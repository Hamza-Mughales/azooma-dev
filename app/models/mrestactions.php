<?php

class MRestActions extends Eloquent {

    protected $table = 'restaurant_info';

    function getRestByUrl($url = "") {
        $list = DB::table('restaurant_info')->where('seo_url', '=', $url)->first();
        if (count($list) > 0) {
            return $list;
        }
    }

    public static function getRestCity($restID = "") {
        $MRestCity = DB::table('restaurant_info');
        $MRestCity->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
        $MRestCity->join('city_list', 'city_list.city_ID', '=', 'rest_branches.city_ID');
        $list = $MRestCity->where('restaurant_info.rest_ID', $restID)->first();
        if (count($list) > 0) {
            return $list->seo_url;
        }
    }

    function addRestaurant($logo = "") {
        $status = 0;
        $rest_type = "";
        $breakfast = $brunch = $lunch = $dinner = $latenight = $iftar = $suhur = 0;
        if (isset($_POST['breakfast'])) {
            $breakfast = 1;
        }
        if (isset($_POST['brunch'])) {
            $brunch = 1;
        }
        if (isset($_POST['lunch'])) {
            $lunch = 1;
        }
        if (isset($_POST['dinner'])) {
            $dinner = 1;
        }
        if (isset($_POST['latenight'])) {
            $latenight = 1;
        }
        if (isset($_POST['iftar'])) {
            $iftar = 1;
        }
        if (isset($_POST['suhur'])) {
            $suhur = 1;
        }
        if (isset($_POST['rest_type'])) {
            $rest_type = implode(",", $_POST['rest_type']);
        }
        if (isset($_POST['rest_Status'])) {
            $status = 1;
        }
        $restNameURL = Input::get('rest_Name');
        $restNameURL = trim($restNameURL);
        $url = Str::slug(stripslashes($restNameURL), '-');
        if (count($this->getRestByUrl($url)) > 0) {
            $url = $url . rand(1, 10000);
        }
        $rest_Email = $_POST['rest_Email'];
        $rest_Email = implode(",", $rest_Email);
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest_style = 0;
        if (Input::has('rest_style')) {
            $rest_style = Input::get('rest_style');
        }
        $data = array(
            'restbusiness_type' => (Input::get('restbusiness_type')),
            'rest_Name' => ($restNameURL),
            'rest_Name_Ar' => (Input::get('rest_Name_Ar')),
            'rest_Logo' => $logo,
            'rest_Description' => (Input::get('rest_Description')),
            'rest_Description_Ar' => (Input::get('rest_Description_Ar')),
            'rest_type' => $rest_type,
            'head_office' => (Input::get('head_office')),
            'rest_Description' => (Input::get('rest_Description')),
            'seo_url' => $url,
            'rest_style' => $rest_style,
            'class_category' => (Input::get('class_category')),
            'rest_WebSite' => (Input::get('rest_WebSite')),
            'rest_Email' => $rest_Email,
            'facebook_fan' => (Input::get('facebook_fan')),
            'rest_Mobile' => (Input::get('rest_Mobile')),
            'your_Name' => (Input::get('your_Name')),
            'your_Email' => (Input::get('your_Email')),
            'your_Contact' => (Input::get('your_Contact')),
            'your_Position' => (Input::get('your_Position')),
            'price_range' => (Input::get('price_range')),
            'rest_TollFree' => (Input::get('rest_TollFree')),
            'rest_Telephone' => (Input::get('rest_Telephone')),
            'rest_pbox' => (Input::get('rest_pbox')),
            'opening' => (Input::get('opening')),
            'rest_tags' => (Input::get('rest_tags')),
            'rest_tags_ar' => (Input::get('rest_tags_ar')),
            'lastUpdatedOn' => date('Y-m-d H:i:s'),
            'openning_manner' => (Input::get('openning_manner')),
            'country' => $country,
            'rest_Status' => $status,
            'breakfast' => $breakfast,
            'brunch' => $brunch,
            'lunch' => $lunch,
            'dinner' => $dinner,
            'latenight' => $latenight,
            'iftar' => $iftar,
            'suhur' => $suhur
        );
        return DB::table('restaurant_info')->insertGetId($data);
    }

    function updateRestaurant($logo = "") {
        $status = 0;
        $rest_type = "";
        $breakfast = $brunch = $lunch = $dinner = $latenight = $iftar = $suhur = 0;
        if (isset($_POST['breakfast'])) {
            $breakfast = 1;
        }
        if (isset($_POST['brunch'])) {
            $brunch = 1;
        }
        if (isset($_POST['lunch'])) {
            $lunch = 1;
        }
        if (isset($_POST['dinner'])) {
            $dinner = 1;
        }
        if (isset($_POST['latenight'])) {
            $latenight = 1;
        }
        if (isset($_POST['iftar'])) {
            $iftar = 1;
        }
        if (isset($_POST['suhur'])) {
            $suhur = 1;
        }
        if (isset($_POST['rest_type'])) {
            $rest_type = implode(",", $_POST['rest_type']);
        }
        $rest = Input::get('rest_ID');
        if (isset($_POST['rest_Status'])) {
            $status = 1;
        }
        $rest_style = 0;
        if (Input::has('rest_style')) {
            $rest_style = Input::get('rest_style');
        }
        $restNameURL = Input::get('rest_Name');
        $restNameURL = trim($restNameURL);
        $url = Str::slug(stripslashes($restNameURL), '-');
        $restByUrl = $this->getRestByUrl($url);
        if ((count($restByUrl) > 0) && ($restByUrl->rest_ID != $rest)) {
            $url = $url . rand(1, 10000);
        }
        $rest_Email = $_POST['rest_Email'];
        $rest_Email = implode(",", $rest_Email);
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'restbusiness_type' => (Input::get('restbusiness_type')),
            'rest_Name' => ($restNameURL),
            'rest_Name_Ar' => (Input::get('rest_Name_Ar')),
            'rest_Logo' => $logo,
            'rest_Description' => (Input::get('rest_Description')),
            'rest_Description_Ar' => (Input::get('rest_Description_Ar')),
            'rest_type' => $rest_type,
            'rest_Description' => (Input::get('rest_Description')),
            'rest_style' => $rest_style,
            'class_category' => (Input::get('class_category')),
            'rest_WebSite' => (Input::get('rest_WebSite')),
            'rest_Email' => $rest_Email,
            'facebook_fan' => (Input::get('facebook_fan')),
            'head_office' => (Input::get('head_office')),
            'rest_Mobile' => (Input::get('rest_Mobile')),
            'your_Name' => (Input::get('your_Name')),
            'your_Email' => (Input::get('your_Email')),
            'your_Contact' => (Input::get('your_Contact')),
            'your_Position' => (Input::get('your_Position')),
            'price_range' => (Input::get('price_range')),
            'rest_TollFree' => (Input::get('rest_TollFree')),
            'rest_Telephone' => (Input::get('rest_Telephone')),
            'rest_pbox' => (Input::get('rest_pbox')),
            'opening' => (Input::get('opening')),
            'rest_tags' => (Input::get('rest_tags')),
            'rest_tags_ar' => (Input::get('rest_tags_ar')),
            'openning_manner' => (Input::get('openning_manner')),
            'lastUpdatedOn' => date('Y-m-d H:i:s'),
            'country' => $country,
            'rest_Status' => $status,
            'breakfast' => $breakfast,
            'brunch' => $brunch,
            'lunch' => $lunch,
            'dinner' => $dinner,
            'latenight' => $latenight,
            'iftar' => $iftar,
            'suhur' => $suhur
        );
        if (isset($_POST['is_change'])) {
            $data['seo_url'] = $url;
        }
        DB::table('restaurant_info')->where('rest_ID', $rest)->update($data);
    }

    function addRestCuisines($rest = 0) {
        $cuisines = '';
        if (isset($_POST['cuisine'])) {
            $cuisines = $_POST['cuisine'];
        }
        if ($cuisines) {
            foreach ($cuisines as $cuisine) {
                $data = array(
                    'rest_ID' => $rest,
                    'cuisine_ID' => $cuisine
                );
                DB::table('restaurant_cuisine')->insertGetId($data);
            }
        }
    }

    function checkRestCuisine($rest = 0) {
        return DB::table('restaurant_cuisine')->where('rest_ID', '=', $rest)->count();
    }

    function deleteRestCuisines($rest = 0) {
        DB::table('restaurant_cuisine')->where('rest_ID', '=', $rest)->delete();
    }

    function deleteRest($rest = 0) {
        DB::table('restaurant_info')->where('rest_ID', '=', $rest)->delete();
    }

    function updateRestCuisines($rest = 0) {
        if ($this->checkRestCuisine($rest) > 0) {
            $this->deleteRestCuisines($rest);
        }
        $cuisines = '';
        if (isset($_POST['cuisine'])) {
            $cuisines = $_POST['cuisine'];
        }
        if ($cuisines) {
            foreach ($cuisines as $cuisine) {
                $data = array(
                    'rest_ID' => $rest,
                    'cuisine_ID' => $cuisine
                );
                DB::table('restaurant_cuisine')->insert($data);
            }
        }
    }

    function addRestBestFor($rest = 0) {
        $bestfors = '';
        if (isset($_POST['bestfor'])) {
            $bestfors = $_POST['bestfor'];
        }

        if ($bestfors) {
            foreach ($bestfors as $bestfor) {
                $data = array(
                    'rest_ID' => $rest,
                    'bestfor_ID' => $bestfor
                );
                DB::table('restaurant_bestfor')->insert($data);
            }
        }
    }

    function checkRestBestFor($rest = 0) {
        DB::table('restaurant_bestfor')->where('rest_ID', $rest)->count();
    }

    function deleteRestBestFor($rest = 0) {
        DB::table('restaurant_bestfor')->where('rest_ID', $rest)->delete();
    }

    function updateRestBestFor($rest = 0) {
        if ($this->checkRestBestFor($rest) > 0) {
            $this->deleteRestBestFor($rest);
        }
        $bestfors = '';
        if (isset($_POST['bestfor'])) {
            $bestfors = $_POST['bestfor'];
        }
        if ($bestfors) {
            foreach ($bestfors as $bestfor) {
                $data = array(
                    'rest_ID' => $rest,
                    'bestfor_ID' => $bestfor
                );
                DB::table('restaurant_bestfor')->insert($data);
            }
        }
    }

    function addUpdateRestSubscriberEmail($rest_Email, $your_Name) {
        foreach ($rest_Email as $key => $email) {
            $q = DB::table('subscribers')->where('email', $email)->get();
            if (count($q) == 0) {
                $data = array(
                    'name' => ($your_Name),
                    'email' => $email,
                    'status' => 1,
                    'restaurant' => 1
                );
                DB::table('subscribers')->insert($data);
            }
        }
    }

    function postArraytoCSV($array) {
        if (is_array($array) && count($array) > 0) {
            $result = "";
            foreach ($array as $value) {
                if ($value == end($array)) {
                    $result.=$value;
                } else {
                    $result.=$value . ",";
                }
            }
            return $result;
        }
    }

    function addOpenHours($rest = 0) {
        $weekdays = "";
        $weekends = "";
        $breakfast = "";
        $brunch = "";
        $dinner = "";
        $lunch = "";
        if (isset($_POST['weekdays']) AND !empty($_POST['weekdays'])) {
            $weekdays = $this->postArraytoCSV($_POST['weekdays']);
        }
        if (isset($_POST['weekends']) AND !empty($_POST['weekends'])) {
            $weekends = $this->postArraytoCSV($_POST['weekends']);
        }
        if (isset($_POST['breakfast']) AND !empty($_POST['breakfast'])) {
            $breakfast = $this->postArraytoCSV($_POST['breakfast']);
        }
        if (isset($_POST['brunch']) AND !empty($_POST['brunch'])) {
            $brunch = $this->postArraytoCSV($_POST['brunch']);
        }
        if (isset($_POST['lunch']) AND !empty($_POST['lunch'])) {
            $lunch = $this->postArraytoCSV($_POST['lunch']);
        }
        if (isset($_POST['dinner']) AND !empty($_POST['dinner'])) {
            $dinner = $this->postArraytoCSV($_POST['dinner']);
        }
        $data = array(
            'rest_ID' => $rest,
            'weekdays' => $weekdays,
            'weekends' => $weekends,
            'breakfast' => $breakfast,
            'brunch' => $brunch,
            'lunch' => $lunch,
            'dinner' => $dinner,
            'date_upd' => Date('Y-m-n h:m:s')
        );
        DB::table('rest_weekdays')->insert($data);
        $opendata = array(
            'week_days_start' => (Input::get('week_days_start')),
            'week_days_close' => (Input::get('week_days_close')),
            'week_ends_start' => (Input::get('week_ends_start')),
            'week_ends_close' => (Input::get('week_ends_close')),
            'breakfast_start' => (Input::get('breakfast_start')),
            'breakfast_close' => (Input::get('breakfast_close')),
            'brunch_start' => (Input::get('brunch_start')),
            'brunch_close' => (Input::get('brunch_close')),
            'lunch_start' => (Input::get('lunch_start')),
            'lunch_close' => (Input::get('lunch_close')),
            'dinner_start' => (Input::get('dinner_start')),
            'dinner_close' => (Input::get('dinner_close')),
            'iftar_start' => (Input::get('iftar_start')),
            'iftar_close' => (Input::get('iftar_close')),
            'suhur_start' => (Input::get('suhur_start')),
            'suhur_close' => (Input::get('suhur_close')),
            'rest_ID' => $rest
        );
        DB::table('open_hours')->insert($opendata);
    }

    function updateOpenHours($rest = 0) {
        $weekdays = "";
        $weekends = "";
        $breakfast = "";
        $brunch = "";
        $dinner = "";
        $lunch = "";
        $q = DB::table('rest_weekdays')->where('rest_ID', $rest)->get();
        if (count($q) == 0) {
            $this->addOpenHours($rest);
            return;
        }

        if (isset($_POST['weekdays']) AND !empty($_POST['weekdays'])) {
            $weekdays = $this->postArraytoCSV($_POST['weekdays']);
        }
        if (isset($_POST['weekends']) AND !empty($_POST['weekends'])) {
            $weekends = $this->postArraytoCSV($_POST['weekends']);
        }
        if (isset($_POST['breakfast']) AND !empty($_POST['breakfast'])) {
            $breakfast = $this->postArraytoCSV($_POST['breakfast']);
        }
        if (isset($_POST['brunch']) AND !empty($_POST['brunch'])) {
            $brunch = $this->postArraytoCSV($_POST['brunch']);
        }
        if (isset($_POST['lunch']) AND !empty($_POST['lunch'])) {
            $lunch = $this->postArraytoCSV($_POST['lunch']);
        }
        if (isset($_POST['dinner']) AND !empty($_POST['dinner'])) {
            $dinner = $this->postArraytoCSV($_POST['dinner']);
        }

        $data = array(
            'rest_ID' => $rest,
            'weekdays' => $weekdays,
            'weekends' => $weekends,
            'breakfast' => $breakfast,
            'brunch' => $brunch,
            'lunch' => $lunch,
            'dinner' => $dinner,
            'date_upd' => Date('Y-m-n h:m:s')
        );
        DB::table('rest_weekdays')->where('rest_ID', $rest)->update($data);
        $opendata = array(
            'week_days_start' => (Input::get('week_days_start')),
            'week_days_close' => (Input::get('week_days_close')),
            'week_ends_start' => (Input::get('week_ends_start')),
            'week_ends_close' => (Input::get('week_ends_close')),
            'breakfast_start' => (Input::get('breakfast_start')),
            'breakfast_close' => (Input::get('breakfast_close')),
            'brunch_start' => (Input::get('brunch_start')),
            'brunch_close' => (Input::get('brunch_close')),
            'lunch_start' => (Input::get('lunch_start')),
            'lunch_close' => (Input::get('lunch_close')),
            'dinner_start' => (Input::get('dinner_start')),
            'dinner_close' => (Input::get('dinner_close')),
            'iftar_start' => (Input::get('iftar_start')),
            'iftar_close' => (Input::get('iftar_close')),
            'suhur_start' => (Input::get('suhur_start')),
            'suhur_close' => (Input::get('suhur_close')),
            'rest_ID' => $rest
        );
        DB::table('open_hours')->where('rest_ID', $rest)->update($opendata);
    }

    function updateRestInfoConactEmails($rest_ID, $uptodateEmails = "") {
        $emails = "";
        if (isset($uptodateEmails)) {
            $emails = implode(',', $uptodateEmails);
        }
        $data = array(
            'rest_Email' => $emails,
            'your_Name' => (Input::get('full_name')),
            'your_Contact' => (Input::get('phone'))
        );
        DB::table('restaurant_info')->where('rest_ID', $rest_ID)->update($data);
    }

    function updateRestBookingConactEmails($rest_ID, $uptodateEmails = "") {
        $user_ID = '';
        $q = DB::table('booking_management')->where('rest_id', $rest_ID)->get();
        if (count($q) > 0) {
            $memberINfo = $q;
            if (!empty($memberINfo->id_user)) {
                $emails = "";
                if (isset($uptodateEmails)) {
                    $emails = implode(',', $uptodateEmails);
                }
                $data = array(
                    'email' => $emails,
                    'full_name' => (Input::get('your_Name')),
                    'phone' => (Input::get('your_Contact'))
                );
                DB::table('booking_management')->where('rest_id', $rest_ID)->where('id_user', $memberINfo->id_user)->update($data);
            }
        }
    }

    function updateMembershipStatus($id, $status = 0) {
        $data = array(
            'status' => $status
        );
        DB::table('booking_management')->where('rest_id', $id)->update($data);
    }

    function addGroupRest($rest_ID) {
        $data = array(
            'group_id' => (Input::get('group_value')),
            'rest_ID' => $rest_ID
        );
        DB::table('rest_group')->insert($data);
    }

    function updateGroupRest($rest_ID) {
        $data = array(
            'group_id' => (Input::get('group_value'))
        );
        DB::table('rest_group')->where('rest_ID', $rest_ID)->update($data);
    }

    function getGroupRest($rest_ID) {
        return DB::table('rest_group')->where('rest_ID', $rest_ID)->get();
    }

    public static function getAllRestaurants($country = 0, $city = "", $status = "", $limit = "", $count = false, $district = "", $rest_viewed = 0, $cuisine = "", $best = "", $member = "", $price = "", $restaurant = "", $sort = "latest") {
        $MREST = DB::table('restaurant_info');
        $MREST->select('restaurant_info.*',
                DB::Raw('(select status FROM booking_management WHERE rest_id=restaurant_info.rest_ID Limit 1 ) AS membershipstatus'), 
                DB::Raw("( SELECT getCuisineName(restaurant_info.rest_ID,'en') ) as cuisines"), 
                DB::Raw("( SELECT getCityName(restaurant_info.rest_ID,'en') ) as cities"));

        if (!empty($country)) {
            $MREST->where('restaurant_info.country', '=', $country);
        }
        if ($status != "") {
            $MREST->where('restaurant_info.rest_Status', $status);
        }
        if ($city != "") {
            $MREST->join('rest_branches', function($join) {
                $join->on('rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            });
            $MREST->where('rest_branches.city_ID', '=', $city);
            if ($district != 0) {
                $MREST->where('rest_branches.district_ID', $district);
            }
        }
        if ($rest_viewed != 0) {
            $MREST->where('restaurant_info.rest_Viewed > ', $rest_viewed);
        }
        if ($cuisine != "") {
            $MREST->join('restaurant_cuisine', 'restaurant_cuisine.rest_ID', '=', 'restaurant_info.rest_ID');
            $MREST->where('restaurant_cuisine.cuisine_ID', '=', $cuisine);
        }
        if ($best != "") {
            $MREST->join('restaurant_bestfor', 'restaurant_bestfor.rest_ID', '=', 'restaurant_info.rest_ID');
            $MREST->where('restaurant_bestfor.bestfor_ID', '=', $best);
        }
        if ($member != "") {
            $MREST->where('restaurant_info.rest_Subscription', $member);
        }
        if ($price != "") {
            $MREST->where('restaurant_info.price_range', $price);
        }
        if ($restaurant != "") {
            $MREST->where('restaurant_info.rest_Name', 'LIKE', $restaurant . '%');
        }
        $MREST->orderBy('restaurant_info.is_read');
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $MREST->orderBy('restaurant_info.rest_Name', 'ASC');
                    break;
                case 'latest':
                    $MREST->orderBy('restaurant_info.rest_RegisDate', 'DESC');
                    break;
                case 'popular':
                    $MREST->select("*", DB::raw('(SELECT COUNT(id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1) as likes'));
                    $MREST->orderBy('likes', 'DESC');
                    break;
                case 'favorite':
                    $MREST->where('restaurant_info.sufrati_favourite >=', 1);
                    break;
            }
        }
        if ($count) {
            return $MREST->count();
        }
        if ($limit != "") {
            $lists = $MREST->paginate($limit);
        } else {
            $lists = $MREST->get();
        }
        if (count($lists) > 0) {
            return $lists;
        } else {
            return NULL;
        }
    }

    public static function getAllRestStyles($country = 0, $status = 0, $limit = 0, $name = "") {
        //$this->table = "rest_style";
        $MRestStyle = DB::table('rest_style');
        //MRestActions::select('*');
        if (!empty($country)) {
            $MRestStyle->where('country', '=', $country);
        }
        if ($status == 1) {
            $MRestStyle->where('status', '=', 1);
        }
        if ($name != "") {
            $MRestStyle->where('name', 'LIKE', $name . '%');
        }
        $MRestStyle->orderBy('name', 'DESC');
        if ($limit != "") {
            $lists = $MRestStyle->paginate($limit);
        } else {
            $lists = $MRestStyle->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    public static function getRest($id) {
        return $query = DB::table('restaurant_info')->where('rest_ID', '=', $id)->first();
    }

    function getRestStyle($id) {
        $this->table = "rest_style";
        $MRestStyle = MRestActions::select('*');
        $MRestStyle->where('id', '=', $id);
        return $MRestStyle->first();
    }

    function addRestStyle() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
            'status' => $status
        );
        return $id = DB::table('rest_style')->insertGetId($data);
    }

    function updateRestStyle() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
            'status' => $status
        );
        DB::table('rest_style')->where('id', Input::get('id'))->update($data);
    }

    function deleteRestStyle($id) {
        DB::table('rest_style')->where('id', $id)->delete();
    }

    function getAllRestTypes($country = 0, $status = 0, $limit = 0, $name = "", $sort = "") {
        $this->table = "rest_type";
        $MRestTypes = MRestActions::select('*');
        if (!empty($country)) {
            $MRestTypes->where('country', '=', $country);
        }
        if ($status != "") {
            $MRestTypes->where('status', '=', $status);
        }
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $MRestTypes->orderBy('name', 'DESC');
                    break;
                case 'latest':
                    $MRestTypes->orderBy('createdAt', 'DESC');
                    break;
            }
        }
        if ($name != "") {
            $MRestTypes->where('name', 'LIKE', $name . '%');
        }

        if ($limit != "") {
            $lists = $MRestTypes->paginate($limit);
        } else {
            $lists = $MRestTypes->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getRestType($id) {
        $this->table = "rest_type";
        $MRestStyle = MRestActions::select('*');
        $MRestStyle->where('id', '=', $id);
        return $MRestStyle->first();
    }

    function addRestType() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
            'status' => $status
        );
        return $id = DB::table('rest_type')->insertGetId($data);
    }

    function updateRestType() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
            'status' => $status
        );
        DB::table('rest_type')->where('id', Input::get('id'))->update($data);
    }

    function deleteRestType($id) {
        DB::table('rest_type')->where('id', $id)->delete();
    }

    function getAllRestServices($country = 0, $city = 0, $status = "", $limit = 0, $name = "", $sort = "") {
        $MrestServices = DB::table('features_services');
        if ($country != 0) {
            $MrestServices->where('features_services.country', '=', $country);
        }

        if ($status != "") {
            $MrestServices->where('features_services.status', '=', $status);
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

        if (!empty($sort)) {
            switch ($sort) {
                case 'name':
                    $MrestServices->orderBy('name', 'DESC');
                    break;
                case 'latest':
                    $MrestServices->orderBy('createdAt', 'DESC');
                    break;
            }
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
        $MRestServices = MRestActions::select('*');
        $MRestServices->where('id', '=', $id);
        return $MRestServices->first();
    }

    function addRestServices($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
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
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
            'status' => $status,
            'seo_url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('features_services')->where('id', '=', Input::get('id'))->update($data);
    }

    function deleteRestService($id) {
        DB::table('features_services')->where('id', '=', $id)->delete();
    }

    function getAllGroupRestaurants($status = 0) {
        $query = "";
        $query = DB::table('restaurant_groups');
        if ($status != 0) {
            $query->where('status', '=', 1);
        }
        $lists = $query->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function read($rest = 0) {
        $data = array(
            'is_read' => 1
        );
        DB::table('restaurant_info')->where('rest_ID', $rest)->update($data);
    }

    function getRestaurantTimings($rest = 0) {
        $lists = DB::table('open_hours')->where('rest_ID', $rest)->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getRestaurantDays($rest = 0) {
        $lists = DB::table('rest_weekdays')->where('rest_ID', $rest)->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getAllBranches($rest = 0, $city = "", $limit = "", $offset = "", $titleflag = false, $status = 0) {
        $MRESTBranch = DB::table('rest_branches');
        $MRESTBranch->select('*');
        if ($rest != 0) {
            $MRESTBranch->where('rest_branches.rest_fk_id', '=', $rest);
        }
        if ($status != 0) {
            $MRESTBranch->where('rest_branches.status', '=', 1);
        }
        if ($city != "") {
            $MRESTBranch->where('rest_branches.city_ID', '=', $city);
        }
        $MRESTBranch->join('city_list', 'city_list.city_ID', '=', 'rest_branches.city_ID');
        $MRESTBranch->leftjoin('district_list', 'district_list.district_ID', '=', 'rest_branches.district_ID');

        if ($titleflag == true) {
            $MRESTBranch->select('restaurant_info.rest_Name');
            $MRESTBranch->where('rest_branches.latitude', "")->or_where('rest_branches.longitude', "");
            $MRESTBranch->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'rest_branches.rest_fk_id');
        }

        if ($limit != "") {
            $lists = $MRESTBranch->paginate($limit);
        } else {
            $lists = $MRESTBranch->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getRestBranch($br_id = 0) {
        $lists = DB::table('rest_branches')->where('br_id', $br_id)->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getHotelRest($hotel_id, $br_id) {
        //$query = "SELECT * FROM hotel_rest WHERE hotel_id=$hotel_id AND rest_id={$br_id}";
        $lists = DB::table('hotel_rest')->where('hotel_id', $hotel_id)->where('rest_id', $br_id)->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function addBranch() {
        $seating = $features = $mood = "";
        $status = 0;
        $rest = $this->getRest(Input::get('rest_fk_id'));
        $url = Str::slug($rest->rest_Name, '-', TRUE);
        $url.="-" . Str::slug(Input::get('br_loc'), '-');
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (isset($_POST['seating_rooms'])) {
            $seating = implode(',', $_POST['seating_rooms']);
        }
        if (isset($_POST['features_services'])) {
            $features = implode(',', $_POST['features_services']);
        }
        if (isset($_POST['mood_atmosphere'])) {
            $mood = implode(',', $_POST['mood_atmosphere']);
        }
        $data = array(
            'city_ID' => (Input::get('city_ID')),
            'district_ID' => (Input::get('district_' . Input::get('city_ID'))),
            'br_loc' => (Input::get('br_loc')),
            'br_loc_ar' => Input::get('br_loc_ar'),
            'br_number' => Input::get('cityCode') . ' - ' . (Input::get('br_number')),
            'rest_fk_id' => (Input::get('rest_fk_id')),
            'br_mobile' => (Input::get('br_mobile')),
            'br_toll_free' => (Input::get('br_tollfree')),
            'latitude' => (Input::get('latitude')),
            'longitude' => (Input::get('longitude')),
            'zoom' => (Input::get('zoom')),
            'branch_type' => (Input::get('branch_type')),
            'tot_seats' => (Input::get('tot_seats')),
            'seating_rooms' => $seating,
            'features_services' => $features,
            'mood_atmosphere' => $mood,
            'lastUpdated' => date('Y-m-d H:i:s'),
            'status' => $status,
            'url' => $url
        );
        return DB::table('rest_branches')->insertGetId($data);
    }

    function getBranch($br = 0) {
        $list = DB::table('rest_branches')->where('br_id', '=', $br)->first();
        if (count($list) > 0) {
            return $list;
        }
    }

    function updateBranch() {
        $seating = $features = $mood = "";
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $rest = $this->getRest(Input::get('rest_fk_id'));
        $url = Str::slug($rest->rest_Name, '-');
        $url.="-" . Str::slug(Input::get('br_loc'), '-');
        if (isset($_POST['seating_rooms'])) {
            $seating = implode(',', $_POST['seating_rooms']);
        }
        if (isset($_POST['features_services'])) {
            $features = implode(',', $_POST['features_services']);
        }
        if (isset($_POST['mood_atmosphere'])) {
            $mood = implode(',', $_POST['mood_atmosphere']);
        }
        $data = array(
            'city_ID' => (Input::get('city_ID')),
            'district_ID' => (Input::get('district_' . Input::get('city_ID'))),
            'br_loc' => (Input::get('br_loc')),
            'br_loc_ar' => Input::get('br_loc_ar'),
            'br_number' => Input::get('cityCode') . ' - ' . (Input::get('br_number')),
            'rest_fk_id' => (Input::get('rest_fk_id')),
            'br_mobile' => (Input::get('br_mobile')),
            'br_toll_free' => (Input::get('br_tollfree')),
            'latitude' => (Input::get('latitude')),
            'longitude' => (Input::get('longitude')),
            'zoom' => (Input::get('zoom')),
            'branch_type' => (Input::get('branch_type')),
            'tot_seats' => (Input::get('tot_seats')),
            'seatings' => (Input::get('seatings')),
            'seating_rooms' => $seating,
            'features_services' => $features,
            'mood_atmosphere' => $mood,
            'lastUpdated' => date('Y-m-d H:i:s'),
            'status' => $status,
            'url' => $url
        );
        DB::table('rest_branches')->where('br_id', '=', Input::get('br_id'))->update($data);
    }

    function getBranchImages($br_id = 0, $status = 0, $limit = "") {
        $MRESTBranchImages = DB::table('image_gallery');
        $MRESTBranchImages->select('*');

        if ($status != 0) {
            $MRESTBranchImages->where('image_gallery.status', $status);
        }

        $MRESTBranchImages->where('image_gallery.branch_ID', $br_id);
        $MRESTBranchImages->where('image_gallery.rest_ID', '>', 0);
        if ($limit != "") {
            $lists = $MRESTBranchImages->paginate($limit);
        } else {
            $lists = $MRESTBranchImages->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function updateRestLastUpdatedOn($rest) {
        $data = array(
            'lastUpdatedOn' => date('Y-m-d H:i:s')
        );
        DB::table('restaurant_info')->where('rest_ID', '=', $rest)->update($data);
    }

    function addBranchHotel($branch) {
        $data = array(
            'hotel_id' => (Input::get('hotel_value')),
            'rest_id' => $branch
        );
        DB::table('hotel_rest')->insertGetId($data);
    }

    function updateBranchHotel($branch) {
        $data = array(
            'hotel_id' => (Input::get('hotel_value'))
        );
        DB::table('hotel_rest')->where('rest_id', '=', $branch)->update($data);
    }

    function getAllMoodsAtmosphere($country = 0, $status = "", $limit = 0, $name = "", $sort = "") {
        $this->table = "moodsatmosphere";
        $Mmoodsatmosphere = MRestActions::select('*');
        if ($country != 0) {
            $Mmoodsatmosphere->where('moodsatmosphere.country', '=', $country);
        }
        if (!empty($sort)) {
            switch ($sort) {
                case 'name':
                    $Mmoodsatmosphere->orderBy('name', 'ASC');
                    break;
                case 'latest':
                    $Mmoodsatmosphere->orderBy('createdAt', 'DESC');
                    break;
            }
        }
        if ($status != "") {
            $Mmoodsatmosphere->where('moodsatmosphere.status', '=', $status);
        }
        $Mmoodsatmosphere->orderBy('moodsatmosphere.name');

        if ($name != "") {
            $Mmoodsatmosphere->where('moodsatmosphere.name', 'LIKE', $name . '%');
        }
        if ($limit != "") {
            $lists = $Mmoodsatmosphere->paginate($limit);
        } else {
            $lists = $Mmoodsatmosphere->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getMoodsAtmosphere($id) {
        $this->table = "moodsatmosphere";
        $Mmoodsatmosphere = MRestActions::select('*');
        $Mmoodsatmosphere->where('id', '=', $id);
        return $Mmoodsatmosphere->first();
    }

    function addMoodsAtmosphere($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
            'status' => $status,
            'seo_url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return $qid = DB::table('moodsatmosphere')->insertGetId($data);
    }

    function updateMoodsAtmosphere($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'country' => $country,
            'status' => $status,
            'seo_url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('moodsatmosphere')->where('id', '=', Input::get('id'))->update($data);
    }

    function deleteMoodsAtmosphere($id) {
        DB::table('moodsatmosphere')->where('id', '=', $id)->delete();
    }

    function getImage($image_ID = 0) {
        $list = DB::table('image_gallery')->where('image_ID', '=', $image_ID)->first();
        if (count($list) > 0) {
            return $list;
        }
    }

    function addBranchImage($image = "", $title, $title_ar, $ratio = 0, $width = 0) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (($ratio != 0) && ($width != 0)) {
            $data = array(
                'title' => $title,
                'title_ar' => $title_ar,
                'rest_ID' => (Input::get('rest_fk_id')),
                'branch_ID' => (Input::get('br_id')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'width' => $width,
                'ratio' => $ratio,
            );
        }
        if (($ratio == 0) && ($width == 0)) {
            $data = array(
                'title' => $title,
                'title_ar' => $title_ar,
                'rest_ID' => (Input::get('rest_fk_id')),
                'branch_ID' => (Input::get('br_id')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status
            );
        }
        return DB::table('image_gallery')->insertGetId($data);
    }

    function updateBranchImage($image_ID, $image = "", $title, $title_ar, $ratio = 0, $width = 0) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (($ratio != 0) && ($width != 0)) {
            $data = array(
                'title' => $title,
                'title_ar' => $title_ar,
                'rest_ID' => (Input::get('rest_fk_id')),
                'branch_ID' => (Input::get('br_id')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'width' => $width,
                'ratio' => $ratio,
                'updatedAt' => date('Y-m-d H:i:s')
            );
        }
        if (($ratio == 0) && ($width == 0)) {
            $data = array(
                'title' => $title,
                'title_ar' => $title_ar,
                'rest_ID' => (Input::get('rest_fk_id')),
                'branch_ID' => (Input::get('br_id')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );
        }
        DB::table('image_gallery')->where('image_ID', '=', $image_ID)->update($data);
    }

    function deleteImage($image_ID = 0) {
        DB::table('image_gallery')->where('image_ID', '=', $image_ID)->delete();
    }

    function getAllMenuCats($rest = 0, $limit = 0, $menu_id = "") {
        $this->table = 'menu_cat';
        $MRestMenuCats = MRestActions::select('*');
        $MRestMenuCats->where('rest_ID', '=', $rest);
        if ($menu_id != "") {
            $MRestMenuCats->where('menu_id', '=', $menu_id);
        }

        $MRestMenuCats->orderBy('listOrder');

        if (!empty($limit)) {
            $lists = $MRestMenuCats->paginate($limit);
        } else {
            $lists = $MRestMenuCats->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getAllMenuItems($rest = 0, $cat = 0) {
        $this->table = 'rest_menu';
        $MRestMenu = MRestActions::select('*');
        $MRestMenu->where('rest_fk_id', '=', $rest);
        $MRestMenu->where('cat_id', '=', $cat);
        $MRestMenu->orderBy('enter_time');
        $lists = $MRestMenu->paginate();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getMenuCat($menu = 0, $menu_id = "") {
        $this->table = 'menu_cat';
        $MRestMenu = MRestActions::select('*');
        $MRestMenu->where('cat_id', $menu);
        if ($menu_id != "") {
            $MRestMenu->where('menu_id', $menu_id);
        }
        $lists = $MRestMenu->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getMenuItem($item = 0) {
        $this->table = 'rest_menu';
        $MRestMenu = MRestActions::select('*');
        $MRestMenu->where('id', $item);
        $lists = $MRestMenu->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getPDFMenu($pdf) {
        $this->table = 'rest_menu_pdf';
        $MRestMenu = MRestActions::select('*');
        $MRestMenu->where('id', $pdf);
        $lists = $MRestMenu->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getAllMenuPDF($rest = 0, $status = 0) {
        $this->table = 'rest_menu_pdf';
        $MRestMenu = MRestActions::select('*');
        if ($status != 0) {
            $MRestMenu->where('status', 1);
        }
        $MRestMenu->where('rest_ID', $rest);
  
            $lists = $MRestMenu->get();
        
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getAllMenu($rest = 0, $limit = 0) {
        $this->table = 'menu';
        $MRestMenu = MRestActions::select('*');
        $MRestMenu->where('rest_ID', $rest);
        $MRestMenu->orderBy('createdAt');
        if (!empty($limit)) {
            $lists = $MRestMenu->paginate($limit);
        } else {
            $lists = $MRestMenu->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getMenu($menu_id = 0) {
        return DB::table('menu')->where('menu_id', '=', $menu_id)->first();
    }

    function addMenu() {
        $data = array(
            'menu_name' => (Input::get('menu_name')),
            'menu_name_ar' => (Input::get('menu_name_ar')),
            'rest_ID' => Input::get('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('menu')->insertGetId($data);
    }

    function updateMenu() {
        $data = array(
            'menu_name' => (Input::get('menu_name')),
            'menu_name_ar' => (Input::get('menu_name_ar')),
            'rest_ID' => Input::get('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('menu')->where('menu_id', '=', Input::get('menu_id'))->update($data);
    }

    function addMenuCat() {
        $maximum = 0;
        $maximum = DB::table('menu_cat')->where('rest_ID', '=', Input::get('rest_ID'))->where('menu_id', '=', Input::get('menu_id'))->max('listOrder');
        $maximum = $maximum + 1;
        $data = array(
            'menu_id' => (Input::get('menu_id')),
            'cat_name' => (Input::get('cat_name')),
            'cat_name_ar' => (Input::get('cat_name_ar')),
            'rest_ID' => Input::get('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s'),
            'listOrder' => $maximum
        );
        return DB::table('menu_cat')->insertGetId($data);
    }

    function updateMenuCat() {
        $data = array(
            'menu_id' => (Input::get('menu_id')),
            'cat_name' => (Input::get('cat_name')),
            'cat_name_ar' => (Input::get('cat_name_ar')),
            'rest_ID' => Input::get('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('menu_cat')->where('cat_id', '=', Input::get('cat_id'))->update($data);
    }

    function addMenuItem($logo) {
        $data = array(
            'menu_item' => (Input::get('menu_item')),
            'menu_item_ar' => (Input::get('menu_item_ar')),
            'image' => $logo,
            'description' => (Input::get('menuItem_Description')),
            'descriptionAr' => (Input::get('menuItem_Description_Ar')),
            'price' => (Input::get('price')),
            'rest_fk_id' => (Input::get('rest_ID')),
            'cat_id' => (Input::get('cat_id')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('rest_menu')->insertGetId($data);
    }

    function updateMenuItem($logo) {
        $data = array(
            'menu_item' => (Input::get('menu_item')),
            'menu_item_ar' => (Input::get('menu_item_ar')),
            'image' => $logo,
            'description' => (Input::get('menuItem_Description')),
            'descriptionAr' => (Input::get('menuItem_Description_Ar')),
            'price' => (Input::get('price')),
            'rest_fk_id' => (Input::get('rest_ID')),
            'cat_id' => (Input::get('cat_id')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('rest_menu')->where('id', '=', Input::get('id'))->update($data);
    }

    function updateMenuCats($rest_ID, $menu_id) {
        $data = array(
            'menu_id' => $menu_id
        );
        DB::table('menu_cat')->where('rest_ID', '=', $rest_ID)->where('menu_id', '=', '0')->update($data);
    }

    function deleteMenu($menu_id = 0, $rest = 0) {
        DB::table('menu')->where('menu_id', '=', $menu_id)->delete();
        ##MENU CATEGORY
        $records = DB::table('menu_cat')->where('rest_ID', '=', $rest)->where('menu_id', '=', $menu_id)->get();
        if (count($records) > 0) {
            if (is_array($records)) {
                foreach ($records as $value) {
                    $lists = DB::table('rest_menu')->where('rest_fk_id', '=', $rest)->where('cat_id', '=', $value->cat_id)->get();
                    if (count($lists) > 0) {
                        if (is_array($lists)) {
                            foreach ($lists as $item) {
                                DB::table('rest_menu')->where('id', '=', $item->id)->where('rest_fk_id', '=', $rest)->delete();
                            }
                        }
                    }
                    DB::table('menu_cat')->where('cat_id', '=', $value->cat_id)->where('menu_id', '=', $menu_id)->delete();
                }
            }
        }
    }

    function deleteMenuCat($cat_id = 0, $menu_id = 0, $rest = 0) {
        ##MENU CATEGORY
        $lists = DB::table('menu_cat')->where('rest_ID', '=', $rest)->where('cat_id', '=', $cat_id)->where('menu_id', '=', $menu_id)->get();
        if (count($lists) > 0) {
            if (is_array($lists)) {
                foreach ($lists as $value) {
                    $records = DB::table('rest_menu')->where('rest_fk_id', '=', $rest)->where('cat_id', '=', $value->cat_id)->get();
                    if (count($records) > 0) {
                        if (is_array($records)) {
                            foreach ($records as $item) {
                                DB::table('rest_menu')->where('id', '=', $item->id)->where('rest_fk_id', '=', $rest)->delete();
                            }
                        }
                    }
                    DB::table('menu_cat')->where('cat_id', '=', $value->cat_id)->where('menu_id', '=', $menu_id)->delete();
                }
            }
        }
    }

    function deleteMenuItem($item = 0) {
        DB::table('rest_menu')->where('id', '=', $item)->delete();
    }

    function getNewMenuRequest($rest, $is_pdf = 0) {
        if ($is_pdf == 0) {
            $lists = DB::table('rest_menu')->where('rest_fk_id', '=', $rest)->get();
            if (count($lists) > 0) {
                $records = DB::table('menurequest')->where('rest_ID', '=', $rest)->where('is_notified', '=', 0)->get();
                if (count($records) > 0) {
                    return $records;
                }
            }
        } else {
            $lists = DB::table('rest_menu_pdf')->where('rest_ID', '=', $rest)->get();
            if (count($lists) > 0) {
                $res = DB::table('menurequest')->where('rest_ID', '=', $rest)->where('is_notified', '=', 0)->get();
                if (count($res) > 0) {
                    return $res;
                }
            }
        }
        return '';
    }

    function updatePDFMenu($menu = "", $menuar = "", $numPages = 0, $numPagesAr = 0) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (empty($numPages)) {
            $numPages = 0;
        }
        if (empty($numPagesAr)) {
            $numPagesAr = 0;
        }
        $data = array(
            'title' => (Input::get('title')),
            'title_ar' => (Input::get('title_ar')),
            'rest_ID' => (Input::get('rest_ID')),
            'menu' => $menu,
            'menu_ar' => $menuar,
            'pagenumber' => $numPages,
            'pagenumberAr' => $numPagesAr,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('rest_menu_pdf')->where('id', '=', Input::get('id'))->update($data);
    }

    function addPDFMenu($menu = "", $menuar = "", $numPages = 0, $numPagesAr = 0) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (empty($numPages)) {
            $numPages = 0;
        }
        if (empty($numPagesAr)) {
            $numPagesAr = 0;
        }
        $data = array(
            'title' => (Input::get('title')),
            'title_ar' => (Input::get('title_ar')),
            'rest_ID' => (Input::get('rest_ID')),
            'menu' => $menu,
            'menu_ar' => $menuar,
            'pagenumber' => $numPages,
            'pagenumberAr' => $numPagesAr,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('rest_menu_pdf')->insertGetId($data);
    }

    function deleteMenuPDF($pdf) {
        DB::table('rest_menu_pdf')->where('id', '=', $pdf)->delete();
    }

    function deleteRestImage($image) {
        DB::table('image_gallery')->where('image_ID', '=', $image)->delete();
    }

    function getRestImage($image = 0) {
        return DB::table('image_gallery')->where('image_ID', '=', $image)->first();
    }

    function addRestImage($image = "", $ratio = 0, $width = 0) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'title' => (Input::get('title')),
            'title_ar' => (Input::get('title_ar')),
            'rest_ID' => (Input::get('rest_ID')),
            'image_full' => $image,
            'image_thumb' => $image,
            'ratio' => $ratio,
            'width' => $width,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('image_gallery')->insertGetId($data);
    }

    function updateRestImage($image = "", $ratio = 0, $width = 0) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (($ratio == 0) && ($width == 0)) {
            $data = array(
                'title' => (Input::get('title')),
                'title_ar' => (Input::get('title_ar')),
                'rest_ID' => (Input::get('rest_ID')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );
        } else {
            $data = array(
                'title' => (Input::get('title')),
                'title_ar' => (Input::get('title_ar')),
                'rest_ID' => (Input::get('rest_ID')),
                'image_full' => $image,
                'image_thumb' => $image,
                'width' => $width,
                'ratio' => $ratio,
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );
        }
        DB::table('image_gallery')->where('image_ID', '=', Input::get('image_ID'))->update($data);
    }

    function makeFeaturedImage($image, $rest) {
        $alldefault = DB::table('image_gallery')->where('rest_ID', '=', $rest)->where('is_featured', '=', 1)->count();
        if ($alldefault > 0) {
            $data = array('is_featured' => 0, 'updatedAt' => date('Y-m-d H:i:s'));
            DB::table('image_gallery')->where('rest_ID', '=', $rest)->where('is_featured', '=', 1)->update($data);
        }
        $data = array('is_featured' => 1, 'updatedAt' => date('Y-m-d H:i:s'));
        DB::table('image_gallery')->where('image_ID', '=', $image)->where('rest_ID', '=', $rest)->update($data);
    }

    function unsetFeaturedImage($image, $rest) {
        $data = array('is_featured' => 0, 'updatedAt' => date('Y-m-d H:i:s'));
        DB::table('image_gallery')->where('rest_ID', '=', $rest)->where('image_ID', '=', $image)->update($data);
    }

    function getRestaurantCommentsCount($id = 0) {
        if ($id != 0) {
            return DB::table('review')->where('rest_ID', '=', $id)->count();
        }
        return DB::table('review')->count();
    }

    function getRestaurantComments($id = 0) {
        return DB::table('review')->where('rest_ID', '=', $id)->get();
    }

    function restRating($rest = 0) {
        $results = DB::table('rating_info')->where('rest_ID', '=', $rest)->get();
        if (count($results) > 0) {
            $total = 0;
            $food = 0;
            $service = 0;
            $atmosphere = 0;
            $value = 0;
            $variety = 0;
            $presentation = 0;
            $count = 0;
            foreach ($results as $q) {
                $count++;
                $food = $food + $q->rating_Food;
                $service = $service + $q->rating_Service;
                $atmosphere = $atmosphere + $q->rating_Atmosphere;
                $value = $value + $q->rating_Value;
                $variety = $variety + $q->rating_Variety;
                $presentation = $presentation + $q->rating_Presentation;
            }

            $data = array();
            $data['count'] = $count;
            $data['food'] = $food = $food / $count;
            $data['service'] = $service = $service / $count;
            $data['atmosphere'] = $atmosphere = $atmosphere / $count;
            $data['value'] = $value = $value / $count;
            $data['variety'] = $variety = $variety / $count;
            $data['presentation'] = $presentation = $presentation / $count;
            $data['total'] = $total = ($food + $service + $atmosphere + $value + $variety + $presentation) / 6;
            return $data;
        }
    }

    function getAllRestaurantEmails($limit = 0, $member = "", $restaurant = "") {
        $this->table = 'restaurant_info';
        $MRestEmails = MRestActions::select('rest_Name', 'lastUpdatedOn', 'your_Name', 
        DB::raw('( SELECT booking_management.email FROM booking_management WHERE booking_management.rest_id=restaurant_info.rest_ID) as booking'), 
        DB::raw('CONCAT(rest_Email, " ", your_Email) AS email'));
        $MRestEmails->where('rest_Email', '!=', '');
        $MRestEmails->where('rest_Status', '=', '1');
        $MRestEmails->orderBy('rest_Subscription', 'DESC');
        if (!empty($member)) {
            $MRestEmails->where('restaurant_info.rest_Subscription', '=', $member);
        }
        if (!empty($restaurant)) {
            $MRestEmails->where('rest_Name', 'LIKE', $restaurant . '%');
        }
        if (!empty($limit)) {
            $lists = $MRestEmails->paginate($limit);
        } else {
            $lists = $MRestEmails->paginate(100);
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getAllGroupofRestaurants($country = 0, $status = 0, $limit = 0, $name = "") {
        $this->table = "restaurant_groups";
        $MGroupofRestaurants = MRestActions::select('*');
        if (!empty($country)) {
            $MGroupofRestaurants->where('country', '=', $country);
        }
        if ($status == 1) {
            $MGroupofRestaurants->where('status', '=', 1);
        }
        if ($name != "") {
            $MGroupofRestaurants->where('name', 'LIKE', $name . '%');
        }
        $MGroupofRestaurants->orderBy('name', 'DESC');
        if ($limit != "") {
            $lists = $MGroupofRestaurants->paginate($limit);
        } else {
            $lists = $MGroupofRestaurants->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getGroupRestaurant($id) {
        $lists = DB::table('restaurant_groups')->where('id', '=', $id)->first();
        return $lists;
    }

    function addGroupRestaurant($logo = "", $image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug(stripslashes(Input::get('name')), '-');
        $data = array(
            'country' => Session::get('admincountry'),
            'name' => (Input::get('name')),
            'name_ar' => (Input::get('name_ar')),
            'status' => $status,
            'logo' => $logo,
            'image' => $image,
            'url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('restaurant_groups')->insertGetId($data);
    }

    function updateGroupRestaurant($logo = "", $image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug(stripslashes(Input::get('name')), '-');
        $data = array(
            'country' => Session::get('admincountry'),
            'name' => (Input::get('name')),
            'name_ar' => (Input::get('name_ar')),
            'status' => $status,
            'logo' => $logo,
            'image' => $image,
            'url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('restaurant_groups')->where('id', '=', Input::get('id'))->update($data);
    }

    function deleteGroupRestaurant($id) {
        DB::table('restaurant_groups')->where('id', '=', $id)->delete();
    }

    function deleteGroupRestaurantImage($id, $type) {
        if ($type == "logo") {
            $data = array(
                'logo' => ''
            );
        } else {
            $data = array(
                'image' => ''
            );
        }
        DB::table('restaurant_groups')->where('id', '=', $id)->update($data);
    }

    function getAllHotels($country = 0, $status = 0, $limit = 0, $name = "", $sort = "latest") {
        $this->table = "hotel_info";
        $MhotelInfo = MRestActions::select('*');
        if ($country != 0) {
            $MhotelInfo->where('hotel_info.country', '=', $country);
        }
        if ($status != "") {
            $MhotelInfo->where('hotel_info.status', '=', $status);
        }
        if ($name != "") {
            $MhotelInfo->where('hotel_name', 'LIKE', $name . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'name':
                    $MhotelInfo->orderBy('hotel_name', 'DESC');
                    break;
                case 'latest':
                    $MhotelInfo->orderBy('createdAt', 'DESC');
                    break;
            }
        }

        if ($limit != "") {
            $lists = $MhotelInfo->paginate($limit);
        } else {
            $lists = $MhotelInfo->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getHotel($id) {
        return $list = DB::table('hotel_info')->where('id', '=', $id)->first();
    }

    function addhotel($logo = "", $image = "") {
        $status = 0;
        $city = "";
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug(stripslashes(Input::get('hotel_name')), '-');
        if (Input::has('city_id')) {
            $city = implode(",", Input::get('city_id'));
        }
        $data = array(
            'country' => Session::get('admincountry'),
            'hotel_name' => (Input::get('hotel_name')),
            'hotel_name_ar' => (Input::get('hotel_name_ar')),
            'star' => (Input::get('star')),
            'city_id' => $city,
            'status' => $status,
            'hotel_logo' => $logo,
            'image' => $image,
            'url' => $url,
        );
        return DB::table('hotel_info')->insertGetId($data);
    }

    function updatehotel($logo = "", $image = "") {
        $status = 0;
        $city = "";
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = Str::slug(stripslashes(Input::get('hotel_name')), '-');
        if (Input::has('city_id')) {
            $city = implode(",", Input::get('city_id'));
        }
        $data = array(
            'country' => Session::get('admincountry'),
            'hotel_name' => (Input::get('hotel_name')),
            'hotel_name_ar' => (Input::get('hotel_name_ar')),
            'star' => (Input::get('star')),
            'city_id' => $city,
            'status' => $status,
            'hotel_logo' => $logo,
            'image' => $image,
            'url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('hotel_info')->where('id', '=', Input::get('id'))->update($data);
    }

    function deleteHotel($id) {
        DB::table('hotel_info')->where('id', '=', $id)->delete();
    }

    function deleteHotelImage($id, $type) {
        if ($type == "logo") {
            $data = array(
                'hotel_logo' => ''
            );
        } else {
            $data = array(
                'image' => ''
            );
        }
        DB::table('hotel_info')->where('id', '=', $id)->update($data);
    }

    function getAccountDetails($rest = 0) {
        $this->table = 'booking_management';
        $MRestAccountDetails = MRestActions::select('booking_management.*', DB::Raw('subscription.sub_detail,subscription.price,subscription.date_add,subscription.id as sub_id,subscription.allowed_messages'));
        $MRestAccountDetails->where('booking_management.rest_id', '=', $rest);
        $MRestAccountDetails->join('subscription', 'subscription.rest_ID', '=', 'booking_management.rest_id');
        $lists = $MRestAccountDetails->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    public function check_user($restid) {
        $results = DB::table('booking_management')->where('rest_id', '=', $restid)->where('status', '=', 1)->first();
        if (empty($results->rest_id)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function generateInvoice($arr) {
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'rest_ID' => Input::get('rest_ID'),
            'country' => $country,
            'invoice_number' => $arr['invoice_number'],
            'reference_number' => Input::get('reference_number'),
            'account_type' => $arr['account_type'],
            'subscription_price' => $arr['subscription_price'],
            'creative_price' => $arr['creative_price'],
            'advertings_price' => $arr['advertings_price'],
            'discount_price' => $arr['discount_price'],
            'total_price' => $arr['total_price'],
            'payment_option' => Input::get('payment_option'),
            'option_list' => $arr['option_list'],
            'option_value' => $arr['option_value'],
            'down_payment' => $arr['down_payment'],
            'monthly_price' => $arr['monthly_price'],
            'installment_duration' => $arr['installment_duration'],
            'installment_left' => $arr['installment_duration'],
            'invoice_date' => Input::get('invoice_date'),
            'is_draft' => $arr['is_draft']
        );
        $lastInsertId = DB::table('invoice')->insertGetId($data);

        if (Input::has('payment_option') == '2') {
            for ($i = 1; $i <= $arr['installment_duration']; $i++) {
                $invoice_date = "";
                $month = "";
                $invoice_date = date('Y-m-d', strtotime("+" . $i . " months", strtotime(Input::get('invoice_date'))));
                $month = date("F", strtotime($invoice_date));
                $data = array(
                    'rest_ID' => Input::get('rest_ID'),
                    'invoice_id' => $lastInsertId,
                    'invoice_number' => $arr['invoice_number'],
                    'reference_number' => Input::get('reference_number'),
                    'monthly_price' => $arr['monthly_price'],
                    'installment_month' => $month,
                    'invoice_date' => $invoice_date,
                    'country' => $country,
                );
                DB::table('invoice_details')->insert($data);
            }
        }
    }

    function saveInvoice($arr) {
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'rest_ID' => Input::get('rest_ID'),
            'country' => $country,
            'invoice_number' => $arr['invoice_number'],
            'reference_number' => Input::get('reference_number'),
            'account_type' => $arr['account_type'],
            'subscription_price' => $arr['subscription_price'],
            'creative_price' => $arr['creative_price'],
            'advertings_price' => $arr['advertings_price'],
            'discount_price' => $arr['discount_price'],
            'total_price' => $arr['total_price'],
            'payment_option' => Input::get('payment_option'),
            'option_list' => $arr['option_list'],
            'option_value' => $arr['option_value'],
            'down_payment' => $arr['down_payment'],
            'monthly_price' => $arr['monthly_price'],
            'installment_duration' => $arr['installment_duration'],
            'installment_left' => $arr['installment_duration'],
            'invoice_date' => Input::get('invoice_date'),
            'is_draft' => $arr['is_draft']
        );
        DB::table('invoice')->where('id', '=', Input::get('invoiceID'))->where('rest_ID', '=', Input::get('rest_ID'))->update($data);
        $lastInsertId = Input::get('invoiceID');
        DB::table('invoice_details')->where('invoice_id', '=', Input::get('invoiceID'))->delete();

        if (Input::has('payment_option') == '2') {
            for ($i = 1; $i <= $arr['installment_duration']; $i++) {
                $invoice_date = "";
                $month = "";
                $invoice_date = date('Y-m-d', strtotime("+" . $i . " months", strtotime(Input::get('invoice_date'))));
                $month = date("F", strtotime($invoice_date));
                $data = array(
                    'rest_ID' => Input::get('rest_ID'),
                    'country' => $country,
                    'invoice_id' => $lastInsertId,
                    'invoice_number' => $arr['invoice_number'],
                    'reference_number' => Input::get('reference_number'),
                    'monthly_price' => $arr['monthly_price'],
                    'installment_month' => $month,
                    'invoice_date' => $invoice_date
                );
                DB::table('invoice_details')->insert($data);
            }
        }
    }

    function getInvoiceDetails($restID = 0, $invoiceID = 0) {
        $MInvoiceDetails = DB::table('invoice');
        if ($restID != 0) {
            $MInvoiceDetails->where('rest_ID', '=', $restID);
        }
        if ($invoiceID != 0) {
            $MInvoiceDetails->where('id', '=', $invoiceID);
        }
        $MInvoiceDetails->Where(function($query) {
            $query->where('status', '=', 0)
                    ->orWhere('status', '=', 2);
        });

        //$MInvoiceDetails->where('status', '=', 0)->orWhere('status', '=', 2);
        $lists = "";
        $lists = $MInvoiceDetails->first();
        if (count($lists) > 0) {
            return $lists;
        }
    }

    function getMonthlyInvoiceDetails($restID = 0, $invoiceID = 0, $invoice_number = "") {
        $MInvoice = DB::table('invoice_details');
        if ($restID != 0) {
            $MInvoice->where('rest_ID', '=', $restID);
        }

        if ($invoiceID != 0) {
            $MInvoice->where('invoice_id', '=', $invoiceID);
        }

        if ($invoice_number != "") {
            $MInvoice->where('invoice_number', '=', $invoice_number);
        }
        $lists = $MInvoice->get();
        if (count($lists) > 0) {
            return $lists;
        }
    }

    function updateInvoice($invoiceID = 0, $rest_ID = 0, $status = 0) {
        $MInvoice = DB::table('invoice');
        if ($invoiceID != 0) {
            $MInvoice->where('id', '=', $invoiceID);
        }
        if ($rest_ID != 0) {
            $MInvoice->where('rest_ID', '=', $rest_ID);
        }
        $data = array(
            'status' => $status
        );
        $MInvoice->update($data);
    }

    function addFavorite($id = 0) {
        $max = DB::table('restaurant_info')->max('sufrati_favourite');
        $max = $max + 1;
        $data = array(
            'sufrati_favourite' => $max
        );
        DB::table('restaurant_info')->where('rest_ID', '=', $id)->update($data);
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

    function getAllFavourites($country = "", $city = "", $limit = 0, $rest_Name = "", $sort = "", $sortview = "") {
        $mRest = DB::table('restaurant_info');
        if ($rest_Name != "") {
            $mRest->Where('restaurant_info.rest_Name', 'LIKE', $rest_Name . '%');
        }
        if (!empty($country)) {
            $mRest->Where('restaurant_info.country', '=', $country);
        }

        if ($city != "") {
            $mRest->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            $mRest->where('rest_branches.city_ID', '=', $city);
        }
        $mRest->where('restaurant_info.sufrati_favourite', '!=', 0);

        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $mRest->orderBy('restaurant_info.rest_Name', 'ASC');
                    break;
                case 'latest':
                    $mRest->orderBy('restaurant_info.rest_RegisDate', 'DESC');
                    break;
            }
        } elseif (!empty($sortview)) {
            if ($sortview == 2) {
                $mRest->orderBy('restaurant_info.sufrati_favourite', 'DESC');
            } else {
                $mRest->orderBy('restaurant_info.sufrati_favourite', 'ASC');
            }
        } else {
            $mRest->orderBy('restaurant_info.rest_Subscription', 'DESC');
            $mRest->orderBy('restaurant_info.sufrati_favourite', 'DESC');
        }
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

}
