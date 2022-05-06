<?php
class PressController extends BaseController {

	public function __construct(){
		
	}

	public function index($post=0){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		if($post==0){
			$limit=10;$offset=0;
			if(Input::has('page')){
				$offset=$limit*(Input::get('page')-1);
			}
			$total=DB::table('press')->where('status',1)->count();
			$posts=DB::table('press')->select('id','short','short_ar','image',DB::raw('full as description'),DB::raw('full_ar as descriptionAr'),'author','author_ar','newsDate')->where('status',1)->skip($offset)->take($limit)->get();
			$data['posts']=$posts;
			$data['paginator']=Paginator::make($data['posts'],$total,$limit);
			$data['meta']=array(
				'title'=>Lang::get('messages.press'),
				'metadesc'=>Lang::get('messages.press'),
				'metakey'=>Lang::get('messages.press'),
			);
			return View::make('blog.press_home',$data);
		}else{
			$press=DB::table('press')->where('status',1)->where('id',$post)->first();
			$data['article']=$press;
			$articletitle=($lang=="en")?stripcslashes($press->short):stripcslashes($press->short_ar);
			$data['articletitle']=$articletitle;
			$data['meta']=array(
				'title'=>$articletitle,
				'metadesc'=>$articletitle,
				'metakey'=>$articletitle,
			);
			return View::make('blog.press_article',$data);
		}
	}
}