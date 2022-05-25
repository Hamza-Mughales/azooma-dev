<?php
class SiteMapController extends BaseController
{

	public function __construct()
	{
	}

	public function index($var = "")
	{
		$lang = Config::get('app.locale');
		$data['lang'] = $lang;
		$countries = DB::table('aaa_country')->select('id', 'flag', 'name', 'nameAr')->get();
		$countriesname = "";
		$i = 0;
		$tcountries = array();
		foreach ($countries as $country) {
			$i++;
			$cities = DB::table('city_list')->select('city_Name', 'city_Name_ar', 'seo_url')->where('city_status', 1)->where('country', $country->id)->orderBy('city_Name', 'asc')->get();
			$tcountries[$i] = $country;
			$tcountries[$i]->cities = $cities;
		}
		$data['countries'] = $tcountries;
		$data['meta'] = array(
			'title' => Lang::get('messages.site_map'),
			'metadesc' => Lang::get('messages.site_map'),
			'metakey' => Lang::get('messages.site_map'),
		);
		return View::make('site-map.index', $data);
	}

	public function city()
	{
		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$cityurl = Request::segment(2);
		} else {
			$cityurl = Request::segment(1);
		}
		$city = MGeneral::getCityURL($cityurl, true);
		$cityname = $lang == "en" ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
		$restaurants = MSiteMap::getListRestaurantsWithAlphabet($city->city_ID);
		$data['city'] = $city;
		$data['cityname'] = $cityname;
		$data['lang'] = $lang;
		$data['restaurants'] = $restaurants;
		$data['meta'] = array(
			'title' => Lang::get('title.site_map_city', array('name' => $cityname)),
			'metadesc' => Lang::get('title.site_map_city', array('name' => $cityname)),
			'metakey' => Lang::get('messages.site_map'),
		);
		return View::make('site-map.city', $data);
	}


	public function restaurants($alphabet = "")
	{
		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$cityurl = Request::segment(2);
		} else {
			$cityurl = Request::segment(1);
		}
		$offset = 0;
		$limit = 50;
		$page = 1;
		if (Input::has('page')) {
			$offset = $limit * (Input::get('page') - 1);
			$page = Input::get('page');
		}
		$city = MGeneral::getCityURL($cityurl, true);
		$cityname = $lang == "en" ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
		$total = MSiteMap::getTotalRestaurantsWithAlphabet($alphabet, $city->city_ID);
		$restaurants = MSiteMap::getRestaurantsWithAlphabet($alphabet, $city->city_ID, $limit, $offset);
		$data['city'] = $city;
		$data['cityname'] = $cityname;
		$data['lang'] = $lang;
		$data['restaurants'] = $restaurants;
		$data['alphabet'] = $alphabet;
		$data['total'] = $total[0]->total;
		$paginator = Paginator::make($data['restaurants'], $total[0]->total, $limit);
		$data['paginator'] = $paginator;
		$data['meta'] = array(
			'title' => Lang::get('title.site_map_restaurants', array('name' => $cityname, 'alphabet' => $alphabet)),
			'metadesc' => Lang::get('title.site_map_restaurants', array('name' => $cityname, 'alphabet' => $alphabet)),
			'metakey' => Lang::get('messages.site_map'),
		);
		return View::make('site-map.restaurants', $data);
	}
}
