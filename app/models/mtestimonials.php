<?php

class MTestimonials extends Eloquent {

    protected $table = 'testimonials';

    function addTestimonial() {
        if (isset($_POST['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'country' => $country,
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),            
            'description' => htmlentities(Input::get('description')),            
            'descriptionAr' => (Input::get('descriptionAr')),
            'url' => $url,
            'status' => $status
        );
        return $insertID = DB::table('testimonials')->insertGetId($data);
        
    }

    function updateTestimonial() {
        if (isset($_POST['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('name')), '-');
        $data = array(
            'country' => $country,
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),            
            'description' => htmlentities(Input::get('description')),            
            'descriptionAr' => (Input::get('descriptionAr')),            
            'url' => $url,
            'status' => $status
        );
        DB::table('testimonials')->where('id',Input::get('id'))->update($data);
    }

}