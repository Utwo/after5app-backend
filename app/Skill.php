<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function User(){
        return $this->belongsToMany(User::class);
    }

    public function Project(){
        return $this->belongsToMany(Project::class);
    }
}
