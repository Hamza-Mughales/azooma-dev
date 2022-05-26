<?php

use Yajra\DataTables\Facades\DataTables;

class KnownFor extends AdminController
{

    protected $MAdmins;
    protected $MKnownFor;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MKnownFor = new MKnownFor();
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

        $city = 0;
        $status = 0;
        $limit = 20;
        $name = "";
        $status = "";
        $sort = "";
        $sortview = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['sortview']) && !empty($_GET['sortview'])) {
            $sortview = stripslashes($_GET['sortview']);
        }

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Known For Title', 'Total Rest', 'Description', 'Last Update on', 'Actions'),
            'pagetitle' => 'All Known For Restaurants',
            'title' => 'Known For Restaurants',
            'action' => 'adminknownfor',
            'side_menu' => array('Categories / Lists', 'Known For'),
        );

        return view('admin.partials.knownfor', $data);
    }

    public function data_table()
    {
        $query = DB::table('bestfor_list');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
            $query->select('*', DB::Raw('(SELECT count(* ) FROM restaurant_bestfor JOIN restaurant_info on restaurant_info.rest_ID=restaurant_bestfor.rest_ID WHERE restaurant_bestfor.bestfor_ID=bestfor_list.bestfor_ID AND restaurant_info.rest_Status=1) AS count'));
        }
        if (Input::has('status')) {
            $query->where("bestfor_Status", '=', intval(get('status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminknownfor/form/', $list->bestfor_ID) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($list->bestfor_Status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminknownfor/status/', $list->bestfor_ID) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminknownfor/status/', $list->bestfor_ID) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip mx-1 cofirm-delete-btn" href="#" link="' . route('adminknownfor/delete/', $list->bestfor_ID) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })

            ->editColumn('bestfor_Name', function ($list) {
                return  stripslashes($list->bestfor_Name);
            })

            ->editColumn('count', function ($list) {
                return  $list->count;
            })

            ->editColumn('best_for_desc', function ($list) {
                return  Str::limit(stripslashes(strip_tags(html_entity_decode($list->best_for_desc))), 100);
            })

            ->editColumn('updatedAt', function ($style) {
                return  date('d/m/Y', strtotime($style->updatedAt));
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
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $restaurants = MRestActions::getAllRestaurants($country);

        if ($id != 0) {
            $page = $this->MKnownFor->getBestFor($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->bestfor_Name,
                'title' => $page->bestfor_Name,
                'page' => $page,
                'restaurants' => $restaurants,
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Categories / Lists', 'Known For'),
            );
            $data['restaurantsbestfor'] = $this->MKnownFor->getBestForRest($id);
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Known For',
                'title' => 'New Known For',
                'restaurants' => $restaurants,
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Categories / Lists', 'Known For'),
            );
        }
        return view('admin.forms.knownfor', $data);
    }

    public function save()
    {
        if (Input::get('bestfor_ID')) {
            $id = Input::get('bestfor_ID');
            $this->MKnownFor->updatebestfor();
            $obj = $this->MKnownFor->getBestFor($id);
            $this->MAdmins->addActivity('Updated Known for ' . $obj->bestfor_name);

            return returnMsg('success', 'adminknownfor', "Known For updated succesfully.");
        } else {
            $id = $this->MKnownFor->addbestfor();
            $obj = $this->MKnownFor->getBestFor($id);
            $this->MAdmins->addActivity('Known for added Succesfully ' . $obj->bestfor_name);

            return returnMsg('success', 'adminknownfor', "Known for added Succesfully.");
        }

        return returnMsg('error', 'adminknownfor', "Something went wrong, Please try again.");
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MKnownFor->getBestFor($id);
        if (count($page) > 0) {
            if ($page->bestfor_Status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'bestfor_Status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );
            DB::table('bestfor_list')->where('bestfor_ID', $id)->update($data);
            $this->MAdmins->addActivity('Known for Status changed successfully.' . $page->short);

            return returnMsg('success', 'adminknownfor', "Known for Status changed successfully.");
        }

        return returnMsg('error', 'adminknownfor', "Something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MKnownFor->getBestFor($id);
        if (count($page) > 0) {
            $this->MKnownFor->deleteKnownFor($id);
            $this->MAdmins->addActivity('Known for Status changed successfully.' . $page->short);

            return returnMsg('success', 'adminknownfor', "Known for deleted successfully.");
        }

        return returnMsg('error', 'adminknownfor', "Something went wrong, Please try again.");
    }

    function addToFavorite()
    {
        $rest_ID = 0;
        $bestfor_ID = 0;
        if (isset($_GET['rest_ID']) && ($_GET['rest_ID'] != "")) {
            $rest_ID = ($_GET['rest_ID']);
        }
        if (isset($_GET['bestfor_ID']) && ($_GET['bestfor_ID'] != "")) {
            $bestfor_ID = ($_GET['bestfor_ID']);
        }
        $this->MKnownFor->addToFavorite($rest_ID, $bestfor_ID);
        $result['result'] = 'true';
        return Response::json($result);
    }
}
