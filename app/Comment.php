<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use ModelTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text'];

    public function setUpdatedAt($value){}
    public function getUpdatedAtColumn(){ return; }

    protected $withable = ['user'];

    public function Project(){
        return $this->belongsTo(Project::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
