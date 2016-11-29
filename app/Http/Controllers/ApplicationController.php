<?php

namespace App\Http\Controllers;

use App\Application;
use App\Notifications\AcceptApplicationNotification;
use App\Notifications\AddApplicationNotification;
use App\Notifications\DeclineApplicationNotification;
use App\Position;
use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource for a specific position.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_project(Request $request)
    {
        $project = Project::findOrFail($request->project);
        $this->authorize('user_own_project', $project);
        $application = Application::pimp()->whereHas('Position.Project', function ($query) use ($project) {
            return $query->where('id', $project->id);
        })->get();
        return response()->json($application);
    }

    /**
     * Display a listing of the resource for a specific user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_user()
    {
        $application = Application::pimp()->where('user_id', auth()->user()->id)->get();
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

        $project = $application->Position->Project;
        $project->User->notify(new AddApplicationNotification(auth()->user(), $project));
        unset($application['Position']);

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
        $application = Application::findOrFail($id);
        $position = $application->Position;
        $project = $position->Project;
        $this->authorize('user_own_project', $project);

        //cand accept aplicatie schimba statusul pozitiei ca fiind ocupata
        $position->status = 0;
        $position->save();

        $application->accepted = 1;
        $application->save();
        $application->User->notify(new AcceptApplicationNotification($project));

        unset($application['User'], $application['Position']);
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
        $position = $application->Position;
        $project = $position->Project;
        if (Gate::denies('user_own_application', $application) && Gate::denies('user_own_project', $project)) {
            abort(403, 'This action is unauthorized.');
        }
        if ($application->accepted) {
            //daca stergem un membru, facem statusul la positie inapoi la unu
            $position->status = 1;
            $position->save();
        }
        if (auth()->user()->id != $application->user_id) {
            //trimitem notificare doar daca aplicatia este stearsa de altcineva decat user-ul apartinator
            $application->User->notify(new DeclineApplicationNotification($project));
        }
        $application->delete();
        return response()->json(['message' => 'Application deleted successfully']);
    }
}
