<?php
use OAuth\OAuth2\Token\StdOAuth2Token;
class UserController extends BaseController {
	public function __construct(){
		
	}

	public function index($userid){
		$lang=Config::get('app.locale');
		$user=User::checkUser($userid);
		if(count($user)>0){
			$user=$user[0];
			$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
			$data=array(
				'user'=>$user,
				'username'=>$username,
			);
			$data['lang']=$lang;
			$data['userlocation']=User::getLocation($user);
			$data['userfavorites']=User::getUserFavCuisines($user->user_ID);
			$data['usertotalcomments']=User::getTotalComments($user->user_ID);
			$data['usertotalratings']=User::getTotalRatings($user->user_ID);
			$data['usertotalphotos']=User::getTotalPhotos($user->user_ID);
			$data['usertotallikes']=User::getTotalLikes($user->user_ID);
			$data['usertotaldislikes']=User::getTotalLikes($user->user_ID,FALSE);
			$data['followers']=User::getTotalFollowers($user->user_ID);
			$data['following']=User::getTotalFollowing($user->user_ID);
			$data['totalactivities']=User::getTotalActivity($user->user_ID);
			$data['useractivities']=User::getActivities($user->user_ID,40,0);
			$data['usertotallists']=User::getTotalLists($user->user_ID);
			if(Session::has('userid')){
				$restaurantfeed=$userfeed=0;
				$data['checkfollowing']=User::checkFollowing(Session::get('userid'),$user->user_ID);
				$usernewsfeed=User::getUserNewsFeed($user->user_ID,20,0);
				$restaurantnewsfeed=User::getRestNewsFeed($user->user_ID,20,0);
				$data['newsfeed']=User::getNewsFeed($usernewsfeed,$restaurantnewsfeed);
			}
			$data['meta']=array(
				'title'=>$username,
			);
			return View::make('user',$data);

		}else{
			App::abort(404);
		}
	}


	public function settings($var=""){
		if(Session::has('userid')){
			$userid=Session::get('userid');
			$user=User::checkUser($userid);
			if(count($user)>0){
				$user=$user[0];
				$lang=Config::get('app.locale');
				$langstring="";
				if($lang=="ar"){
					$langstring="ar/";
				}
				if (Request::isMethod('post')){
					switch ($var) {
						case 'profile':
							$rules=array(
								'user_FullName'=>'required'
							);
							$validator=Validator::make(Input::all(),$rules);
							if($validator->fails()){
								$error=Lang::get('messages.name_empty');
							}else{
								$birthday=Input::get('year').'-'.Input::get('month').'-'.Input::get('birthday');
								$newdata=array(
									'user_FullName'=>Input::get('user_FullName'),
									'user_NickName'=>Input::get('user_NickName'),
									'user_BirthDate'=>$birthday,
									'user_Country'=>Input::get('country'),
									'user_City'=>Input::get('city'),
									'user_nationality'=>Input::get('nationality'),
									'user_Sex'=>Input::get('gender'),
									'user_Occupation'=>Input::get('occupation'),
									'user_Telephone'=>Input::get('telephone'),
									'user_Mobile'=>Input::get('mobile'),
									'user_maritial'=>Input::get('marital_status')
								);
								User::where('user_ID',$user->user_ID)->update($newdata);
								return Redirect::to($langstring.'settings#profile')->with('profilemessage', Lang::get('messages.info_updated_successfully'));
							}
							break;
						case 'notifications':
							$monthly=0;
							if(Input::has('monthly')){
								$monthly=1;
							}
							$weekly=0;
							if(Input::has('weekly')){
								$weekly=1;
							}
							$notify=0;
							if(Input::has('notification_emails')){
								$notify=1;
							}
							DB::table('monthly')->where('user_ID',$userid)->update(array('status'=>$monthly));
							DB::table('weekly')->where('user_ID',$userid)->update(array('status'=>$weekly));
							DB::table('notifications')->where('user_ID',$userid)->update(array('status'=>$notify));
							return Redirect::to($langstring.'settings#notification')->with('notifymessage', Lang::get('messages.notifications_updated_successfully'));
							break;
						case 'password':
							if(Input::has('password')){
								//set password
								$password=sha1(Input::get('password').Config::get('app.key'));
								DB::table('user')->where('user_ID',$userid)->update(array('user_Pass'=>$password));
								return Redirect::to('settings#passwordtab')->with('passwordmessage', Lang::get('messages.password_changed_successfully'));
							}else{
								//update password
								if(sha1(Input::get('old_password').Config::get('app.key'))===$user->user_Pass){
									$password=sha1(Input::get('new_password').Config::get('app.key'));
									DB::table('user')->where('user_ID',$userid)->update(array('user_Pass'=>$password));
									return Redirect::to($langstring.'settings#passwordtab')->with('passwordmessage', Lang::get('messages.password_changed_successfully'));
								}else{
									return Redirect::to($langstring.'settings#passwordtab')->with('passworderror', Lang::get('messages.password_wrong'));
								}
							}
							break;
						case 'photo':
							if(Input::hasFile('image')){
								//new image
								$name = Input::file('image')->getClientOriginalName();
								$image=uniqid('sufrati').$name;
								$largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($_FILES['image']['tmp_name']);
					            $thumbLayer = clone $largeLayer;
					            $actualWidth = $largeLayer->getWidth();
					            $actualHeight = $largeLayer->getHeight();
					            if($actualHeight<200||$actualWidth<200){
					            	return Redirect::to($langstring.'settings#phototab')->with('photoerror', Lang::get('messages.photo_too_small'));
					            }
					            $largeLayer->save(public_path() . "/uploads/images/", $image, true, null, 95);
					            if(Input::has('x1')&&Input::has('x2')&&Input::has('y1')&&Input::has('y2')&&Input::has('width')&&Input::has('height')){
					            	$newwidth=Input::get('width');
					            	$newheight=Input::get('height');
					            	$largeLayer->cropInPixel($newwidth,$newheight,Input::get('x1'),Input::get('y1'),'LT');
					            	$largeLayer->save(public_path() . "/uploads/images/", $image, true, null, 95);
					            }
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
					            DB::table('user')->where('user_ID',$user->user_ID)->update(array('image'=>$image));
					            return Redirect::to($langstring.'settings#phototab')->with('photosuccess', Lang::get('messages.photo_updated'));
							}else{
								if(Input::has('x1')&&Input::has('x2')&&Input::has('y1')&&Input::has('y2')&&Input::has('width')&&Input::has('height')){
									//crop the existing image
									$image=$user->image;
									$largeLayer=PHPImageWorkshop\ImageWorkshop::initFromPath(public_path() . "/uploads/images/".$image);
									$newwidth=Input::get('width');
					            	$newheight=Input::get('height');
					            	$largeLayer->cropInPixel($newwidth,$newheight,Input::get('x1'),Input::get('y1'),'LT');
					            	$largeLayer->save(public_path() . "/uploads/images/", $image, true, null, 95);
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
						            return Redirect::to($langstring.'settings#phototab')->with('photosuccess', Lang::get('messages.photo_updated'));
								}
							}
					}
				}else{
					$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
					$data['user']=$user;
					$data['username']=$username;
					$data['lang']=$lang;
					$data['landing']=true;
					$data['monthlynotify']=User::checkMonthlyNotifStatus($user->user_ID);
					$data['weeklynotify']=User::checkWeeklyNotifStatus($user->user_ID);
					$data['notifystatus']=User::checkNotifyStatus($user->user_ID);
					$data['meta']=array(
						'title'=>$username,
					);
					return View::make('user.settings',$data);
				}
			}else{
				App::abort(404);	
			}
		}else{
			App::abort(404);
		}
	}

	public function helper($var=""){
		$userid=Input::get('user');
		$user=User::checkUser($userid);
		if(count($user)>0){
			$user=$user[0];
			$lang=Config::get('app.locale');
			$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
			$userimage=($user->image=="")?'user-default.svg':$user->image;
			switch ($var) {
				case 'activity':
					$offset=0;
					if(Input::has('loaded')){
						$offset=Input::get('loaded');	
					}
					$limit=40;
					$totalactivities=User::getTotalActivity($user->user_ID);
					$useractivities=User::getActivities($user->user_ID,$limit,$offset);
					$activity=array(
	                    'lang'=>$lang,
	                    'user'=>$user,
	                    'userimage'=>$userimage,
	                    'username'=>$username,
	                    'totalactivities'=>$totalactivities,
	                    'useractivities'=>$useractivities
	                );
	                $totalloaded=$offset+count($useractivities);
	                $html=stripcslashes(View::make('user.activity',$activity));
	                return Response::json(array('html'=>$html,'totalloaded'=>$totalloaded,'total'=>$totalactivities));
					break;
				case 'reviews':
					$offset=0;
					if(Input::has('loaded')){
						$offset=Input::get('loaded');	
					}
					$limit=15;
					$totalcomments=User::getTotalComments($user->user_ID);
					$userreviews=User::getReviews($user->user_ID,$limit,$offset);
					$reviews=array(
                        'lang'=>$lang,
                        'user'=>$user,
                        'userimage'=>$userimage,
                        'username'=>$username,
                        'totalcomments'=>$totalcomments,
                        'userreviews'=>$userreviews
                    );
                    $totalloaded=$offset+count($userreviews);
	                $html=stripcslashes(View::make('user.reviews',$reviews));
	                return Response::json(array('html'=>$html,'totalloaded'=>$totalloaded,'total'=>$totalcomments));
	                break;
	            case 'photos':
	            	$offset=0;
					if(Input::has('loaded')){
						$offset=Input::get('loaded');	
					}
					$limit=15;
					$totalphotos=User::getTotalPhotos($user->user_ID);
					$userphotos=User::getUserPhotos($user->user_ID,$limit,$offset);    
					$reviews=array(
                        'lang'=>$lang,
                        'user'=>$user,
                        'userimage'=>$userimage,
                        'username'=>$username,
                        'usertotalphotos'=>$totalphotos,
                        'userphotos'=>$userphotos
                    );
                    $totalloaded=$offset+count($userphotos);
	                $html=stripcslashes(View::make('user.photos',$reviews));
	                return Response::json(array('html'=>$html,'totalloaded'=>$totalloaded,'total'=>$totalphotos));
	                break;
	            case 'followers':
	            	$offset=0;
					if(Input::has('loaded')){
						$offset=Input::get('loaded');	
					}
					$limit=15;
					$totalfollowers=User::getTotalFollowers($user->user_ID);
					$userfollowers=User::getFollowers($user->user_ID,$limit,$offset);
		            $fol=array(
		                'lang'=>$lang,
		                'user'=>$user,
		                'userimage'=>$userimage,
		                'username'=>$username,
		                'userfollowers'=>$userfollowers,
		            );
		            $totalloaded=$offset+count($userfollowers);
	                $html=stripcslashes(View::make('user.helpers.follower_following',$fol));
	                return Response::json(array('html'=>$html,'totalloaded'=>$totalloaded,'total'=>$totalfollowers));
	                break;
	            case 'following':
	            	$offset=0;
					if(Input::has('loaded')){
						$offset=Input::get('loaded');	
					}
					$limit=15;
					$totalfollowing=User::getTotalFollowers($user->user_ID);
					$userfollowing=User::getFollowing($user->user_ID,$limit,$offset);
		            $fol=array(
		                'lang'=>$lang,
		                'user'=>$user,
		                'userimage'=>$userimage,
		                'username'=>$username,
		                'userfollowers'=>$userfollowing,
		            );
		            $totalloaded=$offset+count($userfollowing);
	                $html=stripcslashes(View::make('user.helpers.follower_following',$fol));
	                return Response::json(array('html'=>$html,'totalloaded'=>$totalloaded,'total'=>$totalfollowing));
				case 'restlikes':
					$offset=0;
					if(Input::has('loaded')){
						$offset=Input::get('loaded');	
					}
					$limit=15;
					$totallikes=User::getTotalLikes($user->user_ID);
					$restlikes=User::getUserLikes($user->user_ID,$limit,$offset);
		            $fol=array(
		                'lang'=>$lang,
		                'user'=>$user,
		                'userimage'=>$userimage,
		                'username'=>$username,
		                'restlikes'=>$restlikes,
		            );
		            $totalloaded=$offset+count($restlikes);
	                $html=stripcslashes(View::make('user.helpers.like_rest',$fol));
	                return Response::json(array('html'=>$html,'totalloaded'=>$totalloaded,'total'=>$totallikes));
					break;
				case 'foodlikes':
					$offset=0;
					if(Input::has('loaded')){
						$offset=Input::get('loaded');	
					}
					$limit=15;
					$totalfoodrecommends=User::getTotalFoodRecommend($user->user_ID); 
					$userfoods=User::getUserFoodRecommend($user->user_ID,$limit,$offset);
		            $fol=array(
		                'lang'=>$lang,
		                'user'=>$user,
		                'userimage'=>$userimage,
		                'username'=>$username,
		                'userfoods'=>$userfoods,
		            );
		            $totalloaded=$offset+count($userfoods);
	                $html=stripcslashes(View::make('user.helpers.like_dish',$fol));
	                return Response::json(array('html'=>$html,'totalloaded'=>$totalloaded,'total'=>$totalfoodrecommends));
					break;
			}
		}
	}

	public function notifications($user=0){
		if(Session::has('userid')){
			$lang=Config::get('app.locale');
			if(Session::get('userid')==$user){
				
				$user=User::checkUser($user);
				if(count($user)>0){
					$user=$user[0];
					$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
					$data=array(
						'user'=>$user,
						'username'=>$username,
					);
					$data['lang']=$lang;
					$data['totalnotifications']=User::getTotalNotifications($user->user_ID);
					$data['usernotifications']=User::getNotifications($user->user_ID);
					$data['newnotifications']=User::getNewNotifications($user->user_ID);
					$data['meta']=array(
						'title'=>$username.' - '.Lang::choice('messages.notification',2),
					);
					return View::make('user.notifications',$data);
				}
			}else{
				$langurl="";
				if($lang=="ar"){
					$langurl="ar/";
				}
				return Redirect::to($langurl.'user/'.Session::get('userid').'/notifications');
			}
		}
	}

	public function clearnotifications(){
		if(Session::has('userid')){
			$lang=Config::get('app.locale');
			$langurl="";
			if($lang=="ar"){
				$langurl="ar/";
			}
			DB::table('user_notifications')->where('user_ID',Session::get('userid'))->where('read',0)->update(array('read'=>1));
			return Redirect::to($langurl.'user/'.Session::get('userid').'/notifications');
		}
	}

	public function clearnotif($id=0){
		if(Session::has('userid')){
			$lang=Config::get('app.locale');
			$langurl="";
			if($lang=="ar"){
				$langurl="ar/";
			}
			DB::table('user_notifications')->where('id',$id)->update(array('read'=>1));
			$notification=DB::table('user_notifications')->where('id',$id)->first();
			switch ($notification->activity_text) {
				case 'Comment approved':
					$comment=User::getPossibleComment($notification->activity_ID);
					if(count($comment)>0){
						$rest=MRestaurant::getRest($comment->rest_ID);
						$city=MGeneral::getPossibleCity($comment->rest_ID);
						return Redirect::to($langurl.$city->seo_url.'/'.$rest->seo_url.'#user-review-'.$comment->review_ID);
					}
					break;
				case 'following':
					$follower=User::checkUser($notification->activity_ID);
					if(count($follower)>0){
						return Redirect::to($langurl.'user/'.$follower->user_ID);
					}
					break;
				case 'Photo approved':
					$photo=User::getPossiblePhoto($notification->activity_ID);
					if(count($photo)>0){
						$rest=MRestaurant::getRest($photo->rest_ID);
						$city=MGeneral::getPossibleCity($photo->rest_ID);
						return Redirect::to($langurl.$city->seo_url.'/'.$rest->seo_url.'#user-photo-'.$notification->activity_ID);
					}
					break;
				case 'Comment Upvoted':
					$support=User::getSupport($notification->activity_ID);
					if(count($support)>0){
						$comment=User::getPossibleComment($support->comment_id);
						if(count($comment)>0){
							$rest=MRestaurant::getRest($comment->rest_ID);
							$city=MGeneral::getPossibleCity($comment->rest_ID);
							return Redirect::to($langurl.$city->seo_url.'/'.$rest->seo_url.'#user-review-'.$comment->review_ID);
						}
					}
					break;
			}
		}
	}


	function followsuggestion(){
		if(Session::has('userid')){
			$limit=15;
			$offset=0;
			$userid=Session::get('userid');
			$lang=Config::get('app.locale');
			$user=User::checkUser($userid);
			if(Input::has('loaded')){
				$offset=Input::get('loaded');
			}
			if(count($user)>0){
				$user=$user[0];
				$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				$data=array(
					'user'=>$user,
					'username'=>$username,
				);
				$data['lang']=$lang;
				$totalfollowsuggestions=User::totalFollowSuggestions($userid);
				$data['total']=$totalfollowsuggestions;
				$data['followsuggestions']=User::followSuggestions($userid,$limit,$offset);
				if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
					$fol=array(
                        'lang'=>$lang,
                        'user'=>$user,
                        'username'=>$username,
                        'userfollowers'=>$data['followsuggestions'],
                    );
                    $totalloaded=$offset+$limit;
					$html=stripcslashes(View::make('user.helpers.follower_following',$fol));
					$t=array(
						'html'=>$html,
						'totalloaded'=>$totalloaded,
						'limit'=>$limit
					);
					return Response::json($t);
				}else{
					$data['meta']=array(
						'title'=>Lang::get('messages.find_friends'),
			            'metadesc'=>Lang::get('messages.find_friends'),
					);
					return View::make('user.suggested_users',$data);
				}
			}
		}else{
			return Redirect::to('');
		}
	}

	function likesuggestion(){
		if(Session::has('userid')){
			$limit=15;
			$offset=0;
			$userid=Session::get('userid');
			$lang=Config::get('app.locale');
			$user=User::checkUser($userid);
			if(Input::has('loaded')){
				$offset=intval(Input::get('loaded'));
			}
			if(count($user)>0){
				$user=$user[0];
				$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				$data=array(
					'user'=>$user,
					'username'=>$username,
				);
				$data['lang']=$lang;
				$totalsuggestions=User::totalLikeSuggestions($userid);
				$data['total']=$totalsuggestions;
				$data['likesuggestions']=User::likeSuggestions($userid,$limit,$offset);
				if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
					$fol=array(
                        'lang'=>$lang,
                        'user'=>$user,
                        'username'=>$username,
                        'likesuggestions'=>$data['likesuggestions'],
                    );
                    $totalloaded=$offset+$limit;
					$html=stripcslashes(View::make('user.helpers.like_suggestions',$fol));
					$t=array(
						'html'=>$html,
						'totalloaded'=>$totalloaded,
						'limit'=>$limit,
						'offset'=>$offset
					);
					return Response::json($t);
				}else{
					$data['meta']=array(
						'title'=>Lang::get('messages.you_might_like'),
			            'metadesc'=>Lang::get('messages.you_might_like'),
					);
					return View::make('user.suggested_rest',$data);
				}
			}
		}else{
			return Redirect::to('');
		}
	}


	function userpreference(){
		if(Session::has('userid')){
			$userid=Session::get('userid');
			$lang=Config::get('app.locale');
			$user=User::checkUser($userid,true);
			$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
			$data=array(
				'user'=>$user,
				'username'=>$username,
			);
			
			$data['allcuisines']=User::getCuisines(0);
			$data['lang']=$lang;
			$data['meta']=array(
				'title'=>Lang::get('messages.cuisines_you_like'),
	            'metadesc'=>Lang::get('messages.cuisines_you_like'),
			);
			return View::make('user.preferences',$data);

		}else{
			return Redirect::to('');
		}
	}


	function savepreference(){
		if(Session::has('userid')){
			$userid=Session::get('userid');
			$lang=Config::get('app.locale');
			$user=User::checkUser($userid)[0];
			if(Input::get('cuisines')){
				$cuisines=Input::get('cuisines');
				$cuisines=explode(',',implode(',', $cuisines));
				$notcuisines=Input::get('notcuisines');
				$notcuisines=explode(',',implode(',', $notcuisines));
				if(count($cuisines)>0){
					foreach ($cuisines as $cuisine) {
						$count=DB::table('userlike')->where('user_ID',$userid)->where('cuisine_ID',$cuisine)->count();
						if($count<=0){
							$data=array(
								'user_ID'=>$userid,
								'cuisine_ID'=>$cuisine,
								'country'=>$user->sufrati
							);
							DB::table('userlike')->where('user_ID',$userid)->insert($data);
						}
					}
				}
				if(count($notcuisines)>0){
					foreach ($notcuisines as $cuisine) {
						$count=DB::table('userlike')->where('user_ID',$userid)->where('cuisine_ID',$cuisine)->count();
						if($count>0){
							DB::table('userlike')->where('user_ID',$userid)->where('cuisine_ID',$cuisine)->delete();
						}
					}
				}
				return Redirect::to('userpreference');
			}
		}

	}

	public function invite(){
		if(Session::has('userid')){
			$userid=Session::get('userid');
			$lang=Config::get('app.locale');
			$user=User::checkUser($userid)[0];
			if(count($user)>0){
				$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
				$data=array(
					'user'=>$user,
					'username'=>$username,
				);
				$data['lang']=$lang;
				$data['meta']=array(
					'title'=>Lang::get('messages.invite_friends'),
				);
				return View::make('user.invite',$data);
			}
		}else{
			return Redirect::to('');
		}
	}

	public function checkFBFriends(){
		if(Session::has('userid')){
			if(Input::has('friends')){
				$friends=Input::get('friends');
				$details=User::checkFollowingFbFriends(Session::get('userid'),$friends);
				$t=array(
					'userfollowers'=>$details,
					'lang'=>Config::get('app.locale')
				);
				$html=stripcslashes(View::make('user.helpers.follower_following',$t));
				$html='<div class="spacing-container"></div><h2 class="rest-page-second-heading">'.Lang::get('messages.fb_friends_sufrati').' - ('.count($details).')</h2><div class="spacing-container"></div>'.$html;
				return Response::json(array('html'=>$html));
			}
		}
	}



	public function getGoogleData(){
		if(Session::has('userid')){
			if(Input::has('googleid')){
				$sufratiusers=$invites=array();
				$user=User::checkUser(Session::get('userid'))[0];
				if($user->image==""){
					$image=Input::get('photo');
					$fbimage = file_get_contents($image.'0');
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
				}
				if($user->importedfromgoogle!=0){
					$contacts=DB::table('fromgmail')->where('user_ID',$user->user_ID)->get();
					if(count($contacts)>0){
						foreach ($contacts as $contact) {
							$friend=(array)$contact;
							$user=DB::table('user')->select('user_ID','user_NickName','user_FullName','image','user_City','sufrati',DB::raw('(SELECT count(id) FROM follower WHERE follower.follow=user_ID ) as followers'),DB::raw('(SELECT count(id) FROM follower WHERE follower.user_ID=user_ID) as following'))->where('user_Email',$friend['email'])->first();
					    	if(count($user)>0){
					    		$sufratiusers[]=$user;
					    	}else{
					    		$invites[]=$friend;
					    	}
						}
					}
				}else{
					if($user->google==0){
						DB::table('user')->where('user_ID',$user->user_ID)->update(array('google'=>Input::get('googleid')));	
					}
					$code = Input::get( 'code' );
				    if ( !empty( $code ) ) {
						$token_interface = new StdOAuth2Token($code);
						$googleService = OAuth::consumer( 'Google' );
						$token = $googleService->getStorage()->storeAccessToken('Google', $token_interface);
				    	$result = json_decode($googleService->request('https://www.google.com/m8/feeds/contacts/default/full?alt=json&max-results=10000'),true);
				    	$contacts=$result['feed']['entry'];
				    	$friends=array();
				    	$i=0;
				    	if(count($contacts)>0){
				    		foreach ($contacts as $contactlist) {
					    		if(isset($contactlist['category'])){
					    			//is a contact
					    			$contact=$contactlist;
					    			$email=$name='';$phone=0;
			    					if(isset($contact['category'])){
			    						if(isset($contact['gd$email'])){
			    							if(count($contact['gd$email'])>0){
			    								foreach ($contact['gd$email'] as $emails) {
			    									if(isset($emails['primary'])){
			    										$email=$emails['address'];
			    									}
			    								}
			    							}
			    							if(isset($contact['title'])){
			    								$name=$contact['title']['$t'];
			    							}
			    							if(isset($contact['gd$phoneNumber'])){
			    								if(count($contact['gd$phoneNumber'])>0&&isset($contact['gd$phoneNumber'][0]['$t'])){
				    								$phone=$contact['gd$phoneNumber'][0]['$t'];
				    								$phone=str_replace(' ', '', $phone);
				    							}
			    							}
			    							$friends[$i]=array(
			    								'email'=>$email,
			    								'name'=>$name,
			    								'phone'=>$phone
			    							);
			    							$i++;
			    						}
			    					}
					    		}else{
					    			//is a list array
					    			if(count($contactlist)>0){
					    				foreach ($contactlist as $contact) {
					    					$email=$name='';$phone=0; 
					    					if(isset($contact['category'])){
					    						if(isset($contact['gd$email'])){
					    							if(count($contact['gd$email'])>0){
					    								foreach ($contact['gd$email'] as $emails) {
					    									if(isset($emails['primary'])){
					    										$email=$emails['address'];
					    									}
					    								}
					    							}
					    							if(isset($contact['title'])){
					    								$name=$contact['title']['$t'];
					    							}
					    							if(isset($contact['gd$phoneNumber'])){
					    								if(count($contact['gd$phoneNumber'])>0&&isset($contact['gd$phoneNumber'][0]['$t'])){
						    								$phone=$contact['gd$phoneNumber'][0]['$t'];
						    								$phone=str_replace(' ', '', $phone);
						    							}
					    							}
					    							$friends[$i]=array(
					    								'email'=>$email,
					    								'name'=>$name
					    							);
					    							$i++;
					    						}
					    					}
					    				}
					    			}
					    		}
					    	}
					    }
					    $curuser=$user->user_ID;
					    $sufratiusers=$invites=array();
					    foreach ($friends as $friend) {
					    	$count=DB::table('fromgmail')->where('user_ID',$curuser)->where('email',$friend['email'])->count();
					    	if($count<=0){
					    		$kdata=array(
					    			'name'=>$friend['name'],
					    			'email'=>$friend['email'],
					    			'phone'=>$friend['phone'],
					    			'user_ID'=>$curuser
					    		);
					    		DB::table('fromgmail')->insert($kdata);
					    	}
					    	$user=DB::table('user')->select('user_ID','user_NickName','user_FullName','image','user_City','sufrati',DB::raw('(SELECT count(id) FROM follower WHERE follower.follow=user_ID ) as followers'),DB::raw('(SELECT count(id) FROM follower WHERE follower.user_ID=user_ID) as following'))->where('user_Email',$friend['email'])->first();
					    	if(count($user)>0){
					    		if($user->user_ID!=$curuser){
						    		$sufratiusers[]=$user;
						    	}
					    	}else{
					    		$invites[]=$friend;
					    	}
					    	//add to newsletter
					    }
				    }
				    DB::table('user')->where('user_ID',$curuser)->update(array('importedfromgoogle'=>1,'lastimportedfromgoogle'=>date("Y-m-d H:i:s")));
				}
				$inviteshort=array_splice($invites, 0,50);
			    $t=array(
					'sufratiusers'=>$sufratiusers,
					'lang'=>Config::get('app.locale'),
					'invited'=>$inviteshort,
					'invitedtotal'=>count($invites)
				);
			    $html=stripcslashes(View::make('user.helpers.get_gmail_friends',$t));
			    return Response::json(array('html'=>$html,'invites'=>$invites));
			}
		}
	}

	public function inviteAccept(){
		if(Input::has('email')){
			$email=Input::get('email');
			Session::put('inviteemail',$email);
			return Redirect::to('');
		}
	}


}	