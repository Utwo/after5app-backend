<?php

namespace App\Http\Controllers;

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function must_delete($id){
        $user = User::findOrFail($id);

        $token = JWTAuth::fromUser($user);
        return response()->json(['user' => $user,'jwt-token' => $token]);
    }
}
