<?php

class RestGallery extends AdminController {

    protected $MAdmins;
    protected $MGeneral;
    protected $MGallery;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
        $this->MGallery = new MGallery();
    }

    public function index($restID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $limit = 500;
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = mysql_real_escape_string($_GET['limit']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $country = 1;
        $rest = $this->MRestActions->getRest($restID);
        $lists = $lists = $this->MGallery->getAllImages($country, $restID, 0, "");

        $data = array(
            'sitename' => $settings['name'],
            'MGeneral' => $this->MGeneral,
            'headings' => array('Title', 'Preview', 'Uploaded By', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Images for ' . $rest->rest_Name,
            'title' => 'All Images for ' . $rest->rest_Name,
            'action' => 'adminrestgallery',
            'lists' => $lists,
            'rest_ID' => $restID,
            'rest' => $rest,
            'side_menu' => ['adminrestaurants','Add Restaurants'],
        );

        return view('admin.partials.restaurantgallery', $data);
    }

    public function form($image_ID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if (Input::has('rest_ID')) {
            $rest_ID = Input::get('rest_ID');
        } else {
            
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        if ($image_ID == 0) {
            $data = array(
                'pagetitle' => 'New Photo for ' . stripslashes($rest->rest_Name),
                'title' => 'New Photo for ' . stripslashes($rest->rest_Name),
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'rest' => $rest,
                'rest_ID' => $rest_ID,
                'js' => 'chosen.jquery,admin/branchform',
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        } else {
            $image = $this->MRestActions->getRestImage($image_ID);
            $data = array(
                'pagetitle' => 'Updating Photo ' . stripslashes($image->title),
                'title' => 'Updating Photo ' . stripslashes($image->title),
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'rest' => $rest,
                'image' => $image,
                'rest_ID' => $rest_ID,
                'js' => 'chosen.jquery,admin/branchform',
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        }
        return view('admin.forms.restgallery', $data);
    }

    public function save() {
        $rest = Input::get('rest_ID');
        $restaurant = $this->MRestActions->getRest($rest);
        $restname = stripslashes($restaurant->rest_Name);
        if (Input::get('title')) {
            $image = "";
            $actualWidth = "";
            $ratio = "0";
            if (Input::hasFile('image_full')) {
                $file = Input::file('image_full');
                $temp_name = $_FILES['image_full']['tmp_name'];
                $image = $save_name = uniqid(Config::get('settings.sitename')) . $file->getClientOriginalName();
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
                    return Redirect::route('adminrestmenu/', array('id' => $rest, 'cat_id' => $cat, 'menu_id' => $menu_id, 'item' => $cat))->with('message', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                }
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/fullsize/", $save_name, true, null, 80);
                $text_font = $restaurant->rest_Name . '-' . Input::get('title') . '- azooma.co';
                $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                $textLayer->opacity(75);
                $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                if (($actualWidth > 800)) {
                    $largeLayer->resizeInPixel(800, null, $conserveProportion, $positionX, $positionY, $position);
                }else{
                    if($actualHeight>500){
                        $largeLayer->resizeInPixel(null, 500, $conserveProportion, $positionX, $positionY, $position);  
                    }
                }

                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/", $save_name, true, null, 95);

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
                $theight = $actualHeight * (400 / $actualWidth);
                $expectedWidth = 400;
                $expectedHeight = $theight;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer=clone $layer;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/400x/", $save_name, true, null, 95);
                $changelayer=clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/thumb/", $save_name, true, null, 95);

                
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $largeLayer->resizeInPixel(200, $height1, $conserveProportion, $positionX, $positionY, $position);

                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/200/", $save_name, true, null, 95);
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $largeLayer->resizeInPixel(230, $height2, $conserveProportion, $positionX, $positionY, $position);
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/230/", $save_name, true, null, 95);
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $largeLayer->resizeInPixel(45, 45, $conserveProportion, $positionX, $positionY, $position);
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/45/", $save_name, true, null, 95);
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $largeLayer->resizeInPixel(200, 200, false);
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/200x200/", $save_name, true, null, 95);
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $largeLayer->resizeInPixel(150, 150, $conserveProportion, $positionX, $positionY, $position);
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/150x150/", $save_name, true, null, 95);
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $theight = $actualHeight * (400 / $actualWidth);
                $largeLayer->resizeInPixel(400, $theight, FALSE, $positionX, $positionY, $position);
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/400x/", $save_name, true, null, 95);
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath')."/Gallery/".$save_name);
                $thumbLayer->resizeInPixel(100, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                $thumbLayer->save(Config::get('settings.uploadpath')  . "/Gallery/thumb", $save_name, true, null, 95);
                
            } else {
                if (Input::has('image_full_old')) {
                    $image = Input::get('image_full_old');
                }
                if (Input::has('ratio_old')) {
                    $ratio = Input::get('ratio_old');
                }
                if (Input::has('width_old')) {
                    $actualWidth = Input::get('width_old');
                }
            }

            if (Input::get('image_ID')) {
                $this->MRestActions->updateRestImage($image, $ratio, $actualWidth);
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                $this->MAdmins->addActivity('Image updated ' . $restname);
                $this->MAdmins->addRestActivity('A new image is added.', $restaurant->rest_ID, Input::get('image_ID'));
                return Redirect::route('adminrestgallery/', $rest)->with('message', "image updated Successfully.");
            } else {
                $last_inserted_id = $this->MRestActions->addRestImage($image, $ratio, $actualWidth);
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                $this->MAdmins->addRestActivity('A new image is added.', $restaurant->rest_ID, $last_inserted_id);
                $this->MAdmins->addActivity('Image Added ' . $restname);
                return Redirect::route('adminrestgallery/', $rest)->with('message', "image Added successfully.");
            }
        } else {
            show_404();
        }
    }

    public function delete($image_ID = 0) {
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
        } else {
            return Redirect::route('adminrestgallery', $rest)->with('error', "something went wrong, Please try again.");
        }
        $this->MRestActions->deleteRestImage($image_ID);
        $this->MRestActions->updateRestLastUpdatedOn($rest);
        $this->MAdmins->addActivity('Image deleted ' . stripslashes(($rest_data->rest_Name)));
        return Redirect::route('adminrestgallery/', $rest)->with('message', "Image deleted succesfully");
    }

    function makeFeaturedImage($image = 0) {
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
        } else {
            return Redirect::route('adminrestgallery', $rest)->with('error', "something went wrong, Please try again.");
        }
        if ($image != 0 && $rest != 0) {
            $this->MRestActions->makeFeaturedImage($image, $rest);
            $this->MRestActions->updateRestLastUpdatedOn($rest);
            $this->MAdmins->addActivity('Featured Image succesfully ' . stripslashes(($rest_data->rest_Name)));
            return Redirect::route('adminrestgallery/', $rest)->with('message', "Image Featured succesfully");
        } else {
            return Redirect::route('adminrestgallery/', $rest)->with('error', "Some error happened Please try again");
        }
    }

    function unsetFeaturedImage($image = 0) {
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
        } else {
            return Redirect::route('adminrestgallery', $rest)->with('error', "something went wrong, Please try again.");
        }
        if ($image != 0 && $rest != 0) {
            $this->MRestActions->unsetFeaturedImage($image, $rest);
            $this->MRestActions->updateRestLastUpdatedOn($rest);
            $this->MAdmins->addActivity('Featured Image succesfully ' . stripslashes(($rest_data->rest_Name)));
            return Redirect::route('adminrestgallery/', $rest)->with('message', "Image removed from Featured succesfully");
        } else {
            return Redirect::route('adminrestgallery/', $rest)->with('error', "Some error happened Please try again");
        }
    }
    
    public function videos($restID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $limit = 5000;

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $country = 1;
        $rest = $this->MRestActions->getRest($restID);
        $lists = $lists = $this->MGallery->getAllVideos($country, $restID, 0, "",5000);

        $data = array(
            'sitename' => $settings['name'],
            'MGeneral' => $this->MGeneral,
            'headings' => array('Title', 'Preview', 'Uploaded By', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Videos for ' . $rest->rest_Name,
            'title' => 'All Videos for ' . $rest->rest_Name,
            'action' => 'admingallery',
            'lists' => $lists,
            'rest_ID' => $restID,
            'rest' => $rest,
            'side_menu' => ['adminrestaurants','Add Restaurants'],
        );

        // dd($data);
        return view('admin.partials.restaurantvideos', $data);
    }
    
    public function videoform($video_ID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if (Input::has('rest_ID')) {
            $rest_ID = Input::get('rest_ID');
        } else {
            
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        if ($video_ID == 0) {
            $data = array(
                'pagetitle' => 'New Video for ' . stripslashes($rest->rest_Name),
                'title' => 'New Video for ' . stripslashes($rest->rest_Name),
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'action' => 'admingallery',
                'rest' => $rest,
                'rest_ID' => $rest_ID,
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        } else {
            $video = $this->MGallery->getRestVideo($video_ID);
            $data = array(
                'pagetitle' => 'Updating Video ' . stripslashes($video->name_en),
                'title' => 'Updating Video ' . stripslashes($video->name_en),
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'rest' => $rest,
                'action' => 'admingallery',
                'video' => $video,
                'rest_ID' => $rest_ID,
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        }
        return view('admin.forms.restvideo', $data);
    }
    
    public function videosave() {
        $rest = Input::get('rest_ID');
        $restaurant = $this->MRestActions->getRest($rest);
        $restname = stripslashes($restaurant->rest_Name);
        if (Input::get('name_en')) {
            if (Input::get('id')) {
                $this->MGallery->updateVideo();
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                $this->MAdmins->addActivity('Video updated ' . $restname);
                $this->MAdmins->addRestActivity('A new Video is added.', $restaurant->rest_ID, Input::get('id'));
                return returnMsg('success','adminrestaurants/videos/','Video updated Successfully.',[$rest]);
            } else {
                $last_inserted_id = $this->MGallery->addVideo();
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                $this->MAdmins->addRestActivity('A new Video is added.', $restaurant->rest_ID, $last_inserted_id);
                $this->MAdmins->addActivity('Video Added ' . $restname);
                return returnMsg('success','adminrestaurants/videos/','Video Added Successfully.',[$rest]);

            }
        } else {
            show_404();
        }
    }
    
    public function videodelete($video_ID = 0) {
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
        } else {
            return returnMsg('success','adminrestaurants', "something went wrong, Please try again.");

        }
        $this->MGallery->deleteVideo($video_ID);
        $this->MRestActions->updateRestLastUpdatedOn($rest);
        $this->MAdmins->addActivity('Video deleted for ' . stripslashes(($rest_data->rest_Name)));
        return returnMsg('success','adminrestaurants/videos/','Video deleted Successfully.',[$rest]);

    }
    
    public function videostatus($id = 0) {
        $status = 0;
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
        } else {
            return returnMsg('success','adminrestaurants', "something went wrong, Please try again.");
        }
        $page = $this->MGallery->getRestVideo($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );

            DB::table('rest_video')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Video Status changed successfully.' . $page->name_en);
            return returnMsg('success','adminrestaurants/videos/','Video Status changed successfully.',[$rest]);

        }
        return returnMsg('error','adminrestaurants/videos/','something went wrong, Please try again.',[$rest]);

    }

}
