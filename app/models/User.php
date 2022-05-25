<?php
class User extends Eloquent{
	public $timestamps = false;
	protected $table="user";
	public static function login($email="",$password=""){
		$q="SELECT user_ID, user_Email, user_FullName,user_NickName,image,user_Status,facebook,fbPublish FROM user WHERE user_Email=:email AND user_Pass=:password";
		return DB::select(DB::raw($q),array('email'=>$email,'password'=>$password));
	}	

	public static function checkUser($userid=0,$min=false){
		if($min){
			return DB::table('user')->select('user_ID','user_NickName','user_FullName','user_Email','image','profilecompletion')->where('user_ID',$userid)->first();
		}else{
			$q="SELECT * FROM user WHERE user_ID=:userid";
			return DB::select(DB::raw($q),array('userid'=>$userid));
		}
		
	}

	public static function FBLogin($fbid=0,$email=""){
		$count= DB::table('user')->where('facebook',$fbid)->count();
		if($count>0){
			return DB::table('user')->where('facebook',$fbid)->first();	
		}else{
			$count= DB::table('user')->where('user_Email',$email)->count();
			if($count>0){
				$count= DB::table('user')->where('user_Email',$email)->first();
			}else{
				return FALSE;	
			}
			
		}
	}

	public static function updateFromFB($userid,$email,$dob,$name,$gender,$publish){
		$user=DB::table('user')->where('user_ID',$userid)->first();
		if(count($user)>0){
			if($user->user_Email==""){
				$data=array('user_Email'=>$email);
				DB::table('user')->where('user_ID',$userid)->update($data);
			}
			if($user->user_BirthDate==""){
				$data=array('user_BirthDate'=>$dob);
				DB::table('user')->where('user_ID',$userid)->update($data);
			}
			if($user->user_FullName==""){
				$data=array('user_FullName'=>$name);
				DB::table('user')->where('user_ID',$userid)->update($data);
			}
			if($user->user_Sex==""){
				$data=array('user_Sex'=>ucfirst($gender));
				DB::table('user')->where('user_ID',$userid)->update($data);
			}
			if($user->fbPublish==""||$user->fbPublish==2){
				$data=array('fbPublish'=>$publish);
				DB::table('user')->where('user_ID',$userid)->update($data);
			}
		}
	}


	public static function register($name,$email,$password,$phone=0,$cityid=0,$countryid=0,$google=0,$facebook=0,$countrycode=''){
		$rand = uniqid(md5(mt_rand()), true);
		$status=0;
		if($google!=0){
			$status=1;
		}
		$data=array(
			'user_FullName'=>$name,
			'user_Email'=>$email,
			'user_Pass'=>$password,
			'user_Mobile' =>$phone,
			'user_City'=>$cityid,
			'rand_num' => $rand,
			'user_Country'=>$countrycode,
			'sufrati'=>$countryid,
			'user_Status'=>$status,
			'google'=>$google,
			'facebook'=>$facebook
		);
		$userid=DB::table('user')->insertGetId($data);
		User::addUserNotification($userid,$name,$email,$countryid);
        return DB::table('user')->where('user_ID',$userid)->first();
	}
	public static function addUserNotification($userid=0,$name,$email,$countryid){
		$data = array(
            'user_ID' => $userid,
            'status' => 1
        );
        DB::table('monthly')->insert($data);
        DB::table('weekly')->insert($data);
        DB::table('notifications')->insert($data);
        $data=array(
            'name'=>"Places I want to try",
            'user_ID'=>$userid,
            'createdAt'=>date("Y-m-d H:i:s")
        );
        DB::table('user_lists')->insert($data);
        $data=array(
            'name'=>$name,
            'email'=>$email,
            'user_ID'=>$userid,
            'restaurant'=>0,
            'status'=>1,
            'external'=>0,
            'bademail'=>0,
            'college'=>0,
            'country'=>$countryid
        );
        DB::table('subscribers')->insert($data);
	}

	public static function getLocation($user=0,$min=true){
		$lang= Config::get('app.locale');
		if(!is_object($user)){
			$user=self::checkUser($user);
			$user=$user[0];
		}
		$sufraticountry=$user->sufrati;
		if($sufraticountry==0){
			$sufraticountry=1;
		}
		$city='';
		$country='';
		$countryq=DB::select(DB::raw("SELECT name,nameAr FROM aaa_country WHERE id=:id"),array('id'=>$sufraticountry));
		if(count($countryq)>0){ 
			if($lang=="en"){
				$country= $countryq[0]->name;
			}else{
				$country= $countryq[0]->nameAr;
			}
		}
		if($user->user_City!=NULL){
			if(is_numeric($user->user_City)){
				$cityq=DB::select(DB::raw("SELECT city_Name,city_Name_ar FROM city_list WHERE city_ID=:id"),array('id'=>$user->user_City));
				if(count($cityq)>0){
					if($lang=="en"){
						$city= $cityq[0]->city_Name.', ';
					}else{
						$city= $cityq[0]->city_Name_ar.', ';
					}
				}		
			}
		}
			return $city.$country;	
	}

	public static function getUserFavCuisines($userid){
		$q="SELECT cl.cuisine_Name,cl.cuisine_Name_ar,cl.cuisine_ID,cl.seo_url,cl.image FROM userlike ul JOIN cuisine_list cl ON cl.cuisine_ID=ul.cuisine_ID AND cl.cuisine_Status=1 WHERE ul.user_ID=:userid";
		return DB::select(DB::raw($q),array('userid'=>$userid));
	}

	public static function checkUserLikeCuisine($cuisine=0,$user=0){
		return DB::table('userlike')->where('user_ID',$user)->where('cuisine_ID',$cuisine)->first();
	}

	public static function getCuisines($city=0,$limit=0,$offset=0){
		$q="SELECT DISTINCT cl.cuisine_ID,cl.cuisine_Name,cl.cuisine_Name_ar,cl.seo_url,cl.image FROM restaurant_cuisine rc JOIN cuisine_list cl ON cl.cuisine_ID=rc.cuisine_ID WHERE cl.cuisine_Status=1 ORDER BY cl.cuisine_viewed DESC ";
		return DB::select(DB::raw($q));
	}

	public static function getTotalComments($userid=0,$status=1){
		$q="SELECT count(review_ID) as total FROM review WHERE user_ID=:userid ";
		if($status==1){
			$q.=" AND review_Status=1";
		}
		$comments= DB::select(DB::raw($q),array('userid'=>$userid));
		return $comments[0]->total;
	}

	public static function getTotalRatings($userid=0){
		$q="SELECT count(rating_ID) as total FROM rating_info WHERE user_ID=:userid ";
		$ratings= DB::select(DB::raw($q),array('userid'=>$userid));
		return $ratings[0]->total;
	}

	public static function getTotalPhotos($userid=0,$status=1){
		$q="SELECT count(image_ID) as total FROM image_gallery WHERE user_ID=:userid ";
		if($status==1){
			$q.=" AND status=1";
		}
		$photos= DB::select(DB::raw($q),array('userid'=>$userid));
		return $photos[0]->total;
	}

	public static function getTotalLikes($userid=0,$like=TRUE){
		$q="SELECT count(id) as total FROM likee_info WHERE user_ID=:userid AND comment_id IS NULL ";
		if($like){
			$q.=" AND status=1 ";
		}else{
			$q.=" AND status=0 ";
		}
		$ratings= DB::select(DB::raw($q),array('userid'=>$userid));
		return $ratings[0]->total;
	}

	public static function getTotalFollowers($user){
		$q="SELECT count(id) as total FROM follower WHERE follow=:userid ";
		$ratings= DB::select(DB::raw($q),array('userid'=>$user));
		return $ratings[0]->total;
	}

	public static function getFollowers($user=0,$limit=20,$offset=0){
		$q="SELECT *,(SELECT count(id) FROM follower WHERE follower.follow=t.user_ID ) as followers,(SELECT count(id) FROM follower WHERE follower.user_ID=t.user_ID) as following FROM (SELECT DISTINCT u.user_ID,u.user_NickName,u.user_FullName,u.image ,u.user_City,u.sufrati FROM follower f JOIN user u ON u.user_ID=f.user_ID AND u.user_Status=1 WHERE f.follow=:userid ORDER BY f.createdAt DESC LIMIT ".$offset.', '.$limit.' ) t';
		return DB::select(DB::raw($q),array('userid'=>$user));
	}

	public static function getTotalFollowing($userid){
		$q="SELECT count(id) as total FROM follower WHERE user_ID=:userid ";
		$ratings= DB::select(DB::raw($q),array('userid'=>$userid));
		return $ratings[0]->total;	
	}

	public static function getFollowing($user=0,$limit=0,$offset=0){
		$q="SELECT *,(SELECT count(id) FROM follower WHERE follower.follow=t.user_ID ) as followers,(SELECT count(id) FROM follower WHERE follower.user_ID=t.user_ID) as following FROM (SELECT DISTINCT u.user_ID,u.user_NickName,u.user_FullName,u.image ,u.user_City,u.sufrati FROM follower f JOIN user u ON u.user_ID=f.follow AND u.user_Status=1 WHERE f.user_ID=:userid ORDER BY f.createdAt DESC LIMIT ".$offset.', '.$limit.' ) t';
		return DB::select(DB::raw($q),array('userid'=>$user));	
	}

	public static function getTotalActivity($userid=0) {
        return DB::table('user_activity')->where('user_ID',$userid)->count();
    }

	public static function getActivities($userid=0,$limit=10,$offset=0){
		return DB::table('user_activity')->select('*',DB::raw('1 as useractivity'))->where('user_ID',$userid)->take($limit)->skip($offset)->orderBy('updated','DESC')->get();
	}

	public static function getUserNewsFeed($curruser=0,$limit=20,$offset=0,$filter=""){
		$selectq=$whereq=$joinq="";
		$selectq.='ua.user_ID,ua.rest_ID,ua.activity,ua.activity_ar,ua.activity_ID,ua.updated,ua.country,ua.city_ID';
        $joinq.=" user_activity ua ON ua.user_ID=f.follow ";
        $whereq.=" f.user_ID= :userid ";
        switch ($filter) {
        	case 'latest_reviews':
        		$whereq.=" AND  ua.updated ='commented on'";
        		break;
        	case 'latest_ratings':
                $whereq.=" AND ua.activity='rated on'";
                break;
            case 'latest_photos':
                $whereq.=" AND ua.activity='uploaded photo for'";
        }
        $q="SELECT ".$selectq." FROM follower f JOIN ".$joinq." WHERE ".$whereq." ORDER BY ua.updated DESC LIMIT ".$offset.", ".$limit;
        return DB::select(DB::raw($q),array('userid'=>$curruser));
	}

	public function getTotalUserNews($userid=0,$filter=""){
		$q="SELECT COUNT(f.id) as total FROM follower f JOIN user_activity ua ON ua.user_ID=f.follow WHERE f.user_ID=:userid ";
        switch ($filter) {
            case 'latest_reviews':
                $q.=" AND ua.activity='commented on'";
                break;
            case 'latest_ratings':
            	$q.=" AND ua.activity='rated on'";
                break;
            case 'latest_photos':
            	$q.=" AND ua.activity='uploaded photo for'";
                break;
        }
        $count= DB::select(DB::raw($q),array('userid'=>$userid));
        return $count[0]->total;
	}

	public static function getRestNewsFeed($curruser=0,$limit=20,$offset=0,$filter="",$timestart=0,$timeend=0){
		$selectq=$whereq=$joinq="";
		$selectq.="ra.activity,ra.activity_ID,ra.rest_ID,ra.date_add,ri.rest_Name,ri.rest_Name_Ar,ri.rest_Logo,ri.seo_url,ra.city_ID";
		$whereq.=" li.user_ID=:userid";
		$joinq.=" restaurant_info ri ON ri.rest_ID=li.rest_ID AND ri.rest_Status=1 ";
        $joinq.=" JOIN rest_activity ra ON ra.rest_ID=ri.rest_ID ";
        if($timestart!=0&&$timeend!=0){
            $whereq.=" AND ri.date_add < :timestart AND ri.date_add > :timeend";
        }
        $whereq.=" AND ra.activity NOT IN ('Logged In','Logged Out','We have changed our branch info.')";
        if($filter=="menu_updates"){
            $whereq=" AND ra.activity IN ('A New PDF Menu is added.','PDF Menu is Added.','A New Menu Type is added.','A New Menu Category is added.','A New Menu Item is added.')";
        }
        $q="SELECT ".$selectq." FROM likee_info li JOIN ".$joinq." WHERE ".$whereq." ORDER BY ra.date_add DESC LIMIT ".$offset.", ".$limit;
        return DB::select(DB::raw($q),array('userid'=>$curruser));
	}

	public function getTotalRestNews($userid=0){
		$q="SELECT COUNT(li.id) as total FROM likee_info li JOIN restaurant_info ri ON ri.rest_ID=li.rest_ID AND ri.rest_Status=1 JOIN rest_activity ra ON ra.rest_ID=ri.rest_ID WHERE li.user_ID=:user ";
		$q.=" AND ra.activity NOT IN ('Logged In','Logged Out','We have changed our branch info.') ";
        if($filter=="menu_updates"){
        	$q.=" AND ra.activity IN ('A New PDF Menu is added.','PDF Menu is Added.','A New Menu Type is added.','A New Menu Category is added.','A New Menu Item is added.')";
        }
        $count= DB::select(DB::raw($q),array('userid'=>$userid));
        return $count[0]->total;
	}


	public static function getNewsFeed($usernews=array(),$restnews=array()){
		$news=array();
		$i=0;
		if(count($usernews)>0){
			foreach ($usernews as $unews) {
				$k=array(
					'useractivity'=>1,
					'user_ID'=>$unews->user_ID,
					'rest_ID'=>$unews->rest_ID,
					'activity'=>$unews->activity,
					'activity_ar'=>$unews->activity_ar,
					'updated'=>$unews->updated,
					'activity_ID'=>$unews->activity_ID,
					'city_ID'=>$unews->city_ID
				);
				$news[$i]=(object)$k;
				$i++;
			}
		}
		if(count($restnews)>0){
			foreach ($restnews as $rnews) {
				$k=array(
					'activity'=>$rnews->activity,
					'restactivity'=>1,
					'activity_ID'=>$rnews->activity_ID,
					'rest_ID'=>$rnews->rest_ID,
					'updated'=>$rnews->date_add,
					'city_ID'=>$rnews->city_ID
				);
				$news[$i]=(object)$k;
				$i++;
			}
		}
		usort($news, "self::cmp");
		return $news;
	}

	public static function cmp($a, $b) {
	    $t1 = strtotime($a->updated);
    	$t2 = strtotime($b->updated);
    	return $t2 - $t1;
	}


	public static function getPossibleRating($id=0,$userid=0,$rest=0,$time=0){
		if($id!=0){
			return DB::table('rating_info')->where('rating_ID',$id)->first();
		}else{
			$time=(String)$time;
			$q="SELECT * FROM rating_info WHERE user_ID=:user AND rest_ID=:rest AND ABS(UNIX_TIMESTAMP(created_at)-UNIX_TIMESTAMP(:time)) < 2 ORDER BY created_at ASC LIMIT 1";
			$rating= DB::select(DB::raw($q),array('user'=>$userid,'rest'=>$rest,'time'=>$time));
			if(count($rating)>0){
				return $rating[0];	
			}
		}
	}

	public static function getPossiblePhoto($id=0,$userid=0,$rest=0,$time=0){
		if($id!=0){
			return DB::table('image_gallery')->where('image_ID',$id)->first();
		}else{
			$time=(String)$time;
			$q="SELECT * FROM image_gallery WHERE user_ID=:user AND rest_ID=:rest AND ABS(UNIX_TIMESTAMP(enter_time))-UNIX_TIMESTAMP(:time) < 2 ORDER BY enter_time ASC LIMIT 1";
			$photo=DB::select(DB::raw($q),array('user'=>$userid,'rest'=>$rest,'time'=>$time));
			if(count($photo)>0){
				return $photo[0];
			}
		}
	}

	public static function getPossibleComment($id=0,$userid=0,$rest=0,$time=0){
		if($id!=0){
			return DB::table('review')->where('review_ID',$id)->first();
		}else{
			$time=(String)$time;
			$q="SELECT * FROM review WHERE user_ID=:user AND rest_ID=:rest AND ABS(UNIX_TIMESTAMP(review_Date))-UNIX_TIMESTAMP(:time) < 2 ORDER BY review_Date ASC LIMIT 1";
			$comment= DB::select(DB::raw($q),array('user'=>$userid,'rest'=>$rest,'time'=>$time));	
			if(count($comment)>0){
				return $comment[0];	
			}
		}
	}

	public static function getPossibleOffer($id=0,$rest=0,$time=0){
		if($id!=0){
			return DB::table('rest_offer')->where('id',$id)->first();
		}else{
			$time=(String)$time;
			$q="SELECT * FROM rest_offer WHERE rest_ID=:rest AND ABS(UNIX_TIMESTAMP(createdAt))-UNIX_TIMESTAMP(:time) < 2 ORDER BY createdAt ASC LIMIT 1";
			$offer=DB::select(DB::raw($q),array('rest'=>$rest,'time'=>$time));
			if(count($offer)>0){
				return $offer;
			}
		}
	}

	public static function getSupport($id=0){
		return DB::table('likee_info')->where('id',$id)->first();
	}

	public static function getReviews($user=0,$limit=0,$offset=0){
		$q='SELECT * FROM review WHERE user_ID=:user AND review_Status=1 ORDER BY review_Date DESC LIMIT '.$offset.', '.$limit ;
		return DB::select(DB::raw($q),array('user'=>$user));
	}

	public static function getUserLikes($user=0,$limit=0,$offset=0){
		$q='SELECT DISTINCT ri.rest_ID,ri.rest_Name,ri.rest_Name_Ar,ri.rest_Logo,ri.seo_url FROM likee_info li JOIN restaurant_info ri ON ri.rest_ID=li.rest_ID AND ri.rest_Status=1 WHERE li.user_ID=:userid ORDER BY li.createdAt DESC LIMIT '.$offset.', '.$limit;
		return DB::select(DB::raw($q),array('userid'=>$user));
	}
	public static function getUserLikesCustom($user=0,$resID=0){
		$q='SELECT DISTINCT ri.rest_ID,ri.rest_Name,ri.rest_Name_Ar,ri.rest_Logo,ri.seo_url FROM likee_info li JOIN restaurant_info ri ON ri.rest_ID=li.rest_ID AND ri.rest_Status=1 WHERE li.user_ID=:userid AND ri.rest_ID =:resID';
		return DB::select(DB::raw($q),array('userid'=>$user,'resID'=>$resID));
	}

	public static function getUserPhotos($user=0,$limit=0,$offset=0){
		$selectq="SELECT DISTINCT ig.image_ID,ig.title,ig.title_ar,ig.image_full,ig.ratio,ig.width, ig.enter_time,ig.user_ID,ri.rest_Name, ri.rest_Name_Ar,ri.rest_Logo,ri.seo_url,ri.rest_ID,(SELECT COUNT(id) FROM photolike WHERE image_ID=ig.image_ID) as likes ";
		$fromq=" FROM image_gallery ig JOIN restaurant_info ri ON ri.rest_ID=ig.rest_ID AND ri.rest_Status=1 JOIN rest_branches rb ";
		$whereq=" WHERE ig.user_ID=:user AND rb.rest_fk_id=ig.rest_ID  AND ig.status=1 ";
		$orderq="ORDER BY ig.enter_time DESC";
		return DB::select(DB::raw($selectq.' '.$fromq.' '.$whereq.' '.$orderq.' LIMIT '.$offset.', '.$limit),array('user'=>$user));	
	}

	public static function getTotalFoodRecommend($user=0){
		return DB::table('recommendmenu')->where('user_ID',$user)->count();
	}

	public static function getUserFoodRecommend($user=0,$limit=0,$offset=0){
		$q="SELECT m.id,m.menu_item,m.menu_item_ar,m.image,mc.cat_name,mc.cat_name_ar,mc.cat_id,ri.rest_Name_Ar,ri.rest_Name,ri.seo_url,ri.rest_ID FROM recommendmenu rm JOIN rest_menu m ON m.id=rm.menuID JOIN menu_cat mc ON mc.cat_id=m.cat_id JOIN restaurant_info ri ON ri.rest_ID=m.rest_fk_id AND ri.rest_Status=1 WHERE rm.user_ID=:userid ORDER BY rm.createdAt LIMIT ".$offset.', '.$limit;
		return DB::select(DB::raw($q),array('userid'=>$user));
	}

	public static function totalLikeSuggestions($user=0){
		$user= DB::select(DB::raw('SELECT user_ID,user_City FROM user WHERE user_ID=:userid'),array('userid'=>$user));;
		$user=$user[0];
		if(count($user)>0){
			$userid=$user->user_ID;
			if(($user->user_City!=NULL)&&(is_numeric($user->user_City))){
				$cityid=$user->user_City;
			}else{
				if(Session::has('sfcity')){
					$cityid=Session::get('sfcity');
				}
			}
			$q="SELECT COUNT(DISTINCT ri.rest_ID) FROM restaurant_cuisine rc JOIN userlike as u ON u.cuisine_ID=rc.cuisine_ID AND u.user_ID=:userid JOIN cuisine_list cl ON cl.cuisine_ID=u.cuisine_ID JOIN rest_branches rb ON rb.rest_fk_id=rc.rest_ID";
			if($cityid!=0){
				$q.=" AND rb.city_ID=:cityid ";	
			}
			$q.=" JOIN restaurant_info ri ON ri.rest_ID=rc.rest_ID AND ri.rest_Status=1 LEFT OUTER JOIN likee_info li ON li.user_ID=u.user_ID AND ri.rest_ID=li.rest_ID WHERE cl.cuisine_Status = 1 AND li.rest_ID IS NULL AND ri.openning_manner != 'Closed Down'";
			return DB::select(DB::raw($q),array('userid'=>$userid,'cityid'=>$cityid));
		}
	}

	public static function likeSuggestions($user=0,$limit=3,$offset=0){
		$cityid=0;
	
		if($user == null){
			if(Session::has('sfcity')){
				$cityid=Session::get('sfcity');
			}
			$q='SELECT DISTINCT ri.rest_ID,ri.rest_Name,ri.rest_Name_Ar,ri.seo_url,ri.rest_Logo,getCuisineName(ri.rest_ID,"en") as cuisine,getCuisineName(ri.rest_ID,"ar") as cuisineAr,(SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=ri.rest_ID AND likee_info.status=1) as totallikes FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid WHERE ri.rest_Status=1 ORDER BY ri.rest_Subscription DESC LIMIT '.$offset.', '.$limit;
			return DB::select(DB::raw($q),array('cityid'=>$cityid));
		}else{
			$user= DB::select(DB::raw('SELECT user_ID,user_City FROM user WHERE user_ID=:userid'),array('userid'=>$user));
			 $user=$user[0];
		
			if(count($user)>0){
			
				$userid=$user->user_ID;
				if(($user->user_City!=NULL)&&(is_numeric($user->user_City))){
					$cityid=$user->user_City;
				}else{
					if(Session::has('sfcity')){
						$cityid=Session::get('sfcity');
					}		
				}
				$q="SELECT DISTINCT ri.rest_Name, ri.rest_type, ri.rest_Name_Ar, ri.rest_Logo, ri.seo_url, ri.rest_ID, getCuisineName(ri.rest_ID, 'en') as cuisine, getCuisineName(ri.rest_ID, 'ar') as cuisineAr,(SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=rc.rest_ID AND likee_info.status=1) as totallikes, class_category,(SELECT name FROM rest_type WHERE rest_type.id=ri.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=ri.rest_type) as typeAr FROM restaurant_cuisine rc JOIN userlike as u ON u.cuisine_ID=rc.cuisine_ID AND u.user_ID=:userid JOIN cuisine_list cl ON cl.cuisine_ID=u.cuisine_ID JOIN rest_branches rb ON rb.rest_fk_id=rc.rest_ID";
				if($cityid!=0){
					$q.=" AND rb.city_ID=:cityid ";	
				}
				$q.=" JOIN restaurant_info ri ON ri.rest_ID=rc.rest_ID AND ri.rest_Status=1 LEFT OUTER JOIN likee_info li ON li.user_ID=u.user_ID AND ri.rest_ID=li.rest_ID WHERE cl.cuisine_Status = 1 AND li.rest_ID IS NULL AND ri.openning_manner != 'Closed Down' ORDER BY ri.rest_Subscription DESC LIMIT ".$offset.', '.$limit;
				return DB::select(DB::raw($q),array('userid'=>$userid,'cityid'=>$cityid));
			}
		}
	}

	public static function followSuggestions($user=0,$limit=3,$offset=0,$friends=""){
		$q="SELECT u.user_ID, u.user_NickName, u.user_FullName, u.user_City, u.user_Country, u.sufrati, u.image, u.userRank, (SELECT count(id) FROM follower WHERE follow=u.user_ID) as followers,(SELECT count(id) FROM follower WHERE user_ID=u.user_ID) as following 
		FROM user u
		LEFT JOIN follower fl ON fl.follow=u.user_ID ";
		if($user!=0){
			$q.=" AND fl.user_ID =:userid ";
		}
		$q.="JOIN user_activity ua ON ua.user_ID=u.user_ID
		WHERE  fl.follow IS NULL AND u.sufratistaff = 0 AND u.user_Status=1 ";
		if($user!=0){
			$q.="AND  u.user_ID != :userid2 ";
		}
		if($friends!=""){
			$q.=" AND u.user_ID NOT IN (".$friends.")";
		}
		if(App::environment()!="local"){
			$q.=" AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < ua.updated ";
		}
		$q.=" GROUP BY u.user_ID ORDER BY u.userRank DESC LIMIT ".$offset.', '.$limit;
		if($user==0){
			return DB::select(DB::raw($q));
		}else{
			return DB::select(DB::raw($q),array('userid'=>$user,'userid2'=>$user));	
		}
	}

	public static function totalFollowSuggestions($user=0){
		$q="SELECT COUNT(DISTINCT u.user_ID) as total FROM user u LEFT JOIN follower fl ON fl.follow=u.user_ID AND fl.user_ID=:userid JOIN user_activity ua ON ua.user_ID=u.user_ID ";
		$q.=" WHERE fl.follow IS NULL AND u.sufratistaff=0 AND u.user_Status=1 AND u.user_ID !=:userid2 ";
		if(App::environment()!="local"){
			$q.=" AND DATE_SUB(NOW(), INTERVAL 1 MONTH) < ua.updated ";
		}
		$q.="";
		$count= DB::select(DB::raw($q),array('userid'=>$user,'userid2'=>$user));
		if(count($count)>0){
			return $count[0]->total;	
		}else{
			return 0;
		}
		
	}

	public static function getAllInvitees($user=0){
		return DB::table('fromgmail')->where('user_ID',$user)->where('email','!=','')->get();
	}

	public static function getInvitee($user=0,$email=''){
		return DB::table('fromgmail')->where('user_ID',$user)->where('email',$email)->first();
	}

	//Checks whether $user follows $following
	
	public static function checkFollowing($user=0,$following=0){
		return DB::table('follower')->where('user_ID',$user)->where('follow',$following)->count();
	}


	public static function checkMonthlyNotifStatus($userid=0){
		return DB::table('monthly')->where('user_ID',$userid)->first();
	}
	
	public static function checkWeeklyNotifStatus($userid=0){
		return DB::table('weekly')->where('user_ID',$userid)->first();	
	}

	public static function checkNotifyStatus($userid=0){
		return DB::table('notifications')->where('user_ID',$userid)->first();
	}

	public static function getTotalLists($userid=0){
		return DB::table('user_lists')->where('user_ID',$userid)->count();
	}

	public static function getUserLists($userid=0){
		$q="SELECT name,id,(SELECT count(id) FROM user_list_restaurant WHERE list_id=user_lists.id) as count FROM user_lists WHERE user_ID=:userid";
		return DB::select(DB::raw($q),array('userid'=>$userid));
	}

	public static function getListRestaurants($list=0){
		$q="SELECT ri.rest_ID,ri.rest_Name,ri.rest_Name_Ar,ri.seo_url,ri.rest_Logo FROM restaurant_info ri JOIN user_list_restaurant ulr ON ulr.list_id=:listid AND ulr.rest_ID=ri.rest_ID WHERE ri.rest_Status=1 AND ri.openning_manner !='Closed Down'";
		return DB::select(DB::raw($q),array('listid'=>$list));
	}

	public static function getTotalNotifications($user=0){
		return DB::table('user_notifications')->where('user_ID',$user)->count();
	}

	public static function getNotifications($user=0,$limit=15,$offset=0){
		return DB::table('user_notifications')->where('user_ID',$user)->skip($offset)->take($limit)->get();
	}

	public static function getNewNotifications($user=0){
		return DB::table('user_notifications')->where('user_ID',$user)->where('read',0)->count();
	}

	public static function checkUserRated($userid=0,$restid=0,$cityid=0){
		return DB::table('rating_info')->where('user_ID',$userid)->where('rest_ID',$restid)->where(function ($query) use ($cityid){ $query->where('city_ID','=',$cityid)->orWhere('city_ID','=',0); })->first();
	}

	public static function checkRestaurantInUserList($restid=0,$userid=0){
		$lists= DB::table('user_list_restaurant')->select('list_id')->where('user_ID',$userid)->where('rest_ID',$restid)->get();
		$presentlists=array();
		if(count($lists)>0){
			foreach ($lists as $list) {
				$presentlists[$list->list_id]=true;	
			}
		}
		return $presentlists;
	}

	public static function checkPhotoLiked($photo=0,$user=0){
		return DB::table('photolike')->where('image_ID',$photo)->where('user_ID',$user)->count();
	}

	public static function checkFollowingFbFriends($userid=0,$friends=array()){
		$friends=implode(',', $friends);
		$q="SELECT user_ID,user_NickName,user_FullName,image,user_City,sufrati,(SELECT count(id) FROM follower WHERE follower.follow=user_ID ) as followers,(SELECT count(id) FROM follower WHERE follower.user_ID=user_ID) as following FROM user WHERE facebook IN (".$friends.") AND user_Status=1";
		return DB::select(DB::raw($q));
	}

	public static function getUserEvents($userid=0){
		return DB::table('user_event')->where('user_ID',$userid)->get();
	}

	/**** User Activities rating, review ,like,follow etc ****/


	public static function AddRating($userid=0,$restid=0,$cityid=0,$country=1,$food=0,$service=0,$atmosphere=0,$presentation=0,$value=0,$variety=0){
		$checkrated=DB::table('rating_info')->where('user_ID',$userid)->where('rest_ID',$restid)->where(function ($query) use ($cityid){ $query->where('city_ID','=',$cityid)->orWhere('city_ID','=',0); })->count();
		$data=array(
			'user_ID'=>$userid,
			'rest_ID'=>$restid,
			'city_ID'=>$cityid,
			'country'=>$country,
			'rating_Food'=>$food,
			'rating_Service'=>$service,
			'rating_Atmosphere'=>$atmosphere,
			'rating_Value'=>$value,
			'rating_Presentation'=>$presentation,
			'rating_Variety'=>$variety,
			'is_read'=>0
		);
		if($checkrated>0){
			//Add city field
			DB::table('rating_info')->where('user_ID',$userid)->where('rest_ID',$restid)->update($data);
			$rt=DB::table('rating_info')->select('rating_ID')->where('user_ID',$userid)->where('rest_ID',$restid)->first();
			return $rt->rating_ID;
		}else{
			return DB::table('rating_info')->insertGetId($data);
		}
	}

	public static function AddReview($comment="",$userid=0,$restid=0,$cityid=0,$country=1,$recommend="",$mealtype=""){
		$data=array(
			'user_ID'=>$userid,
			'rest_ID'=>$restid,
			'city_ID'=>$cityid,
			'country'=>$country,
			'review_Msg'=>$comment,
			'recommend'=>$recommend,
			'orderType'=>$mealtype,
			'review_Status'=>0,
			'replyTo'=>0,
			'is_read'=>0,
			'fromMobile'=>0
		);
		return DB::table('review')->insertGetId($data);
	}

	public static function addList($user=0,$listname="",$rest=0,$country=0){
		$count=DB::table('user_lists')->where('user_ID',$user)->where('name',$listname)->count();
		if($count<=0){
			$data=array(
				'name'=>$listname,
				'user_ID'=>$user,
				'updatedAt'=>date("Y-m-d H:i:s"),
				'createdAt'=>date("Y-m-d H:i:s")
			);
			$list=DB::table('user_lists')->insertGetId($data);
			if($rest!=0&&$country!=0){
				self::addToList($list,$rest,$user,$country);	
			}else{
				return $list;
			}
		}else{
			$list=DB::table('user_lists')->where('user_ID',$user)->where('name',$listname)->first();
			if($rest!=0&&$country!=0){
				self::addToList($list->id,$rest,$user,$country);
			}else{
				return $list->id;
			}
		}
	}

	public static function addToList($list,$rest,$user,$country){
		$count=DB::table('user_list_restaurant')->where('rest_ID',$rest)->where('user_ID',$user)->where('list_id',$list)->count();
		if($count<=0){
			$data=array(
				'list_id'=>$list,
				'rest_ID'=>$rest,
				'user_ID'=>$user,
				'country'=>$country,
				'updatedAt'=>date("Y-m-d H:i:s"),
				'createdAt'=>date("Y-m-d H:i:s")
			);
			$id=DB::table('user_list_restaurant')->insertGetId($data);
			self::AddActivity($user,$rest,"add-to-list","",$id,0,$country);
		}
	}

	public static function LikeRest($rest=0,$user=0,$city=0,$status=0,$country){
		$data=array(
			'rest_ID'=>$rest,
			'user_ID'=>$user,
			'city_ID'=>$city,
			'status'=>$status,
			'ip'=>Azooma::getRealIpAddr(),
			'fromMobile'=>0,
			'facebook'=>0,
			'country'=>$country
		);
		return DB::table('likee_info')->insertGetId($data);
	}
	public static function RemoveLikeRest($rest=0,$user=0,$city=0){
		DB::table('likee_info')->where('rest_ID',$rest)->where('user_ID',$user)->delete();
	}

	public static function followUser($originaluser=0,$followeduser=0){
		$data=array(
			'user_ID'=>$originaluser,
			'follow'=>$followeduser
		);
		return DB::table('follower')->insertGetId($data);
	}

	public static function unFollowUser($originaluser=0,$followeduser=0){
		DB::table('follower')->where('user_ID',$originaluser)->where('follow',$followeduser)->delete();
	}

	public static function likePhoto($photo=0,$user=0,$country){
		$ip=Azooma::getRealIpAddr();
		$data=array(
			'image_ID'=>$photo,
			'user_ID'=>$user,
			'ip'=>$ip,
			'country'=>$country
		);
		return DB::table('photolike')->insertGetId($data);
	}

	public static function unLikePhoto($photo=0,$user=0){
		$t=DB::table('photolike')->where('image_ID',$photo)->where('user_ID',$user)->first();
		DB::table('photolike')->where('image_ID',$photo)->where('user_ID',$user)->delete();
		return $t;
	}


	public static function AddActivity($userid=0,$restid=0,$activity="",$activityAr="",$activityID=0,$cityid=0,$country=1){
		$check=DB::table('user_activity')->where('user_ID',$userid)->where('rest_ID',$restid)->where('activity_ID',$activityID)->where('activity',$activity)->where('city_ID',$cityid)->count();
		if($check<=0){
			$data = array(
	            'user_ID' => $userid,
	            'rest_ID' => $restid,
	            'city_ID'=>$cityid,
	            'activity' => $activity,
	            'activity_ar' => $activityAr,
	            'activity_ID' => $activityID,
	            'country'=>$country
	        );
	        DB::table('user_activity')->insert($data);
		}
	}

	public static function DeleteActivity($userid=0,$restid=0,$activity="",$activityID=0,$cityid=0,$country=1){
		DB::table('user_activity')->where('user_ID',$userid)->where('rest_ID',$restid)->where('activity_ID',$activityID)->where('activity',$activity)->where('city_ID',$cityid)->delete();
	}

	public static function cancelEvent($event=0){
		$data=array('status'=>2);
		DB::table('user_event')->where('id',$event)->update($data);
	}

    public static function getAllUsers($country = 0, $status = "", $name = "", $email = "", $countryuser = "", $nationality = "", $sort = "") {
        $MUsers = DB::table('user');
        if (!empty($country)) {
            $MUsers->where('sufrati', '=', $country);
        }
        if (!empty($countryuser)) {
            $MUsers->where('user_Country', 'LIKE', '%' . $countryuser . '%');
        }
        if (!empty($nationality)) {
            $MUsers->where('user_nationality', 'LIKE', '%' . $nationality . '%');
        }
        if ($status != "") {
            $MUsers->where('user_Status', '=', $status);
        }
        if (!empty($name)) {
            $MUsers->where('user_FullName', 'LIKE', "%" . $name . '%');
        }
        if (!empty($email)) {
            $MUsers->where('user_Email', 'LIKE', $email . '%');
        }
        if (!empty($sort)) {
            switch ($sort) {
                case 'name':
                    $MUsers->orderBy('user_FullName', 'DESC');
                    break;
                case 'latest':
                    $MUsers->orderBy('user_RegisDate', 'DESC');
                    break;
            }
        } else {
            $MUsers->orderBy('user_RegisDate', 'DESC');
        }
        $list = $MUsers->paginate(20);
        if (count($list) > 0) {
            return $list;
        }
    }

    public static function getUser($user_ID = 0, $status = 0) {
        $MUsers = DB::table('user');
        if (!empty($user_ID)) {
            $MUsers->where('user_ID', '=', $user_ID);
        }
        if (!empty($status)) {
            $MUsers->where('user_Status', '=', $status);
        }
        return $list = $MUsers->first();
    }

    public static function addNotification($user, $activity, $activity_text, $activity_text_ar) {
        $data = array(
            'user_ID' => $user,
            'activity_ID' => $activity,
            'activity_text' => $activity_text,
            'activity_text_ar' => $activity_text_ar
        );
        DB::table('user_notifications')->insert($data);
    }

    public static function checkNotificationStatus($userID = 0) {
        $user = DB::table('notifications')->where('user_ID', '=', $userID)->first();
        if (count($user) > 0) {
            if ($user->status == 1) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function pushNotify($user = 0, $message, $msg, $msgar) {
        $userdevices = DB::table('user_devices_list')->where('user_ID', '=', $user)->get();
        if (count($userdevices) > 0) {
            foreach ($userdevices as $device) {
                if ($device->device_ID != "0") {
                    if ($device->device_platform == "Android") {
                        if ($device->language == "ar-sa") {
                            $message['message'] = $msgar;
                        }
                        $url = 'https://android.googleapis.com/gcm/send';
                        $fields = array(
                            'registration_ids' => array($device->device_ID),
                            'data' => $message,
                        );

                        $headers = array(
                            'Authorization: key=AIzaSyBioxAsp9BfP-Jb9naYtN05f9D0wu5MYPY',
                            'Content-Type: application/json'
                        );
                        // Open connection
                        $ch = curl_init();

                        // Set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);

                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        // Disabling SSL Certificate support temporarly
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                        // Execute post
                        $result = curl_exec($ch);
                        if ($result === FALSE) {
                            //   die('Curl failed: ' . curl_error($ch));
                        }
                    } else {
                        if ($device->device_platform == "iOS") {
                            $deviceToken = $device->device_ID;
                            // Put your private key's passphrase here:
                            $passphrase = 'Hungryn137';
                            // Put your alert message here:
                            $ctx = stream_context_create();
                            if ($device->paid == 1) {
                                stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/diner/public_html/Push/Prod/Full/SfF.pem');
                            } else {
                                stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/diner/public_html/Push/Prod/LITE/sfLP.pem');
                            }
                            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
                            // Open a connection to the APNS server
                            $fp = stream_socket_client(
                                    'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
                            if (!$fp)
                            //  exit("Failed to connect: $err $errstr" . PHP_EOL);
                            //echo 'Connected to APNS' . PHP_EOL;
                            // Create the payload body
                                $body['aps'] = array(
                                    'alert' => $msg,
                                    'badge' => 1,
                                    'sound' => 'default',
                                    'message' => $message
                                );
                            // Encode the payload as JSON
                            $payload = json_encode($body);
                            // Build the binary notification
                            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                            // Send it to the server
                            $result = fwrite($fp, $msg, strlen($msg));
                            // Close the connection to the server
                            fclose($fp);
                        }
                    }
                }
            }
        }
    }

}