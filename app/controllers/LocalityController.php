<?php
class LocalityController extends BaseController
{

	public function __construct()
	{
		$this->MListings = new MListings();
	}

	public function index()
	{
		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$cityurl = Request::segment(2);
		} else {
			$cityurl = Request::segment(1);
		}
		$city = MGeneral::getCityURL($cityurl, true);
		if (count($city) > 0) {
			$cityname = ($lang == "en") ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
			$cityid = $city->city_ID;
			$data['localities'] = $this->MListings->getAllLocalities($cityid);
			$data['city'] = $city;
			$data['lang'] = $lang;
			$data['meta'] = array(
				'title' => Lang::get('messages.browse_by_locations') . ' ' . Lang::get('messages.inplace2', array('name' => $cityname)),
				'metadesc' => Lang::get('metadesc.locality_listing', array('name' => $cityname)),
				'metakey' => Lang::get('metakey.locality_listing', array('name' => $cityname))
			);
			return View::make('localitylistings', $data);
		} else {
			App::abort(404);
		}
	}
}
