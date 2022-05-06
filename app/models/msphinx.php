<?php
class MSphinx extends Eloquent{
    protected $table = 'restaurant_info';
    /****

	The groupBy function of SphinxSearch aded by @mohamedfasil, not part of scalia/sphinxsearch
    *****/

    public static function getRestaurants($query="",$cityid=0,$ajax=false,$limit=15,$offset=0){
    	//SphinxSearch::resetSphinx();
    	$restaurants=$restaurantst=array();$total=0;
    	$restaurantssp=SphinxSearch::search($query.'*', 'rest_db')->filter('city_ID', array($cityid))->limit($limit,$offset)->get();
		if(!isset($restaurantssp['matches'])||(isset($restaurantssp['matches']))&&count($restaurantssp['matches'])<=0){
			$restaurantssp=SphinxSearch::search($query, 'rest_db')->filter('city_ID', array($cityid))->limit($limit,$offset)->get();
		}
		if(isset($restaurantssp['matches'])&&count($restaurantssp['matches'])>0){
			$total=$restaurantssp['total'];
            foreach ($restaurantssp['matches'] as $match) {
                $restaurantst[]=$match['attrs']['rest_id'];
            }
			$restaurantssp=join(',',$restaurantst);
			if($ajax){
				$restaurantq='SELECT rest_Name as name,rest_Name_ar as nameAr,CONCAT(seo_url,"#n") as url , rest_Logo FROM restaurant_info ri WHERE ri.rest_Status=1 AND ri.rest_ID IN ('.$restaurantssp.') ORDER BY FIELD(ri.rest_ID,'.$restaurantssp.') LIMIT 0,5';
			}else{
				$restaurantq= 'SELECT *, getCuisineName(t.id,"en") as cuisine, getCuisineName(t.id,"ar") as cuisineAr, getCoverPhoto(t.id) as thephoto, getRestaurantTel(t.id) as telephone,(SELECT name FROM rest_type WHERE rest_type.id=t.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=t.rest_type) as typeAr, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=t.id ) as menu, (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID='.$cityid.') as branches, (SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=t.id AND likee_info.status=1 AND comment_id IS NULL) as `like` FROM (SELECT rest_Name as name,rest_Name_ar as nameAr,seo_url as url,rest_ID as id,rest_Logo as logo,class_category,price_range,rest_type, sufrati_favourite FROM restaurant_info ri WHERE ri.rest_Status=1 AND ri.rest_ID IN ('.$restaurantssp.') ORDER BY FIELD(ri.rest_ID,'.$restaurantssp.') ) t';
			}
			$restaurants=DB::select($restaurantq);
		}
		$results=array('restaurants'=>$restaurants,'total'=>$total);
		return $results;
    }

    public static function getSections($query="",$cityid=0,$ajax){
    	//SphinxSearch::resetSphinx();
    	$sectionssp=SphinxSearch::search($query.'*', 'sections_db')->filter('city_ID', array($cityid))->get();
		if(isset($sectionssp['matches'])&&count($sectionssp['matches'])>0){
		}else{
			$sectionssp=SphinxSearch::search($query, 'sections_db')->filter('city_ID', array($cityid))->get();
		}
		if(isset($sectionssp['matches'])&&count($sectionssp['matches'])>0){
			$sectionssp=join(',',$sectionssp);
			$sectionsq='SELECT name,nameAr,CONCAT(url,"#n") FROM sufrati_sections WHERE id IN ('.$sectionssp.') ORDER BY FIELD(id,'.$sectionssp.')';
			$sections=DB::select($sectionsq);
			return $sections;
		}
    }


    public static function getCuisines($query="",$cityid=0,$ajax){
    	//SphinxSearch::resetSphinx();
    	$cuisinessp=SphinxSearch::search($query,'cuisine_db')->filter('city_ID',array($cityid))->get();
    	$cuisinet=array();
		if(!isset($cuisinessp['matches'])||count($cuisinessp['matches'])<=0){
			$cuisinessp=SphinxSearch::search($query,'cuisine_db')->filter('city_ID',array($cityid))->get();
		}
		if(isset($cuisinessp['matches'])&&count($cuisinessp['matches'])>0){
			foreach ($cuisinessp['matches'] as $match) {
				$cuisinet[]=$match['attrs']['cuisine_id'];
			}
			$cuisinessp=join(',',$cuisinet);
			$cuisineq='SELECT cuisine_Name as name,cuisine_Name_ar as nameAr,CONCAT(seo_url,"/restaurants") as url FROM cuisine_list WHERE cuisine_Status=1 AND cuisine_ID IN ('.$cuisinessp.') ORDER BY FIELD(cuisine_ID,'.$cuisinessp.')';
            if($ajax){
                $cuisineq.="  LIMIT 0,5";
            }
			$cuisines=DB::connection('new-sufrati')->select($cuisineq);
			return $cuisines;
		}
    }

    public static function getHotels($query="",$cityid=0,$ajax=false,$limit=15,$offset=0){
    	//SphinxSearch::resetSphinx();
    	$total=0;$hotels=array();
    	$hotelssp = SphinxSearch::search($query.'*','hotel_db')->limit($limit,$offset)->get();
    	if(!isset($hotelssp['matches'])||count($hotelssp['matches'])<=0){
    		$hotelssp = SphinxSearch::search($query,'hotel_db')->limit($limit,$offset)->get();
    	}
    	if(isset($hotelssp['matches'])&&count($hotelssp['matches'])>0){
    		$total=$hotelssp['total'];
			$hotelssp=array_keys($hotelssp['matches']);
			$hotelssp=join(',',$hotelssp);
			if($ajax){
                $hotelq="SELECT hotel_name as name,hotel_name_ar as nameAr,CONCAT('hotel/',url) as url,'Hotels' as category,$total as total,CONCAT('','hotels') as mainurl FROM hotel_info WHERE id IN (".$hotelssp.") ORDER BY FIELD(hotel_info.id,".$hotelssp.")  LIMIT 0,5";
            }else{
                $hotelq="SELECT hotel_name as name ,hotel_name_ar as nameAr,hotel_logo as logo,star,id,url FROM hotel_info WHERE id IN (".$hotelssp.") ORDER BY FIELD(hotel_info.id,".$hotelssp.")";
            }
            $hotels=DB::select($hotelq);
		}
		$results=array(
			'hotels'=>$hotels,
			'total'=>$total
		);
		return $results;
    }

    public static function getMenu($query,$cityid,$ajax,$limit,$offset){
    	//SphinxSearch::resetSphinx();
    	$total=0;$menus=array();
    	$menussp = SphinxSearch::search($query.'*','menu_db')->filter('city',array($cityid))->limit($limit,$offset)->get();
    	if(!isset($menussp['matches'])||count($menussp['matches'])<=0){
    		$menussp = SphinxSearch::search($query,'menu_db')->filter('city',array($cityid))->limit($limit,$offset)->get();
    	}
    	if(isset($menussp['matches'])&&count($menussp['matches'])>0){
    		$total=$menussp['total'];
    		foreach ($menussp['matches'] as $match) {
				$menut[]=$match['attrs']['cat'];
			}
			$menussp=join(',',$menut);
			if($ajax){
                $menuq="SELECT cat_name as name,cat_name_ar as nameAr,CONCAT('food?dish=',cat_name) as url,'Menu' as category,$total as total,CONCAT('','menus') as mainurl FROM menu_cat WHERE cat_id IN (".$menussp.") ORDER BY FIELD(menu_cat.cat_id,".$menussp.") LIMIT 0,5";
            }else{
                $menuq="SELECT cat_name,cat_name_ar FROM menu_cat WHERE cat_id IN (".$menussp.")  ORDER BY FIELD(menu_cat.cat_id,".$menussp.")";
            }
            $menus=DB::select($menuq);
    	}
    	return $menus;
    }

    public static function getDishes($query="",$cityid=0,$ajax,$limit,$offset){
    	//SphinxSearch::resetSphinx();
    	$total=0;$foods=array();
    	$foodssp=SphinxSearch::search($query.'*','food_db')->filter('city',array($cityid))->limit($limit,$offset)->get();
    	if(!isset($foodssp['matches'])||count($foodssp['matches'])<=0){
    		$foodssp = SphinxSearch::search($query,'food_db')->filter('city',array($cityid))->limit($limit,$offset)->get();
    	}
    	if(isset($foodssp['matches'])&&count($foodssp['matches'])>0){
    		$total=$foodssp['total'];
    		foreach ($foodssp['matches'] as $match) {
				$foodt[]=$match['attrs']['dish'];
			}
			$foodssp=join(',',$foodt);
			if($ajax){
                $foodq="SELECT rest_Name as rest,rest_Name_Ar as restAr,CONCAT(seo_url,'#rest-menu') as url,menu_item as name,menu_item_ar as nameAr,'Dish' as category,$total as total,CONCAT('','menus') as mainurl FROM rest_menu JOIN restaurant_info WHERE restaurant_info.rest_ID=rest_menu.rest_fk_id AND rest_menu.id IN (".$foodssp.") ORDER BY FIELD(rest_menu.id,".$foodssp.")  LIMIT 0,5";
            }else{
                $foodq="SELECT rest_Name ,rest_Name_Ar ,seo_url ,rest_ID,rest_Logo,class_category,price_range,menu_item as name,menu_item_ar as nameAr, (SELECT cat_name FROM menu_cat WHERE cat_id=rest_menu.cat_id) as category,(SELECT cat_name FROM menu_cat WHERE cat_id=rest_menu.cat_id) as categoryAr FROM rest_menu JOIN restaurant_info WHERE restaurant_info.rest_ID=rest_menu.rest_fk_id AND rest_menu.id IN (".$foodssp.") ORDER BY FIELD(rest_menu.id,".$foodssp.")";
            }
            $foods=DB::select($foodq);
    	}
    	$results=array(
			'foods'=>$foods,
			'total'=>$total
		);
		return $results;
    }

    public static function getDistricts($query="",$cityid=0,$ajax,$limit,$offset){
    //	SphinxSearch::resetSphinx();
    	$total=0;$districts=array();
    	$districtssp=SphinxSearch::search($query.'*','district_db')->filter('city_ID',array($cityid))->limit($limit,$offset)->get();
    	if(!isset($districtssp['matches'])||count($districtssp['matches'])<=0){
    		$districtssp = SphinxSearch::search($query,'district_db')->filter('city_ID',array($cityid))->limit($limit,$offset)->get();
    		
    	}
    	if(isset($districtssp['matches'])&&count($districtssp['matches'])>0){
    		$total=$districtssp['total'];
			$districtssp=array_keys($districtssp['matches']);
			$districtssp=join(',',$districtssp);
			if($ajax){
                $districtq="SELECT district_Name as name,district_Name_ar as nameAr,CONCAT(seo_url,'/restaurants') as url,district_ID,'Districts' as category,$total as total,CONCAT('','locations') as mainurl FROM district_list WHERE district_ID IN (".$districtssp.")  ORDER BY FIELD(district_list.district_ID,".$districtssp.") LIMIT 0,5";
            }else{
                $districtq="SELECT district_Name,district_Name_ar,district_ID,city_Name,city_Name_ar,district_list.city_ID FROM district_list JOIN city_list WHERE city_list.city_ID=district_list.city_ID AND district_ID IN (".$districtssp.") ORDER BY FIELD(district_list.district_ID,".$districtssp.")";
            }
            $districts=DB::select($districtq);
    	}
    	return $districts;
    }


    public static function getLocations($query="",$cityid=0,$ajax,$limit,$offset){
    	//SphinxSearch::resetSphinx();
    	$total=0;$locations=array();
    	$locationssp=SphinxSearch::search($query.'*','location_db')->filter('city_ID',array($cityid))->limit($limit,$offset)->get();
    	if(!isset($locationssp['matches'])||count($locationssp['matches'])<=0){
    		$locationssp = SphinxSearch::search($query,'location_db')->filter('city_ID',array($cityid))->limit($limit,$offset)->get();
    	}
    	if(isset($locationssp['matches'])&&count($locationssp['matches'])>0){
    		$total=$locationssp['total'];
			$locationssp=array_keys($locationssp['matches']);
			$locationssp=join(',',$locationssp);
			if($ajax){
                $branchsq="SELECT br_loc as name,br_loc_ar as nameAr,CONCAT('rest/',seo_url,'/',br_id) as url,'Locations' as category,$total as total,CONCAT('','locations') as mainurl FROM rest_branches JOIN restaurant_info WHERE restaurant_info.rest_ID=rest_branches.rest_fk_id AND br_id IN ($locationssp) ORDER BY FIELD(rest_branches.rest_fk_id,$locationssp) LIMIT 0,5";
            }else{
                $branchsq="SELECT br_loc ,br_loc_ar, br_id, seo_url ,restaurant_info.rest_Name,restaurant_info.rest_Name_Ar FROM rest_branches JOIN restaurant_info WHERE restaurant_info.rest_ID=rest_branches.rest_fk_id AND br_id IN (".$locationssp.")  ORDER BY FIELD(rest_branches.rest_fk_id,".$locationssp.")";
            }
            $locations=DB::select($branchsq);
		}
		$results=array(
			'branches'=>$locations,
			'total'=>$total
		);
		return $results;
    }


}