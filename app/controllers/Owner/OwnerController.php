<?php

// use Illuminate\Support\Facades\Redirect;

class OwnerController extends OwnerBaseController
{


	function __construct()
	{
        if (!is_owner()) {
            // dd(is_owner(), 'll');
            $this->back();
		}
	}
    
    public function back()
    {      
        return Redirect::route('adminlogin');
    }
	public function ownerHome()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
     
        $countries = DB::table('aaa_country')
            ->get();
    
        $data = array(
            'sitename' => $settings['name'],
            'pagetitle' => 'Owner Dashboard',
            'title' => 'Dashboard',
            'action' => 'dashboard',
            'partials_name' => 'coursescatpage',
            "countries"=>$countries,
            'side_menu' => array('home'),
        );

        return view('admin.owner.home', $data);
    }

    public function countryDashboard($id){
        
        Session::forget('admincountry');
        Session::put('admincountry', $id);
        $this->MGeneral = new MGeneral();
        Session::put('admincountryName', Str::slug($this->MGeneral->getAdminCountryName($id), '-', TRUE));
        return Redirect::route('adminhome');

    }

}
