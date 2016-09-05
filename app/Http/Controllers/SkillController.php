<?php

namespace App\Http\Controllers;

use App\Skill;
use Illuminate\Http\Request;

use App\Http\Requests;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skill = Skill::all();
        return response()->json($skill);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SkillStoreRequest $request)
    {
        $skill = Skill::create($request->all());
        return response()->json(['skill' => $skill]);
    }
}
