<?php

class MPress extends Eloquent {

    protected $table = 'press';

    function addPress($image = "") {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $url = Str::slug((Input::get('short')), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'short' => (Input::get('short')),
            'short_ar' => (Input::get('short_ar')),
            'full' => htmlentities(Input::get('full')),
            'full_ar' => Input::get('full_ar'),
            'image' => $image,
            'author' => (Input::get('author')),
            'author_ar' => (Input::get('author_ar')),
            'seo_url' => $url,
            'country' => $country,
            'status' => $status
        );
        return $insertID = DB::table('press')->insertGetId($data);
    }

    function updatePress($image = "") {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $url = Str::slug((Input::get('short')), '-');
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'short' => (Input::get('short')),
            'short_ar' => (Input::get('short_ar')),
            'full' => htmlentities(Input::get('full')),
            'full_ar' => Input::get('full_ar'),
            'image' => $image,
            'author' => (Input::get('author')),
            'author_ar' => (Input::get('author_ar')),
            'country' => $country,
            'seo_url' => $url,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('press')->where('id', Input::get('id'))->update($data);
    }

}