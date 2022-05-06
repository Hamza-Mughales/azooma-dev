<?php
class MHomePage extends Eloquent{

	function getNewRestaurants($city=0){
		$query='SELECT *,getCuisineName(t.rest_ID,"en") as cuisine, getCuisineName(t.rest_ID,"ar") as cuisineAr FROM  (SELECT DISTINCT ri.rest_ID,class_category, ri.rest_Logo, ri.rest_Name,ri.rest_Name_ar,ri.rest_type, ri.rest_RegisDate, ri.seo_url, (SELECT name FROM rest_type WHERE rest_type.id=ri.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=ri.rest_type) as typeAr FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid WHERE rest_Status=1  ORDER BY ri.rest_RegisDate DESC LIMIT 10) t';
		return DB::select(DB::raw($query),array('cityid'=>$city));
	}

	function getNewImages($city=0,$limit=10){
		$query='SELECT DISTINCT ri.seo_url,ri.rest_Name_ar,ri.rest_Name, ig.title,ig.title_ar,ig.image_full FROM image_gallery ig JOIN restaurant_info ri ON ri.rest_ID=ig.rest_ID AND ri.rest_Status=1 JOIN rest_branches rb ON rb.rest_fk_id=ig.rest_ID AND rb.city_ID=:cityid WHERE ig.status=1 ORDER BY enter_time DESC LIMIT '.$limit;
		return DB::select(DB::raw($query),array('cityid'=>$city));
	}

	function getNewVideos($country=0,$limit=10){
		$query='SELECT id,name_en,name_ar,youtube_en,youtube_ar FROM rest_video WHERE status=1 AND country=:country ORDER BY add_date DESC LIMIT '.$limit;
		return DB::select(DB::raw($query),array('country'=>$country));
	}

	function getSufratiFavorites($city=0){
		$query='SELECT *,getCuisineName(rest_ID,"en") as cuisine, getCuisineName(rest_ID,"ar") as cuisineAr, (SELECT COUNT(id) FROM likee_info li WHERE li.rest_ID=t.rest_ID AND li.comment_id IS NULL ) AS popularity FROM (SELECT DISTINCT ri.rest_ID, ri.rest_Name,ri.rest_Name_ar,ri.rest_type,ri.rest_Logo,ri.seo_url,ig.image_full,class_category,(SELECT name FROM rest_type WHERE rest_type.id=ri.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=ri.rest_type) as typeAr FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid JOIN image_gallery ig ON ig.rest_ID=ri.rest_ID AND ig.status=1 WHERE ri.rest_Status=1 AND ri.openning_manner!="Closed Down" AND ri.sufrati_favourite>0 GROUP BY ri.rest_ID ORDER BY RAND() LIMIT 5) t';
		return DB::select(DB::raw($query),array('cityid'=>$city));
	}


	function getFeaturedSlides($cityurl=""){
		$query='SELECT image,image_ar,a_title,a_title_ar,img_alt,img_alt_ar,link,link_ar,city_ID FROM art_work WHERE (FIND_IN_SET(:cityurl,city_ID)) AND art_work_name="Home Page Artwork" AND active=1 ORDER BY createdAt DESC' ;
		return DB::select(DB::raw($query),array('cityurl'=>$cityurl));
	}
	

	function getMeals($city=0){
		$hour=date('H');
		$checkramadan=Config::get('app.ramadan');
		$lang= Config::get('app.locale');
		if($checkramadan){

		}else{
			switch (TRUE) {
				case (5<=$hour)&&($hour<=11):
					$t['type']='breakfast';
	                if($lang=="en"){
	                    $t['meal']='<span>Breakfast</span> ';
	                }else{
	                    $t['meal']='للفطور';
	                }
	                break;
				case (11<=$hour)&&($hour<=16) :
	                $t['type']='lunch';
	                if($lang=="en"){
	                    $t['meal']='<span>Lunch</span> ';
	                }else{
	                    $t['meal']='غداء';
	                }
	                break;
	            case (17<=$hour)&&($hour<24) :
	                $t['type']='dinner';
	                if($lang=="en"){
	                    $t['meal']='<span>Dinner</span> ';
	                }else{
	                    $t['meal']='عشاء';
	                }
	                break;
	            case (24<=$hour)||($hour<5&&$hour>=0) :
	                $t['type']='latenight';
                    if($lang=="en"){
                        $t['meal']='<span>LateNight</span> ';
                    }else{
                        $t['meal']='اخر المساء';
                    }
	                break;
			}
			$query='SELECT *,(SELECT COUNT(id) FROM likee_info li WHERE li.rest_ID=t.rest_ID AND li.comment_id IS NULL ) AS popularity,getCuisineName(rest_ID,"en") as cuisine, getCuisineName(rest_ID,"ar") as cuisineAr FROM (SELECT DISTINCT ri.rest_ID, ri.rest_Name,ri.rest_Name_ar,ri.rest_type,ri.rest_Logo,ri.seo_url,ig.image_full,class_category,  (SELECT name FROM rest_type WHERE rest_type.id=ri.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=ri.rest_type) as typeAr FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid JOIN image_gallery ig ON ig.rest_ID=ri.rest_ID AND ig.status=1 WHERE ri.rest_Status=1 AND ri.openning_manner!="Closed Down" AND ri.'.$t['type'].'=1 GROUP BY ri.rest_ID ORDER BY RAND() LIMIT 5) t';
			$t['restaurants']=DB::select(DB::raw($query),array('cityid'=>$city));
			return $t;
		}
	}

	function getPopularCuisines($city=0){
		$cuisineq="SELECT cl.cuisine_ID,cl.cuisine_Name,cl.cuisine_Name_ar,cl.image,cl.seo_url,COUNT(DISTINCT rc.rest_ID) as total FROM cuisine_list cl JOIN restaurant_cuisine rc ON rc.cuisine_ID=cl.cuisine_ID JOIN rest_branches rb ON rb.rest_fk_id=rc.rest_ID AND rb.city_ID=:cityid JOIN restaurant_info ri ON ri.rest_ID=rc.rest_ID AND ri.rest_Status=1 WHERE cl.cuisine_Status=1 AND ri.openning_manner!='Closed Down'  GROUP BY cl.cuisine_ID ORDER BY cl.cuisine_viewed DESC LIMIT 0,10";
		return DB::select(DB::raw($cuisineq),array('cityid'=>$city));
	}

	public function getPopularLocalities($city=0){
		//$localitiesq='SELECT DISTINCT dl.district_Name,dl.district_Name_ar,dl.seo_url,dl.district_ID, (SELECT COUNT(DISTINCT rest_branches.rest_fk_id) FROM rest_branches WHERE rest_branches.district_ID=dl.district_ID AND rest_branches.city_ID='.$city.' AND rest_branches.status=1) as total FROM district_list dl JOIN rest_branches rb ON rb.city_ID=:cityid AND rb.district_ID= dl.district_ID JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 WHERE dl.district_Status=1 AND dl.city_ID='.$city.' ORDER BY dl.district_Name ASC LIMIT 10';
		$localitiesq='SELECT dl.district_ID,dl.district_Name,dl.district_Name_ar,dl.seo_url, (SELECT COUNT(DISTINCT rb.rest_fk_id) FROM rest_branches rb INNER JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 WHERE rb.status=1 AND rb.district_ID=dl.district_ID AND ri.openning_manner!="Closed Down") as total FROM district_list dl WHERE dl.district_Status=1 AND dl.city_ID=:cityid ORDER BY total DESC LIMIT 20';
		return DB::select(DB::raw($localitiesq),array('cityid'=>$city));
	}

	public function getPopularFeatures($city=0,$limit=20){
		$return=array();
		$query="SELECT DISTINCT GROUP_CONCAT(DISTINCT rb.seating_rooms) as seating, GROUP_CONCAT(DISTINCT rb.features_services) as features,GROUP_CONCAT(DISTINCT rb.mood_atmosphere) as moods FROM rest_branches rb JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 WHERE rb.status=1 AND rb.city_ID=:cityid";
		DB::raw("SET SESSION group_concat_max_len = 100000");
		$popularfeatures= DB::select(DB::raw($query),array('cityid'=>$city));
		if(count($popularfeatures)>0){
			$features=preg_split('@,@', $popularfeatures[0]->features, NULL, PREG_SPLIT_NO_EMPTY);
			array_pop($features);
            $features=array_unique($features);
            $kfeatures=array();
            foreach ($features as $feature) {
            	$kfeatures[]=array(
            		'name'=>$feature,
            		'category'=>'services'
            	);
            }
            $features=$kfeatures;
            $seating=preg_split('@,@', $popularfeatures[0]->seating, NULL, PREG_SPLIT_NO_EMPTY);
            array_pop($seating);
            $seating=array_unique($seating);
            $kseating=array();
            foreach ($seating as $stng) {
            	$kseating[]=array(
            		'name'=>$stng,
            		'category'=>'seatings'
            	);
            }
            $seating=$kseating;
            $moods=preg_split('@,@', $popularfeatures[0]->moods, NULL, PREG_SPLIT_NO_EMPTY);
            array_pop($moods);
            $moods=array_unique($moods);
            $kmoods=array();
            foreach ($moods as $md) {
            	$kmoods[]=array(
            		'name'=>$md,
            		'category'=>'atmosphere'
            	);
            }
            $moods=$kmoods;
            $all=array_merge($features,$seating,$moods);
            if($limit!=0){
            	$return = array_slice($all,0,$limit);
            }else{
            	$return=$all;
            }
		}
		return $return;
	}

	public static function getLatestNews($city=0,$user=0){
		$selectq=$joinq="";
		$whereq="1=1"; 
		if($user==0){
			$selectq="DISTINCT(ua.user_ID),ua.rest_ID,ua.activity,ua.activity_ID,ua.updated,ua.country,ua.city_ID, u.user_FullName, u.user_NickName, u.image ";
			$joinq=" user u ON u.user_ID=ua.user_ID AND u.user_Status=1 ";
			$whereq.=" AND (ua.city_ID=:cityid OR ua.city_ID=0)";
	        $q="SELECT ".$selectq." FROM user_activity ua JOIN ".$joinq."WHERE ".$whereq." GROUP BY ua.user_ID ORDER BY ua.updated DESC LIMIT 0,10 ";
	        return DB::select(DB::raw($q),array('cityid'=>$city));
		}else{
			$selectq.='ua.user_ID,ua.rest_ID,ua.activity,ua.activity_ar,ua.activity_ID,ua.updated,ua.country,ua.city_ID, u.user_FullName, u.user_NickName, u.image ';
	        $joinq.=" user_activity ua ON ua.user_ID=f.follow JOIN user u on u.user_ID=ua.user_ID AND u.user_Status=1 ";
	        $whereq.=" AND f.user_ID= :userid ";
	        $q="SELECT ".$selectq." FROM follower f JOIN ".$joinq." WHERE ".$whereq." ORDER BY ua.updated DESC LIMIT 0,10";
	        return DB::select(DB::raw($q),array('userid'=>$user));
		}
		
	}

	public static function getRandomMembers($cityid){
		$r=rand(1,2);
		$qstring=" AND ri.rest_Subscription>0 ORDER BY ri.rest_Subscription DESC";
		if($r==2){
			$qstring=" AND ri.sufrati_favourite >0 ";
		}
		$q="SELECT DISTINCT ri.rest_ID, ri.rest_Name,ri.rest_Name_Ar,ri.rest_Logo,getCoverPhoto(rest_ID) as cover,ri.seo_url,(SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=ri.rest_ID) as totalvoters,(SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=ri.rest_ID AND likee_info.status=1) as totallikers FROM restaurant_info ri  JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid WHERE ri.rest_Status=1 AND getCoverPhoto(rest_ID) COLLATE utf8_unicode_ci  !='' ".$qstring." LIMIT 0,20";
		$restaurants=DB::select(DB::raw($q),array('cityid'=>$cityid));
		if(count($restaurants)>0){
			shuffle($restaurants);
            $randmembers=array_slice($restaurants,0,4);
            return $randmembers;
		}
	}



}