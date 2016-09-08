<?php

namespace App\Policies;

use App\Position;
use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user own the project.
     *
     * @param  App\User  $user
     * @param  App\Project  $project
     * @return mixed
     */
    public function user_own_project(User $user, Project $project)
    {
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user own the project.
     *
     * @param  App\User  $user
     * @param  App\Project  $project
     * @return mixed
     */
    public function user_contribute_to_project(User $user, Project $project)
    {
        if($user->id == $project->user_id){
            return true;
        }

        return Position::where('project_id', $project->id)->whereHas('Application', function($query) use ($user){
            return $query->where('user_id', $user->id)->where('accepted', 1);
        })->exists();
    }
}
