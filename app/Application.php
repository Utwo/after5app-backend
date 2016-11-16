<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use ModelTrait, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'answers'];

    protected $casts = [
        'answers' => 'json',
        'accepted' => 'boolean',
        'user_id' => 'integer',
        'position_id' => 'integer'
    ];

    protected $dates = ['deleted_at'];

    protected $withable = ['user', 'position', 'position.project', 'position.skill'];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Position(){
        return $this->belongsTo(Position::class);
    }
}
