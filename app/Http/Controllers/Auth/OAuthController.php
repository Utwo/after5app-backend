<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Facebook\FacebookSession;
use Facebook\Facebook;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

class OAuthController extends Controller
{
    private $fb;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => config('social_oauth.facebook_id'),
            'app_secret' => config('social_oauth.facebook_secret'),
            'default_graph_version' => 'v2.6',
        ]);
    }

    public function facebook_login()
    {
        $helper = $this->fb->getJavaScriptHelper();

        try {
            $accessToken = $helper->getAccessToken();
            $this->fb->setDefaultAccessToken($accessToken->getValue());
            $oAuth2Client = $this->fb->getOAuth2Client();

            // Exchanges a short-lived access token for a long-lived one
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken->getValue());

            $response = $this->fb->get('/me?fields=email,id,name');
            $userNode = $response->getGraphUser();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return response()->json(['error' => $e->getMessage()]);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return response()->json(['error' => $e->getMessage()]);
        }

        if (!isset($accessToken)) {
            return response()->json(['error' => 'No cookie set or no OAuth data could be obtained from cookie.']);
        }

        $user = User::firstOrCreate([
            'facebook_id' => $userNode->getId(),
        ]);
        $user->facebook_id = $userNode->getId();
        $user->facebook_token = $longLivedAccessToken;
        $user->update([
            'username' => $userNode->getName(),
            'email' => $userNode->getEmail(),
        ]);

        return response()->json($user);
    }
}