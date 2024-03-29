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

    protected $casts = [
        'status' => 'boolean',
        'project_id' => 'integer',
        'skill_id' => 'integer'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get all members for the project.
     */
    public function Member()
    {
        return $this->belongsToMany('App\User', 'applications')->where('accepted', true);
    }

    public function Project()
    {
        return $this->belongsTo(Project::class);
    }

    public function Skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function Application()
    {
        return $this->hasMany(Application::class);
    }
}
