<?php

class MenuRequest extends AdminController
{

    protected $Art_Work;
    protected $MGeneral;

    public function __construct()
    {
        parent::__construct();
        $this->Art_Work = new ArtWork();
        $this->MGeneral = new MGeneral();
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
        $new = 0;
        $limit = 20;
        $status = 0;
        $rest_ID = 0;
        $user_ID = 0;
        $name = "";
        $sort = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['rest_ID']) && !empty($_GET['rest_ID'])) {
            $rest_ID = stripslashes($_GET['rest_ID']);
        }
        if (isset($_GET['user_ID']) && !empty($_GET['user_ID'])) {
            $user_ID = stripslashes($_GET['user_ID']);
        }
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['new']) && !empty($_GET['new'])) {
            $new = stripslashes($_GET['new']);
        }

        $lists = MComments::getAllMenuRequests($country, $new, $limit, $rest_ID, $sort, $name);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant Name', 'Total Request', 'City', 'Request Date', 'Actions'),
            'resultheads' => array('rest_Name', 'total', 'city', 'createdAt/createdAt'),
            'actions' => array('view'),
            'pagetitle' => 'List of All Menu Request',
            'title' => 'All Menu Request',
            'action' => 'adminmenurequest',
            'viewlink' => 'adminmenurequest/view',
            'viewID' => 'rest_ID',
            'new' => FALSE,
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Miscellaneous', 'All Menu Request'),
        );
        return view('admin.partials.maincommonpage', $data);
    }

    public function view($id = 0)
    {
        if ($id != 0) {
            $rest_ID = 0;
            if (isset($_GET['rest_ID']) && !empty($_GET['rest_ID'])) {
                $rest_ID = stripslashes($_GET['rest_ID']);
            }
            if (empty($rest_ID)) {
                app::abort('404');
            }
            MComments::readMenuRequest($id);
            if (Session::get('admincountryName') != "") {
                $settings = Config::get('settings.' . Session::get('admincountryName'));
            } else {
                $settings = Config::get('settings.default');
            }
            $rest = MRestActions::getRest($rest_ID);
            $page = MComments::getMenuRequest($id, $rest_ID);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => "View Menu Request From " .  stripslashes($rest->rest_Name),
                'title' => "Menu Request From " .  stripslashes($rest->rest_Name),
                'lists' => $page,
                'rest' => $rest,
            );
            return View::make('admin.index', $data)->nest('content', 'admin.forms.viewmenurequest', $data);
        }
    }

    public function read($id = 0)
    {
        MComments::readArticleComment($id);
    }
}
