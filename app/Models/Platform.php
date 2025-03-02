<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_platforms';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'platform_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['platform_id', 'name', 'slug', 'generation', 'abbreviation', 'alternative_name', 'summary', 'platform_type_id'];

    public function platformType() 
    {
        return $this->hasOne(PlatformType::class);
    }
}
