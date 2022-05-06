<?php
class HotelController extends BaseController {
	public function __construct(){
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
		$cuisine =$menu = $wheelchair = $price = $latitude = $longitude = $delivery=$finedining=$casualdining="";
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
			$t['cityname']=$cityname;
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
			$t['hotels']=MHotel::getAllHotels($city->city_ID, $cuisine, $menu, $wheelchair, $price, $sort, $limit, $offset, $latitude, $longitude,false);
			$total=MHotel::getAllHotels($city->city_ID, $cuisine, $menu, $wheelchair, $price, $sort, $limit, $offset, $latitude, $longitude,true);
			$t['total']=$data['total']=$total[0]->total;
			$data['actiontitle']=Lang::choice('messages.hotels',2);
			$data['meta']=array(
				'title'=>Lang::get('title.hotels',array('name'=>$cityname)),
			);
			$t['paginator']=Paginator::make($t['hotels'],$total,$limit);
			$data['originallink']=Azooma::URL($city->seo_url.'/hotels');
			if(($page-1)!=0){
				$prev=$page-1;
				$data['prev']=Azooma::URL($city->seo_url.'/hotels?page='.$prev);
			}
			if(($offset+$limit)<$total){
				$next=$page+1;
				$data['next']=Azooma::URL($city->seo_url.'/hotels?page='.$next);
			}
			$data['resultshtml']=View::make('main.hotels',$t);
			return View::make('popular',$data);
		}else{
			App::abort(404);
		}
	}


	public function hotel($hotelurl=""){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$var=Request::segment(3);
			$cityurl=Request::segment(2);
		}else{
			$var=Request::segment(2);
			$cityurl=Request::segment(1);
		}
		$data['lang']=$lang;
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$data['city']=$city;
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$hotel=DB::table('hotel_info')->where('url',$hotelurl)->first();
			if(count($hotel)>0){
				$data['hotel']=$hotel;
				$data['cityname']=$cityname;
				$data['restaurants']=MHotel::getRestaurants($hotel->id,$city->city_ID);
				$data['actiontitle']=($lang=="en")?stripcslashes($hotel->hotel_name):stripcslashes($hotel->hotel_name_ar);
				$data['meta']=array(
					'title'=>$data['actiontitle'].' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				);
				return View::make('hotelpage',$data);
			}else{
				App::abort(404);
			}
		}
	}

}