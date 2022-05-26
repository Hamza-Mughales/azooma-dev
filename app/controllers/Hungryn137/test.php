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

$countries = array('sa', 'lb', 'uk');
$languages = array('ar');
$country = Request::segment(1);

if (in_array($country, $countries)) {
    Route::group(array('prefix' => $country), function () {
        $languages = array('en', 'ar');
        $locale = Request::segment(2);

        if (in_array($locale, $languages)) {
            Cookie::forever('lang', $locale);
            Route::group(array('prefix' => $locale), function () {
                Route::get('/', array('as' => 'home', 'uses' => 'home@index'));
            });
        }

        Route::group(array('prefix' => 'hungryn137'), function () {

            Route::get('/', array('as' => 'adminhome', 'uses' => 'DashboardAdmin@index'));
            Route::get('adminlogin', array('as' => 'adminlogin', 'uses' => 'LoginAdmin@index'));
            Route::post('adminlogin', array('uses' => 'LoginAdmin@postSubmit'));

            Route::get('adminlogout', array('as' => 'adminlogout', 'uses' => 'LoginAdmin@logout'));
            Route::get('dashboard/', array('as' => 'dashboard', 'uses' => 'DashboardAdmin@index'));

            Route::get('adminpages/', array('as' => 'adminpages', 'uses' => 'PagesAdmin@index'));
            Route::get('adminpages/form', array('as' => 'adminpages/form', 'uses' => 'PagesAdmin@form'));
            Route::get('adminpages/form/{id}', array('as' => 'adminpages/form/', 'uses' => 'PagesAdmin@form'));
            Route::get('adminpages/status/{id}', array('as' => 'adminpages/status/', 'uses' => 'PagesAdmin@status'));
            Route::get('adminpages/delete/{id}', array('as' => 'adminpages/delete/', 'uses' => 'PagesAdmin@delete'));
            Route::post('adminpages/save', array('as' => 'adminpages/save', 'uses' => 'PagesAdmin@save'));

            Route::get('admins', array('as' => 'admins', 'uses' => 'AdminsAdmin@index'));
            Route::get('admins/form', array('as' => 'admins/form', 'uses' => 'AdminsAdmin@form'));
            Route::get('admins/form/{id}', array('as' => 'admins/form/', 'uses' => 'AdminsAdmin@form'));
            Route::get('admins/status/{id}', array('as' => 'admins/status/', 'uses' => 'AdminsAdmin@status'));
            Route::get('admins/delete/{id}', array('as' => 'admins/delete/', 'uses' => 'AdminsAdmin@delete'));
            Route::post('admins/save', array('as' => 'admins/save', 'uses' => 'AdminsAdmin@save'));
            Route::get('admins/password/{id}', array('as' => 'admins/password/', 'uses' => 'AdminsAdmin@password'));
            Route::post('admins/savePassword', array('as' => 'admins/savePassword', 'uses' => 'AdminsAdmin@savePassword'));
            Route::get('admins/permissions/{id}', array('as' => 'admins/permissions/', 'uses' => 'AdminsAdmin@permissions'));
            Route::post('admins/savePermissions', array('as' => 'admins/savePermissions', 'uses' => 'AdminsAdmin@savePermissions'));
            Route::get('admins/activity/{id}', array('as' => 'admins/activity/', 'uses' => 'AdminsAdmin@activity'));

            Route::get('adminsettings/', array('as' => 'adminsettings', 'uses' => 'SettingsAdmin@index'));
            Route::post('adminsettings/save', array('as' => 'adminsettings/save', 'uses' => 'SettingsAdmin@save'));

            Route::get('adminteam', array('as' => 'adminteam', 'uses' => 'TeamAdmin@index'));
            Route::get('adminteam/form', array('as' => 'adminteam/form', 'uses' => 'TeamAdmin@form'));
            Route::get('adminteam/form/{id}', array('as' => 'adminteam/form/', 'uses' => 'TeamAdmin@form'));
            Route::post('adminteam/save', array('as' => 'adminteam/save', 'uses' => 'TeamAdmin@save'));
            Route::get('adminteam/status/{id}', array('as' => 'adminteam/status/', 'uses' => 'TeamAdmin@status'));
            Route::get('adminteam/delete/{id}', array('as' => 'adminteam/delete/', 'uses' => 'TeamAdmin@delete'));


            Route::get('admintestimonials', array('as' => 'admintestimonials', 'uses' => 'TestimonialsAdmin@index'));
            Route::get('admintestimonials/form', array('as' => 'admintestimonials/form', 'uses' => 'TestimonialsAdmin@form'));
            Route::get('admintestimonials/form/{id}', array('as' => 'admintestimonials/form/', 'uses' => 'TestimonialsAdmin@form'));
            Route::post('admintestimonials/save', array('as' => 'admintestimonials/save', 'uses' => 'TestimonialsAdmin@save'));
            Route::get('admintestimonials/status/{id}', array('as' => 'admintestimonials/status/', 'uses' => 'TestimonialsAdmin@status'));
            Route::get('admintestimonials/delete/{id}', array('as' => 'admintestimonials/delete/', 'uses' => 'TestimonialsAdmin@delete'));


            Route::get('adminsponsors', array('as' => 'adminsponsors', 'uses' => 'SponsorsAdmin@index'));
            Route::get('adminsponsors/form', array('as' => 'adminsponsors/form', 'uses' => 'SponsorsAdmin@form'));
            Route::get('adminsponsors/form/{id}', array('as' => 'adminsponsors/form/', 'uses' => 'SponsorsAdmin@form'));
            Route::post('adminsponsors/save', array('as' => 'adminsponsors/save', 'uses' => 'SponsorsAdmin@save'));
            Route::get('adminsponsors/status/{id}', array('as' => 'adminsponsors/status/', 'uses' => 'SponsorsAdmin@status'));
            Route::get('adminsponsors/delete/{id}', array('as' => 'adminsponsors/delete/', 'uses' => 'SponsorsAdmin@delete'));


            Route::get('adminpress', array('as' => 'adminpress', 'uses' => 'PressAdmin@index'));
            Route::get('adminpress/form', array('as' => 'adminpress/form', 'uses' => 'PressAdmin@form'));
            Route::get('adminpress/form/{id}', array('as' => 'adminpress/form/', 'uses' => 'PressAdmin@form'));
            Route::post('adminpress/save', array('as' => 'adminpress/save', 'uses' => 'PressAdmin@save'));
            Route::get('adminpress/status/{id}', array('as' => 'adminpress/status/', 'uses' => 'PressAdmin@status'));
            Route::get('adminpress/delete/{id}', array('as' => 'adminpress/delete/', 'uses' => 'PressAdmin@delete'));

            Route::get('adminsuggested', array('as' => 'adminsuggested', 'uses' => 'SuggestedAdmin@index'));
            Route::get('adminsuggested/status/{id}', array('as' => 'adminsuggested/status/', 'uses' => 'SuggestedAdmin@status'));

            Route::get('adminfavorites', array('as' => 'adminfavorites', 'uses' => 'FavoritesAdmin@index'));
            Route::get('adminfavorites/remove/{id}', array('as' => 'adminfavorites/remove/', 'uses' => 'FavoritesAdmin@remove'));
            Route::get('adminfavorites/form/{id}', array('as' => 'adminfavorites/form/', 'uses' => 'FavoritesAdmin@form'));
            Route::post('adminfavorites/save', array('as' => 'adminfavorites/save', 'uses' => 'FavoritesAdmin@save'));

            Route::get('admincuisine', array('as' => 'admincuisine', 'uses' => 'CuisineAdmin@index'));
            Route::get('admincuisine/form', array('as' => 'admincuisine/form', 'uses' => 'CuisineAdmin@form'));
            Route::get('admincuisine/form/{id}', array('as' => 'admincuisine/form/', 'uses' => 'CuisineAdmin@form'));
            Route::post('admincuisine/save', array('as' => 'admincuisine/save', 'uses' => 'CuisineAdmin@save'));
            Route::get('admincuisine/status/{id}', array('as' => 'admincuisine/status/', 'uses' => 'CuisineAdmin@status'));
            Route::get('admincuisine/delete/{id}', array('as' => 'admincuisine/delete/', 'uses' => 'CuisineAdmin@delete'));
            Route::get('admincuisine/subcuisines/{id}', array('as' => 'admincuisine/subcuisines/', 'uses' => 'CuisineAdmin@subcuisines'));

            Route::get('admincuisine/cuisineform', array('as' => 'admincuisine/cuisineform', 'uses' => 'CuisineAdmin@cuisineform'));
            Route::get('admincuisine/cuisineform/{id}', array('as' => 'admincuisine/cuisineform/', 'uses' => 'CuisineAdmin@cuisineform'));
            Route::post('admincuisine/cuisinesave', array('as' => 'admincuisine/cuisinesave', 'uses' => 'CuisineAdmin@cuisinesave'));
            Route::get('admincuisine/cuisinestatus/{id}', array('as' => 'admincuisine/cuisinestatus/', 'uses' => 'CuisineAdmin@cuisinestatus'));
            Route::get('admincuisine/cuisinedelete/{id}', array('as' => 'admincuisine/cuisinedelete/', 'uses' => 'CuisineAdmin@cuisinedelete'));


            Route::get('adminknownfor', array('as' => 'adminknownfor', 'uses' => 'KnownForAdmin@index'));
            Route::get('adminknownfor/form', array('as' => 'adminknownfor/form', 'uses' => 'KnownForAdmin@form'));
            Route::get('adminknownfor/form/{id}', array('as' => 'adminknownfor/form/', 'uses' => 'KnownForAdmin@form'));
            Route::post('adminknownfor/save', array('as' => 'adminknownfor/save', 'uses' => 'KnownForAdmin@save'));
            Route::get('adminknownfor/status/{id}', array('as' => 'adminknownfor/status/', 'uses' => 'KnownForAdmin@status'));
            Route::get('adminknownfor/delete/{id}', array('as' => 'adminknownfor/delete/', 'uses' => 'KnownForAdmin@delete'));
            Route::get('adminknownfor/addToFavorite', array('as' => 'adminknownfor/addToFavorite', 'uses' => 'KnownForAdmin@addToFavorite'));


            Route::get('adminreststyle', array('as' => 'adminreststyle', 'uses' => 'RestStyle@index'));
            Route::get('adminreststyle/form', array('as' => 'adminreststyle/form', 'uses' => 'RestStyle@form'));
            Route::get('adminreststyle/form/{id}', array('as' => 'adminreststyle/form/', 'uses' => 'RestStyle@form'));
            Route::post('adminreststyle/save', array('as' => 'adminreststyle/save', 'uses' => 'RestStyle@save'));
            Route::get('adminreststyle/status/{id}', array('as' => 'adminreststyle/status/', 'uses' => 'RestStyle@status'));
            Route::get('adminreststyle/delete/{id}', array('as' => 'adminreststyle/delete/', 'uses' => 'RestStyle@delete'));


            Route::get('adminresttypes', array('as' => 'adminresttypes', 'uses' => 'RestTypes@index'));
            Route::get('adminresttypes/form', array('as' => 'adminresttypes/form', 'uses' => 'RestTypes@form'));
            Route::get('adminresttypes/form/{id}', array('as' => 'adminresttypes/form/', 'uses' => 'RestTypes@form'));
            Route::post('adminresttypes/save', array('as' => 'adminresttypes/save', 'uses' => 'RestTypes@save'));
            Route::get('adminresttypes/status/{id}', array('as' => 'adminresttypes/status/', 'uses' => 'RestTypes@status'));
            Route::get('adminresttypes/delete/{id}', array('as' => 'adminresttypes/delete/', 'uses' => 'RestTypes@delete'));


            Route::get('adminrestservices', array('as' => 'adminrestservices', 'uses' => 'RestServices@index'));
            Route::get('adminrestservices/form', array('as' => 'adminrestservices/form', 'uses' => 'RestServices@form'));
            Route::get('adminrestservices/form/{id}', array('as' => 'adminrestservices/form/', 'uses' => 'RestServices@form'));
            Route::post('adminrestservices/save', array('as' => 'adminrestservices/save', 'uses' => 'RestServices@save'));
            Route::get('adminrestservices/status/{id}', array('as' => 'adminrestservices/status/', 'uses' => 'RestServices@status'));
            Route::get('adminrestservices/delete/{id}', array('as' => 'adminrestservices/delete/', 'uses' => 'RestServices@delete'));

            Route::get('adminofferscategoires', array('as' => 'adminofferscategoires', 'uses' => 'OfferCategories@index'));
            Route::get('adminofferscategoires/form', array('as' => 'adminofferscategoires/form', 'uses' => 'OfferCategories@form'));
            Route::get('adminofferscategoires/form/{id}', array('as' => 'adminofferscategoires/form/', 'uses' => 'OfferCategories@form'));
            Route::post('adminofferscategoires/save', array('as' => 'adminofferscategoires/save', 'uses' => 'OfferCategories@save'));
            Route::get('adminofferscategoires/status/{id}', array('as' => 'adminofferscategoires/status/', 'uses' => 'OfferCategories@status'));
            Route::get('adminofferscategoires/delete/{id}', array('as' => 'adminofferscategoires/delete/', 'uses' => 'OfferCategories@delete'));


            Route::get('admincity', array('as' => 'admincity', 'uses' => 'AdminCity@index'));
            Route::get('admincity/form', array('as' => 'admincity/form', 'uses' => 'AdminCity@form'));
            Route::get('admincity/form/{id}', array('as' => 'admincity/form/', 'uses' => 'AdminCity@form'));
            Route::post('admincity/save', array('as' => 'admincity/save', 'uses' => 'AdminCity@save'));
            Route::get('admincity/status/{id}', array('as' => 'admincity/status/', 'uses' => 'AdminCity@status'));
            Route::get('admincity/delete/{id}', array('as' => 'admincity/delete/', 'uses' => 'AdminCity@delete'));

            Route::get('admindistrict', array('as' => 'admindistrict', 'uses' => 'AdminDistrict@index'));
            Route::get('admindistrict/form', array('as' => 'admindistrict/form', 'uses' => 'AdminDistrict@form'));
            Route::get('admindistrict/form/{id}', array('as' => 'admindistrict/form/', 'uses' => 'AdminDistrict@form'));
            Route::post('admindistrict/save', array('as' => 'admindistrict/save', 'uses' => 'AdminDistrict@save'));
            Route::get('admindistrict/status/{id}', array('as' => 'admindistrict/status/', 'uses' => 'AdminDistrict@status'));
            Route::get('admindistrict/delete/{id}', array('as' => 'admindistrict/delete/', 'uses' => 'AdminDistrict@delete'));

            Route::get('adminlocations', array('as' => 'adminlocations', 'uses' => 'AdminLocations@index'));
            Route::get('adminlocations/form', array('as' => 'adminlocations/form', 'uses' => 'AdminLocations@form'));
            Route::get('adminlocations/form/{id}', array('as' => 'adminlocations/form/', 'uses' => 'AdminLocations@form'));
            Route::post('adminlocations/save', array('as' => 'adminlocations/save', 'uses' => 'AdminLocations@save'));
            Route::get('adminlocations/status/{id}', array('as' => 'adminlocations/status/', 'uses' => 'AdminLocations@status'));
            Route::get('adminlocations/delete/{id}', array('as' => 'adminlocations/delete/', 'uses' => 'AdminLocations@delete'));


            Route::get('admincalendar/', array('as' => 'admincalendar', 'uses' => 'CalendarAdmin@index'));
        });


        Route::get('/', array('as' => 'home', 'uses' => 'home@index'));
    });
} else {
    $arg1 = Request::segment(1);
    if (in_array($arg1, $languages)) {
        App::setLocale($arg1);
        $locale = $arg1;
    } else {
        $locale = null;
        App::setLocale('en');
    }
    Route::group(array('prefix' => $locale), function () {
        $locale = Config::get('app.locale');
        $var1 = Request::segment(1);
        if ($locale == "ar") {
            $var1 = Request::segment(2);
        }
        $normalpages = array('', 'privacy', 'login', 'videos', 'video', 'user', 'add', 'settings', 'userhelp', 'updatedb', 'blog', 'recipes', 'article', 'locations', 'forgot', 'reset', 'resetpassword', 'logout', 'dashboard', 'reactivate', 'welcome', 'preference', 'ajax');
        if (in_array($var1, $normalpages)) {
            Route::get('', array('as' => 'home', 'uses' => 'HomeController@index'));
            Route::get('login', array('as' => 'login', 'uses' => 'LoginController@index'));
            Route::post('login/l', array('as' => 'login/l', 'before' => 'csrf', 'uses' => 'LoginController@l'));
            Route::post('login/f', array('as' => 'login/f', 'uses' => 'LoginController@f'));
            Route::post('login/r', array('as' => 'login/r', 'uses' => 'LoginController@register'));
            Route::get('forgot', array('as' => 'forgot', 'uses' => 'LoginController@forgot'));
            Route::post('resetpassword', array('as' => 'resetpassword', 'uses' => 'LoginController@resetPassword'));
            Route::get('reset/{rand?}', array('as' => 'reset', 'uses' => 'LoginController@reset'));
            Route::get('privacy', array('as' => 'privacy', 'uses' => 'PrivacyController@index'));
            Route::get('videos', array('as' => 'videos', 'uses' => 'GalleryController@videos'));
            Route::get('video/{id}', array('as' => 'video', 'uses' => 'GalleryController@video'));
            Route::any('settings/{id?}', array('as' => 'settings', 'uses' => 'UserController@settings'));
            Route::get('userhelp/{any}', array('as' => 'userhelp', 'uses' => 'UserController@helper'));
            Route::get('user/{id}', array('as' => 'user', 'uses' => 'UserController@index'));
            Route::get('add/t', array('as' => 'add/t', 'uses' => 'AddController@t'));
            Route::post('add/articlecomment', array('as' => 'add/articlecomment', 'uses' => 'AddController@addComment'));
            Route::post('add/recipecomment', array('as' => 'add/recipecomment', 'uses' => 'AddController@addComment'));
            Route::get('add/reciperecommend', array('as' => 'add/reciperecommend', 'uses' => 'AddController@recommendRecipe'));
            Route::get('add/photo', array('as' => 'add/photo', 'uses' => 'AddController@AddPhoto'));
            Route::get('blog/{category?}', array('as' => 'blog', 'uses' => 'BlogController@index'));
            Route::get('article/{url}', array('as' => 'article', 'uses' => 'BlogController@article'));
            Route::get('recipes/{recipe?}', array('as' => 'recipe', 'uses' => 'BlogController@recipes'));
            Route::get('updatedb/updatecity', array('as' => 'updatedb', 'uses' => 'UpdateDbController@updateCity'));
            Route::get('locations', array('as' => 'locations', 'uses' => 'AjaxController@locations'));
            Route::get('logout', array('as' => 'logout', 'uses' => 'LoginController@logout'));
            Route::get('dashboard/{id}', array('as' => 'dashboard', 'uses' => 'DashboardController@index'));
            Route::get('reactivate/{id}', array('as' => 'reactivate', 'uses' => 'LoginController@reactivate'));
            Route::get('welcome/{id}', array('as' => 'welcome', 'uses' => 'LoginController@welcome'));
            Route::post('preference/{step}', array('as' => 'preference', 'uses' => 'DashboardController@save'));
            Route::post('ajax/follow', array('as' => 'ajax/follow', 'uses' => 'AjaxController@follow'));
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
                        Route::get('', array('as' => 'city', 'uses' => 'CityController@index'));
                    } else {
                        $normalurls = array('home-delivery', 'fine-dining', 'catering', 'sheesha', 'menu', 'find', 'cuisines', 'localities', 'hotels', 'recent', 'recommended', 'latest', 'popular', 'menu', 'add-restaurant', 'photo', 'q', 'gallery', 'photos', 'aj', 'offers', 'offer', 'hotel');
                        if (in_array($arg2, $normalurls)) {
                            Route::get('home-delivery/', array('as' => 'home-delivery', 'uses' => 'PopularController@index'));
                            Route::get('fine-dining/', array('as' => 'fine-dining', 'uses' => 'PopularController@index'));
                            Route::get('catering/', array('as' => 'catering', 'uses' => 'PopularController@index'));
                            Route::get('sheesha/', array('as' => 'sheesha', 'uses' => 'PopularController@index'));
                            Route::get('menu/', array('as' => 'menu', 'uses' => 'PopularController@index'));
                            Route::get('latest/', array('as' => 'latest', 'uses' => 'PopularController@index'));
                            Route::get('popular/', array('as' => 'popular', 'uses' => 'PopularController@index'));
                            Route::get('recommended/', array('as' => 'new', 'uses' => 'PopularController@index'));
                            Route::get('recent/', array('as' => 'recent', 'uses' => 'PopularController@index'));
                            Route::get('hotels/', array('as' => 'hotels', 'uses' => 'HotelController@index'));
                            Route::get('find/{query}', array('as' => 'find', 'uses' => 'SearchController@index'));
                            Route::get('cuisines', array('as' => 'cuisines', 'uses' => 'CuisineController@index'));
                            Route::get('localities', array('as' => 'localities', 'uses' => 'LocalityController@index'));
                            Route::get('add-restaurant', array('as' => 'add-restaurant', 'uses' => 'AddController@index'));
                            Route::get('photo/{image}', array('as' => 'photo', 'uses' => 'PhotoController@index'));
                            Route::get('q', array('as' => 'q', 'uses' => 'QController@index'));
                            Route::get('gallery', array('as' => 'gallery', 'uses' => 'GalleryController@index'));
                            Route::get('photos', array('as' => 'photos', 'uses' => 'GalleryController@photos'));
                            Route::get('aj/c/{rest}/{loaded}', array('as' => 'aj', 'uses' => 'AjaxController@comments'));
                            Route::get('aj/g/{rest}/{loaded}', array('as' => 'add', 'uses' => 'AjaxController@gallery'));
                            Route::post('aj/comment', array('as' => 'aj/comment', 'uses' => 'AjaxController@addComment'));
                            Route::post('aj/rating', array('as' => 'aj/rating', 'uses' => 'AjaxController@addRating'));
                            Route::post('aj/photo', array('as' => 'aj/rating', 'uses' => 'AjaxController@addPhoto'));
                            Route::post('aj/addtolist', array('as' => 'aj/addtolist', 'uses' => 'AjaxController@addToList'));
                            Route::get('aj/likerest/{rest}', array('as' => 'aj', 'uses' => 'AjaxController@addLike'));
                            Route::get('offers/', array('as' => 'offers', 'uses' => 'OfferController@index'));
                            Route::get('offer/{id}', array('as' => 'offer', 'uses' => 'OfferController@offer'));
                            Route::get('hotel/{url}', array('as' => 'hotel', 'uses' => 'HotelController@hotel'));
                        } else {
                            $arg3 = Request::segment(3);
                            if ($locale == "ar") {
                                $arg3 = Request::segment(4);
                            }
                            if ($arg3 == "") {
                                $restaurant = DB::connection('new-sufrati')->select('SELECT DISTINCT ri.rest_ID FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=' . $currentcityid . ' WHERE ri.rest_Status=1 AND rb.status=1 AND ri.seo_url="' . $arg2 . '"');
                                if (count($restaurant) > 0) {
                                    Route::group(array('prefix' => $arg2), function () {
                                        Route::get('', array('as' => 'restaurant', 'uses' => 'RestaurantController@index'));
                                    });
                                }
                            } else {
                                if ($arg3 == "restaurants") {
                                    $cuisine = DB::connection('new-sufrati')->select('SELECT DISTINCT cu.seo_url FROM cuisine_list cu JOIN rest_branches rb ON rb.city_ID=' . $currentcityid . ' AND rb.status=1 JOIN restaurant_cuisine rc ON rc.cuisine_ID=cu.cuisine_ID AND rc.rest_ID=rb.rest_fk_id WHERE cu.cuisine_Status=1 AND cu.seo_url="' . $arg2 . '"');
                                    if (count($cuisine) > 0) {
                                        Route::group(array('prefix' => $arg2), function () {
                                            Route::get('restaurants/', array('as' => 'cuisine', 'uses' => 'CityCuisineController@index'));
                                        });
                                    }
                                } else {
                                }
                            }
                        }
                    }
                });
            }
        }
    });
}
