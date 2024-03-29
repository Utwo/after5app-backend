<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    use ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message'];

    protected $primaryKey = null;

    public $incrementing = false;

    protected $casts = [
        'message' => 'json',
        'project_id' => 'integer'
    ];

    protected $withable = [''];

    public function setUpdatedAt($value){}
    public function getUpdatedAtColumn(){ return; }

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = json_encode(['user_id' => auth()->user()->id, 'user_name' => auth()->user()->name, 'text' => $value]);
    }

    public function Project()
    {
        return $this->belongsTo(Project::class);
    }
}
