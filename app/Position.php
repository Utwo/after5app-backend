<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'status'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function Project()
    {
        return $this->belongsTo(Project::class);
    }

    public function Skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
