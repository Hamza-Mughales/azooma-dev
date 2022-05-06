<?php
class mSearch extends Eloquent{
    protected $table = 'restaurant_info';

    public static function getRestaurants($search="",$city=""){
		$restaurants=$restaurantst=array();$total=0;
        $restaurantq='SELECT DISTINCT rest_Name as name,rest_Name_ar as nameAr,rest_Logo,rest_ID,CONCAT(seo_url,"#n") as url FROM restaurant_info ri JOIN rest_branches ON rest_branches.rest_fk_id=ri.rest_ID AND rest_branches.city_ID='.$city.' WHERE ri.rest_Status=1 AND rest_branches.status=1 AND ri.rest_Name LIKE "%'.$search.'%" OR ri.rest_Name_ar LIKE "%'.$search.'%" LIMIT 0,5';
        $restaurants=DB::select($restaurantq);
		$results=$restaurants;
		return $results;
    }
    public static function getRestaurantsAll($search=""){
		$restaurants=$restaurantst=array();$total=0;
        $restaurantq='SELECT DISTINCT rest_Name as name,rest_Name_ar as nameAr,rest_Logo,rest_ID,CONCAT(seo_url,"#n") as url FROM restaurant_info ri WHERE ri.rest_Status=1 AND ri.rest_Name LIKE "%'.$search.'%" LIMIT 0,10';
        $restaurants=DB::select($restaurantq);
		$results=$restaurants;
		return $results;
    }

}