<?php

namespace App\Http\Controllers;

use App\Skill;
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
    public function index($user = null)
    {
        if (auth()->check() && !$user) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = $user;
        }
        $user = User::pimp()->findOrFail($user_id);
        return response()->json($user);
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
        $skills = [];
        foreach ($request->skill as $request_skill) {
            $skills[] = Skill::firstOrCreate(['name' => Skill::generate_name($request_skill)])->id;
        }

        $user->skill()->sync($skills);
        $user->update($request->all());
        return response()->json(['user' => $user]);
    }
}
