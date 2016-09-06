<?php

namespace App\Http\Controllers;

use App\Position;
use App\Skill;
use Illuminate\Http\Request;

use App\Http\Requests;

class PositionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PositionStoreRequest $request)
    {
        $skill = Skill::firstOrCreate(['name' => Skill::generate_name($request->position_name)]);
        $check_unique = Position::where('project_id', $request->project_id)->where('skill_id', $skill->id)->exists();
        if($check_unique){
            return abort(400, 'A position with that position name already exist.');
        }
        $position = new Position($request->all());
        $position->skill_id = $skill->id;
        $position->project_id = $request->project_id;
        $position->save();
        return response()->json(['position' => $position]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PositionUpdateRequest $request, $id)
    {
        $position = Position::findOrFail($id);
        $position->update($request->all());
        return response()->json(['position' => $position]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $position = Position::findOrFail($request->position);
        $this->authorize('user_own_project', $position->Project);
        $position->delete();
        return response()->json(['message' => 'Position deleted successfully']);
    }
}
