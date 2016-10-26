<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use ModelTrait, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'website', 'workplace', 'twitter',
    ];

    protected $withable = ['skill', 'project', 'favorite'];

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
        if($this->github_id){
            return "https://avatars.githubusercontent.com/u/{$this->github_id}";
        }
        if ($this->facebook_id) {
            return "http://graph.facebook.com/{$this->facebook_id}/picture";
        }
        return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'facebook_token', 'github_token'
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

    public function Favorite()
    {
        return $this->belongsToMany(Project::class, 'favorites');
    }
}
