<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $application = Application::simplePaginate();
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
        $application->project_id = $request->project_id;
        $application->save();
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
