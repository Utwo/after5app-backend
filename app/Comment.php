<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text'];

    public function setUpdatedAtAttribute($value){}
    public function getUpdaedAt(){ return; }

    public function Project(){
        return $this->belongsTo(Project::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
