<?php
class MPopular extends Eloquent{


    function getPopularResults($action="",$city = 0, $cuisine = "", $menu = "", $wheelchair = "", $price = "", $sort = "", $limit = "", $offset = "", $latitude = "", $longitude = "", $count = false,$min=false) {
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $where = "WHERE 1=1 ";
        $mainselect=" * ";
        if(!$min){
            $select.=" restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
            if($sort=="recent"){
                $select.=", review.review_Date ";
            }
            $mainselect.=" , getCuisineName(t.id,'en') as cuisine , getCuisineName(t.id,'ar') as cuisineAr,  getCoverPhoto(t.id) as thephoto, getRestaurantTel(t.id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=t.id ) as menu, (SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=t.id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
            $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";

        }else{
            $select.=' DISTINCT restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.seo_url as url ';
        }
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= ' . $city;
        if($wheelchair!=""){
            $where.=" AND rest_branches.features_services LIKE '%Wheel Chair%' ";
        }
        if($sort=="recent"){
            $join.=" JOIN review ON review.rest_ID=restaurant_info.rest_ID AND review.review_Status=1";    
        }
      
        if ($cuisine != "") {
            $join.=' JOIN restaurant_cuisine ON restaurant_cuisine.rest_ID=restaurant_info.rest_ID ';
            $ia = 0;
            foreach ($cuisine as $cue) {
                if(count($cuisine) == 1){
                    $where.=' AND restaurant_cuisine.cuisine_ID IN( ' . $cue. ' ) ';

                }else{
                    if($ia == 0){
                    $where.=' AND restaurant_cuisine.cuisine_ID IN( ' . $cue. ' )';

                    }else{
                        $where.=' OR restaurant_cuisine.cuisine_ID IN( ' . $cue. ' )';

                    }
                }
                $ia++;
            } 
        }
        if ($menu != "") {
            $join.=' JOIN menuall ON menuall.rest_ID=restaurant_info.rest_ID';
        }
        if ($price != "") {
            $where.=' AND restaurant_info.price_range="' . $price.'"';
        }
        $where.=' AND rest_branches.status=1';
        switch($action){
            case 'home-delivery':
                $where.=' AND ( rest_branches.features_services LIKE "%Delivery%" OR restaurant_info.rest_Delivery= 1 ) ';
                break;
            case 'fine-dining':
                $where.=' AND restaurant_info.class_category= "fine dining" ';
                break;
            case 'sheesha':
                $where.=' AND rest_branches.features_services LIKE "%Sheesha%" ';
                break;
            case 'catering':
                $where.=' AND rest_branches.features_services LIKE "%Catering%" ';
                break;
        }
        $orderby.=" GROUP BY restaurant_info.rest_ID ";
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $orderby.= 'ORDER BY  restaurant_info.rest_Name ASC';
                    break;
                case 'latest':
                    $orderby.= 'ORDER BY  restaurant_info.rest_RegisDate DESC';
                    break;
                case 'popular':
                    $orderby.= 'ORDER BY (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) DESC';
                    break;
                case 'recent':
                    $orderby.=' ORDER BY review.review_Date DESC ';
                    break;
                case 'recommended':
                    $where.=' AND restaurant_info.sufrati_favourite>0 ';
                    break;
                default:
                    $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
                    break;
            }
        }else{
            $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC ";
        }

        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT ".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::select($mainq);
        }
    }


    public static function getPopularCuisines($action="",$city = 0, $cuisine = "", $menu = "", $wheelchair = "", $price = "", $latitude = "", $longitude = "",$meals=false,$branchcategory="",$branchfeature=""){
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $where = "WHERE ri.rest_Status=1 ";
        $mainselect="";
        $select.="rc.cuisine_ID,cl.cuisine_Name,cl.cuisine_Name_ar,COUNT(ri.rest_ID) as count ";
        $join.='JOIN restaurant_cuisine rc ON rc.rest_ID=ri.rest_ID ';
        $join.='JOIN cuisine_list cl ON cl.cuisine_ID=rc.cuisine_ID AND cl.cuisine_Status=1';
        $join.=' JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID='.$city;
        if($wheelchair!=""){
            $where.=" AND rb.features_services LIKE '%Wheel Chair%' ";
        }
        if ($menu != "") {
            $join.=' JOIN menuall ON menuall.rest_ID=ri.rest_ID';
        }
        if ($price != "") {
            $where.=' AND ri.price_range="' . $price.'"';
        }
        if($meals){
            $where.=' AND ri.'.$meals.'=1 ';
        }
        switch($action){
            case 'home-delivery':
                $where.=' AND ( rb.features_services LIKE "%Delivery%" OR ri.rest_Delivery= 1 )';
                break;
            case 'fine-dining':
                $where.=' AND ri.class_category= "fine dining" ';
                break;
            case 'sheesha':
                $where.=' AND rb.features_services LIKE "%Sheesha%"';
                break;
            case 'catering':
                $where.=' AND rb.features_services LIKE "%Catering%"';
                break;
        }
        if($branchcategory!=""){
            switch ($branchcategory) {
                case 'services':
                    $where.=" AND rb.features_services LIKE '%".$branchfeature."%'";
                    break;
               case 'seatings':
                    $where.=" AND rb.seating_rooms LIKE '%".$branchfeature."%'";
                    break;
               case 'atmosphere':
                    $where.=" AND rb.mood_atmosphere LIKE '%".$branchfeature."%'";
                    break;
            }
        }
        $mainq="SELECT ".$select." FROM restaurant_info ri ". $join." ".$where.' GROUP BY cl.cuisine_ID ORDER BY cl.cuisine_Name ASC';
        return DB::connection('new-sufrati')->select($mainq);
        
    }

    function getCityCuisine($city = 0, $cuisine = "", $menu = "", $wheelchair = "", $price = "", $sort = "", $limit = "", $offset = "", $latitude = "", $longitude = "", $count = false,$min=false) {
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $where = "WHERE 1=1 ";
        $mainselect=" * ";
        if(!$min){
            $select.=" restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
            $mainselect.=" , getCuisineName(id,'en') as cuisine , getCuisineName(id,'ar') as cuisineAr,  getCoverPhoto(id) as thephoto, getRestaurantTel(id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=id ) as menu, (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
            $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";
        }else{
            $select.=' restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.seo_url as url ';
        }
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID='.$city;
        if($wheelchair!=""){
            $where.=" AND rest_branches.features_services LIKE '%Wheel Chair%' ";
        }
        if ($cuisine != "") {
            $join.=' JOIN restaurant_cuisine ON restaurant_cuisine.rest_ID=restaurant_info.rest_ID ';
            $where.=' AND restaurant_cuisine.cuisine_ID IN( ' . $cuisine . ' ) ';
        }
        if ($menu != "") {
            $join.=' JOIN menuall ON menuall.rest_ID=restaurant_info.rest_ID';
        }
        if ($price != "") {
            $where.=' AND restaurant_info.price_range="' . $price.'"';
        }
        $where.=' AND rest_branches.status=1';
        $orderby.=" GROUP BY restaurant_info.rest_ID ";
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $orderby.= 'ORDER BY  restaurant_info.rest_Name ASC';
                    break;
                case 'latest':
                    $orderby.= 'ORDER BY  restaurant_info.rest_RegisDate DESC';
                    break;
                case 'popular':
                    $orderby.= 'ORDER BY (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) DESC';
                    break;
                case 'recommended':
                    $where.=' AND restaurant_info.sufrati_favourite>0 ';
                default:
                    $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
                    break;
            }
        }else{
            $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
        }
        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::connection('new-sufrati')->select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT ".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::connection('new-sufrati')->select(DB::raw($mainq)); 
        }
    }

    public static function getCityDistricts($city = 0, $district = 0, $menu = "", $wheelchair = "", $price = "", $sort = "", $limit = "", $offset = "", $latitude = "", $longitude = "", $count = false,$min=false){
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $where = "WHERE 1=1 ";
        $mainselect=" * ";
        if(!$min){
            $select.=" restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
            $mainselect.=" , getCuisineName(id,'en') as cuisine , getCuisineName(id,'ar') as cuisineAr,  getCoverPhoto(id) as thephoto, getRestaurantTel(id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=id ) as menu, (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
            $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";
        }else{
            $select.=' restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.seo_url as url ';
        }
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID='.$city;
        if($wheelchair!=""){
            $where.=" AND rest_branches.features_services LIKE '%Wheel Chair%' ";
        }
        if ($district != 0) {
            $where.=' AND rest_branches.district_ID IN( ' . $district . ' ) ';
        }
        if ($menu != "") {
            $join.=' JOIN menuall ON menuall.rest_ID=restaurant_info.rest_ID';
        }
        if ($price != "") {
            $where.=' AND restaurant_info.price_range="' . $price.'"';
        }
        $where.=' AND rest_branches.status=1';
        $orderby.=" GROUP BY restaurant_info.rest_ID ";
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $orderby.= 'ORDER BY  restaurant_info.rest_Name ASC';
                    break;
                case 'latest':
                    $orderby.= 'ORDER BY  restaurant_info.rest_RegisDate DESC';
                    break;
                case 'popular':
                    $orderby.= 'ORDER BY (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) DESC';
                    break;
                case 'recommended':
                    $where.=' AND restaurant_info.sufrati_favourite>0 ';
                default:
                    $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
                    break;
            }
        }else{
            $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
        }
        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::connection('new-sufrati')->select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT ".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::connection('new-sufrati')->select(DB::raw($mainq)); 
        }
    }

    public static function getSearchResults($city=0,$cuisine=0,$category="", $menu=0,$wheelchair=0, $price=0,$sort="", $limit=20,$offset=0, $latitude=0, $longitude=0, $count=true,$min=false,$meals=false){
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $where = "WHERE 1=1 ";
        $mainselect=" * ";
        if(!$min){
            $select.=" restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
            if($sort=="recent"){
                $select.=", review.review_Date ";
            }
            $mainselect.=" , getCuisineName(t.id,'en') as cuisine , getCuisineName(t.id,'ar') as cuisineAr,  getCoverPhoto(t.id) as thephoto, getRestaurantTel(t.id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=t.id ) as menu, (SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=t.id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
            $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";
        }else{
            $select.=' DISTINCT restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.seo_url as url ';
        }
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= ' . $city;
        if($wheelchair!=""){
            $where.=" AND rest_branches.features_services LIKE '%Wheel Chair%' ";
        }
        if ($cuisine != "") {
            $join.=' JOIN restaurant_cuisine ON restaurant_cuisine.rest_ID=restaurant_info.rest_ID ';
            $where.=' AND restaurant_cuisine.cuisine_ID IN( ' . $cuisine . ' ) ';
        }
        if ($menu != "") {
            $join.=' JOIN menuall ON menuall.rest_ID=restaurant_info.rest_ID';
        }
        if ($category != "") {
            $where.=' AND restaurant_info.class_category="'.$category.'"';
        }
        if ($price != "") {
            $where.=' AND restaurant_info.price_range="' . $price.'"';
        }
        if($meals){
            $where.=' AND restaurant_info.'.$meals.'=1 ';
        }
        $where.=' AND rest_branches.status=1';
        $orderby.=" GROUP BY restaurant_info.rest_ID ";
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $orderby.= 'ORDER BY  restaurant_info.rest_Name ASC';
                    break;
                case 'latest':
                    $orderby.= 'ORDER BY  restaurant_info.rest_RegisDate DESC';
                    break;
                case 'popular':
                    $orderby.= 'ORDER BY (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) DESC';
                    break;
                default:
                    $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
                    break;
            }
        }else{
            $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC ";
        }

        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT ".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::select($mainq);
        }
    }


    public static function getMenu($city=0,$cuisine="",$wheelchair="", $price="",$sort="", $limit=20,$offset=0, $latitude="", $longitude="", $count=false,$min=false){
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $where = "WHERE 1=1 ";
        $mainselect=" * ";
        if(!$min){
            $select.=" restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
            if($sort=="recent"){
                $select.=", review.review_Date ";
            }
            $mainselect.=" , getCuisineName(t.id,'en') as cuisine , getCuisineName(t.id,'ar') as cuisineAr,  getCoverPhoto(t.id) as thephoto, getRestaurantTel(t.id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=t.id ) as menu, (SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=t.id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
            $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";
        }else{
            $select.=' DISTINCT restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.seo_url as url ';
        }
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= ' . $city;
        if($wheelchair!=""){
            $where.=" AND rest_branches.features_services LIKE '%Wheel Chair%' ";
        }
        if($sort=="recent"){
            $join.=" JOIN review ON review.rest_ID=restaurant_info.rest_ID AND review.review_Status=1";    
        }
        if ($cuisine != "") {
            $join.=' JOIN restaurant_cuisine ON restaurant_cuisine.rest_ID=restaurant_info.rest_ID ';
            $where.=' AND restaurant_cuisine.cuisine_ID IN( ' . $cuisine . ' ) ';
        }
        $join.=' JOIN menuall ON menuall.rest_ID=restaurant_info.rest_ID';
        if ($price != "") {
            $where.=' AND restaurant_info.price_range="' . $price.'"';
        }
        $where.=' AND rest_branches.status=1';
        $orderby.=" GROUP BY restaurant_info.rest_ID ";
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $orderby.= 'ORDER BY  restaurant_info.rest_Name ASC';
                    break;
                case 'latest':
                    $orderby.= 'ORDER BY  restaurant_info.rest_RegisDate DESC';
                    break;
                case 'popular':
                    $orderby.= 'ORDER BY (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) DESC';
                    break;
                case 'recent':
                    $orderby.=' ORDER BY review.review_Date DESC ';
                    break;
                case 'recommended':
                    $where.=' AND restaurant_info.sufrati_favourite>0 ';
                    break;
                default:
                    $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
                    break;
            }
        }else{
            $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC ";
        }
        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT ".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::select($mainq);
        }
    }


    public static function getNonRatedRestaurants($city=0,$userid=0,$cuisine=0,$category='', $menu='',$wheelchair='', $price='',$limit=20,$offset=0,$count=false){
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $select.=" restaurant_info.rest_ID AS id, restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
        $mainselect.=" getCuisineName(t.id,'en') as cuisine , getCuisineName(t.id,'ar') as cuisineAr,  getCoverPhoto(t.id) as thephoto, getRestaurantTel(t.id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=t.id ) as menu, (SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=t.id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
        $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= ' . $city;
        if($userid!=0){
            $join.=' LEFT OUTER JOIN rating_info rti ON rti.user_ID='.$userid.' AND rti.rest_ID IS NULL ';
        }
        $orderby.=" GROUP BY restaurant_info.rest_ID ";
        $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT *,".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::select($mainq);
        }
    }


    public static function getNearByRestaurant($city=0,$latitude=0,$longitude=0,$cuisine=0,$category='', $menu='',$wheelchair='', $price='',$limit=20,$offset=0,$count=false){
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $select.=" restaurant_info.rest_ID AS id,rest_branches.br_id as branch, rest_branches.br_loc as location, rest_branches.br_loc_ar as locationAr,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
        $select.=", (SELECT district_list.district_Name FROM district_list WHERE district_ID=rest_branches.district_ID) as district,(SELECT district_list.district_Name_ar FROM district_list WHERE district_ID=rest_branches.district_ID) as districtAr";
        $mainselect.=" getCuisineName(t.id,'en') as cuisine , getCuisineName(t.id,'ar') as cuisineAr,  getCoverPhoto(t.id) as thephoto, getRestaurantTel(t.id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=t.id ) as menu, (SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=t.id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
        $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= ' . $city;
        if($count){
            $where.=" AND rest_branches.latitude!='' AND rest_branches.longitude!='' ";
        }else{
            // $sql1 = "set @origlat = ".$latitude;
            // $sql2 = "set @origlong = ".$longitude;
            $select.=", ((ACOS(SIN(".$latitude." * PI() / 180) * SIN(rest_branches.latitude * PI() / 180) + COS(".$latitude." * PI() / 180) * COS(rest_branches.latitude * PI() / 180) * COS((".$longitude." - rest_branches.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515*1.609344) as distance ";
            // DB::select($sql1);
            // DB::select($sql2);
            $where.=" AND ((ACOS(SIN(".$latitude." * PI() / 180) * SIN(rest_branches.latitude * PI() / 180) + COS(".$latitude." * PI() / 180) * COS(rest_branches.latitude * PI() / 180) * COS((".$longitude."  - rest_branches.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515*1.609344)< 10";
        }

        //$orderby.=" GROUP BY restaurant_info.rest_ID ";
        $orderby.=" ORDER BY distance ASC";
        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND rest_branches.status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT *,".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::select($mainq);
        }
    }


    public static function getRestaurantFeatures($city=0,$cuisine=0, $menu=0,$wheelchair=0, $price=0,$sort="", $limit=20,$offset=0, $latitude=0, $longitude=0, $count=true,$min=false,$category="",$feature=""){
        $mainselect=$select=$where=$join=$orderby=$groupby=$limitq="";
        $where = "WHERE 1=1 ";
        $mainselect=" * ";
        if(!$min){
            $select.=" restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,';',week_days_close,';',week_ends_start,';',week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr ";
            if($sort=="recent"){
                $select.=", review.review_Date ";
            }
            $mainselect.=" , getCuisineName(t.id,'en') as cuisine , getCuisineName(t.id,'ar') as cuisineAr,  getCoverPhoto(t.id) as thephoto, getRestaurantTel(t.id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=t.id ) as menu, (SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=t.id AND likee_info.status=1 AND comment_id IS NULL) as `like` ";
            $mainselect.=" , (SELECT COUNT(br_id) FROM rest_branches WHERE rest_branches.rest_fk_id=t.id AND rest_branches.status=1 AND rest_branches.city_ID=".$city.") as branches ";
        }else{
            $select.=' DISTINCT restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.seo_url as url ';
        }
        $join.=' JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= ' . $city;
        if($wheelchair!=""){
            $where.=" AND rest_branches.features_services LIKE '%Wheel Chair%' ";
        }
        if ($cuisine != "") {
            $join.=' JOIN restaurant_cuisine ON restaurant_cuisine.rest_ID=restaurant_info.rest_ID ';
            $where.=' AND restaurant_cuisine.cuisine_ID IN( ' . $cuisine . ' ) ';
        }
        if ($menu != "") {
            $join.=' JOIN menuall ON menuall.rest_ID=restaurant_info.rest_ID';
        }
        if ($price != "") {
            $where.=' AND restaurant_info.price_range="' . $price.'"';
        }
        if($category!=""){
            switch ($category) {
                case 'services':
                    $where.=" AND rest_branches.features_services LIKE '%".$feature."%'";
                    break;
               case 'seatings':
                    $where.=" AND rest_branches.seating_rooms LIKE '%".$feature."%'";
                    break;
               case 'atmosphere':
                    $where.=" AND rest_branches.mood_atmosphere LIKE '%".$feature."%'";
                    break;
            }
        }
        $where.=' AND rest_branches.status=1';
        $orderby.=" GROUP BY restaurant_info.rest_ID ";
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $orderby.= 'ORDER BY  restaurant_info.rest_Name ASC';
                    break;
                case 'latest':
                    $orderby.= 'ORDER BY  restaurant_info.rest_RegisDate DESC';
                    break;
                case 'popular':
                    $orderby.= 'ORDER BY (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) DESC';
                    break;
                default:
                    $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC";
                    break;
            }
        }else{
            $orderby.=" ORDER BY restaurant_info.rest_Subscription DESC ";
        }

        if (!$count) {
            if ($limit != "") {
                $limitq = " LIMIT " . $offset . " , " . $limit;
            }
        }
        $where.=' AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down"';
        if($count){
            return DB::select(DB::raw(" SELECT COUNT(DISTINCT restaurant_info.rest_ID) as total  FROM restaurant_info ". $join ." ". $where));
        }else{
            $mainq="SELECT ".$mainselect." FROM (SELECT ".$select." FROM restaurant_info". $join." ".$where." ". $orderby." ".$limitq." ) t";
            return DB::select($mainq);
        }
    }



    /*****

    DELIMITER $$

    USE `sufrati_db`$$
    DROP FUNCTION IF EXISTS `getCoverPhoto`$$

    CREATE DEFINER=`root`@`localhost` FUNCTION `getCoverPhoto`( restID INT) RETURNS TEXT CHARSET utf8 COLLATE utf8_unicode_ci
        DETERMINISTIC
    BEGIN
        DECLARE total FLOAT DEFAULT 0;
        DECLARE txtreturn TEXT; 
        
        SET total = (SELECT COUNT(*) AS total FROM image_gallery WHERE rest_ID=restID AND is_featured=1);
        IF(total!=0) THEN
           SET txtreturn = (SELECT image_full FROM image_gallery WHERE rest_ID=restID AND status=1 AND is_featured=1 ORDER BY enter_time DESC LIMIT 1);
     ELSE
           SET txtreturn = (SELECT image_full FROM image_gallery WHERE rest_ID=restID AND status=1 ORDER BY WIDTH DESC LIMIT 1);
     END IF;
        RETURN txtreturn;
        END$$
    DELIMITER ;
    ****/


    /*****

    DELIMITER $$

    USE `sufrati_db`$$
    DROP FUNCTION IF EXISTS `getRestaurantTel`$$

    CREATE DEFINER=`root`@`localhost` FUNCTION `getRestaurantTel`( restID INT) RETURNS TEXT CHARSET utf8 COLLATE utf8_unicode_ci
        DETERMINISTIC
    BEGIN
        DECLARE txtreturn TEXT; 
        DECLARE tollfree varchar(20); 
        DECLARE mobile varchar(20);
        DECLARE telephone varchar(20);
        DECLARE branchtotal FLOAT DEFAULT 0;
        DECLARE branchtollfree varchar(20); 
        DECLARE branchmobile varchar(20);
        DECLARE branchtelephone varchar(20);
        SELECT rest_TollFree,rest_Mobile,rest_Telephone INTO tollFree, mobile, telephone FROM restaurant_info WHERE rest_ID=restID ;
        IF(tollfree!='' AND tollfree !="N/A") THEN
            SET txtreturn = tollfree;
        ELSE
            IF(telephone!="" AND telephone != 'N/A') THEN
                SET txtreturn = telephone;
            ELSE
                IF(mobile!="" AND mobile != 'N/A') THEN
                    SET txtreturn = mobile;
                ELSE
                    SET branchtotal=(SELECT COUNT(*) FROM rest_branches WHERE rest_fk_id=restID AND status=1);
                    IF(branchtotal=1) THEN
                        SELECT br_number, br_mobile,br_toll_free INTO branchtelephone,branchmobile,branchtollfree FROM rest_branches WHERE rest_fk_id=restID AND status=1;
                        IF(LENGTH(branchtelephone)>7) THEN
                            SET txtreturn = branchtelephone;
                        ELSE
                            IF(branchmobile!='' AND branchmobile !="N/A") THEN
                                SET txtreturn = branchmobile;
                            ELSE
                                IF(branchtelephone!='' AND branchtelephone != "N/A") THEN
                                    SET txtreturn = branchtelephone;
                                ELSE 
                                    SET txtreturn = telephone;
                                END IF;
                            END IF;
                        END IF;
                    ELSE
                        SET txtreturn = telephone;
                    END IF;
                END IF;
            END IF;
        END IF;
        IF(LENGTH(txtreturn)>6) THEN
            RETURN txtreturn;
        ELSE
            RETURN '';
        END IF;
        END$$
    DELIMITER ;
    ****/




    /****


SELECT *, getCuisineName(id,"ar") as cuisineAr,  getCoverPhoto(id) as thephoto, getRestaurantTel(id) as telephone, (SELECT COUNT(rest_ID) FROM menuall WHERE menuall.rest_ID=id ) as menu, (SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=id AND likee_info.status=1 AND comment_id IS NULL) as `like`
FROM (SELECT DISTINCT restaurant_info.rest_ID AS id,restaurant_info.rest_Name name,restaurant_info.rest_Name_Ar as nameAr,restaurant_info.price_range as price,restaurant_info.class_category,restaurant_info.rest_RegisDate as regisDate,restaurant_info.rest_Logo as logo,restaurant_info.seo_url as url,restaurant_info.sufrati_favourite,restaurant_info.rest_Subscription, rest_branches.latitude, rest_branches.longitude,(SELECT CONCAT(week_days_start,";",week_days_close,";",week_ends_start,";",week_ends_close) FROM open_hours WHERE rest_ID=restaurant_info.rest_ID LIMIT 1) as opening, (SELECT name FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as type, (SELECT nameAr FROM rest_type WHERE rest_type.id=restaurant_info.rest_type) as typeAr  FROM restaurant_info JOIN rest_branches ON rest_branches.rest_fk_id=restaurant_info.rest_ID WHERE 1=1 AND restaurant_info.class_category="Quick Service" AND restaurant_info.rest_Status=1 AND restaurant_info.openning_manner !="Closed Down" GROUP BY restaurant_info.rest_ID ORDER BY restaurant_info.rest_Subscription DESC LIMIT 0 , 20) t
    ****/
}
