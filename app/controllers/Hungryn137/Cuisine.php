<?php

use Yajra\DataTables\Facades\DataTables;

class Cuisine extends AdminController
{

    protected $MAdmins;
    protected $MCuisine;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MCuisine = new MCuisine();
    }

    public function index()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $logo = ArtWork::where('art_work_name', '=', 'Azooma Logo')->orderBy('createdAt', 'DESC')->first();
        $limit = 20;
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

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }


        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Description', 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All Master Cuisines',
            'title' => 'All Master Cuisines',
            'action' => 'admincuisine',
            'side_menu' => array('Categories / Lists', 'Cuisine List'),
        );
        return view('admin.partials.mastercuisines', $data);
    }

    public function data_table()
    {
        $query = DB::table('master_cuisine');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('admincuisine/form/', $list->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';
                $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('admincuisine/subcuisines/', $list->id) . '" title="View/Add Food/Cuisine"><i class="fa fa-upload"></i></a>';

                if ($list->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('admincuisine/status/', $list->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('admincuisine/status/', $list->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip mx-1 cofirm-delete-btn" href="#" link="' . route('admincuisine/delete/', $list->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })

            ->editColumn('name', function ($list) {
                return  stripslashes($list->name);
            })

            ->editColumn('description', function ($list) {
                return  Str::limit(stripslashes(strip_tags(html_entity_decode($list->description))), 100);
            })

            ->editColumn('updatedAt', function ($list) {
                return  date('d/m/Y', strtotime($list->updatedAt));
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

        $cuisinesList = $this->MCuisine->getAllCuisines();
        if ($id != 0) {
            $page = $this->MCuisine->getMasterCuisine($id);
            $data = array(
                'sitename' => $settings['name'],
                'js' => 'chosen.jquery',
                'css' => 'chosen',
                'cuisines' => $cuisinesList,
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('Categories / Lists', 'Cuisine List'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'js' => 'chosen.jquery',
                'css' => 'chosen',
                'cuisines' => $cuisinesList,
                'pagetitle' => 'New Master Cuisine',
                'title' => 'New Master Cuisine',
                'side_menu' => array('Categories / Lists', 'Cuisine List'),
            );
        }
        return view('admin.forms.mastercuisines', $data);
    }

    public function save()
    {
        $filename = "";
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
            $thumbLayer = clone $largeLayer;
            //get Size of the Image and reSize
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/cuisine/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/cuisine/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            // $changelayer->resizeInPixel(150, 150);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/cuisine/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MCuisine->updateMasterCuisine($filename);
            $obj = $this->MCuisine->getMasterCuisine($id);
            $this->MAdmins->addActivity('Updated Master Cuisine ' . Input::get('name'));

            return returnMsg('success', 'admincuisine', 'Master Cuisine updated succesfully');
        } else {
            $id = $this->MCuisine->addMasterCuisine($filename);
            $obj = $this->MCuisine->getMasterCuisine($id);
            $this->MAdmins->addActivity('Master Cuisine Added' . Input::get('name'));

            return returnMsg('success', 'admincuisine', 'Master Cuisine Added succesfully');
        }

        return returnMsg('error', 'admincuisine', 'Something went wrong, Please try again.');
    }

    public function status($id = 0)
    {
        $status = 0;
        $obj = $this->MCuisine->getMasterCuisine($id);
        if (count($obj) > 0) {
            if ($obj->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('master_cuisine')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Master Cuisine ' . $obj->name . ' status Changed Succesfully ');

            return returnMsg('success', 'admincuisine', 'Master Cuisine ' . $obj->name . ' status Changed Succesfully');
        }

        return returnMsg('error', 'admincuisine', 'Something went wrong, Please try again.');
    }

    public function delete($id = 0)
    {
        $status = 0;
        $obj = $this->MCuisine->getMasterCuisine($id);
        if (count($obj) > 0) {
            $this->MCuisine->deleteMasterCuisine($id);
            $this->MAdmins->addActivity('Master Cuisine deleted Succesfully ' . $obj->name);

            return returnMsg('success', 'admincuisine', 'Master Cuisine deleted succesfully');
        }

        return returnMsg('error', 'admincuisine', 'Something went wrong, Please try again.');
    }

    public function subcuisines($id = 0)
    {
        $settings = settings::where('id', '=', '1')->first();
        Session::put('sitename', $settings['name']);

        $limit = 20;
        $city = 0;
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
        if (isset($_GET['city']) && !empty($_GET['city'])) {
            $city = stripslashes($_GET['city']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $lists = $this->MCuisine->getAllCuisines($city, $status, $limit, $id, 0, $name, $sort);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Description', 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All Food / Cuisines',
            'title' => 'All Food / Cuisines Cuisines',
            'action' => 'admincuisine',
            'mainID' => $id,
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Categories / Lists', 'Cuisine List'),
        );
        return view('admin.partials.cuisines', $data);
    }

    public function cuisineform($id = 0)
    {
        $settings = settings::where('id', '=', '1')->first();
        Session::put('sitename', $settings['name']);

        $cuisinesList = $this->MCuisine->getAllMasterCuisines();
        if ($id != 0) {
            $page = $this->MCuisine->getCuisine($id);
            $data = array(
                'sitename' => $settings['name'],
                'js' => 'chosen.jquery',
                'css' => 'chosen',
                'mainID' => $page->master_id,
                'cuisines' => $cuisinesList,
                'pagetitle' => $page->cuisine_Name,
                'title' => $page->cuisine_Name,
                'page' => $page,
                'side_menu' => array('Categories / Lists', 'Cuisine List'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'js' => 'chosen.jquery',
                'css' => 'chosen',
                'cuisines' => $cuisinesList,
                'pagetitle' => 'New Cuisine',
                'title' => 'New Cuisine',
                'side_menu' => array('Categories / Lists', 'Cuisine List'),
            );
        }
        return view('admin.forms.cuisines', $data);
    }

    public function cuisinesave()
    {
        $filename = "";
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
            $thumbLayer = clone $largeLayer;
            //get Size of the Image and reSize
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/cuisine", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/cuisine/" . $save_name);
            $changelayer = clone $layer;
            // $changelayer->resizeInPixel(150, 150);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/cuisine/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }

        if (Input::hasFile('bannerimage')) {
            $file = Input::file('bannerimage');
            $temp_name = $_FILES['bannerimage']['tmp_name'];
            $bannername = $file->getClientOriginalName();
            $bannername = $save_name = uniqid(Config::get('settings.sitename')) . $bannername;
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
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/cuisine/banner", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/cuisine/banner/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            // $changelayer->resizeInPixel(100, 100);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/cuisine/banner/thumb", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $bannername = Input::get('image_old');
        }
        $master_id = -1;
        if (Input::has('master_id') && !empty(Input::get('master_id'))) {
            $master_id = Input::get('master_id');
        }
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MCuisine->updateCuisine($filename, $bannername);
            $obj = $this->MCuisine->getCuisine($id);
            $this->MAdmins->addActivity('Updated Master Cuisine ' . Input::get('name'));

            return returnMsg('success', 'admincuisine/subcuisines/', 'Master Cuisine updated succesfully', $master_id);
        } else {
            $id = $this->MCuisine->addCuisine($filename, $bannername);
            $obj = $this->MCuisine->getCuisine($id);
            $this->MAdmins->addActivity('Master Cuisine Added' . Input::get('name'));

            return returnMsg('success', 'admincuisine/subcuisines/', 'Master Cuisine Added succesfully', $master_id);
        }

        return returnMsg('error', 'admincuisine', 'Something went wrong, Please try again.', $master_id);
    }

    public function cuisinestatus($id = 0)
    {
        $status = 0;
        $obj = $this->MCuisine->getCuisine($id);
        if (count($obj) > 0) {
            if ($obj->cuisine_Status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'cuisine_Status' => $status
            );
            DB::table('cuisine_list')->where('cuisine_ID', $id)->update($data);
            $this->MAdmins->addActivity('Cuisine ' . $obj->cuisine_Name . ' status Changed Succesfully ');

            return returnMsg('success', 'admincuisine/subcuisines/', 'Master Cuisine deleted succesfully', $obj->master_id);
        }

        return returnMsg('error', 'admincuisine', 'something went wrong, Please try again.');
    }

    public function cuisinedelete($id = 0)
    {
        $status = 0;
        $obj = $this->MCuisine->getCuisine($id);
        if (count($obj) > 0) {
            $this->MCuisine->deleteCuisine($id);
            $this->MAdmins->addActivity('Cuisine deleted Succesfully ' . $obj->cuisine_Name);

            return returnMsg('success', 'admincuisine/subcuisines/', 'Cuisine deleted succesfully.', $obj->master_id);
        }

        return returnMsg('error', 'admincuisine', 'something went wrong, Please try again.');
    }
}
