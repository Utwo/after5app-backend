<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'positions', 'application_questions', 'status'];

    protected $casts = [
        'positions' => 'json',
        'application_questions' => 'json',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Favorite()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function Application()
    {
        return $this->hasMany(Application::class);
    }

    public function Comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function Skill()
    {
        return $this->belongsToMany(Skill::class);
    }
}
