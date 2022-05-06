<?php

class EventCalendar extends Eloquent {

    protected $table = 'event';

    function addCalendarEvent($image = "") {
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
            'country' => $country,
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'date' => date('Y-m-d', strtotime(Input::get('date'))),
            'message' => htmlentities(Input::get('message')),
            'messageAr' => Input::get('messageAr'),
            'recipients' => (Input::get('recipients')),
            'cuisines' => $cuisines,
            'cities' => $cities,
            'status' => $status
        );
        return $insertID = DB::table('event')->insertGetId($data);
    }

    function updateCalendarEvent($image = "") {
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
            'country' => $country,
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'date' => date('Y-m-d', strtotime(Input::get('date'))),
            'message' => htmlentities(Input::get('message')),
            'messageAr' => Input::get('messageAr'),
            'recipients' => (Input::get('recipients')),
            'cuisines' => $cuisines,
            'cities' => $cities,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('event')->where('id', Input::get('id'))->update($data);
    }

    function getCalendarEvent($id, $status = 0) {
        $MEventCalendar = EventCalendar::where('id', $id);
        if ($status == 1) {
            $MEventCalendar = EventCalendar::where('status', '=', 1);
        }
        $result_Array = $MEventCalendar->first();
        if (count($result_Array) > 0) {
            return $result_Array;
        }
    }

}
