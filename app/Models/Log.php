<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_logs';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'log_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['description', 'model_type', 'model_id'];
}
