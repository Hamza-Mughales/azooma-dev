<?php
class TestController extends BaseController
{

	public function __construct()
	{
	}

	public function index()
	{
		$lang = Config::get('app.locale');
		$country = MGeneral::getCountry(2);
		$logo = DB::table('art_work')->select('image', 'image_ar')->where('active', 1)->where('art_work_name', 'Azooma Logo')->first();
		$logoimage = ($lang == "en") ? $logo->image : $logo->image_ar;



		/*
	    $randommessage=Cron::getRandomBirthdayMemssage();
	    $restaurants=Cron::getRandomMembers(1,1);
	    $city=MGeneral::getCity(1,false);
		$data=array(
			'logoimage'=>$logoimage,
			'title'=>'Azooma',
			'country'=>$country,
			'lang'=>$lang,
			'randommessage'=>$randommessage,
			'restaurants'=>$restaurants,
			'city'=>$city
		);
		return View::make('emails.user.birthday',$data);
		*/
		date_default_timezone_set('Asia/Riyadh');
		$date = date("Y-m-d", strtotime("yesterday"));
		$date = "2015-01-07";
		$data = array(
			'logoimage' => $logoimage,
			'title' => 'Azooma',
			'country' => $country,
			'date' => $date
		);
		$data['dailyvisits'] = Cron::getDailyVisits($country->id, $date);
		$data['totalvisits'] = Cron::getDailyVisits($country->id);
		$data['keywords'] = Cron::getDailyKeywords($country->id, $date);
		$data['trafficdetails'] = Cron::getTrafficDetails($country->id, $date);
		$data['comments'] = Cron::getTotalComments($country->id, $date);
		$data['ratings'] = Cron::getTotalRatings($country->id, $date);
		$data['menudownloads'] = Cron::getTotalMenuDownloads($country->id, $date);
		$data['menurequests'] = Cron::getTotalMenuRequests($country->id, $date);
		$data['websiteclicks'] = Cron::getTotalWebsiteClicks($country->id, $date);
		$data['newrestaruants'] = Cron::getTotalNewRestaurants($country->id, $date);
		$data['newusers'] = Cron::getNewUsers($country->id, $date);
		$data['photos'] = Cron::getNewPhotos($country->id, $date);
		$data['totalbronze'] = Cron::getMember($country->id, 1);
		$data['totalsilver'] = Cron::getMember($country->id, 2);
		$data['totalgold'] = Cron::getMember($country->id, 3);
		$data['newbronze'] = Cron::getMember($country->id, 1, $date);
		$data['newsilver'] = Cron::getMember($country->id, 2, $date);
		$data['newgold'] = Cron::getMember($country->id, 3, $date);
		$data['dailyappdownloads'] = Cron::getTotalAppDownloads($country->id, $date);
		$data['dailyiosdownloads'] = Cron::getTotalAppDownloads($country->id, $date, "Android");
		$data['dailyandroiddownloads'] = Cron::getTotalAppDownloads($country->id, $date, "iOS");
		$data['dailyapphits'] = Cron::getTotalAppHits($country->id, $date);
		$data['dailyevents'] = Cron::getTotalEvents($country->id, $date);
		$data['totalapphits'] = Cron::getTotalAppHits($country->id);
		$data['popularcities'] = Cron::getPopularCities($country->id, $date);

		return View::make('emails.internal.daily_analytics', $data);
	}
}
