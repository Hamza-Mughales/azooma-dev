<?php

class HomeController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function __construct(){
			$this->MListings = new MListings();
	}


	public function index()	{
		$lang=Config::get('app.locale');
		$langhelperstring="";
		if($lang=="ar"){
			$langhelperstring='ar/';
		}
		
		$data['lang']=$lang;
		$data['langhelperstring']=$langhelperstring;
		
		$data['landing']=true;
		$data['featured']=array(
				array('city_Name'=>'Jeddah','image'=>'jeddah.png','desc'=>'Discover & Book Best Restaurants in','url'=>'jeddah','city_Name_ar'=>'جده','id'=> '1'),
				array('city_Name'=>'Cairo','image'=>'cairo.png','desc'=>'Discover & Book Best Restaurants in','url'=>'cairo','city_Name_ar'=>'القاهره','id'=> '34'),
				array('city_Name'=>'London','image'=>'london.png','desc'=>'Discover & Book Best Restaurants in','url'=>'london','city_Name_ar'=>'لندن','id'=> '33')
				);
		$countries=DB::table('aaa_country')->select('id','flag','name','nameAr')->get();
		$countriesname="";
		$i=0;
		$tcountries=array();
		foreach ($countries as $country) {
			$i++;
			$countriesname.=($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);
			if($i<count($countries)){
				$countriesname.=', ';
			}
			$cities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail','city_ID')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
			$tcountries[$i]=$country;
			$tcountries[$i]->cities=$cities;
		}
		$data['countries']=$tcountries;

		$mycities = "";
        $city = "";
        $country = "";
        if(Session::has('sfcity')){
            $city=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail','city_ID')->where('city_ID',Session::get('sfcity'))->where('city_status',1)->first();
            $countryID=DB::table('city_list')->select('country')->where('seo_url',$city->seo_url)->first();
            $country=DB::table('aaa_country')->select('id','flag','name','nameAr')->where('id',$countryID->country)->get();
            $mycities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$countryID->country)->orderBy('city_Name','asc')->get();
            $city=$city=MGeneral::getCityURL($city->seo_url);
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
            $details = "";
			if($ip == 0){
				$details = json_decode(file_get_contents("http://ip-api.com/json/"));
			}else{
				$details = json_decode(file_get_contents("http://ip-api.com/json/".$ip));
			}
            $currentCountryIP = $details->country;
            $Getcityname = $details->city;
           
            $country=DB::table('aaa_country')->select('id','flag','name','nameAr')->where('name',$currentCountryIP)->first();
			if(count($country) == 0){
				$country=DB::table('aaa_country')->select('id','flag','name','nameAr')->first();
			   }
            $mycities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
            $city=DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_Name',$Getcityname)->where('city_status',1)->first();
            if(count($city) > 0){
            }else{
                $city=DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url','city_thumbnail')->where('country',$country->id)->where('city_status',1)->first();
            }
   
            Config::set('session.lifetime',365*12*3600);
            Session::put('sfcity',$city->city_ID);
        }
        $city=$city=MGeneral::getCityURL($city->seo_url);
        $data['city']=$city;
        $data['country']=$country;
        $data['mycities']=$mycities;
		$data['meta']=array(
			'metadesc'=>Lang::get('metadesc.landing_page',array('name'=>$countriesname)),
			'metakey'=>Lang::get('metakey.landing_page'),
			
		);
		return View::make('home',$data);
	}

}