<?php
class CityCuisineController extends BaseController
{

	public function __construct()
	{
		$this->MPopular = new MPopular();
	}

	public function index()
	{
		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$cuisine = Request::segment(3);
			$cityurl = Request::segment(2);
		} else {
			$cuisine = Request::segment(2);
			$cityurl = Request::segment(1);
		}
		$limit = 20;
		$offset = 0;
		$data['lang'] = $lang;
		$menu = $wheelchair = $price = $latitude = $longitude = $delivery = $finedining = $casualdining = "";
		$sort = "member";
		$page = 1;
		if (Input::has('page')) {
			$offset = $limit * (Input::get('page') - 1);
			$page = Input::get('page');
		}
		if (Input::has('wheelchair')) {
			$wheelchair = Input::get('wheelchair');
		}
		if (Input::has('menu')) {
			$menu = Input::get('menu');
		}
		if (Input::has('price')) {
			$price = Input::get('price');
		}
		if (Input::has('delivery')) {
			$delivery = Input::get('delivery');
		}
		if (Input::has('sort')) {
			$sort = Input::get('sort');
		}
		if (Input::has('finedining')) {
			$finedining = Input::get('finedining');
		}
		if (Input::has('casualdining')) {
			$casualdining = Input::get('casualdining');
		}
		if (Input::has('latitude')) {
			$latitude = Input::get('latitude');
			if (Input::has('longitude')) {
				$longitude = Input::get('longitude');
			}
		}
		$city = MGeneral::getCityURL($cityurl, true);
		if (count($city) > 0) {
			$data['city'] = $city;
			$cityname = $lang == "en" ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
			$cuisineq = DB::select('SELECT * FROM cuisine_list WHERE seo_url="' . $cuisine . '" AND cuisine_Status=1 LIMIT 1');
			if (count($cuisineq) > 0) {
				$cuisine = $cuisineq[0];
				$cuisinename = $lang == "en" ? stripcslashes($cuisine->cuisine_Name) : stripcslashes($cuisine->cuisine_Name_ar);
				$data['cuisine'] = $cuisine;
				$t['sort'] = $sort;
				$t['MGeneral'] = new MGeneral();
				$t['city'] = $city;
				$t['lang'] = $lang;
				$t['action'] = 'cuisine';
				$data['var'] = $t['var'] = array(
					'sort' => $sort,
					'limit' => $limit,
					'menu' => $menu,
					'price' => $price,
					'wheelchair' => $wheelchair,
					'delivery' => $delivery,
					'finedining' => $finedining,
					'casualdining' => $casualdining,
				);
				$data['newrestaurants'] = $this->MPopular->getCityCuisine($city->city_ID, $cuisine->cuisine_ID, $menu, $wheelchair, $price, "latest", 3, 0, $latitude, $longitude, false, false);
				$data['popularrestaurants'] = $this->MPopular->getCityCuisine($city->city_ID, $cuisine->cuisine_ID, $menu, $wheelchair, $price, "popular", 3, 0, $latitude, $longitude, false, false);
				$data['recommendedrestaurants'] = $this->MPopular->getCityCuisine($city->city_ID, $cuisine->cuisine_ID, $menu, $wheelchair, $price, "recommended", 3, 0, $latitude, $longitude, false, false);
				$total = $this->MPopular->getCityCuisine($city->city_ID, $cuisine->cuisine_ID, $menu, $wheelchair, $price, "latest", "", "", $latitude, $longitude, true);
				$total = $total[0]->total;
				$data['total'] = $t['total'] = $total;
				$t['restaurants'] = $this->MPopular->getCityCuisine($city->city_ID, $cuisine->cuisine_ID, $menu, $wheelchair, $price, $sort, $limit, $offset, $latitude, $longitude, false);
				$data['actiontitle'] = $cuisinename . ' ' . Lang::choice('messages.restaurants', 2);
				$data['meta'] = array(
					'title' => $cuisinename . ' ' . Lang::choice('messages.restaurants', 2) . ' ' . Lang::get('messages.inplace2', array('name' => $cityname)) . ', ' . Lang::get('messages.best') . ' ' . $cuisinename . ' ' . Lang::get('messages.food') . ' ' . Lang::get('messages.inplace2', array('name' => $cityname)),
					'metadesc' => Lang::get('metadesc.city_cuisine', array('city' => $cityname, 'cuisine' => $cuisinename)),
					'metakey' => Lang::get('metakey.city_cuisine', array('city' => $cityname, 'cuisine' => $cuisinename)),
				);
				$t['paginator'] = Paginator::make($t['restaurants'], $total, $limit);
				$data['resultshtml'] = View::make('main.results', $t);
				$data['originallink'] = Azooma::URL($city->seo_url . '/' . $cuisine->seo_url . '/restaurants');
				if ($page > 1) {
					$prev = $page - 1;
					$data['prev'] = Azooma::URL($city->seo_url . '/' . $cuisine->seo_url . '/restaurants?page=' . $prev);
				}
				if (($offset + $limit) < $total) {
					$next = $page + 1;
					$data['next'] = Azooma::URL($city->seo_url . '/' . $cuisine->seo_url . '/restaurants?page=' . $next);
				}
				if ($cuisine->bannerimage != "") {
					$data['bannerimage'] = Azooma::CDN('images/cuisine/banner/' . $cuisine->bannerimage);
				}
				$data['currentcuisineid'] = $cuisine->cuisine_ID;
				return View::make('popular', $data);
			}
		}
	}


	public function district()
	{
		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$district = Request::segment(3);
			$cityurl = Request::segment(2);
		} else {
			$district = Request::segment(2);
			$cityurl = Request::segment(1);
		}
		$limit = 20;
		$offset = 0;
		$data['lang'] = $lang;
		$menu = $wheelchair = $price = $latitude = $longitude = $delivery = $finedining = $casualdining = "";
		$sort = "member";
		$page = 1;
		if (Input::has('page')) {
			$offset = $limit * (Input::get('page') - 1);
			$page = Input::get('page');
		}
		if (Input::has('wheelchair')) {
			$wheelchair = Input::get('wheelchair');
		}
		if (Input::has('menu')) {
			$menu = Input::get('menu');
		}
		if (Input::has('price')) {
			$price = Input::get('price');
		}
		if (Input::has('delivery')) {
			$delivery = Input::get('delivery');
		}
		if (Input::has('sort')) {
			$sort = Input::get('sort');
		}
		if (Input::has('finedining')) {
			$finedining = Input::get('finedining');
		}
		if (Input::has('casualdining')) {
			$casualdining = Input::get('casualdining');
		}
		if (Input::has('latitude')) {
			$latitude = Input::get('latitude');
			if (Input::has('longitude')) {
				$longitude = Input::get('longitude');
			}
		}
		$city = MGeneral::getCityURL($cityurl, true);
		if (count($city) > 0) {
			$data['city'] = $city;
			$cityname = $lang == "en" ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
			$district = DB::table('district_list')->where('seo_url', $district)->where('city_ID', $city->city_ID)->first();
			if (count($district) > 0) {
				$districtname = $lang == "en" ? stripcslashes($district->district_Name) : stripcslashes($district->district_Name_ar);
				$data['district'] = $district;
				$t['sort'] = $sort;
				$t['MGeneral'] = new MGeneral();
				$t['city'] = $city;
				$t['lang'] = $lang;
				$t['action'] = 'districts';
				$data['var'] = $t['var'] = array(
					'sort' => $sort,
					'limit' => $limit,
					'menu' => $menu,
					'price' => $price,
					'wheelchair' => $wheelchair,
					'delivery' => $delivery,
					'finedining' => $finedining,
					'casualdining' => $casualdining,
				);
				$data['newrestaurants'] = $this->MPopular->getCityDistricts($city->city_ID, $district->district_ID, $menu, $wheelchair, $price, "latest", 5, 0, $latitude, $longitude, false, true);
				$data['popularrestaurants'] = $this->MPopular->getCityDistricts($city->city_ID, $district->district_ID, $menu, $wheelchair, $price, "popular", 5, 0, $latitude, $longitude, false, true);
				$data['recommendedrestaurants'] = $this->MPopular->getCityDistricts($city->city_ID, $district->district_ID, $menu, $wheelchair, $price, "recommended", 5, 0, $latitude, $longitude, false, true);
				$total = $this->MPopular->getCityDistricts($city->city_ID, $district->district_ID, $menu, $wheelchair, $price, "latest", "", "", $latitude, $longitude, true);
				$total = $total[0]->total;
				$data['total'] = $t['total'] = $total;
				$t['restaurants'] = $this->MPopular->getCityDistricts($city->city_ID, $district->district_ID, $menu, $wheelchair, $price, $sort, $limit, $offset, $latitude, $longitude, false);
				$data['actiontitle'] = Lang::choice('messages.restaurants', 2) . ' ' . Lang::get('messages.inplace2', array('name' => $districtname));
				$data['action'] = $t['action'];
				$data['meta'] = array(
					'title' => Lang::choice('messages.restaurants', 2) . ' ' . Lang::get('messages.inplace2', array('name' => $districtname . ' - ' . $cityname)),
				);
				$t['paginator'] = Paginator::make($t['restaurants'], $total, $limit);
				$data['resultshtml'] = View::make('main.results', $t);
				$data['originallink'] = Azooma::URL($city->seo_url . '/' . $district->seo_url . '/restaurants');
				if ($page > 1) {
					$prev = $page - 1;
					$data['prev'] = Azooma::URL($city->seo_url . '/' . $district->seo_url . '/restaurants?page=' . $prev);
				}
				if (($offset + $limit) < $total) {
					$next = $page + 1;
					$data['next'] = Azooma::URL($city->seo_url . '/' . $district->seo_url . '/restaurants?page=' . $next);
				}
				return View::make('popular', $data);
			} else {
				App::abort(404);
			}
		}
	}
}
