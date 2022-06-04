<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request){
});


App::after(function($request, $response)
{
    // HTML Minification
    if(App::Environment() != 'local')
    {
        if($response instanceof Illuminate\Http\Response)
        {
            $output = $response->getOriginalContent();
            
            $search = array(
		    '/\>[^\S ]+/s', 
		    '/[^\S ]+\</s', 
		     '/(\s)+/s', // shorten multiple whitespace sequences
		  '#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s' //leave CDATA alone
		    );
		    $replace = array(
		     '>',
		     '<',
		     '\\1',
		    "//&lt;![CDATA[\n".'\1'."\n//]]>"
		    );
		    $blocks = preg_split('/(<\/?head[^>]*>)/', $output, null, PREG_SPLIT_DELIM_CAPTURE);
		    $output="";
		    foreach($blocks as $i=>$block){
		        
		        if($i%4!=0){
		            $output.=$block;
		        }else{
		            $output.= preg_replace($search, $replace, $block);
		        }
		    }
			
            $response->setContent($output);
        }
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('owner-auth', function()
{
	if (!is_owner()) return Redirect::route('adminlogin');
});


Route::filter('admin-user', function()
{
	if (Auth::check()){
		
			
		return Redirect::to('/');

	}elseif (Session::has('adminid')) {
		
		if (Session::get('admincountry') == 0) {
			return Redirect::route('ownerhome');
		}
		
		
	}else {			
		return Redirect::route('adminlogin');
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});