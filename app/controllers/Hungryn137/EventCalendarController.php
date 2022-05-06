<?php

class EventCalendarController extends AdminController {

    protected $MAdmins;
    protected $MGeneral;
    protected $MEventCalendar;
    protected $MCuisine;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MEventCalendar = new EventCalendar();
        $this->MCuisine = new MCuisine();
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

        $MEventCalendar = EventCalendar::orderBy('createdAt', 'DESC');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MEventCalendar = EventCalendar::where('name', 'LIKE', stripslashes($_GET['name']) . '%');
        }
        $MEventCalendar->where('country', '=', $country);
        $lists = $MEventCalendar->paginate(15);
        $emailListingReceivers = $this->MGeneral->getEmailListingReceivers();
        $cuisines = $this->MCuisine->getAllCuisines(0, 1);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Event Date', 'Receivers', 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All The Calendar Events',
            'title' => 'Calendar Events',
            'action' => 'admineventcalendar',
            'cuisines' => $cuisines,
            'emailListingReceivers' => $emailListingReceivers,
            'lists' => $lists,
            'side_menu' => array('Emailing List','Event Calendar'),
        );

        return view('admin.partials.eventcalendar', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $cuisines = $this->MCuisine->getAllCuisines(0, 1);
        $emailListingReceivers = $this->MGeneral->getEmailListingReceivers();
        if ($id != 0) {
            $page = $this->MEventCalendar->getCalendarEvent($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'cuisines' => $cuisines,
                'emailListingReceivers' => $emailListingReceivers,
                'css' => 'admin/jquery-ui',
                'js' => 'admin/jquery-ui',
                'side_menu' => array('Emailing List','Event Calendar'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'cuisines' => $cuisines,
                'emailListingReceivers' => $emailListingReceivers,
                'pagetitle' => 'New Calendar Event',
                'title' => 'New Calendar Event',
                'css' => 'admin/jquery-ui',
                'js' => 'admin/jquery-ui',
                'side_menu' => array('Emailing List','Event Calendar'),
            );
        }
        return view('admin.forms.eventcalendar', $data);
    }

    public function save() {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MEventCalendar->updateCalendarEvent();
            $obj = $this->MEventCalendar->getCalendarEvent($id);
            $this->MAdmins->addActivity('Calendar Event updated Succesfully - ' . $obj->name);
            return Redirect::route('admineventcalendar')->with('message', "Calendar Event updated Succesfully.");
        } else {
            $id = $this->MEventCalendar->addCalendarEvent();
            $obj = $this->MEventCalendar->getCalendarEvent($id);
            $this->MAdmins->addActivity('Calendar Event Added Succesfully - ' . $obj->name);
            return Redirect::route('admineventcalendar')->with('message', "Calendar Event Added Succesfully.");
        }
        return Redirect::route('admineventcalendar')->with('error', "something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MEventCalendar->getCalendarEvent($id);
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

            DB::table('event')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Calendar Event Status changed successfully.' . $page->name);
            return Redirect::route('admineventcalendar')->with('message', "Calendar Event Status changed successfully.");
        }
        return Redirect::route('admineventcalendar')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MEventCalendar->getCalendarEvent($id);
        if (count($page) > 0) {
            DB::table('event')->where('id', $id)->delete();
            $this->MAdmins->addActivity('Calendar Event Deleted successfully.' . $page->name);
            return Redirect::route('admineventcalendar')->with('message', "Calendar Event Deleted successfully.");
        }
        return Redirect::route('admineventcalendar')->with('error', "something went wrong, Please try again.");
    }

    public function view($id = 0) {
        if (!empty($id)) {
            $event = $this->MEventCalendar->getCalendarEvent($id);
            if (count($event) > 0) {
                if ($event->recipients == 0) {
                    //MAIL
                    $countryID = Session::get('admincountry');
                    if (empty($countryID)) {
                        $countryID = 1;
                    }
                    $data = array();
                    if (Session::get('admincountryName') != "") {
                        $settings = Config::get('settings.' . Session::get('admincountryName'));
                    } else {
                        $settings = Config::get('settings.default');
                    }
                    $data['country'] = $country = MGeneral::getCountry($countryID);
                    $data['settings'] = $settings;
                    $data['logo'] = MGeneral::getSufratiLogo($countryID);
                    $sufratiUser = $settings['teamEmails'];
                    $data['sitename'] = $settings['name'];
                    $subject = 'Test Event Email ' . stripslashes($event->name) . ' has been approved.';
                    $data['title'] = $subject;
                    $data['event'] = $event;
                    if(isset($_GET['pass']) && $_GET['pass'] == 'yoman'){
                    Mail::queue('emails.newsletter.event', $data, function($message) use ($subject, $sufratiUser) {
                        $message->to("ha@azooma.co", 'Sufrati.com')->subject($subject);
                        #$message->to($sufratiUser, 'Sufrati.com')->subject($subject);
                    });
                    return Redirect::route('admineventcalendar')->with('message', stripslashes($event->name) . ' Test Email Sent successfully');
                    }else{
                        return View::make('emails.newsletter.event',$data);
                    }
                } else {
                    return Redirect::route('admineventcalendar')->with('error', "something went wrong, Please try again.");
                }
            }
        }
    }

}
