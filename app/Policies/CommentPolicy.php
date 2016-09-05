<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user own the comment.
     *
     * @param  App\User  $user
     * @param  App\Comment  $comment
     * @return mixed
     */
    public function user_own_comment(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }
}
