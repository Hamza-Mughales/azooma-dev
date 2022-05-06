<?php
class LoginController extends BaseController {

	public function index()	{
		$t=array();
		if(Input::has('function')){
			$inputs=Input::all();
			foreach ($inputs as $key => $value) {
				Cookie::queue($key,$value,600);
			}
		}
		$data['html']=stripcslashes(View::make('ajax.login',$t));
		return Response::json($data);
	}
	public function l(){
		$output=array();
		$rules=array(
			'user-email'=>'required|email',
			'user-password'=>'required'
		);
		$validator=Validator::make(Input::all(),$rules);
		if($validator->fails()){
			$output['error']=Lang::get('messages.please_enter_all_fields');
		}else{
			$email=Input::get('user-email');
			$emailexists=DB::select(DB::raw('SELECT user_ID FROM user WHERE user_Email=:email'),array('email'=>$email));
			if(count($emailexists)>0){
				//user is present
				$password=Input::get('user-password');
				$logincheck=User::Login($email,sha1($password.Config::get('app.key')));
				if(count($logincheck)>0){
					//Login user
					$user=$logincheck[0];
					$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
					if(Input::has('rememberme')){
						Config::set('session.lifetime',365*12*3600);
					}
					Session::put('name',$username);
					Session::put('userid',$user->user_ID);
					Session::put('fbid',$user->facebook);
					Session::put('fb_publish',$user->fbPublish);
					$output['user_ID']=$user->user_ID;
				}else{
					$output['error']=Lang::get('messages.you_entered_wrong_password');
				}
			}else{
				$output['error']=Lang::get('messages.sorry_that_email_is_not_registered',array('email'=>$email));
			}
			
		}
		return Response::json($output);
	}


	public function f(){
		if(Input::has('fbid')){
			$facebookid=Input::get('fbid');
			$email=Input::get('email');
			$dob=Input::get('dob');	
			$name=Input::get('name');
			$location=Input::get('location');
			$gender=Input::get('gender');
			$publish=Input::get('publish');
			$user=User::FBLogin(Input::get('fbid'),$email);
			if($user){
				User::updateFromFB($user->user_ID,$email,$dob,$name,$gender,$publish);
				$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				Config::set('session.lifetime',365*12*3600);
				Session::put('name',$username);
				Session::put('userid',$user->user_ID);
				Session::put('fbid',$user->facebook);
				Session::put('fb_publish',$user->fbPublish);
				$output['user_ID']=$user->user_ID;
				if($user->image==""){
					$fbimage = file_get_contents('https://graph.facebook.com/'.$user->facebook.'/picture?width=500');
					$image=uniqid('sufrati') .$user->user_ID.'.jpg';
                    file_put_contents("uploads/images/" .$image, $fbimage);
                    DB::table('user')->where('user_ID',$user->user_ID)->update(array('image'=>$image));
                    $largeLayer=PHPImageWorkshop\ImageWorkshop::initFromPath(public_path() . "/uploads/images/".$image);
                    $largeLayer->cropMaximumInPixel(0, 0, "MM");
                	$changelayer=clone $largeLayer;
                	$layer=clone $changelayer;
                    $layer->resizeInPixel(100, 100);
		            $layer->save(public_path()."/uploads/images/100/",$image,true,null,95);
		            $layer=clone $changelayer;
                    $layer->resizeInPixel(130, 130);
		            $layer->save(public_path()."/uploads/images/userx130/",$image,true,null,95);
                    $layer->resizeInPixel(30, 30);
		            $layer->save(public_path()."/uploads/images/user_thumb/",$image,true,null,95);
	                //resize
				}
				$locationcheck=Input::get('location');
                $countrycheck=explode(',', $locationcheck);
                $userfacebookcountry=$countrycheck[1];
                if(($user->user_City=="")||!is_numeric($user->user_City)){
					if($countrycheck[0]!=""){
	            		$city=DB::table('city_list')->where('city_Name',$locationcheck[0])->first();
	            		DB::table('user')->where('user_ID',$user->user_ID)->update(array('user_City'=>$city->city_ID));
	            	}
	            }
			}else{
				//register
				$cityid=$countryid=0;$countryurl='';
				if(Session::has('sfcity')){
					$city=Session::get('sfcity');
					 $city=DB::table('city_list')->select('city_ID','country')->where('city_ID',$city)->first();
					// $city=DB::table('city_list')->select('city_ID','country')->where('city_ID',1)->first();
					if(count($city)>0){
						$cityid=$city->city_ID;
						$countryid=$city->country;
						$country=MGeneral::getCountry($city->country);
						$countryurl=strtoupper($country->url);
					}
				}else{
					$locationcheck=Input::get('location');
	                $countrycheck=explode(',', $locationcheck);
	                $userfacebookcountry=$countrycheck[1];
					if(Input::get('location')){
                        if($userfacebookcountry!=""){
                        	$country=DB::table('countries')->where('name',$userfacebookcountry)->first();
	                        if(count($country)>0){
	                        	$countryurl=$country->country;
	                        }
                        }
                        if($countrycheck[0]!=""){
		            		$city=DB::table('city_list')->where('city_Name',$locationcheck[0])->first();
		            		if(count($country)>0){
		            			$countryid=$city->country;
		            			$city=$city->city_ID;
		            		}
		            	}
                    }
				}
				$googleid=0;
				if(Input::has('googleid')){
					$googleid=Input::get('googleid');
				}
				$password='';
				$user=User::register($name,$email,$password,0,$cityid,$countryid,$googleid,$facebookid,$countryurl);
				$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				Config::set('session.lifetime',365*12*3600);
				Session::put('name',$username);
				Session::put('userid',$user->user_ID);
				Session::put('fbid',$user->facebook);
				Session::put('fb_publish',$user->fbPublish);
				$country=MGeneral::getCountry($city->country);
				$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
				$lang=Config::get('app.locale');
			    $logoimage=($lang=="en")?$logo->image:$logo->image_ar;
				$data=array(
					'logoimage'=>$logoimage,
					'title'=>'Sufrati',
					'country'=>$country,
					'heading'=>Lang::get('email.welcome_to_sufrati'),
					'helper'=>Lang::get('email.welcome_helper'),
					'action'=>Lang::get('email.activate'),
					'actionlink'=>Azooma::URL('welcome/'.$user->rand_num)
				);
				Mail::queue('emails.general',$data,function($message) use ($user) {
					$message->to($user->user_Email,$user->user_FullName)->subject('Activate account | Azooma');
				});
				$output['message']=Lang::get('messages.registered_check_email',array('email'=>$email));
			}
			return Response::json($output);
		}
	}

	public function register(){
		if(Input::has('registeremail')){
			$email=Input::get('registeremail');
			$name=Input::get('registername');
			$password=Input::get('registerpassword');
			$phone=Input::get('full_phone');
			// $dob=Input::get('year').'-'.Input::get('month').'-'.Input::get('birthday');
			$password=sha1($password.Config::get('app.key'));
			$checkuser=DB::table('user')->where('user_Email',$email)->count();
			if($checkuser>0){
				$output['error']=Lang::get('messages.email_exists',array('email'=>Input::get('registeremail')));
			}else{
				//register
				$cityid=$country=0;$countrycode="";
				if(Session::has('sfcity')){
					$city=Session::get('sfcity');
					$city=DB::table('city_list')->select('city_ID','country')->where('city_ID',$city)->first();
					if(count($city)>0){
						$cityid=$city->city_ID;
						$country=MGeneral::getCountry($city->country);
						$countrycode=strtoupper($country->url);
					}
				}
				$googleid=0;
				if(Input::has('googleid')){
					$googleid=Input::get('googleid');
				}
				$user=User::register($name,$email,$password,$phone,$cityid,1,$googleid,$countrycode);
				if(Input::has('googleid')){
					if(Input::has('photo')){
						$image=Input::get('photo');
						$fbimage = file_get_contents($image.'0');
						$image=uniqid('sufrati') .$user->user_ID.'.jpg';
		                file_put_contents("uploads/images/" .$image, $fbimage);
		                DB::table('user')->where('user_ID',$user->user_ID)->update(array('image'=>$image));
	                    $largeLayer=PHPImageWorkshop\ImageWorkshop::initFromPath(public_path() . "/uploads/images/".$image);
	                    $changelayer=clone $largeLayer;
	                	$layer=clone $changelayer;
	                    $layer->resizeInPixel(100, 100);
			            $layer->save(public_path()."/uploads/images/100/",$image,true,null,95);
			            $layer=clone $changelayer;
	                    $layer->resizeInPixel(130, 130);
			            $layer->save(public_path()."/uploads/images/userx130/",$image,true,null,95);
	                    $layer->resizeInPixel(30, 30);
			            $layer->save(public_path()."/uploads/images/user_thumb/",$image,true,null,95);
					}
				}
				$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				// Config::set('session.lifetime',365*12*3600);
				// Session::put('name',$username);
				// Session::put('userid',$user->user_ID);
				// Session::put('fbid',$user->facebook);
				// Session::put('fb_publish',$user->fbPublish);
				$country=MGeneral::getCountry($city->country);
				$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
				$lang=Config::get('app.locale');
				if($lang=="en"){
					$logoimage=$logo->image;
				}
				else{
					$logoimage= $logo->image_ar;
				}
				$data=array(
					'logoimage'=>$logoimage,
					'title'=>'Sufrati',
					'country'=>$country,
					'heading'=>Lang::get('email.welcome_to_sufrati'),
					'helper'=>Lang::get('email.welcome_helper'),
					'action'=>Lang::get('email.activate'),
					'actionlink'=>Azooma::URL('welcome/'.$user->rand_num)
				);
				Mail::queue('emails.general',$data,function($message) use ($user) {
					$message->to($user->user_Email,$user->user_FullName)->subject('Activate account | Azooma');
				});
				$output['message']=Lang::get('messages.registered_check_email',array('email'=>$email));
			}
			return Response::json($output);
		}
	}
	public function checkmailreg(){
		if(Input::has('registeremail')){
			$email=Input::get('registeremail');
			$checkuser=DB::table('user')->where('user_Email',$email)->count();
			if($checkuser>0){
				$output['error']=Lang::get('messages.email_exists',array('email'=>Input::get('registeremail')));
			}
			else
			{
				$output['message']=Lang::get('messages.registered_check_email',array('email'=>$email));
			}
		return Response::json($output);
	}
}

	public function logout(){
		if(Session::has('userid')){
			Session::forget('name');
			Session::forget('userid');
			Session::forget('fbid');
			Session::forget('fb_publish');
			return Redirect::back();	
		}
	}


	public function forgot(){
		$lang=Config::get('app.locale');
		if(Session::has('userid')){
			return Redirect::to('settings/password');
		}else{
			$email=Input::get('email');
			$checkuser=DB::table('user')->where('user_Email',$email)->count();
			if($checkuser>0){
				$user=DB::table('user')->where('user_Email',$email)->first();
				//Email reset Link
				if(Session::has('sfcity')){
					$cityid=$country=0;
					$city=Session::get('sfcity');
					$city=DB::table('city_list')->select('city_ID','country')->where('city_ID',$city)->first();
					$country=MGeneral::getCountry($city->country);
				}
				$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
			    $logoimage=($lang=="en")?$logo->image:$logo->image_ar;
				$data=array(
					'logoimage'=>$logoimage,
					'title'=>'Azooma',
					'country'=>$country,
					'heading'=>Lang::get('email.forgot_password_heading'),
					'helper'=>Lang::get('email.forgot_password_helper'),
					'action'=>Lang::get('email.reset_password'),
					'action_helper'=>Lang::get('email.reset_password_helper'),
					'actionlink'=>Azooma::URL('reset/'.$user->rand_num)
				); 
				 Mail::queue('emails.general',$data,function($message) use ($user) {
				 	$message->to($user->user_Email,$user->user_FullName)->subject('Reset Password | Azooma');
				 });
				$output=array(
					'message'=>Lang::get('messages.password_reset_link',array('email'=>$email))
				);
			}else{
				$output=array(
					'error'=>Lang::get('messages.sorry_that_email_is_not_registered',array('email'=>$email))
				);
			}
			return Response::json($output);
		}
		
	}


	public function reset($rand=""){
		if($rand!=""){
			$lang=Config::get('app.locale');
			$user=DB::table('user')->where('rand_num',$rand)->first();
			if(count($user)>0){
				$data['meta']=array(
					'title'=>Lang::get('email.reset_password'),
				);
				$data['lang']=$lang;
				$data['user']=$user;
				if(Input::has('succes')){
					$data['success']=1;
				}
				return View::make('user.reset',$data);	
			}else{
				App::abort(404);
			}
		}
	}

	public function resetPassword(){
		if(Input::get('id')){
			$rules=array(
				'new-password'=>'required',
				'confirm-password'=>'required|same:new-password'
			);
			$validator=Validator::make(Input::all(),$rules);
			$userid=Input::get('id');
			$user=DB::table('user')->where('user_ID',$userid)->first();
			if($validator->fails()){
				return Redirect::to('reset/'.$user->rand_num)->withErrors($validator);
			}else{
				if(count($user)>0){
					$password=Input::get('new-password');
					$password=sha1($password.Config::get('app.key'));
					DB::table('user')->where('user_ID',$userid)->update(array('user_Pass'=>$password));
					Session::flash('success',Lang::get('messages.password_change_successfully'));
					return Redirect::to('reset/'.$user->rand_num.'?success=1');	
				}else{
					App::abort(404);
				}
			}
		}
	}


	public function reactivate($user=0){
		$user=User::checkUser($user);
		$user=$user[0];
		$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
		Config::set('session.lifetime',365*12*3600);
		Session::put('name',$username);
		Session::put('userid',$user->user_ID);
		Session::put('fbid',$user->facebook);
		Session::put('fb_publish',$user->fbPublish);
		$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
		$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
		$data=array(
			'logoimage'=>$logoimage,
			'title'=>'Sufrati',
			'country'=>array(),
			'heading'=>Lang::get('email.welcome_to_sufrati'),
			'helper'=>Lang::get('email.welcome_helper'),
			'action'=>Lang::get('email.activate'),
			'action_helper'=>Lang::get('reset_password_helper'),
			'actionlink'=>Azooma::URL('welcome/'.$user->rand_num)
		);
		Mail::queue('emails.general',$data,function($message) use ($user) {
			$message->to($user->user_Email,$user->user_FullName)->subject('Activate account | Sufrati');
		});
		return Redirect::back();
	}


	public function welcome($rand="") {
		$lang=Config::get('app.locale');
		$user=DB::table('user')->where('rand_num',$rand)->first();
		if(count($user)>0){
			$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
			Config::set('session.lifetime',365*12*3600);
			Session::put('name',$username);
			Session::put('userid',$user->user_ID);
			Session::put('fbid',$user->facebook);
			Session::put('fb_publish',$user->fbPublish);
			DB::table('user')->where('rand_num',$rand)->update(array('user_Status'=>1));
			Session::flash('success',Lang::get('messages.account_activated_successfully'));
			// return Redirect::to('/step/0');
			if($user->profilecompletion < 3){
				return Redirect::to('step/'.$user->profilecompletion);
			}else{
				
				return Redirect::to('user/'.$user->user_ID);
			}
		}
	}


	public function checkEmail(){
		$email=Input::get('email');
		$user=DB::table('user')->where('user_Email',$email)->first();
		if(count($user)>0){
			//already exists, loggin
			if($user->google==0&&Input::has('googleid')){
				DB::table('user')->where('user_ID',$user->user_ID)->update(array('google'=>Input::get('googleid')));
			}
			$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
			Config::set('session.lifetime',365*12*3600);
			Session::put('name',$username);
			Session::put('userid',$user->user_ID);
			Session::put('fbid',$user->facebook);
			Session::put('fb_publish',$user->fbPublish);
			$output['user_ID']=$user->user_ID;
			$data=array(
				'exists'=>true
			);
		}else{
			//New user
			$data=array(
				'new'=>true
			);
		}
		return Response::json($data);
	}


	public function facebookConnect(){
		if(Session::has('userid')){
			if(Input::has('fbid')){
				$user=User::checkUser(Session::get('userid'))[0];
				DB::table('user')->where('user_ID',$user->user_ID)->update(array('facebook'=>Input::get('fbid')));
				if($user->user_FullName==""){
					$name=Input::get('name');
					DB::table('user')->where('user_ID',$user->user_ID)->update(array('user_FullName'=>$name));
				}
				if($user->user_BirthDate==""){
					$date=Input::get('dob');
					DB::table('user')->where('user_ID',$user->user_ID)->update(array('user_BirthDate'=>$date));
				}
				if($user->user_Sex==""){
					DB::table('user')->where('user_ID',$user->user_ID)->update(array('user_Sex'=>ucfirst(Input::get('gender'))));	
				}
				$locationcheck=Input::get('location');
                $countrycheck=explode(',', $locationcheck);
                $userfacebookcountry=$countrycheck[1];
				if($user->user_Country==""){
					if(Input::get('location')){
                        if($userfacebookcountry!=""){
                        	$country=DB::table('countries')->where('name',$userfacebookcountry)->first();
	                        if(count($country)>0){
	                        	DB::table('user')->where('user_ID',$user->user_ID)->update(array('user_Country'=>$country->country));
	                        }
                        }
                    }
				}
				if($user->image==""){
					$fbimage = file_get_contents('https://graph.facebook.com/'.Input::get('fbid').'/picture?width=500'); // sets $image to the contents of the url
                    $image=uniqid('sufrati') .$user->user_ID.'.jpg';
                    file_put_contents("uploads/images/" .$image, $fbimage);
                    DB::table('user')->where('user_ID',$user->user_ID)->update(array('image'=>$image));
                    $largeLayer=PHPImageWorkshop\ImageWorkshop::initFromPath(public_path() . "/uploads/images/".$image);
                    $changelayer=clone $largeLayer;
                	$layer=clone $changelayer;
                    $layer->resizeInPixel(100, 100);
		            $layer->save(public_path()."/uploads/images/100/",$image,true,null,95);
		            $layer=clone $changelayer;
                    $layer->resizeInPixel(130, 130);
		            $layer->save(public_path()."/uploads/images/userx130/",$image,true,null,95);
                    $layer->resizeInPixel(30, 30);
		            $layer->save(public_path()."/uploads/images/user_thumb/",$image,true,null,95);
				}
				if(($user->user_City=="")||!is_numeric($user->user_City)){
					if($countrycheck[0]!=""){
	            		$city=DB::table('city_list')->where('city_Name',$locationcheck[0])->first();
	            		DB::table('user')->where('user_ID',$user->user_ID)->update(array('user_City'=>$city->city_ID));
	            	}
	            }
			}
		}
	}

}