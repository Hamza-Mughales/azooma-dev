<?php
class DashboardController extends BaseController {

	public function __construct(){
		
	}

	public function index($step=0){
		if(Session::has('userid')){
			$lang=Config::get('app.locale');
			$userid=Session::get('userid');
			$user=DB::table('user')->where('user_ID',$userid)->first();
			// $user=User::checkUser(Session::get('userid'),true);
			// $user=$user[0];
			$data['user']=$user;
			switch ($step) {
				case 0:
					$data['meta']=array(
						'title'=>Lang::get('title.tell_us_about_you'),
					);
					$cities=DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url')->where('country',$user->sufrati)->get();
					$occupations=Azooma::getOccupations(); 
					$data['subdata']=array(
						'cities'=>$cities,
						'occupations'=>$occupations,
						'user'=>$user,
						'lang'=>$lang
					);
					$data['step']=1;
					$data['title']=Lang::get('title.tell_us_about_you');
					$data['view']='step1';
					break;
				case 1:
					$data['meta']=array(
						'title'=>Lang::get('title.choose_favorite'),
					);
					$cuisines=User::getCuisines($user->user_City,21,0);
					$data['subdata']=array(
						'cuisines'=>$cuisines,
						'user'=>$user,
						'lang'=>$lang
					);
					$data['step']=2;
					$data['title']=Lang::get('title.choose_favorite');
					$data['view']='step2';
					break;
				case 2:
					$data['meta']=array(
						'title'=>Lang::get('title.lets_like'),
					);
					$restaurants=User::likeSuggestions($user->user_ID,15,0);
					
					$city=DB::table('city_list')->select('city_ID','city_Name_ar','city_Name','seo_url')->where('city_ID',$user->user_City)->first();
					
				
					// $data['restaurants']= $restaurants;
					$data['subdata']=array(
						'restaurants'=>$restaurants,
						'city'=>$city,
						'user'=>$user,
						'lang'=>$lang
					);
					$data['step']=3;
					$data['title']=Lang::get('title.lets_like');
					$data['view']='step3';
					break;
				case 3:
					if($user->facebook!=""){
						$facebook = new Facebook(array(
						    'appId' => Config::get('facebook.appId'),
						    'secret' => Config::get('facebook.secret')
						));
						$facebookuser = $facebook->getUser();
						if($facebookuser==0){
							$params = array(
							    'scope' => 'email,user_birthday,user_location,publish_actions',
							    'redirect_uri' => URL::to('step/3')
							);
							$url = $facebook->getLoginUrl($params);
							return Redirect::to($url);
						}else{
							$access_token = $facebook->getAccessToken();
							$facebook->setAccessToken($access_token);
							//$url=$facebook->api('me/friends/?fields=installed');
							$friendslist=$facebook->api(
								array(
									'method'=>'fql.query',
									'query'=>'SELECT uid FROM user WHERE is_app_user=1 AND uid IN (SELECT uid2 FROM friend WHERE uid1 = me())'
								)
							);
							$friends='';
							$friendsl=array();
							if(count($friendslist)>0){
								$i=0;
								foreach ($friendslist as $friend) {
									$i++;
									$friends.=$friend['uid'];
									if($i!=count($friendslist)){
										$friends.=',';
									}
								}
							}
							if($friends!=""){
								$friendsq="SELECT u.user_ID, u.user_NickName, u.user_FullName, u.user_City, u.user_Country, u.sufrati, u.image, u.userRank, (SELECT count(id) FROM follower WHERE follow=u.user_ID) as followers,(SELECT count(id) FROM follower WHERE user_ID=u.user_ID) as following FROM user u WHERE u.facebook IN (".$friends.") AND u.user_Status=1 ";
								$friendsl= DB::select(DB::raw($friendsq));
								foreach ($friendsl as $friend) {
									$checkfollow=User::checkFollowing(Session::get('userid'),$friend->user_ID);
									if($checkfollow<=0){
										User::followUser(Session::get('userid'),$friend->user_ID);
									}
								}
								$data['friends']=$friendsl;
							}
							$data['meta']=array(
								'title'=>Lang::get('title.lets_follow'),
							);
							$users=User::followSuggestions($user->user_ID,15,0);
							$city=DB::table('city_list')->select('city_ID','city_Name_ar','city_Name','seo_url')->where('city_ID',$user->user_City)->first();
							$data['subdata']=array(
								'users'=>$users,
								'city'=>$city,
								'user'=>$user,
								'lang'=>$lang
							);
							$data['step']=4;
							$data['title']=Lang::get('title.lets_follow');
							$data['view']='step4';
						}
					}else{
						$data['meta']=array(
							'title'=>Lang::get('title.lets_follow'),
						);
						$users=User::followSuggestions($user->user_ID,15,0);
						$city=DB::table('city_list')->select('city_ID','city_Name_ar','city_Name','seo_url')->where('city_ID',$user->user_City)->first();
						$data['subdata']=array(
							'users'=>$users,
							'city'=>$city,
							'user'=>$user,
							'lang'=>$lang
						);
						$data['step']=4;
						$data['title']=Lang::get('title.lets_follow');
						$data['view']='step4';
					}
					
					break;
			}
			if($user->user_City!=NULL){
				if(is_numeric($user->user_City)){
					$city= DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url')->where('city_ID',$user->user_City)->first();
					$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
					$data['city']=$city;	
				}
			}

			$city=DB::table('city_list')->select('city_ID','city_Name_ar','city_Name','seo_url', 'country')->where('city_ID',$user->user_City)->first();
			$data['city']=$city;	

			$data['lang']=$lang;
			return View::make('dashboard',$data);
		}else{
			return Redirect::to('');	
		}
	}


	public function save($steps){
		if(Session::has('userid')){
			$userid=Session::get('userid');
			switch ($steps) {
				case 0:
					$data=array(
						'user_City'=>Input::get('user_City'),
						'user_Sex'=>Input::get('user_Sex'),
						'user_occupation'=>Input::get('user_occupation'),
						'profilecompletion'=> 2
					);
					if(!Session::has('sfcity')){
						Config::set('session.lifetime',365*12*3600);
						Session::put('sfcity',Input::get('user_City'));
					}
					DB::table('user')->where('user_ID',$userid)->update($data);
					return Redirect::to('step/1');
					break;

				case 2:
					$user=User::checkUser(Session::get('userid'))[0];
					$likedcuisines=$_POST['cuisines'];
					$likedcuisines=explode(',',implode(',', $likedcuisines));
					$data2=array(
						'profilecompletion'=> 4
					);
					DB::table('user')->where('user_ID',$userid)->update($data2);
					foreach ($likedcuisines as $cuisine) {
						$count=DB::table('userlike')->where('user_ID',$userid)->where('cuisine_ID',$cuisine)->count();
						if($count<=0){
							$data=array(
								'user_ID'=>$userid,
								'cuisine_ID'=>$cuisine,
								'country'=>$user->sufrati,
							);
							
							DB::table('userlike')->where('user_ID',$userid)->insert($data);
						}
					}
					return Redirect::to('step/2');
				default:
					# code...
					break;
			}
		}
	}

}