<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_collections';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'collection_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'collection_id',
        'name',
        'slug',
        'user_id',
        'description',
        'is_public',
        'followers_count',
        'games_count',
        'cover_image'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_public' => 'boolean',
        'followers_count' => 'integer',
        'games_count' => 'integer',
    ];

    /**
     * Boot do model para gerar slug automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($collection) {
            if (empty($collection->slug)) {
                $collection->slug = Str::slug($collection->name);
            }
        });
    }

    /**
     * Relacionamento com usuário dono da coleção
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relacionamento com jogos da coleção
     */
    public function games()
    {
        return $this->belongsToMany(Game::class, 'tbl_game_collections', 'collection_id', 'game_id')
                    ->withTimestamps();
    }

    /**
     * Seguidores da coleção
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'tbl_collection_followers', 'collection_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Tags da coleção
     */
    public function tags()
    {
        return $this->belongsToMany(
            CollectionTag::class,
            'collection_tag_pivot',
            'collection_id',
            'tag_id'
        )->withTimestamps();
    }

    /**
     * Verifica se um usuário está seguindo a coleção
     */
    public function isFollowedBy($userId)
    {
        return $this->followers()->where('user_id', $userId)->exists();
    }

    /**
     * Verifica se a coleção pertence ao usuário
     */
    public function belongsToUser($userId)
    {
        return $this->user_id == $userId;
    }

    /**
     * Scope para coleções públicas
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope para coleções de um usuário específico
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Recalcula e atualiza o contador de jogos
     */
    public function updateGamesCount()
    {
        $this->games_count = $this->games()->count();
        $this->save();
        return $this->games_count;
    }

    /**
     * Recalcula e atualiza o contador de seguidores
     */
    public function updateFollowersCount()
    {
        $this->followers_count = $this->followers()->count();
        $this->save();
        return $this->followers_count;
    }
}
