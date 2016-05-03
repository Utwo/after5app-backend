<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Jedrzej\Pimpable\PimpableTrait;

class User extends Authenticatable
{
    use PimpableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'website', 'workplace', 'twitter',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Skill(){
        return $this->belongsToMany(Skill::class);
    }

    public function Comment(){
        return $this->hasMany(Comment::class);
    }

    public function Application(){
        return $this->hasMany(Application::class);
    }

    public function Project(){
        return $this->hasMany(Project::class);
    }
}
