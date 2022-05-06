<?php
class PageController extends BaseController {

	public function __construct(){
		
	}

	public function index($post=''){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		if($post!=''){
			$press=DB::table('contents')->where('status',1)->where('seo_url',$post)->first();
			$data['article']=$press;
			if($lang=="en"){
				$articletitle = $press->title;
			}
			else{
				$articletitle = $press->title_ar;
			}
			//  $articletitle=($lang=="en")?stripcslashes($press->title):stripcslashes($press->title_ar);
			$data['articletitle']=$articletitle;
			$data['meta']=array(
				'title'=>$articletitle,
			);
			return View::make('blog.page',$data);
		}else{

		}
	}
}