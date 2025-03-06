<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_franchises';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'franchise_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['franchise_id', 'name', 'slug'];
}
