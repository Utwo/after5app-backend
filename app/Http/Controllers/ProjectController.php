<?php

namespace App\Http\Controllers;

use App\Position;
use App\Project;
use App\Skill;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->exists('recommended') && auth()->check()){
            $user_skill = auth()->user()->Skill->pluck(['id']);
            $project = Project::withCount('Favorite', 'Comment')->pimp()->whereHas('Position', function($query) use ($user_skill){
                return $query->whereIn('skill_id', $user_skill);
            })->orderBy('created_at', 'desc')->simplePaginate();
        }else{
            $project = Project::withCount('Favorite', 'Comment')->pimp()->simplePaginate();
        }

        return response()->json($project);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ProjectStoreRequest $request)
    {
        //$request->merge(['positions' => $request->positions, 'application_questions' => $request->application_questions]);
        $project = new Project($request->all());
        $project->user_id = auth()->user()->id;
        $project->save();
        $position_created = [];
        foreach ($request->position as $position){
            $position_created[] = $this->store_position($position, $project);
        }
        $project->position = $position_created;
        return response()->json(['project' => $project]);
    }

    public function store_position($position_request, $project)
    {
        $skill = Skill::firstOrCreate(['name' => Skill::generate_name($position_request['name'])]);
        $check_unique = Position::where('project_id', $project->id)->where('skill_id', $skill->id)->exists();
        if($check_unique){
            return abort(400, 'A position with that position name already exist.');
        }
        $position = new Position($position_request);
        $position->skill_id = $skill->id;
        $position->project_id = $project->id;
        $position->save();
        return $position;
    }

    public function favorite(Request $request)
    {
        $project = Project::findOrFail($request->project);
        $result = $project->favorite()->toggle(auth()->user());
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\ProjectUpdateRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return response()->json(['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $project = Project::findOrFail($request->project);
        $this->authorize('user_own_project', $project);
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
