<?php

use Illuminate\Support\Facades\Input;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class Hotels extends AdminController
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

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Hotel Name', 'Star', "Status", 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Hotels',
            'title' => 'All Hotels',
            'action' => 'adminhotels',
            'country' => $country,
            'side_menu' => array('Restaurant Mgmt', 'Hotels'),
        );

        return view('admin.partials.hotels', $data);
    }

    public function form($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $cities = $this->MGeneral->getAllCities($country);
        if ($id != 0) {
            $page = $this->MRestActions->getHotel($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->hotel_name,
                'title' => $page->hotel_name,
                'hotel' => $page,
                'cities' => $cities,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => array('Restaurant Mgmt', 'Hotels'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Restaurant Group',
                'title' => 'New Restaurant Group',
                'css' => 'chosen',
                'cities' => $cities,
                'js' => 'chosen.jquery',
                'side_menu' => array('Restaurant Mgmt', 'Hotels'),
            );
        }
        return view('admin.forms.hotels', $data);
    }
    
    public function getHotelData()
    {
    
        $query = DB::table('hotel_info');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('h_status')) {
            $query->where("status", '=', intval(get('h_status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($hotel) {
                $btns =
                    $btns = '<a class="btn btn-xs m-1 btn-info" href="' . route('adminhotels/form/', $hotel->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($hotel->status == 0) {

                    $btns .= ' <a class="btn btn-xs m-1 btn-primary" href="' . route('adminhotels/status/', $hotel->id) . '" title="Activate "><i class="fa fa-check"></i></a>';
                } else {
                    $btns .= ' <a class="btn btn-xs m-1 btn-danger" href="' . route('adminhotels/status/', $hotel->id) . '" title="Deactivate"><i class="fa fa-ban"></i></a>';
                }
                $btns .= ' <a herf="#" class="btn btn-xs m-1 btn-danger mytooltip cofirm-delete-btn" link="' . route('adminhotels/delete/', $hotel->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })
            ->editColumn('hotel_name', function ($hotel) {
                return  stripslashes($hotel->hotel_name) . ' - ' . stripslashes($hotel->hotel_name_ar);
            })

            ->addColumn('status_html', function ($hotel) {
                return  $hotel->status == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
            })

            ->editColumn('updatedAt', function ($hotel) {
                if ($hotel->updatedAt == "" || $hotel->updatedAt == "0000-00-00 00:00:00") {
                    return date('d/m/Y', strtotime($hotel->createdAt));
                } else {
                    return date('d/m/Y', strtotime($hotel->updatedAt));
                }
            })
            ->make(true);
    }
    public function save()
    {
        Input::flash();
        if (Input::get('hotel_name')) {
            $image = "";
            $actualWidth = "";
            $ratio = "0";
            if (Input::hasFile('hotel_logo')) {
                $file = Input::file('hotel_logo');
                $temp_name = $_FILES['hotel_logo']['tmp_name'];
                $filename = $file->getClientOriginalName();
                $logo = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
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
                    return  returnMsg('error', 'adminhotels/form', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/logos", $save_name, true, null, 80);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/logos/" . $save_name);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(200, 200);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/logos/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(45, 45);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/45/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(40, 40);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/40/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(70, 70);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/70/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/thumb", $save_name, true, null, 95);
            } else {
                if (Input::has('hotel_logo_old')) {
                    $logo = Input::get('hotel_logo_old');
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
                    return  returnMsg('error', 'adminhotels/form', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                }

                $largeLayer->save(Config::get('settings.uploadpath') . "/logos", $save_name, true, null, 80);

                if (($actualWidth > 800) || ($actualHeight > 500)) {
                    $largeLayer->resizeInPixel(800, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/hotel/", $save_name, true, null, 95);

                $thumbLayer->resizeInPixel(100, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                $thumbLayer->save(Config::get('settings.uploadpath') . "/hotel/thumb", $save_name, true, null, 95);
            } else {
                if (Input::has('image_old')) {
                    $image = Input::get('image_old');
                } else {
                    $image = '';
                }
            }

            if (Input::get('id')) {
                $rest = $_POST['id'];
                $this->MRestActions->updatehotel($logo, $image);
                $this->MAdmins->addActivity('Hotel Updated ' . Input::get('hotel_name'));
                return  returnMsg('success', 'adminhotels', "Hotel Updated succesfully");
            } else {
                $rest = $this->MRestActions->addhotel($logo, $image);
                $this->MAdmins->addActivity('Hotel Added ' . Input::get('hotel_name'));
                return  returnMsg('success', 'adminhotels', 'Hotel Added succesfully');
            }
        } else {
            return  returnMsg('error', 'adminhotels/form', 'something went wrong, Please try again.');
        }
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getHotel($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('hotel_info')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Hotel Status changed successfully.' . $page->hotel_name);
            return returnMsg('success', 'adminhotels', 'Hotel Status changed successfully.');
        }

        return returnMsg('error', 'adminhotels', 'something went wrong, Please try again.');
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getHotel($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteHotel($id);
            $this->MAdmins->addActivity($page->hotel_name . ' deleted successfully.');

            return returnMsg('success', 'adminhotels', 'deleted successfully.');
        }

        return returnMsg('error', 'adminhotels', 'something went wrong, Please try again.');
    }

    function deleteImage($id = 0)
    {
        $type = "";
        if (isset($_GET['type']) && ($_GET['type'] != "")) {
            $type = ($_GET['type']);
        }
        $page = $this->MRestActions->getHotel($id);
        $this->MRestActions->deleteHotelImage($id, $type);
        $this->MAdmins->addActivity('Deleted Hotel ' . $type . ' ' . stripslashes(($page->hotel_name)));
        return returnMsg('success', 'adminhotels/form/', 'deleted succesfully.', $page->id);
    }
}
