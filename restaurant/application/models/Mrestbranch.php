<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MRestBranch extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function memeberAccountStatus($username, $password)
    {
        $this->db->select('*');
        $this->db->from('booking_management');
        $this->db->where(array('user_name' => $username, 'password' => $password));
        $query = $this->db->get();
        $results = $query->row_array();
        return $results;
    }

    function getOverallRatings($rest_ID)
    {
        $this->db->where('rest_ID', $rest_ID);
        $q = $this->db->get('rating_info');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function get_like_percentage($rest_id)
    {
        $this->db->select("*")->where('rest_ID', $rest_id);
        $q = $this->db->get('likee_info');

        $count = 0;
        if ($q->num_rows() > 0) {
            $res_data = $q->result_Array();
            $total = count($res_data);
            foreach ($res_data as $rows) {
                if ($rows['status'] == 1)
                    $count++;
            }
            return sprintf("%.2f", ($count / $total) * 100);
        } else {
            return $count;
        }
    }
    function get_like_by($rest_id)
    {
        $this->db->select("count(rest_ID) as count")->where(['rest_ID' => $rest_id, "status" => 1]);
        return  $this->db->get('likee_info')->row()->count;
    }
    public function getFavourites($restid)
    {
        return 0;
        ###TABLE REMOVED FROM DB
        //$this->db->select('COUNT(rest_ID) as fovort');
        //$this->db->where('favourite_list.rest_ID', $restid);
        //$query = $this->db->get('favourite_list');
        //$row = $query->row_array();
        //return $row['fovort'];
    }

    public function getTotalComments($restid)
    {
        $this->db->select('COUNT(review_ID) as totrev');
        $this->db->where('review.rest_ID', $restid);
        $query = $this->db->get('review');
        $result = $query->row_array();
        return $result['totrev'];
    }

    public function getTotalNewComments($id, $lastlogin)
    {
        $dt = Date("Y-m-d");
        $this->db->select('COUNT(rest_ID) as totnewrev');
        $this->db->where('rest_ID', $id);
        $this->db->where('is_read', 0);
        $this->db->where('review_Date BETWEEN "' . $lastlogin . '" and  NOW() ');
        $query = $this->db->get('review');
        $results = $query->row_array();
        return $results['totnewrev'];
    }

    public function getTotalNewPhotos($id, $lastlogin)
    {
        $dt = Date("Y-m-d");
        $this->db->select('COUNT(rest_ID) as newphot');
        $this->db->where('rest_ID', $id);
        $this->db->where('user_ID', "")->where('user_ID IS NULL');
        $this->db->where('enter_time BETWEEN "' . $lastlogin . '" and  NOW() ');
        $query = $this->db->get('image_gallery');
        $results = $query->row_array();
        return $results['newphot'];
    }

    public function getTotalNewRatingsNew($id, $lastlogin)
    {
        $dt = Date("Y-m-d");
        $this->db->select('COUNT(rating_ID) as rating');
        $this->db->where('rest_ID', $id);
        $this->db->where('created_at BETWEEN "' . $lastlogin . '" and  NOW() ');
        $query = $this->db->get('rating_info');
        $results = $query->row_array();
        return $results['rating'];
    }

    public function getActivities($id, $limit = "", $offset = "")
    {
        $this->db->where('id_user', $id);
        $this->db->order_by("date_add", "desc");
        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('rest_activity');
        $results = $query->result_array();
        return $results;
    }

    public function getCountActivities($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->count_all_results('rest_activity');
    }

    public function getLatestRatings($id, $status = 0, $limit = "", $offset = "")
    {
        if ($status == 0) {
            $this->db->where('rating_info.is_read', '0');
        }
        $this->db->where('rating_info.rest_ID', $id);
        $this->db->order_by("rating_info.rating_ID", "desc");
        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }
        $q = $this->db->get('rating_info');
        $results = $q->result_array();
        return $results;
    }

    public function getCountLatestRatings($id)
    {
        $this->db->join('user', 'user.user_ID=rating_info.user_ID');
        $this->db->where('rating_info.is_read', '0');
        $this->db->where('rating_info.rest_ID', $id);
        return $this->db->count_all_results('rating_info');
    }

    public function getLatestComments($restid, $status = 0, $limit = "", $offset = "")
    {
        if ($status == 0) {
            $this->db->where('review.is_read', 0);
        }
        $this->db->where('review.rest_ID', $restid);
        $this->db->order_by("review.review_Date", "desc");
        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }
        $q = $this->db->get('review');
        $results = $q->result_array();
        return $results;
    }

    public function getCountLatestComments($restid)
    {
        $this->db->where('review.rest_ID', $restid);
        return $this->db->count_all_results('review');
    }
    public function getCountComments($restid)
    {
        return $this->db->select("count(*) as count")->from("review")->where('rest_ID', $restid)->get()->row()->count;
    }
    public function getRestaurantTimings($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        $q = $this->db->get('open_hours');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    public function getRestaurantDays($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        $q = $this->db->get('rest_weekdays');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function getAllRestTypes($status = 0)
    {
        if ($status == 1) {
            $this->db->where('status', 1);
        }
        $this->db->order_by('name', 'DESC');
        $q = $this->db->get('rest_type');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getRestByUrl($url = "")
    {
        $this->db->where('seo_url', $url);
        $q = $this->db->get('restaurant_info');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function updateRestaurant($logo = "")
    {
        $status = 0;
        $rest = $this->input->post('rest_ID');

        $url = url_title(($this->input->post('rest_Name')), 'dash', TRUE);
        $restByUrl = $this->getRestByUrl($url);
        if ((count($restByUrl) > 0) && ($restByUrl['rest_ID'] != $rest)) {
            $url = $url . rand(1, 10000);
        }
        $rest_Email = $_POST['rest_Email'];
        $rest_Email = implode(",", $rest_Email);
        $data = array(
            /* 'rest_Name' => (($this->input->post('rest_Name'))),
              'rest_Name_Ar' => ($this->input->post('rest_Name_Ar')),
              'seo_url' => $url,
             */
            'rest_Logo' => $logo,
            'rest_Description' => ($this->input->post('rest_Description')),
            'rest_Description_Ar' => ($this->input->post('rest_Description_Ar')),
            'head_office' => ($this->input->post('head_office')),
            'rest_Description' => ($this->input->post('rest_Description')),
            'rest_WebSite' => ($this->input->post('rest_WebSite')),
            'rest_Email' => $rest_Email,
            'facebook_fan' => ($this->input->post('facebook_fan')),
            'head_office' => ($this->input->post('head_office')),
            'rest_Mobile' => ($this->input->post('rest_Mobile')),
            'rest_TollFree' => ($this->input->post('rest_TollFree')),
            'rest_Telephone' => ($this->input->post('rest_Telephone')),
            'rest_pbox' => ($this->input->post('rest_pbox')),
            'opening' => ($this->input->post('opening')),
            'rest_tags' => ($this->input->post('rest_tags')),
            'rest_tags_ar' => ($this->input->post('rest_tags_ar')),
            'lastUpdatedOn' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('rest_ID', $rest);
        $this->db->update('restaurant_info', $data);
    }

    function checkRestCuisine($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        return $this->db->count_all_results('restaurant_cuisine');
    }

    function deleteRestCuisines($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        $this->db->delete('restaurant_cuisine');
    }

    function updateRestCuisines($rest = 0)
    {
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
                $this->db->insert('restaurant_cuisine', $data);
            }
        }
    }

    function checkRestBestFor($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        return $this->db->count_all_results('restaurant_bestfor');
    }

    function deleteRestBestFor($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        $this->db->delete('restaurant_bestfor');
    }

    function updateRestBestFor($rest = 0)
    {
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
                $this->db->insert('restaurant_bestfor', $data);
            }
        }
    }

    function postArraytoCSV($array)
    {
        if (count($array) > 0) {
            $result = "";
            foreach ($array as $value) {
                if ($value == end($array)) {
                    $result .= $value;
                } else {
                    $result .= $value . ",";
                }
            }
            return $result;
        }
    }

    function addOpenHours($rest = 0)
    {
        $weekdays = "";
        $weekends = "";
        $breakfast = "";
        $brunch = "";
        $dinner = "";
        $lunch = "";
        if (isset($_POST['weekdays']) and !empty($_POST['weekdays'])) {
            $weekdays = $this->postArraytoCSV($_POST['weekdays']);
        }
        if (isset($_POST['weekends']) and !empty($_POST['weekends'])) {
            $weekends = $this->postArraytoCSV($_POST['weekends']);
        }
        if (isset($_POST['breakfast']) and !empty($_POST['breakfast'])) {
            $breakfast = $this->postArraytoCSV($_POST['breakfast']);
        }
        if (isset($_POST['brunch']) and !empty($_POST['brunch'])) {
            $brunch = $this->postArraytoCSV($_POST['brunch']);
        }
        if (isset($_POST['lunch']) and !empty($_POST['lunch'])) {
            $lunch = $this->postArraytoCSV($_POST['lunch']);
        }
        if (isset($_POST['dinner']) and !empty($_POST['dinner'])) {
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
        $this->db->insert('rest_weekdays', $data);
        $opendata = array(
            'week_days_start' => ($this->input->post('week_days_start')),
            'week_days_close' => ($this->input->post('week_days_close')),
            'week_ends_start' => ($this->input->post('week_ends_start')),
            'week_ends_close' => ($this->input->post('week_ends_close')),
            'breakfast_start' => ($this->input->post('breakfast_start')),
            'breakfast_close' => ($this->input->post('breakfast_close')),
            'brunch_start' => ($this->input->post('brunch_start')),
            'brunch_close' => ($this->input->post('brunch_close')),
            'lunch_start' => ($this->input->post('lunch_start')),
            'lunch_close' => ($this->input->post('lunch_close')),
            'dinner_start' => ($this->input->post('dinner_start')),
            'dinner_close' => ($this->input->post('dinner_close')),
            'rest_ID' => $rest
        );
        $this->db->insert('open_hours', $opendata);
    }

    function updateOpenHours($rest = 0)
    {
        $weekdays = "";
        $weekends = "";
        $breakfast = "";
        $brunch = "";
        $dinner = "";
        $lunch = "";
        //$this->db->where('rest_ID',$rest);
        //        if($this->db->count_all_results('rest_weekdays')>0){
        //            $this->addOpenHours($rest);
        //            return;
        //        }
        $this->db->where('rest_ID', $rest);
        $q = $this->db->get('rest_weekdays');
        if ($q->num_rows() == 0) {
            $this->addOpenHours($rest);
            return;
        }

        if (isset($_POST['weekdays']) and !empty($_POST['weekdays'])) {
            $weekdays = $this->postArraytoCSV($_POST['weekdays']);
        }
        if (isset($_POST['weekends']) and !empty($_POST['weekends'])) {
            $weekends = $this->postArraytoCSV($_POST['weekends']);
        }
        if (isset($_POST['breakfast']) and !empty($_POST['breakfast'])) {
            $breakfast = $this->postArraytoCSV($_POST['breakfast']);
        }
        if (isset($_POST['brunch']) and !empty($_POST['brunch'])) {
            $brunch = $this->postArraytoCSV($_POST['brunch']);
        }
        if (isset($_POST['lunch']) and !empty($_POST['lunch'])) {
            $lunch = $this->postArraytoCSV($_POST['lunch']);
        }
        if (isset($_POST['dinner']) and !empty($_POST['dinner'])) {
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
        $this->db->where('rest_ID', $rest);
        $this->db->update('rest_weekdays', $data);
        $opendata = array(
            'week_days_start' => ($this->input->post('week_days_start')),
            'week_days_close' => ($this->input->post('week_days_close')),
            'week_ends_start' => ($this->input->post('week_ends_start')),
            'week_ends_close' => ($this->input->post('week_ends_close')),
            'breakfast_start' => ($this->input->post('breakfast_start')),
            'breakfast_close' => ($this->input->post('breakfast_close')),
            'brunch_start' => ($this->input->post('brunch_start')),
            'brunch_close' => ($this->input->post('brunch_close')),
            'lunch_start' => ($this->input->post('lunch_start')),
            'lunch_close' => ($this->input->post('lunch_close')),
            'dinner_start' => ($this->input->post('dinner_start')),
            'dinner_close' => ($this->input->post('dinner_close')),
            'rest_ID' => $rest
        );
        $this->db->where('rest_ID', $rest);
        $this->db->update('open_hours', $opendata);
    }

    function getAllBranches($rest = 0, $city = "", $limit = "", $offset = "", $groupbyFlag = false)
    {
        $this->db->select('rest_branches.*,city_list.city_Name,city_list.city_Name_ar,district_list.district_Name,district_list.district_Name_ar');
        if ($rest != 0) {
            $this->db->where('rest_branches.rest_fk_id', $rest);
        }
        $this->db->where('rest_branches.status', 1);
        if ($city != "") {
            $this->db->where('rest_branches.city_ID', $city);
        }
        $this->db->join('city_list', 'city_list.city_ID=rest_branches.city_ID ');
        $this->db->join('district_list', 'district_list.district_ID=rest_branches.district_ID ', "LEFT"); #Haroon
        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }
        if ($groupbyFlag) {
            $this->db->group_by('rest_branches.city_ID');
        }
        $q = $this->db->get('rest_branches');

        return $q->result_Array();
    }

    function getTotalBranches($rest = 0, $city = "")
    {
        $this->db->where('rest_branches.status', 1);
        if ($rest != 0) {
            $this->db->where('rest_branches.rest_fk_id', $rest);
        }
        if ($city != "") {
            $this->db->where('rest_branches.city_ID', $city);
        }
        return $this->db->count_all_results('rest_branches');
    }

    function getBranch($br = 0)
    {
        $this->db->select('rest_branches.*,city_list.city_Name,city_list.city_Name_Ar,district_list.district_Name,district_list.district_Name_Ar');
        $this->db->where('br_id', $br);
        $this->db->join('city_list', 'city_list.city_ID=rest_branches.city_ID ');
        $this->db->join('district_list', 'district_list.district_ID=rest_branches.district_ID ', 'LEFT');
        $q = $this->db->get('rest_branches');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function getAllHotels($status = 0)
    {
        if ($status != 0) {
            $this->db->where('status', 1);
        }
        $q = $this->db->get('hotel_info');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function updateBranch()
    {
        $status = 1;
        $seating = $features = $mood = "";

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
            'city_ID' => ($this->input->post('city_ID')),
            'district_ID' => ($this->input->post('district_' . $this->input->post('city_ID'))),
            'br_loc' => ($this->input->post('br_loc')),
            'br_loc_ar' => $this->input->post('br_loc_ar'),
            'br_number' => $this->input->post('cityCode') . ' - ' . ($this->input->post('br_number')),
            'rest_fk_id' => ($this->input->post('rest_fk_id')),
            'br_mobile' => ($this->input->post('br_mobile')),
            'br_toll_free' => ($this->input->post('br_tollfree')),
            'latitude' => ($this->input->post('latitude')),
            'longitude' => ($this->input->post('longitude')),
            'zoom' => ($this->input->post('zoom')),
            'branch_type' => ($this->input->post('branch_type')),
            'tot_seats' => ($this->input->post('tot_seats')),
            'seatings' => ($this->input->post('seatings')),
            'seating_rooms' => $seating,
            'features_services' => $features,
            'mood_atmosphere' => $mood,
            'lastUpdated' => Date('Y-m-d h:m:s'),
            'status' => $status
        );
        $this->db->where('br_id', $this->input->posT('br_id'));
        $this->db->update('rest_branches', $data);
    }

    function addBranchHotel($branch)
    {
        $data = array(
            'hotel_id' => ($this->input->post('hotel_value')),
            'rest_id' => $branch
        );
        $this->db->insert('hotel_rest', $data);
    }

    function updateBranchHotel($branch)
    {
        $data = array(
            'hotel_id' => ($this->input->post('hotel_value'))
        );
        $this->db->where('rest_id', $branch);
        $this->db->update('hotel_rest', $data);
    }

    function getHotel($branch)
    {
        $this->db->where('rest_id', $branch);
        $q = $this->db->get('hotel_rest');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function addBranch()
    {
        $status = 1;
        $seating = $features = $mood = "";
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
            'city_ID' => ($this->input->post('city_ID')),
            'district_ID' => ($this->input->post('district_' . $this->input->post('city_ID'))),
            'br_loc' => ($this->input->post('br_loc')),
            'br_loc_ar' => $this->input->post('br_loc_ar'),
            'br_number' => $this->input->post('cityCode') . ' - ' . ($this->input->post('br_number')),
            'rest_fk_id' => ($this->input->post('rest_fk_id')),
            'br_mobile' => ($this->input->post('br_mobile')),
            'br_toll_free' => ($this->input->post('br_tollfree')),
            'latitude' => ($this->input->post('latitude')),
            'longitude' => ($this->input->post('longitude')),
            'zoom' => ($this->input->post('zoom')),
            'branch_type' => ($this->input->post('branch_type')),
            'tot_seats' => ($this->input->post('tot_seats')),
            'seating_rooms' => $seating,
            'features_services' => $features,
            'mood_atmosphere' => $mood,
            'lastUpdated' => Date('Y-m-d h:m:s'),
            'status' => $status
        );

        $this->db->insert('rest_branches', $data);
        return  $this->db->insert_id();
    }

    function updateRest($rest)
    {
        $data = array(
            'lastUpdatedOn' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('rest_ID', $rest);
        $this->db->update('restaurant_info', $data);
    }

    function getAllMenuItems($rest = 0, $cat = 0)
    {
        $this->db->where('rest_fk_id', $rest);
        $this->db->where('cat_id', $cat);
        $q = $this->db->get('rest_menu');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getTotalMenuItems($rest = 0, $cat = 0)
    {
        $this->db->where('rest_fk_id', $rest);
        $this->db->where('cat_id', $cat);
        return $this->db->count_all_results('rest_menu');
    }

    function getMenuCat($menu = 0, $menu_id = "")
    {
        $this->db->where('cat_id', $menu);
        #Haroon
        if ($menu_id != "") {
            $this->db->where('menu_id', $menu_id);
        }
        $q = $this->db->get('menu_cat');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function getAllMenuCats($rest = 0, $limit = 0, $menu_id = "")
    {
        $this->db->where('rest_ID', $rest);
        #Haroon
        if ($menu_id != "") {
            $this->db->where('menu_id', $menu_id);
        }
        if ($limit != 0) {
            $this->db->limit($limit);
        }
        $this->db->order_by('createdAt');
        $q = $this->db->get('menu_cat');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getTotalMenuCats($rest = 0, $menu_id = "")
    {
        $this->db->where('rest_ID', $rest);
        #Haroon
        if ($menu_id != "") {
            $this->db->where('menu_id', $menu_id);
        }
        return $this->db->count_all_results('menu_cat');
    }

    function getAllMenu($rest = 0, $limit = 0)
    {
        $this->db->where('rest_ID', $rest);
        if ($limit != 0) {
            $this->db->limit($limit);
        }
        $this->db->order_by('createdAt');
        $q = $this->db->get('menu');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getTotalMenu($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        return $this->db->count_all_results('menu');
    }

    function getMenu($menu_id = 0)
    {
        $this->db->where('menu_id', $menu_id);
        $q = $this->db->get('menu');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function updateMenu()
    {
        $data = array(
            'menu_name' => ($this->input->post('menu_name')),
            'menu_name_ar' => ($this->input->post('menu_name_ar')),
            'rest_ID' => $this->input->post('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('menu_id', $this->input->post('menu_id'));
        $this->db->update('menu', $data);
    }

    function addMenu()
    {
        $data = array(
            'menu_name' => ($this->input->post('menu_name')),
            'menu_name_ar' => ($this->input->post('menu_name_ar')),
            'rest_ID' => $this->input->post('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->insert('menu', $data);
        return $this->db->insert_id();
    }

    function updateMenuCats($rest_ID, $menu_id)
    {
        $data = array(
            'menu_id' => $menu_id
        );
        $this->db->where('rest_ID', $rest_ID);
        $this->db->where('menu_id', '0');
        $this->db->update('menu_cat', $data);
    }

    function updateMenuCat()
    {
        $data = array(
            'menu_id' => ($this->input->post('menu_id')),
            'cat_name' => ($this->input->post('cat_name')),
            'cat_name_ar' => ($this->input->post('cat_name_ar')),
            'rest_ID' => $this->input->post('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('cat_id', $this->input->post('cat_id'));
        $this->db->update('menu_cat', $data);
    }

    function addMenuCat()
    {
        $data = array(
            'menu_id' => ($this->input->post('menu_id')),
            'cat_name' => ($this->input->post('cat_name')),
            'cat_name_ar' => ($this->input->post('cat_name_ar')),
            'rest_ID' => $this->input->post('rest_ID'),
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->insert('menu_cat', $data);
        return $this->db->insert_id();
    }

    function updateMenuItem($logo = "")
    {
        $data = array(
            'menu_item' => ($this->input->post('menu_item')),
            'menu_item_ar' => ($this->input->post('menu_item_ar')),
            'image' => $logo,
            'description' => ($this->input->post('menuItem_Description')),
            'descriptionAr' => ($this->input->post('menuItem_Description_Ar')),
            'price' => ($this->input->post('price')),
            'rest_fk_id' => ($this->input->post('rest_ID')),
            'cat_id' => ($this->input->post('cat_id')),
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('rest_menu', $data);
    }

    function addMenuItem($logo)
    {
        $data = array(
            'menu_item' => ($this->input->post('menu_item')),
            'menu_item_ar' => ($this->input->post('menu_item_ar')),
            'image' => $logo,
            'description' => ($this->input->post('menuItem_Description')),
            'descriptionAr' => ($this->input->post('menuItem_Description_Ar')),
            'price' => ($this->input->post('price')),
            'rest_fk_id' => ($this->input->post('rest_ID')),
            'cat_id' => ($this->input->post('cat_id')),
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->insert('rest_menu', $data);
        return $this->db->insert_id();
    }

    function getMenuItem($item = 0)
    {
        $this->db->where('id', $item);
        $q = $this->db->get('rest_menu');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function deleteMenu($menu_id = 0, $rest = 0)
    {
        ##MENU TYPE
        $this->db->where('menu_id', $menu_id);
        $this->db->delete('menu');

        ##MENU CATEGORY
        $this->db->where('rest_ID', $rest);
        $this->db->where('menu_id', $menu_id);
        $q = $this->db->get('menu_cat');
        if ($q->num_rows() > 0) {
            $menucats = $q->result_Array();
            if (is_array($menucats)) {
                foreach ($menucats as $value) {
                    $this->db->where('rest_fk_id', $rest);
                    $this->db->where('cat_id', $value['cat_id']);
                    $q = $this->db->get('rest_menu');
                    if ($q->num_rows() > 0) {
                        $menuitems = $q->result_Array();
                        if (is_array($menuitems)) {
                            foreach ($menuitems as $item) {
                                $this->db->where('id', $item['id']);
                                $this->db->where('rest_fk_id', $rest);
                                $this->db->delete('rest_menu');
                            }
                        }
                    }
                    $this->db->where('cat_id', $value['cat_id']);
                    $this->db->where('menu_id', $menu_id);
                    $this->db->delete('menu_cat');
                }
            }
        }
    }

    function deleteMenuItem($item = 0)
    {
        $this->db->where('id', $item);
        $this->db->delete('rest_menu');
    }

    function deleteMenuCat($cat_id = 0, $menu_id = 0, $rest = 0)
    {
        ##MENU CATEGORY
        $this->db->where('rest_ID', $rest);
        $this->db->where('cat_id', $cat_id);
        $this->db->where('menu_id', $menu_id);
        $q = $this->db->get('menu_cat');
        if ($q->num_rows() > 0) {
            $menucats = $q->result_Array();
            if (is_array($menucats)) {
                foreach ($menucats as $value) {
                    $this->db->where('rest_fk_id', $rest);
                    $this->db->where('cat_id', $value['cat_id']);
                    $q = $this->db->get('rest_menu');
                    if ($q->num_rows() > 0) {
                        $menuitems = $q->result_Array();
                        if (is_array($menuitems)) {
                            foreach ($menuitems as $item) {
                                $this->db->where('id', $item['id']);
                                $this->db->where('rest_fk_id', $rest);
                                $this->db->delete('rest_menu');
                            }
                        }
                    }
                    $this->db->where('cat_id', $value['cat_id']);
                    $this->db->where('menu_id', $menu_id);
                    $this->db->delete('menu_cat');
                }
            }
        }
    }

    function getAllMenuPDF($rest = 0, $status = 0)
    {
        if ($status != 0) {
            $this->db->where('status', 1);
        }
        $this->db->where('rest_ID', $rest);
        $q = $this->db->get('rest_menu_pdf');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getTotalMenuPDF($rest = 0, $status = 0)
    {
        if ($status != 0) {
            $this->db->where('status', 1);
        }
        $this->db->where('rest_ID', $rest);
        return $this->db->count_all_results('rest_menu_pdf');
    }

    function getPDFMenu($pdf)
    {
        $this->db->where('id', $pdf);
        $q = $this->db->get('rest_menu_pdf');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function addPDFMenu($menu = "", $menuar = "", $numPages = 0, $numPagesAr = 0)
    {
        $status = 1;
        if (empty($numPages)) {
            $numPages = 0;
        }
        if (empty($numPagesAr)) {
            $numPagesAr = 0;
        }
        $data = array(
            'title' => ($this->input->post('title')),
            'title_ar' => ($this->input->post('title_ar')),
            'rest_ID' => ($this->input->post('rest_ID')),
            'pagenumber' => $numPages,
            'pagenumberAr' => $numPagesAr,
            'status' => $status,
            'menu' => $menu,
            'menu_ar' => $menuar,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->insert('rest_menu_pdf', $data);
        return $this->db->insert_id();
    }

    function updatePDFMenu($menu = "", $menuar = "", $numPages = 0, $numPagesAr = 0)
    {
        $status = 1;
        if (empty($numPages)) {
            $numPages = 0;
        }
        if (empty($numPagesAr)) {
            $numPagesAr = 0;
        }
        $data = array(
            'title' => ($this->input->post('title')),
            'title_ar' => ($this->input->post('title_ar')),
            'rest_ID' => ($this->input->post('rest_ID')),
            'pagenumber' => $numPages,
            'pagenumberAr' => $numPagesAr,
            'status' => $status,
            'menu' => $menu,
            'menu_ar' => $menuar,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('rest_menu_pdf', $data);
    }

    function deleteMenuPDF($pdf)
    {
        $this->db->where('id', $pdf);
        $this->db->delete('rest_menu_pdf');
    }

    public function updateLogo($restimage, $restid)
    {
        $data['rest_Logo'] = $restimage;
        $this->db->where('rest_ID', $restid);
        $this->db->update('restaurant_info', $data);
    }

    function getAllRestImages($rest = 0, $status = 0, $limit = "", $offset = "")
    {

        $this->db->select('image_gallery.title,image_gallery.title_ar,image_gallery.image_full,image_gallery.enter_time,image_gallery.status,image_gallery.rest_ID,image_gallery.user_ID, image_gallery.image_ID, image_gallery.is_read,(SELECT restaurant_info.rest_Name FROM restaurant_info WHERE restaurant_info.rest_ID=image_gallery.rest_ID) as restaurant,image_gallery.is_featured,');
        if ($status != 0) {
            $this->db->where('image_gallery.status', $status);
        }
        if ($rest != 0) {
            $this->db->where('image_gallery.rest_ID', $rest);
        }
        $this->db->where('image_gallery.user_ID IS NULL');
        $this->db->where('image_gallery.branch_ID', '0');

        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('enter_time', 'DESC');
        $q = $this->db->get('image_gallery');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getTotalRestImages($rest = 0, $status = 0)
    {
        if ($status != 0) {
            $this->db->where('status', $status);
        }
        if ($rest != 0) {
            $this->db->where('rest_ID', $rest);
        }
        return $this->db->count_all_results('image_gallery');
    }

    function deleteRestImage($image)
    {
        $this->db->where('image_ID', $image);
        $this->db->delete('image_gallery');
    }

    function getRestImage($image = 0)
    {
        $this->db->where('image_ID', $image);
        $q = $this->db->get('image_gallery');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function updateRestImage($image = "", $ratio = 0, $width = 0)
    {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'title' => ($this->input->post('title')),
            'title_ar' => ($this->input->post('title_ar')),
            'rest_ID' => ($this->input->post('rest_ID')),
            'image_full' => $image,
            'image_thumb' => $image,
            'width' => $width,
            'ratio' => $ratio,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('image_ID', $this->input->post('image_ID'));
        $this->db->update('image_gallery', $data);
    }

    function addRestImage($image = "", $ratio = 0, $width = 0)
    {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'title' => ($this->input->post('title')),
            'title_ar' => ($this->input->post('title_ar')),
            'rest_ID' => ($this->input->post('rest_ID')),
            'image_full' => $image,
            'image_thumb' => $image,
            'ratio' => $ratio,
            'width' => $width,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->insert('image_gallery', $data);
        return $this->db->insert_id();
    }

    function getAllOffers($rest = 0, $status = 0, $limit = 0)
    {
        if ($rest != 0) {
            $this->db->where('rest_ID', $rest);
        }
        if ($status != 0) {
            $this->db->where('status', 1);
        }
        $this->db->order_by('createdAt', 'DESC');
        $query = $this->db->get('rest_offer');
        if ($query->num_rows() > 0) {
            return $query->result_Array();
        }
    }

    function getAllTotalOffers($rest = 0, $status = 0)
    {
        if ($rest != 0) {
            $this->db->where('rest_ID', $rest);
        }
        if ($status != 0) {
            $this->db->where('status', 1);
        }

        return $this->db->count_all_results('rest_offer');
    }

    function getAllOfferCategories($status = 0, $limit = "", $offset = "")
    {
        $this->db->distinct();
        $this->db->select('offer_category.id,offer_category.categoryName,offer_category.categoryNameAr,offer_category.url,offer_category.status');
        if ($status != 0) {
            $this->db->where('offer_category.status', 1);
        }
        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('offer_category.createdAt');
        $query = $this->db->get('offer_category');
        if ($query->num_rows() > 0) {
            return $query->result_Array();
        }
    }

    function getTotalOfferCategories($status = 0)
    {
        $this->db->distinct();
        $this->db->select('offer_category.id,offer_category.categoryName,offer_category.categoryNameAr,offer_category.url,offer_category.status');
        if ($status != 0) {
            $this->db->where('offer_category.status', 1);
        }
        return $this->db->count_all_results('offer_category');
    }

    function getOfferCategory($id)
    {
        $this->db->where('offerID', $id);
        $query = $this->db->get('rest_offer_category');
        if ($query->num_rows() > 0) {
            return $query->result_Array();
        }
    }

    function getOfferBranch($id)
    {
        $this->db->where('offerID', $id);
        $query = $this->db->get('offer_branch');
        if ($query->num_rows() > 0) {
            return $query->result_Array();
        }
    }

    function getOffer($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('rest_offer');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function deleteOffer($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rest_offer');
    }

    function changeOfferStatus($id)
    {
        $data = array();
        $result1 = array('status' => '0');
        $result2 = array('status' => '1');
        $this->db->where('id', $id);
        $query = $this->db->get('rest_offer');
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            if ($data['status'] == '1') {
                $this->db->where('id', $id);
                $this->db->update('rest_offer', $result1);
            } else {
                $this->db->where('id', $id);
                $this->db->update('rest_offer', $result2);
            }
        }
    }

    function addViewOffer($id)
    {
        $query = "UPDATE rest_offer SET views=views+1 WHERE id=$id";
        $this->db->query($query);
    }

    function addOfferCategory($ofrid, $catid)
    {
        $data = array(
            'offerID' => $ofrid,
            'categoryID' => $catid
        );
        $this->db->insert('rest_offer_category', $data);
    }

    function addOfferBranch($ofrid, $brid, $restID)
    {
        $data = array(
            'offerID' => $ofrid,
            'branchID' => $brid,
            'restID' => $restID
        );
        $this->db->insert('offer_branch', $data);
    }

    function deleteOfferCategory($ofrid)
    {
        $this->db->where('offerID', $ofrid);
        $this->db->delete('rest_offer_category');
    }

    function deleteOfferBranch($ofrid)
    {
        $this->db->where('offerID', $ofrid);
        $this->db->delete('offer_branch');
    }

    function addOffer($image, $imageAr)
    {
        if (isset($_POST['status']))
            $status = 1;
        else
            $status = 0;
        $data = array(
            'rest_ID' => ($this->input->post('rest_ID')),
            'offerName' => ($this->input->post('offerName')),
            'offerNameAr' => ($this->input->post('offerNameAr')),
            'shortDesc' => $this->input->post('shortDesc'),
            'shortDescAr' => $this->input->post('shortDescAr'),
            'longDesc' => htmlentities($this->input->post('longDesc')),
            'longDescAr' => $this->input->post('longDescAr'),
            'image' => $image,
            'imageAr' => $imageAr,
            'startDate' => ($this->input->post('startDate')),
            'endDate' => ($this->input->post('endDate')),
            'startTime' => ($this->input->post('startTime')),
            'endTime' => ($this->input->post('endTime')),
            'terms' => htmlentities($this->input->post('terms')),
            'termsAr' => addslashes($this->input->post('termsAr')),
            'contactEmail' => ($this->input->post('contactEmail')),
            'contactPhone' => ($this->input->post('contactPhone')),
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->insert('rest_offer', $data);
        $ofrid = $this->db->insert_id();
        $cat = array();
        $br = array();
        if (isset($_POST['offerCategory'])) {
            $cat = $_POST['offerCategory'];
            for ($i = 0; $i < count($cat); $i++) {
                $this->addOfferCategory($ofrid, $cat[$i]);
            }
        }
        if (isset($_POST['restBranches'])) {
            $br = $_POST['restBranches'];
            $restid = rest_id();
            if ((count($br) == 1) && ($br[0] == 'all')) {
                $branchq = $this->db->select("*")->from("rest_branches")->where('rest_fk_id', $restid)->get()->result();
                foreach ($branchq as $br) {
                    $this->addOfferBranch($ofrid, $br->br_id, rest_id());
                }
            } else {
                for ($i = 0; $i < count($br); $i++) {
                    $this->addOfferBranch($ofrid, $br[$i], rest_id());
                }
            }
        }
        return $ofrid;
    }

    function updateOffer($image, $imageAr)
    {
        if (isset($_POST['status']))
            $status = 1;
        else
            $status = 0;
        $data = array(
            'rest_ID' => rest_id(),
            'offerName' => ($this->input->post('offerName')),
            'offerNameAr' => ($this->input->post('offerNameAr')),
            'shortDesc' => ($this->input->post('shortDesc')),
            'shortDescAr' => ($this->input->post('shortDescAr')),
            'longDesc' => addslashes($this->input->post('longDesc')),
            'longDescAr' => addslashes($this->input->post('longDescAr')),
            'image' => $image,
            'imageAr' => $imageAr,
            'startDate' => ($this->input->post('startDate')),
            'endDate' => ($this->input->post('endDate')),
            'startTime' => ($this->input->post('startTime')),
            'endTime' => ($this->input->post('endTime')),
            'terms' => addslashes($this->input->post('terms')),
            'termsAr' => addslashes($this->input->post('termsAr')),
            'contactEmail' => ($this->input->post('contactEmail')),
            'contactPhone' => ($this->input->post('contactPhone')),
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );

        $this->db->where('id', $_POST['id']);
        $this->db->update('rest_offer', $data);
        $ofrid = $_POST['id'];
        $this->deleteOfferCategory($ofrid);
        $this->deleteOfferBranch($ofrid);
        $cat = array();
        $restid = $this->input->post('rest_ID');
        $br = array();
        if (isset($_POST['offerCategory'])) {
            $cat = $_POST['offerCategory'];
            for ($i = 0; $i < count($cat); $i++) {
                $this->addOfferCategory($ofrid, $cat[$i]);
            }
        }
        if (isset($_POST['restBranches'])) {
            $br = $_POST['restBranches'];
            if ((count($br) == 1) && ($br[0] == 'all')) {
                $branchq = $this->db->select("*")->from("rest_branches")->where('rest_fk_id', $restid)->get()->result();
                foreach ($branchq as $br) {
                    $this->addOfferBranch($ofrid, $br->br_id, rest_id());
                }
            } else {
                for ($i = 0; $i < count($br); $i++) {
                    $this->addOfferBranch($ofrid, $br[$i], rest_id());
                }
            }
        }
    }

    function getAccountDetails($rest = 0)
    {
        $this->db->select('booking_management.*,subscription.sub_detail,subscription.price,subscription.date_add,subscription.id as sub_id, subscription.allowed_messages');
        $this->db->where('booking_management.rest_id', $rest);
        $this->db->join('subscription', 'subscription.rest_ID=booking_management.rest_id', 'left');
        $q = $this->db->get('booking_management');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function updateMemberContacts()
    {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $emails = "";
        if (isset($_POST['emails'])) {
            $emails = implode(',', $_POST['emails']);
        }
        $data = array(
            'full_name' => ($this->input->post('full_name')),
            'email' => $emails,
            'phone' => ($this->input->post('phone')),
            'status' => $status,
            'preferredlang' => ($this->input->post('preferredlang'))
        );
        $where['rest_id'] = $this->input->post('rest_ID');
        $where['id_user'] = $this->input->post('id_user');
        $this->db->where($where);
        $this->db->update('booking_management', $data);
    }

    public function getUserComment($userid, $reviewId)
    {
        $this->db->where(array('review.user_ID' => $userid, 'review.review_ID' => $reviewId));
        $query = $this->db->get('review');
        $result = $query->row_array();
        return $result;
    }

    function getUser($user)
    {
        //$userdb = $this->load->database('user', TRUE);
        $this->db->where('user_ID', $user);
        $q = $this->db->get('user');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function getUserName($user)
    {
        //$userdb = $this->load->database('user', TRUE);
        $this->db->where('user_ID', $user);
        $q = $this->db->get('user');
        if ($q->num_rows() > 0) {
            $user_info = $q->row_Array();
            $name = "";
            if ($user_info['user_NickName'] != "") {
                $name = $user_info['user_NickName'];
            } else {
                $name = $user_info['user_FullName'];
            }
            return $name;
        }
    }

    function getLatestUploads($rest, $status = 0, $limit = "", $offset = "")
    {
        $this->db->select('image_gallery.image_full,image_gallery.enter_time,image_gallery.image_ID, image_gallery.is_read, image_gallery.status, image_gallery.user_ID,restaurant_info.rest_Name');
        $this->db->join('restaurant_info', 'restaurant_info.rest_ID=image_gallery.rest_ID');
        $this->db->where('image_gallery.user_ID IS NOT NULL');
        if ($status == 0) {
            $this->db->where('image_gallery.is_read', 0);
        }
        $this->db->where('restaurant_info.rest_ID', $rest);
        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('image_gallery.enter_time', 'DESC');
        $q = $this->db->get('image_gallery');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getTotalLatestUploads($rest)
    {
        $this->db->join('restaurant_info', 'restaurant_info.rest_ID=image_gallery.rest_ID');
        $this->db->where('image_gallery.is_read', 0)->where('image_gallery.user_ID IS NOT NULL');
        $this->db->where('restaurant_info.rest_ID', $rest);
        return $this->db->count_all_results('image_gallery');
    }

    function getUserGalleryImage($id = 0)
    {
        $this->db->where('image_ID', $id);
        $q = $this->db->get('image_gallery');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function deActivateUserGalleryImage($id = 0)
    {
        $data = array(
            'status' => 0,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('image_ID', $id);
        $this->db->update('image_gallery', $data);
    }

    function activateUserGalleryImage($id = 0)
    {
        $data = array(
            'status' => 1,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('image_ID IN ( ' . $id . ' )');
        $this->db->update('image_gallery', $data);
    }

    function getRestaurantComments($new = 0, $status = 0, $rest_ID = 0)
    {
        if ($rest_ID != 0) {
            $this->db->where('rest_ID', $rest_ID);
        }
        if ($new != 0) {
            $this->db->where('is_read', 0);
        }
        return $this->db->count_all_results('review');
    }

    function getRestaurantComment($id = 0)
    {
        $this->db->where('review_ID', $id);
        $q = $this->db->get('review');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function activateRestComment($id = 0)
    {
        $data = array(
            'review_Status' => 1
        );
        $this->db->where('review_ID IN ( ' . $id . ' ) ');
        $this->db->update('review', $data);
    }

    function deActivateRestComment($id = 0)
    {
        $data = array(
            'review_Status' => 0
        );
        $this->db->where('review_ID', $id);
        $this->db->update('review', $data);
    }

    public function savecommentreply($restid = 0)
    {
        $data = "";
        $data['rest_ID'] = $restid;
        $data['user_ID'] = $_POST['user_ID'];
        $data['review_ID'] = $_POST['review_ID'];
        $data['reply_msg'] = $_POST['replymsg'];
        $true = $this->db->insert('commentreply', $data);
    }

    public function getMemberEmail($id)
    {
        $this->db->select('full_name,phone,email,referenceNo');
        $this->db->from('booking_management');
        $this->db->where('id_user', $id);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }

    public function getRestAllImages($id)
    {
        $this->db->where('rest_ID', $id);
        $this->db->where('image_gallery.branch_ID', 0);
        $this->db->where('image_gallery.user_ID IS NULL');
        return $this->db->count_all_results('image_gallery');
    }

    function getBranchImages($br_id = 0, $status = 0, $limit = "", $offset = "")
    {
        if ($status != 0) {
            $this->db->where('image_gallery.status', $status);
        }

        $this->db->where('image_gallery.branch_ID', $br_id);
        $this->db->where('image_gallery.rest_ID >', 0);
        if ($limit != "") {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('enter_time', 'DESC');
        $q = $this->db->get('image_gallery');

        return $q->result_Array();
    }

    function addBranchImage($image = "", $title, $title_ar, $ratio = 0, $width = 0)
    {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (($ratio != 0) && ($width != 0)) {
            $data = array(
                'title' => $title,
                'title_ar' => $title_ar,
                'rest_ID' => ($this->input->post('rest_fk_id')),
                'branch_ID' => ($this->input->post('br_id')),
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
                'rest_ID' => ($this->input->post('rest_fk_id')),
                'branch_ID' => ($this->input->post('br_id')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );
        }

        $this->db->insert('image_gallery', $data);
    }

    function updateBranchImage($image_ID, $image = "", $title, $title_ar, $ratio = 0, $width = 0)
    {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (($ratio != 0) && ($width != 0)) {
            $data = array(
                'title' => $title,
                'title_ar' => $title_ar,
                'rest_ID' => ($this->input->post('rest_fk_id')),
                'branch_ID' => ($this->input->post('br_id')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'width' => $width,
                'ratio' => $ratio,
                'updatedAt' => date('Y-m-d H:i:s', now())
            );
        }
        if (($ratio == 0) && ($width == 0)) {
            $data = array(
                'title' => $title,
                'title_ar' => $title_ar,
                'rest_ID' => ($this->input->post('rest_fk_id')),
                'branch_ID' => ($this->input->post('br_id')),
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s', now())
            );
        }
        $this->db->where('image_ID', $image_ID);
        $this->db->update('image_gallery', $data);
    }

    function addNotification($user, $activity, $activity_text, $activity_text_ar)
    {
        //$userdb = $this->load->database('user', TRUE);
        $data = array(
            'user_ID' => $user,
            'activity_ID' => $activity,
            'activity_text' => $activity_text,
            'activity_text_ar' => $activity_text_ar
        );
        $this->db->insert('user_notifications', $data);
    }

    function makeFeaturedImage($image, $rest)
    {
        $this->db->where('rest_ID', $rest)->where('is_featured', 1);
        $alldefault = $this->db->count_all_results('image_gallery');
        if ($alldefault > 0) {
            $data = array('is_featured' => 0);
            $this->db->where('rest_ID', $rest)->where('is_featured', 1);
            $this->db->update('image_gallery', $data);
        }
        $data = array('is_featured' => 1);
        $this->db->where('image_ID', $image)->where('rest_ID', $rest);
        $this->db->update('image_gallery', $data);
    }

    function unsetAsFeaturedImage($image, $rest)
    {
        $data = array('is_featured' => 0);
        $this->db->where('rest_ID', $rest)->where('image_ID', $image);
        $this->db->update('image_gallery', $data);
    }

    function deleteUserGalleryImage($image)
    {
        $this->db->where('image_ID', $image);
        $this->db->delete('image_gallery');
    }

    public function getTotalRecommendation($id, $lastlogin)
    {
        $this->db->where('rest_ID', $id);
        $this->db->where('recommend', 1);
        return $this->db->count_all_results('review');
    }

    function getLikeUsers($rest = 0, $sortby = "", $audienceType = 0, $recipients = "")
    {
        return [];
        $where['d.rest_ID'] = rest_id();
        $c_name = sys_lang() == "arabic" ? "city_Name_ar" : "city_Name";
        $stmt = $this->db->select('user.*');
        $stmt = $this->db->select("c.$c_name as city_name,d.*");
        $this->db->from("user as user");
        $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
        $this->db->join("city_list as c", "user.user_City=c.city_ID", "left");
        $this->db->order_by("d.createdAt", "desc");
        $this->db->where($where);
        return $this->db->get()->result();
    }

    function getLikePercentage($rest = 0, $number = 0)
    {
        if ($rest != 0) {
            $this->db->where('rest_ID', $rest);
            $total = $this->db->count_all_results('likee_info');
            if ($total > 0) {
                if ($number == 0) {
                    $this->db->where('rest_ID', $rest);
                    $this->db->where('status', 1);
                    $count = $this->db->count_all_results('likee_info');
                    return round(($count / $total) * 100, 0);
                } else {
                    return $total;
                }
            } else
                return 0;
        } else {
            return 0;
        }
    }

    function addDinerMessage($rest = 0, $total_receiver = 0, $recipients = "", $image = "")
    {
        $status = 0;
        $data = array(
            'subject' => ($this->input->post('subject')),
            'message' => ($this->input->post('message')),
            'audienceType' => $this->input->post('audienceType'),
            'recipients' => $recipients,
            'total_receiver' => $total_receiver,
            'rest_ID' => $rest,
            'status' => $status,
            'image' => $image,
            "country" => 0,
            'date' => date('Y-m-d', now()),
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->insert('dinermessage', $data);
        return $this->db->insert_id();
    }

    function updateDinerMessage($id, $rest = 0, $total_receiver = 0, $recipients = "", $image = "")
    {
        $status = $this->input->post('status');
        $data = array(
            'subject' => ($this->input->post('subject')),
            'message' => ($this->input->post('message')),
            'audienceType' => $this->input->post('audienceType'),
            'recipients' => $recipients,
            'total_receiver' => $total_receiver,
            'rest_ID' => $rest,
            'status' => $status,
            'image' => $image,
            'updatedAt' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('id', $id);
        $this->db->update('dinermessage', $data);
        return $this->db->insert_id();
    }

    function updateSendStatusDinerMessage($id)
    {
        $status = 1;
        $data = array(
            'status' => $status,
            'send_status' => $status,
            'sendTime' => date('Y-m-d H:i:s', now())
        );
        $this->db->where('id', $id);
        $this->db->update('dinermessage', $data);
        return $this->db->insert_id();
    }

    function getDinerMessage($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('dinermessage');
    
            return $q->row_Array();
        
    }

    function getAllDinerMessages($rest = 0)
    {
        $this->db->where('rest_ID', $rest);
        $this->db->order_by('createdAt', 'DESC');
        $query = $this->db->get('dinermessage');
        if ($query->num_rows() > 0) {
            return $query->result_Array();
        }
    }

    function updateAllowedMessage($rest, $allowed_messages)
    {
        $data = array(
            'allowed_messages' => $allowed_messages
        );
        $this->db->where('rest_ID', $rest);
        $this->db->update('subscription', $data);
    }

    function deleteBranch($id)
    {
        $this->db->where('br_id', $id)->delete('rest_branches');
    }
    public function getCountDiners($rest_id)
    {
        $where['rest_ID'] = intval($rest_id);
        return   $this->db->select("count(f.id) as count")->from("likee_info as f")->join("user as u", "u.user_ID=f.user_ID")->where($where)->get()->row()->count;
    }
}
