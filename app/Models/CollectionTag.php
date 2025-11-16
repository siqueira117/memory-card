<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CollectionTag extends Model
{
    protected $table = 'collection_tags';
    protected $primaryKey = 'tag_id';

    protected $fillable = [
        'name',
        'slug',
        'usage_count'
    ];

    protected $casts = [
        'usage_count' => 'integer',
    ];

    /**
     * Boot do model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    /**
     * Coleções que usam esta tag
     */
    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            'collection_tag_pivot',
            'tag_id',
            'collection_id'
        )->withTimestamps();
    }

    /**
     * Incrementa o contador de uso
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Decrementa o contador de uso
     */
    public function decrementUsage()
    {
        $this->decrement('usage_count');
    }

    /**
     * Scope para tags populares
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }
}

