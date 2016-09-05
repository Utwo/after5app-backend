<?php

namespace App\Policies;

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
}
