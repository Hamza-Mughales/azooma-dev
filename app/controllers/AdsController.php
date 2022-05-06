<?php
class AdsController extends BaseController {

	public function __construct(){
		
	}

	public function index($id=0){
		$banner=Ads::getBanner($id);
		$lang=Config::get('app.locale');
		if(count($banner)>0){
			Ads::IncrementClick($id);
			$url=$banner->url;
			if($lang=="ar"){
				$url=$banner->url_ar;
			}
			return Redirect::to($url);
		}
	}
}