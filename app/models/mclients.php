<?php

class MClients extends Eloquent {

    protected $table = 'subscription';

    function getAllClients($country = 0, $city = 0, $cuisine = 0, $sort = "latest", $member = 0, $limit = 0, $restname = "", $ispaid = 0, $rest_viewed = 0, $best = 0) {
        //$this->table = "restaurant_info";
        $MSubscription = DB::table('restaurant_info'); //MClients::select('*');
        //$MSubscription = MClients::select(DB::raw(),'booking_management.status AS membershipstatus,booking_management.referenceNo, booking_management.date_add AS datejoin,booking_management.email,booking_management.full_name,booking_management.phone, restaurant_info.rest_RegisDate,restaurant_info.rest_Name, restaurant_info.rest_ID, restaurant_info.rest_Status, restaurant_info.sufrati_favourite, restaurant_info.lastUpdatedOn,restaurant_info.rest_Name_Ar,restaurant_info.rest_Description,restaurant_info.rest_Subscription,restaurant_info.is_read,restaurant_info.member_duration,restaurant_info.member_date');
        $MSubscription->join('booking_management', 'booking_management.rest_id', '=', 'restaurant_info.rest_ID');

        if ($city != "") {
            $MSubscription->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            $MSubscription->where('rest_branches.city_ID', '=', $city);
        }
        if ($rest_viewed != 0) {
            $MSubscription->where('restaurant_info.rest_Viewed > ', $rest_viewed);
        }
        if ($cuisine != "") {
            $MSubscription->join('restaurant_cuisine', 'restaurant_cuisine.rest_ID', '=', 'restaurant_info.rest_ID');
            $MSubscription->where('restaurant_cuisine.cuisine_ID', '=', $cuisine);
        }
        if ($best != "") {
            $MSubscription->join('restaurant_bestfor', 'restaurant_bestfor.rest_ID', '=', 'restaurant_info.rest_ID');
            $MSubscription->where('restaurant_bestfor.bestfor_ID', '=', $best);
        }
        if ($country != 0) {
            $MSubscription->where('restaurant_info.country', '=', $country);
        }
        if ($restname != "") {
            $MSubscription->where('restaurant_info.rest_Name', 'LIKE', "%".$restname . '%');
        }
        if (!empty($member)) {
            $MSubscription->where('restaurant_info.rest_Subscription', '=', $member);
        }
        if (!empty($ispaid)) {
            $MSubscription->where('restaurant_info.rest_Subscription', '>', 0);
        } else {
            $MSubscription->where('restaurant_info.rest_Subscription', '>', -1);
        }

        $MSubscription->where('restaurant_info.rest_Status', '>', 0);
        $MSubscription->where('booking_management.status', '>', 0);

        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $MSubscription->orderBy('restaurant_info.rest_Name', 'ASC');
                    break;
                case 'latest':
                    $MSubscription->orderBy('restaurant_info.rest_RegisDate', 'DESC');
                    break;
                case 'popular':
                    $MSubscription->orderBy('restaurant_info.total_view', 'DESC');
            }
        }
        if ($limit != "") {
            $lists = $MSubscription->paginate($limit);
        } else {
            $lists = $MSubscription->paginate();
        }

        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getAllSubscriptionTypes($country = 0) {
        $MSubscription = DB::table('subscriptiontypes'); //MClients::select('*');
  
        if (!in_array(0, adminCountry())) {
            $MSubscription->whereIn("country",  adminCountry());
        }
        $MSubscription->orderBy('date_add', 'DESC');
        $lists = $MSubscription->get();
        if (count($lists) > 0) {
            return $lists;
        }
        return [];
    }

    function getSubscriptionType($id) {
        $this->table = 'subscriptiontypes';
        return $query = DB::table('subscriptiontypes')->where('id', '=', $id)->first();
    }

    function updateMemberContacts() {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $emails = "";
        if (isset($_POST['emails'])) {
            $emails = implode(',', $_POST['emails']);
        }
        $data = array(
            'full_name' => (Input::get('full_name')),
            'email' => $emails,
            'phone' => (Input::get('phone')),
            'status' => $status,
            'preferredlang' => (Input::get('preferredlang'))
        );
        DB::table('booking_management')->where('rest_id', '=', Input::get('rest_ID'))->where('id_user', '=', Input::get('id_user'))->update($data);
    }

    function getPermissionDetails($membership) {
        return DB::table('subscription')->where('accountType', '=', $membership)->where('rest_ID', '=', 0)->first();
    }

    function addMemberContacts($password = 0, $userName) {
        $emails = "";
        if (isset($_POST['emails'])) {
            $emails = Input::get('emails');
            $emails = implode(",", $emails);
        }
        $data = array(
            'full_name' => (Input::get('full_name')),
            'email' => $emails,
            'user_name' => $userName,
            'password' => $password,
            'phone' => (Input::get('phone')),
            'status' => 1,
            'preferredlang' => (Input::get('preferredlang')),
            'rest_id' => Input::get('rest_ID'),
            'date_add' => date('Y-m-d H:i:s')
        );
        return DB::table('booking_management')->insertGetId($data);
    }

    function addMemberDetails($reference = "", $id_user = 0) {
        $permissions = "1,2,3,6";
        $data = array(
            'accountType' => 0,
            'sub_detail' => $permissions,
            'rest_ID' => Input::get('rest_ID'),
            'price' => 0,
            'date_upd' => date('Y-m-d H:i:s')
        );
        $insertedID = DB::table('subscription')->insertGetId($data);

        $bkdata = array(
            'referenceNo' => $reference
        );
        DB::table('booking_management')->where('rest_id', '=', Input::get('rest_ID'))->where('id_user', '=', $id_user)->update($bkdata);

        $restdata = array(
            'member_duration' => (Input::get('member_duration')),
            'member_date' => (Input::get('member_date')),
            'rest_Subscription' => (Input::get('rest_Subscription')),
        );
        DB::table('restaurant_info')->where('rest_ID', '=', Input::get('rest_ID'))->update($restdata);
    }

    function getBookingManagementID($id) {
        $result = DB::table('booking_management')->where('rest_id', '=', $id)->first();
        if (count($result) > 0) {
            return $result;
        }
    }

    function addMemberDeatilsLog($rest_ID) {
        $old_data = DB::table('subscription')->where('rest_ID', '=', $rest_ID)->first();
        if (count($old_data) > 0) {
            $reference = '';
            $resQ = DB::table('booking_management')->where('rest_ID', '=', $rest_ID)->first();
            if (count($resQ) > 0) {
                $rest_data = $resQ;
                $reference = $rest_data->referenceNo;
            }
            $logdata = array(
                'accountType' => $old_data->accountType,
                'rest_ID' => $old_data->rest_ID,
                'sub_detail' => $old_data->sub_detail,
                'price' => $old_data->price,
                'referenceNo' => $reference,
                "date_add"=>date("Y-m-d H:i:s")
            );
            DB::table('subscription_log')->insert($logdata);
        }
    }

    function getMemberDeatilsLog($rest_ID) {
        $lists = DB::table('subscription_log')->where('subscription_log.rest_ID', '=', $rest_ID)->orderBy('date_add','DESC')->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return '';
    }

    function updateMemberDetails($reference = "") {
        $this->addMemberDeatilsLog(Input::get('rest_ID'));
        $permissions = "";
        if (isset($_POST['editfeatures'])) {
            $permissions = implode(',', $_POST['editfeatures']);
        }
        if ($permissions == "" || empty($permissions)) {
            $permissions = "1,2,3,6";
        }

     
        $data = array(
            'accountType' => (Input::get('rest_Subscription')),
            'sub_detail' => $permissions,
            'price' => (Input::get('price')),
            'allowed_messages' => (Input::get('allowed_messages')),
            'date_upd' => date('Y-m-d H:i:s')
        );
        DB::table('subscription')->where('rest_ID', '=', Input::get('rest_ID'))->where('id', '=', Input::get('id'))->update($data);
        $bkdata = array(
            'date_upd' => date('Y-m-d H:i:s'),
            'referenceNo' => $reference,
            'status' => 1
        );
        DB::table('booking_management')->where('rest_id', '=', Input::get('rest_ID'))->where('id_user', '=', Input::get('id_user'))->update($bkdata);
        $restdata = array(
            'member_duration' => (Input::get('member_duration')),
            'member_date' => (Input::get('member_date')),
            'rest_Subscription' => (Input::get('rest_Subscription')),
            'is_account_expire' => 0
        );
        DB::table('restaurant_info')->where('rest_ID', '=', Input::get('rest_ID'))->update($restdata);
    }

    function expiry_notified($restid = 0, $status = 0) {
        $data = array(
            'expiry_notified' => $status
        );
        DB::table('restaurant_info')->where('rest_ID', '=', $restid)->update($data);
    }

    function activate($id = 0) {
        $data = array(
            'status' => 1,
            'date_upd' => date('Y-m-d H:i:s')
        );
        DB::table('booking_management')->where('rest_id', '=', $id)->update($data);
    }

    function deActivate($id = 0) {
        $data = array(
            'status' => 0,
            'date_upd' => date('Y-m-d H:i:s')
        );
        DB::table('booking_management')->where('rest_id', '=', $id)->update($data);
    }

    function deleteAccount($id, $rest) {
        DB::table('booking_management')->where('id_user', '=', $id)->delete();
        DB::table('booking_branches')->where('user_id', '=', $id)->delete();
        DB::table('subscription')->where('rest_ID', '=', $rest)->delete();
    }

}
