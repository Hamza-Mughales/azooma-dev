<?php

class MLocation extends Eloquent {

    protected $table = 'city_list';

    function getAllCountries($status = 0, $limit = 0, $name = "") {
        $this->table = "aaa_country";
        $mcountry = MLocation::select('*');
        if ($status != 0) {
            $mcountry->where('aaa_country.status', 1);
        }
        $mcountry->orderBy('name', 'asc');
        if ($name != "") {
            $mcountry->where('name', 'LIKE', $name . '%');
        }
        if ($limit != "" && !empty($limit)) {
            $lists = $mcountry->paginate($limit);
        } else {
            $lists = $mcountry->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getUserCountryByName($name = "") {
        $this->table = "countries";
        $MCITY = MLocation::select('*');
        if ($name != "") {
            $MCITY->where('name', 'LIKE', $name . '%');
        }
        $MCITY->where('status', '=', 1);
        return $MCITY->first();
    }

    function getCountry($id) {
        $this->table = "aaa_country";
        $MCITY = MLocation::select('*');
        $MCITY->where('id', '=', $id);
        return $MCITY->first();
    }

    function addCountry($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = "";
        $url = Str::slug(Input::get('name'),'-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'currency' => (Input::get('currency')),
            'currencyAr' => (Input::get('currencyAr')),
            'facebook' => (Input::get('facebook')),
            'twitter' => (Input::get('twitter')),
            'youtube' => (Input::get('youtube')),
            'instagram' => (Input::get('instagram')),
            'google' => (Input::get('google')),
            'telephone' => (Input::get('telephone')),
            'email' => (Input::get('email')),
            'teamemail' => (Input::get('teamemail')),
            'address' => (Input::get('address')),
            'rest_backend' => (Input::get('rest_backend')),
            'flag' => $image,
            'url' => $url,
            'createdAt' => date('Y-m-d H:i:s')
        );
        return $id = DB::table('aaa_country')->insertGetId($data);
    }

    function updateCountry($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $url = "";
        $url = Str::slug(Input::get('name'),'-');
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'currency' => (Input::get('currency')),
            'currencyAr' => (Input::get('currencyAr')),
            'facebook' => (Input::get('facebook')),
            'twitter' => (Input::get('twitter')),
            'youtube' => (Input::get('youtube')),
            'instagram' => (Input::get('instagram')),
            'google' => (Input::get('google')),
            'telephone' => (Input::get('telephone')),
            'email' => (Input::get('email')),
            'teamemail' => (Input::get('teamemail')),
            'address' => (Input::get('address')),
            'rest_backend' => (Input::get('rest_backend')),
            'flag' => $image,
            'url' => $url,
            'createdAt' => date('Y-m-d H:i:s')
        );
        DB::table('aaa_country')->where('id', Input::get('id'))->update($data);
    }

    function deleteCountry($id) {
        DB::table('aaa_country')->where('id', $id)->delete();
    }

    function getAllCities($status = 0, $limit = 0, $name = "", $country_ID = 0) {
        $this->table = "city_list";
        $mcity = MLocation::select('*');
        if ($status != 0) {
            $mcity->where('city_list.city_Status', 1);
        }
        $mcity->orderBy('city_Name', 'asc');
        if ($name != "") {
            $mcity->where('city_Name', 'LIKE', $name . '%');
        }
        if (!empty($country_ID)) {
            $mcity->where('country', '=', $country_ID);
        }
        if ($limit != "") {
            $lists = $mcity->paginate($limit);
        } else {
            $lists = $mcity->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function getCity($id) {
        $this->table = "city_list";
        $MCITY = MLocation::select('*');
        $MCITY->where('city_ID', '=', $id);
        return $MCITY->first();
    }

    function addCity($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('city_Name')), '-');
        $data = array(
            'country' => $country,
            'city_Name' => (Input::get('city_Name')),
            'city_Name_ar' => (Input::get('city_Name_ar')),
            'city_Code' => (Input::get('city_Code')),
            'city_Status' => $status,
            'city_thumbnail' => $image,
            'seo_url' => $url,
            'city_Description' => (Input::get('city_Description')),
            'city_Description_Ar' => (Input::get('city_Description_Ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return $id = DB::table('city_list')->insertGetId($data);
    }

    function updateCity($image = "") {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $url = Str::slug((Input::get('city_Name')), '-');
        $data = array(
            'country' => $country,
            'city_Name' => (Input::get('city_Name')),
            'city_Name_ar' => (Input::get('city_Name_ar')),
            'city_Code' => (Input::get('city_Code')),
            'city_Status' => $status,
            'city_thumbnail' => $image,
            'seo_url' => $url,
            'city_Description' => (Input::get('city_Description')),
            'city_Description_Ar' => (Input::get('city_Description_Ar')),
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('city_list')->where('city_ID', Input::get('city_ID'))->update($data);
    }

    function deleteCity($id) {
        DB::table('city_list')->where('city_ID', $id)->delete();
    }

    function getAllDistricts($country = 0, $status = 0, $limit = 0, $name = "", $city_ID = "") {
        $mcity = DB::table('district_list');
        if ($country != 0) {
            $mcity->where('district_list.country', $country);
        }
        if ($status != 0) {
            $mcity->where('district_list.district_Status', 1);
        }

        if ($city_ID != 0) {
            $mcity->where('district_list.city_ID', $city_ID);
        }
        $mcity->orderBy('district_Name', 'asc');
        if ($name != "") {
            $mcity->where('district_Name', 'LIKE', $name . '%');
        }
        if ($limit != "") {
            $lists = $mcity->paginate($limit);
        } else {
            $lists = $mcity->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }


    function getDistrict($id) {
        $this->table = "district_list";
        $MDistrict = MLocation::select('*');
        $MDistrict->where('district_ID', '=', $id);
        return $MDistrict->first();
    }

    function addDistrict() {
        $status = 0;
        if (isset($_POST['district_Status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('district_Name')), '-');
        $data = array(
            'district_Name' => (Input::get('district_Name')),
            'district_Name_ar' => (Input::get('district_Name_ar')),
            'city_ID' => (Input::get('city_ID')),
            'district_Status' => $status,
            'seo_url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('district_list')->insertGetId($data);
    }

    function updateDistrict() {
        $status = 0;
        if (isset($_POST['district_Status'])) {
            $status = 1;
        }
        $url = Str::slug((Input::get('district_Name')), '-');
        $data = array(
            'district_Name' => (Input::get('district_Name')),
            'district_Name_ar' => (Input::get('district_Name_ar')),
            'city_ID' => (Input::get('city_ID')),
            'district_Status' => $status,
            'seo_url' => $url,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('district_list')->where('district_ID', Input::get('district_ID'))->update($data);
    }

    function deleteDistrict($id) {
        DB::table('district_list')->where('district_ID', $id)->delete();
    }

}
