<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MGeneral extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getSettings()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function getSiteName($lang = 'en')
    {
        $this->db->select('name,nameAr');
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            $data = $q->row_Array();
            if ($lang == 'en') {
                return $data['name'];
            } else {
                return $data['nameAr'];
            }
        }
    }

    function getLogo()
    {
        $this->db->where('art_work_name', 'Sufrati Logo')->where('active', 1);
        $q = $this->db->get('art_work');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    public function memberinfo($name)
    {
        $this->db->select('booking_management.id_user,booking_management.full_name,booking_management.email,booking_management.rest_id,booking_management.user_name,booking_management.phone,booking_management.password,restaurant_info.rest_Subscription,restaurant_info.member_duration,restaurant_info.rest_Name,restaurant_info.your_Name,restaurant_info.your_Position,restaurant_info.rest_Name_Ar');
        $this->db->join('restaurant_info', 'restaurant_info.rest_ID=booking_management.rest_id');
        $this->db->where(array('booking_management.user_name' => $name));
        $q = $this->db->get('booking_management');
        $results = "";
        if ($q->num_rows() > 0) {
            $results = $q->row_Array();
        }
        return $results;
    }

    public function accountDuration($id)
    {
        $this->db->where('rest_ID', $id);
        $query = $this->db->get('subscription');
        $row = $query->row_array();
        return $row;
    }

    public function firstLogin($userid)
    {
        $this->db->select("COUNT(id_user) AS userid");
        $this->db->from('clientlogging');
        $this->db->where('id_user', $userid);
        $query = $this->db->get();
        $row = $query->row_array();
        if ($row['userid'] == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insertlogin($id)
    {
        $this->db_array = "";
        date_default_timezone_set('Asia/Riyadh');
        $this->db_array['id_user'] = $id;
        $this->db_array['lastlogin'] = Date('Y-m-d H:i:s');

        if ($this->db->insert('clientlogging', $this->db_array)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateAccount($restid)
    {
        $data = "";
        $data['date_upd'] = Date('Y-m-n h:m:s');
        $data['sub_detail'] = "1,2,3,6";
        $data['accountType'] = 0;

        $this->db->where('rest_ID', $restid);
        $true = $this->db->update('subscription', $data);
    }

    public function updateDuration($restid)
    {
        $data = "";
        $data['rest_Subscription'] = 0; //Free Subscription
        $data['member_duration'] = 0;
        $data['is_account_expire'] = 1;
        $this->db->where('rest_ID', $restid);
        $true = $this->db->update('restaurant_info', $data);
    }

    public function getRest($id = 0, $min = false, $fav = false)
    {
        if ($min == TRUE) {
            $this->db->select('rest_ID,rest_Name,rest_Name_Ar,rest_Logo,seo_url');
        }
        if ($fav) {
            $this->db->select('restaurant_info.*,');
        }
        $this->db->select("( SELECT city_Name FROM city_list INNER JOIN rest_branches ON rest_branches.city_ID = city_list.city_ID WHERE rest_branches.rest_fk_id = restaurant_info.rest_ID LIMIT 1 ) AS city");
        $this->db->where('rest_ID', $id);
        $q = $this->db->get('restaurant_info');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    public function getLastLogin($id)
    {
        $this->db->select('lastlogin');
        $this->db->where('id_user', $id);
        $this->db->order_by('lastlogin', 'DESC');
        $q = $this->db->get('clientlogging');
        $results = $q->row_array();
        if (empty($results)) {
            $results['lastlogin'] = Date('Y-m-d H:i:s');
        }
        return $results['lastlogin'];
    }

    function getRestaurantCuisines($rest = 0, $limit = "", $name = 0, $lang = "en")
    {
        $this->db->distinct();
        if ($name == 0) {
            $this->db->select('cuisine_list.*');
        } else {
            $this->db->select('cuisine_list.cuisine_Name,cuisine_list.cuisine_Name_Ar');
        }
        $this->db->where('restaurant_cuisine.rest_ID', $rest);
        $this->db->join('cuisine_list', 'cuisine_list.cuisine_ID=restaurant_cuisine.cuisine_ID AND cuisine_list.cuisine_Status=1');
        $this->db->order_by('cuisine_list.cuisine_Name', 'DESC');
        if ($limit != "") {
            $this->db->limit($limit);
        }
        $q = $this->db->get('restaurant_cuisine');
        if ($q->num_rows() > 0) {
            if ($name == 0) {
                return $q->result_Array();
            } else {
                $cuisine = "";
                $i = 0;
                foreach ($q->result_Array() as $row) {
                    $i++;
                    if ($lang == "en") {
                        $cuisine .= $row['cuisine_Name'];
                    } else {
                        $cuisine .= $row['cuisine_Name_Ar'];
                    }
                    if ($i != $q->num_rows()) {
                        $cuisine .= ", ";
                    }
                }
                return $cuisine;
            }
        }
    }

    function getRestaurantBestFors($rest = 0, $limit = "", $name = 0, $lang = "en")
    {
        $this->db->distinct();
        if ($name == 0) {
            $this->db->select('bestfor_list.*');
        } else {
            $this->db->select('bestfor_list.bestfor_Name,bestfor_list.bestfor_Name_Ar');
        }
        $this->db->where('restaurant_bestfor.rest_ID', $rest);
        $this->db->join('bestfor_list', 'bestfor_list.bestfor_ID=restaurant_bestfor.bestfor_ID AND bestfor_list.bestfor_Status=1');
        $this->db->order_by('bestfor_list.bestfor_Name', 'DESC');
        if ($limit != "") {
            $this->db->limit($limit);
        }
        $q = $this->db->get('restaurant_bestfor');
        if ($q->num_rows() > 0) {
            if ($name == 0) {
                return $q->result_Array();
            } else {
                $bestfor = "";
                $i = 0;
                foreach ($q->result_Array() as $row) {
                    $i++;
                    if ($lang == "en") {
                        $bestfor .= $row['bestfor_Name'];
                    } else {
                        $bestfor .= $row['bestfor_Name_Ar'];
                    }
                    if ($i != $q->num_rows()) {
                        $bestfor .= ", ";
                    }
                }
                return $bestfor;
            }
        }
    }

    function getAllBestFor($status = 0, $city = 0)
    {
        if ($status == 1) {
            $this->db->where('bestfor_Status', 1);
        }
        if ($city != 0) {
            $this->db->join('restaurant_bestfor', 'restaurant_bestfor.bestfor_ID=bestfor_list.bestfor_ID');
            $this->db->join('rest_branches', 'rest_branches.rest_fk_id=restaurant_bestfor.rest_ID AND rest_branches.city_ID=' . $city);
            $this->db->join('restaurant_info', 'restaurant_info.rest_ID=rest_branches.rest_fk_id');
            $this->db->where('restaurant_info.rest_Status', 1);
            $this->db->group_by('bestfor_list.bestfor_ID');
        }
        $this->db->order_by('bestfor_Name');
        $q = $this->db->get('bestfor_list');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getAllCuisine($status = 0, $city = 0)
    {
        $this->db->select('cuisine_list.cuisine_Name,cuisine_list.cuisine_Name_ar,cuisine_list.seo_url,cuisine_list.cuisine_ID');
        if ($status == 1) {
            $this->db->where('cuisine_Status', 1);
        }
        if ($city != 0) {
            $this->db->join('restaurant_cuisine', 'restaurant_cuisine.cuisine_ID=cuisine_list.cuisine_ID');
            $this->db->join('rest_branches', 'rest_branches.rest_fk_id=restaurant_cuisine.rest_ID AND rest_branches.city_ID=' . $city);
            $this->db->join('restaurant_info', 'restaurant_info.rest_ID=rest_branches.rest_fk_id');
            $this->db->where('restaurant_info.rest_Status', 1);
            $this->db->group_by('cuisine_list.cuisine_ID');
        }
        $this->db->order_by('cuisine_Name');
        $q = $this->db->get('cuisine_list');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function addActivity($activity, $activity_id = 0)
    {
        $data = array();
        $data['id_user'] = $this->session->userdata('id_user');
        $data['rest_ID'] = $this->session->userdata('rest_id');
        $data['langid'] = $this->session->userdata('language');
        $data['activity'] = $activity;
        $data['activity_ID'] = $activity_id;
        $this->db->insert('rest_activity', $data);
    }

    function getCity($city = 0)
    {
        $this->db->where('city_ID', $city);
        $q = $this->db->get('city_list');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function getAllCity($status = 0, $country = 0)
    {
        if ($status == 1) {
            $this->db->where('city_Status', 1);
        }

        if (!empty($country)) {
            $this->db->where('country', $country);
        }
        $this->db->order_by('city_Name');
        $q = $this->db->get('city_list');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getCityDistricts($city = 0, $status = "")
    {
        if ($city != 0) {
            $this->db->where('city_ID', $city);
        }
        if ($status != "") {
            $this->db->where('district_Status', $status);
        }
        $this->db->order_by('district_Name', 'ASC');
        $q = $this->db->get('district_list');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function uploadImage($name, $directory)
    {
        $uploadDir = $directory;
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $file = str_replace(' ', '_', $_FILES[$name]['name']);

            $rand = rand(0, 10000 - 1);
            $date = date('YmdHis');
            $file_name = $_FILES[$name]['name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $new_filename = $rand . $date . "." . $file_ext;
            $uploadFile_1 = uniqid('sufrati') . $new_filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1)) {
                // successfully uploaded"
            } else {
                return null;
            }
            return $uploadFile_1;
        } else
            return null;
    }

    function ago($datefrom = 0, $dateto = -1)
    {
        if ($datefrom == 0) {
            return "A long time ago";
        }
        $date = new DateTime(null, new DateTimeZone('Asia/Riyadh'));
        if ($dateto == -1) {
            $dateto = strtotime($date->format("Y-m-d H:i:s"));
        }
        // Make the entered date into Unix timestamp from MySQL datetime field
        $datefrom = strtotime($datefrom);
        // Calculate the difference in seconds betweeen
        $difference = $dateto - $datefrom;
        // Based on the interval,Find the difference
        switch (true) {
                // Seconds
            case (strtotime('-1 min', $dateto) < $datefrom):
                $datediff = $difference;
                $res = ($datediff == 1) ? $datediff . ' second ago' : $datediff . ' seconds ago';
                break;
                // Minutes
            case (strtotime('-1 hour', $dateto) < $datefrom):
                $datediff = floor($difference / 60);
                $res = ($datediff == 1) ? $datediff . ' minute ago' : $datediff . ' minutes ago';
                break;
                // Hours
            case (strtotime('-1 day', $dateto) < $datefrom):
                $datediff = floor($difference / 60 / 60);
                $res = ($datediff == 1) ? $datediff . ' hour ago' : $datediff . ' hours ago';
                break;
                // Days
            case (strtotime('-1 week', $dateto) < $datefrom):
                $day_difference = 1;
                while (strtotime('-' . $day_difference . ' day', $dateto) >= $datefrom) {
                    $day_difference++;
                }
                $datediff = $day_difference;
                $res = ($datediff == 1) ? 'yesterday' : $datediff . ' days ago';
                break;
                // Weeks      
            case (strtotime('-1 month', $dateto) < $datefrom):
                $week_difference = 1;
                while (strtotime('-' . $week_difference . ' week', $dateto) >= $datefrom) {
                    $week_difference++;
                }
                $datediff = $week_difference;
                $res = ($datediff == 1) ? 'last week' : $datediff . ' weeks ago';
                break;
                // Months
            case (strtotime('-1 year', $dateto) < $datefrom):
                $months_difference = 1;
                while (strtotime('-' . $months_difference . ' month', $dateto) >= $datefrom) {
                    $months_difference++;
                }
                $datediff = $months_difference;
                $res = ($datediff == 1) ? $datediff . ' month ago' : $datediff . ' months ago';
                break;
                // Years
            case (strtotime('-1 year', $dateto) >= $datefrom):
                $year_difference = 1;
                while (strtotime('-' . $year_difference . ' year', $dateto) >= $datefrom) {
                    $year_difference++;
                }
                $datediff = $year_difference;
                $res = ($datediff == 1) ? $datediff . ' year ago' : $datediff . ' years ago';
                break;
        }
        return $res;
    }

    function addUserActivity($user, $rest, $activity, $activityAr, $activityID)
    {
        $data = array(
            'user_ID' => $user,
            'rest_ID' => $rest,
            'activity' => $activity,
            'activity_ar' => $activityAr,
            'activity_ID' => $activityID
        );
        $this->db->insert('user_activity', $data);
        return $this->db->insert_id();
    }

    function getAllUsersCommentedOnRest($user_ID, $rest_ID)
    {
        $this->db->where('rest_ID', $rest_ID);
        $this->db->where('review_Status', 1);
        $this->db->where('user_ID != ', $user_ID);
        $q = $this->db->get('review');
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
    }

    function checkNotificationStatus($user)
    {
        //$userdb = $this->load->database('user', TRUE);  
        $this->db->where('user_ID', $user);
        $q = $this->db->get('notifications');
        if ($q->num_rows() > 0) {
            $n = $q->row_Array();
            if ($n['status'] == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function getAdminDetails($email, $restid)
    {
        $this->db->select('booking_management.id_user,booking_management.user_name,booking_management.password,booking_management.full_name,booking_management.email,restaurant_info.rest_Name');
        $this->db->join('restaurant_info', 'restaurant_info.rest_ID=booking_management.rest_id');
        $this->db->where('restaurant_info.rest_ID', $restid);
        $this->db->like('booking_management.email', $email, 'both');
        $q = $this->db->get('booking_management');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    public function getRestByName($restName)
    {
        $this->db->like('rest_Name', $restName, 'both');
        $q = $this->db->get('restaurant_info');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function getRestType($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('rest_type');
        $results = $query->row_array();
        return $results;
    }

    function convertToArabic($var)
    {
        $digit = (string) $var;
        if (empty($digit))
            return '.';
        $ar_digit = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '-' => '-', ' ' => ' ', '.' => '.');
        $arabic_digit = '';
        $length = strlen($digit);
        for ($i = 0; $i < $length; $i++) {
            if (isset($ar_digit[$digit[$i]]))
                $arabic_digit .= $ar_digit[$digit[$i]];
            else
                $arabic_digit .= $digit[$i];
        }
        return $arabic_digit;
    }

    function readUserComment($id = 0)
    {
        $data = array(
            'is_read' => 1
        );
        $this->db->where('review_ID', $id);
        $this->db->update('review', $data);
    }

    function readUserPhoto($id = 0)
    {
        $data = array(
            'is_read' => 1
        );
        $this->db->where('image_ID', $id);
        $this->db->update('image_gallery', $data);
    }

    function readUserRating($id = 0)
    {
        $data = array(
            'is_read' => 1
        );
        $this->db->where('rating_ID', $id);
        $this->db->update('rating_info', $data);
    }

    public function getProfileCompletionStatus($restid, $user_id)
    {
        $this->db->select('booking_management.id_user,booking_management.profilecompletion');
        $this->db->where('booking_management.rest_ID', $restid);
        $this->db->where('booking_management.id_user', $user_id);
        $q = $this->db->get('booking_management');
        if ($q->num_rows() > 0) {
            return $q->row_Array();
        }
    }

    function updateProfileCompletionStatus($restid, $user_id, $status = 0)
    {
        $data = array(
            'profilecompletion' => $status
        );
        $this->db->where('booking_management.rest_ID', $restid);
        $this->db->where('booking_management.id_user', $user_id);
        $this->db->update('booking_management', $data);
    }

    public function getRestPermissions($id)
    {
        $this->db->where('rest_ID', $id);
        $query = $this->db->get('subscription');
        $row = $query->row_array();
        return $row;
    }

    function addMemberDeatilsLog($rest_ID)
    {
        //$rest_ID=$this->input->post('rest_ID');
        $this->db->where('rest_ID', $rest_ID);
        $q = $this->db->get('subscription');
        if ($q->num_rows() > 0) {
            $old_data = $q->row_Array();
            $reference = '';
            $this->db->where('rest_ID', $rest_ID);
            $resQ = $this->db->get('booking_management');
            if ($resQ->num_rows() > 0) {
                $rest_data = $resQ->row_Array();
                $reference = $rest_data['referenceNo'];
            }
            $logdata = array(
                'accountType' => $old_data['accountType'],
                'rest_ID' => $old_data['rest_ID'],
                'sub_detail' => $old_data['sub_detail'],
                'price' => $old_data['price'],
                'referenceNo' => $reference
            );
            $this->db->insert('subscription_log', $logdata);
        }
    }

    public function getRestaurantCityURL($rest_ID = 0)
    {
        $this->db->select('city_list.seo_url');
        $this->db->join('rest_branches', 'restaurant_info.rest_ID=rest_branches.rest_fk_id');
        $this->db->join('city_list', 'city_list.city_ID=rest_branches.city_ID');
        $this->db->where(array('restaurant_info.rest_ID' => $rest_ID));
        $q = $this->db->get('restaurant_info');
        $results = "";
        if ($q->num_rows() > 0) {
            $results = $q->row_Array();
        }
        return $results;
    }
}
