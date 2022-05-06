<?php

class Press extends AdminController {

    protected $MAdmins;
    protected $MPress;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MPress = new MPress();
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
        $MPress = DB::table('press');
        //MPress::orderBy('newsDate', 'DESC');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MPress->where('short', 'LIKE', stripslashes($_GET['name']) . '%');
        }
        if (!empty($sort)) {
            switch ($sort) {
                case "latest":
                    $MPress->orderBy('newsDate', 'DESC');
                    break;
                case "name":
                    $MPress->orderBy('short', 'ASC');
                    break;
            }
        }
        if ($status != "") {
            $MPress->where('status', '=', $status);
        }

        $MPress->where('country', '=', $country);
        $lists = $MPress->paginate(15);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Press Title', 'Title Arabic', 'Description', 'Last Update on', 'Actions'),
            'resultheads' => array('short', 'short_ar', 'full', 'newsDate/updatedAt'),
            'actions' => array('edit', 'status', 'delete'),
            'pagetitle' => 'All Press',
            'title' => 'Press',
            'action' => 'adminpress',
            'statuslink' => 'adminpress/status',
            'deletelink' => 'adminpress/delete',
            'addlink' => 'adminpress/form',
            'lists' => $lists,
            'side_menu' => array('Corporate Pages','Press'),
        );

        return view('admin.partials.maincommonpage', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = Mpress::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->short,
                'title' => $page->short,
                'page' => $page,
                'side_menu' => array('Corporate Pages','Press'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Press',
                'title' => 'New Press',
                'side_menu' => array('Corporate Pages','Press'),
            );
        }
        return view('admin.forms.press', $data);
    }

    public function save() {
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
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/news/", $save_name, true, null, 95);
            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/news/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(150, 150);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/news/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }

        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MPress->updatePress($filename);
            $obj = MPress::find($id);
            $this->MAdmins->addActivity('Press updated Succesfully ' . $obj->short);
            return Redirect::route('adminpress')->with('message', "Press updated Succesfully.");
        } else {
            $id = $this->MPress->addPress($filename);
            $obj = MPress::find($id);
            $this->MAdmins->addActivity('Press added Succesfully ' . $obj->short);
            return Redirect::route('adminpress')->with('message', "Press added Succesfully.");
        }
        return Redirect::route('adminpress')->with('error', "something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = MPress::find($id);
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

            DB::table('press')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Press Status changed successfully.' . $page->short);
            return Redirect::route('adminpress')->with('message', "Press Status changed successfully.");
        }
        return Redirect::route('adminpress')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = MPress::find($id);
        if (count($page) > 0) {
            MPress::destroy($id);
            $this->MAdmins->addActivity('Press Status changed successfully.' . $page->short);
            return Redirect::route('adminpress')->with('message', "Your data has been save successfully.");
        }
        return Redirect::route('adminpress')->with('error', "something went wrong, Please try again.");
    }

}
