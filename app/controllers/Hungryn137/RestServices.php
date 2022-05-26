<?php

use Yajra\DataTables\Facades\DataTables;

class RestServices extends AdminController
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
        $city = 0;
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
            'pagetitle' => 'All Restaurant Features & Services',
            'title' => 'Restaurant Features & Services',
            'action' => 'adminrestservices',
            'side_menu' => array('DB Management', 'Features & Services'),
        );

        return view('admin.partials.restservices', $data);
    }

    public function data_table()
    {
        $query = DB::table('features_services');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($service) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminrestservices/form/', $service->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($service->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminrestservices/status/', $service->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminrestservices/status/', $service->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip mx-1 cofirm-delete-btn" href="#" link="' . route('adminrestservices/delete/', $service->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
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
            $page = $this->MRestActions->getRestService($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('DB Management', 'Features & Services'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Restaurant Features & Services',
                'title' => 'New Restaurant Features & Services',
                'side_menu' => array('DB Management', 'Features & Services'),
            );
        }
        return view('admin.forms.restservices', $data);
    }

    public function save()
    {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MRestActions->updateRestServices();
            $obj = $this->MRestActions->getRestService($id);
            $this->MAdmins->addActivity('Restaurant Features or Service updated Succesfully ' . $obj->short);

            return returnMsg('success', 'adminrestservices', "Restaurant Features or Service updated Succesfully.");
        } else {
            $id = $this->MRestActions->addRestServices();
            $obj = $this->MRestActions->getRestService($id);
            $this->MAdmins->addActivity('Restaurant Features or Service added Succesfully ' . $obj->short);

            return returnMsg('success', 'adminrestservices', "Restaurant Features or Service added Succesfully.");
        }

        return returnMsg('error', 'adminrestservices', "Something went wrong, Please try again.");
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getRestService($id);
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
            DB::table('features_services')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Restaurant Features or Service Status changed successfully.' . $page->short);

            return returnMsg('success', 'adminrestservices', "Restaurant Features or Service Status changed successfully.");
        }

        return returnMsg('error', 'adminrestservices', "Something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MRestActions->getRestService($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteRestService($id);
            $this->MAdmins->addActivity('Restaurant Features or Service deleted successfully.' . $page->short);

            return returnMsg('success', 'adminrestservices', "Restaurant Features or Service deleted successfully.");
        }

        return returnMsg('error', 'adminrestservices', "Something went wrong, Please try again.");
    }
}
