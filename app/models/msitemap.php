<?php
class MSiteMap extends Eloquent {

	public static function getListRestaurantsWithAlphabet($city=0){
		return DB::select(DB::raw("SELECT SUBSTRING(ri.rest_Name,1,1) as letter, count(DISTINCT ri.rest_ID) as total FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid AND rb.status=1 WHERE ri.rest_Status=1 AND ri.openning_manner!='Closed Down' GROUP BY SUBSTRING(ri.rest_Name,1,1)"),array('cityid'=>$city));
	}


	public static function getTotalRestaurantsWithAlphabet($alphabet="",$city=0){
		$q="SELECT COUNT(DISTINCT ri.rest_ID) as total FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid AND rb.status=1 WHERE ri.rest_Status=1 AND ri.openning_manner!='Closed Down' AND SUBSTRING(ri.rest_Name,1,1) = :alphabet";
		return DB::select(DB::raw($q),array('cityid'=>$city,'alphabet'=>$alphabet));
	}
	public static function getRestaurantsWithAlphabet($alphabet="",$city=0,$limit=50,$offset=0){
		$q="SELECT DISTINCT ri.rest_ID,ri.rest_Name,ri.rest_Name_Ar,ri.seo_url FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid AND rb.status=1 WHERE ri.rest_Status=1 AND ri.openning_manner!='Closed Down' AND SUBSTRING(ri.rest_Name,1,1) = :alphabet ORDER BY ri.rest_Name ASC LIMIT ".$offset.", ".$limit;
		return DB::select(DB::raw($q),array('cityid'=>$city,'alphabet'=>$alphabet));	
	}

	public static function getLocationsStartingWith($alphabet="",$city=0){
		$q="SELECT COUNT(DISTINCT dl.district_ID) as total FROM district_list dl JOIN rest_branches rb ON rb.city_ID=:cityid AND rb.district_ID=dl.district_ID WHERE dl.district_Status=1 AND SUBSTRING(dl.district_Name,1,1)=:alphabet";
		$total= DB::select(DB::raw($q),array('cityid'=>$city,'alphabet'=>$alphabet));
		if(count($total)>0){
			return $total[0]->total;	
		}else{
			return 0;
		}
		

	}

	public static function getCuisinesStartingWith($alphabet="",$city=0){

	}

}