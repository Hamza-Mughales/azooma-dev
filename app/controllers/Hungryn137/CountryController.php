<?php

class CountryController extends AdminController
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
        if(!is_owner()){
         return   Redirect::route('adminhome');
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $logo = ArtWork::where('art_work_name', '=', 'Azooma Logo')->orderBy('createdAt', 'DESC')->first();
        $limit = 500;
        $status = 0;
        $name = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }

        $lists = $this->MLocation->getAllCountries($status, $limit, $name);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Last updated At', 'Actions'),
            'pagetitle' => 'All Countries',
            'title' => 'Countries',
            'action' => 'admincountry',
            'lists' => $lists,
            'side_menu' => array('Locations', 'Country List'),
        );

        return view('admin.partials.country', $data);
    }

    public function form($id = 0)
    {
        if(!is_owner()){
            return   Redirect::route('adminhome');
           }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $countries = DB::table('aaa_country')
        ->get();
        if ($id != 0) {
            $page = $this->MLocation->getCountry($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                "countries"=> $countries ,
                'side_menu' => array('Locations', 'Country List'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Country Name',
                'title' => 'New Country Name',
                'side_menu' => array('Locations', 'Country List'),
            );
        }
        return view('admin.forms.country', $data);
    }

    public function save()
    {
        $filename = "";
        if (Input::hasFile('countryflag')) {
            $file = Input::file('countryflag');
            $temp_name = $_FILES['countryflag']['tmp_name'];
            $filename = $file->getClientOriginalName();
            $filename = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            $thumbLayer = clone $largeLayer;
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/flag/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/flag/" . $save_name);
            $changelayer = clone $layer;
            // $changelayer->resizeInPixel(150, 150);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/flag/", $save_name, true, null, 95);
        } elseif (isset($_POST['countryflag_old'])) {
            $filename = Input::get('countryflag_old');
        }

        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MLocation->updateCountry($filename);
            $obj = $this->MLocation->getCountry($id);
            $this->MAdmins->addActivity('Country updated Succesfully ' . $obj->city_Name);

            return returnMsg('success', 'admincountry', 'Country updated Succesfully.');
        } else {
            $id = $this->MLocation->addCountry($filename);
            $obj = $this->MLocation->getCountry($id);
            $this->MAdmins->addActivity('Country added Succesfully ' . $obj->city_Name);

            return returnMsg('success', 'admincountry', 'Country added Succesfully.');
        }

        return returnMsg('error', 'admincountry', 'Something went wrong, Please try again.');
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MLocation->getCountry($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('countries')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Country Status changed successfully.' . $page->city_Name);

            return returnMsg('success', 'admincountry', 'Country Status changed successfully.');
        }

        return returnMsg('error', 'admincountry', 'Something went wrong, Please try again.');
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MLocation->getCountry($id);
        if (count($page) > 0) {
            $this->MLocation->deleteCountry($id);
            $this->MAdmins->addActivity('Country deleted successfully.' . $page->city_Name);

            return returnMsg('success', 'admincountry', 'Country deleted successfully.');
        }
        return Redirect::route('admincountry')->with('', "something went wrong, Please try again.");
        return returnMsg('error', 'admincountry', 'something went wrong, Please try again.');
    }
}
