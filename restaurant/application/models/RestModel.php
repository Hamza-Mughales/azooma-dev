<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RestModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    public function getDashboardData($rest_id)
    {
        $this_month_liked_by = $this->db->select("count(rest_ID) as count")->where(['rest_ID' => $rest_id, "status" => 1, "YEAR(createdAt)" => date('Y'), "MONTH(createdAt)" => date('m')])
            ->get('likee_info')->row()->count;
        $last_month_date = date("Y-n-j", strtotime("first day of previous month"));
        $time = strtotime($last_month_date);
        $month = date("m", $time);
        $year = date("Y", $time);

        $last_month_liked_by = $this->db->select("count(rest_ID) as count")->where(['rest_ID' => $rest_id, "status" => 1, "YEAR(createdAt)" => $year, "MONTH(createdAt)" => $month])->get('likee_info')->row()->count;
        $data['this_month_liked_by'] = $this_month_liked_by;
        $data['last_month_liked_by'] = $last_month_liked_by;

        $total_comments_this_month = $this->db->select("count(*) as count")
            ->from("review")
            ->where(['rest_ID' => $rest_id, "YEAR(review_Date)" => date("Y"), "MONTH(review_Date)" => date("m")])
            ->get()->row()->count;
        $total_comments_last_month = $this->db->select("count(*) as count")
            ->from("review")
            ->where(['rest_ID' => $rest_id, "YEAR(review_Date)" => $year, "MONTH(review_Date)" => $month])
            ->get()->row()->count;
        $data['total_comments_this_month'] = $total_comments_this_month;
        $data['total_comments_last_month'] = $total_comments_last_month;

        $total_vistors_this_month = $this->db->select("count(*) as count")
            ->from("rest_vistors")
            ->where(['rest_id' => $rest_id, "YEAR(created_at)" => date("Y"), "MONTH(created_at)" => date("m")])
            ->get()->row()->count;
        $total_vistors_last_month = $this->db->select("count(*) as count")
            ->from("rest_vistors")
            ->where(['rest_id' => $rest_id, "YEAR(created_at)" => $year, "MONTH(created_at)" => $month])
            ->get()->row()->count;
        $data['total_vistors_this_month'] = $total_vistors_this_month;
        $data['total_vistors_last_month'] = $total_vistors_last_month;

        $index = 0;
        $total = rand(1, 100);
        $month_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $where['MONTH(salary_date)'] = $i;

            $total =  $this->db->select("count(*) as count")
                ->from("rest_vistors")
                ->where(['rest_id' => $rest_id, "YEAR(created_at)" => date('Y'), "MONTH(created_at)" => $i])
                ->get()->row()->count;
            //$total = rand(1, 100);


            $month_data[] = intval($total);
        }

        $data['months_vistors_data'] = $month_data;

        $rating_info =  $this->db->select("sum(rating_Food+rating_Service+rating_Atmosphere+rating_Value+rating_Presentation+rating_Variety) as total_points,(sum(rating_Food+rating_Service+rating_Atmosphere+rating_Value+rating_Presentation+rating_Variety)*10)/6 as total")->where('rating_info.rest_ID', $rest_id)
            ->from('rating_info')->where("rest_ID", $rest_id)->group_by("rating_ID")->get()->result();
        $count_rating = count($rating_info);
        $total_rating = 0;
        $total_rating_row = 0;
        foreach ($rating_info as $r) {
            $total_rating_row += $r->total;
        }
        if ($count_rating > 0) {
            $total_rating = round($total_rating_row / $count_rating, 2);
        }
        $data['total_rating'] = $total_rating;


        $rating_info_month =  $this->db->select("sum(rating_Food+rating_Service+rating_Atmosphere+rating_Value+rating_Presentation+rating_Variety) as total_points,(sum(rating_Food+rating_Service+rating_Atmosphere+rating_Value+rating_Presentation+rating_Variety)*10)/6 as total")->where('rating_info.rest_ID', $rest_id)
            ->from('rating_info')->where(["YEAR(created_at)" => date("Y"), "MONTH(created_at)" => date("m"), "rest_ID" => $rest_id])->group_by("rating_ID")->get()->result();
        $count_rating = count($rating_info_month);
        $total_rating = 0;
        $total_points = 0;
        $total_rating_row = 0;
        foreach ($rating_info_month as $r) {
            $total_rating_row += $r->total;
            $total_points += $r->total_points;
        }
        if ($count_rating > 0) {
            $total_rating = round($total_rating_row / $count_rating, 2);
        }
        $data['total_month_rating'] = $total_rating;
        $data['total_month_rating_points'] = $total_points;

        $rating_info_year =  $this->db->select("sum(rating_Food+rating_Service+rating_Atmosphere+rating_Value+rating_Presentation+rating_Variety) as total_points,(sum(rating_Food+rating_Service+rating_Atmosphere+rating_Value+rating_Presentation+rating_Variety)*10)/6 as total")->where('rating_info.rest_ID', $rest_id)
            ->from('rating_info')->where(["YEAR(created_at)" => date("Y"), "rest_ID" => $rest_id])->group_by("rating_ID")->get()->result();
        $count_rating = count($rating_info_year);
        $total_rating = 0;
        $total_points = 0;
        $total_rating_row = 0;
        foreach ($rating_info_year as $r) {
            $total_rating_row += $r->total;
            $total_points += $r->total_points;
        }
        if ($count_rating > 0) {
            $total_rating = round($total_rating_row / $count_rating, 2);
        }
        $data['total_year_rating'] = $total_rating;
        $data['total_year_rating_points'] = $total_points;
        $data['total_reviews'] = $this->db->select("count(*) as total_reviews")->from('rating_info')->where('rating_info.rest_ID', $rest_id)->get()->row()->total_reviews;

        return $data;
    }

    function getRestGalaryImages($rest = 0, $status = 0, $limit = 8, $offset = "")
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
        return $q->result();
    }

    function getLatestUserPhotos($rest, $status = 0, $limit = 8, $offset = "")
    {
        $this->db->select('image_gallery.image_full,image_gallery.title,image_gallery.title_ar,image_gallery.enter_time,image_gallery.image_ID, image_gallery.is_read, image_gallery.status, image_gallery.user_ID,restaurant_info.rest_Name');
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
        return $q->result();
    }
    public function getRestRatings($id)
    {

        $this->db->where('rating_info.rest_ID', $id);
        $this->db->order_by("rating_info.rating_ID", "desc");

        $q = $this->db->get('rating_info');
        $results = $q->result_array();
        return $results;
    }

    public  function getRatingtext($rest = 0)
    {
        $query = "SELECT COUNT(*) as total,sum(rating_Food) as totalfood,SUM(rating_Service) as totalservice,SUM(rating_Atmosphere) as totalatmosphere,SUM(rating_Value) as totalvalue,SUM(rating_Variety) as totalvariety,SUM(rating_Presentation) as totalpresentation FROM rating_info WHERE rest_ID=" . $rest;
        $ratinginfo = $this->db->query($query)->row();
   
        $totalrating = 0;
        if ($ratinginfo) {

            if ($ratinginfo->total > 0) {
                $totalrating = round(($ratinginfo->totalfood + $ratinginfo->totalservice + $ratinginfo->totalatmosphere + $ratinginfo->totalvalue + $ratinginfo->totalvariety + $ratinginfo->totalpresentation) / (6 * $ratinginfo->total), 1);
            } else {
                $totalrating = 0;
            }
        }
        $ratingtext='';
        if ($totalrating > 0) {
            $totalrating = $totalrating/2;
            switch ($totalrating) {
                case ($totalrating >= 1 && $totalrating < 3.5):
                    $ratingtext = "not_good";
                    break;
                case ($totalrating >= 3.5 && $totalrating < 5):
                    $ratingtext = "pleasant";
                    break;
                case ($totalrating >= 5 && $totalrating < 6.5):
                    $ratingtext = "good";
                    break;
                case ($totalrating >= 6.5 && $totalrating < 7):
                    $ratingtext = "very_good";
                    break;
                case ($totalrating >= 7 && $totalrating < 9.5):
                    $ratingtext = "superb";
                    break;
                case ($totalrating >= 9.5 && $totalrating <= 10):
                    $ratingtext = "excellent";
                    break;
            }
        }else{
            if($ratinginfo->total>0){
                $ratingtext='not_good';
            }else{
                $ratingtext='';    
            }

        }
        return lang($ratingtext);
    }
}
