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
}
