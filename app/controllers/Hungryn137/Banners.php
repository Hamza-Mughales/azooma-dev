<?php

use Yajra\DataTables\Facades\DataTables;

class Banners extends AdminController
{

    protected $Art_Work;
    protected $MGeneral;

    public function __construct()
    {
        parent::__construct();
        $this->Art_Work = new ArtWork();
        $this->MGeneral = new MGeneral();
    }

    public function index()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }


        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Banner', 'Type', 'City', 'Clicked', 'Impressions', 'Start date', "End date", "Status", 'Actions'),
            'pagetitle' => 'List of All Banners',
            'title' => ' All Banners',
            'action' => 'adminbanners',
            'type' => '',
            'side_menu' => array('Art Work', 'Banners'),
        );
        return view('admin.partials.banner', $data);
    }
    public function getBannerData()
    {
        $query = DB::table('banner')
            ->select(['banner.*', 'city_list.city_Name'])
            ->LeftJoin('city_list', "banner.city_ID", "=", "city_list.city_ID");

        if (!in_array(0, adminCountry())) {
            $query->whereIn("banner.country",  adminCountry());
        }
        if (get('status') or get('status') === '0') {
            $query->where('banner.active', intval(get('status')));
        }
        if (get('city_ID')) {
            $query->where('banner.city_ID', '=', get('city_ID'));
        }
        if (get('banner_type')) {
            $query->where('banner.banner_type', '=', get('banner_type'));
        }
        if (get('cuisine_ID')) {
            $query->where('banner.cuisine_ID', '=', get('cuisine_ID'));
        }
        if (get('type')) {
            $query->where('banner.type', '=', get('type'));
        }

        return  DataTables::of($query)
            ->addColumn('action', function ($row) {
                $type = get('type');
                $btns = '';

                $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminbanners/form/', $row->id) . '" title="Edit"><i class="fa fa-edit"></i></a>';

                if ($row->active == 0) {

                    $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminbanners/status/', $row->id) .  '" title="Activate "><i class="fa fa-check"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="' . route('adminbanners/status/', $row->id) . '" title="Deactivate"><i class="fa fa-ban"></i></a>';
                }
                $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-button" href="#" link="' . route('adminbanners/delete/', $row->id)  . '" title="Delete"><i class="fa fa-trash"></i></a>';

                return $btns;
            })


            ->addColumn('image', function ($row) {
                $html = '<img src="' . upload_url('banner/' . $row->image) . '" border="0" width="100" >';

                return $html;
            })
            ->editColumn('banner_type', function ($row) {
                $bannerTypes = Config::get('settings.bannertypes');
                $banner_type = isset($bannerTypes[$row->banner_type]) ? $bannerTypes[$row->banner_type] : "";
                return  $banner_type;
            })
            ->addColumn('status_html', function ($row) {
                return  $row->active == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
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
        Session::put('sitename', $settings['name']);
        $type = "";
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $type = $_GET['type'];
        }
        $bannerTypes = Config::get('settings.bannertypes');
        if ($id != 0) {
            $page = Ads::getBanner($id, 0);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $bannerTypes[$page->banner_type],
                'title' => $bannerTypes[$page->banner_type],
                'art_work_name' => $bannerTypes[$page->banner_type],
                'banner' => $page,
                'css' => 'chosen,admin/jquery-ui',
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Art Work', 'Banners'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'art_work_name' => $type,
                'pagetitle' => 'New Banner',
                'title' => 'New Banner',
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Art Work', 'Banners'),
            );
        }
        return view('admin.forms.banner', $data);
    }

    public function save()
    {
        if (Input::has('banner_type')) {
            $banner_type = Input::get('banner_type');
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
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                $largeLayer->save(Config::get('settings.uploadpath') . "/banner", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/banner/" . $save_name);
                $changelayer = clone $layer;

                // if ($banner_type == 1) {
                //     $changelayer->resizeInPixel(968, 98);
                // } elseif ($banner_type == 2) {
                //     $changelayer->resizeInPixel(245, null);
                // } elseif ($banner_type == 3) {
                //     $changelayer->resizeInPixel(657, 50);
                // } elseif ($banner_type == 4) {
                //     $changelayer->resizeInPixel(265, 146);
                // }
                $changelayer->save(Config::get('settings.uploadpath')  . "/banner/", $save_name, true, null, 95);
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
                //                if ($actualWidth < 200 && $actualHeight < 200) {
                //                    return Redirect::route('adminrestaurants')->with('message', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                //                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/banner", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/banner/" . $save_name);
                $changelayer = clone $layer;

                // if ($banner_type == 1) {
                //     $changelayer->resizeInPixel(968, 98);
                // } elseif ($banner_type == 2) {
                //     $changelayer->resizeInPixel(245, null);
                // } elseif ($banner_type == 3) {
                //     $changelayer->resizeInPixel(657, 50);
                // } elseif ($banner_type == 4) {
                //     $changelayer->resizeInPixel(265, 146);
                // }
                $changelayer->save(Config::get('settings.uploadpath')  . "/banner/", $save_name, true, null, 95);
            } elseif (isset($_POST['image_ar_old'])) {
                $filenameAr = Input::get('image_ar_old');
            }

            $status = 0;
            if (Input::has('status')) {
                $status = 1;
            }
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            if (Input::has('cuisine_ID')) {
                $cuisines = implode(',', Input::get('cuisine_ID'));
            } else {
                $cuisines = 0;
            }
            if (Input::has('city_ID')) {
                $city = implode(',', Input::get('city_ID'));
            } else {
                $city = 0;
            }
            if (Input::has('start_date')) {
                $startdate = Input::get('start_date');
            } else {
                $startdate = date('Y-m-d');
            }
            $data = array(
                'title' => (Input::get('title')),
                'banner_type' => (Input::get('banner_type')),
                'city_ID' => $city,
                'cuisine_ID' => $cuisines,
                'country' => $country,
                'url' => (Input::get('url')),
                'url_ar' => (Input::get('url_ar')),
                'image' => $filename,
                'image_ar' => $filenameAr,
                'active' => $status,
                'start_date' => $startdate,
                'end_date' => Input::get('end_date'),
            );

            if (Input::get('id')) {
                DB::table('banner')->where('id', Input::get('id'))->update($data);
            } else {
                DB::table('banner')->insert($data);
            }
        }
        return returnMsg('success', 'adminbanners', 'Your data has been save successfully.', array('type' => get('art_work_name')));
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = Ads::getBanner($id);
        $message = "";
        if (count($page) > 0) {
            if ($page->active == 0) {
                $status = 1;
                $message = "Banner activatied successfully.";
            } else {
                $status = 0;
                $message = "Banner deactivatied successfully.";
            }
            $data = array(
                'active' => $status
            );
            DB::table('banner')->where('id', $id)->update($data);
            return returnMsg('success', 'adminbanners', $message, array('type' => get('art_work_name')));
        }
        return returnMsg('error', 'adminbanners', 'something went wrong, Please try again.', array('type' => get('art_work_name')));
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = Ads::getBanner($id);
        if (count($page) > 0) {
            Ads::deleteBanner($id);
            return returnMsg('success', 'adminbanners',  'Banner deleted successfully.');
        }
        return returnMsg('error', 'adminbanners', 'something went wrong, Please try again.');
    }

    ###############################################################

    public function category()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }


        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Banner', 'Title', 'Title Arabic', 'City', "Status", 'Actions'),
            'pagetitle' => 'List of All Home Page Categories',
            'title' => ' All Home Page Categories',
            'action' => 'admincategoryartwork',
            'type' => '',
            'side_menu' => array('Art Work', 'Category Artwork'),
        );
        return view('admin.partials.homepagecategory', $data);
    }
    public function getCategoryData()
    {
        $query = DB::table('art_work')
            ->select(['art_work.*', 'city_list.city_Name'])
            ->LeftJoin('city_list', "art_work.city_ID", "=", "city_list.city_ID")
            ->where('art_work_name', '=', 'Home Page Category');

        if (!in_array(0, adminCountry())) {
            $query->whereIn("art_work.country",  adminCountry());
        }
        if (get('status') or get('status') === '0') {
            $query->where('art_work.active', intval(get('status')));
        }
        if (get('city_ID')) {
            $query->where('art_work.city_ID', '=', get('city_ID'));
        }


        return  DataTables::of($query)
            ->addColumn('action', function ($row) {
                $btns = '';

                $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admincategoryartwork/form/', $row->id) . '" title="Edit"><i class="fa fa-edit"></i></a>';

                if ($row->active == 0) {

                    $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admincategoryartwork/status/', $row->id) .  '" title="Activate "><i class="fa fa-check"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="' . route('admincategoryartwork/status/', $row->id) . '" title="Deactivate"><i class="fa fa-ban"></i></a>';
                }
                $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-button" href="#" link="' . route('admincategoryartwork/delete/', $row->id)  . '" title="Delete"><i class="fa fa-trash"></i></a>';

                return $btns;
            })


            ->addColumn('image', function ($row) {
                $html = '<img src="' . upload_url('images/' . $row->image) . '" border="0" width="100" >';

                return $html;
            })

            ->addColumn('status_html', function ($row) {
                return  $row->active == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
            })


            ->make(true);
    }
    public function categoryform($id = 0)
    {
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
            $page = Ads::getHomePageCategory($id, 0);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->a_title,
                'title' => $page->a_title,
                'art_work_name' => $page->art_work_name,
                'banner' => $page,
                'css' => 'chosen,admin/jquery-ui',
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Art Work', 'Category Artwork'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'art_work_name' => 'Home Page Category',
                'pagetitle' => 'New Home Page Category',
                'title' => 'New Home Page Category',
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Art Work', 'Category Artwork'),
            );
        }
        return view('admin.forms.homepagecategory', $data);
    }

    public function categorysave()
    {
        if (Input::has('art_work_name')) {
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
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 80);
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                // $changelayer->resizeInPixel(200, 125);
                $changelayer->save(Config::get('settings.uploadpath')  . "/images/", $save_name, true, null, 95);
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
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 80);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                // $changelayer->resizeInPixel(200, 125);
                $changelayer->save(Config::get('settings.uploadpath')  . "/images/", $save_name, true, null, 95);
            } elseif (isset($_POST['image_ar_old'])) {
                $filenameAr = Input::get('image_ar_old');
            }

            $status = 0;
            if (Input::has('status')) {
                $status = 1;
            }
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            if (Input::has('city_ID')) {
                $city = implode(',', Input::get('city_ID'));
            } else {
                $city = 0;
            }

            $data = array(
                'a_title' => (Input::get('a_title')),
                'a_title_ar' => (Input::get('a_title_ar')),
                'art_work_name' => 'Home Page Category',
                'city_ID' => $city,
                'country' => $country,
                'image' => $filename,
                'image_ar' => $filenameAr,
                'active' => $status
            );

            if (Input::get('id')) {
                DB::table('art_work')->where('id', Input::get('id'))->update($data);
            } else {
                DB::table('art_work')->insert($data);
            }
        }
        return returnMsg('success', 'admincategoryartwork', 'Your data has been save successfully.', array('type' => get('art_work_name')));
    }

    public function categorystatus($id = 0)
    {
        $status = 0;
        $page = Ads::getHomePageCategory($id);
        $message = "";
        if (count($page) > 0) {
            if ($page->active == 0) {
                $status = 1;
                $message = "Home Page Category activatied successfully.";
            } else {
                $status = 0;
                $message = "Home Page Category deactivatied successfully.";
            }
            $data = array(
                'active' => $status
            );
            DB::table('art_work')->where('id', $id)->update($data);
            return returnMsg('success', 'admincategoryartwork', $message);
        }
        return returnMsg('error', 'admincategoryartwork', 'something went wrong, Please try again.');
    }

    public function categorydelete($id = 0)
    {
        $status = 0;
        $page = Ads::getHomePageCategory($id);
        if (count($page) > 0) {
            Ads::deleteHomePageCategory($id);
            return returnMsg('success', 'admincategoryartwork', 'Home Page Category deleted successfully.');
        }
        return returnMsg('error', 'admincategoryartwork', 'something went wrong, Please try again.');
    }
}
