<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jedrzej\Pimpable\PimpableTrait;

class Project extends Model
{
    use PimpableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'application_questions', 'status'];

    protected $casts = [
        'application_questions' => 'json',
    ];

    protected $withable = ['comment', 'comment.user', 'favorite', 'position', 'position.skill', 'user'];

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

    public function Position()
    {
        return $this->hasMany(Position::class);
    }
}
