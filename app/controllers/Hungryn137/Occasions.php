<?php

class Occasions extends AdminController {

    protected $MAdmins;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $sort = "latest";
        $name = "";
        $limit = 20;
        $status = 0;
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['name']) && ($_GET['name'] != "")) {
            $name = ($_GET['name']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $lists = MOccasions::getAllCateringEvents($country, $status, $limit, $sort, $name);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'User Name', 'Mobile', 'Date', 'Budget', 'Total Guests', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Occasions Services',
            'title' => 'All Occasions Services',
            'action' => 'admincompetitions',
            'lists' => $lists,
            'side_menu' => array('Competitions','Occasions Services'),
        );
        return view('admin.partials.occasions', $data);
    }

    public function view($id = 0) {
        if ($id != 0) {
            if (Session::get('admincountryName') != "") {
                $settings = Config::get('settings.' . Session::get('admincountryName'));
            } else {
                $settings = Config::get('settings.default');
            }
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            $page = MOccasions::getCateringEvent($id);
            $user = MOccasions::getUserInfo($page->user_ID);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'catering' => $page,
                'user' => $user,
                'side_menu' => array('Competitions','Occasions Services'),
            );
            return view('admin.forms.occasions', $data);
        } else {
            app::abort(404);
        }
    }

    public function forwardrest($id = 0) {
        if ($id != 0) {
            if (Session::get('admincountryName') != "") {
                $settings = Config::get('settings.' . Session::get('admincountryName'));
            } else {
                $settings = Config::get('settings.default');
            }
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            $page = MOccasions::getCateringEvent($id);
            $user = MOccasions::getUserInfo($page->user_ID);
            $restaurants = MRestActions::getAllRestaurants($country, "", 1);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'catering' => $page,
                'restaurants' => $restaurants,
                'user' => $user,
                'css' => 'chosen',
                'js' => 'chosen.jquery'
            );
            return View::make('admin.index', $data)->nest('content', 'admin.forms.occasionstorest', $data);
        } else {
            app::abort(404);
        }
    }

    public function sendtorest() {
        $data = array();
        $countryID = Session::get('admincountry');
        if (empty($countryID)) {
            $countryID = 1;
        }

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

        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 1) {
            $id = ($_REQUEST['id']);
            if (isset($_REQUEST['tagRest']) && isset($_REQUEST['notes'])) {
                MOccasions::updateCateringEventRequestRest($id);
            }
            $data['title'] = "CHECKING...";
            if (!empty($catering->cuisines)) {
                $data['preferred_cuisines'] = MOccasions::getCuisineNames($catering->cuisines);
            } else {
                $data['preferred_cuisines'] = "";
            }
            $data['event'] = $catering = MOccasions::getCateringEvent($id);
            $data['view'] = TRUE;
            $data['restname'] = 'Administrator';

            return View::make('emails.restaurant.cateringinfo', $data);
        } elseif (isset($_POST['id'])) {
            $restemails = "";
            $id = Input::get('id');
            MOccasions::updateCateringEventRequestRest($id);
            $rest_IDs = Input::get('tagRest');
            $data['notes'] = $notes = (Input::get('notes'));
            $data['event'] = $catering = MOccasions::getCateringEvent($id);

            //MAIL
            if (is_array($rest_IDs) && count($rest_IDs) > 0) {
                $subject = 'Quotation required for an Event of ' . stripslashes($catering->name);
                $data['title'] = $subject;
                $data['user'] = $user = MOccasions::getUserInfo($catering->user_ID);
                $data['event'] = $catering;
                if (!empty($catering->cuisines)) {
                    $data['preferred_cuisines'] = MOccasions::getCuisineNames($catering->cuisines);
                } else {
                    $data['preferred_cuisines'] = "";
                }
                foreach ($rest_IDs as $key => $value) {
                    $rest = MOccasions::getRestEmails($value);
                    $allemails = "";
                    if (!empty($rest->rest_Email)) {
                        $allemails = $rest->rest_Email;
                    }
                    if (!empty($rest->email)) {
                        if ($allemails == "") {
                            $allemails = $rest->email;
                        } else {
                            $allemails.="," . $rest->email;
                        }
                    }
                    if (!empty($rest->your_Email)) {
                        if ($allemails == "") {
                            $allemails = $rest->your_Email;
                        } else {
                            $allemails.="," . $rest->your_Email;
                        }
                    }

                    if (!empty($allemails)) {
                        $emailss = trim($allemails, ',');
                        $arr = explode(",", $emailss);
                        if (is_array($arr) && !empty($arr)) {
                            $data['restname'] = stripslashes($rest->your_Name);
                            $user_Email = "";
                            $user_Email = $arr;
                            Mail::queue('emails.restaurant.cateringinfo', $data, function($message) use ($subject, $user_Email, $sufratiUser) {
                                $message->to("ha@azooma.co", 'Sufrati.com')->subject($subject);
                                #$message->to($userEmails, 'Sufrati.com')->subject($subject);
                                #$message->bcc($sufratiUser, 'Sufrati.com')->subject($subject);
                            });
                        }
                    }
                }
            }
            $this->MAdmins->addActivity('Quotation sent to restaurant for event of ' . stripslashes($catering->name));
            return Redirect::route('adminoccasions')->with('message', "Email Sent successfully.");
        } else {
            return Redirect::route('adminoccasions')->with('error', "something went wrong, Please try again.");
        }
    }

    public function status($id = 0) {
        $status = 0;
        $page = MOccasions::getCateringEvent($id);
        $dispMsg = "";
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
                $dispMsg = "Occasion Event activated successfully";
            } else {
                $dispMsg = "Occasion Event deactivated successfully";
                $status = 0;
            }
            MOccasions::changeCateringEventStatus($id, $status);
            $this->MAdmins->addActivity($dispMsg);
            return Redirect::route('adminoccasions')->with('message', $dispMsg);
        }
        return Redirect::route('adminoccasions')->with('error', "something went wrong, Please try again.");
    }

    public function approved($id = 0) {
        $catering = $page = MOccasions::getCateringEvent($id);
        if (count($page) > 0) {
            $status = 3;
            MOccasions::changeCateringEventStatus($id, $status);
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
            $subject = 'Your Event ' . stripslashes($catering->name . ' has been approved.');
            $data['title'] = $subject;
            $data['user'] = $user = MOccasions::getUserInfo($catering->user_ID);
            $data['event'] = $catering;
            if (!empty($catering->cuisines)) {
                $data['preferred_cuisines'] = MOccasions::getCuisineNames($catering->cuisines);
            } else {
                $data['preferred_cuisines'] = "";
            }
            $username = "";
            $username = $user->user_FullName;
            $data['restname'] = $username;

            $user_Email = "";
            $user_Email = $user->user_Email;
            if ($user->user_Status == 1) {
                Mail::queue('emails.user.cateringapproved', $data, function($message) use ($subject, $user_Email, $sufratiUser) {
                    $message->to("ha@azooma.co", 'Sufrati.com')->subject($subject);
                    #$message->to($userEmails, 'Sufrati.com')->subject($subject);
                    #$message->bcc($sufratiUser, 'Sufrati.com')->subject($subject);
                });
            }
            $this->MAdmins->addActivity(stripslashes($page->name) . ' Approved successfully');
            return Redirect::route('adminoccasions')->with('message', stripslashes($page->name) . ' Approved successfully');
        }
        return Redirect::route('adminoccasions')->with('error', "something went wrong, Please try again.");
    }

    public function cancel($id = 0) {
        $catering = $page = MOccasions::getCateringEvent($id);
        if (count($page) > 0) {
            $status = 2;
            MOccasions::changeCateringEventStatus($id, $status);
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
            $subject = 'Your Event ' . stripslashes($catering->name . ' has been Cancelled.');
            $data['title'] = $subject;
            $data['user'] = $user = MOccasions::getUserInfo($catering->user_ID);
            $data['event'] = $catering;
            if (!empty($catering->cuisines)) {
                $data['preferred_cuisines'] = MOccasions::getCuisineNames($catering->cuisines);
            } else {
                $data['preferred_cuisines'] = "";
            }
            $username = "";
            $username = $user->user_FullName;
            $data['restname'] = $username;

            $user_Email = "";
            $user_Email = $user->user_Email;
            if ($user->user_Status == 1) {
                Mail::queue('emails.user.cateringcancelled', $data, function($message) use ($subject, $user_Email, $sufratiUser) {
                    $message->to("ha@azooma.co", 'Sufrati.com')->subject($subject);
                    #$message->to($userEmails, 'Sufrati.com')->subject($subject);
                    #$message->bcc($sufratiUser, 'Sufrati.com')->subject($subject);
                });
            }
            $this->MAdmins->addActivity(stripslashes($page->name) . ' cancelled successfully');
            return Redirect::route('adminoccasions')->with('message', stripslashes($page->name) . ' cancelled successfully');
        }
        return Redirect::route('adminoccasions')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = MOccasions::getCateringEvent($id);
        if (count($page) > 0) {
            MOccasions::deleteCateringEvent($id);
            $this->MAdmins->addActivity(stripslashes($page->name) . ' deleted successfully.');
            return Redirect::route('adminoccasions')->with('message', stripslashes($page->name) . ' deleted successfully.');
        }
        return Redirect::route('adminoccasions')->with('error', "something went wrong, Please try again.");
    }

    public function read($id = 0) {
        MOccasions::read($id);
    }

}
