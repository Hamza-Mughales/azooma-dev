<?php

use Yajra\DataTables\Facades\DataTables;

class ArtWorkController extends AdminController
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
   
        $type = "Home Page Artwork";

        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $type = $_GET['type'];
        }
        if (empty($type)) {
            $type = 'Azooma Logo';
        }
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Artwork',"Status", 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All ' . $type . ' Artworks',
            'title' => $type . ' Artworks',
            'action' => 'adminartkwork',
            'type' => $type,
            'side_menu' => array('Art Work', $type),
        );
        return view('admin.partials.artwork', $data);
    }
    public function getArtworkData()
    {
        $query = DB::table('art_work')
        ->select(['art_work.*']);
    if (!in_array(0, adminCountry())) {
        $query->whereIn("country",  adminCountry());
    }
    if (get('status') or get('status')==='0') {
        $query->where('active', intval(get('status')));
    }
    if (get('city_ID')) {
        $query->where('city_ID', '=',get('city_ID'));
    }
    if (get('type')) {
        $query->where('art_work_name', '=',get('type'));
    }
    
    return  DataTables::of($query)
        ->addColumn('action', function ($row) {
            $type=get('type');
            $btns ='';
        
                $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' .route('adminartkwork/form/',$row->id).'?type='.$type
                . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

            if ($row->active == 0) {

                $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminartkwork/status/',$row->id).  '" title="Activate "><i class="fa fa-check"></i></a>';
            } else {
                $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="' . route('adminartkwork/status/',$row->id). '" title="Deactivate"><i class="fa fa-ban"></i></a>';
            }
            $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-button" href="#" link="' . route('adminartkwork/delete/',$row->id)  . '" title="Delete"><i class="fa fa-trash"></i></a>';

            return $btns;
        })
 
 
        ->addColumn('image', function ($row) {
            $html='';
            $type=get('type');
            if ($type == "Azooma Logo") {

                $html='<img src="'.upload_url('sufratilogo/' . $row->image).'" border="0" width="100" >';
            } else {
           
                $html=' <img src="'.upload_url('images/' . $row->image).'" border="0" width="100" >';
            }
             return $html;
        })


        ->addColumn('status_html', function ($row) {
            return  $row->active == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
        })

        ->editColumn('updatedAt', function ($row) {
            if ($row->updatedAt == "" || $row->updatedAt == "0000-00-00 00:00:00") {
                return date('d/m/Y', strtotime($row->createdAt));
            } else {
                return date('d/m/Y', strtotime($row->updatedAt));
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
                'side_menu' => array('Art Work',  $type ),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'art_work_name' => $type,
                'pagetitle' => 'New Artwork',
                'title' => 'New Artwork',
                'js' => 'chosen.jquery',
                'css' => 'chosen',
                'side_menu' => array('Art Work',  $type ),
            );
        }
        return view('admin.forms.artwork', $data);
    }

    public function save()
    {
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
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/sufratilogo/" . $save_name);
                $changelayer = clone $layer;

                $changelayer->save(Config::get('settings.uploadpath') . "/sufratilogo/", $save_name, true, null, 95);
            } else {
                //Home Page slider
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 95);
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/" . $save_name);
                $changelayer = clone $layer;
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
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/sufratilogo/" . $save_name);
                $changelayer = clone $layer;
                // $changelayer->resizeInPixel(183, 50);
                $changelayer->save(Config::get('settings.uploadpath') . "/sufratilogo/", $save_name, true, null, 95);
            } else {
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/", $save_name, true, null, 80);
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/" . $save_name);
                $changelayer = clone $layer;
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
        return returnMsg('success', 'adminartkwork', 'Your data has been save successfully.', array('type' => Input::get('art_work_name')));
    }

    public function status($id = 0)
    {
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
            return returnMsg('success', 'adminartkwork', 'Status had been changed successfully.', array('type' => $page->art_work_name));
        }
        return returnMsg('error', 'adminartkwork', 'something went wrong, Please try again.', array('type' => $page->art_work_name));
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = ArtWork::find($id);
        if (count($page) > 0) {
            ArtWork::destroy($id);
            return returnMsg('success', 'adminartkwork', 'Delete Proccess done successfully.', array('type' => $page->art_work_name));
        }
        return returnMsg('error', 'adminartkwork', 'something went wrong, Please try again.', array('type' => $page->art_work_name));
    }
}
