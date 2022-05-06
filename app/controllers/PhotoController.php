<?php
class PhotoController extends BaseController {
	public function __construct(){
	}

	public function index($image){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$data['lang']=$lang;
		$sort="";
		$rest=0;
		$city=MGeneral::getCityURL($cityurl,true);
		if(Input::has('rest')){
			$rest=Input::get('rest');
		}
		if(Input::has('sort')){
			$rest=Input::get('sort');
		}
		if(count($city)>0){
			$photoq='SELECT ig.image_ID, ig.rest_ID,ig.title,ig.title_ar,ig.image_full,ig.user_ID,ig.ratio,ig.width,ig.branch_id,ig.enter_time,ri.rest_Name,ri.rest_Name_ar,ri.seo_url,ri.rest_Logo,ig.status,(SELECT COUNT(id) FROM photolike WHERE image_ID=ig.image_ID) as likes FROM image_gallery ig JOIN restaurant_info ri ON ri.rest_ID=ig.rest_ID AND ri.rest_Status=1 WHERE image_ID=:photo';
			$photo=DB::select(DB::raw($photoq),array('photo'=>$image));
			$restname=($lang=="en")?stripcslashes($photo[0]->rest_Name):stripcslashes($photo[0]->rest_Name_ar);
			$user=array();
			if($photo[0]->user_ID!=NULL){
				$userq='SELECT user_ID,user_NickName,user_FullName,image FROM user WHERE user_ID=:userid';
				$user=DB::select(DB::raw($userq),array('userid'=>$photo[0]->user_ID));
			}
			$cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
			$cityid=$city->city_ID;
			$rest=MRestaurant::getRest($photo[0]->rest_ID,TRUE);
			//return View::make('ajax.photo',$t);
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
				$next=MGallery::getScrollPhoto(TRUE,$image,$cityid,$sort,$rest->rest_ID);
				$prev=MGallery::getScrollPhoto(FALSE,$image,$cityid,$sort,$rest->rest_ID);
				$t=array(
					'photo'=>$photo[0],
					'lang'=>$lang,
					'restname'=>$restname,
					'user'=>$user,
					'city'=>$city,
					'cityname'=>$cityname,
					'next'=>$next,
					'prev'=>$prev,
					'rest'=>$rest,
					'sort'=>$sort
				);
				$data['html']=stripcslashes(View::make('ajax.photo',$t));	
				return Response::json($data);
			}else{
				$photo=$photo[0];

				$data['lang']=$lang;
				$data['city']=$city;
				$data['photo']=$photo;
				if($lang=="en"){
					$photoname= ($photo->title!="")?stripcslashes($photo->title):stripcslashes($photo->rest_Name).' '.Lang::get('messages.photo');
				}else{
					$photoname= ($photo->title_ar!="")?stripcslashes($photo->title_ar):stripcslashes($photo->rest_Name_ar).' '.Lang::get('messages.photo');
				}
				$width=$photo->width;
				if($width==0){
					if(file_exists('uploads/Gallery/'.$photo->image_full)){
						list($width, $height, $type, $attr)= getimagesize('uploads/Gallery/'.$photo->image_full);	
					}else{
						$width=500;$height=500;
					}
				}else{
					$height=round($width/$photo->ratio);
				}
				if($width>800){
					$width=800;
					$height=round(800/$photo->ratio);
				}
				$data['meta']=array(
					'title'=>$photoname,
					'metadesc'=>$photoname.' '.Lang::get('messages.photo').' '.Lang::get('messages.inplace2',array('cityname'=>$cityname)),
					'metakey'=>$photoname.', '.$restname.', '.Lang::get('messages.photo')
				);
				$data['width']=$width;
				$data['height']=$height;
				$data['photoname']=$photoname;
				$data['rest']=$rest;
				return View::make('photo',$data);
			}
		}
	}

}