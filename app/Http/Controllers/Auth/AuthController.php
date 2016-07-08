<?php

namespace App\Http\Controllers\Auth;

use App\EmailLogin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|max:255']);
        $email = $request->email;
        User::firstOrCreate(['email' => $email]);
        $emailLogin = EmailLogin::createForEmail($email);

        Mail::queue('emails.email-login', ['token' => $emailLogin->token], function ($m) use ($email) {
            $m->from('noreply@myapp.com', config('app.app_name'));
            $m->to($email)->subject(config('app.app_name') . ' Login');
        });

        return response()->json(['message' => 'Email successfuly send']);
    }

    public function authenticateEmail(Request $request)
    {
        $emailLogin = EmailLogin::validFromToken($request->token);
        $user = User::where('email', $emailLogin->email)->firstOrFail();
        $token = JWTAuth::fromUser($user);
        if ($request->isJson() || $request->ajax()) {
            return response()->json(['user' => $user]);
        }
        return response()->redirectToRoute('home', ['token' => $token]);
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return response()->redirectTo("auth/{$provider}");
        }

        $authUser = $this->findOrCreateUser($provider, $user);
        $token = JWTAuth::fromUser($authUser);
        return response()->redirectToRoute('home', ['token' => $token]);
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($provider, $user)
    {
        $authUser = User::where([$provider . '_id' => $user->id])->orWhere(['email' => $user->getEmail()])->first();
        $authUser->facebook_id = $user->getId();
        $authUser->facebook_token = $user->token;
        $authUser->name = $user->getName();
        $authUser->email = $user->getEmail();
        $authUser->save();

        return $authUser;
    }

}
