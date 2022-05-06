<?php

class MCompetition extends Eloquent {

    protected $table = 'competition';

    public static function getAllCompetition($country = 0, $status = 0, $limit = 0, $sort = "latest") {
        $MComp = DB::table('competition');
        if ($status != 0) {
            $MComp->where('status', '=', 1);
        }
        switch ($sort) {
            case "latest":
                $MComp->orderBy('createdAt', 'DESC');
                break;
            case "name":
                $MComp->orderBy('name', 'DESC');
                break;
            case "popularity":
                $MComp->orderBy('views', 'DESC');
                break;
        }
        if (!empty($limit)) {
            $lists = $MComp->paginate($limit);
        } else {
            $lists = $MComp->get();
        }
        if (count($lists) > 0) {
            return $lists;
        } else {
            return NULL;
        }
    }

    public static function getCompetition($id = 0) {
        $list = DB::table('competition')->where('id', '=', $id)->first();
        if (count($list) > 0) {
            return $list;
        } else {
            return NULL;
        }
    }

    public static function getTotalParticipants($event_id = 0, $status = 0) {
        $tot = DB::table('participants');
        if (!empty($event_id)) {
            $tot->where('event_id', '=', $event_id);
        }
        if (!empty($status)) {
            $tot->where('status', '=', $status);
        }
        return $tot->count();
    }

    public static function addCompetition($image = "", $logo = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }

        $cities = '';
        if (isset($_POST['city'])) {
            $cities = $_POST['city'];
            $cities = implode(",", $cities);
        }

        $age_range_from = "";
        $age_range_to = "";
        if (isset($_POST['age_range_from'])) {
            $age_range_from = $_POST['age_range_from'];
        }
        if (isset($_POST['age_range_to'])) {
            $age_range_to = $_POST['age_range_to'];
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'title' => (Input::get('title')),
            'titleAr' => (Input::get('titleAr')),
            'start_date' => date('Y-m-d', strtotime(Input::get('start_date'))),
            'end_date' => date('Y-m-d', strtotime(Input::get('end_date'))),
            'description' => htmlentities(Input::get('description')),
            'descriptionAr' => htmlentities(Input::get('descriptionAr')),
            'start_time' => (Input::get('start_time')),
            'end_time' => (Input::get('end_time')),
            'event_type' => (Input::get('event_type')),
            'participants' => (Input::get('participants')),
            'country' => $country,
            'image' => $image,
            'logo' => $logo,
            'city' => (Input::get('city_ID')),
            'district' => (Input::get('district_' . $_POST['city_ID'])),
            'status' => $status,
            'latitude' => (Input::get('latitude')),
            'longitude' => (Input::get('longitude')),
            'updatedAt' => date('Y-m-d H:i:s'),
            'age_range_from' => $age_range_from,
            'age_range_to' => $age_range_to
        );
        return DB::table('competition')->insertGetId($data);
    }

    public static function updateCompetition($image = "", $logo = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $age_range_from = "";
        $age_range_to = "";
        if (isset($_POST['age_range_from'])) {
            $age_range_from = $_POST['age_range_from'];
        }
        if (isset($_POST['age_range_to'])) {
            $age_range_to = $_POST['age_range_to'];
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'title' => (Input::get('title')),
            'titleAr' => (Input::get('titleAr')),
            'start_date' => date('Y-m-d', strtotime(Input::get('start_date'))),
            'end_date' => date('Y-m-d', strtotime(Input::get('end_date'))),
            'description' => htmlentities(Input::get('description')),
            'descriptionAr' => htmlentities(Input::get('descriptionAr')),
            'start_time' => (Input::get('start_time')),
            'end_time' => (Input::get('end_time')),
            'event_type' => (Input::get('event_type')),
            'participants' => (Input::get('participants')),
            'image' => $image,
            'country' => $country,
            'logo' => $logo,
            'city' => (Input::get('city_ID')),
            'district' => (Input::get('district_' . $_POST['city_ID'])),
            'status' => $status,
            'latitude' => (Input::get('latitude')),
            'longitude' => (Input::get('longitude')),
            'updatedAt' => date('Y-m-d H:i:s'),
            'age_range_from' => $age_range_from,
            'age_range_to' => $age_range_to
        );
        DB::table('competition')->where('id', '=', Input::get('id'))->update($data);
    }

    public static function deleteCompetition($id = 0) {
        DB::table('competition')->where('id', '=', $id)->delete();
    }

    public static function getAllCompetitionParticipants($event_id) {
        $tot = DB::table('participants');
        if (!empty($event_id)) {
            $tot->where('event_id', '=', $event_id);
        }
        return $tot->paginate(1000);
    }

    public static function getParticipants($id = 0, $event_id = 0) {
        $tab = DB::table('participants');
        $tab->where('id', '=', $id);
        $tab->where('event_id', '=', $event_id);
        $list = $tab->first();
        if (count($list) > 0) {
            return $list;
        }
        return NULL;
    }

    public static function participantsStatus($id = 0, $event_id = 0, $status = 0) {
        $data = array(
            'status' => $status
        );
        DB::table('participants')->where('id', '=', $id)->where('event_id','=', $event_id)->update($data);
    }

}
