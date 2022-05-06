<?php

class NewsletterController extends AdminController {

    protected $MAdmins;
    protected $MGeneral;
    protected $MNewsLetter;
    protected $MCuisine;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MNewsLetter = new NewsLetter();
        $this->MCuisine = new MCuisine();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $MNewsLetter = NewsLetter::orderBy('createdAt', 'DESC');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MNewsLetter = NewsLetter::where('name', 'LIKE', stripslashes($_GET['name']) . '%');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $MNewsLetter->where('country', '=', $country);
        $lists = $MNewsLetter->paginate(15);
        $emailListingReceivers = $this->MGeneral->getEmailListingReceivers();
        $cuisines = $this->MCuisine->getAllCuisines(0, 1);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Description', 'Total Receivers', 'Result', 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All The Newsletters',
            'title' => 'Newsletters',
            'action' => 'adminnewsletter',
            'cuisines' => $cuisines,
            'emailListingReceivers' => $emailListingReceivers,
            'lists' => $lists,
            'side_menu' => array('Emailing List','News Letter'),
        );

        return view('admin.partials.newsletter', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $cities = $this->MGeneral->getAllCities($country);
        $emailListingReceivers = $this->MGeneral->getEmailListingReceivers();
        $cuisines = $this->MCuisine->getAllCuisines(0, 1);

        if ($id != 0) {
            $page = $this->MNewsLetter->getNewsLetter($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'cities' => $cities,
                'cuisines' => $cuisines,
                'emailListingReceivers' => $emailListingReceivers,
                'css' => 'datepicker,chosen',
                'js' => 'datepicker,chosen.jquery',
                'side_menu' => array('Emailing List','News Letter'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'cuisines' => $cuisines,
                'cities' => $cities,
                'emailListingReceivers' => $emailListingReceivers,
                'pagetitle' => 'New Newsletter',
                'title' => 'New Newsletter',
                'css' => 'admin/datepicker,chosen',
                'js' => 'admin/datepicker,chosen.jquery',
                'side_menu' => array('Emailing List','News Letter'),
            );
        }
        return view('admin.forms.newsletter', $data);
    }

    public function save() {
        $filename = "";
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $temp_name = $_FILES['image']['tmp_name'];
            $filename = $file->getClientOriginalName();
            $filename = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            $thumbLayer = clone $largeLayer;
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/newsletter", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/newsletter/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(640, null);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/newsletter/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/newsletter/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(100, 100);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/newsletter/thumb/", $save_name, true, null, 95);

        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MNewsLetter->updateNewsLetter($filename);
            $obj = $this->MNewsLetter->getNewsLetter($id);
            $this->MAdmins->addActivity('Newsletter updated Succesfully - ' . $obj->name);
            return Redirect::route('adminnewsletter')->with('message', "Newsletter updated Succesfully.");
        } else {
            $id = $this->MNewsLetter->addNewsLetter($filename);
            // dd($id);
            $obj = $this->MNewsLetter->getNewsLetter($id);
            $this->MAdmins->addActivity('Newsletter Added Succesfully - ' . $obj->name);
            return Redirect::route('adminnewsletter')->with('message', "Newsletter Added Succesfully.");
        }
        return Redirect::route('adminnewsletter')->with('error', "something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MNewsLetter->getNewsLetter($id);
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

            DB::table('newsletter')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Newsletter Status changed successfully.' . $page->name);
            return Redirect::route('adminnewsletter')->with('message', "Newsletter Status changed successfully.");
        }
        return Redirect::route('adminnewsletter')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MNewsLetter->getNewsLetter($id);
        if (count($page) > 0) {
            DB::table('newsletter')->where('id', $id)->delete();
            $this->MAdmins->addActivity('Newsletter Deleted successfully.' . $page->name);
            return Redirect::route('adminnewsletter')->with('message', "Newsletter Deleted successfully.");
        }
        return Redirect::route('adminnewsletter')->with('error', "something went wrong, Please try again.");
    }

    public function getAjaxCount() {
        $type = "";
        $city = "";
        if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
            $type = $_REQUEST['type'];
        }

        $total = NewsLetter::getReceivers($type);
        $data['total'] = $total;
        return Response::json($data);
    }

}
