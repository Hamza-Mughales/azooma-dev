<?php
class Cron extends Eloquent {

	public static function getRandomBirthdayMemssage(){
		$total=DB::table('birthday')->count();
		$total--;
		return DB::table('birthday')->take(1)->skip($total)->first();
	}


	public static function getRandomMembers($city=0,$country=1){
		$q="SELECT DISTINCT ri.rest_ID,ri.rest_Name, ri.rest_Logo,ri.seo_url FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID";
		if($city!=0){
			$q.=" AND rb.city_ID=:cityid ";	
		}
		$q.=" WHERE ri.rest_Status=1 AND rb.status=1 AND ri.openning_manner!='Closed down' AND ri.country=:country ORDER BY RAND() LIMIT 0,5";
		return DB::select(DB::raw($q),array('cityid'=>$city,'country'=>$country));
	}


	public static function getDailyVisits($country=0,$date=0){
		$q=DB::table('analytics')->where('country',$country);
		if($date!=0){
			$q->whereRaw('DATE(created_at)= "'.$date.'"');
		}
		return $q->count();
	}

	public static function getTotalEvents($country=0,$date=0){
		return DB::table('user_event')->where('country',$country)->whereRaw('DATE(createdAt) = "'.$date.'"')->count();
	}


	public static function getDailyKeywords($country=0,$date){
		$q='SELECT DISTINCT search_term FROM analytics WHERE search_term != "" AND search_term NOT LIKE "%fdj%" AND DATE(created_at) = "'.$date.'" AND country=:countryid  GROUP BY search_term LIMIT 15';
		return DB::select(DB::raw($q),array('countryid'=>$country));
	}

	public static function getTrafficDetails($country=0,$date=0){
		$direct=DB::table('analytics')->where('country',$country)->whereRaw('DATE(created_at)= "'.$date.'"')->whereRaw('(ref="direct" OR ref LIKE "%.azooma.co%")')->count();
		$total=Self::getDailyVisits($country,$date);
		if($total!=0){
			return round(($direct/$total)*100,1);	
		}else{
			return 0;
		}

	}

	public static function getTotalComments($country=0,$date){
		return DB::table('review')->where('country',$country)->whereRaw('DATE(review_Date)= "'.$date.'"')->count();
	}

	public static function getTotalRatings($country=0,$date){
		return DB::table('rating_info')->where('country',$country)->whereRaw('DATE(created_at)= "'.$date.'"')->count();
	}

	public static function getTotalMenuDownloads($country=0,$date){
		return DB::table('menu_downloads')->where('country',$country)->whereRaw('DATE(createdAt)= "'.$date.'"')->count();
	}

	public static function getTotalMenuRequests($country=0,$date){
		return DB::table('menurequest')->where('country',$country)->whereRaw('DATE(createdAt)= "'.$date.'"')->count();
	}

	public static function getTotalWebsiteClicks($country=0,$date){
		return DB::table('rest_website_visits')->where('country',$country)->whereRaw('DATE(createdAt)= "'.$date.'"')->count();
	}

	public static function getTotalNewRestaurants($country=0,$date){
		return DB::table('restaurant_info')->where('country',$country)->whereRaw('DATE(rest_RegisDate)= "'.$date.'"')->count();
	}

	public static function getNewUsers($country=0,$date){
		return DB::table('user')->where('sufrati',$country)->whereRaw('DATE(user_RegisDate)= "'.$date.'"')->count();
	}

	public static function getNewPhotos($country=0,$date){
		return DB::table('image_gallery')->where('country',$country)->whereRaw('DATE(enter_time)= "'.$date.'"')->count();
	}

	public static function getMember($country=0,$membership=0,$date=0){
		if($date!=0){
			$q="SELECT COUNT(bm.id_user) as total FROM booking_management bm JOIN restaurant_info ri ON ri.rest_Subscription=:membership AND ri.country=:country AND DATE(bm.date_add)=:dategiven AND ri.rest_Status=1 AND ri.openning_manner!='Closed down'";
			$k= DB::select(DB::raw($q),array('membership'=>$membership,'country'=>$country,'dategiven'=>$date));
			return $k[0]->total;
		}else{
			return DB::table('restaurant_info')->where('rest_Status',1)->where('rest_Subscription',$membership)->where('country',$country)->where('openning_manner','!=','Closed down')->count();
		}
	}

	public static function getTotalAppDownloads($country=0,$date=0,$platform=""){
		$q=DB::table('user_devices_list')->where('country',$country)->whereRaw('DATE(createdAt)= "'.$date.'"');
		if($platform!=""){
			$q->where('device_platform',$platform);
		}
		return $q->count();
	}

	public static function getTotalAppHits($country=0,$date=0){
		$q= DB::table('logs')->where('country',$country);
		if($date!=0){
			$q->whereRaw('DATE(FROM_UNIXTIME(time))= "'.$date.'"');
		}
		return $q->count();
	}

	public static function getPopularCities($country=0,$date=0){
		$q="SELECT cl.city_Name, COUNT(a.city_ID) as visits FROM analytics a JOIN city_list cl ON cl.city_ID=a.city_ID AND cl.city_Status=1 WHERE a.country=:country AND DATE(a.created_at) =:dategiven GROUP BY a.city_ID LIMIT 3";
		return DB::select(DB::raw($q),array('country'=>$country,'dategiven'=>$date));

	}



}