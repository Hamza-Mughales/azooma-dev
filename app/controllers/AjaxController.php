<?php

use Illuminate\Support\Facades\Response;

class AjaxController extends BaseController {
	public function __construct(){
	}

	public function comments($rest=0,$loaded=0)	{
		$lang=Config::get('app.locale');
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$city= MGeneral::getCityURL($cityurl,true);
		$rest=MRestaurant::getRest($rest,true,true);
		if(count($rest)>0){
			$comments=MRestaurant::getReviews($rest->rest_ID,$city->city_ID,10,$loaded);
			$reviewhelper=array(
				'userreviews'=>$comments,
				'rest'=>$rest,
				'city'=>$city
			);
			$data['html']=stripcslashes(View::make('rest.helpers._reviews',$reviewhelper));
			$data['loaded']=$loaded+count($comments);
			return Response::json($data);
		}else{
			App::abort(404);
		}
	}

	public function addComment(){
		$lang=Config::get('app.locale');
		if(Session::has('userid')){
			$userid=Session::get('userid');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$restid=Input::get('rest');
			$rest= DB::table('restaurant_info')->select('rest_ID','rest_Email','seo_url','rest_Name','rest_Name_Ar')->where('rest_ID',$restid)->first();
			$rules=array(
				'user-comment'=>'required|min:5'
			);
			$messages=array('user-comment.required'=>Lang::get('messages.please_add_review'));
			$validator=Validator::make(array('user-comment'=>Input::get('user-comment')),$rules,$messages);
			if($validator->fails()){
				return Redirect::to($cityurl.'/'.$rest->seo_url.'#n')->withErrors($validator);
			}else{
				$ratings=array();
				$city= MGeneral::getCityURL($cityurl,true);
				if(Input::has('food')&&Input::has('service')&&Input::has('atmosphere')&&Input::has('presentation')&&Input::has('value')&&Input::has('variety')){
					if(Input::get('food')!=0&&Input::get('service')!=0&&Input::get('atmosphere')!=0&&Input::get('presentation')!=0&&Input::get('value')!=0&&Input::get('variety')!=0){
						$ratingactivity=User::AddRating($userid,$rest->rest_ID,$city->city_ID,$city->country,Input::get('food'),Input::get('service'),Input::get('atmosphere'),Input::get('presentation'),Input::get('value'),Input::get('variety'));
						//Add Activity for rating
						User::AddActivity($userid,$rest->rest_ID,'rated on','التقييم على',$ratingactivity,$city->city_ID,$city->country);
						$ratings=array(
							'food'=>Input::get('food'),
							'service'=>Input::get('service'),
							'atmosphere'=>Input::get('atmosphere'),
							'presentation'=>Input::get('presentation'),
							'value'=>Input::get('value'),
							'variety'=>Input::get('variety'),
						);
					}
				}
				$country=MGeneral::getCountry($city->country);
				$user=User::checkUser($userid)[0];
				$comment=Input::get('user-comment');
				$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				if(!Azooma::checkSpam($comment,$user->user_Email,$username)){
					if(Input::has('recommend')){
						$recommend=1;
					}else{
						$recommend=0;
					}
					User::AddReview($comment,$userid,$rest->rest_ID,$city->city_ID,$city->country,$recommend,Input::get('mealtype'));
					//Notify restaurant 
					$logo=MGeneral::getLogo();
					$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
					$data=array(
						'user'=>$user,
						'rest'=>$rest,
						'comment'=>$comment,
						'rating'=>$ratings,
						'city'=>$city,
						'username'=>$username,
						'country'=>$country,
						'logoimage'=>$logoimage
					);
					$subject='New comment on '.$rest->rest_Name.' by '.$username;
					$teamemails=explode(",",$country->teamemail);
					$restname=$rest->rest_Name;
					Mail::queue('emails.notify.newreview',$data,function($message) use ($subject,$teamemails) {
						foreach ($teamemails as $email) {
							$message->to(trim($email),'Azooma');
						}
						$message->subject($subject);
					});
					if($rest->rest_Email!=""){
						$emails=explode(",",$rest->rest_Email);
						$data['torestaurant']=true;
						Mail::queue('emails.notify.newreview',$data,function($message) use ($subject,$emails,$restname) {
							foreach ($emails as $email) {
								$message->to($email,$restname);
							}
							$message->subject($subject);
						});
					}

					DB::table('notifications')->insert(
						[
							'user_ID' => $userid,
							'rest_ID' => $rest->rest_ID,
							'status' => 1,
							'detail' => 'new review '. $comment
						]
					);
					

					Session::flash('success',Lang::get('messages.thank_for_review'));
					return Redirect::to($cityurl.'/'.$rest->seo_url.'#n');
				}else{
					DB::select(DB::raw("UPDATE spamkiller SET killed=killed+1 WHERE id=1"));
					Session::flash('error',Lang::get('messages.security_reasons'));
					return Redirect::to($cityurl.'/'.$rest->seo_url.'#n');
				}
			}
		}
	}


	public function addLike($restid=0){
		if(Session::has('userid')){
			$rest= DB::table('restaurant_info')->select('rest_ID','seo_url')->where('rest_ID',$restid)->first();
			if(count($rest)>0){
				if(Session::has('sfcity')){
					$city=MGeneral::getCity(Session::get('sfcity'),true);
				}else{
					$city=MGeneral::getPossibleCity($rest->rest_ID);
				}
				if(Input::get('removelike')==1){
					//remove like
					$activity=DB::table('likee_info')->where('user_ID',Session::get('userid'))->where('rest_ID',$rest->rest_ID)->first();
					User::RemoveLikeRest($rest->rest_ID,Session::get('userid'));
					User::DeleteActivity(Session::get('userid'),$rest->rest_ID,'liked',$activity->id,$city->city_ID,$city->country);
				}else{
					if(Input::get('like')==1){
					//like or dislike the restaurant
						$checkliked=Azooma::checkUserLiked($rest->rest_ID,Session::get('userid'));
						if(count($checkliked)>0){
							if($checkliked->status!=1){
								DB::table('likee_info')->where('id',$checkliked->id)->update(array('status',1));
							}
							$activityid=$checkliked->id;
						}else{
							$activityid=User::LikeRest($rest->rest_ID,Session::get('userid'),Session::get('sfcity'),1,$city->country);
							//Add activity for like
							User::AddActivity(Session::get('userid'),$rest->rest_ID,'liked','أحب',$activityid,$city->city_ID,$city->country);
						}
						$data=array('like'=>$activityid,'city'=>$city->seo_url,'rest'=>$rest->seo_url);
						return Response::json($data);
					}else{
						//remove like
						$checkliked=Azooma::checkUserLiked($rest->rest_ID,Session::get('userid'));
						if(count($checkliked)>0){
							if($checkliked->status!=1){
								DB::table('likee_info')->where('id',$checkliked->id)->update(array('status',0));
							}
							$activityid=$checkliked->id;
						}else{
							$activityid=User::LikeRest($rest->rest_ID,Session::get('userid'),Session::get('sfcity'),0,$city->country);
							//Add activity for like
							//User::AddActivity(Session::get('userid'),$rest->rest_ID,'liked','أحب',$activityid,$city->city_ID,$city->country);
						}						
					}
				}
			}else{
				App::abort(404);
			}
		}
	}

	public function addFBLike(){
		if(Input::has('fbactivity')&&Input::has('liked')){
			DB::table('likee_info')->where('id',Input::get('liked'))->update(array('facebook'=>Input::get('fbactivity')));
		}
	}


	public function addRating(){
		if(Session::has('userid')){
			$restid=Input::get('rest');
			$rest=MRestaurant::getRest($restid,true,true);
			$lang=Config::get('app.locale');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$ratingactivity=User::AddRating(Session::get('userid'),$rest->rest_ID,$city->city_ID,$city->country,Input::get('foodMini'),Input::get('serviceMini'),Input::get('atmosphereMini'),Input::get('presentationMini'),Input::get('valueMini'),Input::get('varietyMini'));
			//Add Activity for rating
			User::AddActivity(Session::get('userid'),$rest->rest_ID,'rated on','التقييم على',$ratingactivity,$city->city_ID,$city->country);
			$ratinginfo=MRestaurant::getRatingInfo($rest->rest_ID)[0];
			$data['ratinginfo']=$ratinginfo;
			return Response::json($data);
		}
	}

	public function follow(){
		if(Session::has('userid')){
			$lang=Config::get('app.locale');
			if(Input::get('user')){
				$checkfollowing=User::checkFollowing(Session::get('userid'),Input::get('user'));
				if(Session::has('sfcity')){
					$cityid=Session::get('sfcity');
				}else{
					$cityid=1;
				}
				$city=MGeneral::getCity($cityid,true);
				$country=MGeneral::getCountry($city->country);
				if(Input::get('follow')==1){
					//follow
					if($checkfollowing==0){
						$activityid=User::followUser(Session::get('userid'),Input::get('user'));
						//Activity and email
						
						User::AddActivity(Session::get('userid'),0,'followed','',Input::get('user'),0,$city->country); 
						$currentuser=User::checkUser(Session::get('userid'))[0];
						$followeduser=User::checkUser(Input::get('user'))[0];
						$currentusername=($currentuser->user_NickName=="")?stripcslashes($currentuser->user_FullName):stripcslashes($currentuser->user_NickName);
						$followedusername=($followeduser->user_NickName=="")?stripcslashes($followeduser->user_FullName):stripcslashes($followeduser->user_NickName);
						$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
			        	$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
						$data=array(
							'logoimage'=>$logoimage,
							'currentuser'=>$currentuser,
							'followeduser'=>$followeduser,
							'currentusername'=>$currentusername,
							'lang'=>$currentuser->lang,
							'country'=>$country,
							'followedusername'=>$followedusername
						);
						/*
						Mail::queue('emails.user.follownotify',$data,function($message) use ($followeduser,$currentusername,$followedusername) {
							$message->to($followeduser->user_Email,$followedusername)->subject(Lang::get('email.follow_subject', array('username'=>$currentusername), $followeduser->lang).' | '.Lang::get('messages.azooma',array(),$followeduser->lang));
						});
						*/
					}
				}else{
					//unfollow
					if($checkfollowing>0){
						User::unFollowUser(Session::get('userid'),Input::get('user'));
						User::DeleteActivity(0,Session::get('userid'),'followed','',Input::get('user'),0,$city->country); 
					}
				}
			}
		}
	}


	public function addToList(){
		if(Session::has('userid')){
			$lang=Config::get('app.locale');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$restid=Input::get('rest');
			$rest= MRestaurant::getRest($restid,true,true);
			if(Input::has('new-user-list')&&Input::get('new-user-list')!=""){
				User::addList(Session::get('userid'),Input::get('new-user-list'),$rest->rest_ID,$city->country);
			}
			$lists=Input::get('userlist');
			foreach ($lists as $list) {
				User::addToList($list,$rest->rest_ID,Session::get('userid'),$city->country);
			}
			return Redirect::to($cityurl.'/'.$rest->seo_url.'#n');
		}else{
			App::abort(404);
		}
	}


	public function addPhoto(){
		if(Session::has('userid')){
			$lang=Config::get('app.locale');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$restid=Input::get('rest');
			$rest= MRestaurant::getRest($restid,true,true);
			$name = Input::file('photo')->getClientOriginalName();
			$image=uniqid('sufrati').$name;
			$largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($_FILES['photo']['tmp_name']);
            $thumbLayer = clone $largeLayer;
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            if($actualHeight<=400||$actualWidth<=400){
            	Session::flash('error',Lang::get('messages.photo_too_small'));
            	if($lang=="ar"){
            		return Redirect::to('ar/'.$cityurl.'/'.$rest->seo_url.'#n');
            	}else{
            		return Redirect::to($cityurl.'/'.$rest->seo_url.'#n');
            	}
            }else{
	            $ratio = $actualWidth / $actualHeight;
	            $largeLayer->save(Config::get('settings.uploadpath') . "/Gallery/fullsize/", $image, true, null, 80);
				$conserveProportion = true;
                $positionX = 0; // px
                $positionY = 0; // px
                $position = 'MM';
				$text_font = $rest->rest_Name . '- azooma.co';
                $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                $textLayer->opacity(75);
                $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                if (($actualWidth > 800)) {
               //     $largeLayer->resizeInPixel(800, null, $conserveProportion, $positionX, $positionY, $position);
                }else{
                	if($actualHeight>500){
                	//	$largeLayer->resizeInPixel(null, 500, $conserveProportion, $positionX, $positionY, $position);	
                	}
                }
                $actualWidth=$largeLayer->getWidth();
                $actualHeight=$largeLayer->getHeight();
                $largeLayer->save(Config::get('settings.uploadpath'). "/Gallery/", $image, true, null, 95);
                $height1 = round($actualHeight * (200 / $actualWidth));
                $height2 = round($actualHeight * (230 / $actualWidth));

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$image);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer=clone $layer;
                $expectedWidth = 200;
                $expectedHeight = $height1;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/200/", $image, true, null, 95);
                $changelayer=clone $layer;
                $expectedWidth = 230;
                $expectedHeight = $height2;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/230/", $image, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(45, 45);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/45/", $image, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(200, 200);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/200x200/", $image, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(150, 150);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/150x150/", $image, true, null, 95);
                $theight = $actualHeight * (400 / $actualWidth);
                $expectedWidth = 400;
                $expectedHeight = $theight;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer=clone $layer;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/400x/", $image, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/thumb/", $image, true, null, 95);

				$data=array(
					'rest_ID'=>Input::get('rest'),
					'title'=>Input::get('photo-caption'),
					'title_ar'=>'',
					'image_full'=>$image,
					'image_thumb'=>$image,
					'status'=>0,
					'user_ID'=>Session::get('userid'),
					'ratio'=>$ratio,
					'width'=>$actualWidth,
					'is_featured'=>0,
					'branch_ID'=>0,
					'city_ID'=>$city->city_ID,
					'country'=>$city->country,
					'updatedAt'=>date('Y-m-d H:i:s')
				);	
				DB::table('image_gallery')->insert($data);
				Session::flash('success',Lang::get('messages.photo_waiting_for_review_thanks'));
				if($lang=="ar"){
            		return Redirect::to('ar/'.$cityurl.'/'.$rest->seo_url.'#n');
            	}else{
            		return Redirect::to($cityurl.'/'.$rest->seo_url.'#n');
            	}
            }
		}
	}


	public function claimRestaurant(){
		if(Input::has('claim_name')){
			$lang=Config::get('app.locale');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$restid=Input::get('rest');
			$rest= MRestaurant::getRest($restid,true,true);
			$country=MGeneral::getCountry($city->country);
			$logo=MGeneral::getLogo();
			$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
			$data['info']=array(
				'name'=>Input::get('claim_name'),
				'email'=>Input::get('claim_email'),
				'telephone'=>Input::get('claim_tel'),
				'position'=>Input::get('claim_position'),
				'headoffice'=>Input::get('headoffice'),
				'website'=>Input::get('website'),
				'comments'=>Input::get('comments')
			);
			$data['city']=$city;
			$data['logoimage']=$logoimage;
			$data['rest']=$rest;
			$data['country']=$country;
			$subject='Get in Touch Request for '.stripcslashes($rest->rest_Name);
			Mail::queue('emails.internal.claimrestaurant',$data,function($message) use ($subject) {
				$s=array('fasi.manu@gmail.com','fasil@azooma.co');
				$message;
				foreach ($s as $email) {
					$message->to($email,'Azooma');
				}
				$message->subject($subject);
			});
			Session::flash('success',Lang::get('messages.someone_will_contact'));
			if($lang=="ar"){
				return Redirect::to('ar/'.$cityurl.'/'.$rest->seo_url);
			}else{
				return Redirect::to($cityurl.'/'.$rest->seo_url);	
			}
			
		}
	}

	public function likePhoto(){
		if(Session::has('userid')){
			$data=array();
			$lang=Config::get('app.locale');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$checkliked=User::checkPhotoLiked(Input::get('photo'),Session::get('userid'));
			if(Input::get('liked')==1){
				if($checkliked<=0){
					$liked=User::likePhoto(Input::get('photo'),Session::get('userid'),$city->country);	
					$data=array(
						'liked'=>$liked
					);
				}
				
			}else{
				if($checkliked>0){
					$removed=User::unLikePhoto(Input::get('photo'),Session::get('userid'));
					$data=$removed;
				}
			}
			return Response::json($data);
		}
	}

	public function addFBLikePhoto(){
		if(Session::has('userid')){
			if(Input::has('fbactivity')&&Input::has('liked')){
				$data=array('fbActivityID'=>Input::get('fbactivity'));
				DB::table('photolike')->where('id',Input::get('liked'))->update($data);
			}
		}
	}

	public function websiteRef(){
		if(Input::has('rest')){
			$lang=Config::get('app.locale');
			$restid=Input::get('rest');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$data=array(
				'restID'=>$restid,
				'city_ID'=>$city->city_ID,
				'country'=>$city->country
			);
			DB::table('rest_website_visits')->insert($data);
		}
	}

	public function downloadMenu(){
		if(Input::has('rest')){
			$lang=Config::get('app.locale');
			$menu=Input::get('menu');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$menu=DB::table('rest_menu_pdf')->where('id',$menu)->first();
			$data=array(
				'restID'=>$menu->rest_ID,
				'menuID'=>$menu->id,
				'city_ID'=>$city->city_ID,
				'country'=>$city->country
			);
			DB::table('menu_downloads')->insert($data);
		}
	}

	public function downloadMenuNew($rest = null, $id = null){
		if($rest){
			
			$lang = Config::get('app.locale');
			
			$menu=DB::table('rest_menu_pdf')->where('id', $id)->first();
			
			if($lang=="ar"){
				$cityurl=Request::segment(2);
				$menu_name = $menu->menu_ar;
				$the_menu = menu_pdf_path().$menu->menu_ar;
			}else{
				$cityurl=Request::segment(1);
				$menu_name = $menu->menu;
				$the_menu = menu_pdf_path().$menu->menu;
			}
			
			$city= MGeneral::getCityURL($cityurl,true);
			$data=array(
				'restID'=>$menu->rest_ID,
				'menuID'=>$menu->id,
				'country'=>$city->country
			);

			DB::table('menu_downloads')->insert($data);

			return Response::download($the_menu, $menu_name, ['Content-Type: application/pdf']);
		}
	}

	public function menuRequest(){
		if(Input::has('rest')){
			$lang=Config::get('app.locale');
			$restid=Input::get('rest');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$city= MGeneral::getCityURL($cityurl,true);
			$rest= DB::table('restaurant_info')->select('rest_ID','seo_url','rest_Name','rest_Name_Ar','country','rest_Email')->where('rest_ID',$restid)->first();
			$restname=$rest->rest_Name;
			$country=MGeneral::getCountry($city->country);
			$otherrequesters=MRestaurant::getAllMenuRequests($rest->rest_ID);
			if(Session::has('userid')){
				$user=User::checkUser(Session::get('userid'),true);
				$name=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_FullName);
				$email=$user->user_Email;
			}else{
				$name=Input::get('menuname');
				$email=Input::get('menuemail');
				if(Input::has('register')){
					//register new account
					$checkuser=DB::table('user')->where('user_Email',$email)->count();
					if($checkuser<=0){
						$password="hungry".mt_rand(100,1000);
						$dob=NULL;
						$user=User::register($name,$email,$password,0,$city->city_ID,$city->country,'','',strtoupper($country->url));
						$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
						$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
						$data=array(
							'logoimage'=>$logoimage,
							'title'=>'Azooma',
							'country'=>$country,
							'heading'=>Lang::get('email.welcome_to_sufrati'),
							'helper'=>Lang::get('email.welcome_helper'),
							'action'=>Lang::get('email.activate'),
							'action_helper'=>Lang::get('messages.your').' '.Lang::get('messages.password').' : '.$password,
							'actionlink'=>Azooma::URL('welcome/'.$user->rand_num),
							'password'=>$password
						);
						Mail::queue('emails.general',$data,function($message) use ($user) {
							$message->to($user->user_Email,$user->user_FullName)->subject('Activate account | Azooma');
						});
					}
				}elseif (Input::has('subscribe')) {
					//add a new subscriber
					$checksubscribed=DB::table('subscribers')->where('email',$email)->count();
					if($checksubscribed<=0){
						$subdata=array(
							'name'=>$name,
							'email'=>$email,
							'city'=>$city->city_ID,
							'restaurant'=>0,
							'status'=>1,
							'external'=>0,
							'bademail'=>0,
							'college'=>0,
							'country'=>$city->country,
						);
						DB::table('subscribers')->insert($subdata);
					}
				}
			}
			$msg='';
			
			if(Input::has('menutext')){
				$msg=Input::get('menutext');
			}
			$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
			$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
			$data=array(
				'name'=>$name,
				'email'=>$email,
				'rest'=>$rest,
				'city'=>$city,
				'country'=>$country,
				'msg'=>$msg,
				'logoimage'=>$logoimage
			);
			DB::table('menurequest')->insert(array('rest_ID'=>$rest->rest_ID,'name'=>$name,'email'=>$email,'message'=>$msg,'is_read'=>0,'is_notified'=>0,'country'=>$rest->country));
			$teamemails=explode(",",$country->teamemail);
			$subject='Menu Request for '.stripcslashes($rest->rest_Name).' by '.$name;
			if($rest->rest_Email!=""){
				$subject=$name.' Requests your Menu on Azooma';
				$checkmember=MRestaurant::checkMember($rest->rest_ID);
				$data['checkmember']=$checkmember;
				$data['otherrequesters']=$otherrequesters;
				$emails=explode(",",$rest->rest_Email);
				$subject=$name.' Requests your Menu on Azooma'.
				Mail::queue('emails.restaurant.menurequest_rest',$data,function($message) use ($subject,$emails,$restname,$teamemails) {
					foreach ($emails as $email) {
						$message->to($email,$restname);
					}
					foreach ($teamemails as $email) {
						$message->bcc($email,'Azooma');
					}
					$message->subject($subject);
				});
			}
			Session::flash('success',Lang::get('messages.menu_request_sent_successfully'));
			if($lang=="ar"){
				return Redirect::to('ar/'.$cityurl.'/'.$rest->seo_url.'#n');
			}else{
				return Redirect::to($cityurl.'/'.$rest->seo_url.'#n');	
			}
		}
	}

	public function recommendMenu(){
		if(Session::has('userid')){
			if(Input::has('menu')&&Input::has('recommend')){
				$lang=Config::get('app.locale');
				if($lang=="ar"){
					$cityurl=Request::segment(2);
				}else{
					$cityurl=Request::segment(1);
				}
				$city= MGeneral::getCityURL($cityurl,true);
				$recommend=Input::get('recommend');
				$menu=Input::get('menu');
				$checkrecommended=MRestaurant::checkUserRecommended(Session::get('userid'),$menu);
				if($recommend==1){
					$item=MRestaurant::getMenuItem($menu)[0];
					if($checkrecommended<=0){
						$activity=MRestaurant::recommendMenu($menu,Session::get('userid'),$city->country);
						User::AddActivity(Session::get('userid'),$item->rest_fk_id,'recommend menu','',$activity,$city->city_ID,$city->country);	
					}
				}else{
					if($checkrecommended>0){
						MRestaurant::unrecommendMenu($menu,Session::get('userid'),$city->country);
					}
				}
			}
		}
	}

	public function agreeComment(){
		if(Session::has('userid')){
			if(Input::has('review')&&Input::has('agree')){
				$lang=Config::get('app.locale');
				if($lang=="ar"){
					$cityurl=Request::segment(2);
				}else{
					$cityurl=Request::segment(1);
				}
				$city= DB::table('city_list')->select('city_ID','country')->where('seo_url',$cityurl)->first();
				$agree=Input::get('agree');
				$review=Input::get('review');
				$checkagreed=MRestaurant::checkUserAgreed(Session::get('userid'),$review);
				$review=MRestaurant::getReview($review);
				if($agree==1){
					if($checkagreed<=0){
						MRestaurant::agreeComment(Session::get('userid'),$review->review_ID,$city->city_ID,$review->rest_ID,$city->country);
					}
				}else{
					if($checkagreed>0){
						MRestaurant::removeAgreeComment(Session::get('userid'),$review->rest_ID,$city->country);
					}
				}
			}
		}
	}


	public function locations(){
		$tcountries=DB::table('aaa_country')->select('id','name','nameAr','url')->get();
		$countries=array();
		foreach ($tcountries as $country) {
			$cities=DB::table('city_list')->select('city_ID','city_Name','city_Name_Ar','seo_url','city_thumbnail')->where('city_Status',1)->where('country',$country->id)->get();
			$i=0;
			if(count($cities)>0){
				$country->cities=$cities;
				$countries[]=$country;
				$i++;
			}
		}
		$lang=Config::get('app.locale');
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
			$t['countries']=$countries;
			$t['lang']=$lang;
			$data['html']=stripcslashes(View::make('ajax.locations',$t));
			return Response::json($data);
		}else{

		}
	}

	public function removeFromList(){
		if(Input::has('list')&&Input::has('rest')){
			$list=Input::get('list');
			$rest=Input::get('rest');
			if(Session::has('userid')){
				$userid=Session::get('userid');
				DB::table('user_list_restaurant')->where('rest_ID',$rest)->where('list_id',$list)->where('user_ID',$userid)->delete();
			}
		}
	}

	public function deleteList(){
		if(Input::has('list')&&Session::has('userid')){
			$list=Input::get('list');
			$userid=Session::get('userid');
			DB::table('user_lists')->where('id',$list)->delete();
			DB::table('user_list_restaurant')->where('list_id',$list)->where('user_ID',$userid)->delete();
		}
	}

	public function inviteGmail(){
		$lang=Config::get('app.locale');
		if(Session::has('userid')){
			$currentuserid=Session::get('userid');
			$currentuser=User::checkUser(Session::get('userid'),true);
			$username=$currentuser->user_FullName;
			$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
			$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
			if(Session::has('sfcity')){
				$cityid=Session::get('sfcity');
			}else{
				$cityid=1;
			}
			$city= MGeneral::getCity($cityid);
			$country=MGeneral::getCountry($city->country);
			$userreviews=User::getTotalComments($currentuserid,1);
			$userratings=User::getTotalRatings($currentuserid);
			if(Input::has('full')){
				$invitees=User::getAllInvitees($currentuserid);
				if(count($invitees)>0){
						$data=array(
							'logoimage'=>$logoimage,
							'user'=>$currentuser,
							'username'=>$username,
							'country'=>$country,
							'reviews'=>$userreviews,
							'ratings'=>$userratings
						);
						$subject=$username." invites you to join Azooma";
					foreach ($invitees as $invitee){
						$data['invitee']=$invitee;
						Mail::queue('emails.user.sendinvite',$data,function($message) use ($subject,$invitee) {
							$message->to(trim($invitee->email),$invitee->name);
							$message->subject($subject);
						});
					}
				}
			}else{
				if(Input::has('email')){
					$invitee=User::getInvitee($currentuserid,Input::get('email'));
					if(count($invitee)>0){
						$data=array(
							'logoimage'=>$logoimage,
							'user'=>$currentuser,
							'username'=>$username,
							'country'=>$country,
							'reviews'=>$userreviews,
							'ratings'=>$userratings
						);
						$subject=$username." invites you to join Azooma";
						$data['invitee']=$invitee;
						Mail::queue('emails.user.sendinvite',$data,function($message) use ($subject,$invitee) {
							$message->to(trim($invitee->email),$invitee->name);
							$message->subject($subject);
						});
					}
				}
			}
		}
	}


	public function relatedLists($rest=0){
		$lang=Config::get('app.locale');
		$rest=MRestaurant::getRest($rest,true,true);
		$relatedlists=MRestaurant::getListsWithRestaurant($rest->rest_ID,true);
		$data['html']=stripcslashes(View::make('ajax.restaurant_lists',array('rest'=>$rest,'relatedlists'=>$relatedlists,'lang'=>$lang)));
		return Response::json($data);
	}


	public function correctBranch(){
		if(Input::has('branch_ID')){
			$lang=Config::get('app.locale');
			if($lang=="ar"){
				$cityurl=Request::segment(2);
			}else{
				$cityurl=Request::segment(1);
			}
			$branch=MRestaurant::getPossibleBranch(Input::get('branch_ID'));
			if(Session::has('userid')){
				$user=User::checkUser(Session::get('userid'),true);
				$name=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				$email=$user->user_Email;
			}else{
				$name=Input::get('yourName');
				$email=Input::get('yourEmail');
			}
			$rest=MRestaurant::getRest($branch->rest_fk_id,true,true);
			$logo=MGeneral::getLogo();
			$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
			$city= MGeneral::getCityURL($cityurl,true);
			$lang=Config::get('app.locale');
			$cityurl=Request::segment(1);
			$country=MGeneral::getCountry($city->country);
			$tdata=array(
				'latitude'=>Input::get('new-latitude'),
				'longitude'=>Input::get('new-longitude'),
				'comments'=>Input::get('additional'),
				'name'=>$name,
				'email'=>$email,
				'branch'=>$branch,
				'rest'=>$rest,
				'logoimage'=>$logoimage,
				'country'=>$country,
				'city'=>$city
			);
			$teamemails=explode(",",$country->teamemail);
			$subject="Branch Correction Request for ".stripcslashes($rest->rest_Name).' - '.$branch->br_loc;
			Mail::queue('emails.internal.branch_correct',$tdata,function($message) use ($subject,$teamemails) {
				foreach ($teamemails as $email) {
					$message->to(trim($email),'Azooma');
				}
				$message->subject($subject);
			});
		}
	}

	public function getMenuItem($menu=0){
		$lang=Config::get('app.locale');
		if($lang=="ar"){
			$cityurl=Request::segment(2);
		}else{
			$cityurl=Request::segment(1);
		}
		$city= MGeneral::getCityURL($cityurl,true);
		$item=MRestaurant::getMenuItem($menu);
		if(count($item)>0){
			$item=$item[0];
			$recommendations=MRestaurant::getMenuItemRecommendations($item->id);
			if(count($recommendations)>0){
				$recommendations=$recommendations[0]->recommend;
			}else{
				$recommendations=0;
			}
			$rest=MRestaurant::getRest($item->rest_fk_id,true,true);
			$t=array(
				'item'=>$item,
				'rest'=>$rest,
				'city'=>$city,
				'lang'=>$lang,
				'recommendations'=>$recommendations
			);
			$data['html']=stripcslashes(View::make('ajax.menu_item',$t));	
			return Response::json($data);
		}
	}

}