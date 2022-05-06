<?php

class WelcomeMessage extends Eloquent {

    protected $table = 'welcome_message';

    public function getAllMessage($country = 0, $limit = "", $name = "", $status = 0) {
        $mresult = WelcomeMessage::select('*');
        if (!empty($country)) {
            $mresult->where('welcome_message.country', $country);
        }
        if ($status != 0) {
            $mresult->where('welcome_message.status', 1);
        }
        $mresult->orderBy('created_at', 'asc');
        if ($name != "") {
            $mresult->where('name', 'LIKE', $name . '%');
        }
        if ($limit != "" && !empty($limit)) {
            $lists = $mresult->paginate($limit);
        } else {
            $lists = $mresult->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function addMessage() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'country' => (Input::get('country')),
            'text_en' => (Input::get('text_en')),
            'text_ar' => (Input::get('text_ar')),
            'status' => $status
        );
        return $insertID = DB::table('welcome_message')->insertGetId($data);
    }

    function updateMessage() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $data = array(
            'country' => (Input::get('country')),
            'text_en' => (Input::get('text_en')),
            'text_ar' => (Input::get('text_ar')),
            'status' => $status
        );
        DB::table('welcome_message')->where('id', Input::get('id'))->update($data);
    }

}
