<?php

class AdminSettings extends AdminController
{

    public function index($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $DBsettings = DB::table('settings')->where('country', $country)->first();
        if (count($DBsettings) > 0) {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'Website Settings',
                'title' => 'Website Settings',
                'settings' => $DBsettings
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'Website Settings',
                'title' => 'Website Settings',
            );
        }
        return view('admin.forms.settings', $data);
    }

    public function save()
    {
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => Input::get('nameAr'),
            'countryname' => (Input::get('countryname')),
            'countrynameAr' => Input::get('countrynameAr'),
            'instagram' => Input::get('instagram'),
            'fax' => Input::get('fax'),
            'currency' => Input::get('currency'),
            'currencyAr' => Input::get('currencyAr'),
            'keywords' => Input::get('keywords'),
            'keywordsAr' => Input::get('keywordsAr'),
            'email' => Input::get('email'),
            'keywords' => (Input::get('keywords')),
            'keywordsAr' => Input::get('keywordsAr'),
            'twitter' => (Input::get('twitter')),
            'facebook' => (Input::get('facebook')),
            'linkedin' => (Input::get('linkedin')),
            'youtube' => (Input::get('youtube')),
            'address' => nl2br(Input::get('address')),
            'addressAr' => nl2br(Input::get('addressAr')),
            'tel' => Input::get('tel'),
            'fax' => Input::get('fax'),
            'country' => $country,
            'mobile' => Input::get('mobile')
        );

        if (Input::get('id')) {
            DB::table('settings')->where('id', Input::get('id'))->update($data);
        } else {
            DB::table('settings')->insert($data);
        }

        return returnMsg('success', 'adminsettings', 'Your data has been save successfully.');
    }
}
