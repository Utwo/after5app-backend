<?php

namespace App;

use App\Events\ProjectDeleting;
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
        'user_id' => 'integer',
    ];

    protected $withable = ['comment', 'comment.user', 'favorite', 'position', 'position.skill', 'position.member', 'user'];

	/**
	 * The event map for the model.
	 *
	 * @var array
	 */
	protected $events = [
		'deleting' => ProjectDeleting::class,
	];

    /**
     * Get all applications for a given project.
     */
    public function Application()
    {
        return $this->hasManyThrough('App\Application', 'App\Position');
    }

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

    public function Asset()
    {
        return $this->hasMany(Asset::class);
    }
}
