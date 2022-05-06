<?php

use Yajra\DataTables\Facades\DataTables;

class Suggested extends AdminController {

    protected $MAdmins;
    protected $MSuggested;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MRestaurant = new MRestaurant();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $limit = 20;
        $city = $type = $rest_Name = "";
        if (isset($_GET['city']) && ($_GET['city'] != "")) {
            $city = ($_GET['city']);
        }
        if (isset($_GET['name']) && ($_GET['name'] != "")) {
            $rest_Name = ($_GET['name']);
        }
        if (isset($_GET['city']) && ($_GET['city'] != "")) {
            $city = ($_GET['city']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['type']) && ($_GET['type'] != "")) {
            $type = ($_GET['type']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $meals = array(
            'iftar' => 'iftar',
            'suhur' => 'suhur',
            'breakfast' => 'Breakfast',
            'brunch' => 'Brunch',
            'lunch' => 'Lunch',
            'dinner' => 'Dinner',
            'latenight' => 'Latenight'
        );
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant Name', 'Breakfast', 'Lunch', 'Dinner', 'Late Night', 'Iftar', 'Suhur'),
            'pagetitle' => 'All Suggested Reaturants',
            'title' => 'Suggested Reaturants',
            'action' => 'adminpress',
            'mealsType' => $meals,
            'country' => $country,
            'side_menu' => array('Categories / Lists','Suggested'),
        );

        return view('admin.partials.suggested', $data);
    }

    public function data_table()
    {
        $query = DB::table('restaurant_info');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('rest_name')) {
            $query->where("rest_Name", 'LIKE', get('rest_name').'%');
        }
        if (Input::has('meal_type')) {
            $query->where(get('meal_type'),'=', 1);
        }
        if (Input::has('status')) {
            $query->where("rest_Status", '=', intval(get('status')));
        }
        return  DataTables::of( $query)
            ->addColumn('breakfast', function ($list) {
                $btns ='';
                if ($list->breakfast == 1) {
                    $btns .= '<a class="label label-default mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=breakfast' .'" title="Active Breakfast">
                                <i data-feather="plus-circle"></i> Active
                             </a>';
                } else {
                    $btns .= '<a class="label label-primary mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=breakfast' .'" title="Inactive Breakfast">
                    <i class="glyphicon glyphicon-remove"></i> Inactive
                </a>';
                }
                return $btns;
            })
            ->addColumn('lunch', function ($list) {
                $btns ='';
                if ($list->lunch == 1) {
                    $btns .= '<a class="label label-default mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=lunch' .'" title="Active Breakfast">
                                <i data-feather="plus-circle"></i> Active
                              </a>';
                } else {
                    $btns .= '<a class="label label-primary mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=lunch' .' "title="Inactive Breakfast">
                                <i class="glyphicon glyphicon-remove"></i> Inactive
                               </a>';
                }
                return $btns;
            })
            ->addColumn('dinner', function ($list) {
                $btns ='';
                if ($list->dinner == 1) {
                    $btns .= '<a class="label label-default mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=dinner' .'" title="Active Breakfast">
                                <i data-feather="plus-circle"></i> Active
                              </a>';
                } else {
                    $btns .= '<a class="label label-primary mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=dinner' .'" title="Inactive Breakfast">
                                <i class="glyphicon glyphicon-remove"></i> Inactive
                              </a>';
                }
                return $btns;
            })
            ->addColumn('latenight', function ($list) {
                $btns ='';
                if ($list->latenight == 1) {
                    $btns .= '<a class="label label-default mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=latenight' .'" title="Active Breakfast">
                                <i data-feather="plus-circle"></i> Active
                             </a>';
                } else {
                    $btns .= '<a class="label label-primary mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=latenight' .'" title="Inactive Breakfast">
                                <i class="glyphicon glyphicon-remove"></i> Inactive
                              </a>';
                }
                return $btns;
            })
            ->addColumn('iftar', function ($list) {
                $btns ='';
                if ($list->iftar == 1) {
                    $btns .= '<a class="label label-default mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=iftar' .'" title="Active Breakfast">
                                <i data-feather="plus-circle"></i> Active
                             </a>';
                } else {
                    $btns .= '<a class="label label-primary mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=iftar' .'" title="Inactive Breakfast">
                                <i class="glyphicon glyphicon-remove"></i> Inactive
                             </a>';
                }
                return $btns;
            })
            ->addColumn('suhur', function ($list) {
                $btns ='';
                if ($list->suhur == 1) {
                    $btns .= '<a class="label label-default mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=suhur' .'" title="Active Breakfast">
                                <i data-feather="plus-circle"></i> Active
                             </a>';
                } else {
                    $btns .= '<a class="label label-primary mytooltip" href="'. route('adminsuggested/status/',$list->rest_ID).'?type=suhur' .'" title="Inactive Breakfast">
                                <i class="glyphicon glyphicon-remove"></i> Inactive
                             </a>';
                }
                return $btns;
            })
            
            ->editColumn('rest_Name', function ($rest) {
                return  stripslashes($rest->rest_Name);
            })
            
            ->make(true);
    }

    public function status($id = 0) {
        $type = '';
        if (isset($_GET['type']) && ($_GET['type'] != "")) {
            $type = ($_GET['type']);
        }
        $rest = MRestaurant::where('rest_ID', '=', $id)->first();
        $this->MRestaurant->suggestedType($id, $type);
        $this->MAdmins->addActivity('Suggested - ' . $rest->rest_Name . '  for ' . $type);
        
        return returnMsg('success','adminsuggested','Suggested - ' . $rest->rest_Name . '  for ' . $type);
    }

}
