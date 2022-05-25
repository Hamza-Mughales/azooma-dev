<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|

 Default -> shows home page
 `ar` - arabic
 `sa,lb` - Lists all cities in saudi and lebanon
`jeddah,riyadh` - 
*/

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('ar', 'HomeController@index');
Route::get('azoomasearch/', 'NewSearchController@index');
Route::get('/register', array('as' => 'register', 'uses' => 'RegisterController@index'));
$languages = array('ar');
$countryurl = $arg1 = Request::segment(1);
if (in_array($arg1, array('sa', 'lb'))) {
    Route::group(array('prefix' => $arg1), function () use ($countryurl) {
        $arg2 = Request::segment(2);
        $langstring = "";
        if ($arg2 == "ar") {
            $locale = "ar";
            $langstring = "ar/";
            $arg2 = Request::segment(3);
        } else {
            $locale = null;
        }
        Route::group(array('prefix' => $locale), function ()  use ($arg2, $langstring, $countryurl) {
            $vars = array('', 'home-delivery', 'catering', 'finedining', 'hotels', 'shisha', 'grprest', 'features', 'categories', 'offers', 'most-liked', 'known-for', 'cuisine', 'sufrati-favorites', 'sponsors', 'menu', 'new', 'activity', 'trending', 'gallery', 'food', 'activity', 'suggest', 'advance-search', 'register', 'login', 'facebooklogin', 'search', 'subscription', 'suggest');
            if (in_array($arg2, $vars)) {
                Route::get($arg2, function () use ($langstring) {
                    return Redirect::to($langstring . '', 301);
                });
                $arg3 = Request::segment(3);
                if ($arg2 == "ar") {
                    $arg3 = Request::segment(4);
                }
                if ($arg3 != "") {
                    $vars = array('home-delivery', 'catering', 'finedining', 'hotels', 'shisha', 'offers', 'most-liked', 'menu', 'gallery', 'food');
                    if (in_array($arg2, $vars)) {
                        $citiesq = DB::connection('new-sufrati')->select('select city_ID,seo_url FROM city_list WHERE city_Status=1');
                        $sufraticities = $scity = array();
                        if (count($citiesq) > 0) {
                            foreach ($citiesq as $city) {
                                $sufraticities[] = $city->seo_url;
                                $scity[$city->seo_url] = $city->city_ID;
                            }
                        }
                        if (in_array($arg3, $sufraticities)) {
                            Route::get('home-delivery/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/home-delivery', 301);
                            });
                            Route::get('finedining/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/fine-dining', 301);
                            });
                            Route::get('offers/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/offers', 301);
                            });
                            Route::get('hotels/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/hotels', 301);
                            });
                            Route::get('catering/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg2 . '/catering', 301);
                            });
                            Route::get('sufrati-favorites/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/recommended', 301);
                            });
                            Route::get('cuisines/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/cuisines', 301);
                            });
                            Route::get('shisha/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/sheesha', 301);
                            });
                            Route::get('gallery/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3 . '/gallery', 301);
                            });
                            Route::get('food/' . $arg3, function () use ($arg3, $langstring) {
                                return Redirect::to($langstring . $arg3, 301);
                            });
                        }
                    }
                }
            } else {
                Route::get('blog/{any?}', function () use ($langstring) {
                    return Redirect::to($langstring . 'blog', 301);
                });
                Route::get('recipe/{any?}', function () use ($langstring) {
                    return Redirect::to($langstring . 'recipes', 301);
                });
                Route::get('contact', function () use ($langstring) {
                    return Redirect::to($langstring . 'contact-us', 301);
                });
                Route::get('search/{any?}', function () use ($langstring) {
                    return Redirect::to($langstring . '', 301);
                });
                Route::get('user/{id}', function ($id) use ($langstring) {
                    return Redirect::to($langstring . 'user/' . $id, 301);
                });
                Route::get('rest/{url}/{any?}', function ($url) use ($countryurl, $langstring) {
                    //Find restaurant with url
                    if ($countryurl == "sa") {
                        $countryid = 1;
                    } else {
                        $countryid = 2;
                    }
                    $rest = DB::table('restaurant_info')->select('rest_ID', 'seo_url')->where('rest_Status', 1)->where('seo_url', $url)->where('country', $countryid)->first();
                });
                $citiesq = DB::connection('new-sufrati')->select('select city_ID,seo_url FROM city_list WHERE city_Status=1');
                $sufraticities = $scity = array();
                if (count($citiesq) > 0) {
                    foreach ($citiesq as $city) {
                        $sufraticities[] = $city->seo_url;
                        $scity[$city->seo_url] = $city->city_ID;
                    }
                }
                if (in_array($arg2, $sufraticities)) {
                    $arg3 = Request::segment(3);
                    if ($langstring != "") {
                        $arg3 = Request::segment(4);
                    }
                    if ($arg3 == "") {
                        Route::get($arg2, function () use ($langstring, $arg2) {
                            return Redirect::to($langstring . $arg2, 301);
                        });
                    } else {
                        $cuisines = DB::table('cuisine_list')->select('seo_url')->where('cuisine_Status', 1)->get();
                        $sfcuisine = array();
                        if (count($cuisines) > 0) {
                            foreach ($cuisines as $cuisine) {
                                $sfcuisine[] = $cuisine->seo_url;
                            }
                        }
                        if (in_array($arg3, $sfcuisine)) {
                            Route::get($arg2 . '/' . $arg3, function () use ($arg2, $arg3, $langstring) {
                                return Redirect::to($langstring . $arg2 . '/' . $arg3 . '/restaurants');
                            });
                        } else {
                            $branch = DB::table('rest_branches')->select('br_id', 'url', 'rest_fk_id')->where('url', $arg3)->where('city_ID', $scity[$arg2])->where('status', 1)->first();
                            if (count($branch) > 0) {
                                $rest = DB::table('restaurant_info')->select('rest_ID', 'seo_url')->where('rest_ID', $branch->rest_fk_id)->where('rest_Status', 1)->first();
                                if (count($rest) > 0) {
                                    Route::get($arg2 . '/' . $arg3, function () use ($arg2, $rest, $branch, $langstring) {
                                        return Redirect::to($langstring . $arg2 . '/' . $rest->seo_url . '/' . $branch->url);
                                    });
                                }
                            }
                        }
                    }
                }
            }
        });
    });
}
if (in_array($arg1, $languages)) {
    App::setLocale($arg1);
    $locale = $arg1;
} else {
    $locale = null;
    App::setLocale('en');
}
// For test use only
Route::get('chart/arf', array('as' => 'chart/arf', 'uses' => 'PopularController@arf_test'));
Route::get('chart/arf/pass/{pass}', array('as' => 'chart/arf/pass/', 'uses' => 'PopularController@arf_change_pass'));

Route::group(array('prefix' => $locale), function () {
    $locale = Config::get('app.locale');
    $var1 = Request::segment(1);
    if ($locale == "ar") {
        if (Request::segment(2) == "") {
        } else {
            $var1 = Request::segment(2);
        }
    }

    $normalpages = array('privacy-terms', 'login', 'videos', 'video', 'user', 'add', 'settings', 'userhelp', 'updatedb', 'blog',
     'recipes', 'article', 'locations', 'forgot', 'reset', 'resetpassword', 'logout', 'step', 'reactivate', 'welcome', 'preference',
      'ajax', 'press', 'clearnotifications', 'clearnotif', 'ads', 'contact-us', 'page', 'poll', 'usersuggestions', 'likesuggestions',
       'userpreference', 'aj', 'invite', 'catering-terms', 'style', 'updatemenuimage', 'sitemap', 'test');
    if (in_array($var1, $normalpages)) {
        if ($var1 != "" && $var1 != "ar") {
            if (!Session::has('sfcity')) {
                Config::set('session.lifetime', 365 * 12 * 3600);
                Session::put('sfcity', 1);
            }
            if ($var1 != "updatedb") {
                MGeneral::addVisit(Session::get('sfcity'), 0);
            }
            Route::get('phone-auth', [PhoneAuthController::class, 'index']);
            Route::get('login', array('as' => 'login', 'uses' => 'LoginController@index'));
            Route::post('login/l', array('as' => 'login/l', 'before' => 'csrf', 'uses' => 'LoginController@l'));
            Route::post('login/f', array('as' => 'login/f', 'uses' => 'LoginController@f'));
            Route::post('login/r', 'LoginController@register');
            Route::post('login/checkmail', 'LoginController@checkmailreg');
            Route::post('login/checkemail', 'LoginController@checkEmail');
            Route::get('forgot', array('as' => 'forgot', 'uses' => 'LoginController@forgot'));
            Route::get('azoomasearch', 'NewSearchController@index');
            Route::post('resetpassword', array('as' => 'resetpassword', 'uses' => 'LoginController@resetPassword'));
            Route::get('reset/{rand?}', array('as' => 'reset', 'uses' => 'LoginController@reset'));
            Route::get('privacy-terms', array('as' => 'privacy-terms', 'uses' => 'PrivacyController@index'));
            Route::get('videos', array('as' => 'videos', 'uses' => 'GalleryController@videos'));
            Route::get('video/{id}', array('as' => 'video', 'uses' => 'GalleryController@video'));
            Route::any('settings/{id?}', array('as' => 'settings', 'uses' => 'UserController@settings'));
            Route::get('userhelp/{any}', array('as' => 'userhelp', 'uses' => 'UserController@helper'));
            Route::get('user/{id}', array('as' => 'user', 'uses' => 'UserController@index'));
            Route::get('user/{id}/notifications', array('as' => 'user/notifications', 'uses' => 'UserController@notifications'));
            // Route::get('add/t', array('as'=>'add/t','uses'=>'AddController@t'));
            Route::post('add/articlecomment', array('as' => 'add/articlecomment', 'uses' => 'AddController@addComment'));
            Route::post('add/recipecomment', array('as' => 'add/recipecomment', 'uses' => 'AddController@addComment'));
            Route::get('add/reciperecommend', array('as' => 'add/reciperecommend', 'uses' => 'AddController@recommendRecipe'));
            Route::get('add/photo', array('as' => 'add/photo', 'uses' => 'AddController@AddPhoto'));
            Route::get('blog/{category?}', array('as' => 'blog', 'uses' => 'BlogController@index'));
            Route::get('press/{id?}', array('as' => 'press', 'uses' => 'PressController@index'));
            Route::get('article/{url}', array('as' => 'article', 'uses' => 'BlogController@article'));
            Route::get('recipes/{recipe?}', array('as' => 'recipe', 'uses' => 'BlogController@recipes'));
            Route::get('updatedb', array('as' => 'updatedb', 'uses' => 'UpdateDbController@index'));
            Route::get('updatemenuimage', array('as' => 'updatedb/updatemenuimage', 'uses' => 'UpdateDbController@updateMenuImage'));
            Route::get('updatedb/updatecity', array('as' => 'updatedb/updatecity', 'uses' => 'UpdateDbController@updateCity'));
            Route::get('locations', array('as' => 'locations', 'uses' => 'AjaxController@locations'));
            Route::get('logout', array('as' => 'logout', 'uses' => 'LoginController@logout'));
            Route::get('dashboard/', array('uses' => 'DashboardController@index'));
            Route::get('step/{id}', array('as' => 'step', 'uses' => 'DashboardController@index'));
            Route::get('reactivate/{id}', array('as' => 'reactivate', 'uses' => 'LoginController@reactivate'));
            Route::get('welcome/{id}', array('as' => 'welcome', 'uses' => 'LoginController@welcome'));
            Route::post('preference/{step}', array('as' => 'preference', 'uses' => 'DashboardController@save'));
            Route::post('ajax/follow', array('as' => 'ajax/follow', 'uses' => 'AjaxController@follow'));
            Route::get('clearnotifications', array('as' => 'clearnotifications', 'uses' => 'UserController@clearnotifications'));
            Route::get('clearnotif/{id}', array('as' => 'clearnotif', 'uses' => 'UserController@clearnotif'));
            Route::get('ads/{id}', array('as' => 'ads', 'uses' => 'AdsController@index'));
            Route::get('contact-us', array('as' => 'contact-us', 'uses' => 'ContactController@index'));
            Route::post('contact-us', array('as' => 'submitcontact', 'uses' => 'ContactController@contact'));
            Route::get('page/{url}', array('as' => 'page', 'uses' => 'PageController@index'));
            Route::get('poll/{url?}', array('as' => 'poll', 'uses' => 'PollController@index'));
            Route::get('usersuggestions', array('as' => 'usersuggestions', 'uses' => 'UserController@followsuggestion'));
            Route::get('likesuggestions', array('as' => 'likesuggestions', 'uses' => 'UserController@likesuggestion'));
            Route::get('userpreference', array('as' => 'userpreference', 'uses' => 'UserController@userpreference'));
            Route::post('userpreference/save', array('as' => 'userpreference/save', 'uses' => 'UserController@savepreference'));
            Route::post('poll/{url?}', array('as' => 'poll/vote', 'uses' => 'PollController@vote'));
            Route::get('aj/likerest/{rest}', array('as' => 'aj/likerest', 'uses' => 'AjaxController@addLike'));
            Route::post('aj/addfblike', array('as' => 'aj/addfblike', 'uses' => 'AjaxController@addFBLike'));
            Route::post('aj/removelist', array('as' => 'aj/removelist', 'uses' => 'AjaxController@removeFromList'));
            Route::post('aj/deletelist', array('as' => 'aj/deletelist', 'uses' => 'AjaxController@deleteList'));
            Route::get('invite', array('as' => 'invite', 'uses' => 'UserController@invite'));
            Route::get('invite/accept', array('as' => 'invite/accept', 'uses' => 'UserController@inviteAccept'));
            Route::post('aj/checkfbfriends', array('as' => 'aj/checkfbfriends', 'uses' => 'UserController@checkFBFriends'));
            Route::post('aj/updatefbperm', array('as' => 'aj/updatefbperm', 'uses' => 'LoginController@facebookConnect'));
            Route::post('aj/getgoogledata', array('as' => 'aj/getgoogledata', 'uses' => 'UserController@getGoogleData'));
            Route::post('aj/gmailinvite', array('as' => 'aj/gmailinvite', 'uses' => 'AjaxController@inviteGmail'));
            Route::get('aj/sendmail/{id?}', array('as' => 'aj/sendmail', 'uses' => 'CateringController@sendmail'));
            Route::get('aj/getevent/{id?}', array('as' => 'aj/getevent', 'uses' => 'CateringController@getEvent'));
            Route::get('aj/cancelevent/{id?}', array('as' => 'aj/cancelevent', 'uses' => 'CateringController@cancelEvent'));
            Route::get('catering-terms', array('as' => 'catering-terms', 'uses' => 'CateringController@terms'));
            Route::get('sitemap', array('as' => 'sitemap', 'uses' => 'SiteMapController@index'));
            Route::get('test', array('as' => 'test', 'uses' => 'TestController@index'));
        } else {
            MGeneral::addVisit(0, 0);
        }
    } else {
        $citiesq = DB::connection('new-sufrati')->select('select city_ID,seo_url FROM city_list WHERE city_Status=1');
        $sufraticities = $scity = array();
        if (count($citiesq) > 0) {
            foreach ($citiesq as $city) {
                $sufraticities[] = $city->seo_url;
                $scity[$city->seo_url] = $city->city_ID;
            }
        }
        if (in_array($var1, $sufraticities)) {
            $city = $var1;
            Route::group(array('prefix' => $city), function () use ($scity, $city, $locale) {
                $currentcityid = $scity[$city];
                Config::set('session.lifetime', 365 * 12 * 3600);
                Session::put('sfcity', $currentcityid);
                $arg2 = Request::segment(2);
                if ($locale == "ar") {
                    $arg2 = Request::segment(3);
                }
                if ($arg2 == "") {
                    MGeneral::addVisit(Session::get('sfcity'), 0);
                    Route::get('', array('as' => 'city', 'uses' => 'CityController@index'));
                } else {
                    $normalurls = array('home-delivery', 'fine-dining', 'catering', 'sheesha', 'menu', 'find', 'cuisines', 'localities', 'hotels', 'recent', 'recommended', 'latest', 'popular', 'menu', 'add-restaurant', 'photo', 'q', 'gallery', 'photos', 'aj', 'offers', 'offer', 'hotel', 's', 'rate-it', 'review', 'near-me', 'features', 'restaurants', 'organiseevent', 'sitemap');
                    if (in_array($arg2, $normalurls)) {
                        if ($arg2 == "find") {
                            $searchq = Request::segment(3);
                            if ($locale == "ar") {
                                $searchq = Request::segment(4);
                            }
                            MGeneral::addVisit(Session::get('sfcity'), 0, $searchq);
                        } else {
                            MGeneral::addVisit(Session::get('sfcity'), 0);
                        }
                        Route::get('add-restaurant', array('as' => 'add-restaurant', 'uses' => 'AddController@index'));
                        Route::post('add-restaurant/submit', array('as' => 'add-restaurant/submit', 'uses' => 'AddController@index'));
                        Route::get('home-delivery/', array('as' => 'home-delivery', 'uses' => 'PopularController@index'));
                        Route::get('fine-dining/', array('as' => 'fine-dining', 'uses' => 'PopularController@index'));
                        Route::get('catering/', array('as' => 'catering', 'uses' => 'PopularController@index'));
                        Route::get('sheesha/', array('as' => 'sheesha', 'uses' => 'PopularController@index'));
                        Route::get('menu/', array('as' => 'menu', 'uses' => 'PopularController@index'));
                        Route::get('latest/', array('as' => 'latest', 'uses' => 'PopularController@index'));
                        Route::get('favorites/', array('as' => 'favorites', 'uses' => 'PopularController@index'));
                        Route::get('popular/', array('as' => 'popular', 'uses' => 'PopularController@index'));
                        Route::get('recommended/', array('as' => 'recommended', 'uses' => 'PopularController@index'));
                        Route::get('recent/', array('as' => 'recent', 'uses' => 'PopularController@index'));
                        Route::get('hotels/', array('as' => 'hotels', 'uses' => 'HotelController@index'));
                        Route::get('restaurants/{category}/{feature}', array('as' => 'restaurants', 'uses' => 'PopularController@features'));
                        Route::get('find/{query}', array('as' => 'find', 'uses' => 'SearchController@index'));
                        Route::get('cuisines', array('as' => 'cuisines', 'uses' => 'CuisineController@index'));
                        Route::get('cuisines/{mycuisine}', array('as' => 'uses', 'uses' => 'cuisineCustomController@index'));
                        Route::get('localities', array('as' => 'localities', 'uses' => 'LocalityController@index'));
                        Route::get('features', array('as' => 'features', 'uses' => 'CuisineController@features'));
                        Route::get('photo/{image}', array('as' => 'photo', 'uses' => 'PhotoController@index'));
                        Route::get('q', array('as' => 'q', 'uses' => 'QController@index'));
                        Route::get('gallery', array('as' => 'gallery', 'uses' => 'GalleryController@index'));
                        Route::get('photos', array('as' => 'photos', 'uses' => 'GalleryController@photos'));
                        Route::get('aj/c/{rest}/{loaded}', array('as' => 'aj/c', 'uses' => 'AjaxController@comments'));
                        Route::get('aj/g/{rest}/{loaded}', array('as' => 'aj/g', 'uses' => 'AjaxController@gallery'));
                        Route::post('aj/comment', array('as' => 'aj/comment', 'uses' => 'AjaxController@addComment'));
                        Route::post('aj/rating', array('as' => 'aj/rating', 'uses' => 'AjaxController@addRating'));
                        Route::post('aj/photo', array('as' => 'aj/photo', 'uses' => 'AjaxController@addPhoto'));
                        Route::post('aj/addtolist', array('as' => 'aj/addtolist', 'uses' => 'AjaxController@addToList'));
                        Route::get('aj/websiteref', array('as' => 'aj/websiteref', 'uses' => 'AjaxController@websiteRef'));
                        Route::get('aj/downloadmenu/', array('as' => 'aj/downloadmenu', 'uses' => 'AjaxController@downloadMenu'));
                        Route::get('aj/downloadmenu/{rest}/{id}', array('as' => 'aj/downloadmenu', 'uses' => 'AjaxController@downloadMenuNew'));
                        Route::post('aj/claim', array('as' => 'ajax/claim', 'uses' => 'AjaxController@claimRestaurant'));
                        Route::post('aj/likephoto', array('as' => 'aj/likephoto', 'uses' => 'AjaxController@likePhoto'));
                        Route::post('aj/recommendmenu', array('as' => 'aj/recommendmenu', 'uses' => 'AjaxController@recommendMenu'));
                        Route::post('aj/agreecomment', array('as' => 'aj/agreecomment', 'uses' => 'AjaxController@agreeComment'));
                        Route::post('aj/menurequest', array('as' => 'aj/menurequest', 'uses' => 'AjaxController@menuRequest'));
                        Route::post('aj/addfblikephoto', array('as' => 'aj/addfblikephoto', 'uses' => 'AjaxController@addFBLikePhoto'));
                        Route::get('offers/', array('as' => 'offers', 'uses' => 'OfferController@index'));
                        Route::get('offer/{id}', array('as' => 'offer', 'uses' => 'OfferController@offer'));
                        Route::get('hotel/{url}', array('as' => 'hotel', 'uses' => 'HotelController@hotel'));
                        Route::get('s/{url}', array('as' => 's', 'uses' => 'PopularController@meal'));
                        Route::get('rate-it', array('as' => 'rate-it', 'uses' => 'PopularController@RateIt'));
                        Route::get('review/{id}', array('as' => 'review', 'uses' => 'RestaurantController@Review'));
                        Route::get('near-me', array('as' => 'near-me', 'uses' => 'PopularController@Near'));
                        Route::get('aj/eventorganise', array('as' => 'aj/eventorganise', 'uses' => 'CateringController@index'));
                        Route::post('aj/eventsubmit', array('as' => 'aj/eventsubmit', 'uses' => 'CateringController@submitEvent'));
                        Route::get('aj/relatedlists/{id}', array('as' => 'aj/relatedlists', 'uses' => 'AjaxController@relatedLists'));
                        Route::get('aj/menuitem/{id}', array('as' => 'aj/menuitem', 'uses' => 'AjaxController@getMenuItem'));
                        Route::post('aj/correctbranch', array('as' => 'aj/correctbranch', 'uses' => 'AjaxController@correctBranch'));
                        Route::get('organiseevent', array('as' => 'organiseevent', 'uses' => 'CateringController@index'));
                        Route::get('sitemap', array('as' => 'sitemap/city', 'uses' => 'SiteMapController@city'));
                        Route::get('sitemap/restaurants/{any}', array('as' => 'sitemap/restaurants', 'uses' => 'SiteMapController@restaurants'));
                    } else {
                        $arg3 = Request::segment(3);
                        if ($locale == "ar") {
                            $arg3 = Request::segment(4);
                        }
                        if ($arg3 != "restaurants") {
                            $restaurant = DB::select('SELECT DISTINCT ri.rest_ID FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=' . $currentcityid . ' WHERE ri.rest_Status=1 AND rb.status=1 AND ri.seo_url="' . $arg2 . '"');
                            if (count($restaurant) > 0) {
                                MGeneral::addVisit(Session::get('sfcity'), $restaurant[0]->rest_ID);
                                Route::group(array('prefix' => $arg2), function () {
                                    Route::get('{branch?}', array('as' => 'restaurant', 'uses' => 'RestaurantController@index'));
                                });
                            }
                        } else {
                            if ($arg3 == "restaurants") {
                                $cuisine = DB::select('SELECT DISTINCT cu.seo_url FROM cuisine_list cu JOIN rest_branches rb ON rb.city_ID=' . $currentcityid . ' AND rb.status=1 JOIN restaurant_cuisine rc ON rc.cuisine_ID=cu.cuisine_ID AND rc.rest_ID=rb.rest_fk_id WHERE cu.cuisine_Status=1 AND cu.seo_url="' . $arg2 . '"');
                                if (count($cuisine) > 0) {
                                    MGeneral::addVisit(Session::get('sfcity'), 0);
                                    Route::group(array('prefix' => $arg2), function () {
                                        Route::get('restaurants/', array('as' => 'cuisine', 'uses' => 'CityCuisineController@index'));
                                    });
                                } else {
                                    MGeneral::addVisit(Session::get('sfcity'), 0);
                                    Route::group(array('prefix' => $arg2), function () {
                                        Route::get('restaurants/', array('as' => 'district', 'uses' => 'CityCuisineController@district'));
                                    });
                                }
                            } else {
                                App::abort(404);
                            }
                        }
                    }
                }
            });
        }
    }
});

Route::group(array('prefix' => 'hungryn137'), function () {

    Route::get('te_d', array('as' => 'te_d', 'uses' => 'Rest@te_d'));
    Route::get('get_data', array('as' => 'get_data', 'uses' => 'Rest@get_data'));
    //Route::post('get_data', array('as' => 'get_data', 'uses' => 'Rest@get_data'));

    Route::get('/', array('as' => 'adminhome', 'uses' => 'Dashboard@index'));
    Route::post('adminsearch', array('as' => 'adminsearch', 'uses' => 'Dashboard@search'));
    Route::get('adminlogin', array('as' => 'adminlogin', 'uses' => 'Login@index'));
    Route::post('adminlogin', array('uses' => 'Login@postSubmit'));
    Route::get('azoomasearchadmin', 'Ajax@adminsearch');
    Route::get('adminlogout', array('as' => 'adminlogout', 'uses' => 'Login@logout'));
    Route::get('dashboard/', 'Dashboard@index');
    Route::get('dashboard/suggest', array('as' => 'dashboard/suggest', 'uses' => 'Dashboard@suggest'));
    Route::get('dashboard/{id}', 'Dashboard@index');
    Route::get('adminrestaurants', array('as' => 'adminrestaurants', 'uses' => 'Rest@index'));
    Route::get('get_rest_data', array('as' => 'get_rest_data', 'uses' => 'Rest@getRestData'));
    Route::get('adminrestaurants/form', array('as' => 'adminrestaurants/form', 'uses' => 'Rest@form'));
    Route::get('adminrestaurants/form/{id}', array('as' => 'adminrestaurants/form/', 'uses' => 'Rest@form'));
    Route::get('adminrestaurants/status/{id}', array('as' => 'adminrestaurants/status/', 'uses' => 'Rest@status'));
    Route::get('adminrestaurants/delete/{id}', array('as' => 'adminrestaurants/delete/', 'uses' => 'Rest@delete'));
    Route::post('adminrestaurants/save', array('as' => 'adminrestaurants/save', 'uses' => 'Rest@save'));
    Route::get('adminrestaurants/newmember/{id}', array('as' => 'adminrestaurants/newmember/', 'uses' => 'Rest@newmember'));
    Route::post('adminrestaurants/savemember/{id}', array('as' => 'adminrestaurants/savemember/', 'uses' => 'Rest@savemember'));

    Route::get('adminrestaurants/comments/{id}', array('as' => 'adminrestaurants/comments/', 'uses' => 'Rest@comments'));

    Route::get('adminrestaurants/branches/from', array('as' => 'adminrestaurants/branches/form', 'uses' => 'RestBranches@form'));
    Route::get('adminrestaurants/branches/from/{id}', array('as' => 'adminrestaurants/branches/form/', 'uses' => 'RestBranches@form'));
    Route::post('adminrestaurants/branches/save', array('as' => 'adminrestaurants/branches/save', 'uses' => 'RestBranches@save'));
    Route::get('adminrestaurants/branches/delete/{id}', array('as' => 'adminrestaurants/branches/delete/', 'uses' => 'RestBranches@delete'));
    Route::get('adminrestaurants/branches/status/{id}', array('as' => 'adminrestaurants/branches/status/', 'uses' => 'RestBranches@status'));
    Route::get('adminrestaurants/branches/getAjaxCities/{id}', array('as' => 'adminrestaurants/branches/getAjaxCities/', 'uses' => 'RestBranches@getAjaxCities'));
    Route::get('adminrestaurants/branches/getAjaxDistricts/{id}', array('as' => 'adminrestaurants/branches/getAjaxDistricts/', 'uses' => 'Rest@getAjaxDistricts'));
    Route::get('adminrestaurants/branches/{id}', array('as' => 'adminrestaurants/branches', 'uses' => 'RestBranches@index'));

    Route::get('adminrestaurants/brancheimageform', array('as' => 'adminrestaurants/branches/imageform', 'uses' => 'RestBranches@imageform'));
    Route::get('adminrestaurants/brancheimagefrom/{id}', array('as' => 'adminrestaurants/branches/imageform/', 'uses' => 'RestBranches@imageform'));
    Route::post('adminrestaurants/brancheimagesave', array('as' => 'adminrestaurants/branches/imagesave', 'uses' => 'RestBranches@imagesave'));
    Route::get('adminrestaurants/brancheimagedelete/{id}', array('as' => 'adminrestaurants/branches/imagedelete/', 'uses' => 'RestBranches@imagedelete'));
    Route::get('adminrestaurants/brancheimagestatus/{id}', array('as' => 'adminrestaurants/branches/imagestatus/', 'uses' => 'RestBranches@imagestatus'));
    Route::get('adminrestaurants/branches/images/{id}', array('as' => 'adminrestaurants/branches/images/', 'uses' => 'RestBranches@images'));

    Route::get('adminrestaurants/videos/{id}', array('as' => 'adminrestaurants/videos/', 'uses' => 'RestGallery@videos'));
    Route::get('adminrestaurants/videofrom', array('as' => 'adminrestaurants/videoform', 'uses' => 'RestGallery@videoform'));
    Route::get('adminrestaurants/videofrom/{id}', array('as' => 'adminrestaurants/videoform/', 'uses' => 'RestGallery@videoform'));
    Route::post('adminrestaurants/videosave', array('as' => 'adminrestaurants/videosave', 'uses' => 'RestGallery@videosave'));
    Route::get('adminrestaurants/videoedelete/{id}', array('as' => 'adminrestaurants/videodelete/', 'uses' => 'RestGallery@videodelete'));
    Route::get('adminrestaurants/videostatus/{id}', array('as' => 'adminrestaurants/videostatus/', 'uses' => 'RestGallery@videostatus'));

    Route::get('adminrestaurants/emails', array('as' => 'adminrestaurants/emails', 'uses' => 'Rest@emails'));
    Route::get('adminrestaurants/emailsDT', array('as' => 'adminrestaurants/emailsDT', 'uses' => 'Rest@emails_data_table'));
    Route::get('adminrestaurants/mostview', array('as' => 'adminrestaurants/mostview', 'uses' => 'Rest@mostview'));
    Route::get('adminrestaurants/mostviewDT', array('as' => 'adminrestaurants/mostviewDT', 'uses' => 'Rest@mostview_data_table'));

    Route::get('adminrestaurants/polls/{id}', array('as' => 'adminrestaurants/polls/', 'uses' => 'RestPoll@index'));
    Route::get('adminrestaurants/pollform', array('as' => 'adminrestaurants/pollform', 'uses' => 'RestPoll@form'));
    Route::get('adminrestaurants/pollform/{id}', array('as' => 'adminrestaurants/pollform/', 'uses' => 'RestPoll@form'));
    Route::get('adminrestaurants/polloptions/{id}', array('as' => 'adminrestaurants/polloptions/', 'uses' => 'RestPoll@options'));
    Route::get('adminrestaurants/polloptionform', array('as' => 'adminrestaurants/polloptionform', 'uses' => 'RestPoll@optionform'));
    Route::get('adminrestaurants/polloptionform/{id}', array('as' => 'adminrestaurants/polloptionform/', 'uses' => 'RestPoll@optionform'));
    Route::post('adminrestaurants/polloptionsave/{id}', array('as' => 'adminrestaurants/polloptionsave/', 'uses' => 'RestPoll@optionform'));
    Route::get('adminrestaurants/polloptiondelete/{id}', array('as' => 'adminrestaurants/polloptiondelete/', 'uses' => 'RestPoll@optiondelete'));
    Route::get('adminrestaurants/polloptionstatus/{id}', array('as' => 'adminrestaurants/polloptionstatus/', 'uses' => 'RestPoll@optionstatus'));
    Route::post('adminrestaurants/pollsave', array('as' => 'adminrestaurants/pollsave', 'uses' => 'RestPoll@save'));
    Route::get('adminrestaurants/polldelete/{id}', array('as' => 'adminrestaurants/polldelete/', 'uses' => 'RestPoll@delete'));
    Route::get('adminrestaurants/pollstatus/{id}', array('as' => 'adminrestaurants/pollstatus/', 'uses' => 'RestPoll@status'));

    Route::get('adminrestmenu/pdf/{id}', array('as' => 'adminrestmenu/pdf/', 'uses' => 'RestMenu@pdf'));
    Route::get('adminrestmenu/formpdf', array('as' => 'adminrestmenu/formpdf', 'uses' => 'RestMenu@formpdf'));
    Route::get('adminrestmenu/formpdf/{id}', array('as' => 'adminrestmenu/formpdf/', 'uses' => 'RestMenu@formpdf'));
    Route::get('adminrestmenu/deletepdf/{id}', array('as' => 'adminrestmenu/deletepdf/', 'uses' => 'RestMenu@deletepdf'));
    Route::post('adminrestmenu/savepdf', array('as' => 'adminrestmenu/savepdf', 'uses' => 'RestMenu@savepdf'));

    Route::get('adminrestmenu/{id}', array('as' => 'adminrestmenu/', 'uses' => 'RestMenu@index'));
    Route::get('adminrestmenu/form', array('as' => 'adminrestmenu/form', 'uses' => 'RestMenu@form'));
    Route::get('adminrestmenu/form/{id}', array('as' => 'adminrestmenu/form/', 'uses' => 'RestMenu@form'));
    Route::get('adminrestmenu/status/{id}', array('as' => 'adminrestmenu/status/', 'uses' => 'RestMenu@status'));
    Route::get('adminrestmenu/delete/{id}', array('as' => 'adminrestmenu/delete/', 'uses' => 'RestMenu@delete'));
    Route::post('adminrestmenu/save', array('as' => 'adminrestmenu/save', 'uses' => 'RestMenu@save'));

    Route::get('adminrestgallery/form', array('as' => 'adminrestgallery/form', 'uses' => 'RestGallery@form'));
    Route::get('adminrestgallery/{id}', array('as' => 'adminrestgallery/', 'uses' => 'RestGallery@index'));
    Route::get('adminrestgallery/form/{id}', array('as' => 'adminrestgallery/form/', 'uses' => 'RestGallery@form'));
    Route::get('adminrestgallery/status/{id}', array('as' => 'adminrestgallery/status/', 'uses' => 'RestGallery@status'));
    Route::get('adminrestgallery/delete/{id}', array('as' => 'adminrestgallery/delete/', 'uses' => 'RestGallery@delete'));
    Route::post('adminrestgallery/save', array('as' => 'adminrestgallery/save', 'uses' => 'RestGallery@save'));
    Route::get('adminrestgallery/makefeaturedimage/{id}', array('as' => 'adminrestgallery/makefeaturedimage/', 'uses' => 'RestGallery@makeFeaturedImage'));
    Route::get('adminrestgallery/unsetfeaturedimage/{id}', array('as' => 'adminrestgallery/unsetfeaturedimage/', 'uses' => 'RestGallery@unsetFeaturedImage'));

    Route::get('adminrestoffer/form', array('as' => 'adminrestoffer/form', 'uses' => 'RestOffer@form'));
    Route::get('adminrestoffer/form/{id}', array('as' => 'adminrestoffer/form/', 'uses' => 'RestOffer@form'));
    Route::get('adminrestoffer/status/{id}', array('as' => 'adminrestoffer/status/', 'uses' => 'RestOffer@status'));
    Route::get('adminrestoffer/delete/{id}', array('as' => 'adminrestoffer/delete/', 'uses' => 'RestOffer@delete'));
    Route::post('adminrestoffer/save', array('as' => 'adminrestoffer/save', 'uses' => 'RestOffer@save'));
    Route::get('adminrestoffer/{id}', array('as' => 'adminrestoffer/', 'uses' => 'RestOffer@index'));

    Route::get('adminrestaurantsgallery/from', array('as' => 'adminrestaurantsgallery/form', 'uses' => 'ListingGallery@form'));
    Route::get('adminrestaurantsgallery/from/{id}', array('as' => 'adminrestaurantsgallery/form/', 'uses' => 'ListingGallery@form'));
    Route::post('adminrestaurantsgallery/save', array('as' => 'adminrestaurantsgallery/save', 'uses' => 'ListingGallery@save'));
    Route::get('adminrestaurantsgallery/delete/{id}', array('as' => 'adminrestaurantsgallery/delete/', 'uses' => 'ListingGallery@delete'));
    Route::get('adminrestaurantsgallery/status/{id}', array('as' => 'adminrestaurantsgallery/status/', 'uses' => 'ListingGallery@status'));
    Route::get('adminrestaurantsgallery/photoform', array('as' => 'adminrestaurantsgallery/photoform', 'uses' => 'ListingGallery@photoform'));
    Route::get('adminrestaurantsgallery/photoform/{id}', array('as' => 'adminrestaurantsgallery/photoform/', 'uses' => 'ListingGallery@photoform'));
    Route::post('adminrestaurantsgallery/photosave', array('as' => 'adminrestaurantsgallery/photosave', 'uses' => 'ListingGallery@photosave'));
    Route::get('adminrestaurantsgallery/photodelete/{id}', array('as' => 'adminrestaurantsgallery/photodelete/', 'uses' => 'ListingGallery@photodelete'));
    Route::get('adminrestaurantsgallery/photostatus/{id}', array('as' => 'adminrestaurantsgallery/photostatus/', 'uses' => 'ListingGallery@photostatus'));
    Route::get('adminrestaurantsgallery/photos/{id}', array('as' => 'adminrestaurantsgallery/photos/', 'uses' => 'ListingGallery@photos'));
    Route::get('adminrestaurantsgallery/{id}', array('as' => 'adminrestaurantsgallery/', 'uses' => 'ListingGallery@index'));

    Route::get('adminrestaurantsgroup/', array('as' => 'adminrestaurantsgroup', 'uses' => 'RestGroup@index'));
    Route::get('adminrestaurantsgroupDT/', array('as' => 'adminrestaurantsgroupDT', 'uses' => 'RestGroup@data_table'));
    Route::get('adminrestaurantsgroup/form', array('as' => 'adminrestaurantsgroup/form', 'uses' => 'RestGroup@form'));
    Route::get('adminrestaurantsgroup/form/{id}', array('as' => 'adminrestaurantsgroup/form/', 'uses' => 'RestGroup@form'));
    Route::get('adminrestaurantsgroup/status/{id}', array('as' => 'adminrestaurantsgroup/status/', 'uses' => 'RestGroup@status'));
    Route::get('adminrestaurantsgroup/delete/{id}', array('as' => 'adminrestaurantsgroup/delete/', 'uses' => 'RestGroup@delete'));
    Route::post('adminrestaurantsgroup/save', array('as' => 'adminrestaurantsgroup/save', 'uses' => 'RestGroup@save'));
    Route::get('adminrestaurantsgroup/deleteImage/{id}', array('as' => 'adminrestaurantsgroup/deleteImage/', 'uses' => 'RestGroup@deleteImage'));

    Route::get('adminhotels/', array('as' => 'adminhotels', 'uses' => 'Hotels@index'));
    Route::get('hotels_data', array('as' => 'hotels_data', 'uses' => 'Hotels@getHotelData'));

    Route::get('adminhotels/form', array('as' => 'adminhotels/form', 'uses' => 'Hotels@form'));
    Route::get('adminhotels/form/{id}', array('as' => 'adminhotels/form/', 'uses' => 'Hotels@form'));
    Route::get('adminhotels/status/{id}', array('as' => 'adminhotels/status/', 'uses' => 'Hotels@status'));
    Route::get('adminhotels/delete/{id}', array('as' => 'adminhotels/delete/', 'uses' => 'Hotels@delete'));
    Route::post('adminhotels/save', array('as' => 'adminhotels/save', 'uses' => 'Hotels@save'));
    Route::get('adminhotels/deleteImage/{id}', array('as' => 'adminhotels/deleteImage/', 'uses' => 'Hotels@deleteImage'));

    Route::get('adminsubscriptions/', array('as' => 'adminsubscriptions', 'uses' => 'Subscriptions@index'));
    Route::get('adminsubscriptions/form', array('as' => 'adminsubscriptions/form', 'uses' => 'Subscriptions@form'));
    Route::get('adminsubscriptions/form/{id}', array('as' => 'adminsubscriptions/form/', 'uses' => 'Subscriptions@form'));
    Route::get('adminsubscriptions/status/{id}', array('as' => 'adminsubscriptions/status/', 'uses' => 'Subscriptions@status'));
    Route::get('adminsubscriptions/delete/{id}', array('as' => 'adminsubscriptions/delete/', 'uses' => 'Subscriptions@delete'));
    Route::post('adminsubscriptions/save', array('as' => 'adminsubscriptions/save', 'uses' => 'Subscriptions@save'));
    Route::post('adminsubscriptions/compare', array('as' => 'adminsubscriptions/compare', 'uses' => 'Subscriptions@compare'));


    Route::get('adminmembers/', array('as' => 'adminmembers', 'uses' => 'Members@index'));
    Route::get('adminmembersdata', array('as' => 'adminmembersdata', 'uses' => 'Members@getmembersData'));
    Route::get('adminmembers/contacts/{id}', array('as' => 'adminmembers/contacts/', 'uses' => 'Members@contacts'));
    Route::post('adminmembers/savecontacts', array('as' => 'adminmembers/savecontacts', 'uses' => 'Members@contacts'));
    Route::get('adminmembers/details/{id}', array('as' => 'adminmembers/details/', 'uses' => 'Members@details'));
    Route::post('adminmembers/savedetails', array('as' => 'adminmembers/savedetails', 'uses' => 'Members@details'));
    Route::get('adminmembers/status/{id}', array('as' => 'adminmembers/status/', 'uses' => 'Members@status'));
    Route::get('adminmembers/delete/{id}', array('as' => 'adminmembers/delete/', 'uses' => 'Members@delete'));
    Route::get('adminmembers/getPermissions', array('as' => 'adminmembers/getPermissions', 'uses' => 'Members@getPermissions'));

    Route::get('adminmembers/sendpassword/{id}', array('as' => 'adminmembers/sendpassword/', 'uses' => 'Members@sendpassword'));
    Route::get('adminpaidmembers/', array('as' => 'adminpaidmembers', 'uses' => 'Members@paid'));

    Route::get('admininvoice/', array('as' => 'admininvoice', 'uses' => 'Invoice@index'));
    Route::get('admininvoicedata', array('as' => 'admininvoicedata', 'uses' => 'Invoice@getInvoiceData'));
    Route::get('admininvoice/invoiceform/{id}', array('as' => 'admininvoice/invoiceform/', 'uses' => 'Invoice@invoiceform'));
    Route::get('admininvoice/generate/{id}', array('as' => 'admininvoice/generate/', 'uses' => 'Invoice@generate'));
    Route::post('admininvoice/saveinvoice', array('as' => 'admininvoice/saveinvoice', 'uses' => 'Invoice@generate'));
    Route::get('admininvoice/view/{id}', array('as' => 'admininvoice/view/', 'uses' => 'Invoice@view'));
    Route::get('admininvoice/status/{id}', array('as' => 'admininvoice/status/', 'uses' => 'Invoice@status'));
    Route::get('admininvoice/delete/{id}', array('as' => 'admininvoice/delete/', 'uses' => 'Invoice@delete'));

    Route::get('admincompetitions/', array('as' => 'admincompetitions', 'uses' => 'Competition@index'));
    Route::get('admincompetitionsDT/', array('as' => 'admincompetitionsDT', 'uses' => 'Competition@data_table'));
    Route::get('admincompetitions/form', array('as' => 'admincompetitions/form', 'uses' => 'Competition@form'));
    Route::get('admincompetitions/form/{id}', array('as' => 'admincompetitions/form/', 'uses' => 'Competition@form'));
    Route::get('admincompetitions/status/{id}', array('as' => 'admincompetitions/status/', 'uses' => 'Competition@status'));
    Route::get('admincompetitions/delete/{id}', array('as' => 'admincompetitions/delete/', 'uses' => 'Competition@delete'));
    Route::get('admincompetitions/participants/{id}', array('as' => 'admincompetitions/participants/', 'uses' => 'Competition@participants'));
    Route::get('admincompetitions/participantsDT/{id}', array('as' => 'admincompetitions/participantsDT/', 'uses' => 'Competition@parti_data_table'));
    Route::get('admincompetitions/participantstatus/{id}', array('as' => 'admincompetitions/participantstatus/', 'uses' => 'Competition@participantstatus'));
    Route::post('admincompetitions/save', array('as' => 'admincompetitions/save', 'uses' => 'Competition@save'));

    Route::get('adminpages/', array('as' => 'adminpages', 'uses' => 'Pages@index'));
    Route::get('adminpages/form', array('as' => 'adminpages/form', 'uses' => 'Pages@form'));
    Route::get('adminpages/form/{id}', array('as' => 'adminpages/form/', 'uses' => 'Pages@form'));
    Route::get('adminpages/status/{id}', array('as' => 'adminpages/status/', 'uses' => 'Pages@status'));
    Route::get('adminpages/delete/{id}', array('as' => 'adminpages/delete/', 'uses' => 'Pages@delete'));
    Route::post('adminpages/save', array('as' => 'adminpages/save', 'uses' => 'Pages@save'));

    Route::get('adminusers', array('as' => 'adminusers', 'uses' => 'AdminUsers@index'));
    Route::get('adminallusersdata', array('as' => 'getusersdata', 'uses' => 'AdminUsers@getUsersData'));

    Route::get('adminusers/view/{id}', array('as' => 'adminusers/view/', 'uses' => 'AdminUsers@view'));

    Route::get('adminrestmanagers', array('as' => 'adminrestmanagers', 'uses' => 'Rest@emails'));

    Route::get('admins', array('as' => 'admins', 'uses' => 'Admins@index'));
    Route::get('admins/form', array('as' => 'admins/form', 'uses' => 'Admins@form'));
    Route::get('admins/form/{id}', array('as' => 'admins/form/', 'uses' => 'Admins@form'));
    Route::get('admins/status/{id}', array('as' => 'admins/status/', 'uses' => 'Admins@status'));
    Route::get('admins/delete/{id}', array('as' => 'admins/delete/', 'uses' => 'Admins@delete'));
    Route::post('admins/save', array('as' => 'admins/save', 'uses' => 'Admins@save'));
    Route::get('admins/password/{id}', array('as' => 'admins/password/', 'uses' => 'Admins@password'));
    Route::post('admins/savePassword', array('as' => 'admins/savePassword', 'uses' => 'Admins@savePassword'));
    Route::get('admins/permissions/{id}', array('as' => 'admins/permissions/', 'uses' => 'Admins@permissions'));
    Route::post('admins/savePermissions', array('as' => 'admins/savePermissions', 'uses' => 'Admins@savePermissions'));
    Route::get('admins/activity/{id}', array('as' => 'admins/activity/', 'uses' => 'Admins@activity'));
    Route::get('admins/activitydata/{id}', array('as' => 'adminsactivitydata', 'uses' => 'Admins@getAdminActivity'));

    Route::get('adminsettings/', array('as' => 'adminsettings', 'uses' => 'AdminSettings@index'));
    Route::post('adminsettings/save', array('as' => 'adminsettings/save', 'uses' => 'AdminSettings@save'));

    Route::get('adminteam', array('as' => 'adminteam', 'uses' => 'TeamAdminController@index'));
    Route::get('adminteam/form', array('as' => 'adminteam/form', 'uses' => 'TeamAdminController@form'));
    Route::get('adminteam/form/{id}', array('as' => 'adminteam/form/', 'uses' => 'TeamAdminController@form'));
    Route::post('adminteam/save', array('as' => 'adminteam/save', 'uses' => 'TeamAdminController@save'));
    Route::get('adminteam/status/{id}', array('as' => 'adminteam/status/', 'uses' => 'TeamAdminController@status'));
    Route::get('adminteam/delete/{id}', array('as' => 'adminteam/delete/', 'uses' => 'TeamAdminController@delete'));

    Route::get('admintestimonials', array('as' => 'admintestimonials', 'uses' => 'Testimonials@index'));
    Route::get('admintestimonials/form', array('as' => 'admintestimonials/form', 'uses' => 'Testimonials@form'));
    Route::get('admintestimonials/form/{id}', array('as' => 'admintestimonials/form/', 'uses' => 'Testimonials@form'));
    Route::post('admintestimonials/save', array('as' => 'admintestimonials/save', 'uses' => 'Testimonials@save'));
    Route::get('admintestimonials/status/{id}', array('as' => 'admintestimonials/status/', 'uses' => 'Testimonials@status'));
    Route::get('admintestimonials/delete/{id}', array('as' => 'admintestimonials/delete/', 'uses' => 'Testimonials@delete'));

    Route::get('adminsponsors', array('as' => 'adminsponsors', 'uses' => 'Sponsors@index'));
    Route::get('adminsponsors/form', array('as' => 'adminsponsors/form', 'uses' => 'Sponsors@form'));
    Route::get('adminsponsors/form/{id}', array('as' => 'adminsponsors/form/', 'uses' => 'Sponsors@form'));
    Route::post('adminsponsors/save', array('as' => 'adminsponsors/save', 'uses' => 'Sponsors@save'));
    Route::get('adminsponsors/status/{id}', array('as' => 'adminsponsors/status/', 'uses' => 'Sponsors@status'));
    Route::get('adminsponsors/delete/{id}', array('as' => 'adminsponsors/delete/', 'uses' => 'Sponsors@delete'));

    Route::get('adminpress', array('as' => 'adminpress', 'uses' => 'Press@index'));
    Route::get('adminpress/form', array('as' => 'adminpress/form', 'uses' => 'Press@form'));
    Route::get('adminpress/form/{id}', array('as' => 'adminpress/form/', 'uses' => 'Press@form'));
    Route::post('adminpress/save', array('as' => 'adminpress/save', 'uses' => 'Press@save'));
    Route::get('adminpress/status/{id}', array('as' => 'adminpress/status/', 'uses' => 'Press@status'));
    Route::get('adminpress/delete/{id}', array('as' => 'adminpress/delete/', 'uses' => 'Press@delete'));

    Route::get('adminsuggested', array('as' => 'adminsuggested', 'uses' => 'Suggested@index'));
    Route::get('adminsuggestedDT', array('as' => 'adminsuggestedDT', 'uses' => 'Suggested@data_table'));
    Route::get('adminsuggested/status/{id}', array('as' => 'adminsuggested/status/', 'uses' => 'Suggested@status'));

    Route::get('adminfavorites', array('as' => 'adminfavorites', 'uses' => 'Favorites@index'));
    Route::get('adminfavoritesDT', array('as' => 'adminfavoritesDT', 'uses' => 'Favorites@data_table'));
    Route::get('adminfavorites/remove/{id}', array('as' => 'adminfavorites/remove/', 'uses' => 'Favorites@remove'));
    Route::get('adminfavorites/favourite/{id}', array('as' => 'adminfavorites/favourite/', 'uses' => 'Favorites@favourite'));
    Route::get('adminfavorites/form/{id}', array('as' => 'adminfavorites/form/', 'uses' => 'Favorites@form'));
    Route::post('adminfavorites/save', array('as' => 'adminfavorites/save', 'uses' => 'Favorites@save'));

    Route::get('admincuisine', array('as' => 'admincuisine', 'uses' => 'Cuisine@index'));
    Route::get('admincuisineDT', array('as' => 'admincuisineDT', 'uses' => 'Cuisine@data_table'));
    Route::get('admincuisine/form', array('as' => 'admincuisine/form', 'uses' => 'Cuisine@form'));
    Route::get('admincuisine/form/{id}', array('as' => 'admincuisine/form/', 'uses' => 'Cuisine@form'));
    Route::post('admincuisine/save', array('as' => 'admincuisine/save', 'uses' => 'Cuisine@save'));
    Route::get('admincuisine/status/{id}', array('as' => 'admincuisine/status/', 'uses' => 'Cuisine@status'));
    Route::get('admincuisine/delete/{id}', array('as' => 'admincuisine/delete/', 'uses' => 'Cuisine@delete'));
    Route::get('admincuisine/subcuisines/{id}', array('as' => 'admincuisine/subcuisines/', 'uses' => 'Cuisine@subcuisines'));

    Route::get('admincuisine/cuisineform', array('as' => 'admincuisine/cuisineform', 'uses' => 'Cuisine@cuisineform'));
    Route::get('admincuisine/cuisineform/{id}', array('as' => 'admincuisine/cuisineform/', 'uses' => 'Cuisine@cuisineform'));
    Route::post('admincuisine/cuisinesave', array('as' => 'admincuisine/cuisinesave', 'uses' => 'Cuisine@cuisinesave'));
    Route::get('admincuisine/cuisinestatus/{id}', array('as' => 'admincuisine/cuisinestatus/', 'uses' => 'Cuisine@cuisinestatus'));
    Route::get('admincuisine/cuisinedelete/{id}', array('as' => 'admincuisine/cuisinedelete/', 'uses' => 'Cuisine@cuisinedelete'));

    Route::get('adminknownfor', array('as' => 'adminknownfor', 'uses' => 'KnownFor@index'));
    Route::get('adminknownforDT', array('as' => 'adminknownforDT', 'uses' => 'KnownFor@data_table'));
    Route::get('adminknownfor/form', array('as' => 'adminknownfor/form', 'uses' => 'KnownFor@form'));
    Route::get('adminknownfor/form/{id}', array('as' => 'adminknownfor/form/', 'uses' => 'KnownFor@form'));
    Route::post('adminknownfor/save', array('as' => 'adminknownfor/save', 'uses' => 'KnownFor@save'));
    Route::get('adminknownfor/status/{id}', array('as' => 'adminknownfor/status/', 'uses' => 'KnownFor@status'));
    Route::get('adminknownfor/delete/{id}', array('as' => 'adminknownfor/delete/', 'uses' => 'KnownFor@delete'));
    Route::get('adminknownfor/addToFavorite', array('as' => 'adminknownfor/addToFavorite', 'uses' => 'KnownFor@addToFavorite'));

    Route::get('adminreststyle', array('as' => 'adminreststyle', 'uses' => 'RestStyle@index'));
    Route::get('adminreststyleDT', array('as' => 'adminreststyleDT', 'uses' => 'RestStyle@data_table'));
    Route::get('adminreststyle/form', array('as' => 'adminreststyle/form', 'uses' => 'RestStyle@form'));
    Route::get('adminreststyle/form/{id}', array('as' => 'adminreststyle/form/', 'uses' => 'RestStyle@form'));
    Route::post('adminreststyle/save', array('as' => 'adminreststyle/save', 'uses' => 'RestStyle@save'));
    Route::get('adminreststyle/status/{id}', array('as' => 'adminreststyle/status/', 'uses' => 'RestStyle@status'));
    Route::get('adminreststyle/delete/{id}', array('as' => 'adminreststyle/delete/', 'uses' => 'RestStyle@delete'));

    Route::get('adminresttypes', array('as' => 'adminresttypes', 'uses' => 'RestTypes@index'));
    Route::get('adminresttypesDT', array('as' => 'adminresttypesDT', 'uses' => 'RestTypes@data_table'));
    Route::get('adminresttypes/form', array('as' => 'adminresttypes/form', 'uses' => 'RestTypes@form'));
    Route::get('adminresttypes/form/{id}', array('as' => 'adminresttypes/form/', 'uses' => 'RestTypes@form'));
    Route::post('adminresttypes/save', array('as' => 'adminresttypes/save', 'uses' => 'RestTypes@save'));
    Route::get('adminresttypes/status/{id}', array('as' => 'adminresttypes/status/', 'uses' => 'RestTypes@status'));
    Route::get('adminresttypes/delete/{id}', array('as' => 'adminresttypes/delete/', 'uses' => 'RestTypes@delete'));

    Route::get('adminrestservices', array('as' => 'adminrestservices', 'uses' => 'RestServices@index'));
    Route::get('adminrestservicesDT', array('as' => 'adminrestservicesDT', 'uses' => 'RestServices@data_table'));
    Route::get('adminrestservices/form', array('as' => 'adminrestservices/form', 'uses' => 'RestServices@form'));
    Route::get('adminrestservices/form/{id}', array('as' => 'adminrestservices/form/', 'uses' => 'RestServices@form'));
    Route::post('adminrestservices/save', array('as' => 'adminrestservices/save', 'uses' => 'RestServices@save'));
    Route::get('adminrestservices/status/{id}', array('as' => 'adminrestservices/status/', 'uses' => 'RestServices@status'));
    Route::get('adminrestservices/delete/{id}', array('as' => 'adminrestservices/delete/', 'uses' => 'RestServices@delete'));

    Route::get('adminmoodsatmosphere', array('as' => 'adminmoodsatmosphere', 'uses' => 'MoodsAtmosphere@index'));
    Route::get('adminmoodsatmosphereDT', array('as' => 'adminmoodsatmosphereDT', 'uses' => 'MoodsAtmosphere@data_table'));
    Route::get('adminmoodsatmosphere/form', array('as' => 'adminmoodsatmosphere/form', 'uses' => 'MoodsAtmosphere@form'));
    Route::get('adminmoodsatmosphere/form/{id}', array('as' => 'adminmoodsatmosphere/form/', 'uses' => 'MoodsAtmosphere@form'));
    Route::post('adminmoodsatmosphere/save', array('as' => 'adminmoodsatmosphere/save', 'uses' => 'MoodsAtmosphere@save'));
    Route::get('adminmoodsatmosphere/status/{id}', array('as' => 'adminmoodsatmosphere/status/', 'uses' => 'MoodsAtmosphere@status'));
    Route::get('adminmoodsatmosphere/delete/{id}', array('as' => 'adminmoodsatmosphere/delete/', 'uses' => 'MoodsAtmosphere@delete'));

    Route::get('adminofferscategoires', array('as' => 'adminofferscategoires', 'uses' => 'OfferCategories@index'));
    Route::get('adminofferscategoiresDT', array('as' => 'adminofferscategoiresDT', 'uses' => 'OfferCategories@data_table'));
    Route::get('adminofferscategoires/form', array('as' => 'adminofferscategoires/form', 'uses' => 'OfferCategories@form'));
    Route::get('adminofferscategoires/form/{id}', array('as' => 'adminofferscategoires/form/', 'uses' => 'OfferCategories@form'));
    Route::post('adminofferscategoires/save', array('as' => 'adminofferscategoires/save', 'uses' => 'OfferCategories@save'));
    Route::get('adminofferscategoires/status/{id}', array('as' => 'adminofferscategoires/status/', 'uses' => 'OfferCategories@status'));
    Route::get('adminofferscategoires/delete/{id}', array('as' => 'adminofferscategoires/delete/', 'uses' => 'OfferCategories@delete'));


    Route::get('admincountry', array('as' => 'admincountry', 'uses' => 'CountryController@index'));
    Route::get('admincountry/form', array('as' => 'admincountry/form', 'uses' => 'CountryController@form'));
    Route::get('admincountry/form/{id}', array('as' => 'admincountry/form/', 'uses' => 'CountryController@form'));
    Route::post('admincountry/save', array('as' => 'admincountry/save', 'uses' => 'CountryController@save'));
    Route::get('admincountry/status/{id}', array('as' => 'admincountry/status/', 'uses' => 'CountryController@status'));
    Route::get('admincountry/delete/{id}', array('as' => 'admincountry/delete/', 'uses' => 'CountryController@delete'));

    Route::get('admincity', array('as' => 'admincity', 'uses' => 'City@index'));
    Route::get('admincity/form', array('as' => 'admincity/form', 'uses' => 'City@form'));
    Route::get('admincity/form/{id}', array('as' => 'admincity/form/', 'uses' => 'City@form'));
    Route::post('admincity/save', array('as' => 'admincity/save', 'uses' => 'City@save'));
    Route::get('admincity/status/{id}', array('as' => 'admincity/status/', 'uses' => 'City@status'));
    Route::get('admincity/delete/{id}', array('as' => 'admincity/delete/', 'uses' => 'City@delete'));

    Route::get('admindistrict', array('as' => 'admindistrict', 'uses' => 'District@index'));
    Route::get('admindistrict/form', array('as' => 'admindistrict/form', 'uses' => 'District@form'));
    Route::get('admindistrict/form/{id}', array('as' => 'admindistrict/form/', 'uses' => 'District@form'));
    Route::post('admindistrict/save', array('as' => 'admindistrict/save', 'uses' => 'District@save'));
    Route::get('admindistrict/status/{id}', array('as' => 'admindistrict/status/', 'uses' => 'District@status'));
    Route::get('admindistrict/delete/{id}', array('as' => 'admindistrict/delete/', 'uses' => 'District@delete'));

    Route::get('adminlocations', array('as' => 'adminlocations', 'uses' => 'Locations@index'));
    Route::get('adminlocations/form', array('as' => 'adminlocations/form', 'uses' => 'Locations@form'));
    Route::get('adminlocations/form/{id}', array('as' => 'adminlocations/form/', 'uses' => 'Locations@form'));
    Route::post('adminlocations/save', array('as' => 'adminlocations/save', 'uses' => 'Locations@save'));
    Route::get('adminlocations/status/{id}', array('as' => 'adminlocations/status/', 'uses' => 'Locations@status'));
    Route::get('adminlocations/delete/{id}', array('as' => 'adminlocations/delete/', 'uses' => 'Locations@delete'));

    Route::get('admingallery/', array('as' => 'admingallery', 'uses' => 'Gallery@index'));
    Route::get('admingallerydata', array('as' => 'getgallerydata', 'uses' => 'Gallery@getGalleryData'));
    Route::get('adminvideodata', array('as' => 'getVideodata', 'uses' => 'Gallery@getVideosData'));

    Route::get('admingallery/form', array('as' => 'admingallery/form', 'uses' => 'Gallery@form'));
    Route::get('admingallery/form/{id}', array('as' => 'admingallery/form/', 'uses' => 'Gallery@form'));
    Route::get('admingallery/status/{id}', array('as' => 'admingallery/status/', 'uses' => 'Gallery@status'));
    Route::get('admingallery/delete/{id}', array('as' => 'admingallery/delete/', 'uses' => 'Gallery@delete'));
    Route::post('admingallery/save', array('as' => 'admingallery/save', 'uses' => 'Gallery@save'));

    Route::get('admingallery/videostatus/{id}', array('as' => 'admingallery/videostatus/', 'uses' => 'Gallery@videostatus'));
    Route::get('admingallery/videos/', array('as' => 'admingallery/videos', 'uses' => 'Gallery@videos'));
    Route::get('admingallery/videoform', array('as' => 'admingallery/videoform', 'uses' => 'Gallery@videoform'));
    Route::get('admingallery/videoform/{id}', array('as' => 'admingallery/videoform/', 'uses' => 'Gallery@videoform'));

    Route::get('admingallery/videodelete/{id}', array('as' => 'admingallery/videodelete/', 'uses' => 'Gallery@videodelete'));
    Route::post('admingallery/videosave', array('as' => 'admingallery/videosave', 'uses' => 'Gallery@videosave'));

    Route::get('adminarticles/', array('as' => 'adminarticles', 'uses' => 'Article@index'));
    Route::get('adminarticlesDT/', array('as' => 'adminarticlesDT', 'uses' => 'Article@data_table'));

    Route::get('adminarticles/articles/{id}', array('as' => 'adminarticles/articles/', 'uses' => 'Article@articles'));

    Route::get('adminarticles/articleform/{id}', array('as' => 'adminarticles/articleform/', 'uses' => 'Article@articleform'));
    Route::get('adminarticles/articleform', array('as' => 'adminarticles/articleform', 'uses' => 'Article@articleform'));

    Route::post('adminarticles/articlesave', array('as' => 'adminarticles/articlesave', 'uses' => 'Article@articlesave'));
    Route::get('adminarticles/articlestatus/{id}', array('as' => 'adminarticles/articlestatus/', 'uses' => 'Article@articlestatus'));
    Route::get('adminarticles/articledelete/{id}', array('as' => 'adminarticles/articledelete/', 'uses' => 'Article@articledelete'));

    Route::get('adminarticles/form', array('as' => 'adminarticles/form', 'uses' => 'Article@form'));
    Route::get('adminarticles/form/{id}', array('as' => 'adminarticles/form/', 'uses' => 'Article@form'));
    Route::get('adminarticles/status/{id}', array('as' => 'adminarticles/status/', 'uses' => 'Article@status'));
    Route::get('adminarticles/delete/{id}', array('as' => 'adminarticles/delete/', 'uses' => 'Article@delete'));
    Route::post('adminarticles/save', array('as' => 'adminarticles/save', 'uses' => 'Article@save'));

    Route::get('adminarticles/slideformtab', array('as' => 'adminarticles/slideformtab', 'uses' => 'Article@slideformtab'));
    Route::get('adminarticles/slidedelete/{id}', array('as' => 'adminarticles/slidedelete/', 'uses' => 'Article@slidedelete'));
    Route::get('adminarticles/slideform', array('as' => 'adminarticles/slideform', 'uses' => 'Article@slideform'));
    Route::get('adminarticles/slideform/{id}', array('as' => 'adminarticles/slideform/', 'uses' => 'Article@slideform'));
    Route::post('adminarticles/saveslide', array('as' => 'adminarticles/saveslide', 'uses' => 'Article@saveslide'));

    Route::post('adminarticles/updateposition', array('as' => 'adminarticles/updateposition', 'uses' => 'Article@updateposition'));

    Route::get('adminnewsletter/', array('as' => 'adminnewsletter', 'uses' => 'NewsletterController@index'));
    Route::get('adminnewsletterdata', array('as' => 'adminnewsletterdata', 'uses' => 'NewsletterController@getNewsLetterData'));

    Route::get('adminnewsletter/form', array('as' => 'adminnewsletter/form', 'uses' => 'NewsletterController@form'));
    Route::get('adminnewsletter/form/{id}', array('as' => 'adminnewsletter/form/', 'uses' => 'NewsletterController@form'));
    Route::get('adminnewsletter/status/{id}', array('as' => 'adminnewsletter/status/', 'uses' => 'NewsletterController@status'));
    Route::get('adminnewsletter/delete/{id}', array('as' => 'adminnewsletter/delete/', 'uses' => 'NewsletterController@delete'));
    Route::post('adminnewsletter/save', array('as' => 'adminnewsletter/save', 'uses' => 'NewsletterController@save'));

    Route::get('adminnewsletter/getAjaxCount', array('as' => 'adminnewsletter/getAjaxCount', 'uses' => 'NewsletterController@getAjaxCount'));

    Route::get('admineventcalendar/', array('as' => 'admineventcalendar', 'uses' => 'EventCalendarController@index'));
    Route::get('admineventscalendardata', array('as' => 'admineventscalendardata', 'uses' => 'EventCalendarController@getEventsData'));

    Route::get('admineventcalendar/form', array('as' => 'admineventcalendar/form', 'uses' => 'EventCalendarController@form'));
    Route::get('admineventcalendar/form/{id}', array('as' => 'admineventcalendar/form/', 'uses' => 'EventCalendarController@form'));
    Route::get('admineventcalendar/status/{id}', array('as' => 'admineventcalendar/status/', 'uses' => 'EventCalendarController@status'));
    Route::get('admineventcalendar/delete/{id}', array('as' => 'admineventcalendar/delete/', 'uses' => 'EventCalendarController@delete'));
    Route::get('admineventcalendar/view/{id}', array('as' => 'admineventcalendar/view/', 'uses' => 'EventCalendarController@view'));
    Route::post('admineventcalendar/save', array('as' => 'admineventcalendar/save', 'uses' => 'EventCalendarController@save'));

    Route::get('adminartkwork', array('as' => 'adminartkwork', 'uses' => 'ArtWorkController@index'));
    Route::get('adminartkworkdata', array('as' => 'get_artwork_data', 'uses' => 'ArtWorkController@getArtworkData'));
    Route::get('adminartkwork/form', array('as' => 'adminartkwork/form', 'uses' => 'ArtWorkController@form'));
    Route::get('adminartkwork/form/{id}', array('as' => 'adminartkwork/form/', 'uses' => 'ArtWorkController@form'));
    Route::post('adminartkwork/save', array('as' => 'adminartkwork/save', 'uses' => 'ArtWorkController@save'));
    Route::get('adminartkwork/status/{id}', array('as' => 'adminartkwork/status/', 'uses' => 'ArtWorkController@status'));
    Route::get('adminartkwork/delete/{id}', array('as' => 'adminartkwork/delete/', 'uses' => 'ArtWorkController@delete'));

    Route::get('admincategoryartwork', array('as' => 'admincategoryartwork', 'uses' => 'Banners@category'));
    Route::get('admincategoryartworkdata', array('as' => 'admincategoryartworkdata', 'uses' => 'Banners@getCategoryData'));

    Route::get('admincategoryartwork/form', array('as' => 'admincategoryartwork/form', 'uses' => 'Banners@categoryform'));
    Route::get('admincategoryartwork/form/{id}', array('as' => 'admincategoryartwork/form/', 'uses' => 'Banners@categoryform'));
    Route::post('admincategoryartwork/save', array('as' => 'admincategoryartwork/save', 'uses' => 'Banners@categorysave'));
    Route::get('admincategoryartwork/status/{id}', array('as' => 'admincategoryartwork/status/', 'uses' => 'Banners@categorystatus'));
    Route::get('admincategoryartwork/delete/{id}', array('as' => 'admincategoryartwork/delete/', 'uses' => 'Banners@categorydelete'));

    Route::get('adminbanners', array('as' => 'adminbanners', 'uses' => 'Banners@index'));
    Route::get('adminbannersdata', array('as' => 'adminbannersdata', 'uses' => 'Banners@getBannerData'));
    Route::get('adminbanners/form', array('as' => 'adminbanners/form', 'uses' => 'Banners@form'));
    Route::get('adminbanners/form/{id}', array('as' => 'adminbanners/form/', 'uses' => 'Banners@form'));
    Route::post('adminbanners/save', array('as' => 'adminbanners/save', 'uses' => 'Banners@save'));
    Route::get('adminbanners/status/{id}', array('as' => 'adminbanners/status/', 'uses' => 'Banners@status'));
    Route::get('adminbanners/delete/{id}', array('as' => 'adminbanners/delete/', 'uses' => 'Banners@delete'));

    Route::get('adminmessages', array('as' => 'adminmessages', 'uses' => 'Messages@index'));
    Route::get('adminmessages/form', array('as' => 'adminmessages/form', 'uses' => 'Messages@form'));
    Route::get('adminmessages/form/{id}', array('as' => 'adminmessages/form/', 'uses' => 'Messages@form'));
    Route::post('adminmessages/save', array('as' => 'adminmessages/save', 'uses' => 'Messages@save'));
    Route::get('adminmessages/status/{id}', array('as' => 'adminmessages/status/', 'uses' => 'Messages@status'));
    Route::get('adminmessages/delete/{id}', array('as' => 'adminmessages/delete/', 'uses' => 'Messages@delete'));

    Route::get('adminajax/getCitiesList/{id}', array('as' => 'adminajax/getCitiesList/', 'uses' => 'Ajax@getCitiesList'));

    Route::get('adminrecipe/', array('as' => 'adminrecipe', 'uses' => 'Recipe@index'));
    Route::get('adminrecipeDT/', array('as' => 'adminrecipeDT', 'uses' => 'Recipe@data_table'));
    Route::get('adminrecipe/form', array('as' => 'adminrecipe/form', 'uses' => 'Recipe@form'));
    Route::get('adminrecipe/form/{id}', array('as' => 'adminrecipe/form/', 'uses' => 'Recipe@form'));
    Route::get('adminrecipe/status/{id}', array('as' => 'adminrecipe/status/', 'uses' => 'Recipe@status'));
    Route::get('adminrecipe/delete/{id}', array('as' => 'adminrecipe/delete/', 'uses' => 'Recipe@delete'));
    Route::post('adminrecipe/save', array('as' => 'adminrecipe/save', 'uses' => 'Recipe@save'));


    Route::get('admincalendar/', array('as' => 'admincalendar', 'uses' => 'Calendar@index'));


    Route::get('adminpolls', array('as' => 'adminpolls', 'uses' => 'RestPoll@index'));
    Route::get('adminpollform', array('as' => 'adminpollform', 'uses' => 'RestPoll@form'));
    Route::get('adminpollform/{id}', array('as' => 'adminpollform/', 'uses' => 'RestPoll@form'));
    Route::get('adminpolloptions/{id}', array('as' => 'adminpolloptions/', 'uses' => 'RestPoll@options'));
    Route::get('adminpolloptionform', array('as' => 'adminpolloptionform', 'uses' => 'RestPoll@optionform'));
    Route::get('adminpolloptionform/{id}', array('as' => 'adminpolloptionform/', 'uses' => 'RestPoll@optionform'));
    Route::post('adminpolloptionsave/{id}', array('as' => 'adminpolloptionsave/', 'uses' => 'RestPoll@optionform'));
    Route::get('adminpolloptiondelete/{id}', array('as' => 'adminpolloptiondelete/', 'uses' => 'RestPoll@optiondelete'));
    Route::get('adminpolloptionstatus/{id}', array('as' => 'adminpolloptionstatus/', 'uses' => 'RestPoll@optionstatus'));
    Route::post('adminpollsave', array('as' => 'adminpollsave', 'uses' => 'RestPoll@save'));
    Route::get('adminpolldelete/{id}', array('as' => 'adminpolldelete/', 'uses' => 'RestPoll@delete'));
    Route::get('adminpollstatus/{id}', array('as' => 'adminpollstatus/', 'uses' => 'RestPoll@status'));


    Route::get('admincomments', array('as' => 'admincomments', 'uses' => 'AdminComments@index'));
    Route::get('admincommentsDT', array('as' => 'admincommentsDT', 'uses' => 'AdminComments@data_table'));
    Route::get('admincomments/view/{id}', array('as' => 'admincomments/view/', 'uses' => 'AdminComments@view'));
    Route::post('admincomments/save', array('as' => 'admincomments/save', 'uses' => 'AdminComments@save'));
    Route::get('admincomments/delete/{id}', array('as' => 'admincomments/delete/', 'uses' => 'AdminComments@delete'));
    Route::get('admincomments/status/{id}', array('as' => 'admincomments/status/', 'uses' => 'AdminComments@status'));
    Route::get('admincomments/read/{id}', array('as' => 'admincomments/read/', 'uses' => 'AdminComments@read'));

    Route::get('adminarticlecomments', array('as' => 'adminarticlecomments', 'uses' => 'AdminComments@artcat'));
    Route::get('adminarticlecommentsDT', array('as' => 'adminarticlecommentsDT', 'uses' => 'AdminComments@artcat_data_table'));
    Route::get('adminarticlecomments/view/{id}', array('as' => 'adminarticlecomments/view/', 'uses' => 'AdminComments@art'));
    Route::get('adminarticlecomments/delete/{id}', array('as' => 'adminarticlecomments/delete/', 'uses' => 'AdminComments@artdelete'));
    Route::get('adminarticlecomments/status/{id}', array('as' => 'adminarticlecomments/status/', 'uses' => 'AdminComments@artstatus'));
    Route::get('adminarticlecomments/read/{id}', array('as' => 'adminarticlecomments/read/', 'uses' => 'AdminComments@artread'));

    Route::get('adminmenurequest', array('as' => 'adminmenurequest', 'uses' => 'MenuRequest@index'));
    Route::get('adminmenurequest/view/{id}', array('as' => 'adminmenurequest/view/', 'uses' => 'MenuRequest@view'));

    Route::get('adminoccasions/', array('as' => 'adminoccasions', 'uses' => 'Occasions@index'));
    Route::get('adminoccasionsDT/', array('as' => 'adminoccasionsDT', 'uses' => 'Occasions@data_table'));
    Route::get('adminoccasions/forwardrest/{id}', array('as' => 'adminoccasions/forwardrest/', 'uses' => 'Occasions@forwardrest'));
    Route::post('adminoccasions/sendtorest', array('as' => 'adminoccasions/sendtorest', 'uses' => 'Occasions@sendtorest'));
    Route::get('adminoccasions/view/{id}', array('as' => 'adminoccasions/view/', 'uses' => 'Occasions@view'));
    Route::get('adminoccasions/approved/{id}', array('as' => 'adminoccasions/approved/', 'uses' => 'Occasions@approved'));
    Route::get('adminoccasions/cancel/{id}', array('as' => 'adminoccasions/cancel/', 'uses' => 'Occasions@cancel'));
    Route::get('adminoccasions/read/{id}', array('as' => 'adminoccasions/read/', 'uses' => 'Occasions@read'));
    Route::get('adminoccasions/status/{id}', array('as' => 'adminoccasions/status/', 'uses' => 'Occasions@status'));
    Route::get('adminoccasions/delete/{id}', array('as' => 'adminoccasions/delete/', 'uses' => 'Occasions@delete'));
    Route::post('adminoccasions/save', array('as' => 'adminoccasions/save', 'uses' => 'Occasions@save'));

    Route::post('chart/year', array('as' => 'chart/year', 'uses' => 'Dashboard@visitors_chart'));
});
