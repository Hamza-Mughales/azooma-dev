<?php

class AdminUsers extends AdminController {

    protected $MAdmins;
    protected $MLocation;
    protected $MGeneral;
    protected $MUser;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
        $this->MUser = new User();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $status = 0;
        $name = "";
        $email = "";
        $sort = "";
        $countryuser = "";
        $nationality = "";
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        if (isset($_GET['name']) && ($_GET['name'] != "")) {
            $name = ($_GET['name']);
        }

        if (isset($_GET['email']) && ($_GET['email'] != "")) {
            $email = ($_GET['email']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }

        if (isset($_GET['country']) && ($_GET['country'] != "")) {
            $countryuser = ($_GET['country']);
        }

        if (isset($_GET['nationality']) && ($_GET['nationality'] != "")) {
            $nationality = ($_GET['nationality']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }


        $lists = User::getAllUsers($country, $status, $name, $email, $countryuser, $nationality, $sort);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Email', 'Country', 'Nationality', 'Joined Date', 'No of Activities', 'Action'),
            'pagetitle' => 'List of All Sufrati Users',
            'title' => 'All Sufrati Users',
            'action' => 'adminusers',
            'lists' => $lists,
            'side_menu' => array('Users','General Users'),
        );
        return view('admin.partials.users', $data);
    }

    public function view($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if ($id != 0) {
            $admin = User::getUser($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $admin->user_FullName,
                'title' => $admin->user_FullName,
                'user' => $admin
            );
        }
        return View::make('admin.index', $data)->nest('content', 'admin.forms.user', $data);
    }

}
