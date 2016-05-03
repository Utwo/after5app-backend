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
        'name', 'email', 'website', 'workplace', 'twitter',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['picture'];

    /**
     * Get the user's profile picture.
     *
     * @return string
     */
    public function getPictureAttribute()
    {
        if ($this->facebook_id != null) {
            return "http://graph.facebook.com/{$this->facebook_id}/picture?type=square";
        }
        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email)));
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Skill()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function Comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function Application()
    {
        return $this->hasMany(Application::class);
    }

    public function Project()
    {
        return $this->hasMany(Project::class);
    }
}
