<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jedrzej\Pimpable\PimpableTrait;

class Skill extends Model
{
    use PimpableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $withable = ['position', 'position.project', 'position.project.user'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function generate_name($value)
    {
        //TODO sa pun sau sa nu pun str_slug?
        //return str_slug(strtolower($value), '-');
        return strtolower($value);
    }

    /**
     * Set the name attribute.
     *
     * @param  string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        //$this->attributes['name'] = str_slug(strtolower($value), '-');
        $this->attributes['name'] = strtolower($value);
    }

    public function User()
    {
        return $this->belongsToMany(User::class);
    }

    public function Position()
    {
        return $this->hasMany(Position::class);
    }
}
