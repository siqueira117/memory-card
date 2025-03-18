<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_activities';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'activity_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['description', 'model_type', 'model_id', 'model_uri'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('read_at');
    }
}
