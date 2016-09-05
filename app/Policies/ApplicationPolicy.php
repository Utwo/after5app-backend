<?php

namespace App\Policies;

use App\User;
use App\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the application.
     *
     * @param  App\User  $user
     * @param  App\Application  $application
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        //
    }

    /**
     * Determine whether the user own the application.
     *
     * @param  App\User  $user
     * @param  App\Application  $application
     * @return mixed
     */
    public function user_own_application(User $user, Application $application)
    {
        return $user->id == $application->user_id;
    }

}
