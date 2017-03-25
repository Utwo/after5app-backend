<?php

namespace App\Http\Controllers\Auth;

use App\EmailLogin;
use App\Notifications\EmailLoginNotification;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|max:255']);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = new User();
            $user->email = $email;
            $user->name = strstr($email, '@', true);;
            $user->save();
        }

        $email_login = EmailLogin::createForEmail($email);
        $user->notify(new EmailLoginNotification($email_login->token));

        return response()->json(['message' => 'Email successfuly send']);
    }

    public function authenticateEmail(Request $request)
    {
        $emailLogin = EmailLogin::validFromToken($request->token);
        $user = User::where('email', $emailLogin->email)->firstOrFail();
        $token = auth()->login($user);
        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }

        $authUser = $this->findOrCreateUser($provider, $user);
        $token = auth()->login($authUser);
        return response()->json(['user' => $authUser, 'token' => $token]);
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($provider, $user)
    {
        $authUser = User::where($provider . '_id', $user->id)->orWhere('email', $user->getEmail())->first();
        if ($authUser == null) {
            $authUser = new User();
        }

        $provider_id = $provider . '_id';
        $provider_token = $provider . '_token';

        $social = $authUser->social === null ? [] : $authUser->social;
        if ($user->getNickname() != null) {
            $social[$provider] = $user->getNickname();
            $authUser->social = $social;
        }

        $authUser->$provider_id = $user->getId();
        $authUser->$provider_token = $user->token;
        $authUser->name = $user->getName();
        $authUser->email = $user->getEmail();
        $authUser->save();

        return $authUser;
    }

}
