<?php
class QController extends BaseController {

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
		$cuisine =$menu = $wheelchair = $price = $latitude = $longitude = $category= $delivery=$finedining=$casualdining="";
		$sort="member";
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
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
		if(Input::has('category')){
			$category=Input::get('category');
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
			$categorystring='';
			if(Input::has('category')){
				$categorystring=Azooma::LangSupport(Input::get('category')).' ';
			}
			$pricestring='';
			if(Input::has('price')){
				$pricestring=Lang::get('messages.price_range').' '.Input::get('price').' '.Azooma::GetCurrency($city->country);
			}
			$total=$this->MPopular->getSearchResults($city->city_ID,$cuisine,$category, $menu,$wheelchair, $price,"latest", "","", $latitude, $longitude, true);
			$total=$total[0]->total;
			$data['total']=$t['total']=$total;
			$t['restaurants']=$this->MPopular->getSearchResults($city->city_ID,$cuisine,$category, $menu,$wheelchair, $price,$sort, $limit,$offset, $latitude, $longitude, false);
			$data['actiontitle']=$categorystring.Lang::choice('messages.restaurants',2).' '.$pricestring;
			$data['meta']=array(
				'title'=>$categorystring.Lang::choice('messages.restaurants',2).$pricestring.' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>$categorystring.Lang::choice('messages.restaurants',2).$pricestring.' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metakey'=>'',
			);
			$t['paginator']=Paginator::make($t['restaurants'],$total,$limit);
			$data['originallink']=Azooma::URL($city->seo_url.'/q'.$var);
			$data['resultshtml']=View::make('main.results',$t);
			return View::make('popular',$data);
		}

	}


}