<?php

use Yajra\DataTables\Facades\DataTables;

class TeamAdminController extends AdminController {

    protected $MTeam;

    public function __construct() {
        parent::__construct();
        $this->MTeam = new Team();
    }

    public function index() {
        $status = "";
        $sort = "";
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $MTeam = DB::table('ourteam');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MTeam->where('name', 'LIKE', "%" . stripslashes($_GET['name']) . '%');
        }
        $MTeam->where('country', '=', $country);

        if (!empty($sort)) {
            switch ($sort) {
                case "latest":
                    $MTeam->orderBy('createdAt', 'DESC');
                    break;
                case "name":
                    $MTeam->orderBy('name', 'ASC');
                    break;
            }
        }
        if ($status != "") {
            $MTeam->where('status', '=', $status);
        }

        $lists = $MTeam->paginate(2000);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Title', 'Description', 'Last Update on', 'Actions'),
            'resultheads' => array('name', 'jobtitle', 'description', 'createdAt/updatedAt'),
            'actions' => array('edit', 'status', 'delete'),
            'pagetitle' => 'List of All Team Members',
            'title' => 'Creative Team',
            'action' => 'adminteam',
            'statuslink' => 'adminteam/status',
            'deletelink' => 'adminteam/delete',
            'addlink' => 'adminteam/form',
            'lists' => $lists,
            'side_menu' => array('Corporate Pages','Team'),
        );
        return view('admin.partials.restTeam', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = Team::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('Corporate Pages','Team'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Static Page',
                'title' => 'New Static Page',
                'side_menu' => array('Corporate Pages','Team'),
            );
        }
        return view('admin.forms.team', $data);
    }

    public function save() {
        $status = 0;
        $url = "";
        $filename = "";
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $temp_name = $_FILES['image']['tmp_name'];
            $filename = $file->getClientOriginalName();
            $filename = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/team/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/team/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(150, 150);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/team/", $save_name, true, null, 95);
            
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }
        $url = Str::slug((Input::get('name')), 'dash', TRUE);
        if (Input::get('status') != "") {
            $status = Input::get('status');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name' => (Input::get('name')),
            'nameAr' => (Input::get('nameAr')),
            'description' => htmlentities(Input::get('description')),
            'descriptionAr' => Input::get('descriptionAr'),
            'jobtitle' => (Input::get('jobtitle')),
            'jobtitleAr' => (Input::get('jobtitleAr')),
            'image' => $filename,
            'url' => $url,
            'country' => $country,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        if (Input::get('id')) {
            DB::table('ourteam')->where('id', Input::get('id'))->update($data);
        } else {
            DB::table('ourteam')->insert($data);
        }
        
        return returnMsg('success','adminteam',"Your data has been save successfully.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = Team::find($id);
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

            DB::table('ourteam')->where('id', $id)->update($data);
            
            return returnMsg('success','adminteam',"Your data has been save successfully.");
        }
        
        return returnMsg('error','adminteam',"something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = Team::find($id);
        if (count($page) > 0) {
            Team::destroy($id);
            
            return returnMsg('success','adminteam',"Your data has been save successfully.");
        }
        
        return returnMsg('error','adminteam',"something went wrong, Please try again.");
    }

}
