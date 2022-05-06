<?php

class ArtWorkController extends AdminController {

    protected $Art_Work;
    protected $MGeneral;

    public function __construct() {
        parent::__construct();
        $this->Art_Work = new ArtWork();
        $this->MGeneral = new MGeneral();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $type = "";
        $limit = 20;
        $name = "";
        $status = "";
        $sort = "";
        $city_ID = 0;
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $type = $_GET['type'];
        }
        if (empty($type)) {
            $type = 'Azooma Logo';
        }

        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['city_ID']) && !empty($_GET['city_ID'])) {
            $city_ID = stripslashes($_GET['city_ID']);
        }


        $lists = $this->MGeneral->getAllArtwork($country, $type, $status, $limit, $name, $sort, $city_ID);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Artwork', 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All ' . $type . ' Artworks',
            'title' => $type . ' Artworks',
            'action' => 'adminartkwork',
            'type' => $type,
            'lists' => $lists,
            'side_menu' => array('Art Work','Slider Artwork'),
        );
        return view('admin.partials.artwork', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        Session::put('sitename', $settings['name']);
        $type = "";
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $type = $_GET['type'];
        }
        if ($id != 0) {
            $page = $this->MGeneral->getArtwork($id, 0);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->art_work_name,
                'title' => $page->art_work_name,
                'art_work_name' => $page->art_work_name,
                'page' => $page,
                'js' => 'chosen.jquery',
                'css' => 'chosen',
                'side_menu' => array('Art Work','Slider Artwork'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'art_work_name' => $type,
                'pagetitle' => 'New Artwork',
                'title' => 'New Artwork',
                'js' => 'chosen.jquery',
                'css' => 'chosen',
                'side_menu' => array('Art Work','Slider Artwork'),
            );
        }
        return view('admin.forms.artwork', $data);
    }

    public function save() {
        $filename = "";
        $art_work_name = Input::get('art_work_name');
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $temp_name = $_FILES['image']['tmp_name'];
            $filename = $file->getClientOriginalName();
            $filename = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            //get Size of the Image and reSize
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            if ($art_work_name == "Azooma Logo") {
                $largeLayer->save(Config::get('settings.uploadpath') . "/sufratilogo/", $save_name, true, null, 95);
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/sufratilogo/".$save_name);
                $changelayer=clone $layer;
                // $changelayer->resizeInPixel(183, 50);
                $changelayer->save(Config::get('settings.uploadpath') . "/sufratilogo/", $save_name, true, null, 95);
            } else {
                //Home Page slider
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 95);
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/images/".$save_name);
                $changelayer=clone $layer;
                // $changelayer->resizeInPixel(null, 380,true);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 95);
            }
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }
        $filenameAr = "";
        if (Input::hasFile('image_ar')) {
            $file = Input::file('image_ar');
            $temp_name = $_FILES['image_ar']['tmp_name'];
            $filenameAr = $file->getClientOriginalName();
            $filenameAr = $save_name = uniqid(Config::get('settings.sitename')) . $filenameAr;
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            //get Size of the Image and reSize
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            if ($art_work_name == "Azooma Logo") {
                $largeLayer->save(Config::get('settings.uploadpath') . "/sufratilogo/", $save_name, true, null, 80);
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/sufratilogo/".$save_name);
                $changelayer=clone $layer;
                // $changelayer->resizeInPixel(183, 50);
                $changelayer->save(Config::get('settings.uploadpath') . "/sufratilogo/", $save_name, true, null, 95);
            } else {
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 80);
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/images/".$save_name);
                $changelayer=clone $layer;
                // $changelayer->resizeInPixel(null, 380,true);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 95);
            }
        } elseif (isset($_POST['image_ar_old'])) {
            $filenameAr = Input::get('image_ar_old');
        }
        $status = 0;
        $url = "";
        $url = Str::slug(Input::get('name'));
        if (Input::get('status') != "") {
            $status = Input::get('status');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $city_ID = 0;
        if (Input::has('city_ID')) {
            $city_ID = implode(",", Input::get('city_ID'));
        }
        $data = array(
            'art_work_name' => (Input::get('art_work_name')),
            'img_alt' => (Input::get('img_alt')),
            'img_alt_ar' => (Input::get('img_alt_ar')),
            'country' => $country,
            'a_title' => (Input::get('title')),
            'a_title_ar' => (Input::get('title_ar')),
            'link' => (Input::get('link')),
            'link_ar' => (Input::get('link_ar')),
            'image' => $filename,
            'image_ar' => $filenameAr,
            'active' => $status,
            'city_ID' => $city_ID,
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        if (Input::get('id')) {
            DB::table('art_work')->where('id', Input::get('id'))->update($data);
        } else {
            DB::table('art_work')->insert($data);
        }
        return Redirect::route('adminartkwork', array('type' => Input::get('art_work_name')))->with(array('message' => 'Your data has been save successfully.'));
    }

    public function status($id = 0) {
        $status = 0;
        $page = ArtWork::find($id);
        if (count($page) > 0) {
            if ($page->active == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'active' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );

            DB::table('art_work')->where('id', $id)->update($data);
            return Redirect::route('adminartkwork', array('type' => $page->art_work_name))->with(array('message' => 'Your data has been save successfully.'));
        }
        return Redirect::route('adminartkwork', array('type' => $page->art_work_name))->with(array('message' => 'something went wrong, Please try again.'));
    }

    public function delete($id = 0) {
        $status = 0;
        $page = ArtWork::find($id);
        if (count($page) > 0) {
            ArtWork::destroy($id);
            return Redirect::route('adminartkwork', array('type' => $page->art_work_name))->with(array('message' => 'Your data has been save successfully.'));
        }
        return Redirect::route('adminartkwork', array('type' => $page->art_work_name))->with(array('message' => 'something went wrong, Please try again.'));
    }

}
