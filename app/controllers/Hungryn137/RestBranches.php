<?php

use Illuminate\Support\Facades\Input;

class RestBranches extends AdminController
{

    protected $MAdmins;
    protected $MGeneral;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
    }

    public function index($restID = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $sort = "latest";
        $limit = 500;
        $offset = 0;
        $to_excel = false;
        $city = $cuisine = $bestfor = $status = $member = $restaurant = "";
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['city']) && ($_GET['city'] != "")) {
            $city = ($_GET['city']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }
        if (isset($_GET['per_page']) && ($_GET['per_page'] != "")) {
            $offset = ($_GET['per_page']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['report']) && ($_GET['report'] != "")) {
            $to_excel = TRUE;
            $limit = "";
        }
        $rest = $this->MRestActions->getRest($restID);
        $lists = $this->MRestActions->getAllBranches($restID, $city, $limit, $offset, false, $status);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('District - City', 'Location', 'Number', "Status", 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Branches of ' . $rest->rest_Name,
            'title' => 'Branches of ' . $rest->rest_Name,
            'action' => 'adminrestaurants',
            'lists' => $lists,
            'rest' => $rest,
            'side_menu' => ['Restaurant Mgmt'],
        );
        return view('admin.partials.restaurantbranches', $data);
    }

    public function form($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $rest_ID = 0;
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest_ID = ($_REQUEST['rest_ID']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $cities = $this->MGeneral->getAllCities();
        $hotels = $this->MGeneral->getAllHotels();
        $rest = $this->MRestActions->getRest($rest_ID);
        $featureAndServices = $this->MRestActions->getAllRestServices($country);
        $moodsAtmosphere = $this->MRestActions->getAllMoodsAtmosphere($country);
        if ($id != 0) {
            $branch = $this->MRestActions->getRestBranch($id);
            $data = array(
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'pagetitle' => $branch->br_loc . ' ' . $rest->rest_Name,
                'title' => $branch->br_loc . ' ' . $rest->rest_Name,
                'branch' => $branch,
                'rest' => $rest,
                'hotels' => $hotels,
                'cities' => $cities,
                'featureAndServices' => $featureAndServices,
                'moodsAtmosphere' => $moodsAtmosphere,
                'css' => 'chosen',
                'js' => 'chosen.jquery,admin/branchform',
                'side_menu' => array('Restaurant Mgmt', 'Restaurants')
            );
        } else {
            $data = array(
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'pagetitle' => 'New Branch for ' . $rest->rest_Name,
                'title' => 'New Branch for ' . $rest->rest_Name,
                'rest' => $rest,
                'cities' => $cities,
                'hotels' => $hotels,
                'featureAndServices' => $featureAndServices,
                'moodsAtmosphere' => $moodsAtmosphere,
                'css' => 'chosen',
                'js' => 'chosen.jquery,admin/branchform',
                'side_menu' => ['Restaurant Mgmt'],
            );
        }
        return view('admin.forms.branch', $data);
    }

    public function save()
    {

        if (Input::get('rest_Name')) {
            $rest = Input::get('rest_fk_id');
            if (Input::get('br_id')) {
                $branch = Input::get('br_id');
                $this->MRestActions->updateBranch();
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                if ($_POST['branch_type'] == "Hotel Restaurant") {
                    if ($this->MRestActions->getHotel($branch) > 0) {
                        $this->MRestActions->updateBranchHotel($branch);
                    } else {
                        $this->MRestActions->addBranchHotel($branch);
                    }
                }
                $this->MAdmins->addActivity('Branch Updated ' . stripslashes(Input::get('rest_Name')));
                if (Input::get('ref')) {
                    $per_page = Input::get('per_page');
                    $limit = Input::get('limit');
                    return returnMsg('success', 'adminrestaurants/branches', "Branch added succesfully", [$rest]);
                } else {
                    return returnMsg('success', 'adminrestaurants/branches', "Branch updated succesfully", [$rest]);
                }
            } else {
                $branch = $this->MRestActions->addBranch();
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                if (Input::get('branch_type') == "Hotel Restaurant") {
                    $this->MRestActions->addBranchHotel($branch);
                }
                $this->MAdmins->addActivity('Branch Added ' . stripslashes(Input::get('rest_Name')));
                $this->MAdmins->addRestActivity('We have opened our new branch.', $rest, $branch);
                return returnMsg('success', 'adminrestaurants/branches', "Branch added succesfully", [$rest]);
            }
        } else {
            return returnMsg('error', 'adminrestaurants', "something went wrong, Please try again.");
        }
    }

    public function status($id = 0)
    {
        $status = 0;
        $rest = 0;
        if (isset($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
        }
        $page = $this->MRestActions->getRestBranch($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status,
                'lastUpdated' => date('Y-m-d H:i:s')
            );
            DB::table('rest_branches')->where('br_id', $id)->update($data);
            $this->MAdmins->addActivity('Branch Status changed successfully.' . $page->br_loc);
            return returnMsg('success', 'adminrestaurants/branches',  "Branch Status changed successfully.", [$rest]);
        }
        return returnMsg('error', 'adminrestaurants/branches',  "something went wrong, Please try again.", [get('rest_ID')]);
    }

    public function delete($id = 0)
    {

        $saved = DB::table('rest_branches')->where('br_id', intval($id))->delete();
        if ($saved)
            return returnMsg('success', 'adminrestaurants/branches', "Branch deleted successfully.", [get('rest_ID')]);


        return returnMsg('error', 'adminrestaurants/branches',  "something went wrong, Please try again.", [get('rest_ID')]);
    }

    public function images($br_id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $rest_ID = 0;
        if (isset($_GET['rest_ID']) && !empty($_GET['rest_ID'])) {
            $rest_ID = $_GET['rest_ID'];
        }
        $sort = "latest";
        $limit = 500;
        $offset = 0;
        $to_excel = false;
        $city = $cuisine = $bestfor = $status = $member = $restaurant = "";
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['report']) && ($_GET['report'] != "")) {
            $to_excel = TRUE;
            $limit = "";
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        $branch = $this->MRestActions->getRestBranch($br_id);
        $lists = $this->MRestActions->getBranchImages($br_id, $status, $limit);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Restaurant', 'Thumb', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Branch Photo for ' . $rest->rest_Name . ' - ' . $branch->br_loc,
            'title' => 'Branch Photo for ' . $rest->rest_Name . ' - ' . $branch->br_loc,
            'action' => 'adminrestaurants',
            'lists' => $lists,
            'rest' => $rest,
            'branch' => $branch,
            'br_id' => $br_id,
            'side_menu' => ['Restaurant Mgmt'],
        );
        return view('admin.partials.brancheimages', $data);
    }

    public function imageform($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $rest_ID = 0;
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest_ID = ($_REQUEST['rest_ID']);
        }
        $br_id = 0;
        if (isset($_GET['br_id']) && !empty($_GET['br_id'])) {
            $br_id = $_GET['br_id'];
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        $branch = $this->MRestActions->getRestBranch($br_id);
        if ($id != 0) {
            $branchimage = $this->MRestActions->getImage($id);
            $data = array(
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'pagetitle' => $branchimage->title . ' ' . $rest->rest_Name,
                'title' => $branchimage->title . ' ' . $rest->rest_Name,
                'branchimage' => $branchimage,
                'rest' => $rest,
                'branch' => $branch,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => ['Restaurant Mgmt'],
            );
        } else {
            $data = array(
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'pagetitle' => 'New Branch Image for ' . $rest->rest_Name,
                'title' => 'New Branch Image for ' . $rest->rest_Name,
                'rest' => $rest,
                'branch' => $branch,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => ['Restaurant Mgmt'],
            );
        }
        return view('admin.forms.branchimage', $data);
    }

    public function imagesave()
    {
        Input::flash();
        $rest_ID = Input::get('rest_fk_id');
        $br_id = Input::get('br_id');

        if (!empty($br_id)) {
            $restData = $rest = $this->MRestActions->getRest($rest_ID);
            $branch = $this->MRestActions->getRestBranch($br_id);
            $restname = $rest->rest_Name;
            $image = "";
            $title = $title_ar = "";
            $ratio = $actualWidth = 0;
            if (Input::hasFile('branch_image')) {
                $file = Input::file('branch_image');
                $temp_name = $_FILES['branch_image']['tmp_name'];
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
                    return returnMsg('error', 'adminrestaurants/branches/imageform',  'Image is very small. Please upload image which must be bigger than 200*200 width and height.', array('br_id' => $br_id, 'rest_ID' => $rest_ID));
                }
                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/fullsize/", $save_name, true, null, 80);
                $text_font = $restData->rest_Name . '-' . Input::get('title') . '- azooma.co';
                $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                $textLayer->opacity(75);
                $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                if (($actualWidth > 800)) {
                    $largeLayer->resizeInPixel(800, null, $conserveProportion, $positionX, $positionY, $position);
                } else {
                    if ($actualHeight > 500) {
                        $largeLayer->resizeInPixel(null, 500, $conserveProportion, $positionX, $positionY, $position);
                    }
                }

                $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/", $save_name, true, null, 95);

                $height1 = round($actualHeight * (200 / $actualWidth));
                $height2 = round($actualHeight * (230 / $actualWidth));

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/Gallery/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $expectedWidth = 200;
                $expectedHeight = $height1;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/200/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $expectedWidth = 230;
                $expectedHeight = $height2;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/230/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(45, 45);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/45/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(200, 200);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/200x200/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(150, 150);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/150x150/", $save_name, true, null, 95);
                $theight = $actualHeight * (400 / $actualWidth);
                $expectedWidth = 400;
                $expectedHeight = $theight;
                ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
                $changelayer = clone $layer;
                $changelayer->resizeInPixel($largestSide, $largestSide);
                $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/400x/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/thumb/", $save_name, true, null, 95);
            } elseif (isset($_POST['branch_image_old'])) {
                $image = Input::get('branch_image_old');
            }
            $title = (Input::get('title'));
            $title_ar = (Input::get('title_ar'));

            if ($title == "" || empty($title)) {
                $title = $restData->rest_Name . ' ' . $branch->br_loc;
            }
            if ($title_ar == "" || empty($title_ar)) {
                $title_ar = $restData->rest_Name_Ar . ' ' . $branch->br_loc_ar;
            }
            if (Input::get('image_ID')) {
                $image_ID = Input::get('image_ID');
                $this->MRestActions->updateBranchImage($image_ID, $image, $title, $title_ar, $ratio, $actualWidth);
                $this->MRestActions->updateRestLastUpdatedOn($rest_ID);
                return returnMsg('success', 'adminrestaurants/branches/images/', 'Branch Image updated succesfully', array('id' => $br_id, 'rest_ID' => $rest_ID));
            } else {
                $this->MRestActions->addBranchImage($image, $title, $title_ar, $ratio, $actualWidth);
                $this->MRestActions->updateRestLastUpdatedOn($rest_ID);
                return returnMsg('success', 'adminrestaurants/branches/images/', 'Branch Image Added succesfully', array('id' => $br_id, 'rest_ID' => $rest_ID));
            }
            return returnMsg('error', 'adminrestaurants/branches/imageform',  "something went wrong, Please try again.", array('br_id' => $br_id, 'rest_ID' => $rest_ID));
        } else {
            return returnMsg('error', 'adminrestaurants/branches/imageform',  "something went wrong, Please try again.", array('br_id' => $br_id, 'rest_ID' => $rest_ID));
        }
    }

    public function imagestatus($id = 0)
    {
        $status = 0;
        $rest = 0;
        $br_id = 0;
        if (isset($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
        }
        if (isset($_REQUEST['br_id'])) {
            $br_id = $_REQUEST['br_id'];
        }
        $page = $this->MRestActions->getImage($id);
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
            $this->MAdmins->addActivity('Branch Image Status changed successfully.' . $page->title);
            return returnMsg('success', 'adminrestaurants/branches/images/', "Branch Status changed successfully.", array('id' => $br_id, 'rest_ID' => $rest));
        }
        return returnMsg('error', 'adminrestaurants/branches/images/', "something went wrong, Please try again.", array('id' => $br_id, 'rest_ID' => $rest));
    }

    public function imagedelete($id = 0)
    {
        $rest = 0;
        $br_id = 0;
        if (isset($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
        }
        if (isset($_REQUEST['br_id'])) {
            $br_id = $_REQUEST['br_id'];
        }
        $page = $this->MRestActions->getImage($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteImage($id);
            $this->MAdmins->addActivity('Welcome Message deleted successfully.' . $page->title);
            return returnMsg('success', 'adminrestaurants/branches/images/', "Branch Image deleted successfully.", array('id' => $br_id, 'rest_ID' => $rest));
        }
        return returnMsg('error', 'adminrestaurants/branches/images/', "something went wrong, Please try again.", array('id' => $br_id, 'rest_ID' => $rest));
    }
}
