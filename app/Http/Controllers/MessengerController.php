<?php

namespace App\Http\Controllers;

use App\Messenger;
use App\Notifications\NewMessageNotification;
use App\Project;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Notification;

class MessengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $project_id
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('user_contribute_to_project', $project);
        $messenger = Messenger::pimp()->where('project_id', $project->id)->simplePaginate(config('app.per_page'));
        return response()->json($messenger);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\MessengerStoreRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\MessengerStoreRequest $request)
    {
        $messenger = new Messenger();
        $messenger->message = $request->text;
        $messenger->project_id = $request->project_id;
        $messenger->save();

        $project = $messenger->Project;
        $users = User::where('id', '<>', auth()->user()->id)->membersOfProject($project->id);
        if(auth()->user()->id != $project->user_id){
            $users->orWhere('id', $project->user_id);
        }
        Notification::send($users->get(), new NewMessageNotification($project, auth()->user()));
        unset($messenger['Project']);

        return response()->json(['messenger' => $messenger]);
    }
}
