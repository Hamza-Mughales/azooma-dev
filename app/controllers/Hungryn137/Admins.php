<?php

class Admins extends AdminController {

    protected $MAdmins;
    protected $MLocation;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MLocation = new MLocation();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $MAdmins = Admin::orderBy('lastlogin', 'DESC');
        $MAdmins = Admin::where('country', '=',$country);
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MAdmins = Admin::where('fullname', 'LIKE', stripslashes($_GET['name']) . '%');
        }
        if (isset($_GET['email']) && !empty($_GET['email'])) {
            $MAdmins = Admin::where('email', 'LIKE', stripslashes($_GET['email']) . '%');
        }
        $lists = $MAdmins->paginate(15);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Email', 'Country', 'Last Login', 'Actions'),
            'pagetitle' => 'List of All Administrators',
            'title' => 'Administrators',
            'action' => 'admins',
            'lists' => $lists,
            'side_menu' => array('Users','Administrators'),
        );
        return view('admin.partials.admins', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }


        if ($id != 0) {
            $admin = Admin::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $admin->fullname,
                'title' => $admin->fullname,
                'admin' => $admin,
            'side_menu' => array('Users','Administrators'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Administrator',
                'title' => 'Administrator',
            'side_menu' => array('Users','Administrators'),
            );
        }
        return view('admin.forms.admins', $data);
    }

    public function Save() {
        $MAdmins = New Admin();
        if (Input::get('id')) {
            $id = Input::get('id');
            $MAdmins->updateAdmin();
            $admin = Admin::find($id);
            $MAdmins->addActivity('Administrator updated Succesfully ' . $admin->fullname);
            return Redirect::route('admins')->with('message', "Administrator updated Succesfully.");
        } else {
            $id = $MAdmins->addAdmin();
            $admin = Admin::find($id);
            $MAdmins->addActivity('Administrator added Succesfully ' . $admin->fullname);
            if (Input::get('admin') == 0) {
                return Redirect::route('admins/permissions/' . $admin->id)->with('entry', '1')->with('message', "Admin added succesfully, please specify Permissions");
            }
            return Redirect::route('admins')->with('message', "Administrator added Succesfully.");
        }
    }

    public function status($id = 0) {
        $MAdmins = New Admin();
        $status = 0;
        $admin = Admin::find($id);
        if (count($admin) > 0) {
            if ($admin->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('admin')->where('id', $id)->update($data);
            $MAdmins->addActivity('Status Changed Succesfully ' . $admin->fullname);
            return Redirect::route('admins')->with('message', "Status Changed Succesfully.");
        }
        return Redirect::route('admins')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $MAdmins = New Admin();
        $status = 0;
        $admin = Admin::find($id);
        if (count($admin) > 0) {
            Admin::destroy($id);
            $MAdmins->addActivity('Administrator deleted Succesfully ' . $admin->fullname);
            return Redirect::route('admins')->with('message', "Administrator deleted Succesfully.");
        }
        return Redirect::route('admins')->with('error', "something went wrong, Please try again.");
    }

    function password($id = 0) {
        $settings = settings::where('id', '=', '1')->first();
        Session::put('sitename', $settings['name']);
        $logo = ArtWork::where('art_work_name', '=', 'Azooma Logo')->orderBy('createdAt', 'DESC')->first();
        if ($id == 0) {
            $id = Session::get('adminid');
        }
        $admin = Admin::find($id);
        $data = array(
            'sitename' => $settings['name'],
            'pagetitle' => $admin->fullname,
            'title' => $admin->fullname,
            'admin' => $admin,
            'side_menu' => array('Users','Administrators'),
        );
        return view('admin.forms.adminpassword', $data);
    }

    function savePassword() {
        $MAdmins = New Admin();
        if (Input::get('id')) {
            $id = Input::get('id');
            $admin = Admin::find($id);
            $MAdmins->changePassword();
            $MAdmins->addActivity('Password Changed Succesfully ' . $admin->fullname);
            return Redirect::route('admins')->with('message', "Password Changed succesfully");
        }
    }

    function permissions($id = 0) {
        $MAdmins = New Admin();
        $settings = settings::where('id', '=', '1')->first();
        Session::put('sitename', $settings['name']);
        $logo = ArtWork::where('art_work_name', '=', 'Azooma Logo')->orderBy('createdAt', 'DESC')->first();
        if ($id == 0) {
            $id = Session::get('adminid');
        }
        $admin = Admin::find($id);

        $permissions = $MAdmins->getAllPermissions();

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Email', 'Last Login', 'Actions'),
            'pagetitle' => "Updating Permissions for " . $admin->fullname,
            'title' => $admin->fullname,
            'permissions' => $permissions,
            'admin' => $admin,
            'side_menu' => array('Users','Administrators'),
        );
        $entry = Session::get('entry');
        if (isset($entry) && ($entry == 1)) {
            $data['entry'] = array('26', '27', '28', '31', '32', '33', '');
        }
        return view('admin.forms.adminpermissions', $data);
    }

    function savePermissions() {
        $MAdmins = New Admin();
        $MAdmins->updatePermissions();
        $id = Input::get('id');
        $admin = Admin::find($id);
        $MAdmins->addActivity('Updated permissions for Administrator - ' . $admin->fullname);
        return Redirect::route('admins')->with('message', "Administrator Permissions updated succesfully");
    }

    function activity($id = 0) {
        $MAdmins = New Admin();
        $settings = settings::where('id', '=', '1')->first();
        Session::put('sitename', $settings['name']);
        $logo = ArtWork::where('art_work_name', '=', 'Azooma Logo')->orderBy('createdAt', 'DESC')->first();
        if ($id == 0) {
            $id = Session::get('adminid');
        }
        $admin = Admin::find($id);
        $activities = $MAdmins->getAdminActivity($admin->user);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Activity', 'Date'),
            'pagetitle' => "List of all Activities of " . $admin->fullname,
            'title' => 'Activities',
            'lists' => $activities,
            'admin' => $admin,
            'side_menu' => array('Users','Administrators'),
        );
        return view('admin.partials.adminActivities', $data);
    }

}