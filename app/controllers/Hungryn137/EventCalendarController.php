<?php

use Yajra\DataTables\Facades\DataTables;

class EventCalendarController extends AdminController
{

    protected $MAdmins;
    protected $MGeneral;
    protected $MEventCalendar;
    protected $MCuisine;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MEventCalendar = new EventCalendar();
        $this->MCuisine = new MCuisine();
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
            'headings' => array('Title', 'Event Date', 'Receivers', "Status", 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All The Calendar Events',
            'title' => 'Calendar Events',
            'action' => 'admineventcalendar',
            'cuisines' => $cuisines,
            'emailListingReceivers' => $emailListingReceivers,
            'lists' => $lists,
            'side_menu' => array('Emailing List', 'Event Calendar'),
        );

        return view('admin.partials.eventcalendar', $data);
    }
    public function getEventsData()
    {
        $query = DB::table('event')
            ->select(['event.*']);
        if (!in_array(0, adminCountry())) {
            $query->whereIn("event.country",  adminCountry());
        }

        return  DataTables::of($query)
            ->addColumn('action', function ($row) {
                $btns = '';
                if ($row->recipients == 0) {
                    $btns = '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admineventcalendar/view/', $row->id) . '?pass=yoman' . '" title="Send As Test"><i class="fa fa-info"></i></a>';
                    $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admineventcalendar/view/', $row->id)  . '" title="View"><i class="fa fa-eye"></i></a>';
                }
                $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admineventcalendar/form/', $row->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';


                if ($row->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('admineventcalendar/status/', $row->id) . '" title="Activate "><i class="fa fa-check"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="' . route('admineventcalendar/status/', $row->id) . '" title="Deactivate"><i class="fa fa-ban"></i></a>';
                }
                $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-button" href="#" link="' . route('admineventcalendar/delete/', $row->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';

                return $btns;
            })


            ->addColumn('recipients', function ($row) {
                $emailListingReceivers = array(
                    '0' => 'Test Email',
                    '1' => 'All Users',
                    '2' => 'All Paid Restaurants Members',
                    '3' => 'All Restaurants Members',
                    '4' => 'All Restaurants',
                    '5' => 'All Non Restaurants Members',
                    '6' => 'All Hotels',
                    '7' => 'All Subscribers'
                );
                $index =  $row->recipients;
                $html = isset($emailListingReceivers[$index]) ? $emailListingReceivers[$index] : "";
                //$html.= '<br> Total: <span class="label label-info p-1">' . $row->total_receiver . '</span>';
                return $html;
            })


            ->addColumn('status_html', function ($row) {
                return  $row->status == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
            })

            ->editColumn('updatedAt', function ($row) {
                if ($row->updatedAt == "" || $row->updatedAt == "0000-00-00 00:00:00") {
                    return date('d/m/Y', strtotime($row->createdAt));
                } else {
                    return date('d/m/Y', strtotime($row->updatedAt));
                }
            })
            ->editColumn('date', function ($row) {
                return date('d/m/Y', strtotime($row->date));
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
                'side_menu' => array('Emailing List', 'Event Calendar'),
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
                'side_menu' => array('Emailing List', 'Event Calendar'),
            );
        }
        return view('admin.forms.eventcalendar', $data);
    }

    public function save()
    {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MEventCalendar->updateCalendarEvent();
            $obj = $this->MEventCalendar->getCalendarEvent($id);
            $this->MAdmins->addActivity('Calendar Event updated Successfully - ' . $obj->name);
            return returnMsg('success', 'admineventcalendar', "Calendar Event updated Successfully.");
        } else {
            $id = $this->MEventCalendar->addCalendarEvent();
            $obj = $this->MEventCalendar->getCalendarEvent($id);
            $this->MAdmins->addActivity('Calendar Event Added Successfully - ' . $obj->name);
            return returnMsg('success', 'admineventcalendar', "Calendar Event Added Successfully.");
        }
        return returnMsg('error', 'admineventcalendar', "something went wrong, Please try again.");
    }

    public function status($id = 0)
    {
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
            return returnMsg('success', 'admineventcalendar', "Calendar Event Status changed successfully.");
        }
        return returnMsg('error', 'admineventcalendar', "something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MEventCalendar->getCalendarEvent($id);
        if (count($page) > 0) {
            DB::table('event')->where('id', $id)->delete();
            $this->MAdmins->addActivity('Calendar Event Deleted successfully.' . $page->name);
            return returnMsg('success', 'admineventcalendar', "Calendar Event Deleted successfully.");
        }
        return returnMsg('error', 'admineventcalendar', "something went wrong, Please try again.");
    }

    public function view($id = 0)
    {
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
                    if (isset($_GET['pass']) && $_GET['pass'] == 'yoman') {
                        Mail::queue('emails.newsletter.event', $data, function ($message) use ($subject, $sufratiUser) {
                            $message->to("ha@azooma.co", 'Azooma.co')->subject($subject);
                        });
                        return returnMsg('success', 'admineventcalendar', stripslashes($event->name) . ' Test Email Sent successfully');
                    } else {
                        return view('emails.newsletter.event', $data);
                    }
                } else {
                    return returnMsg('error', 'admineventcalendar', "something went wrong, Please try again.");
                }
            }
        }
    }
}
