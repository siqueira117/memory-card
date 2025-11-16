<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionFollower extends Model
{
    protected $table = 'tbl_collection_followers';
    protected $primaryKey = 'collection_follower_id';
    
    protected $fillable = [
        'user_id',
        'collection_id'
    ];

    /**
     * Relacionamento com usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relacionamento com coleção
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id', 'collection_id');
    }
}
