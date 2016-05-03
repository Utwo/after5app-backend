<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmailLogin extends Model
{
    public $fillable = ['email', 'token'];

    public function setUpdatedAtAttribute($value){}
    public function getUpdaedAt(){ return; }

    public static function createForEmail($email)
    {
        return self::create([
            'email' => $email,
            'token' => bin2hex(random_bytes(5))
        ]);
    }

    public static function validFromToken($token)
    {
        return self::where('token', $token)
            ->where('created_at', '>', Carbon::parse('-10 minutes'))
            ->firstOrFail();
    }

    public function User()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }
}
