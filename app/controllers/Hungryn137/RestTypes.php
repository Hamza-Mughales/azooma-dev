<?php

use Yajra\DataTables\Facades\DataTables;

class RestTypes extends AdminController {

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
        $status = "";
        $sort = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['status']) ) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }


        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Created At', 'Actions'),
            'pagetitle' => 'All Restaurant Types',
            'title' => 'Restaurant Types',
            'action' => 'adminresttypes',
            'side_menu' => array('DB Management','Business Types'),
        );

        return view('admin.partials.resttypes', $data);
    }
    
    public function data_table()
    {
        $query = DB::table('rest_type');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }
        return  DataTables::of( $query)
            ->addColumn('action', function ($type) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info mytooltip mx-1" href="'. route('adminresttypes/form/',$type->id) .'" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($type->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="'. route('adminresttypes/status/',$type->id) .'" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="'. route('adminresttypes/status/',$type->id) .'" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip mx-1 cofirm-delete-btn" href="#" link="'. route('adminresttypes/delete/',$type->id) .'" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })
            
            ->editColumn('title', function ($style) {
                return  stripslashes($style->name);
            })
            
            ->editColumn('nameAr', function ($style) {
                return  stripslashes($style->nameAr);
            })
            
            ->editColumn('createdAt', function ($style) {
              return  date('d/m/Y', strtotime($style->createdAt));
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
            $page = $this->MRestActions->getRestType($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
            'side_menu' => array('DB Management','Business Types'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Restaurant Types',
                'title' => 'New Restaurant Types',
            'side_menu' => array('DB Management','Business Types'),
            );
        }
        return view('admin.forms.resttypes', $data);
    }

    public function save() {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MRestActions->updateRestType();
            $obj = $this->MRestActions->getRestType($id);
            $this->MAdmins->addActivity('Restaurant Type updated Succesfully ' . $obj->short);
            
            return returnMsg('success','adminresttypes',"Restaurant Type updated Succesfully.");
        } else {
            $id = $this->MRestActions->addRestType();
            $obj = $this->MRestActions->getRestType($id);
            $this->MAdmins->addActivity('Restaurant Type added Succesfully ' . $obj->short);
            
            return returnMsg('success','adminresttypes',"Restaurant Type added Succesfully.");
        }
        
        return returnMsg('error','adminresttypes',"Something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MRestActions->getRestType($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('rest_type')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Restaurant Type Status changed successfully.' . $page->short);

            return returnMsg('success','adminresttypes',"Restaurant Type Status changed successfully.");
        }
        
        return returnMsg('error','adminresttypes',"Something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MRestActions->getRestType($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteRestType($id);
            $this->MAdmins->addActivity('Restaurant Type deleted successfully.' . $page->short);
            
            return returnMsg('success','adminresttypes',"Restaurant Type deleted changed successfully.");
        }
        
        return returnMsg('error','adminresttypes',"Something went wrong, Please try again.");
    }

}
