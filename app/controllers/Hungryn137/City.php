<?php

class City extends AdminController {

    protected $MAdmins;
    protected $MLocation;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MLocation = new MLocation();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $logo = ArtWork::where('art_work_name', '=', 'Azooma Logo')->orderBy('createdAt', 'DESC')->first();
        $limit = 5000;
        $status = 0;
        $name = "";
        $country_id=get('country_id');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }

        $lists = $this->MLocation->getAllCities($status, $limit, $name,$country_id);

        $data = array(
            'logo' => $logo,
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Last updated At', 'Actions'),
            'pagetitle' => 'All Cities',
            'title' => 'Cities',
            'action' => 'admincity',
            'lists' => $lists,
            'side_menu' => array('Locations','City List'),
        );

        return view('admin.partials.city', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if ($id != 0) {
            $page = $this->MLocation->getCity($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->city_Name,
                'title' => $page->city_Name,
                'page' => $page,
            'side_menu' => array('Locations','City List'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New City Name',
                'title' => 'New City Name',
            'side_menu' => array('Locations','City List'),
            );
        }
        return view('admin.forms.city', $data);
    }

    public function save() {
        $filename = "";
        if (Input::hasFile('city_thumbnail')) {
            $file = Input::file('city_thumbnail');
            $temp_name = $_FILES['city_thumbnail']['tmp_name'];
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
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/city/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/city/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            // $changelayer->resizeInPixel(150, 150);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/city/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/city/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            // $changelayer->resizeInPixel(100, 100);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/city/thumb/", $save_name, true, null, 95);
        } elseif (isset($_POST['city_thumbnail_old'])) {
            $filename = Input::get('city_thumbnail_old');
        }

        if (Input::get('city_ID')) {
            $id = Input::get('city_ID');
            $this->MLocation->updateCity($filename);
            $obj = $this->MLocation->getCity($id);
            $this->MAdmins->addActivity('City updated Succesfully ' . $obj->city_Name);

            return returnMsg('success','admincity','City updated Succesfully.');
        } else {
            $id = $this->MLocation->addCity($filename);
            $obj = $this->MLocation->getCity($id);
            $this->MAdmins->addActivity('City added Succesfully ' . $obj->city_Name);
            
            return returnMsg('success','admincity','City added Succesfully.');
        }
        
        return returnMsg('error','admincity','Something went wrong, Please try again..');
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MLocation->getCity($id);
        if (count($page) > 0) {
            if ($page->city_Status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'city_Status' => $status
            );
            DB::table('city_list')->where('city_ID', $id)->update($data);
            $this->MAdmins->addActivity('City Status changed successfully.' . $page->city_Name);
            
            return returnMsg('success','admincity','City Status changed successfully.');
        }
        
        return returnMsg('error','admincity','Something went wrong, Please try again.');
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MLocation->getCity($id);
        if (count($page) > 0) {
            $this->MLocation->deleteCity($id);
            $this->MAdmins->addActivity('City deleted successfully.' . $page->city_Name);
            
            return returnMsg('success','admincity','City deleted successfully.');
        }
        
        return returnMsg('error','admincity','Something went wrong, Please try again.');
    }

}
