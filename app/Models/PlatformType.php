<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_platform_types';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'platform_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['platform_type_id', 'name'];

    public function platforms() 
    {
        return $this->hasMany(Platform::class);
    }
}
