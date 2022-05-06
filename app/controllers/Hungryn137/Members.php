<?php

class Members extends AdminController {

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
        $sort = "latest";
        $restname = "";
        $excel = false;
        $limit = 20;
        $offset = $rest_viewed = $price = 0;
        $to_excel = false;
        $city = $cuisine = $best = $status = $member = $restaurant = $district = "";
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['price']) && ($_GET['price'] != "")) {
            $price = ($_GET['price']);
        }
        if (isset($_GET['rest_viewed']) && ($_GET['rest_viewed'] != "")) {
            $rest_viewed = ($_GET['rest_viewed']);
        }
        if (isset($_GET['city']) && ($_GET['city'] != "")) {
            $city = ($_GET['city']);
        }
        if (isset($_GET['cuisine']) && ($_GET['cuisine'] != "")) {
            $cuisine = ($_GET['cuisine']);
        }
        if (isset($_GET['best']) && ($_GET['best'] != "")) {
            $best = ($_GET['best']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }
        if (isset($_GET['membership']) && ($_GET['membership'] != "")) {
            $member = ($_GET['membership']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['report']) && ($_GET['report'] != "")) {
            $to_excel = TRUE;
            $limit = "";
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        if (isset($_GET['restaurant']) && !empty($_GET['restaurant'])) {
            $restname = stripslashes($_GET['restaurant']);
        }
        $lists = $this->MClients->getAllClients($country, $city, $cuisine, $sort, $member, $limit, $restname, 0, $rest_viewed, $best);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Reference No', 'Membership', 'Joined On', 'Last Update', 'Expiry Date', 'Actions'),
            'pagetitle' => 'List of All Sufrati Members',
            'title' => 'All Sufrati Members',
            'action' => 'adminmembers',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Subscriptions','All Members'),
        );

        return view('admin.partials.members', $data);
    }

    public function paid() {
        $city = 0;
        $cuisine = 0;
        $sort = "latest";
        $member = 0;
        $ispaid = 1;
        $rest_viewed=0;
        $limit = 20;
        $restname = "";
        $excel = false;
        $city = $cuisine = $best = $status = $member = $restaurant = $district = "";
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['price']) && ($_GET['price'] != "")) {
            $price = ($_GET['price']);
        }
        if (isset($_GET['rest_viewed']) && ($_GET['rest_viewed'] != "")) {
            $rest_viewed = ($_GET['rest_viewed']);
        }
        if (isset($_GET['city']) && ($_GET['city'] != "")) {
            $city = ($_GET['city']);
        }
        if (isset($_GET['cuisine']) && ($_GET['cuisine'] != "")) {
            $cuisine = ($_GET['cuisine']);
        }
        if (isset($_GET['best']) && ($_GET['best'] != "")) {
            $best = ($_GET['best']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }
        if (isset($_GET['membership']) && ($_GET['membership'] != "")) {
            $member = ($_GET['membership']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['report']) && ($_GET['report'] != "")) {
            $to_excel = TRUE;
            $limit = "";
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        if (isset($_GET['restaurant']) && !empty($_GET['restaurant'])) {
            $restname = stripslashes($_GET['restaurant']);
        }

        $lists = $this->MClients->getAllClients($country, $city, $cuisine, $sort, $member, $limit, $restname, $ispaid, $rest_viewed, $best);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Reference No', 'Membership', 'Joined On', 'Last Update', 'Expiry Date', 'Actions'),
            'pagetitle' => 'List of All Sufrati Paid Members',
            'title' => 'All Sufrati Paid Members',
            'action' => 'adminpaidmembers',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Subscriptions','Paid Members'),
        );

        return view('admin.partials.members', $data);
    }

    public function contacts($rest = 0) {
        if ($rest != 0) {
            if (Session::get('admincountryName') != "") {
                $settings = Config::get('settings.' . Session::get('admincountryName'));
            } else {
                $settings = Config::get('settings.default');
            }
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            $restData = $this->MRestActions->getRest($rest);
            $member = $this->MRestActions->getAccountDetails($rest);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => stripslashes($restData->rest_Name) . " Admin Management contact Details",
                'title' => stripslashes($restData->rest_Name) . " Admin Management contact Details",
                'action' => 'adminmembers',
                'rest' => $restData,
                'member' => $member,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => array('Subscriptions','All Members'),
            );
            return view('admin.partials.membercontact', $data);
        } else {
            if (Input::has('rest_ID')) {
                $rest = Input::get('rest_ID');
                $countryID = Session::get('admincountry');
                if (empty($countryID)) {
                    $countryID = 1;
                }
                $country = MGeneral::getCountry($countryID);

                $restData = $this->MRestActions->getRest($rest);
                $member = $this->MRestActions->getAccountDetails($rest);
                $this->MClients->updateMemberContacts();
                $allrestEmails = $_POST['emails'];
                $this->MRestActions->updateRestInfoConactEmails(Input::get('rest_ID'), $allrestEmails);
                $this->MRestActions->addUpdateRestSubscriberEmail($allrestEmails, $_POST['full_name']);
                $this->MAdmins->addActivity('updated ' . stripslashes(($restData->rest_Name)) . ' Member account contact details');
                if (Input::has('status')) {
                    #####Email Function
                    $userEmails = "";
                    if (isset($_POST['emails'])) {
                        $userEmails = Input::get('emails');
                    }
                    if (is_array($userEmails)) {
                        $data = array();
                        if (Session::get('admincountryName') != "") {
                            $settings = Config::get('settings.' . Session::get('admincountryName'));
                        } else {
                            $settings = Config::get('settings.default');
                        }
                        $data['settings'] = $settings;
                        $sufratiUser = $settings['teamEmails'];
                        $data['country'] = $country;
                        $data['restname'] = stripslashes($restData->rest_Name);
                        $data['restnameAr'] = stripslashes($restData->rest_Name_Ar);
                        $data['restaurant'] = $restData;
                        $data['username'] = $member->user_name;
                        $data['password'] = $member->password;
                        $data['rest_Subscription'] = $restData->rest_Subscription;
                        $data['title'] = "Admin account";
                        $data['sitename'] = $settings['name'];
                        $date['side_menu'] = array('Subscriptions','All Members');
                        $subject = "Contact information Updated Successfully at Sufrati";
                        Mail::queue('emails.restaurant.memberaccountupdate', $data, function($message) use ($subject, $userEmails, $sufratiUser) {
                            $message->to($userEmails[0], 'Sufrati')->subject($subject);
                            $counter = 0;
                            $ccemail = array();
                            if (count($userEmails) > 1) {
                                foreach ($userEmails as $emaillist) {
                                    if ($counter == 0) {
                                        $counter++;
                                        continue;
                                    }
                                    $counter++;
                                    $ccemail[] = $emaillist;
                                }
                                $message->cc($ccemail, 'Sufrati')->subject($subject);
                            }
                            $message->bcc($sufratiUser, 'Sufrati')->subject($subject);
                        });
                        return Redirect::route('adminmembers/contacts/', $restData->rest_ID)->with('message', stripslashes(($restData->rest_Name)) . ' Member Account contact details updated');
                    }
                }
                #********************END
                return Redirect::route('adminmembers/contacts/', $restData->rest_ID)->with('message', stripslashes(($restData->rest_Name)) . ' Member Account contact details updated');
            } else {
                return Redirect::route('adminrestaurants')->with('error', "something went wrong, Please try again.");
            }
        }
    }

    public function getPermissions($permission = "", $type = "") {
        $data = array();
        if ($permission != "") {
            $data['permissions'] = explode(',', $permission);
        }
        $ajax = 0;
        if (isset($_GET['ajax']) && ($_GET['ajax'] != "")) {
            $ajax = ($_GET['ajax']);
        }
        if (isset($_GET['type']) && ($_GET['type'] != "")) {
            $type = ($_GET['type']);
        }
        if ($type != "") {
            $permissions = $this->MClients->getPermissionDetails($type);
            $data['permissions'] = explode(',', $permissions->sub_detail);
        }
        $html = View::make('admin.ajax.memberpermissions', $data)->render();
        if ($ajax != 0) {
            return Response::json(array('html' => $html, 'price' => $permissions->price));
        } else {
            return $html;
        }
    }

    public function details($rest = 0) {
        if ($rest != 0) {
            if (Session::get('admincountryName') != "") {
                $settings = Config::get('settings.' . Session::get('admincountryName'));
            } else {
                $settings = Config::get('settings.default');
            }
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            $restData = $this->MRestActions->getRest($rest);
            $member = $this->MRestActions->getAccountDetails($rest);
            $permission = $this->getPermissions($member->sub_detail);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => stripslashes($restData->rest_Name) . " Membership Details",
                'title' => stripslashes($restData->rest_Name) . " Membership Details",
                'MGeneral' => $this->MGeneral,
                'action' => 'adminmembers',
                'rest' => $restData,
                'member' => $member,
                'permission' => $permission,
                'js' => 'admin/jquery-ui,admin/member',
                'css'=>'admin/jquery-ui',
                'side_menu' => array('Subscriptions','All Members'),
            );
            return view('admin.partials.memberdetails', $data);
        } else {
            if (Input::get('rest_ID')) {
                $rest = $this->MRestActions->getRest(Input::get('rest_ID'));
                $member = $this->MRestActions->getAccountDetails($rest->rest_ID);
                $MemberDeatilsLog = $this->MGeneral->getMemberDeatilsLog($rest->rest_ID);
                $restname = str_replace(" ", "", $rest->rest_Name);
                $restname = str_replace("'", "", $rest->rest_Name);
                $restnameLength = strlen($restname);
                if ($restnameLength == 1) {
                    $ref = $restname . '00';
                } elseif ($restnameLength == 2) {
                    $ref = $restname . '0';
                } else {
                    $ref = substr($restname, 0, 3);
                }
                $reference = $ref . $member->id_user . date("d") . date("m") . date("y");
                $this->MClients->updateMemberDetails($reference);
                $this->MClients->expiry_notified($rest->rest_ID, 0);
                $this->MAdmins->addActivity('updated ' . stripslashes(($rest->rest_Name)) . ' Membership details');
                ###Account updation Email
                if (Session::get('admincountryName') != "") {
                    $settings = Config::get('settings.' . Session::get('admincountryName'));
                } else {
                    $settings = Config::get('settings.default');
                }
                $countryID = Session::get('admincountry');
                if (empty($countryID)) {
                    $countryID = 1;
                }
                $country = MGeneral::getCountry($countryID);
                $userEmails = "";
                if (isset($member->email)) {
                    $userEmails = $member->email;
                    $userEmails = explode(",", $userEmails);
                }
                if (is_array($userEmails)) {
                    $data = array();
                    switch ($_POST['rest_Subscription']) {
                        case 0:
                            $type = "Free";
                            $sevices = "<ul style='line-height:21px;font-size:14px;margin: 0px;'>
                                    <li>Business/Restaurant Profile Page</li>
                                    <li>All Branch Contact Information and Location Maps</li>
                                    <li>An attractive Photo Gallery with 3 photos</li>
                                    <li>A Sample Menu</li>
                                    </ul>";
                            break;
                        case 1:
                            $type = "Bronze";
                            $sevices = "<ul style='line-height:21px;font-size:14px;margin: 0px;'>
                                  <li>Business/Restaurant Profile Page</li>
                                  <li>All Branch Contact Information and Location Maps</li>
                                  <li>An attractive Photo Gallery with 6 photos</li>
                                  <li>Full Menu + PDF Menu Upload</li>
                                  </ul>";
                            break;
                        case 2:
                            $type = "Silver";
                            $sevices = "<ul style='line-height:21px;font-size:14px;margin: 0px;'>
                                  <li>Business/Restaurant Profile Page</li>
                                  <li>All Branch Contact Information and Location Maps</li>
                                  <li>An attractive Photo Gallery with 12 photos</li>
                                  <li>Full Menu + PDF Menu Upload</li>
                                  <li>One Special Offer Displayed</li>
                                  </ul>";
                            break;
                        case 3:
                            $type = "Gold";
                            $sevices = "<ul style='line-height:21px;font-size:14px;margin: 0px;'>
                                  <li>Business/Restaurant Profile Page</li>
                                  <li>All Branch Contact Information and Location Maps</li>
                                  <li>An attractive Photo Gallery with 20 photos</li>
                                  <li>Online Full Menu + PDF Menu Upload</li>
                                  <li>Respond To User Comments</li>
                                  <li>Monthly report</li>
                                  </ul>";
                            break;
                    }
                    if ($_POST['rest_Subscription'] == 0) {
                        $subject = "Account has been renewed successfully";
                    } else {
                        if (is_array($MemberDeatilsLog) && $MemberDeatilsLog->accountType == $_POST['rest_Subscription']) {
                            $subject = "Account has been renewed successfully";
                        } elseif ($MemberDeatilsLog->accountType > $_POST['rest_Subscription']) {
                            $subject = "Account has been downgraded successfully";
                        } else {
                            $subject = "Account has been upgraded successfully";
                        }
                    }

                    $subject = "Account has been updated successfully";
                    $data['settings'] = $settings;
                    $data['country'] = $country;
                    $data['title'] = "Admin account";
                    $data['sitename'] = $settings['name'];
                    $data['heading_title'] = $subject;
                    $data['restname'] = stripslashes($rest->rest_Name);
                    $data['manager_name'] = stripslashes($member->full_name);
                    $data['username'] = $member->user_name;
                    $data['password'] = $member->password;
                    $data['sevices'] = $sevices;
                    $data['rest_Subscription'] = $_POST['rest_Subscription'];
                    $data['type'] = $type;
                    $data['side_menu'] = array('Subscriptions','All Members');
                    $sufratiUser = $settings['teamEmails'];
                    Mail::queue('emails.restaurant.memberaccountupdatedetails', $data, function($message) use ($subject, $userEmails, $sufratiUser) {
                        $message->to($userEmails[0], 'Sufrati')->subject($subject);
                        $counter = 0;
                        $ccemail = array();
                        if (count($userEmails) > 1) {
                            foreach ($userEmails as $emaillist) {
                                if ($counter == 0) {
                                    $counter++;
                                    continue;
                                }
                                $counter++;
                                $ccemail[] = $emaillist;
                            }
                            $message->cc($ccemail, 'Sufrati')->subject($subject);
                        }
                        $message->bcc($sufratiUser, 'Sufrati')->subject($subject);
                    });
                    return Redirect::route('adminmembers')->with('message', stripslashes(($rest->rest_Name)) . ' Membership details updated');
                }
                return Redirect::route('adminrestaurants')->with('error', "Opss!!! Looks like this restaurant has no emails, Please try again.");
            } else {
                return Redirect::route('adminrestaurants')->with('error', "something went wrong, Please try again.");
            }
        }
    }

    public function status($id) {
        $member = $account = $this->MRestActions->getAccountDetails($id);
        $rest = $this->MRestActions->getRest($id);
        ##****** Email Function Common***##
        $data = array();
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $countryID = Session::get('admincountry');
        if (empty($countryID)) {
            $countryID = 1;
        }
        $country = MGeneral::getCountry($countryID);
        $userEmails = "";
        if (isset($member->email)) {
            $userEmails = $member->email;
            $userEmails = explode(",", $userEmails);
        }
        if (is_array($userEmails)) {
            $sufratiUser = $settings['teamEmails'];
            $data['settings'] = $settings;
            ##CHECK STATUS IF ACTIVE THAN DEACTIVATE AND VICE VERSA
            $data['sitename'] = $settings['name'];
            $data['country'] = $country;
            $data['title'] = "Admin account";
            $data['restname'] = stripslashes($rest->rest_Name);
            $data['user_name'] = stripslashes($rest->rest_Name);
            $data['manager_name'] = stripslashes($member->full_name);
            $data['username'] = $member->user_name;
            $data['password'] = $member->password;
            $subject = stripslashes($rest->rest_Name) . " admin account at Sufrati.com";
            if ($account->status == 1) {
                $this->MClients->deActivate($id);
                $filename = "memberaccountterminated";
                $flashmessage = stripslashes(($rest->rest_Name)) . ' Membership Deactivated Succesfully';
                $this->MAdmins->addActivity('Deactivated ' . stripslashes(($rest->rest_Name)) . ' membership');
            } else {
                $this->MClients->activate($id);
                $filename = "memberaccountreactive";
                $flashmessage = stripslashes(($rest->rest_Name)) . ' membership Activated succesfully';
                $this->MAdmins->addActivity('Activated ' . stripslashes(($rest->rest_Name)) . ' membership');
            }
            Mail::queue('emails.restaurant.' . $filename, $data, function($message) use ($subject, $userEmails, $sufratiUser) {
                $message->to("ha@azooma.co", 'Sufrati')->subject($subject);
                //$message->to($userEmails[0], 'Sufrati')->subject($subject);
                $counter = 0;
                $ccemail = array();
                if (count($userEmails) > 1) {
                    foreach ($userEmails as $emaillist) {
                        if ($counter == 0) {
                            $counter++;
                            continue;
                        }
                        $counter++;
                        $ccemail[] = $emaillist;
                    }
                    //$message->cc($ccemail, 'Sufrati')->subject($subject);
                }
                //$message->bcc($sufratiUser, 'Sufrati')->subject($subject);
            });
            return Redirect::route('adminmembers')->with('message', $flashmessage);
        }
        return Redirect::route('adminmembers')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $member = $account = $this->MRestActions->getAccountDetails($id);
        $rest = $this->MRestActions->getRest($id);
        $this->MClients->addMemberDeatilsLog($id);
        $this->MClients->deleteAccount($account->id_user, $id);
        // $this->MRestActions->updateRestSubscription($id);
        ##****** Email Function Common***##
        $data = array();
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $countryID = Session::get('admincountry');
        if (empty($countryID)) {
            $countryID = 1;
        }
        $country = MGeneral::getCountry($countryID);
        $userEmails = "";
        if (isset($member->email)) {
            $userEmails = $member->email;
            $userEmails = explode(",", $userEmails);
        }
        if (is_array($userEmails)) {
            $sufratiUser = $settings['teamEmails'];
            $data['settings'] = $settings;
            ##CHECK STATUS IF ACTIVE THAN DEACTIVATE AND VICE VERSA
            $data['sitename'] = $settings['name'];
            $data['country'] = $country;
            $data['title'] = "Admin account";
            $data['restname'] = stripslashes($rest->rest_Name);
            $data['user_name'] = stripslashes($rest->rest_Name);
            $data['manager_name'] = stripslashes($member->full_name);
            $data['username'] = $member->user_name;
            $data['password'] = $member->password;
            $subject = stripslashes($rest->rest_Name) . " admin account at Sufrati.com";
            $flashmessage = stripslashes(($rest->rest_Name)) . ' Membership removed succesfully';
            $this->MAdmins->addActivity('Deactivated ' . stripslashes(($rest->rest_Name)) . ' membership removed.');
            Mail::queue('emails.restaurant.memberaccountterminated', $data, function($message) use ($subject, $userEmails, $sufratiUser) {
                $message->to("ha@azooma.co", 'Sufrati')->subject($subject);
                //$message->to($userEmails[0], 'Sufrati')->subject($subject);
                $counter = 0;
                $ccemail = array();
                if (count($userEmails) > 1) {
                    foreach ($userEmails as $emaillist) {
                        if ($counter == 0) {
                            $counter++;
                            continue;
                        }
                        $counter++;
                        $ccemail[] = $emaillist;
                    }
                    //$message->cc($ccemail, 'Sufrati')->subject($subject);
                }
                //$message->bcc($sufratiUser, 'Sufrati')->subject($subject);
            });
            return Redirect::route('adminmembers')->with('message', $flashmessage);
        }
        return Redirect::route('adminrestaurants')->with('error', "Opss!!! Looks like this restaurant has no emails, Please try again.");
    }

    public function sendpassword($id = 0) {
        $member = $account = $this->MRestActions->getAccountDetails($id);
        $rest = $this->MRestActions->getRest($id);
        ##****** Email Function Common***##
        $data = array();
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $countryID = Session::get('admincountry');
        if (empty($countryID)) {
            $countryID = 1;
        }
        $country = MGeneral::getCountry($countryID);
        $userEmails = "";
        if (isset($member->email)) {
            $userEmails = $member->email;
            $userEmails = explode(",", $userEmails);
        }
        if (is_array($userEmails)) {
            $sufratiUser = $settings['teamEmails'];
            $data['settings'] = $settings;
            $data['sitename'] = $settings['name'];
            $data['country'] = $country;
            $data['title'] = "Admin account";
            $data['restname'] = stripslashes($rest->rest_Name);
            $data['user_name'] = stripslashes($rest->rest_Name);
            $data['manager_name'] = stripslashes($member->full_name);
            $data['username'] = $member->user_name;
            $data['password'] = $member->password;
            $subject = stripslashes($rest->rest_Name) . " admin account details at Sufrati.com";
            $flashmessage = stripslashes($rest->rest_Name) . " admin account details sent successfully";
            $this->MAdmins->addActivity(stripslashes($rest->rest_Name) . " admin account details sent successfully");
            Mail::queue('emails.restaurant.resendpassword', $data, function($message) use ($subject, $userEmails, $sufratiUser) {
                $message->to("ha@azooma.co", 'Sufrati')->subject($subject);
                //$message->to($userEmails[0], 'Sufrati')->subject($subject);
                $counter = 0;
                $ccemail = array();
                if (count($userEmails) > 1) {
                    foreach ($userEmails as $emaillist) {
                        if ($counter == 0) {
                            $counter++;
                            continue;
                        }
                        $counter++;
                        $ccemail[] = $emaillist;
                    }
                    //$message->cc($ccemail, 'Sufrati')->subject($subject);
                }
                //$message->bcc($sufratiUser, 'Sufrati')->subject($subject);
            });
            return Redirect::route('adminrestaurants/form/', $id)->with('message', $flashmessage);
        }
        return Redirect::route('adminrestaurants')->with('error', "Opss!!! Looks like this restaurant has no emails, Please try again.");
    }

}
