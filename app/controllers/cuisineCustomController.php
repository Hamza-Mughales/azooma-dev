<?php
class cuisineCustomController extends BaseController {

	public function __construct(){
		$this->MListings = new MListings();
        $this->MPopular = new MPopular();
	}

	public function index($mycuisine=""){
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
			$data['cuisines']=$this->MListings->getCustomCuisines($cityid,$mycuisine);
			$mycusii = $data['cuisines'];
			$mycusii = $mycusii[0];
            $data['mycuisine']= ($lang=="en")?stripcslashes($mycusii->cuisine_Name):stripcslashes($mycusii->cuisine_Name_ar);
            $data['city']=$city;
			$data['cityurl']=$cityurl;
			$data['lang']=$lang;
			$data['meta']=array(
				'title'=>Lang::get('messages.browse_by_cuisines').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>Lang::get('metadesc.cuisine',array('name'=>$cityname)),
				'metakey'=>Lang::get('metakey.cuisine',array('name'=>$cityname)),
			);
			return View::make('cuisine',$data);
		}else{
			App::abort(404);
		}
	}


}