<?php

use Yajra\DataTables\Facades\DataTables;

class Favorites extends AdminController {

    protected $MAdmins;
    protected $MRestaurant;
    protected $MGeneral;
    protected $MRestActions;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MRestaurant = new MRestaurant();
        $this->MRestActions = new MRestActions();
        $this->MGeneral = new MGeneral();
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

        $limit = 20;
        $city = 0;
        $name = "";
        $status = "";
        $sort = "";
        $sortview="";
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
        if (isset($_GET['sortview']) && !empty($_GET['sortview'])) {
            $sortview = stripslashes($_GET['sortview']);
        }
        
        
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant Name', 'Restaurant Name Arabic', 'Total Views', 'Action'),
            'pagetitle' => 'All Sufrati Favourites Reaturants',
            'title' => 'Sufrati Favourites Reaturants',
            'action' => 'adminfavorites',
            'country' => $country,
            'side_menu' => array('Categories / Lists','Favorites'),
        );
        
        return view('admin.partials.favourites', $data);
    }

    public function data_table()
    {
        $query = DB::table('restaurant_info');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('sortview')) {
            if (intval(Input::has('sortview')) == 2) {
                $query->orderBy('sufrati_favourite', 'DESC');
            } else {
                $query->orderBy('sufrati_favourite', 'ASC');
            }
        }
        return  DataTables::of( $query)
            ->addColumn('action', function ($list) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info mytooltip m-1" href="'. route('adminfavorites/form/',$list->rest_ID) .'" title="Edit Content"><i class="fa fa-edit"></i></a>';

                    $btns .= '<a class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-btn" href="#" link="'. route('adminfavorites/remove/',$list->rest_ID) .'" title="Remove"><i class="fa fa-trash"></i></a>';
                return $btns;
            })
            
            ->editColumn('name', function ($style) {
                return  stripslashes($style->rest_Name);
            })
            
            ->editColumn('nameAr', function ($style) {
                return  stripslashes($style->rest_Name_Ar);
            })
            
            ->editColumn('totalViews', function ($style) {
              return  stripslashes($style->total_view);
            })
            ->make(true);
    }

    public function remove($id = 0) {
        $rest = MRestaurant::where('rest_ID', '=', $id)->first();
        $this->MRestActions->removeFavorite($id);
        $this->MAdmins->addActivity('Removed - ' . $rest->rest_Name . '  from Favorites ');
        if(isset($_REQUEST['rest']) && $_REQUEST['rest']=="1"){
            
            return returnMsg('success','adminrestaurants', $rest->rest_Name . '  remove from Favorites');
        }else{
            
            return returnMsg('success','adminfavorites', $rest->rest_Name . '  remove from Favorites');
        }
    }

    function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $rest = $this->MRestaurant->getRest($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $rest->rest_Name,
                'title' => $rest->rest_Name,
                'page' => $rest,
                'side_menu' => array('Categories / Lists','Favorites'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'Edit Sufrati Favorites',
                'title' => 'Edit Sufrati Favorites',
                'side_menu' => array('Categories / Lists','Favorites'),
            );
        }
        return view('admin.forms.favorites', $data);


        if ($id != 0) {
            $data['rest'] = $this->MRestActions->getRest($id);
            $data['pagetitle'] = strip_slashes(htmlspecialchars($data['rest']['rest_Name']));
        } else {
            $data['pagetitle'] = 'Edit Sufrati favourite';
        }
        $data['main'] = 'favoriteform';
        $data['js'] = 'validate';
        $this->load->view('admin/template', $data);
    }

    function save($option = "") {
        if (Input::get('rest_ID')) {
            $id = (Input::get('rest_ID'));
            $this->MRestActions->updateFavoriteRest();
            $obj = $this->MRestActions->getRest($id);
            $this->MAdmins->addActivity('favourite Restaurant ' . $obj->rest_Name . ' updated Succesfully ');
            
            return returnMsg('success','adminfavorites','favourite Restaurant ' . $obj->rest_Name . ' updated Succesfully.');
        } else {
            
            return returnMsg('error','adminfavorites','Something went wrong, please try again.');
        }
    }

    public function favourite($id = 0) {
        $rest = $this->MRestActions->getRest($id);
        $this->MRestActions->addFavorite($id);
        $this->MAdmins->addActivity(stripslashes(($rest->rest_Name)) . ' added to favorites');
        
            return returnMsg('success','adminrestaurants',stripslashes(($rest->rest_Name)) . ' added to Favourites Succesfully.');
    }

}
