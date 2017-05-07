<?php

namespace App;

use App\Events\AssetDeleting;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'extension'];

    protected $hidden = ['path'];

    protected $withable = ['user'];

    protected $casts = [
        'project_id' => 'integer',
        'user_id' => 'integer'
    ];

	/**
	 * The event map for the model.
	 *
	 * @var array
	 */
	protected $events = [
		'deleting' => AssetDeleting::class,
	];

    public function Project(){
        return $this->belongsTo(Project::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
