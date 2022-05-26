<?php

class Settings extends AdminController
{

    public function index($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = Contents::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->title,
                'title' => $page->title,
                'page' => $page
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'Website Settings',
                'title' => 'Website Settings',
                'settings' => $settings
            );
        }
        return View::make('admin.index', $data)->nest('content', 'admin.forms.settings', $data);
    }

    public function save()
    {
        $data = array(
            'name' => mysql_real_escape_string(Input::get('name')),
            'nameAr' => Input::get('nameAr'),
            'email' => Input::get('email'),
            'keywords' => mysql_real_escape_string(Input::get('keywords')),
            'keywordsAr' => Input::get('keywordsAr'),
            'twitter' => mysql_real_escape_string(Input::get('twitter')),
            'facebook' => mysql_real_escape_string(Input::get('facebook')),
            'linkedin' => mysql_real_escape_string(Input::get('linkedin')),
            'youtube' => mysql_real_escape_string(Input::get('youtube')),
            'address' => nl2br(Input::get('address')),
            'addressAr' => nl2br(Input::get('addressAr')),
            'tel' => Input::get('tel'),
            'fax' => Input::get('fax'),
            'mobile' => Input::get('mobile')
        );

        if (Input::get('id')) {
            DB::table('settings')->where('id', Input::get('id'))->update($data);
        } else {
            return Redirect::route('adminsettings')->with('error', "something went wrong, Please try again");
        }
        return Redirect::route('adminsettings')->with('message', "Your data has been save successfully.");
    }
}
