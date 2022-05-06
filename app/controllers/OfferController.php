<?php
class OfferController extends BaseController {
	public function __construct(){
		
	}

	public function index(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$limit=20;$offset=0;
		$data['lang']=$lang;
		$cuisine =$category  = $latitude = $longitude ="";
		$sort="member";
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
		}
		if(Input::has('cuisine')){
			$cuisine=Input::get('cuisine');
		}
		if(Input::has('category')){
			$category=Input::get('category');
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
			$data['var']=$t['var']=array(
				'sort'=>$sort,
				'limit'=>$limit,
				'cuisine'=>$cuisine,
				'category'=>$category,
			);
			$t['lang']=$lang;
			$t['city']=$city;
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$t['cityname']=$cityname;
			$data['city']=$city;
			$t['offers']=MOffers::getAllOffers($city->city_ID,$category,$sort,$limit,$offset,false);
			$total=MOffers::getAllOffers($city->city_ID,$category,$sort,$limit,$offset,true);
			$data['total']=$total[0]->total;
			$data['actiontitle']=Lang::get('messages.special_offers');
			$data['meta']=array(
				'title'=>Lang::get('messages.special_offers').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>Lang::get('metadesc.offerhome',array('name'=>$cityname)),
				'metakey'=>Lang::get('metakey.offerhome',array('name'=>$cityname)),

			);
			$t['paginator']=Paginator::make($t['offers'],$total,$limit);
			$data['resultshtml']=View::make('main.offers',$t);
			return View::make('offers',$data);
		}
	}


	public function offer($id=0){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$data['lang']=$lang;
		$city=MGeneral::getCityURL($cityurl,true);
		if(count($city)>0){
			$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$data['city']=$city;
			$offer=DB::table('rest_offer')->where('id',$id)->first();
			if(count($offer)>0){
				$data['offer']=$offer;
				$offername=($lang=="en")?stripcslashes($offer->offerName):stripcslashes($offer->offerNameAr);
				$data['offername']=$offername;
				$data['cityname']=$cityname;
				$data['category']=MOffers::getOfferCategories($offer->id);
				$categoriesname="";
				$i=0;
				if(count($data['category'])>0){
					$i++;
					foreach ($data['category'] as $category) {
						$categoriesname.=($lang=="en")?stripcslashes($category->categoryName):stripcslashes($category->categoryNameAr);
					}
					if($i<=count($data['category'])){
						$categoriesname.=", ";
					}
				}
				$data['restaurant']=MRestaurant::getRest($offer->rest_ID,true);
				$restname=($lang=="en")?stripcslashes($data['restaurant']->rest_Name):stripcslashes($data['restaurant']->rest_Name_Ar);
				$data['restname']=$restname;
				$data['branches']=MOffers::getOfferBranches($offer->id,$city->city_ID);
				$data['branchcount']=DB::table('rest_branches')->where('rest_fk_id',$offer->rest_ID)->where('city_ID',$city->city_ID)->count();
				$data['relatedoffers']=MOffers::getOtherOffers($city->city_ID,$offer->id);
				$data['meta']=array(
					'title'=>$offername.' '.Lang::get('messages.from').' '.$restname.' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
					'metadesc'=>$offername.' '.Lang::get('messages.by').' '.$restname.'. '.$offername.' '.Lang::get('messages.inplace2',array('name'=>$cityname)).', '.$categoriesname,
					'metakey'=>$offername.', '.$restname.', '.$cityname,
				);
				return View::make('offerpage',$data);
			}else{
				App::abort(404);
			}
		}
	}

}