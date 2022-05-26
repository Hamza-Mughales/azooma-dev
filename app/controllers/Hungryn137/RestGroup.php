<?php

use Yajra\DataTables\Facades\DataTables;

class RestGroup extends AdminController
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

    public function index()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $sort = "latest";
        $restaurant = "";
        $limit = 20;
        $status = 0;
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['restaurant']) && ($_GET['restaurant'] != "")) {
            $restaurant = ($_GET['restaurant']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        // $lists = $this->MRestActions->getAllGroupofRestaurants($country, $status, $limit, $restaurant, $sort);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Group Name', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Group of Restaurants',
            'title' => 'All Group of Restaurants',
            'action' => 'adminrestaurantsgroup',
            // 'lists' => $lists,
            'side_menu' => array('Restaurant Mgmt', 'Group of Restaurants'),
        );

        return view('admin.partials.restaurantsgroup', $data);
    }

    public function data_table()
    {
        $query = DB::table('restaurant_groups');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('adminrestaurantsgroup/form/', $list->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($list->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('adminrestaurantsgroup/status/', $list->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('adminrestaurantsgroup/status/', $list->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-button" href="' . route('adminrestaurantsgroup/delete/', $list->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })
            ->editColumn('name', function ($list) {
                return  stripslashes($list->name) . ' - ' .  stripslashes($list->name_ar);
            })

            ->editColumn('updatedAt', function ($list) {
                if ($list->updatedAt == "") {
                    return date('d/m/Y', strtotime($list->createdAt));
                } else {
                    return date('d/m/Y', strtotime($list->updatedAt));
                }
            })
            ->make(true);
    }

    public function form($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if ($id != 0) {
            $page = $this->MRestActions->getGroupRestaurant($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'restgroup' => $page,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => array('Restaurant Mgmt', 'Group of Restaurants'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Restaurant Group',
                'title' => 'New Restaurant Group',
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => array('Restaurant Mgmt', 'Group of Restaurants'),
            );
        }
        return view('admin.forms.restaurantgroup', $data);
    }

    public function save()
    {
        if (Input::get('name')) {
            $image = "";
            $logo = "";
            $actualWidth = "";
            $ratio = "0";
            if (Input::hasFile('logo')) {
                $file = Input::file('logo');
                $temp_name = $_FILES['logo']['tmp_name'];
                $filename = $file->getClientOriginalName();
                $logo = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
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
                if ($actualWidth < 150 && $actualHeight < 150) {
                    return Redirect::route('adminrestaurants')->with('message', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/logos/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/logos/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(200, 200);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/", $save_name, true, null, 95);

                $changelayer = clone $layer;
                $changelayer->resizeInPixel(45, 45);
                $changelayer->save(Config::get('settings.uploadpath')  . "/logos/45/", $save_name, true, null, 95);

                $changelayer = clone $layer;
                $changelayer->resizeInPixel(40, 40);
                $changelayer->save(Config::get('settings.uploadpath')  . "/logos/40/", $save_name, true, null, 95);

                $changelayer = clone $layer;
                $changelayer->resizeInPixel(70, 70);
                $changelayer->save(Config::get('settings.uploadpath')  . "/logos/70/", $save_name, true, null, 95);

                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath')  . "/logos/thumb/", $save_name, true, null, 95);
            } else {
                if (Input::has('logo_old')) {
                    $logo = Input::get('logo_old');
                } else {
                    $logo = '';
                }
            }

            if (Input::hasFile('image')) {
                $file = Input::file('image');
                $temp_name = $_FILES['image']['tmp_name'];
                $filename = $file->getClientOriginalName();
                $image = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
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
                if ($actualWidth < 200 && $actualHeight < 200) {
                    return Redirect::route('adminrestaurants')->with('message', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/logos", $save_name, true, null, 80);
                if (($actualWidth > 800) || ($actualHeight > 500)) {
                    $largeLayer->resizeInPixel(800, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/hotel/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/hotel/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/hotel/thumb/", $save_name, true, null, 95);
            } else {
                if (Input::has('image_old')) {
                    $image = Input::get('image_old');
                } else {
                    $image = '';
                }
            }

            if (Input::get('id')) {
                $rest = $_POST['id'];
                $this->MRestActions->updateGroupRestaurant($logo, $image);
                $this->MAdmins->addActivity('Group of Restaurants Updated ' . Input::get('name'));

                return returnMsg('success', 'adminrestaurantsgroup', "Group of Restaurants Updated succesfully.");
            } else {
                $rest = $this->MRestActions->addGroupRestaurant($logo, $image);
                $this->MAdmins->addActivity('Group of Restaurants Added ' . Input::get('name'));

                return returnMsg('success', 'adminrestaurantsgroup', "Group of Restaurants Added succesfully.");
            }
        } else {

            return returnMsg('error', 'adminrestaurants', "Something went wrong, Please try again.");
        }
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getGroupRestaurant($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('restaurant_groups')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Group of Restaurant Status changed successfully.' . $page->name);

            return returnMsg('success', 'adminrestaurantsgroup', "Group of Restaurant Status changed successfully.");
        }

        return returnMsg('error', 'adminrestaurantsgroup', "Something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getGroupRestaurant($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteGroupRestaurant($id);
            $this->MAdmins->addActivity($page->name . ' deleted successfully.');

            return returnMsg('success', 'adminrestaurantsgroup', $page->name . ' deleted successfully.');
        }
        return returnMsg('error', 'adminrestaurantsgroup', "Something went wrong, Please try again.");
    }

    function deleteImage($id = 0)
    {
        $type = "";
        if (isset($_GET['type']) && ($_GET['type'] != "")) {
            $type = ($_GET['type']);
        }
        $cuisine = $this->MRestActions->getGroupRestaurant($id);
        $this->MRestActions->deleteGroupRestaurantImage($id, $type);
        $this->MAdmins->addActivity('Deleted Restaurant Group ' . $type . ' ' . stripslashes(($cuisine->name)));

        return returnMsg('success', 'adminrestaurantsgroup/form/', $cuisine->id, 'Restaurant Group ' . $type . ' deleted succesfully');
    }
}
