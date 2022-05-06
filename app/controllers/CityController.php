<?php
class CityController extends BaseController {

	public function __construct(){
		$this->MHomePage = new MHomePage();
	}

	public function index()
	{
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$data['lang']=$lang;
		$city=$city=MGeneral::getCityURL($cityurl);
		$data['city']=$city;
		$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
		$data['randoms']=$this->MHomePage->getRandomMembers($city->city_ID);
		$data['newrestaurants']=$this->MHomePage->getNewRestaurants($city->city_ID);
		$data['newimages']=$this->MHomePage->getNewImages($city->city_ID);
		$data['newvideos']=$this->MHomePage->getNewVideos($city->country);
		$data['favorites']=$this->MHomePage->getSufratiFavorites($city->city_ID);
		$data['featured']=$this->MHomePage->getFeaturedSlides($city->seo_url);
		$data['recommendedmeals']=$this->MHomePage->getMeals($city->city_ID);
		$data['popularcuisines']=$this->MHomePage->getPopularCuisines($city->city_ID);
		$data['popularlocalities']=$this->MHomePage->getPopularLocalities($city->city_ID);
		$data['popularfeatures']=$this->MHomePage->getPopularFeatures($city->city_ID);
		// $countries=DB::table('aaa_country')->select('id','flag','name','nameAr')->get();
		// $countriesname="";
		// $i=0;
		// $tcountries=array();
		// foreach ($countries as $country) {
		// 	$i++;
		// 	$countriesname.=($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);
		// 	if($i<count($countries)){
		// 		$countriesname.=', ';
		// 	}
		// 	$cities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
		// 	$tcountries[$i]=$country;
		// 	$tcountries[$i]->cities=$cities;
		// }
		// $data['countries']=$tcountries;
		$userid=0;
		if(Session::has('userid')){
			$userid=Session::get('userid');
			  $user=DB::table('user')->where('user_ID',$userid)->first();
			  if($user->profilecompletion < 3){
				return Redirect::to('step/0');
			  }
		}
		$data['latestnews']=MHomePage::getLatestNews($city->city_ID,$userid);
		$data['meta']=array(
			'title'=>$cityname.' '.Lang::choice('messages.restaurants',2).' - '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
			'metadesc'=>Lang::get('metadesc.city_page',array('name'=>$cityname)),
			'metakeywords'=>$cityname.' '.Lang::choice('messages.restaurants',2).', '.Lang::get('metakey.city_page',array('name'=>$cityname))
		);
		return View::make('city',$data);
	}

}