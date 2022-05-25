<?php
class MListings extends Eloquent{

	public function getCuisineMasterChildListings($city=0){
		$mcq='SELECT DISTINCT mc.id,mc.name,mc.name_ar FROM master_cuisine mc JOIN cuisine_list cl ON cl.master_id=mc.id JOIN rest_branches rb ON rb.city_ID='.$city.' AND rb.status=1 JOIN restaurant_cuisine rc  ON rc.cuisine_ID =cl.cuisine_ID AND rc.rest_ID=rb.rest_fk_id WHERE mc.status=1 AND cl.cuisine_Status=1 ORDER BY name ASC';
		$mastercuisines=DB::connection('new-sufrati')->select($mcq);
		$cuisines=array();
		$i=0;
		foreach ($mastercuisines as $mc) {
			$cuisineq='SELECT DISTINCT cu.seo_url,cu.cuisine_Name,cu.cuisine_Name_ar FROM cuisine_list cu JOIN rest_branches rb ON rb.city_ID='.$city.' AND rb.status=1 JOIN restaurant_cuisine rc ON rc.cuisine_ID=cu.cuisine_ID AND rc.rest_ID=rb.rest_fk_id JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 AND ri.openning_manner!="Closed Down" WHERE cu.cuisine_Status=1 AND cu.master_id='.$mc->id;
			$subcuisines=DB::connection('new-sufrati')->select($cuisineq);
			if(count($subcuisines)>0){
				$cuisines[$i]['master']=$mc;
				$cuisines[$i]['subcuisines']=$subcuisines;
				$i++;	
			}
			
		}
		$othercuisines=DB::connection('new-sufrati')->select('SELECT DISTINCT cu.seo_url,cu.cuisine_Name,cu.cuisine_Name_ar FROM cuisine_list cu JOIN rest_branches rb ON rb.city_ID='.$city.' AND rb.status=1 JOIN restaurant_cuisine rc ON rc.cuisine_ID=cu.cuisine_ID AND rc.rest_ID=rb.rest_fk_id WHERE cu.cuisine_Status=1 AND cu.master_id=0');
		$full=array(
			'maincuisines'=>$cuisines,
			'othercuisines'=>$othercuisines
		);
		return $full;
	}


	public function getAllCuisines($city=0){
		$cuisineq="SELECT cl.cuisine_ID,cl.cuisine_Name,cl.image,cl.cuisine_Name_ar,cl.seo_url,COUNT(DISTINCT rc.rest_ID) as total FROM cuisine_list cl JOIN restaurant_cuisine rc ON rc.cuisine_ID=cl.cuisine_ID JOIN rest_branches rb ON rb.rest_fk_id=rc.rest_ID AND rb.city_ID=:cityid JOIN restaurant_info ri ON ri.rest_ID=rc.rest_ID AND ri.rest_Status=1 WHERE cl.cuisine_Status=1 AND ri.openning_manner!='Closed Down' GROUP BY cl.cuisine_ID ORDER BY cl.cuisine_Name ASC";
		return DB::select(DB::raw($cuisineq),array('cityid'=>$city));
	}
	public function getCustomCuisines($cityid=0,$cuisinename=""){
	
		$mastercuisines=DB::select('SELECT DISTINCT id,name,name_ar FROM master_cuisine WHERE name="'.$cuisinename.'"');
		$mastercuisiness = $mastercuisines[0];

        $maincuisines=DB::connection('new-sufrati')->select('SELECT DISTINCT cu.cuisine_ID,cu.seo_url,cu.cuisine_Name,cu.cuisine_Name_ar,COUNT(DISTINCT rc.rest_ID) as total FROM cuisine_list cu JOIN rest_branches rb ON rb.city_ID='.$cityid.' AND rb.status=1 JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 JOIN restaurant_cuisine rc ON rc.cuisine_ID=cu.cuisine_ID AND rc.rest_ID=rb.rest_fk_id WHERE cu.cuisine_Status=1 AND cu.master_id='.$mastercuisiness->id.' GROUP BY cu.cuisine_ID ORDER BY cu.cuisine_Name ASC');
        return $maincuisines;
	}

	public function getAllLocalities($city=0){
		$localitiesq='SELECT * FROM (SELECT dl.district_ID,dl.district_Name,dl.district_Name_ar,dl.seo_url, (SELECT COUNT(DISTINCT rb.rest_fk_id) FROM rest_branches rb INNER JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 WHERE rb.status=1 AND rb.district_ID=dl.district_ID AND ri.openning_manner!="Closed Down") as total FROM district_list dl WHERE dl.district_Status=1 AND dl.city_ID=:cityid ORDER BY dl.district_Name ASC) as t WHERE t.total>0';
		return DB::select(DB::raw($localitiesq),array('cityid'=>$city));
	}
	public static function getAllLocalities2($city=0){
		$localitiesq='SELECT * FROM (SELECT dl.district_ID,dl.district_Name,dl.district_Name_ar,dl.seo_url, (SELECT COUNT(DISTINCT rb.rest_fk_id) FROM rest_branches rb INNER JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 WHERE rb.status=1 AND rb.district_ID=dl.district_ID AND ri.openning_manner!="Closed Down") as total FROM district_list dl WHERE dl.district_Status=1 AND dl.city_ID=:cityid ORDER BY dl.district_Name ASC) as t WHERE t.total>0';
		return DB::select(DB::raw($localitiesq),array('cityid'=>$city));
	}

}