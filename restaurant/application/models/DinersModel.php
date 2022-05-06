<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DinersModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    /**
     *
     * Return diners list 
     *
     * @access    public
     * @params  [filter data array , count row true or false]
     * @return   diners array
     */
    public function getDinersList($data = array(), $count = false)
    {

        $where = $like = array();
        $search = post("sSearch");
        //if process is search
        if (strlen($search) > 0) {

            $name = "user.user_FullName";
            $like["$name"] = $search;
        }
        $where['d.rest_ID'] = rest_id();
        // $where['user.status'] =1;

        // for get num rows
        if ($count) {
            $this->db->select('COUNT(user.user_ID) as count');
            $this->db->from("user as user");
            $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
        } else {
            $limit = post("iDisplayLength");
            $offset = post("iDisplayStart");
            $c_name = sys_lang() == "arabic" ? "city_Name_ar" : "city_Name";
            $stmt = $this->db->select('user.*');
            $stmt = $this->db->select("c.$c_name as city_name");
            $this->db->from("user as user");
            $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
            $this->db->join("city_list as c", "user.user_City=c.city_ID", "left");
            $this->db->order_by("d.createdAt", "desc");
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        $this->db->where($where);

        $this->db->like($like);

        $result = $count ? "row" : "result";

        return $this->db->get()->{$result}();
    }
    public function countUserFollowers($user_id)
    {

        $where['user_ID'] = intval($user_id);
        return $this->db->select("count(id) as count")->from("follower")->where($where)->get()->row()->count;
    }
    public function countUserReviews($user_id)
    {

        $where['user_ID'] = intval($user_id);
        return $this->db->select("count(*) as count")->from("review")->where($where)->get()->row()->count;
    }

    public  function getAllMyDiners()
    {

        $where['d.rest_ID'] = rest_id();
        $c_name = sys_lang() == "arabic" ? "city_Name_ar" : "city_Name";
        $stmt = $this->db->select('user.*');
        $stmt = $this->db->select("c.$c_name as city_name");
        $this->db->from("user as user");
        $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
        $this->db->join("city_list as c", "user.user_City=c.city_ID", "left");
        $this->db->order_by("d.createdAt", "desc");
        $this->db->where($where);
        return $this->db->get()->result();
    }
    public  function getToList($msg_id)
    {
        $to_diners = [];
        $message = $this->db->where("id", intval($msg_id))->from("dinermessage")->get()->row();
        if ($message->audienceType == 2) {
            $where['d.rest_ID'] = rest_id();
            $this->db->select('user.*');
            $this->db->from("user as user");
            $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
            $this->db->where($where);
            $to_diners = $this->db->get()->result();
        } elseif ($message->audienceType == 3) {
            $where['d.rest_ID'] = rest_id();
            $recipients = explode(",", $message->recipients);
            $ids = [-1];
            if (is_array($recipients) && !empty($recipients)) {

                foreach ($recipients as $r) {
                    $ids[]=intval($r);
                }
            }
            $this->db->select('user.*');
            $this->db->from("user as user");
            $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
            $this->db->where_in("user.user_ID", $ids);
            $to_diners = $this->db->get()->result();
        }
        else {
            $where['d.rest_ID'] = rest_id();
            $recipients = explode(",", $message->recipients);
            $ids = [-1];
            if (is_array($recipients) && !empty($recipients)) {

                foreach ($recipients as $r) {
                    $ids[]=intval($r);
                }
            }
            $this->db->select('user.*');
            $this->db->from("user as user");
            $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
            $this->db->where_in("user.user_ID", $ids);
            $to_diners = $this->db->get()->result();
        }
        $to_emails = array();
        foreach ($to_diners as $v) {
            $to_emails[] = array("name" => $v->user_FullName, "email" => $v->user_Email);
        }
        return $to_emails;
    }
    public  function getTotalDiners()
    {

        $where['d.rest_ID'] = rest_id();
        $stmt = $this->db->select('count(user.user_ID) as total');
        $this->db->from("user as user");
        $this->db->join("likee_info as d", "user.user_ID=d.user_ID");
        $this->db->where($where);
        return $this->db->get()->row()->total;
    }
}
