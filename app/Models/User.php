<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'tbl_activity_user', 'user_id', 'activity_id')->withPivot('read_at');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    public function userGames()
    {
        return $this->hasMany(UserGame::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    /**
     * Coleções criadas pelo usuário
     */
    public function collections()
    {
        return $this->hasMany(Collection::class, 'user_id', 'id');
    }

    /**
     * Coleções que o usuário está seguindo
     */
    public function followingCollections()
    {
        return $this->belongsToMany(Collection::class, 'tbl_collection_followers', 'user_id', 'collection_id')
                    ->withTimestamps();
    }

    /**
     * Tags personalizadas do usuário
     */
    public function gameTags()
    {
        return $this->hasMany(GameTag::class, 'user_id', 'id');
    }

    /**
     * Notas privadas do usuário
     */
    public function gameNotes()
    {
        return $this->hasMany(GameNote::class, 'user_id', 'id');
    }

    /**
     * Total de reviews do usuário
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Média de avaliação do usuário
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    /**
     * Total de coleções criadas
     */
    public function getTotalCollectionsAttribute()
    {
        return $this->collections()->count();
    }
}
