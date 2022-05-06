<?php

class MPoll extends Eloquent {

    protected $table = 'fpoll_poll';

    function getAllPolls($country = 0, $restaurant = 0, $status = 0, $limit = "") {
        $this->table = "fpoll_poll";
        $MPoll = MPoll::Select('*');
        if ($status != 0) {
            $MPoll->where('status', '=', 1);
        }
        if ($country != 0) {
            $MPoll->where('country', '=', $country);
        }
        if ($restaurant != 0) {
            $MPoll->where('rest_ID', '=', $restaurant);
        }
        $MPoll->orderBy('status', 'DESC');
        $MPoll->orderBy('date_add', 'DESC');

        if ($limit != "") {
            $lists = $MPoll->paginate($limit);
        } else {
            $lists = $MPoll->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return $lists;
    }

    function getPollOptions($poll = 0, $status = 0) {
        $this->table = "fpoll_options";
        $MPoll = MPoll::Select('*');
        if ($poll != 0) {
            $MPoll->where('poll_id', $poll);
        }
        if ($status != 0) {
            $MPoll->where('status', 1);
        }
        return $list = $MPoll->paginate();
    }
    /********

    Made static function by Mohamed Fasil
    *******/

    public static function getPoll($id = 0) {
        return DB::table('fpoll_poll')->where('id', '=', $id)->first();
    }

    function addPollQuestion($image) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'question' => (Input::get('question')),
            'question_ar' => (Input::get('question_ar')),
            'description' => (Input::get('description')),
            'descriptionAr' => (Input::get('descriptionAr')),
            'image' => $image,
            'status' => $status,
            'rest_ID' => (Input::get('rest_ID')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('fpoll_poll')->insertGetId($data);
    }

    function updatePollQuestion($image) {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'question' => (Input::get('question')),
            'question_ar' => (Input::get('question_ar')),
            'description' => (Input::get('description')),
            'descriptionAr' => (Input::get('descriptionAr')),
            'image' => $image,
            'status' => $status,
            'rest_ID' => (Input::get('rest_ID')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('fpoll_poll')->where('id', '=', Input::get('id'))->update($data);
    }

    function deleteQuestion($id) {
        DB::table('fpoll_poll')->where('id', '=', $id)->delete();
    }

    function addPollAnswer($field, $field_ar, $status = 1, $poll = 0) {
        $data = array(
            'field' => $field,
            'field_ar' => $field_ar,
            'status' => $status,
            'poll_id' => $poll,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('fpoll_options')->insertGetId($data);
    }

    function updatePollAnswer($field, $field_ar, $status = 1, $poll = 0, $id = 0) {
        $data = array(
            'field' => $field,
            'field_ar' => $field_ar,
            'status' => $status,
            'poll_id' => $poll,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('fpoll_options')->where('id', '=', $id)->update($data);
    }

    function deleteAnswer($id) {
        DB::table('fpoll_options')->where('id', '=', $id)->delete();
    }

    function activateQuestion($id = 0) {
        $data = array(
            'status' => 1,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('fpoll_poll')->where('id', '=', $id)->update($data);
    }

    function deActivateQuestion($id = 0) {
        $data = array(
            'status' => 0,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('fpoll_poll')->where('id', '=', $id)->update($data);
    }

    function getPollOption($id = 0) {
        return DB::table('fpoll_options')->where('id', '=', $id)->first();
    }

    function activateAnswer($id = 0) {
        $data = array(
            'status' => 1,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('fpoll_options')->where('id', '=', $id)->update($data);
    }

    function deActivateAnswer($id = 0) {
        $data = array(
            'status' => 0,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('fpoll_options')->where('id', '=', $id)->update($data);
    }

    /***************
    Mohamed Fasil
    ************/


    public static function getFullPolls($limit=0,$offset=0,$country=0,$except=0){
        $q=DB::table('fpoll_poll')->select('id','question','question_ar','date_add')->where('status',1)->where('country',$country);
        if($except!=0){
            $q->where('id','<>',$except);
        }
        if($limit!=0){
            $q->skip($offset)->take($limit);
        }
        return $q->get();
    }

    public static function getLatestPoll($country=0){
        return DB::table('fpoll_poll')->where('status',1)->where('country',$country)->orderBy('date_add','desc')->first();
    }

    public static function getOptionsWithResult($poll=0){
        return DB::table('fpoll_options')->select('*',DB::raw('(SELECT COUNT(id) FROM fpoll_ips WHERE fpoll_ips.option_id= fpoll_options.id) as count'))->where('poll_id',$poll)->get();
    }

    public static function getTotalVotes($poll=0){
        return DB::table('fpoll_ips')->where('poll_id',$poll)->count();
    }

    public static function checkUserVoted($poll=0){
        $userid=0;
        $ip=Azooma::getRealIpAddr();
        if(Session::has('userid')){
            $userid=Session::get('userid');
            return DB::table('fpoll_ips')->where('poll_id',$poll)->where('user_ID',$userid)->first();
        }else{
            return DB::table('fpoll_ips')->where('poll_id',$poll)->where('ip',$ip)->first();
        }
        
    }

}
