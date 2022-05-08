<?php

use Yajra\DataTables\Facades\DataTables;
class RestStyle extends AdminController {

    protected $MAdmins;
    protected $MRestActions;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MRestActions = new MRestActions();
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
        $name = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Created At', 'Actions'),
            'pagetitle' => 'All Restaurant Styles',
            'title' => 'Restaurant Styles',
            'action' => 'adminreststyle',
            'side_menu' => array('DB Management','Restaurant Style'),
        );

        return view('admin.partials.reststyle', $data);
    }

    public function data_table()
    {
        $query = DB::table('rest_style');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($style) {
                $btns ='';
                    $btns = '<a class="btn btn-xs btn-info mytooltip mx-1" href="'. route('adminreststyle/form/', $style->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($style->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="'. route('adminreststyle/status/', $style->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminreststyle/status/', $style->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip mx-1 cofirm-delete-btn" href="#" link="'. route('adminreststyle/delete/',$style->id) .'" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })
            ->editColumn('title', function ($style) {
                return  stripslashes($style->name);
            })
            
            ->editColumn('createdAt', function ($style) {
               return date('d/m/Y', strtotime($style->createdAt));
            })
            ->make(true);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = $this->MRestActions->getRestStyle($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
            'side_menu' => array('DB Management','Restaurant Style'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Restaurant Style',
                'title' => 'New Restaurant Style',
            'side_menu' => array('DB Management','Restaurant Style'),
            );
        }
        return view('admin.forms.reststyle', $data);
    }

    public function save() {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MRestActions->updateRestStyle();
            $obj = $this->MRestActions->getRestStyle($id);
            $this->MAdmins->addActivity('Restaurant Style updated Succesfully ' . $obj->short);
            return returnMsg('success','adminreststyle',"Restaurant Style updated Succesfully.");
        } else {
            $id = $this->MRestActions->addRestStyle();
            $obj = $this->MRestActions->getRestStyle($id);
            $this->MAdmins->addActivity('Restaurant Style added Succesfully ' . $obj->short);

            return returnMsg('success','adminreststyle',"Restaurant Style added Succesfully.");
        }
        return returnMsg('error','adminreststyle',"something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MRestActions->getRestStyle($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );

            DB::table('rest_style')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Restaurant Style Status changed successfully.' . $page->short);
            
            return returnMsg('success','adminreststyle',"Restaurant Style Status changed successfully.");
        }
        
        return returnMsg('error','adminreststyle',"Something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MRestActions->getRestStyle($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteRestStyle($id);
            $this->MAdmins->addActivity('Restaurant Style deleted successfully.' . $page->short);
            return returnMsg('success','adminreststyle',"Restaurant Style deleted successfully.");
        }
        
        return returnMsg('error','adminreststyle',"Something went wrong, Please try again.");
    }

}