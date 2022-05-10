<?php

use Yajra\DataTables\Facades\DataTables;

class Members extends AdminController
{

    protected $MAdmins;
    protected $MGeneral;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
        $this->MClients = new MClients();
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
     
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Reference No', 'Membership', 'Joined On',"status", 'Last Update', 'Expiry Date', 'Actions'),
            'pagetitle' => 'List of All Sufrati Members',
            'title' => 'All Sufrati Members',
            'action' => 'adminmembers',
            "is_paid"=>0,
            'country' => $country,
            'side_menu' => array('Subscriptions', 'All Members'),
        );

        return view('admin.partials.members', $data);
    }
    public function getmembersData()
    {
        $query = DB::table('restaurant_info')
        ->select(["restaurant_info.*","booking_management.referenceNo","booking_management.status","subscriptiontypes.accountName"]);
        $query->join('booking_management', 'booking_management.rest_id', '=', 'restaurant_info.rest_ID')
        ->LeftJoin("subscriptiontypes","restaurant_info.rest_Subscription","=","subscriptiontypes.id");

        if (get('city')) {
            $query->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            $query->where('rest_branches.city_ID', '=', get('city'));
        }
        if (get('rest_viewed') != 0) {
            $query->where('restaurant_info.rest_Viewed > ', get('rest_viewed'));
        }
        if (get('cuisine')) {
            $query->join('restaurant_cuisine', 'restaurant_cuisine.rest_ID', '=', 'restaurant_info.rest_ID');
            $query->where('restaurant_cuisine.cuisine_ID', '=', get('cuisine'));
        }
        if (get('best')) {
            $query->join('restaurant_bestfor', 'restaurant_bestfor.rest_ID', '=', 'restaurant_info.rest_ID');
            $query->where('restaurant_bestfor.bestfor_ID', '=', get('best'));
        }

        if (!in_array(0, adminCountry())) {
            $query->whereIn("restaurant_info.country",  adminCountry());
        }

        if (get('membership')) {
            $query->where('restaurant_info.rest_Subscription', '=', get('membership'));
        }
        if (get('is_paid') == 1) {
            $query->where('restaurant_info.rest_Subscription', '>', 0);
        } else {
            $query->where('restaurant_info.rest_Subscription', '>', -1);
        }

        $query->where('restaurant_info.rest_Status', '>', 0);
        $query->where('booking_management.status', '>', 0);
        return  DataTables::of($query)
            ->addColumn('action', function ($row) {
                $btns = '';
                    $btns = '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminmembers/contacts/',$row->rest_ID) .  '" title="Update Membership Contacts"><i class="fa fa-info"></i></a>';
                
                $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminmembers/details/',$row->rest_ID). '" title="Update Membership Details"><i class="fa fa-edit"></i></a>';


                if ($row->rest_Status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminmembers/status/',$row->rest_ID) . '" title="Activate "><i class="fa fa-check"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="' . route('adminmembers/status/',$row->rest_ID) . '" title="Deactivate"><i class="fa fa-ban"></i></a>';
                }
                $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-button" href="#" link="' . route('adminmembers/delete/',$row->rest_ID) . '" title="Delete"><i class="fa fa-trash"></i></a>';

                return $btns;
            })


            ->editColumn('rest_Name', function ($row) {
                return stripslashes($row->rest_Name) . ' ' . stripslashes($row->rest_Name_Ar);
            })

            ->editColumn('member_duration', function ($row) {
                if ($row->rest_Subscription == 0) {
                    return 'Unlimited - Free Account';
                } else {
                    $duration = $row->member_duration;
                    return date('d/m/Y', strtotime(date("Y-m-d", strtotime($row->member_date)) . " +$duration month"));
                }
            })
            ->addColumn('status_html', function ($row) {
                return  $row->status == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
            })

            ->editColumn('lastUpdatedOn', function ($row) {
                if ($row->lastUpdatedOn == "" || $row->lastUpdatedOn == "0000-00-00 00:00:00") {
                    return date('d/m/Y', strtotime($row->rest_RegisDate));
                } else {
                    return date('d/m/Y', strtotime($row->lastUpdatedOn));
                }
            })
            ->editColumn('member_date', function ($row) {
                return date('d/m/Y', strtotime($row->member_date));
            })
            ->editColumn('rest_Subscription', function ($row) {
                $html = '<span class="label';
                if ($row->rest_Subscription == 0) {
                    $html .= ' label-danger p-1">Not a Member';
                } else {
                    switch ($row->rest_Subscription) {
                        case 0:
                            $html .=  ' label-default p-1">Free member';
                            break;
                        case 1;
                            $html .=  ' label-success p-1">Bronze member';
                            break;
                        case 2:
                            $html .=  ' label-info p-1">Silver member';
                            break;
                        case 3:
                            $html .=  ' label-warning p-1">Gold Member';
                            break;  
                            default:
                            $html .=  ' label-success p-1">'.$row->accountName;                   
                            
                    }

                }
                $html .=  "</span>";
                return $html;
            })
            ->make(true);
    }
    public function paid()
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


        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Reference No', 'Membership', 'Joined On', "Status",'Last Update', 'Expiry Date', 'Actions'),
            'pagetitle' => 'List of All Sufrati Paid Members',
            'title' => 'All Sufrati Paid Members',
            'action' => 'adminpaidmembers',
            "is_paid"=>1,
            'country' => $country,
            'side_menu' => array('Subscriptions', 'Paid Members'),
        );

        return view('admin.partials.members', $data);
    }

    public function contacts($rest = 0)
    {
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
                'side_menu' => array('Subscriptions', 'All Members'),
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
                        $date['side_menu'] = array('Subscriptions', 'All Members');
                        $subject = "Contact information Updated Successfully at Sufrati";
                        try{
                        Mail::queue('emails.restaurant.memberaccountupdate', $data, function ($message) use ($subject, $userEmails, $sufratiUser) {
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
                    }
                    catch(Exception $e ){
                        return returnMsg('error','adminrestaurants',$e->getMessage());
            
                    }
                        return returnMsg('success','adminmembers/contacts/', stripslashes(($restData->rest_Name)) . ' Member Account contact details updated',[$restData->rest_ID]);
                    }
                }
                #********************END
                return returnMsg('success','adminmembers/contacts/', stripslashes(($restData->rest_Name)) . ' Member Account contact details updated',[$restData->rest_ID]);
            } else {
                return returnMsg('error','adminrestaurants',"something went wrong, Please try again.");
            }
        }
    }

    public function getPermissions($permission = "", $type = "")
    {
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

    public function details($rest = 0)
    {
        $MemberDeatilsLog =[];
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
                'css' => 'admin/jquery-ui',
                'side_menu' => array('Subscriptions', 'All Members'),
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
                        if ( isset($MemberDeatilsLog->accountType) && $MemberDeatilsLog->accountType == $_POST['rest_Subscription']) {
                            $subject = "Account has been renewed successfully";
                        } elseif (isset($MemberDeatilsLog->accountType) && $MemberDeatilsLog->accountType > $_POST['rest_Subscription']) {
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
                    $data['side_menu'] = array('Subscriptions', 'All Members');
                    $sufratiUser = $settings['teamEmails'];
                    try{
                    Mail::queue('emails.restaurant.memberaccountupdatedetails', $data, function ($message) use ($subject, $userEmails, $sufratiUser) {
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
                }
                catch(Exception $e ){
                    return returnMsg('error','adminmembers',$e->getMessage());
        
                }
                    return returnMsg('success','adminmembers', stripslashes($rest->rest_Name) . ' Membership details updated');
                }
                return returnMsg('error','adminrestaurants',"Opss!!! Looks like this restaurant has no emails, Please try again.");
            } else {
                return returnMsg('error','adminrestaurants',"something went wrong, Please try again.");
            }
        }
    }

    public function status($id)
    {
        $member = $account = $this->MRestActions->getAccountDetails($id);
        $rest = $this->MRestActions->getRest($id);
       // ##****** Email Function Common***##
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
            //##CHECK STATUS IF ACTIVE THAN DEACTIVATE AND VICE VERSA
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
            try{
            Mail::queue('emails.restaurant.' . $filename, $data, function ($message) use ($subject, $userEmails, $sufratiUser) {
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
        }
        catch(Exception $e ){
            return returnMsg('error','adminmembers',$e->getMessage());
        }
            return returnMsg('success','adminmembers', $flashmessage);
        }
        return returnMsg('error','adminmembers', "something went wrong, Please try again.");

    }

    public function delete($id = 0)
    {
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
            try{
            Mail::queue('emails.restaurant.memberaccountterminated', $data, function ($message) use ($subject, $userEmails, $sufratiUser) {
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
        }
            catch(Exception $e ){
                return returnMsg('error','adminmembers',$e->getMessage());
            }
            return returnMsg('success','adminmembers', $flashmessage);
        }
        return returnMsg('error','adminrestaurants', "Opss!!! Looks like this restaurant has no emails, Please try again.");
    }

    public function sendpassword($id = 0)
    {
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
            try{
            Mail::queue('emails.restaurant.resendpassword', $data, function ($message) use ($subject, $userEmails, $sufratiUser) {
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
        }
            catch(Exception $e ){
                return returnMsg('error','adminrestaurants',$e->getMessage());
            }
            return returnMsg('success','adminrestaurants/form/',$flashmessage,[$id]);
        }
        return returnMsg('error','adminrestaurants',"Opss!!! Looks like this restaurant has no emails, Please try again.");
    }
}
