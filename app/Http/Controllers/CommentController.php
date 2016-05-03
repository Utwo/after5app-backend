<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CommentStoreRequest $request)
    {
        $comment = new Comment($request->all());
        $comment->user_id = auth()->user()->id;
        $comment->project_id = $request->project_id;
        $comment->save();
        return response()->json(['comment' => $comment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Comment::findOrFail($request->comment)->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
