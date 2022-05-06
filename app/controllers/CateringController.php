<?php
class CateringController extends BaseController {

	public function __construct(){
		
	}

	public function index(){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		$data['meta']=array(
			'title'=>Lang::get('messages.event_organiser'),
            'metadesc'=>Lang::get('messages.event_organiser').' '.Lang::get('messages.plan_event'),
		);
		if($lang=="ar"){
			$cityurl=Request::segment(2);
			$langstring="ar/";
		}else{
			$cityurl=Request::segment(1);
			$langstring="";
		}
		$city=MGeneral::getCityURL($cityurl);
		$country=MGeneral::getCountry($city->country);
		$masters=MGeneral::getAllCuisines();
		$tdata=array('masters'=>$masters,'lang'=>$lang,'country'=>$country);
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
		}else{
			$tdata['noajax']=true;
		}
		$data['html']=stripcslashes(View::make('ajax.event_plan',$tdata));
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
			$t=array(
				'html'=>$data['html']
			);
			return Response::json($t);
		}else{
			$check=Request::segment(2);
			if($lang=="ar"){
				$check=Request::segment(3);
			}
			if($check=="organiseevent"){
				$data['city']=$city;
				$data['lang']=$lang;
				$data['country']=$country;
				$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
				$data['cityname']=$cityname;
				return View::make('event_organise',$data);
			}else{
				return Redirect::to($langstring.$cityurl.'/organiseevent');
			}
		}
	}


	public function submitEvent(){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$city=MGeneral::getCityURL($cityurl,true);
		if(Input::has('eventTitle')){
			$event=Input::get('eventTitle');
			if(Session::has('userid')){
				$userid=Session::get('userid');
				$user=DB::table('user')->select('user_ID','user_Mobile','user_Email','user_FullName')->where('user_ID',$userid)->first();
			}else{
				$check=DB::table('user')->select('user_ID','user_Mobile','user_Email','user_FullName','user_NickName','facebook','fbPublish')->where('user_Email',Input::get('yourEmail'))->first();
				if(count($check)>0){
					$user=$check;
					$userid=$check->user_ID;
					$user=$check;
					$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
					Config::set('session.lifetime',365*12*3600);
					Session::put('name',$username);
					Session::put('userid',$check->user_ID);
					Session::put('fbid',$check->facebook);
					Session::put('fb_publish',$check->fbPublish);
				}else{
					//register user
					$name=Input::get('yourName');
					$number=Input::get('yourNumber');
					$rand=uniqid(md5(mt_rand()), true);
        			$pass='hungry'.mt_rand(1000,9999);
        			$email=Input::get('yourEmail');
        			$data=array(
			            'user_Email'=>  $email,
			            'user_Pass'=>$pass,
			            'user_FullName'=>  $name,
			            'user_BirthDate'=>'0000-00-00',
			            'rand_num'=>$rand,
			            'sufrati'=>$city->country
			        );
        			$userid=DB::table('user')->insertGetId($data);
        			User::addUserNotification($userid,$name,$email,$city->country);
        			$logo=MGeneral::getLogo();
					$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
					$country=MGeneral::getCountry($city->country);
        			$helper=Lang::get('email.welcome_helper').' <br/>'.Lang::get('email.your_password_is').' : '.$pass;
        			$kdata=array(
        				'user'=>$user,
        				'city'=>$city,
						'country'=>$country,
						'logoimage'=>$logoimage,
						'heading'=>Lang::get('email.welcome_to_sufrati'),
						'helper'=>$helper,
						'action'=>Lang::get('email.activate'),
						'actionlink'=>Azooma::URL('welcome/'.$user->rand_num)
        			);
        			$subject=Lang::get('email.welcome_to_sufrati');
        			Mail::queue('emails.general',$data,function($message) use ($subject,$user) {
						$message->to(trim($user->user_Email),$user->user_FullName);
						$message->subject($subject);
					});
				}
			}
			if($user->user_Mobile==""){
				DB::table('user')->where('user_ID',$userid)->update(array('user_Mobile'=>Input::get('yourNumber')));
			}
			$eventdate=Input::get('eventDate');
			$cuisines=implode(',',Input::get('cuisines'));
			$meals=implode(',', Input::get('meal'));
			$beverages=implode(',', Input::get('beverage'));
			$dining=$staffReq=$location='';
			if(Input::has('diningSetup')){
				$dining=implode(',',Input::get('diningSetup'));
			}
			if(Input::has('staffReq')){
				$staffReq=implode(',',Input::get('staffReq'));
			}
			if(Input::has('location')){
				$location=Input::get('location');
			}
			$newevent=array(
				'user_ID'=>$userid,
				'name'=>$event,
				'type'=>Input::get('eventType'),
				'guests'=>Input::get('guests'),
				'budget'=>Input::get('budget'),
				'date'=>$eventdate,
				'mealType'=>Input::get('eventTime'),
				'eventVenue'=>Input::get('eventVenue'),
				'cuisines'=>$cuisines,
				'meals'=>$meals,
				'beverage'=>$beverages,
				'servingStyle'=>Input::get('servingStyle'),
				'diningSetup'=>$dining,
				'staffReq'=>$staffReq,
				'location'=>$location,
				'notes'=>Input::get('notes')
			);
			$eventid=DB::table('user_event')->insertGetId($newevent);
			$event=DB::table('user_event')->where('id',$eventid)->first();
			$this->_sendmail($event,$user,$city);
			$t['html']=stripcslashes(View::make('ajax.event_success',array('event'=>$event,'user'=>$user)));
			$t['event']=$event;
			return Response::json($t);
		}
	}

	public function _sendmail($event,$user=array(),$city=array()){
		/*
		if(!is_array($event)){
			$event=DB::table('user_event')->where('id',$event)->first();
			$user=DB::table('user')->select('user_ID','user_Mobile','user_Email','user_FullName')->where('user_ID',$event->user_ID)->first();
			$city=MGeneral::getCityURL('jeddah');
		}
		*/
		$lang=Config::get('app.locale');
		$country=MGeneral::getCountry($city->country);
		$logo=MGeneral::getLogo();
		$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
		$data=array(
			'event'=>$event,
			'user'=>$user,
			'city'=>$city,
			'country'=>$country,
			'logoimage'=>$logoimage,
		);
		$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
		$subject=Lang::get('email.user_ordered_catering_subject',array('username'=>$user->user_FullName));
		$teamemails=explode(",",$country->teamemail);
		Mail::queue('emails.notify.new_catering',$data,function($message) use ($subject,$user) {
			$message->to(trim($user->user_Email),$user->user_FullName);
			$message->subject($subject);
		});
		$data['tosufrati']=true;
		Mail::queue('emails.notify.new_catering',$data,function($message) use ($subject,$teamemails) {
			foreach ($teamemails as $email) {
				$message->to(trim($email),'Sufrati');
			}
			$message->subject($subject);
		});
	}

	public function getEvent($event){
		$event=DB::table('user_event')->where('id',$event)->first();
		$user=DB::table('user')->select('user_ID','user_Mobile','user_Email','user_FullName')->where('user_ID',$event->user_ID)->first();
		$country=MGeneral::getCountry(1);
		$data=array('event'=>$event,'user'=>$user,'country'=>$country);
		$data['html']=stripcslashes(View::make('ajax.cateringevent',$data));
		return Response::json($data);
	}

	public function cancelEvent($event=0){
		$lang=Config::get('app.locale');
		$event=DB::table('user_event')->where('id',$event)->first();
		$user=DB::table('user')->select('user_ID','user_Mobile','user_Email','user_FullName')->where('user_ID',$event->user_ID)->first();
		$country=MGeneral::getCountry(1);
		User::cancelEvent($event->id);
		$logo=MGeneral::getLogo();
		$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
		$data=array(
			'lang'=>$lang,
			'event'=>$event,
			'user'=>$user,
			'logoimage'=>$logoimage,
			'country'=>$country
		);
		$teamemails=explode(",",$country->teamemail);
		$subject='You cancelled your event Ref:- SUF000'.$event->id;
		Mail::queue('emails.notify.cancel_event',$data,function($message) use ($subject,$user) {
			$message->to(trim($user->user_Email),$user->user_FullName);
			$message->subject($subject);
		});
		$subject=$user->user_FullName.' cancelled their event Ref:- SUF000'.$event->id;
		$data['tosufrati']=true;
		Mail::queue('emails.notify.cancel_event',$data,function($message) use ($subject,$teamemails) {
			foreach ($teamemails as $email) {
				$message->to(trim($email),'Sufrati');
			}
			$message->subject($subject);
		});
		return Redirect::to('user/'.$user->user_ID.'#user-events');
	}

	public function terms(){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		$data['meta']=array(
			'title'=>Lang::get('messages.catering_terms'),
            'metadesc'=>Lang::get('messages.catering_terms'),
		);
		return View::make('catering_terms',$data);
	}


}