<?php

class Gallery extends AdminController {

    protected $MAdmins;
    protected $MGeneral;
    protected $Gallery;
    protected $MLocation;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->Gallery = new MGallery();
        $this->MLocation = new MLocation();
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
        $limit = 20;
        $rest = "";
        $user = "";
        $type = "";
        $name = "";
        $status = "";
        $sort = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['rest']) && !empty($_GET['rest'])) {
            $rest = stripslashes($_GET['rest']);
        }

        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $type = $_GET['type'];
            switch ($type) {
                case "All":
                    $user = "";
                    break;
                case "Sufrati":
                    $user = 0;
                    break;
                case "Users":
                    $user = 1;
                    break;
            }
        }
        $lists = $this->Gallery->getAllImages($country, $rest, $status, $user, $limit, $sort);
        $data = array(
            'sitename' => $settings['name'],
            'type' => $type,
            'headings' => array('Thumb', 'Restaurant', 'Upload By', 'Last update', 'Actions'),
            'pagetitle' => 'All Photos',
            'title' => 'Photos',
            'action' => 'admingallery',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Gallery','Food Gallery'),
        );
        return view('admin.partials.photos', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $type = "";
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $type = $_GET['type'];
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $restaurants = MRestActions::getAllRestaurants($country, "", 1);
        if ($id != 0) {
            $page = $this->Gallery->getPhoto($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->title,
                'title' => $page->title,
                'type' => $type,
                'restaurants' => $restaurants,
                'page' => $page,
                'side_menu' => array('Gallery','Food Gallery'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Photo',
                'type' => $type,
                'restaurants' => $restaurants,
                'title' => 'New Photo',
                'side_menu' => array('Gallery','Food Gallery'),
            );
        }
        $data['country'] = $country;
        return view('admin.forms.photos', $data);
    }

    public function save() {
        $image = "";
        $actualWidth = 0;
        $ratio = 0;
        if (Input::hasFile('image_full')) {
            $file = Input::file('image_full');
            $temp_name = $_FILES['image_full']['tmp_name'];
            $image = $file->getClientOriginalName();
            $image = $save_name = uniqid(Config::get('settings.sitename')) . $image;
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
                $thumbLayer = clone $largeLayer;
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                if ($actualWidth <= 400 && $actualHeight <= 400) {
                    return Redirect::route('admingallery/form')->with('message', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                }
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/fullsize/", $save_name, true, null, 80);
                $text_font = $save_name . '-' . Input::get('title') . '- azooma.co';
                $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                $textLayer->opacity(75);
                $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                if (($actualWidth > 800)) {
                 // $largeLayer->resizeInPixel(1500, null, $conserveProportion, $positionX, $positionY, $position);
                }else{
                    if ($actualHeight>500){
                       // $largeLayer->resizeInPixel(null, 800, $conserveProportion, $positionX, $positionY, $position);  
                    }
                }

                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/", $save_name, true, null, 80);

                $height1 = round($actualHeight * (200 / $actualWidth));
                $height2 = round($actualHeight * (230 / $actualWidth));
                
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer=clone $layer;
                $expectedWidth = 200;
                $expectedHeight = $height1;
                  ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
               $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/200/", $save_name, true, null, 95);
                $changelayer=clone $layer;
                $expectedWidth = 230;
                $expectedHeight = $height2;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/230/", $save_name, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(45, 45);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/45/", $save_name, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(200, 200);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/200x200/", $save_name, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(150, 150);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/150x150/", $save_name, true, null, 95);
                $theight = $actualHeight * (1000 / $actualWidth);
                $expectedWidth = 1000;
                $expectedHeight = $theight;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer=clone $layer;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/400x/", $save_name, true, null, 80);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/thumb/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_full_old'])) {
            $image = Input::get('image_full_old');
            $ratio = Input::get('ratio_old');
        }
        if (Input::get('image_ID')) {
            $id = Input::get('image_ID');
            $this->Gallery->updateImage($image, $ratio, $actualWidth);
            $obj = $this->Gallery->getPhoto($id);
            $this->MAdmins->addActivity('Photo updated Succesfully - ' . $obj->title);
            return Redirect::route('admingallery', array('type' => Input::get('type')))->with('message', "Photo updated Succesfully.");
        } else {
            $id = $this->Gallery->addImage($image, $ratio, $actualWidth);
            $obj = $this->Gallery->getPhoto($id);
            $this->MAdmins->addActivity('Photo Added Succesfully - ' . $obj->title);
            return Redirect::route('admingallery', array('type' => Input::get('type')))->with('message', "Photo Added Succesfully.");
        }
        return Redirect::route('admingallery', array('type' => Input::get('type')))->with('error', "something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->Gallery->getPhoto($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );

            DB::table('image_gallery')->where('image_ID', $id)->update($data);
            $this->MAdmins->addActivity('Photo Status changed successfully.' . $page->title);
            return Redirect::route('admingallery', array('type' => $_GET['type']))->with('message', "Photo Status changed successfully.");
        }
        return Redirect::route('admingallery', array('type' => $_GET['type']))->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->Gallery->getPhoto($id);
        if (count($page) > 0) {
            DB::table('image_gallery')->where('image_ID', $id)->delete();
            $this->MAdmins->addActivity('Photo Deleted successfully.' . $page->title);
            return Redirect::route('admingallery', array('type' => $_GET['type']))->with('message', "Photo Deleted successfully.");
        }
        return Redirect::route('admingallery', array('type' => $_GET['type']))->with('error', "something went wrong, Please try again.");
    }

    public function videos() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $name = "";
        $limit = 20;
        $rest = "";
        $user = "";
        $type = "";
        $name = "";
        $status = "";
        $sort = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['rest']) && !empty($_GET['rest'])) {
            $rest = stripslashes($_GET['rest']);
        }

        $lists = $this->Gallery->getAllVideos($country, $rest, $status, $name, $limit, $sort);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Thumb', 'Restaurant', 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All Videos',
            'title' => 'All Videos',
            'action' => 'admingallery',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Gallery','Video Uploads'),
        );
        return view('admin.partials.videos', $data);
    }

    public function videoform($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = 1;
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $restaurants = MRestActions::getAllRestaurants($country, '', 1);
        if ($id != 0) {
            $page = $this->Gallery->getRestVideo($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name_en,
                'title' => $page->name_en,
                'restaurants' => $restaurants,
                'page' => $page,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
            'side_menu' => array('Gallery','Video Uploads'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Video',
                'restaurants' => $restaurants,
                'title' => 'New Video',
                'css' => 'chosen',
                'js' => 'chosen.jquery',
            'side_menu' => array('Gallery','Video Uploads'),
            );
        }
        return view('admin.forms.video', $data);
    }

    public function videosave() {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->Gallery->updateVideo();
            $obj = $this->Gallery->getRestVideo($id);
            $this->MAdmins->addActivity('Video updated Succesfully - ' . $obj->name_en);
            return Redirect::route('admingallery/videos')->with('message', "Video updated Succesfully.");
        } else {
            $id = $this->Gallery->addVideo();
            $obj = $this->Gallery->getRestVideo($id);
            $this->MAdmins->addActivity('Video Added Succesfully - ' . $obj->name_en);
            return Redirect::route('admingallery/videos')->with('message', "Video Added Succesfully.");
        }
        return Redirect::route('admingallery/videos')->with('error', "something went wrong, Please try again.");
    }

    public function videostatus($id = 0) {
        $status = 0;
        $page = $this->Gallery->getRestVideo($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );
            DB::table('rest_video')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Video Status changed successfully.' . $page->name_en);
            return Redirect::route('admingallery/videos')->with('message', "Video Status changed successfully.");
        }
        return Redirect::route('admingallery/videos')->with('error', "something went wrong, Please try again.");
    }

    public function videodelete($id = 0) {
        $status = 0;
        $page = $this->Gallery->getRestVideo($id);
        if (count($page) > 0) {
            DB::table('rest_video')->where('id', $id)->delete();
            $this->MAdmins->addActivity('Video Deleted successfully.' . $page->name_en);
            return Redirect::route('admingallery/videos')->with('message', "Video Deleted successfully.");
        }
        return Redirect::route('admingallery/videos')->with('error', "something went wrong, Please try again.");
    }

}
