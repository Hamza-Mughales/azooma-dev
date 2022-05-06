<?php

class MSponsor extends Eloquent {

    protected $table = 'sponsor';

    function addSponsor($logo = "", $image = "") {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'country' => $country,
            'name' => (Input::get('name')),
            'name_ar' => (Input::get('name_ar')),
            'detail' => htmlentities(Input::get('detail')),
            'detail_ar' => Input::get('detail_ar'),
            'contact' => htmlentities(Input::get('contact')),
            'contact_ar' => Input::get('contact_ar'),
            'image' => $logo,
            'image_big' => $image,
            'url' => (Input::get('url')),
            'active' => $status
        );
        return $insertID = DB::table('sponsor')->insertGetId($data);
    }

    function updateSponsor($logo = "", $image = "") {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'country' => $country,
            'name' => (Input::get('name')),
            'name_ar' => (Input::get('name_ar')),
            'detail' => htmlentities(Input::get('detail')),
            'detail_ar' => Input::get('detail_ar'),
            'contact' => htmlentities(Input::get('contact')),
            'contact_ar' => Input::get('contact_ar'),
            'image' => $logo,
            'image_big' => $image,
            'url' => (Input::get('url')),
            'active' => $status
        );
        DB::table('sponsor')->where('id', Input::get('id'))->update($data);
    }

}