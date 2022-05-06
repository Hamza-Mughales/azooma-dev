<?php

class MKnownFor extends Eloquent {

    protected $table = 'bestfor_list';

    function getAllKnownFor($country = 0, $city = 0, $status = 0, $limit = 0, $name = "",$sort="",$sortview="") {
        $mBest = DB::table('bestfor_list');
        $mBest->select('*',DB::Raw('(SELECT count(* ) FROM restaurant_bestfor JOIN restaurant_info on restaurant_info.rest_ID=restaurant_bestfor.rest_ID WHERE restaurant_bestfor.bestfor_ID=bestfor_list.bestfor_ID AND restaurant_info.rest_Status=1) AS count'));
        if ($country != 0) {
            $mBest->where('bestfor_list.country', '=', $country);
        }
        if ($status != 0) {
            $mBest->where('bestfor_list.bestfor_Status', '=', 1);
        }
        
        if ($name != 0) {
            $mBest->where('bestfor_list.bestfor_Name', 'LIKE', $name . '%');
        }
        if ($city != 0) {
            $mBest->join('restaurant_bestfor', 'restaurant_bestfor.bestfor_ID', '=', 'bestfor_list.bestfor_ID');
            $mBest->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_bestfor.rest_ID')->where('rest_branches.city_ID', '=', $city);
            $mBest->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'rest_branches.rest_fk_id');
            $mBest->where('restaurant_info.rest_Status', '=', 1);
            $mBest->group_by('bestfor_list.bestfor_ID');
        }
        
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $mBest->orderBy('bestfor_Name', 'ASC');
                    break;
                case 'latest':
                    $mBest->orderBy('updatedAt', 'DESC');
                    break;
            }
        } elseif (!empty($sortview)) {
            if ($sortview == 1) {
                $mBest->orderBy('count', 'DESC');
            } else {
                $mBest->orderBy('count', 'ASC');
            }
        }
        
        //$mBest->orderBy('bestfor_list.bestfor_Name');
        if ($limit != "") {
            $lists = $mBest->paginate($limit);
        } else {
            $lists = $mBest->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getBestFor($id = 0) {
        return MKnownFor::where('bestfor_ID', '=', $id)->first();
    }

    function getBestForRest($bestfor_ID = 0) {
        $mBest = MKnownFor::select('*');
        $mBest->join('restaurant_bestfor', 'restaurant_bestfor.bestfor_ID', '=', 'bestfor_list.bestfor_ID');
        $mBest->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'restaurant_bestfor.rest_ID');
        $mBest->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_bestfor.rest_ID');
        $mBest->where('restaurant_info.rest_Status', '=', 1);
        $mBest->where('bestfor_list.bestfor_ID', '=', $bestfor_ID);
        $lists = $mBest->get();
        if (count($lists) > 0) {
            return $lists;
        } else {
            return null;
        }
        $q = $this->db->get('bestfor_list');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function addToFavorite($rest_ID, $bestfor_ID) {
        $mBest = MKnownFor::select('*');
        $mBest->where('bestfor_ID', $bestfor_ID);
        $q = $mBest->first();
        if (count($q) > 0) {
            $row = $q;
            $tagrest_ID = '';
            if (!empty($row->rest_ID)) {
                $tagrest_ID.=$row->rest_ID . ',' . $rest_ID;
            } else {
                $tagrest_ID.=$rest_ID;
            }
            $data = array(
                'rest_ID' => $tagrest_ID,
                'updatedAt' => date('Y-m-d H:i:s')
            );
            DB::table('bestfor_list')->where('bestfor_ID', '=', $bestfor_ID)->update($data);
        }
    }

    function addbestfor($image = "") {
        $status = 0;
        if (isset($_POST['bestfor_Status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('bestfor_Name')), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest_ID="";
        if(isset($_POST['rest_ID'])){
            $rest_ID=implode(',', $_POST['rest_ID']);
        }
        $data = array(
            'bestfor_Name' => (Input::get('bestfor_Name')),
            'bestfor_Name_ar' => (Input::get('bestfor_Name_ar')),
            'country' => $country,
            'rest_ID'=>$rest_ID,
            'bestfor_Status' => $status,
            'seo_url' => $url,
            'best_for_desc' => (Input::get('best_for_desc')),
            'best_for_desc_ar' => (Input::get('best_for_desc_ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return $rtID = DB::table('bestfor_list')->insertGetId($data);
    }

    function updatebestfor($image = "") {
        $status = 0;
        if (isset($_POST['bestfor_Status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('bestfor_Name')), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest_ID="";
        if(isset($_POST['rest_ID'])){
            $rest_ID=implode(',', $_POST['rest_ID']);
        }
        $data = array(
            'bestfor_Name' => (Input::get('bestfor_Name')),
            'bestfor_Name_ar' => (Input::get('bestfor_Name_ar')),
            'country' => $country,
            'rest_ID'=>$rest_ID,
            'bestfor_Status' => $status,
            'seo_url' => $url,
            'best_for_desc' => (Input::get('best_for_desc')),
            'best_for_desc_ar' => (Input::get('best_for_desc_ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('bestfor_list')->where('bestfor_ID', '=', Input::get('bestfor_ID'))->update($data);
    }

    function deleteKnownFor($id) {
        DB::table('bestfor_list')->where('bestfor_ID', '=', $id)->delete();
    }

}
