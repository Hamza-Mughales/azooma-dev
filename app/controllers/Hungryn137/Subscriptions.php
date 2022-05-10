<?php

class Subscriptions extends AdminController {

    protected $MAdmins;
    protected $MGeneral;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
        $this->MClients = new MClients();
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
        $lists = $this->MClients->getAllSubscriptionTypes($country);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array("#",'Subscription Title', 'Country', 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All Subscriptions',
            'title' => 'All Subscriptions',
            'action' => 'adminsubscriptions',
            'lists' => $lists,
            'side_menu' => array('Subscriptions','Subscription Types'),
        );

        return view('admin.partials.subscriptions', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = $this->MClients->getSubscriptionType($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->accountName,
                'title' => $page->accountName,
                'page' => $page,
            'side_menu' => array('Subscriptions','Subscription Types'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Subscription',
                'title' => 'New Subscription',
            'side_menu' => array('Subscriptions','Subscription Types'),
            );
        }


        return view('admin.forms.subscription', $data);
    }

    public function save() {
        $permissions = "";
        if (isset($_POST['features']) && is_array($_POST['features'])) {
            $permissions = implode(',', Input::get('features'));
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'country' => $country,
            'accountName' => (Input::get('accountName')),
            'price' => (Input::get('price')),
            'sub_detail' => $permissions,
            'date_upd' => date('Y-m-d H:i:s')
        );

        if (Input::get('id')) {
            DB::table('subscriptiontypes')->where('id', Input::get('id'))->update($data);
        } else {
            DB::table('subscriptiontypes')->insert($data);
        }
        return returnMsg('success','adminsubscriptions', "Your data has been save successfully.");
    }

    public function delete($id = 0) {
        $page = $this->MClients->getSubscriptionType($id);
        if (count($page) > 0) {
            DB::table('subscriptiontypes')->where('id', '=', $id)->delete($id);
            return returnMsg('success','adminsubscriptions', "Your data has been save successfully.");
        }
        return returnMsg('error','adminsubscriptions',"something went wrong, Please try again.");
    }

    public function compare() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        if (Input::has('compare')) {
            $compare = Input::get('compare');
            if (is_array($compare) && count($compare) > 1) {
                $id1 = $compare[0];
                $id2 = $compare[1];
                $lists1 = $this->MClients->getSubscriptionType($id1);
                $lists2 = $this->MClients->getSubscriptionType($id2);
                $data = array(
                    'sitename' => $settings['name'],
                    'headings' => array('Subscription Title', 'Country', 'Last Update on', 'Actions'),
                    'pagetitle' => 'Comparsion between ' . $lists1->accountName . ' And ' . $lists2->accountName,
                    'title' => 'Comparsion between ' . $lists1->accountName . ' And ' . $lists2->accountName,
                    'action' => 'adminsubscriptions',
                    'lists1' => $lists1,
                    'lists2' => $lists2,
                    'side_menu' => array('Subscriptions','Subscription Types'),
                );
                return view('admin.partials.subscriptioncompare', $data);
            } else {
                return returnMsg('error','adminsubscriptions', "something went wrong, Please try again.");
            }
        } else {
            return returnMsg('error','adminsubscriptions',"something went wrong, Please try again.");
        }
    }

}
