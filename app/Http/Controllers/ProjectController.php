<?php

namespace App\Http\Controllers;

use App\Position;
use App\Project;
use App\Skill;
use App\User;
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
        if ($request->exists('recommended') && auth()->check()) {
            $user_skill = auth()->user()->Skill->pluck(['id']);
            $project = Project::withCount('Favorite', 'Comment')->pimp()->whereHas('Position', function ($query) use ($user_skill) {
                return $query->whereIn('skill_id', $user_skill);
            })->orderBy('created_at', 'desc')->simplePaginate(config('app.per_page'));
        } else {
            $project = Project::withCount('Favorite', 'Comment')->pimp()->simplePaginate(config('app.per_page'));
        }

        return response()->json($project);
    }

    /**
     * Display a listing of the members of a project.
     *
     * @return \Illuminate\Http\Response
     */
    public function members(Request $request)
    {
        $members = User::membersOfProject($request->project)->get();
        return response()->json($members);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ProjectStoreRequest $request)
    {
        $project = new Project($request->all());
        $project->user_id = auth()->user()->id;
        $project->save();

        $position_created = [];
        $position_controller = new PositionController();
        foreach ($request->position as $position) {
            $position_created[] = $position_controller->store_position($position, $project->id);
        }
        $project->position = $position_created;

        return response()->json(['project' => $project]);
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
