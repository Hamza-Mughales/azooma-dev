<?php

class NewsLetter extends Eloquent {

    protected $table = 'newsletter';

    public function addNewsLetter($image = "") {
        // dd($image);
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $cuisines = "";
        $cities = "";
        if (Input::get('cuisines') != '') {
            $cuisines = implode(',', Input::get('cuisines'));
        }
        if (Input::get('cities') != '') {
            $cities = implode(',', Input::get('cities'));
        }
        $data = array(
            'receiver' => (Input::get('receiver')),
            'country' => $country,
            'name' => (Input::get('name')),
            'month' => (Input::get('month')),
            'year' => (Input::get('year')),
            'message' => htmlentities(Input::get('description')),
            'recipents_test' => htmlentities(Input::get('recipents_test')),
            'cuisines' => $cuisines,
            'image' => $image,
            'cities' => $cities,
            'status' => $status
        );
        return $insertID = DB::table('newsletter')->insertGetId($data);
    }

    public function updateNewsLetter($image = "") {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $cuisines = "";
        $cities = "";
        if (Input::get('cuisines') != '') {
            $cuisines = implode(',', Input::get('cuisines'));
        }
        if (Input::get('cities') != '') {
            $cities = implode(',', Input::get('cities'));
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'receiver' => (Input::get('receiver')),
            'country' => $country,
            'name' => (Input::get('name')),
            'month' => (Input::get('month')),
            'year' => (Input::get('year')),
            'message' => htmlentities(Input::get('description')),
            'recipents_test' => htmlentities(Input::get('recipents_test')),
            'cuisines' => $cuisines,
            'cities' => $cities,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('newsletter')->where('id', Input::get('id'))->update($data);
    }

    public function getNewsLetter($id, $status = 0) {
        $MNewsLetter = NewsLetter::where('id', $id);
        if ($status == 1) {
            $MNewsLetter = NewsLetter::where('status', '=', 1);
        }
        $result_Array = $MNewsLetter->first();
        if (count($result_Array) > 0) {
            return $result_Array;
        }
    }

    public static function getReceivers($typ = "subscribers", $city = 0) {
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        switch ($typ) {
            case "subscribers":
                $TR = DB::table('subscribers')->where('country', '=', $country)->where('status', '=', 1)->where('bademail', '=', 0);
                if (!empty($city)) {
                    $TR->where('city', '=', $city);
                }
                return $TR->count();
                break;
            case "users":
                $TR = DB::table('user')->where('user_Status', '=', 1);
                if (!empty($city)) {
                    $TR->where('user_City', '=', $city);
                }
                return $TR->count();
                break;
            case "rest":

                break;
        }
    }

}
