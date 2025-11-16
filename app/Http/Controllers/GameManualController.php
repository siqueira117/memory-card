<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameManual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class GameManualController extends Controller
{
    public function store(Request $request)
    {
        Log::info('📖 [MANUAL] Cadastrando manual', [
            'game_id' => $request->manualGame,
            'platform_id' => $request->manualPlatform,
            'language_id' => $request->manualLanguage,
            'user' => Auth::check() ? Auth::user()->email : 'guest'
        ]);
        
        try {
            $validator = Validator::make($request->all(), [
                'manualUrl'         => 'required',
                'manualPlatform'    => 'required',
                'manualLanguage'    => 'required',
                'manualGame'        => 'required'
            ]);
            
            if (!$validator->passes()) {
                Log::warning('⚠️ [MANUAL] Validação falhou', [
                    'game_id' => $request->manualGame,
                    'erros' => $validator->errors()->toArray()
                ]);
                return Redirect::back()->withErrors($validator);
            }
    
            DB::beginTransaction();

            $gameResult = Game::where('game_id', $request->manualGame)->get();
            if (!count($gameResult)) {
                Log::error('❌ [MANUAL] Jogo não encontrado', [
                    'game_id' => $request->manualGame
                ]);
                throw new \Exception("Game não encontrado!");
            }
            
            $game = $gameResult->first();
            Log::info('✅ [MANUAL] Jogo encontrado', [
                'game_id' => $game->game_id,
                'nome' => $game->name
            ]);
    
            $gameModel = GameManual::create([
                'url'           => $request->manualUrl,
                'game_id'       => $request->manualGame,
                'language_id'   => $request->manualLanguage,
                'platform_id'   => $request->manualPlatform
            ]);
    
            if (!$gameModel) throw new \Exception("Não foi possível adicionar o manual!");
    
            DB::commit();

            Log::info('🎉 [MANUAL] Manual cadastrado com sucesso', [
                'manual_id' => $gameModel->id,
                'game_id' => $request->manualGame,
                'game_name' => $game->name,
                'platform_id' => $request->manualPlatform,
                'language_id' => $request->manualLanguage
            ]);

            $request->session()->flash('successMsg',"Manual adicionado com sucesso!"); 
            return Redirect::back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ [MANUAL] Erro ao cadastrar manual', [
                'game_id' => $request->manualGame,
                'erro' => $e->getMessage(),
                'linha' => $e->getLine()
            ]);
            $request->session()->flash('errorMsg', $e->getMessage()); 
            return Redirect::back();
        }
    }
}
