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
        $skill = Skill::firstOrCreate(['name' => $request->position_name]);
        $position = new Position($request->all());
        $position->project_id = $request->project_id;
        $position->skill_id = $skill->id;
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
