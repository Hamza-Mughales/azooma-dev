<?php

class MCuisine extends Eloquent {

    protected $table = 'cuisine_list';

    function getAllMaster($country = 0, $status = 0, $limit = 0, $name = "", $sort = "") {
        $this->table = 'master_cuisine';
        $mCuisine = MCuisine::select('*');
        if (!empty($country)) {
            $mCuisine->where('master_cuisine.country', '=', $country);
        }
        if ($status != "") {
            $mCuisine->where('master_cuisine.status', '=', $status);
        }

        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $mCuisine->orderBy('name', 'ASC');
                    break;
                case 'latest':
                    $mCuisine->orderBy('updatedAt', 'DESC');
                    break;
            }
        }

        if ($name != "") {
            $mCuisine->where('master_cuisine.name', 'LIKE', $name . '%');
        }

        if ($limit != "") {
            $lists = $mCuisine->paginate($limit);
        } else {
            $lists = $mCuisine->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getMasterCuisine($id = 0) {
        $this->table = 'master_cuisine';
        return MCuisine::where('id', '=', $id)->first();
    }

    function getAllCuisines($city = 0, $status = 0, $limit = 0, $item = 0, $master = 0, $name = 0,$sort="") {
        $mCuisine = MCuisine::select('*');
        if ($status != 0) {
            $mCuisine->where('cuisine_list.cuisine_Status', '=', 1);
        }
        if ($name != "") {
            $mCuisine->where('cuisine_list.cuisine_Name', 'LIKE', $name . '%');
        }

        if ($item != 0) {
            if ($item == '-1') {
                $mCuisine->where('cuisine_list.master_id', '=', 0);
            } else {
                $mCuisine->where('cuisine_list.master_id', '=', $item);
            }
        }
        if ($master != 0) {
            $mCuisine->where('cuisine_list.master_id', '=', 0);
        }
        
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $mCuisine->orderBy('cuisine_Name', 'ASC');
                    break;
                case 'latest':
                    $mCuisine->orderBy('updatedAt', 'DESC');
                    break;
            }
        }
        
        if ($city != 0) {
            $mCuisine->join('restaurant_cuisine', 'restaurant_cuisine.cuisine_ID', '=', 'cuisine_list.cuisine_ID');
            $mCuisine->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_cuisine.rest_ID')->where('rest_branches.city_ID', '=', $city);
            $mCuisine->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'rest_branches.rest_fk_id');
            if ($status != 0) {
                $mCuisine->where('restaurant_info.rest_Status', '=', 1);
            }
        }

        if ($limit != "") {
            $lists = $mCuisine->paginate($limit);
        } else {
            $lists = $mCuisine->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function addMasterCuisine($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('name')), 'dash', TRUE);
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $cuisines = implode(",", $_POST['tags']);
        $data = array(
            'name' => (Input::get('name')),
            'name_ar' => (Input::get('name_ar')),
            'country' => $country,
            'tags' => $cuisines,
            'status' => $status,
            'image' => $image,
            'url' => $url,
            'description' => (Input::get('description')),
            'description_ar' => (Input::get('description_ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $master_id = DB::table('master_cuisine')->insertGetId($data);
        $txtcuisines = $_POST['tags'];
        if ($txtcuisines != "") {
            foreach ($txtcuisines as $cuisine_id) {
                $tdata = array(
                    'master_id' => $master_id
                );
                DB::table('cuisine_list')->where('cuisine_ID', $cuisine_id)->update($tdata);
            }
        }
        return $master_id;
    }

    function updateMasterCuisine($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('cuisine_Name')), 'dash', TRUE);
        $cuisines = implode(",", $_POST['tags']);
        $data = array(
            'name' => (Input::get('name')),
            'name_ar' => (Input::get('name_ar')),
            'country' => $country,
            'tags' => $cuisines,
            'status' => $status,
            'image' => $image,
            'url' => $url,
            'description' => (Input::get('description')),
            'description_ar' => (Input::get('description_ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('master_cuisine')->where('id', '=', Input::get('id'))->update($data);
        $txtcuisines = $_POST['tags'];
        if ($txtcuisines != "") {
            foreach ($txtcuisines as $cuisine_id) {
                $tdata = array(
                    'master_id' => Input::get('id')
                );
                DB::table('cuisine_list')->where('cuisine_ID', '=', $cuisine_id)->update($tdata);
            }
        }
    }

    function deleteMasterCuisine($id = 0) {
        DB::table('master_cuisine')->where('id', '=', $id)->delete();
    }

    function getCuisine($id = 0) {
        $this->table = "cuisine_list";
        return MCuisine::where('cuisine_ID', '=', $id)->first();
    }

    function addCuisine($image = "",$bannerimage="") {
        $this->table = "cuisine_list";
        $status = 0;
        if (isset($_POST['cuisine_Status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('cuisine_Name')), 'dash', TRUE);
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'cuisine_Name' => (Input::get('cuisine_Name')),
            'cuisine_Name_ar' => (Input::get('cuisine_Name_ar')),
            'cuisine_tags' => (Input::get('cuisine_tags')),
            'cuisine_tags_ar' => (Input::get('cuisine_tags_ar')),
            'master_id' => (Input::get('master_id')),
            'country' => $country,
            'cuisine_Status' => $status,
            'image' => $image,
            'bannerimage'=>$bannerimage,
            'seo_url' => $url,
            'cuisine_description' => (Input::get('cuisine_description')),
            'cuisine_description_ar' => (Input::get('cuisine_description_ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $trtunid = DB::table('cuisine_list')->insertGetId($data);
        $masterCu = $this->getMasterCuisine(Input::get('master_id'));
        $mtags = "";
        if ($masterCu->tags != "") {
            $mtags = $masterCu->tags . ',' . $trtunid;
        } else {
            $mtags = $trtunid;
        }
        $tdata = array(
            'tags' => $mtags
        );
        DB::table('master_cuisine')->where('id', '=', Input::get('master_id'))->update($tdata);
    }

    function updateCuisine($image = "",$bannerimage="") {
        $this->table = "cuisine_list";
        $status = 0;
        if (isset($_POST['cuisine_Status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('cuisine_Name')), 'dash', TRUE);
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'cuisine_Name' => (Input::get('cuisine_Name')),
            'cuisine_Name_ar' => (Input::get('cuisine_Name_ar')),
            'cuisine_tags' => (Input::get('cuisine_tags')),
            'cuisine_tags_ar' => (Input::get('cuisine_tags_ar')),
            'master_id' => (Input::get('master_id')),
            'country' => $country,
            'cuisine_Status' => $status,
            'image' => $image,
            'bannerimage'=>$bannerimage,
            'seo_url' => $url,
            'cuisine_description' => (Input::get('cuisine_description')),
            'cuisine_description_ar' => (Input::get('cuisine_description_ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('cuisine_list')->where('cuisine_ID', '=', Input::get('id'))->update($data);
    }

    function getAllMasterCuisines($status = 0, $limit = 0, $offset = "", $admin = false) {
        $this->table = "master_cuisine";
        $MCuisine = MCuisine::select('*');
        if ($status != 0) {
            $MCuisine->where('master_cuisine.status', 1);
        }
        $MCuisine->orderBy('master_cuisine.name');
        if ($limit != "") {
            $lists = $MCuisine->paginate($limit);
        } else {
            $lists = $MCuisine->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function deleteCuisine($id = 0) {
        DB::table('cuisine_list')->where('cuisine_ID', '=', $id)->delete();
    }

    function getRest($id = 0) {
        return MRestaurant::where('rest_ID', '=', $id)->first();
    }

    function getAllSuggested($city = "", $type = "", $limit = 0, $rest_Name = "", $frontend = FALSE, $district = 0, $cuisine = 0, $bestfor = 0, $feature = 0, $price = 0, $sort = "name") {

        $mRest = MRestaurant::select('*');

        if ($city != "") {
            $mRest->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            $mRest->where('rest_branches.city_ID', '=', $city);
            if ($district != 0) {
                $mRest->where('rest_branches.district_ID', '=', $district);
            }
            $mRest->groupBy('rest_branches.rest_fk_id');
        }

        if ($type != "") {
            $mRest->where('' . $type . '', '=', 1);
        } else {
            $mRest->Where(
                    function($mRest) {
                $mRest->where('breakfast', '=', 1)->orWhere('lunch', '=', 1)->orWhere('dinner', '=', 1)->orWhere('latenight', '=', 1)->orWhere('iftar', '=', 1)->orWhere('suhur', '=', 1);
            });
        }

        if ($cuisine != "") {
            $mRest->join('restaurant_cuisine', 'restaurant_cuisine.rest_ID', '=', 'restaurant_info.rest_ID');
            $mRest->where('restaurant_cuisine.cuisine_ID', '=', $cuisine);
        }

        if ($bestfor != "") {
            $mRest->join('restaurant_bestfor', 'restaurant_bestfor.rest_ID', '=', 'restaurant_info.rest_ID');
            $mRest->where('restaurant_bestfor.bestfor_ID', '=', $bestfor);
        }

        if ($price != "") {
            $mRest->where('restaurant_info.price_range', '=', $price);
        }

        if ($rest_Name != "") {
            $mRest->Where('restaurant_info.rest_Name', 'LIKE', $rest_Name . '%');
        }

        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $mRest->orderBy('restaurant_info.rest_Name', 'DESC');
                    break;
                case 'latest':
                    $mRest->orderBy('restaurant_info.rest_RegisDate', 'DESC');
                    break;
                case 'popular':
                    $mRest->orderBy('restaurant_info.total_view', 'DESC');
                    break;
                case 'favorite':
                    $mRest->where('restaurant_info.sufrati_favourite', '=', 1);
                    $mRest->orderBy('restaurant_info.rest_Name', 'DESC');
                    break;
            }
        }
        $mRest->orderBy('restaurant_info.rest_Subscription', 'DESC');
        if ($limit != "") {
            $lists = $mRest->paginate($limit);
        } else {
            $lists = $mRest->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function suggestedType($id, $type) {
        $check = 1;
        $rest = MRestaurant::where('rest_ID', '=', $id)->first();
        if (count($rest) > 0) {
            $temp = array('breakfast' => $rest->breakfast, 'lunch' => $rest->lunch, 'dinner' => $rest->dinner, 'latenight' => $rest->latenight, 'iftar' => $rest->iftar, 'suhur' => $rest->suhur);
            if ($temp[$type] == 1) {
                $check = 0;
            } else {
                $check = 1;
            }
        }
        $data = array(
            $type => $check
        );
        DB::table('restaurant_info')->where('rest_ID', $id)->update($data);
    }

    function updateFavoriteRest() {
        $data = array(
            'fav_desc' => htmlentities(input::get('fav_desc')),
            'fav_desc_ar' => (input::get('fav_desc_ar'))
        );
        DB::table('restaurant_info')->where('rest_ID', input::get('rest_ID'))->update($data);
    }

    function getAllFavourites($city = "", $limit = 0, $rest_Name = "") {
        $mRest = MRestaurant::select('*');

        //$this->db->distinct();
        //$this->db->select('rest_ID as id, rest_Status as status,rest_Name,rest_Name_Ar,total_view');
        if ($rest_Name != "") {
            $mRest->Where('restaurant_info.rest_Name', 'LIKE', $rest_Name . '%');
        }

        if ($city != "") {
            $mRest->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            $mRest->where('rest_branches.city_ID', '=', $city);
        }

        $mRest->where('restaurant_info.sufrati_favourite', '!=', 0);

        $mRest->orderBy('restaurant_info.rest_Subscription', 'DESC');
        $mRest->orderBy('restaurant_info.sufrati_favourite', 'DESC');
        if ($limit != "") {
            $lists = $mRest->paginate($limit);
        } else {
            $lists = $mRest->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function removeFavorite($id) {
        $data = array(
            'sufrati_favourite' => 0
        );
        DB::table('restaurant_info')->where('rest_ID', $id)->update($data);
    }

    public static function getCuisinesMin() {
        return DB::table('cuisine_list')->select('cuisine_ID', 'cuisine_Name', 'cuisine_Name_ar')->where('cuisine_Status', 1)->get();
    }



    /******* From Fasil *****/

    public static function getTotalRestaurantsFeature($feature="",$cityid=0,$category=""){
        $q="SELECT COUNT(DISTINCT ri.rest_ID) as total FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=:cityid WHERE ri.rest_Status=1 AND rb.status=1 AND ri.openning_manner !='Closed Down'";
        switch ($category) {
           case 'services':
                $q.=" AND rb.features_services LIKE '%".$feature."%'";
                break;
           case 'seatings':
                $q.=" AND rb.seating_rooms LIKE '%".$feature."%'";
                break;
           case 'atmosphere':
                $q.=" AND rb.mood_atmosphere LIKE '%".$feature."%'";
                break;
        }
        $total=DB::select(DB::raw($q),array('cityid'=>$cityid));
        if(count($total)>0){
            return $total[0]->total;
        }
    }

}
