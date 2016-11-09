<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use ModelTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'application_questions', 'status'];

    protected $casts = [
        'application_questions' => 'json',
        'status' => 'boolean',
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

    public function Comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function Position()
    {
        return $this->hasMany(Position::class);
    }

    public function Messenger()
    {
        return $this->hasMany(Messenger::class);
    }
}
