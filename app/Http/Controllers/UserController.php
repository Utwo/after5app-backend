<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->check() && ! $request->has('username')){
            $user = User::pimp()->findOrFail(auth()->user()->id);
        }else{
            $user = User::pimp()->where('name', $request->username)->firstOrFail();
        }
        return response()->json(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UserUpdateRequest $request)
    {
        $user = auth()->user();
        $user->update($request->all());
        return response()->json(['user' => $user]);
    }
}
