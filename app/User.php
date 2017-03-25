<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements AuthenticatableUserContract
{
    use ModelTrait, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'city', 'website', 'workplace', 'twitter', 'hobbies', 'social', 'notify_email'
    ];

    protected $withable = ['skill', 'project', 'favorite', 'position', 'position.project'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['picture'];

    protected $casts = [
        'hobbies' => 'json',
        'social' => 'json',
        'notify_email' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'facebook_token', 'github_token'
    ];

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Eloquent model method
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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
     * Scope a query to only include members of a project.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $project_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMembersOfProject($query, $project_id)
    {
        return $query->whereHas('Application', function ($query) use ($project_id) {
            $query->where('accepted', 1)->whereHas('Position', function ($query) use ($project_id) {
                $query->where('project_id', $project_id);
            });
        });
    }

    public function Skill()
    {
        return $this->belongsToMany(Skill::class)->withPivot('skill_level');
    }

    public function Comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function Application()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get all positions of a user.
     */
    public function Position()
    {
        return $this->belongsToMany('App\Position', 'applications')->where('accepted', true);
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
