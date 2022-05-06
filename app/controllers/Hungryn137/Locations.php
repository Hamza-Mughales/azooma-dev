<?php

class Locations extends AdminController {

    protected $MAdmins;
    protected $MOffers;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MOffers = new MOffers();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $limit = 5000;
        $city = 0;
        $status = 0;
        $name = "";
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }

        $lists = $this->MOffers->getAllOfferCategories($city, $status, $limit, $name);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Last updated At', 'Actions'),
            'pagetitle' => 'All Offers Categories',
            'title' => 'Offers Categories',
            'action' => 'adminofferscategoires',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Locations','Locations List'),
        );

        return view('admin.partials.Offercategories', $data);
    }

    public function form($id = 0) {
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
                'side_menu' => array('Locations','Locations List'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Offers Category',
                'title' => 'New Offers Category',
                'side_menu' => array('Locations','Locations List'),
            );
        }
        return view('admin.forms.Offercategories', $data);
    }

    public function save() {
        if (Input::get('categoryID')) {
            $id = Input::get('categoryID');
            $this->MOffers->updateCategory();
            $obj = $this->MOffers->getOfferCategory($id);
            $this->MAdmins->addActivity('Offer Category updated Succesfully ' . $obj->categoryName);
            
            return returnMsg('success','adminlocations','Offer Category updated Succesfully.');
        } else {
            $id = $this->MOffers->addCategory();
            $obj = $this->MOffers->getOfferCategory($id);
            $this->MAdmins->addActivity('Offer Category added Succesfully ' . $obj->categoryName);
            
            return returnMsg('success','adminlocations','Offer Category added Succesfully.');
        }
        
        return returnMsg('error','adminlocations','Something went wrong, Please try again.');
    }

    public function status($id = 0) {
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
            
            return returnMsg('success','adminlocations','Offer Category Status changed successfully.');
        }
        
        return returnMsg('error','adminlocations','Something went wrong, Please try again.');
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MOffers->getOfferCategory($id);
        if (count($page) > 0) {
            $this->MOffers->deleteOfferCategory($id);
            $this->MAdmins->addActivity('Offer Category deleted successfully.' . $page->categoryName);
            
            return returnMsg('success','adminlocations','Offer Category deleted successfully.');
        }
        
        return returnMsg('error','adminlocations','Something went wrong, Please try again.');
    }

}
