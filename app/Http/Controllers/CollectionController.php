<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Game;
use App\Models\GameCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    /**
     * Lista todas as coleções públicas e do usuário com pesquisa e filtros
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'public'); // public, my, following
        $search = $request->get('search');
        $tag = $request->get('tag');
        $sort = $request->get('sort', 'popular'); // popular, recent, name, games

        $query = Collection::with('user', 'games', 'tags');

        // Aplicar filtros de visualização
        if ($filter === 'my' && $user) {
            $query->where('user_id', $user->id);
        } elseif ($filter === 'following' && $user) {
            $query->whereIn('collection_id', $user->followingCollections()->pluck('collection_id'));
        } else {
            $query->where('is_public', true);
        }

        // Pesquisa por texto
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('games', function($gameQuery) use ($search) {
                      $gameQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filtrar por tag
        if ($tag) {
            $query->whereHas('tags', function($tagQuery) use ($tag) {
                $tagQuery->where('slug', $tag);
            });
        }

        // Ordenação
        switch ($sort) {
            case 'recent':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'games':
                $query->orderBy('games_count', 'desc');
                break;
            case 'popular':
            default:
                $query->orderBy('followers_count', 'desc');
                break;
        }

        $collections = $query->paginate(12)->appends($request->except('page'));

        // Tags populares para o filtro
        $popularTags = \App\Models\CollectionTag::popular(20)->get();

        return view('collections.index', compact('collections', 'filter', 'search', 'tag', 'sort', 'popularTags'));
    }

    /**
     * Página de exploração de coleções
     */
    public function explore()
    {
        // Coleções em destaque (mais seguidas)
        $featured = Collection::where('is_public', true)
                              ->with('user', 'tags')
                              ->orderBy('followers_count', 'desc')
                              ->take(6)
                              ->get();

        // Coleções populares
        $popular = Collection::where('is_public', true)
                             ->with('user', 'tags')
                             ->where('followers_count', '>', 0)
                             ->orderBy('followers_count', 'desc')
                             ->take(8)
                             ->get();

        // Coleções recentes
        $recent = Collection::where('is_public', true)
                            ->with('user', 'tags')
                            ->orderBy('created_at', 'desc')
                            ->take(8)
                            ->get();

        // Tags populares
        $popularTags = \App\Models\CollectionTag::popular(15)->get();

        // Estatísticas
        $stats = [
            'total_collections' => Collection::where('is_public', true)->count(),
            'total_games' => \DB::table('tbl_game_collections')
                               ->join('tbl_collections', 'tbl_game_collections.collection_id', '=', 'tbl_collections.collection_id')
                               ->where('tbl_collections.is_public', true)
                               ->distinct('tbl_game_collections.game_id')
                               ->count('tbl_game_collections.game_id'),
            'total_users' => Collection::where('is_public', true)->distinct('user_id')->count('user_id'),
        ];

        return view('collections.explore', compact('featured', 'popular', 'recent', 'popularTags', 'stats'));
    }

    /**
     * Exibe detalhes de uma coleção
     */
    public function show($slug)
    {
        $collection = Collection::where('slug', $slug)
                                ->with(['user', 'games.platforms', 'games.genres'])
                                ->firstOrFail();

        // Verificar permissões
        if (!$collection->is_public && (!Auth::check() || $collection->user_id !== Auth::id())) {
            abort(403, 'Esta coleção é privada.');
        }

        $isFollowing = Auth::check() ? $collection->isFollowedBy(Auth::id()) : false;
        $isOwner = Auth::check() ? $collection->belongsToUser(Auth::id()) : false;

        return view('collections.show', compact('collection', 'isFollowing', 'isOwner'));
    }

    /**
     * Formulário para criar nova coleção (redirecionado para index - usar modal)
     */
    public function create()
    {
        return redirect()->route('collections.index')
                        ->with('info', 'Use o botão "Nova Coleção" para criar uma coleção.');
    }

    /**
     * Salva nova coleção
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Dados recebidos para criar coleção:', $request->all());
            
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:150',
                'description' => 'nullable|string|max:1000',
                'is_public' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                \Log::error('Falha na validação:', $validator->errors()->toArray());
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Erro na validação dos dados.',
                        'errors' => $validator->errors()->toArray()
                    ], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $collection = Collection::create([
                'name' => $request->name,
                'description' => $request->description,
                'is_public' => (bool) $request->is_public,
                'user_id' => Auth::id(),
            ]);

            // Processar tags
            if ($request->filled('tags')) {
                $tagNames = array_map('trim', explode(',', $request->tags));
                $tagIds = [];
                
                foreach ($tagNames as $tagName) {
                    if (empty($tagName)) continue;
                    
                    // Criar ou encontrar a tag
                    $tag = \App\Models\CollectionTag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => \Str::slug($tagName)]
                    );
                    
                    $tagIds[] = $tag->tag_id;
                }
                
                // Associar tags à coleção
                if (!empty($tagIds)) {
                    $collection->tags()->attach($tagIds);
                    
                    // Atualizar contadores de uso
                    foreach ($tagIds as $tagId) {
                        \App\Models\CollectionTag::find($tagId)->incrementUsage();
                    }
                }
            }

            \Log::info('Coleção criada com sucesso:', ['collection_id' => $collection->collection_id, 'slug' => $collection->slug]);

            // Se for requisição AJAX, retornar JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Coleção criada com sucesso!',
                    'redirect' => route('collections.show', $collection->slug),
                    'collection' => $collection
                ]);
            }

            // Caso contrário, redirecionar normalmente
            return redirect()->route('collections.show', $collection->slug)
                            ->with('success', 'Coleção criada com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao criar coleção: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao criar coleção: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Erro ao criar coleção.')
                ->withInput();
        }
    }

    /**
     * Formulário para editar coleção
     */
    public function edit($slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();

        // Verificar se é o dono
        if ($collection->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar esta coleção.');
        }

        return view('collections.edit', compact('collection'));
    }

    /**
     * Atualiza coleção
     */
    public function update(Request $request, $slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();

        // Verificar se é o dono
        if ($collection->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para editar esta coleção.');
        }

        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'required|in:0,1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_public' => (bool) $request->is_public,
        ];

        // Upload de imagem
        if ($request->hasFile('cover_image')) {
            // Deletar imagem antiga se existir
            if ($collection->cover_image && Storage::disk('public')->exists($collection->cover_image)) {
                Storage::disk('public')->delete($collection->cover_image);
            }

            $path = $request->file('cover_image')->store('collections', 'public');
            $data['cover_image'] = $path;
        }

        $collection->update($data);

        // Processar tags
        if ($request->has('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                if (empty($tagName)) continue;
                
                // Criar ou encontrar a tag
                $tag = \App\Models\CollectionTag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => \Str::slug($tagName)]
                );
                
                $tagIds[] = $tag->tag_id;
            }
            
            // Decrementar contadores das tags antigas
            foreach ($collection->tags as $oldTag) {
                if (!in_array($oldTag->tag_id, $tagIds)) {
                    $oldTag->decrementUsage();
                }
            }
            
            // Sincronizar tags (remove antigas e adiciona novas)
            $collection->tags()->sync($tagIds);
            
            // Incrementar contadores das tags novas
            foreach ($tagIds as $tagId) {
                $tag = \App\Models\CollectionTag::find($tagId);
                if (!$collection->tags()->where('tag_id', $tagId)->exists()) {
                    $tag->incrementUsage();
                }
            }
        }

        return redirect()->route('collections.show', $collection->slug)
                        ->with('success', 'Coleção atualizada com sucesso!');
    }

    /**
     * Deleta coleção
     */
    public function destroy($slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();

        // Verificar se é o dono
        if ($collection->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para deletar esta coleção.');
        }

        // Decrementar contadores das tags
        foreach ($collection->tags as $tag) {
            $tag->decrementUsage();
        }

        // Deletar imagem da coleção se existir
        if ($collection->cover_image && Storage::disk('public')->exists($collection->cover_image)) {
            Storage::disk('public')->delete($collection->cover_image);
        }

        $collection->delete();

        return redirect()->route('collections.index')
                        ->with('success', 'Coleção deletada com sucesso!');
    }

    /**
     * Gera capa automaticamente baseada no primeiro jogo
     */
    public function autoGenerateCover($slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();

        // Verificar se é o dono
        if ($collection->user_id !== Auth::id()) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        $firstGame = $collection->games()->first();

        if (!$firstGame || !$firstGame->coverUrl) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum jogo com capa encontrado nesta coleção.'
            ], 400);
        }

        // Deletar imagem antiga se existir
        if ($collection->cover_image && Storage::disk('public')->exists($collection->cover_image)) {
            Storage::disk('public')->delete($collection->cover_image);
        }

        // Salvar a URL da capa do jogo
        $collection->cover_image = $firstGame->coverUrl;
        $collection->save();

        return response()->json([
            'success' => true,
            'message' => 'Capa gerada automaticamente!',
            'cover_url' => $firstGame->coverUrl
        ]);
    }

    /**
     * Remove a capa da coleção
     */
    public function removeCover($slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();

        // Verificar se é o dono
        if ($collection->user_id !== Auth::id()) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        // Deletar imagem se for upload local
        if ($collection->cover_image && Storage::disk('public')->exists($collection->cover_image)) {
            Storage::disk('public')->delete($collection->cover_image);
        }

        $collection->cover_image = null;
        $collection->save();

        return response()->json([
            'success' => true,
            'message' => 'Capa removida com sucesso!'
        ]);
    }

    /**
     * Adiciona jogo à coleção
     */
    public function addGame(Request $request)
    {
        $request->validate([
            'collection_id' => 'required|exists:tbl_collections,collection_id',
            'game_id' => 'required|exists:tbl_games,game_id',
        ]);

        $collection = Collection::findOrFail($request->collection_id);

        // Verificar se é o dono
        if ($collection->user_id !== Auth::id()) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        // Verificar se já existe
        if ($collection->games()->where('game_id', $request->game_id)->exists()) {
            return response()->json(['error' => 'Jogo já está na coleção'], 400);
        }

        $collection->games()->attach($request->game_id);
        $collection->increment('games_count');

        return response()->json(['success' => true, 'message' => 'Jogo adicionado à coleção!']);
    }

    /**
     * Remove jogo da coleção
     */
    public function removeGame(Request $request)
    {
        $request->validate([
            'collection_id' => 'required|exists:tbl_collections,collection_id',
            'game_id' => 'required|exists:tbl_games,game_id',
        ]);

        $collection = Collection::findOrFail($request->collection_id);

        // Verificar se é o dono
        if ($collection->user_id !== Auth::id()) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        $collection->games()->detach($request->game_id);
        $collection->decrement('games_count');

        return response()->json(['success' => true, 'message' => 'Jogo removido da coleção!']);
    }

    /**
     * Seguir/Deixar de seguir coleção
     */
    public function toggleFollow(Request $request, $slug)
    {
        $collection = Collection::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Não pode seguir própria coleção
        if ($collection->user_id === $user->id) {
            return response()->json(['error' => 'Você não pode seguir sua própria coleção'], 400);
        }

        $isFollowing = $collection->isFollowedBy($user->id);

        if ($isFollowing) {
            // Deixar de seguir
            $collection->followers()->detach($user->id);
            $collection->decrement('followers_count');
            $message = 'Você deixou de seguir esta coleção.';
            $action = 'unfollowed';
        } else {
            // Seguir
            $collection->followers()->attach($user->id);
            $collection->increment('followers_count');
            $message = 'Você está seguindo esta coleção!';
            $action = 'followed';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'followers_count' => $collection->followers_count
        ]);
    }

    /**
     * Exportar coleção para JSON
     */
    public function exportJson($slug)
    {
        $collection = Collection::where('slug', $slug)
                                ->with('games')
                                ->firstOrFail();

        // Verificar permissões
        if (!$collection->is_public && (!Auth::check() || $collection->user_id !== Auth::id())) {
            abort(403, 'Sem permissão para exportar esta coleção.');
        }

        $data = [
            'name' => $collection->name,
            'description' => $collection->description,
            'created_at' => $collection->created_at->toDateString(),
            'games' => $collection->games->map(function ($game) {
                return [
                    'name' => $game->name,
                    'slug' => $game->slug,
                    'release_date' => $game->first_release_date,
                ];
            })
        ];

        $fileName = Str::slug($collection->name) . '-' . date('Y-m-d') . '.json';

        return response()->json($data, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Exportar coleção para CSV
     */
    public function exportCsv($slug)
    {
        $collection = Collection::where('slug', $slug)
                                ->with('games')
                                ->firstOrFail();

        // Verificar permissões
        if (!$collection->is_public && (!Auth::check() || $collection->user_id !== Auth::id())) {
            abort(403, 'Sem permissão para exportar esta coleção.');
        }

        $fileName = Str::slug($collection->name) . '-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($collection) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nome do Jogo', 'Slug', 'Data de Lançamento']);

            foreach ($collection->games as $game) {
                fputcsv($file, [
                    $game->name,
                    $game->slug,
                    $game->first_release_date,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Modal para adicionar jogo à coleção
     */
    public function addGameModal($gameId)
    {
        $game = Game::findOrFail($gameId);
        $collections = Auth::user()->collections;

        return view('collections.add-game-modal', compact('game', 'collections'));
    }

    /**
     * Retorna coleções do usuário em JSON (para modal)
     */
    public function getUserCollections()
    {
        $collections = Auth::user()->collections()
            ->select('collection_id', 'name', 'slug', 'games_count')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'collections' => $collections
        ]);
    }
}
