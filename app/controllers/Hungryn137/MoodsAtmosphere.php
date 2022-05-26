<?php

use Yajra\DataTables\Facades\DataTables;

class MoodsAtmosphere extends AdminController
{

    protected $MAdmins;
    protected $MRestActions;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MRestActions = new MRestActions();
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

        $limit = 20;
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

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Last updated At', 'Actions'),
            'pagetitle' => 'All Restaurant Moods & Atmosphere',
            'title' => 'Restaurant Moods & Atmosphere',
            'action' => 'adminmoodsatmosphere',
            'side_menu' => array('DB Management', 'Moods & Atmosphere'),
        );

        return view('admin.partials.moodsatmosphere', $data);
    }

    public function data_table()
    {
        $query = DB::table('moodsatmosphere');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }

        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminmoodsatmosphere/form/', $list->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($list->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminmoodsatmosphere/status/', $list->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminmoodsatmosphere/status/', $list->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip mx-1 cofirm-delete-btn" href="#"  link="' . route('adminmoodsatmosphere/delete/', $list->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })

            ->editColumn('title', function ($style) {
                return  stripslashes($style->name);
            })

            ->editColumn('nameAr', function ($style) {
                return  stripslashes($style->nameAr);
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

        if ($id != 0) {
            $page = $this->MRestActions->getMoodsAtmosphere($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('DB Management', 'Moods & Atmosphere'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Restaurant Moods & Atmosphere',
                'title' => 'New Restaurant Moods & Atmosphere',
                'side_menu' => array('DB Management', 'Moods & Atmosphere'),
            );
        }

        return view('admin.forms.moodsatmosphere', $data);
    }

    public function save()
    {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MRestActions->updateMoodsAtmosphere();
            $obj = $this->MRestActions->getMoodsAtmosphere($id);
            $this->MAdmins->addActivity('Restaurant Moods & Atmosphere updated Succesfully ' . $obj->short);

            return returnMsg('success', 'adminmoodsatmosphere', "Restaurant Moods & Atmosphere updated Succesfully.");
        } else {
            $id = $this->MRestActions->addMoodsAtmosphere();
            $obj = $this->MRestActions->getMoodsAtmosphere($id);
            $this->MAdmins->addActivity('Restaurant Moods & Atmosphere added Succesfully ' . $obj->short);

            return returnMsg('success', 'adminmoodsatmosphere', "Restaurant Moods & Atmosphere added Succesfully.");
        }

        return returnMsg('error', 'adminmoodsatmosphere', "Something went wrong, Please try again.");
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getMoodsAtmosphere($id);
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
            DB::table('moodsatmosphere')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Restaurant Moods & Atmosphere Status changed successfully.' . $page->short);

            return returnMsg('success', 'adminmoodsatmosphere', "Restaurant Moods & Atmosphere Status changed successfully.");
        }

        return returnMsg('error', 'adminmoodsatmosphere', "Something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getMoodsAtmosphere($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteMoodsAtmosphere($id);
            $this->MAdmins->addActivity('Restaurant Moods & Atmosphere deleted successfully.' . $page->short);

            return returnMsg('success', 'adminmoodsatmosphere', "Restaurant Moods & Atmosphere deleted successfully.");
        }

        return returnMsg('error', 'adminmoodsatmosphere', "Something went wrong, Please try again.");
    }
}
