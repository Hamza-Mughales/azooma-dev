<?php

use Yajra\DataTables\Facades\DataTables;

class AdminUsers extends AdminController
{

    protected $MAdmins;
    protected $MLocation;
    protected $MGeneral;
    protected $MUser;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
        $this->MUser = new User();
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
            'headings' => array('Name', 'Email', 'Country', 'Nationality', 'Joined Date', 'No of Activities', 'Action'),
            'pagetitle' => 'List of All Azooma Users',
            'title' => 'All Azooma Users',
            'action' => 'adminusers',
            'side_menu' => array('Users', 'General Users'),
        );
        return view('admin.partials.users', $data);
    }
    public function getUsersData()
    {
        $query = DB::table('user');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("sufrati",  adminCountry());
        }
   
        return  DataTables::of($query)
        ->addcolumn('action',function($row){
            $btns=' <a class="btn btn-xs btn-info mytooltip m-1" href="'.route('adminusers/view/',$row->user_ID).'" title="view"><i class="fa fa-eye"></i></a>';
            return $btns;
        })
        ->editcolumn('user_RegisDate',function($row){
            return date('d/m/Y', strtotime($row->user_RegisDate));
        })
        ->editcolumn('user_FullName',function($row){
            return stripslashes($row->user_FullName); 
        })
        ->editcolumn('user_Email',function($row){
            return stripslashes($row->user_Email); 
        })
        ->make(true);
    }
    public function view($id = 0)
    {
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
                'user' => $admin,
                'side_menu' => array('Users', 'General Users'),

            );
        }
        return view( 'admin.forms.user', $data);
    }
}
