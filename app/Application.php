<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jedrzej\Pimpable\PimpableTrait;

class Application extends Model
{
    use PimpableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'answers'];

    protected $casts = [
        'answers' => 'json',
    ];

    protected $withable = ['user', 'position', 'position.project', 'position.skill'];

    public function setUpdatedAtAttribute($value){}
    public function getUpdaedAt(){ return; }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Position(){
        return $this->belongsTo(Position::class);
    }
}
