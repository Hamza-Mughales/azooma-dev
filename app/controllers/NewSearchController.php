<?php
class NewSearchController extends BaseController
{

    public function index()
    {
        $lang = Config::get('app.locale');
        if ($lang == "ar") {
            $cityurl = Request::segment(2);
        } else {
            $cityurl = Request::segment(1);
        }
        $city = "";
        $data = array();
        $query = "";
        if (Input::has('query')) {
            $query = Input::get('query');
        }
        if (Input::has('city')) {
            $city = Input::get('city');
        }
        // $searchCity=DB::table('city_list')->select('city_ID')->where('city_Name',$city)->where('city_status',1)->first();
        // $cityid = $searchCity->city_ID;
        $city = MGeneral::getCityURL($cityurl, true);
        if (count($city) > 0) {
            $cityid = $city->city_ID;
            $cityname = ($lang == "en") ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $ajax = TRUE;
            } else {
                $ajax = FALSE;
            }
            $restoffset = $hoteloffset = $menuoffset = $cuisineoffset = $locationoffset = $foodoffset = 0;
            if ($ajax) {
                $limit = 5;
            } else {
                $limit = 15;
                if (Input::has('page') && Input::has('tab') && Input::get('tab') == "restaurant") {
                    $restoffset = $limit * (Input::get('page') - 1);
                }
                if (Input::has('page') && Input::has('tab') && Input::get('tab') == "hotel") {
                    $hoteloffset = $limit * (Input::get('page') - 1);
                }
                if (Input::has('menupage')) {
                    $menuoffset = $limit * (Input::get('menupage') - 1);
                }
                if (Input::has('foodpage')) {
                    $foodoffset = $limit * (Input::get('foodpage') - 1);
                }
                if (Input::has('locationpage')) {
                    $locationoffset = $limit * (Input::get('locationpage') - 1);
                }
            }
            $sectiontotal = $restauranttotal = $hoteltotal = $cuisinetotal = $districttotal = $citytotal = $branchtotal = $menutotal = $foodtotal = 0;
            $sections = $restaurants = $hotels = $cuisines = $districts = $branch = $menu = $food = array();
            $restresults = MSphinx::getRestaurants($query, $cityid, $ajax, $limit, $restoffset);
            $restaurants = $restresults['restaurants'];
            $restauranttotal = $restresults['total'];
            $sections = MSphinx::getSections($query, $cityid, $ajax);
            $cuisines = MSphinx::getCuisines($query, $cityid, $ajax);
            $hotelsresult = MSphinx::getHotels($query, $cityid, $ajax);
            $hotels = $hotelsresult['hotels'];
            $hoteltotal = $hotelsresult['total'];
            $menu = MSphinx::getMenu($query, $cityid, $ajax, $limit, $menuoffset);
            $dishes = MSphinx::getDishes($query, $cityid, $ajax, $limit, $foodoffset);
            $dishtotal = $dishes['total'];
            $dishes = $dishes['foods'];
            $districts = MSphinx::getDistricts($query, $cityid, $ajax, $limit, $locationoffset);
            $locations = MSphinx::getLocations($query, $cityid, $ajax, $limit, $locationoffset);
            $locationtotal = $locations['total'];
            $locations = $locations['branches'];
            if ($ajax) {
                $data = array();
                if (count($restaurants) > 0) {
                    $restaurants['label'] = 'restaurantstitle';
                    $data['restaurants'] = $restaurants;
                }
                if (count($sections) > 0) {
                    $sections['label'] = "sectionstitle";
                    $data['sections'] = $sections;
                }
                if (count($hotels) > 0) {
                    $hotels['label'] = "hotelstitle";
                    $data['hotels'] = $hotels;
                }
                if (count($cuisines) > 0) {
                    $cuisines['label'] = "cuisinestitle";
                    $data['cuisines'] = $cuisines;
                }
                if (count($menu) > 0) {
                    $menu['label'] = "menutitle";
                    $data['menu'] = $menu;
                }
                if (count($dishes) > 0) {
                    $dishes['label'] = "dishestitle";
                    $data['dishes'] = $dishes;
                }
                if (count($locations) > 0) {
                    $locations['label'] = "locationstitle";
                    $data['locations'] = $locations;
                }
                if (count($districts) > 0) {
                    $districts['label'] = "districtstitle";
                    $data['districts'] = $districts;
                }
                return Response::json($data);
            } else {
                $data = array(
                    'restaurants' => $restaurants,
                    'cuisines' => $cuisines,
                    'menu' => $menu,
                    'dishes' => $dishes,
                    'locations' => $locations,
                    'districts' => $districts,
                );
                $data['city'] = $city;
                $data['cityname'] = $cityname;
                $data['query'] = $query;
                $data['lang'] = $lang;
                $data['restauranttotal'] = $restauranttotal;
                $data['restpaginator'] = Paginator::make($restaurants, $restauranttotal, $limit);
                $data['meta'] = array(
                    'title' => Lang::get('messages.search_results') . ' ' . Lang::get('messages.for') . ' ' . $query . ' ' . Lang::get('messages.inplace', array('name' => $cityname)),
                    'metadesc' => Lang::get('metadesc.searchresults', array('query' => $query, 'cityname' => $cityname)),
                    'metakey' => Lang::get('metakey.searchresults', array('query' => $query, 'cityname' => $cityname))
                );
                return View::make('searchresults', $data);
            }
        }
    }
}
