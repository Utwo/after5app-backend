<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jedrzej\Pimpable\PimpableTrait;

class Comment extends Model
{
    use PimpableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text'];

    public function setUpdatedAtAttribute($value){}
    public function getUpdaedAt(){ return; }

    protected $withable = ['user'];

    public function Project(){
        return $this->belongsTo(Project::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
