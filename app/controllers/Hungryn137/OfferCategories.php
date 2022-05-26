<?php

use Yajra\DataTables\Facades\DataTables;

class OfferCategories extends AdminController
{

    protected $MAdmins;
    protected $MOffers;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MOffers = new MOffers();
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
        if (isset($_GET['city']) && !empty($_GET['city'])) {
            $city = stripslashes($_GET['city']);
        }

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Created At', 'Actions'),
            'pagetitle' => 'All Offers Categories',
            'title' => 'Offers Categories',
            'action' => 'adminofferscategoires',
            'country' => $country,
            'side_menu' => array('DB Management', 'Offer Categories'),
        );

        return view('admin.partials.Offercategories', $data);
    }

    public function data_table()
    {
        $query = DB::table('offer_category');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns = '';
                $btns = '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminofferscategoires/form/', $list->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($list->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminofferscategoires/status/', $list->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip mx-1" href="' . route('adminofferscategoires/status/', $list->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip mx-1 cofirm-delete-btn" href="#" link="' . route('adminofferscategoires/delete/', $list->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })

            ->editColumn('title', function ($style) {
                return  stripslashes($style->categoryName);
            })

            ->editColumn('nameAr', function ($style) {
                return  stripslashes($style->categoryNameAr);
            })

            ->editColumn('createdAt', function ($style) {
                return  date('d/m/Y', strtotime($style->createdAt));
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
            $page = $this->MOffers->getOfferCategory($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->categoryName,
                'title' => $page->categoryName,
                'page' => $page,
                'side_menu' => array('DB Management', 'Offer Categories'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Offers Category',
                'title' => 'New Offers Category',
                'side_menu' => array('DB Management', 'Offer Categories'),
            );
        }
        return view('admin.forms.Offercategories', $data);
    }

    public function save()
    {
        if (Input::get('categoryID')) {
            $id = Input::get('categoryID');
            $this->MOffers->updateCategory();
            $obj = $this->MOffers->getOfferCategory($id);
            $this->MAdmins->addActivity('Offer Category updated Succesfully ' . $obj->categoryName);

            return returnMsg('success', 'adminofferscategoires', "Offer Category updated Succesfully.");
        } else {
            $id = $this->MOffers->addCategory();
            $obj = $this->MOffers->getOfferCategory($id);
            $this->MAdmins->addActivity('Offer Category added Succesfully ' . $obj->categoryName);

            return returnMsg('success', 'adminofferscategoires', "Offer Category added Succesfully.");
        }

        return returnMsg('error', 'adminofferscategoires', "Something went wrong, Please try again.");
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MOffers->getOfferCategory($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('offer_category')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Offer Category Status changed successfully.' . $page->categoryName);

            return returnMsg('success', 'adminofferscategoires', "Offer Category Status changed successfully.");
        }

        return returnMsg('error', 'adminofferscategoires', "Something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MOffers->getOfferCategory($id);
        if (count($page) > 0) {
            $this->MOffers->deleteOfferCategory($id);
            $this->MAdmins->addActivity('Offer Category deleted successfully.' . $page->categoryName);

            return returnMsg('success', 'adminofferscategoires', "Offer Category deleted successfully.");
        }

        return returnMsg('error', 'adminofferscategoires', "Something went wrong, Please try again.");
    }
}
