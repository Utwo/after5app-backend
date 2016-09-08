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

    protected $primaryKey = '';

    public $incrementing = false;

    protected $casts = [
        'message' => 'json',
    ];

    protected $withable = [''];

    public function setUpdatedAtAttribute($value){}
    public function getUpdaedAt(){ return; }

    public function Project()
    {
        return $this->belongsTo(Project::class);
    }
}
