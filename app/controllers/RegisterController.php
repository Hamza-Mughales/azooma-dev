<?php

class RegisterController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Default Register Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/register', 'RegisterController@showWelcome');
	|
	*/

	public function index()	{
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		$data['meta']=array(
			'title'=>Lang::get('messages.register'),
            'metadesc'=>Lang::get('messages.register'),
		);

		return View::make('register',$data);
	}

}