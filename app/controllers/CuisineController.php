<?php
class CuisineController extends BaseController {

	public function __construct(){
		$this->MListings = new MListings();
	}

	public function index(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$cityid=$city->city_ID;
			$data['cuisines']=$this->MListings->getAllCuisines($cityid);
			$data['city']=$city;
			$data['lang']=$lang;
			$data['meta']=array(
				'title'=>Lang::get('messages.browse_by_cuisines').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>Lang::get('metadesc.cuisinelistings',array('name'=>$cityname)),
				'metakey'=>Lang::get('metakey.cuisinelistings',array('name'=>$cityname)),
			);
			return View::make('cuisinelistings',$data);
		}else{
			App::abort(404);
		}
	}


	public function features(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$this->MHomePage = new MHomePage();
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$cityid=$city->city_ID;
			$data['features']=$this->MHomePage->getPopularFeatures($cityid,0);
			$data['city']=$city;
			$data['lang']=$lang;
			$data['meta']=array(
				'title'=>Lang::choice('messages.restaurants',1).' '.Lang::get('messages.features_services').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>Lang::choice('messages.restaurants',1).' '.Lang::get('messages.features_services').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metakey'=>Lang::choice('messages.restaurants',1).', '.Lang::get('messages.features_services').', '.$cityname,
			);
			return View::make('featurelistings',$data);
		}else{
			App::abort(404);
		}
	}
}