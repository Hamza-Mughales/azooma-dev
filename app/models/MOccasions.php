<?php

Class MOccasions extends Eloquent {

    public static function getAllCateringEvents($country = 0, $status = 0, $limit = 0, $sort = "", $name = "") {
        $MO = DB::table('user_event');
        if ($status != 0) {
            $MO->where('user_event.status', 1);
        }
        if (!empty($name)) {
            $MO->where('name', 'LIKE', '%' . $name . '%');
        }
        if (empty($sort)) {
            $MO->orderBy('user_event.createdAt');
        } else {
            switch ($sort) {
                case 'latest':
                    $MO->orderBy('user_event.createdAt');
                    break;
                case 'name':
                    $MO->orderBy('user_event.name');
                    break;
                case 'budget':
                    $MO->orderBy('user_event.budget');
                    break;
            }
        }
        if (!empty($limit)) {
            $lists = $MO->paginate($limit);
        } else {
            $lists = $MO->paginate(10000);
        }
        if (count($lists) > 0) {
            return $lists;
        }
    }

    public static function getTotalCateringEvents() {
        return DB::table('user_event')->count();
    }

    public static function getCateringEvent($id) {
        return DB::table('user_event')->where('id', '=', $id)->first();
    }

    public static function getRestEmails($id) {
        $Em = DB::table('restaurant_info');
        $Em->select('*', DB::Raw('group_concat(rest_Email,', ', email) AS email'));
        $Em->join('booking_management', 'restaurant_info.rest_ID', '=', 'booking_management.rest_ID');
        $Em->where('restaurant_info.rest_ID', '=', $id);
        return $lists = $Em->get();
    }

    public static function getCuisineNames($ids) {
        $MCN = DB::table('cuisine_list');
        $MCN->select('cuisine_Name');
        if (strpos($ids, ",")) {
            $str = explode(",", $ids);
            $MCN->whereIn('cuisine_ID', $str);
        } else {
            $MCN->where('cuisine_ID', '=', $ids);
        }
        $lists = $MCN->get();
        $names = "";
        if (count($lists) > 0) {
            foreach ($lists as $value) {
                if ($names == "") {
                    $names = stripslashes($value->cuisine_Name);
                } else {
                    $names.=", " . stripslashes($value->cuisine_Name);
                }
            }
        }
        return $names;
    }

    public static function changeCateringEventStatus($id, $status = 0) {
        $data = array(
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('user_event')->where('id', $id)->update($data);
    }

    public static function getUserInfo($id) {
        return DB::table('user')->where('user_ID', '=', $id)->first();
    }

    public static function updateCateringEventRequestRest($id) {
        $rests = "";
        if (is_array(Input::has('tagRest'))) {
            $rests = implode(",", Input::get('tagRest'));
        }
        $data = array(
            'reqRest' => $rests,
            'restNotes' => Input::get('notes'),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('user_event')->where('id', '=', $id)->update($data);
    }

    public static function deleteCateringEvent($id) {
        DB::table('user_event')->where('id', '=', $id)->delete();
    }

    public static function read($id = 0) {
        $data = array(
            'is_read' => 1,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('user_event')->where('id', '=', $id)->update($data);
    }

}
