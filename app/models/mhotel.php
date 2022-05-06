<?php
class MHotel extends Eloquent{
    protected $table = 'hotel_info';

    public static function getAllHotels($city = 0, $cuisine = "", $menu = "", $wheelchair = "", $price = "", $sort = "", $limit = "", $offset = "", $latitude = "", $longitude = "", $count = false){
    	
    	$selectq = $orderq = $joinq = "";
        $whereq = "WHERE 1=1 ";
        $selectq.='hotel_info.id,hotel_info.url,hotel_info.hotel_name AS name,hotel_info.hotel_name_ar nameAr,hotel_info.hotel_logo as logo, hotel_info.star';
        $joinq.=' JOIN hotel_rest ON hotel_rest.hotel_id=hotel_info.id';
        $joinq.=' JOIN rest_branches ON rest_branches.br_id=hotel_rest.rest_id AND rest_branches.city_ID=' . $city;
        $joinq.=' JOIN restaurant_info ON restaurant_info.rest_ID=rest_branches.rest_fk_id';
        $whereq.=' AND hotel_info.status=1';
        $whereq.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($wheelchair!=""){
            $whereq.=" AND rest_branches.features_services LIKE '%Wheel Chair%' ";
        }
        if ($cuisine != "") {
            $joinq.=' JOIN restaurant_cuisine ON restaurant_cuisine.rest_ID=restaurant_info.rest_ID ';
            $whereq.='AND restaurant_cuisine.cuisine_ID IN( ' . $cuisine . ' ) ';
        }
        if ($menu != "") {
            $joinq.=' JOIN menuall ON menuall.rest_ID=restaurant_info.rest_ID';
        }
        if ($price != "") {
            $whereq.=' AND restaurant_info.price_range=' . $price;
        }
        if ($count) {
            return DB::select(DB::raw("SELECT count(DISTINCT hotel_info.id) as total FROM hotel_info " .$joinq." " . $whereq));
        } else {
            $orderq.=" GROUP BY restaurant_info.rest_ID ";
            if ($sort != "") {
                switch ($sort) {
                    case 'name':
                        $orderq.= 'ORDER BY hotel_info.hotel_name ASC';
                        break;
                    case 'latest':
                        $orderq.= 'ORDER BY  hotel_info.createdAt DESC';
                        break;
                    case 'popular':
                        $orderq.= 'ORDER BY  hotel_info.star DESC';
                        break;
                    default:
                        $orderq.=" ORDER BY restaurant_info.rest_Subscription DESC";
                        break;
                }
            }else{
                $orderq.=" ORDER BY restaurant_info.rest_Subscription DESC";
            }
            $mainq="SELECT DISTINCT " . $selectq . " FROM hotel_info " . $joinq . " " . $whereq ." ". $orderq;
            return DB::select($mainq);
    	}
    }


    public static function getHotelRestaurant($hotel=0,$city=0){
        $q='SELECT ri.rest_Name,ri.sufrati_favourite,ri.rest_Name_Ar,ri.rest_RegisDate,ri.rest_Logo,ri.rest_ID, ri.seo_url, getCoverPhoto(ri.rest_ID) as coverphoto  FROM hotel_rest hr JOIN rest_branches rb ON rb.rest_fk_id=hr.rest_id AND rb.city_ID=:cityid JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1  WHERE hr.hotel_id=:hotel LIMIT 0,1';
        $hotel= DB::select(DB::raw($q),array('hotel'=>$hotel,'cityid'=>$city));
        if(count($hotel)>0){
            return $hotel[0];
        }
    }

    public static function getRestaurants($hotel=0,$city=0){
        $q='SELECT DISTINCT ri.rest_ID, ri.rest_Name,ri.sufrati_favourite,ri.rest_Name_Ar,ri.rest_RegisDate,ri.rest_Logo, ri.seo_url, getRestaurantTel(ri.rest_ID) as telephone,getCuisineName(ri.rest_ID,"en") as cuisine , getCuisineName(ri.rest_ID,"ar") as cuisineAr,(SELECT name FROM rest_type WHERE rest_type.id=ri.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=ri.rest_type) as typeAr FROM hotel_rest hr JOIN rest_branches rb ON rb.rest_fk_id=hr.rest_id AND rb.city_ID=:cityid JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1  WHERE hr.hotel_id=:hotel';
        return DB::select(DB::raw($q),array('hotel'=>$hotel,'cityid'=>$city));
    }




}