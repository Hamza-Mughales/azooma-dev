<?php

class MGeneralActions extends Eloquent {

    protected $table = '';

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
        $MRestaurant_info = MGeneralActions::select('*');
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

    function getAllArtwork($country = 0, $type = 'Logo', $status = 0, $limit = 0, $name = "") {
        $this->table = "art_work";
        $Martwork = MGeneralActions::select('*');
        $Martwork->where('art_work_name', '=', ucfirst($type));
        if (!empty($country)) {
            $Martwork->where('country', '=', $country);
        }
        if ($status == 1) {
            $Martwork->where('status', '=', 1);
        }
        if ($name != "") {
            $Martwork->where('a_title', 'LIKE', $name . '%');
        }
        $Martwork->orderBy('createdAt', 'DESC');
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
        $Mart_work = MGeneralActions::select('*');
        if ($status == 1) {
            $Mart_work->where('status', '=', 1);
        }
        $Mart_work->where('id', '=', $id);
        return $Mart_work->first();
    }

    function getAllBcategories($status = 0, $limit = 0, $name = "") {
        $this->table = "businesscategories";
        $MBcategories = MGeneralActions::select('*');
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
        $MRestStyle = MGeneralActions::select('*');
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
        $MBcategories = MGeneralActions::select('*');
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
        $MSubBCat = MGeneralActions::select('*');
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
        $MRestServices = MGeneralActions::select('*');
        $MRestServices->where('id', '=', $id);
        return $MRestServices->first();
    }

    function addRestServices($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('name')), 'dash', TRUE);
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
        $url = Str::slug((Input::get('name')), 'dash', TRUE);
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
        $mcountry = MGeneralActions::select('*');
        $mcountry->orderBy('name', 'asc');
        $lists = $mcountry->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    public function getAdminCountryName($id, $lang = 'en') {
        $this->table = "aaa_country";
        $mcountry = MGeneralActions::select('*');
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
        $MCITY = MGeneralActions::select('*');
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
        $result = DB::connection('sufrati-users')->table('user')->where('user_ID', $user_ID)->first();
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
            $lists = $query->paginate();
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

    function getAllBestFor($status = 0, $city = 0) {
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

    function getAllCuisine($status = 0, $city = 0) {
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

    function getAllMasterCuisine($status = 0, $limit = 0, $offset = "") {
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
            $lists = $query->paginate();
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

    function getAllCities($limit = "", $lang = "en") {
        $query = DB::table('city_list');
        $query->select('city_list.*');
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

    function getCityDistricts($city = 0, $status = "") {
        $MCityDist = DB::table('district_list');
        if ($city != 0) {
            $MCityDist->where('city_ID', $city);
        }
        if ($status != "") {
            $MCityDist->where('district_Status', $status);
        }
        $MCityDist->orderBy('district_Name', 'ASC');
        $lists = $MCityDist->paginate();
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

}
