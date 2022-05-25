<?php
class PollController extends BaseController {

	public function __construct(){
		
	}

	public function index($poll=0){
		
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		$cityid=1;
		if(Session::has('sfcity')){
			$cityid=Session::get('sfcity');
		}
		$city=MGeneral::getCity($cityid,false);
		$limit=15;$offset=0;
		if(Input::has('page')){
			$offset=$limit*(Input::get('page')-1);
		}
		if(Input::get('results')){
			$data['showresults']=true;
		}else{
			$data['showresults']=false;
		}
		if($poll==0){
			$latestpoll=MPoll::getLatestPoll($city->country);
		}else{
			$latestpoll=MPoll::getPoll($poll);
		}
		$data['voted']=MPoll::checkUserVoted($latestpoll->id);
		$total=DB::table('fpoll_poll')->where('status',1)->count();
		$latestoptions=MPoll::getOptionsWithResult($latestpoll->id);
		$polls=MPoll::getFullPolls($limit,$offset,$city->country,$latestpoll->id);
		$data['latestpoll']=$latestpoll;
		$data['latestoptions']=$latestoptions;
		$data['totalvotes']=MPoll::getTotalVotes($latestpoll->id);
		$data['polls']=$polls;
		$data['city']=$city;
		
		$cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_Ar);
		$data['cityname']=$cityname;
		$data['checkuservoted']=MPoll::checkUserVoted($latestpoll->id);
		$data['paginator']=Paginator::make($data['polls'],$total,$limit);
		
		$data['meta']=array(
			'title'=>Lang::get('messages.poll'),
			'metadesc'=>($lang=="en")?stripcslashes($latestpoll->question):stripcslashes($latestpoll->question_ar).'. '.Lang::get('messages.poll').' '.Lang::get('messages.azooma'),
			'metakey'=>''
		);
		
		return view('poll_home',$data);
	}


	public function vote($poll=0){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		$cityid=1;
		if(Session::has('sfcity')){
			$cityid=Session::get('sfcity');
		}
		$city=DB::table('city_list')->select('city_ID','seo_url','country')->where('city_ID',$cityid)->first();
		if($poll!=0){
			$userid=0;
			$option=Input::get('polloption');
			if(Session::has('userid')){
				$userid=Session::get('userid');
			}
			$ip=Azooma::getRealIpAddr();
			$data=array(
				'poll_id'=>$poll,
				'user_ID'=>$userid,
				'option_id'=>intval($option),
				'ip'=>$ip,
				'country'=>$city->country
			);
			$checkuservoted=MPoll::checkUserVoted($poll);
			if(count($checkuservoted)>0){
				DB::table('fpoll_ips')->where('id',$checkuservoted->id)->update($data);
			}else{
				DB::table('fpoll_ips')->insert($data);	
			}
			return Redirect::to('poll/'.$poll.'?results=1#n');
		}
	}


}