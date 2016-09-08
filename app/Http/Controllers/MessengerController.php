<?php

namespace App\Http\Controllers;

use App\Messenger;
use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;

class MessengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('user_contribute_to_project', $project);
        $messenger = Messenger::pimp()->where('project_id', $project->id)->orderBy('created_at', 'desc')->simplePaginate();
        return response()->json(['messenger' => $messenger]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\MessengerStoreRequest $request)
    {
        $messenger = new Messenger();
        $messenger->message = $request->text;
        $messenger->project_id = $request->project_id;
        $messenger->save();
        return response()->json(['messenger' => $messenger]);
    }
}
