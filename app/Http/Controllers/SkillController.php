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
        $skill = Skill::pimp()->simplePaginate(config('app.per_page'));
        return response()->json($skill);
    }
}
