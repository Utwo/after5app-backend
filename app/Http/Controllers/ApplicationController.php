<?php

namespace App\Http\Controllers;

use App\Application;
use App\Position;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource for a specific position.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_position(Request $request)
    {
        $project = Position::findOrFail($request->position)->Project;
        $this->authorize('user_own_project', $project);
        $application = Application::pimp()->where('position_id', $request->position)->simplePaginate();
        return response()->json($application);
    }

    /**
     * Display a listing of the resource for a specific user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_user()
    {
        $application = Application::pimp()->where('user_id', auth()->user()->id)->simplePaginate();
        return response()->json($application);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ApplicationStoreRequest $request)
    {
        $application = new Application($request->all());
        $application->user_id = auth()->user()->id;
        $application->position_id = $request->position_id;
        $application->save();
        return response()->json(['application' => $application]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['accepted' => 'required|boolean']);
        $application = Application::findOrFail($id);
        $project = $application->Position->Project;
        $this->authorize('user_own_project', $project);
        $application->update(['accepted' => $request->accepted]);
        return response()->json(['application' => $application]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $application = Application::findOrFail($request->application);
        $this->authorize('user_own_application', $application);
        $application->delete();
        return response()->json(['message' => 'Application deleted successfully']);
    }
}
