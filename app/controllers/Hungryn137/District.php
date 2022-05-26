<?php

class District extends AdminController
{

    protected $MAdmins;
    protected $MLocation;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MLocation = new MLocation();
    }

    public function index()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $limit = 5000;
        $status = 0;
        $country = 1;
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $name = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        $lists = $this->MLocation->getAllDistricts($country, $status, $limit, $name);
        // dd($lists, $country, $status, $limit, $name);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('District Name', 'City Name', 'Last updated At', 'Actions'),
            'pagetitle' => 'All Districts',
            'title' => 'Districts',
            'action' => 'admindistrict',
            'lists' => $lists,
            'side_menu' => array('Locations', 'District List'),
        );

        return view('admin.partials.district', $data);
    }

    public function form($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $cities = $this->MLocation->getAllCities();
        if ($id != 0) {
            $page = $this->MLocation->getDistrict($id);
            $data = array(
                'sitename' => $settings['name'],
                'cities' => $cities,
                'pagetitle' => $page->district_Name,
                'title' => $page->district_Name,
                'page' => $page,
                'side_menu' => array('Locations', 'District List'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'cities' => $cities,
                'pagetitle' => 'New District Name',
                'title' => 'New District Name',
                'side_menu' => array('Locations', 'District List'),
            );
        }
        return view('admin.forms.district', $data);
    }

    public function save()
    {
        if (Input::get('district_ID')) {
            $id = Input::get('district_ID');
            $this->MLocation->updateDistrict();
            $obj = $this->MLocation->getDistrict($id);
            $this->MAdmins->addActivity('District updated Succesfully ' . $obj->city_Name);

            return returnMsg('success', 'admindistrict', 'District updated Succesfully.');
        } else {
            $id = $this->MLocation->addDistrict();
            $obj = $this->MLocation->getDistrict($id);
            $this->MAdmins->addActivity('District added Succesfully ' . $obj->city_Name);

            return returnMsg('success', 'admindistrict', 'District added Succesfully.');
        }

        return returnMsg('error', 'admindistrict', 'something went wrong, Please try again.');
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MLocation->getDistrict($id);
        if (count($page) > 0) {
            if ($page->district_Status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'district_Status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );
            DB::table('district_list')->where('district_ID', $id)->update($data);
            $this->MAdmins->addActivity('District Status changed successfully.' . $page->city_Name);

            return returnMsg('success', 'admindistrict', 'District Status changed successfully.');
        }

        return returnMsg('error', 'admindistrict', 'Something went wrong, Please try again.');
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MLocation->getDistrict($id);
        if (count($page) > 0) {
            $this->MLocation->deleteDistrict($id);
            $this->MAdmins->addActivity('District deleted successfully.' . $page->city_Name);

            return returnMsg('success', 'admindistrict', 'District deleted successfully.');
        }

        return returnMsg('error', 'admindistrict', 'Something went wrong, Please try again.');
    }
}
