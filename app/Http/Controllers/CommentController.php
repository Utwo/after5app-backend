<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notifications\AddCommentNotification;
use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comment = Comment::pimp()->where('project_id', $request->project)->simplePaginate(config('app.per_page'));
        return response()->json($comment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CommentStoreRequest $request)
    {
        $comment = new Comment($request->all());
        $comment->user_id = auth()->user()->id;
        $comment->project_id = $request->project_id;
        $comment->save();

        $project = $comment->Project;
        if (auth()->user()->id != $project->user_id) {
            $project->User->notify(new AddCommentNotification($project, auth()->user()));
        }
        unset($comment['Project']);

        return response()->json(['comment' => $comment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $comment = Comment::findOrFail($request->comment);
        $this->authorize('user_own_comment', $comment);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
