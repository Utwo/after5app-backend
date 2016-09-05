<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'answers'];

    protected $casts = [
        'answers' => 'json',
    ];

    public function setUpdatedAtAttribute($value){}
    public function getUpdaedAt(){ return; }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Position(){
        return $this->belongsTo(Position::class);
    }
}
