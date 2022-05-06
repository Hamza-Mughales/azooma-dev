<?php

class Messages extends AdminController {

    protected $MAdmins;
    protected $MWelcomeMessage;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MWelcomeMessage = new WelcomeMessage();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $name = '';
        $limit = '15';
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $lists = $this->MWelcomeMessage->getAllMessage($country,$limit, $name, 0);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Country', 'Created At', 'Actions'),
            'pagetitle' => 'List of All Welcome Messages',
            'title' => 'Welcome Messages',
            'action' => 'adminmessages',
            'lists' => $lists
        );

        return View::make('admin.index', $data)->nest('content', 'admin.partials.messages', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = WelcomeMessage::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->text_en,
                'title' => $page->text_en,
                'page' => $page
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Welcome Message',
                'title' => 'New Welcome Message',
            );
        }
        return View::make('admin.index', $data)->nest('content', 'admin.forms.messages', $data);
    }

    public function save() {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MWelcomeMessage->updateMessage();
            $obj = WelcomeMessage::find($id);
            $this->MAdmins->addActivity('Welcome Message updated Succesfully ' . $obj->text_en);
            return Redirect::route('adminmessages')->with('message', "Welcome Message updated Succesfully.");
        } else {
            $id = $this->MWelcomeMessage->addMessage();
            $obj = WelcomeMessage::find($id);
            $this->MAdmins->addActivity('Welcome Message added Succesfully ' . $obj->text_en);
            return Redirect::route('adminmessages')->with('message', "Welcome Message added Succesfully.");
        }
        return Redirect::route('adminmessages')->with('error', "something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = WelcomeMessage::find($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );

            DB::table('welcome_message')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Welcome Message Status changed successfully.' . $page->text_en);
            return Redirect::route('adminmessages')->with('message', "Welcome Message Status changed successfully.");
        }
        return Redirect::route('adminmessages')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = WelcomeMessage::find($id);
        if (count($page) > 0) {
            WelcomeMessage::destroy($id);
            $this->MAdmins->addActivity('Welcome Message deleted successfully.' . $page->text_en);
            return Redirect::route('adminmessages')->with('message', "Welcome Message deleted successfully.");
        }
        return Redirect::route('adminmessages')->with('error', "something went wrong, Please try again.");
    }

}