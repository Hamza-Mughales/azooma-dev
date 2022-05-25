<?php
class PrivacyController extends BaseController
{

        public function index()
        {
                $lang = Config::get('app.locale');
                $data['lang'] = $lang;
                $data['meta'] = array(
                        'title' => Lang::get('messages.privacy_policy'),
                        'metadesc' => Lang::get('messages.privacy_policy'),
                );
                return View::make('privacy', $data);
        }

        public function test()
        {

                $code = Input::get('oauth_token');
                $oauth_verifier = Input::get('oauth_verifier');

                $twitterService = Artdarek\OAuth\Facade\OAuth::consumer('Twitter');

                // if code is provided get user data and sign in
                if (!empty($code)) {

                        $token = $twitterService->getStorage()->retrieveAccessToken('Twitter');

                        // This was a callback request from google, get the token
                        $twitterService->requestAccessToken($code, $oauth_verifier, $token->getRequestTokenSecret());

                        // Send a request with it
                        $result = json_decode($twitterService->request('account/verify_credentials.json'));

                        // try to login

                        // get user by twitter_id
                        //   $user = User::where( [ 'twitter_id' => $result->id ] )->first();


                        // build message with some of the resultant data
                        $message_success = 'Your unique twitter user id is: ' . $result->id . ' and your name is ' . $result->name;
                        $message_notice = 'Account Created.';

                        // redirect to game page

                }
                // if not ask for permission first
                else {

                        // extra request needed for oauth1 to request a request token :-)
                        $token = $twitterService->requestRequestToken();
                        $url = $twitterService->getAuthorizationUri(['oauth_token' => $token->getRequestToken()]);

                        // return to twitter login url
                        return Response::make()->header('Location', (string)$url);
                }
        }
}
