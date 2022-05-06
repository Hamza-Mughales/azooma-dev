<?php

class MGeneral extends Eloquent{

	public static function getAllCity($status = 0) {
        $MCity = MCity::orderBy('city_Name', 'DESC');
        if ($status == 1) {
            $MCity = MCity::where('city_Status', '=', 1);
        }
        $result_Array = $MCity->get();
        if (count($result_Array) > 0) {
            return $result_Array;
        }
    }


    public static function city_list($status = 0, $id = "city_ID", $class = "", $allCity = 0) {
        $cities = $this->getAllCity($status);
        $html = "";
        if (count($cities) > 0) {
            $html.= '<select name="city" id="' . $id . '" class="' . $class . '">';
            $html.='<option value="">Select City</option>';
            if ($allCity != 0) {
                $html.='<option value="0">All City</option>';
            }
            foreach ($cities as $city) {
                $html.='<option value="' . $city['city_ID'] . '">' . $city['city_Name'] . '</option>';
            }
            $html.="</select>";
        }
        return $html;
    }


    public static function checkPermissions($activity = "") {
        if (Session::has('adminid')) {
            $adminid = Session::get('adminid');
            $results = DB::select('select * from admin where id = ' . $adminid);
            $adminType = 0;
            $userpermission = "";
            if (isset($results[0])) {
                $results = $results[0];
                $adminType = $results->admin;
                $userpermission = explode(",", $results->permissions);
            }
            if ($adminType == 3) {
                return TRUE;
            } elseif (!empty($userpermission)) {
                $res = DB::select('select * from permission_info where permissionText = "' . $activity . '"');
                $permission = "";
                if (isset($res[0])) {
                    $permission = $res[0];
                    if (in_array($permission->id, $userpermission)) {
                        return true;
                    }
                }
            }
        } else {
            return FALSE;
        }
    }

    function getAllRests($status = 0) {
        $this->table = "restaurant_info";
        $MRestaurant_info = MGeneral::select('*');
        if ($status == 1) {
            $MRestaurant_info->where('rest_Status', '=', 1);
        }
        $MRestaurant_info->orderBy('rest_Subscription', 'DESC');
        $lists = $MRestaurant_info->get();

        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    public function getAllArtwork($country = 0, $type = 'Logo', $status = "", $limit = 0, $name = "", $sort = "", $city_ID = "") {
        $this->table = "art_work";
        $Martwork = MGeneral::select('*');
        $Martwork->where('art_work_name', '=', ucfirst($type));
        if (!empty($country)) {
            $Martwork->where('country', '=', $country);
        }
        if ($status != "") {
            $Martwork->where('active', '=', $status);
        }

        if (!empty($sort)) {
            switch ($sort) {
                case "latest":
                    $Martwork->orderBy('createdAt', 'DESC');
                    break;
                case "name":
                    $Martwork->orderBy('a_title', 'DESC');
                    break;
            }
        } else {
            $Martwork->orderBy('createdAt', 'DESC');
        }

        if (!empty($city_ID)) {
            $Martwork->where('city_ID', '=', $city_ID);
        }

        if ($name != "") {
            $Martwork->where('a_title', 'LIKE', $name . '%');
        }

        if ($limit != "") {
            $lists = $Martwork->paginate($limit);
        } else {
            $lists = $Martwork->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getArtwork($id, $status = 0) {
        $this->table = "art_work";
        $Mart_work = MGeneral::select('*');
        if ($status == 1) {
            $Mart_work->where('status', '=', 1);
        }
        $Mart_work->where('id', '=', $id);
        return $Mart_work->first();
    }

    function getAllBcategories($status = 0, $limit = 0, $name = "") {
        $this->table = "businesscategories";
        $MBcategories = MGeneral::select('*');
        if ($status == 1) {
            $MBcategories->where('status', '=', 1);
        }
        if ($name != "") {
            $MBcategories->where('name', 'LIKE', $name . '%');
        }
        $MBcategories->orderBy('name', 'DESC');
        if ($limit != "") {
            $lists = $MBcategories->paginate($limit);
        } else {
            $lists = $MBcategories->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getBcategory($id) {
        $this->table = "businesscategories";
        $MRestStyle = MGeneral::select('*');
        $MRestStyle->where('id', '=', $id);
        return $MRestStyle->first();
    }

    function addBcategory() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'status' => $status
        );
        return $id = DB::table('businesscategories')->insertGetId($data);
    }

    function updateBcategory() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'updated_At' => date('Y-m-d'),
            'status' => $status
        );
        DB::table('businesscategories')->where('id', Input::get('id'))->update($data);
    }

    function deleteBcategory($id) {
        DB::table('businesscategories')->where('id', $id)->delete();
    }

    function getAllSubBcategories($pid = 0, $status = 0, $limit = 0, $name = "") {
        $this->table = "businesssubcategories";
        $MBcategories = MGeneral::select('*');
        $MBcategories->where('parent_id', '=', $pid);
        if ($status == 1) {
            $MBcategories->where('status', '=', 1);
        }
        if ($name != "") {
            $MBcategories->where('name', 'LIKE', $name . '%');
        }
        $MBcategories->orderBy('name', 'DESC');
        if ($limit != "") {
            $lists = $MBcategories->paginate($limit);
        } else {
            $lists = $MBcategories->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getSubBcategory($id) {
        $this->table = "businesssubcategories";
        $MSubBCat = MGeneral::select('*');
        $MSubBCat->where('id', '=', $id);
        return $MSubBCat->first();
    }

    function addSubBcategory() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'parent_id' => (Input::get('parent_id')),
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'status' => $status
        );
        return $id = DB::table('businesssubcategories')->insertGetId($data);
    }

    function updateSubBcategory() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'parent_id' => (Input::get('parent_id')),
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'updated_At' => date('Y-m-d'),
            'status' => $status
        );
        DB::table('businesssubcategories')->where('id', Input::get('id'))->update($data);
    }

    function deleteSubBcategory($id) {
        DB::table('businesssubcategories')->where('id', $id)->delete();
    }

    function getAllRestServices($city = 0, $status = 0, $limit = 0, $name = "") {
        //$this->table = "features_services";
        $MrestServices = DB::table('features_services');
        if ($status != 0) {
            $MrestServices->where('features_services.status', '=', 1);
        }
        if ($city != 0) {
            $MrestServices->join('restaurant_bestfor', 'restaurant_bestfor.bestfor_ID', '=', 'bestfor_list.bestfor_ID');
            $MrestServices->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_bestfor.rest_ID')->where('AND rest_branches.city_ID', '=', $city);
            $MrestServices->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'rest_branches.rest_fk_id');
            $MrestServices->where('restaurant_info.rest_Status', '=', 1);
            $MrestServices->group_by('bestfor_list.bestfor_ID');
        }
        $MrestServices->orderBy('features_services.name');

        if ($name != "") {
            $MrestServices->where('features_services.name', 'LIKE', $name . '%');
        }
        if ($limit != "") {
            $lists = $MrestServices->paginate($limit);
        } else {
            $lists = $MrestServices->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getRestService($id) {
        $this->table = "features_services";
        $MRestServices = MGeneral::select('*');
        $MRestServices->where('id', '=', $id);
        return $MRestServices->first();
    }

    function addRestServices($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'status' => $status,
            'seo_url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return $qid = DB::table('features_services')->insertGetId($data);
    }

    function updateRestServices($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'status' => $status,
            'seo_url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('features_services')->where('id', '=', Input::get('id'))->update($data);
    }

    function deleteRestService($id) {
        DB::table('features_services')->where('id', '=', $id)->delete();
    }

    function callback_month($month) {
        return date('F', mktime(0, 0, 0, $month, 1));
    }

    function convertToArabic($var) {
        $digit = (string) $var;
        if (empty($digit))
            return ' ';
        $ar_digit = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '-' => '-', ' ' => ' ', '.' => '.');
        $arabic_digit = '';
        $length = strlen($digit);
        for ($i = 0; $i < $length; $i++) {
            if (isset($ar_digit[$digit[$i]]))
                $arabic_digit .= $ar_digit[$digit[$i]];
            else
                $arabic_digit .=$digit[$i];
        }
        return $arabic_digit;
    }

    public function generate_options($from, $to, $callback = false, $lang = 'en', $selected = "") {
        $reverse = false;
        if ($from > $to) {
            $tmp = $from;
            $from = $to;
            $to = $tmp;
            $reverse = true;
        }
        $return_string = array();
        for ($i = $from; $i <= $to; $i++) {
            if ($lang == "en") {
                $string = '<option value="' . $i . '"';
                if (($selected != "") && ($selected == $i)) {
                    $string.=' selected="selected"';
                }
                $string.='>' . ($callback ? $this->callback_month($i) : $i) . '</option>';
                $return_string[] = $string;
            } else {
                if ($callback) {
                    $return_string[] = '
                        <option value="' . $i . '">' . $this->convertToArabic($i) . '</option>';
                } else {
                    $return_string[] = '
                        <option value="' . $i . '">' . $this->convertToArabic($i) . '</option>';
                }
            }
        }
        if ($reverse) {
            $return_string = array_reverse($return_string);
        }
        return join('', $return_string);
    }

    public function generateSelect($cats, $name, $required, $iselected = "", $onCallFunc = "", $row_name = "name", $row_ID = "id", $multiple = '') {
        $html = "";
        $html = '<select ' . $multiple . ' name="' . $name . '" class="form-control ' . $required . '" id="' . $name . '" onchange=' . $onCallFunc . ' >';
        $selected_arr = explode(",", $iselected);
        if (is_object($cats)) {
            foreach ($cats AS $cat) {
                $selected = "";
                if (!empty($iselected) && in_array($cat->$row_ID, $selected_arr)) {
                    $selected = "selected";
                }
                $html.='<option  ' . $selected . ' value="' . $cat->$row_ID . '">' . $cat->$row_name . '</option>';
            }
        }

        return $html;
    }

    function getAllAdminCountries() {
        $this->table = "aaa_country";
        $mcountry = MGeneral::select('*');
        $mcountry->orderBy('name', 'asc');
        $lists = $mcountry->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    public function getAdminCountryName($id, $lang = 'en') {
        $this->table = "aaa_country";
        $mcountry = MGeneral::select('*');
        $mcountry->where('id', '=', $id);
        $country = $mcountry->first();
        if ($lang = 'en') {
            return $country->name;
        } else {
            return $country->nameAr;
        }
    }

    public function getAdminCountryByName($name = "") {
        $this->table = "aaa_country";
        $MCITY = MGeneral::select('*');
        if ($name != "") {
            $MCITY->where('name', 'LIKE', $name . '%');
        }
        return $MCITY->first();
    }

    public function getEmailListingReceivers() {
        $arr = array(
            '0' => 'Test Email',
            '1' => 'All Users',
            '2' => 'All Paid Restaurants Members',
            '3' => 'All Restaurants Members',
            '4' => 'All Restaurants',
            '5' => 'All Non Restaurants Members',
            '6' => 'All Hotels',
            '7' => 'All Subscribers'
        );
        return $arr;
    }

    public function visitor_country() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];
        $result = "Unknown";
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        if ($ip == "127.0.0.1" || $ip == "::1") {
            $ip = '188.53.4.127';
        }
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

        if ($ip_data && $ip_data->geoplugin_countryName != null) {
            $result = $ip_data->geoplugin_countryName;
        }

        return $result;
    }

    public function getRestaurantName($rest_ID, $lang = 'en') {
        $name = '';
        if ($lang == 'en') {
            $name = DB::table('restaurant_info')->where('rest_ID', $rest_ID)->pluck('rest_Name');
        } else {
            $name = DB::table('restaurant_info')->where('rest_ID', $rest_ID)->pluck('rest_Name_Ar');
        }

        return $name;
    }

    public function getUser($user_ID) {
        $result = '';
        $result = DB::table('user')->where('user_ID', $user_ID)->first();
        return $result;
    }

    function getRestaurantCities($rest = 0, $limit = "", $name = 0, $lang = "en") {
        $query = DB::table('rest_branches');
        if ($name == 0) {
            $query->select('city_list.*');
        } else {
            $query->select('city_list.city_Name', 'city_list.city_Name_Ar');
        }
        $query->where('rest_branches.rest_fk_id', $rest);
        $query->join('city_list', 'city_list.city_ID', '=', 'rest_branches.city_ID');
        $query->where('city_list.city_Status', '=', '1');
        $query->orderBy('city_list.city_Name', 'DESC');
        if ($limit != "") {
            $lists = $query->paginate($limit);
        } else {
            $lists = $query->paginate();
        }
        if (count($lists) > 0) {
            if ($name == 0) {
                return $lists;
            } else {
                $city = "";
                $i = 0;
                foreach ($lists as $row) {
                    $i++;
                    if ($lang == "en") {
                        $city.=substr($row->city_Name, 0, 6);
                    } else {
                        $city.=$row->city_Name_Ar;
                    }
                    if ($i != $lists->getTotal()) {
                        $city.=", ";
                    }
                }
                return $city;
            }
        }
        return '-';
    }

    function getRestaurantCuisines($rest = 0, $limit = "", $name = 0, $lang = "en") {
        $query = DB::table('restaurant_cuisine');
        if ($name == 0) {
            $query->select('cuisine_list.*');
        } else {
            $query->select('cuisine_list.cuisine_Name', 'cuisine_list.cuisine_Name_Ar', 'cuisine_list.master_id');
        }
        $query->where('restaurant_cuisine.rest_ID', '=', $rest);
        $query->join('cuisine_list', 'cuisine_list.cuisine_ID', '=', 'restaurant_cuisine.cuisine_ID');
        $query->where('cuisine_list.cuisine_Status', '=', 1);
        $query->orderBy('cuisine_list.cuisine_Name', 'DESC');
        if ($limit != "") {
            $lists = $query->paginate($limit);
        } else {
            $lists = $query->get();
        }
        if (count($lists) > 0) {
            if ($name == 0) {
                return $lists;
            } else {
                $cuisine = "";
                $i = 0;
                foreach ($lists as $row) {
                    $i++;
                    if ($lang == "en") {
                        $cuisine.=$row->cuisine_Name;
                    } else {
                        $cuisine.=$row->cuisine_Name_Ar;
                    }
                    if ($i != $lists->getTotal()) {
                        $cuisine.=", ";
                    }
                }
                return $cuisine;
            }
        }
        return '-';
    }

    public static function getAllBestFor($status = 0, $city = 0) {
        $query = "";
        $query = DB::table('bestfor_list');
        if ($status == 1) {
            $query->where('bestfor_Status', 1);
        }
        if ($city != 0) {
            $query->join('restaurant_bestfor', 'restaurant_bestfor.bestfor_ID', '=', 'bestfor_list.bestfor_ID');
            $query->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_bestfor.rest_ID');
            $query->where('rest_branches.city_ID', '=', $city);
            $query->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'rest_branches.rest_fk_id');
            $query->where('restaurant_info.rest_Status', 1);
            $query->groupBy('bestfor_list.bestfor_ID');
        }
        $query->orderBy('bestfor_Name');
        $lists = $query->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    public static function getAllCuisine($status = 0, $city = 0) {
        $query = "";
        $query = DB::table('cuisine_list')->select(
                array(
                    'cuisine_list.cuisine_Name',
                    'cuisine_list.cuisine_Name_ar',
                    'cuisine_list.seo_url',
                    'cuisine_list.cuisine_ID',
                    'cuisine_list.master_id'
                )
        );
        if ($status == 1) {
            $query->where('cuisine_Status', 1);
        }
        if ($city != 0) {
            $query->join('restaurant_cuisine', 'restaurant_cuisine.cuisine_ID', '=', 'cuisine_list.cuisine_ID');
            $query->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_cuisine.rest_ID');
            $query->where('rest_branches.city_ID', '=', $city);
            $query->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'rest_branches.rest_fk_id');
            $query->where('restaurant_info.rest_Status', '=', 1);
            $query->groupBy('cuisine_list.cuisine_ID');
        }
        $query->orderBy('cuisine_Name');
        $lists = $query->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    public static function getAllMasterCuisine($status = 0, $limit = 0, $offset = "") {
        $query = "";
        $query = DB::table('master_cuisine');
        if ($status != 0) {
            $query->where('master_cuisine.status', 1);
        }
        $query->orderBy('master_cuisine.name');
        if ($limit != 0) {
            $lists = $query->paginate($limit);
        } else {
            $lists = $query->paginate();
        }
        $lists = $query->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getRestaurantBestFors($rest = 0, $limit = "", $name = 0, $lang = "en") {
        $query = DB::table('restaurant_bestfor');
        if ($name == 0) {
            $query->select('bestfor_list.*');
        } else {
            $query->select('bestfor_list.bestfor_Name', 'bestfor_list.bestfor_Name_Ar');
        }
        $query->where('restaurant_bestfor.rest_ID', $rest);
        $query->join('bestfor_list', 'bestfor_list.bestfor_ID', '=', 'restaurant_bestfor.bestfor_ID');
        $query->where('bestfor_list.bestfor_Status', '=', 1);
        $query->orderBy('bestfor_list.bestfor_Name', 'DESC');
        if ($limit != "") {
            $lists = $query->paginate($limit);
        } else {
            $lists = $query->get();
        }
        if (count($lists) > 0) {
            if ($name == 0) {
                return $lists;
            } else {
                $bestfor = "";
                $i = 0;
                foreach ($lists as $row) {
                    $i++;
                    if ($lang == "en") {
                        $bestfor.=$row->bestfor_Name;
                    } else {
                        $bestfor.=$row->bestfor_Name_Ar;
                    }
                    if ($i != $q->num_rows()) {
                        $bestfor.=", ";
                    }
                }
                return $bestfor;
            }
        }
        return '';
    }

    public static function getAllCities($country = 0, $limit = "", $lang = "en") {
        $query = DB::table('city_list');
        $query->select('city_list.*');
        if (!empty($country)) {
            $query->where('country', '=', $country);
        }
        $query->orderBy('city_list.city_Name', 'ASC');
        if ($limit != "") {
            $lists = $query->paginate($limit);
        } else {
            $lists = $query->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return '';
    }

    function getAllHotels($status = 0) {
        $mhotel_info = DB::table('hotel_info');
        if ($status != 0) {
            $mhotel_info->where('status', 1);
        }
        $lists = $mhotel_info->paginate();
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    public static function getCityDistricts($city = 0, $status = "") {
        $MCityDist = DB::table('district_list');
        if ($city != 0) {
            $MCityDist->where('city_ID', $city);
        }
        if ($status != "") {
            $MCityDist->where('district_Status', $status);
        }
        $MCityDist->orderBy('district_Name', 'ASC');
        $lists = $MCityDist->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return '';
    }

    function getMemberDeatilsLog($rest_ID) {
        $lists = DB::table('subscription_log')->where('subscription_log.rest_ID', '=', $rest_ID)->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return '';
    }

    public static function getAllSubscriptionTypes($country = 0) {
        $MSubscription = DB::table('subscriptiontypes');
        if (!empty($country)) {
            $MSubscription->where('country', '=', $country);
        }
        $MSubscription->orderBy('date_add', 'DESC');
        $lists = $MSubscription->get();
        return $lists;
    }

    public static function generate_list($lists, $id, $name, $displayID, $displayName) {
        $html = "";
        if (count($lists) > 0) {
            $html.= '<select class="form-control" name="' . $displayName . '" id="' . $displayID . '">';
            $html.='<option value="">please select ' . ucfirst($displayName) . '</option>';
            foreach ($lists as $list) {
                $html.='<option value="' . $list->$id . '">' . $list->$name . '</option>';
            }
            $html.="</select>";
        }
        return $html;
    }

    public static function getSufratiLogo($country = 0, $lang = 'en') {
        $logo = DB::table('art_work')->select('image', 'image_ar')->where('active', '=', 1)->where('art_work_name', '=', 'Azooma Logo');
        if (!empty($country)) {
            $logo->where('country', '=', $country);
        }
        $logo = $logo->first();
        // dd($logo);
        return $logoimage = ($lang == "en") ? $logo->image : $logo->image_ar;
    }



	/***** From Mohamed Fasil ******/


	public static function getCity($city=0,$full=true){
		if($full){
			return DB::table('city_list')->where('city_ID',$city)->first();	
		}else{
			return DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url','country')->where('city_ID',$city)->first();	
		}
	}

	public static function getCityURL($city="",$min=false){
		if($min){
			return DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url','country')->where('seo_url',$city)->first();
		}else{
			return DB::table('city_list')->where('seo_url',$city)->first();
		}
	}

	public static function getPossibleCity($rest=0){
		$q="SELECT GROUP_CONCAT(DISTINCT cl.seo_url) as cities FROM rest_branches rb JOIN city_list cl ON cl.city_ID=rb.city_ID AND cl.city_Status=1 WHERE rb.rest_fk_id=:rest AND rb.status=1";
		$result=DB::select(DB::raw($q),array('rest'=>$rest));
        $curcity=DB::table('city_list')->select('city_ID','city_Name','city_Name_Ar','seo_url','country')->where('city_ID',Session::get('sfcity'))->first();
        if(count($result)>0){
            $cities=explode(',', trim($result[0]->cities));
            if(in_array($curcity->seo_url, $cities)){
                return $curcity;
            }else{
                $city=DB::table('city_list')->select('city_ID','city_Name','city_Name_Ar','seo_url','country')->where('seo_url',$cities[0])->first();
                if(count($city)>0){
                	return $city;
                }else{
            		return $curcity;    	
                }
            }
        }else{
            return $curcity;
        }
	}

	public static function getCountry($country=0){
		return DB::table('aaa_country')->where('id',$country)->first();
	}

	public static function getLogo(){
		return DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
	}

	public static function getAllCuisines($categorised=true){
		if($categorised){
			$masters=DB::table('master_cuisine')->select('id','name','name_ar')->where('status',1)->get();
			if(count($masters)>0){
				foreach ($masters as $mc) {
					$cuisines=DB::table('cuisine_list')->select('cuisine_ID','cuisine_Name','cuisine_Name_ar','image')->where('cuisine_Status',1)->where('master_id',$mc->id)->get();
					if(count($cuisines)>0){
						$mc->cuisines=$cuisines;
					}
				}
				$cuisines=DB::table('cuisine_list')->select('cuisine_ID','cuisine_Name','cuisine_Name_ar','image')->where('cuisine_Status',1)->where('master_id',0)->get();
				$masters[count($masters)]=(object)array(
					'name'=>'Other',
					'name_ar'=>Lang::get('messages.other',array(), 'ar'),
					'cuisines'=>$cuisines
				);
				
			}
			return $masters;
		}
	}

	public static function getAllCountries(){
		return DB::table('aaa_country')->get();
	}

    public static function addVisit($city=0,$rest=0,$search=""){
        $ref="";
        $country=0;
        $robot=Agent::isRobot();
        if($city!=0){
            $city=MGeneral::getCity($city,true);
            $country=$city->country;
            $city=$city->city_ID;
        }
        if(isset($_SERVER['HTTP_REFERER'])){
            $ref=parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        }else{
           $ref="direct";
        }
        $data=array(
            'ua'=>$_SERVER['HTTP_USER_AGENT'],
            'lang'=>Config::get('app.locale'),
            'currentPage'=>Request::url(),
            'rest_ID'=>$rest,
            'ref'=>$ref,
            'search_term'=>$search,
            'city_ID'=>$city,
            'country'=>$country,
            'robot'=>$robot,
            'ip'=>Azooma::getRealIpAddr()
        );
        DB::table('analytics')->insert($data);
    }

}