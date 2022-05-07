<?php

use Yajra\DataTables\Facades\DataTables;

class Gallery extends AdminController
{

    protected $MAdmins;
    protected $MGeneral;
    protected $Gallery;
    protected $MLocation;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->Gallery = new MGallery();
        $this->MLocation = new MLocation();
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
        $type='';
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
       
        $data = array(
            'sitename' => $settings['name'],
            'type' => $type,
            'headings' => array('Thumb', 'Restaurant', 'Upload By', "Status",'Last update', 'Actions'),
            'pagetitle' => 'All Photos',
            'title' => 'Photos',
            'action' => 'admingallery',
            'country' => $country,
            'side_menu' => array('Gallery', 'Food Gallery'),
        );
        return view('admin.partials.photos', $data);
    }
    public function getGalleryData()
    {
        //$obj = new MGeneral();
        $query = DB::table('image_gallery')
            ->select(['image_gallery.*', 'restaurant_info.rest_Name','user.user_FullName','user.user_Email'])
            ->Leftjoin("restaurant_info", "image_gallery.rest_ID", "=", "restaurant_info.rest_ID")
            ->Leftjoin("user", "image_gallery.user_ID", "=", "user.user_ID");
            

        if (!in_array(0, adminCountry())) {
         $query->whereIn("image_gallery.country",  adminCountry());
        }
        if (get('status') or get('status')==0) {
            $query->where('image_gallery.status', intval(get('status')));
        }

        if (get('rest')) {
            $query->where('image_gallery.rest_ID', intval(get('rest')));
        }

            return  DataTables::of($query)
                ->addColumn('action', function ($gallery) {
                    $type=get('type');
                    $btns =
                        $btns = '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admingallery/form/',$gallery->image_ID).'?rest_ID='.$gallery->rest_ID.'&type='.$type . '" title="Edit Content"><i class="fa fa-edit"></i></a>';


                    if ($gallery->status == 0) {

                        $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admingallery/status/',$gallery->image_ID).'?rest_ID='.$gallery->rest_ID.'&type='.$type. '" title="Activate "><i class="fa fa-check"></i></a>';
                    } else {
                        $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="' . route('admingallery/status/',$gallery->image_ID).'?rest_ID='.$gallery->rest_ID.'&type='.$type. '" title="Deactivate"><i class="fa fa-ban"></i></a>';
                    }
                    $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-button" href="#" link="' . route('admingallery/delete/',$gallery->image_ID).'?rest_ID='.$gallery->rest_ID.'&type='.$type . '" title="Delete"><i class="fa fa-trash"></i></a>';
                 
                    return $btns;
                })
                ->editColumn('image_full', function ($gallery) {
                  return  '<img src="'.upload_url('/Gallery/thumb/'.$gallery->image_full).'" border="0" width="100" >';
                })
                ->addColumn('user_name', function ($gallery) {
                    $html='';
                    $type=get('type');
                    if ($type == "Sufrati") {
                        $html= 'Sufrati';
                    } else {
                        if ($gallery->user_ID != "") {
                                $html= $gallery->user_FullName . '<br>';
                                $html.= '<a href="mailto:' . $gallery->user_Email . '">' . $gallery->user_Email . '</a>';
                        
                        } else {
                            $html= 'Sufrati';
                        }
                    }
                    return $html;
                })
       

                ->addColumn('status_html', function ($gallery) {
                    return  $gallery->status == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
                })
    
                ->editColumn('updatedAt', function ($gallery) {
                    if ($gallery->updatedAt == "" || $gallery->updatedAt == "0000-00-00 00:00:00") {
                        return date('d/m/Y', strtotime($gallery->enter_time));
                    } else {
                        return date('d/m/Y', strtotime($gallery->updatedAt));
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
                'side_menu' => array('Gallery', 'Food Gallery'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Photo',
                'type' => $type,
                'restaurants' => $restaurants,
                'title' => 'New Photo',
                'side_menu' => array('Gallery', 'Food Gallery'),
            );
        }
        $data['country'] = $country;
        return view('admin.forms.photos', $data);
    }

    public function save()
    {
        Input::flash();
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
                return returnMsg('error', 'admingallery/form', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
            }
            $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/fullsize/", $save_name, true, null, 80);
            $text_font = $save_name . '-' . Input::get('title') . '- azooma.co';
            $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
            $textLayer->opacity(75);
            $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
            if (($actualWidth > 800)) {
                // $largeLayer->resizeInPixel(1500, null, $conserveProportion, $positionX, $positionY, $position);
            } else {
                if ($actualHeight > 500) {
                    // $largeLayer->resizeInPixel(null, 800, $conserveProportion, $positionX, $positionY, $position);  
                }
            }

            $largeLayer->save(Config::get('settings.uploadpath')  . "/Gallery/", $save_name, true, null, 80);

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
            $theight = $actualHeight * (1000 / $actualWidth);
            $expectedWidth = 1000;
            $expectedHeight = $theight;
            ($expectedWidth > $expectedHeight) ? $largestSide = $expectedWidth : $largestSide = $expectedHeight;
            $changelayer = clone $layer;
            $changelayer->resizeInPixel($largestSide, $largestSide);
            $changelayer->cropInPixel($expectedWidth, $expectedHeight, 0, 0, 'MM');
            $changelayer->save(Config::get('settings.uploadpath')  . "/Gallery/400x/", $save_name, true, null, 80);
            $changelayer = clone $layer;
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
            return returnMsg('success', 'admingallery', "Photo updated Succesfully.", array('type' => get('type')));
        } else {
            $id = $this->Gallery->addImage($image, $ratio, $actualWidth);
            $obj = $this->Gallery->getPhoto($id);
            $this->MAdmins->addActivity('Photo Added Succesfully - ' . $obj->title);
            return returnMsg('success', 'admingallery', "Photo Added Succesfully.", array('type' => get('type')));
        }
        return returnMsg('error', 'admingallery', "something went wrong, Please try again.", array('type' => get('type')));
    }

    public function status($id = 0)
    {
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
            return returnMsg('success','admingallery',"Photo Status changed successfully.", array('type' => get('type')));
        }
        return returnMsg('error','admingallery',"something went wrong, Please try again.", array('type' => get('type')));
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->Gallery->getPhoto($id);
        if (count($page) > 0) {
            DB::table('image_gallery')->where('image_ID', $id)->delete();
            $this->MAdmins->addActivity('Photo Deleted successfully.' . $page->title);
            return returnMsg('success','admingallery',"Photo Deleted successfully.", array('type' => get('type')));

        }
        return returnMsg('error','admingallery',"something went wrong, Please try again.", array('type' => get('type')));
    }

    public function videos()
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
            'side_menu' => array('Gallery', 'Video Uploads'),
        );
        return view('admin.partials.videos', $data);
    }

    public function videoform($id = 0)
    {
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
                'side_menu' => array('Gallery', 'Video Uploads'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Video',
                'restaurants' => $restaurants,
                'title' => 'New Video',
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => array('Gallery', 'Video Uploads'),
            );
        }
        return view('admin.forms.video', $data);
    }

    public function videosave()
    {
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

    public function videostatus($id = 0)
    {
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

    public function videodelete($id = 0)
    {
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
