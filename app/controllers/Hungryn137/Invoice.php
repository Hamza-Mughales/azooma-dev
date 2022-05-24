<?php

use Yajra\DataTables\Facades\DataTables;

class Invoice extends AdminController
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
        $city = 0;
        $cuisine = 0;
        $sort = "latest";
        $member = 0;
        $ispaid = 1;
        $rest_viewed = 0;
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
        if (isset($_GET['restaurant']) && !empty($_GET['restaurant'])) {
            $restname = stripslashes($_GET['restaurant']);
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

        $lists = $this->MClients->getAllClients($country, $city, $cuisine, $sort, $member, $limit, $restname, 0, $rest_viewed, $best);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant Name', 'Reference No', 'Membership', 'Joined On', "Status", 'Last Update', 'Expiry Date', 'Actions'),
            'pagetitle' => 'List of All Azooma Members',
            'title' => 'All Azooma Members',
            'action' => 'admininvoice',
            'MRestActions' => $this->MRestActions,
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Billing', 'Manage Invoice'),
        );

        return view('admin.partials.invoice', $data);
    }
    public function getInvoiceData()
    {
        $query = DB::table('restaurant_info')
            ->select([
                "restaurant_info.*", "booking_management.referenceNo", "booking_management.status", "subscriptiontypes.accountName", DB::Raw('(select id  FROM invoice WHERE rest_ID=restaurant_info.rest_ID Limit 1 ) AS invoice_ar_id'), DB::Raw('(select is_draft  FROM invoice WHERE rest_ID=restaurant_info.rest_ID Limit 1 ) AS is_draft')
            ]);
        $query->join('booking_management', 'booking_management.rest_id', '=', 'restaurant_info.rest_ID')
            ->LeftJoin("subscriptiontypes", "restaurant_info.rest_Subscription", "=", "subscriptiontypes.id");

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
        if (get('status') or get('status') === '0') {
            $query->where('booking_management.status', '=', get('status'));
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
                if (isset($row->invoice_ar_id) &&  $row->invoice_ar_id > 0) {

                    if (isset($row->is_draft) &&  $row->is_draft == 1) {

                        $btns .= ' <a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admininvoice/invoiceform/', $row->rest_ID) . '?invoice=' . $row->invoice_ar_id . '" title="View & Generate Invoice"><i class="fa fa-list"></i></a>';
                    } else {
                        $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admininvoice/view/', $row->rest_ID) . '" title="View Invoice"><i class="fa  fa-search"></i></a>';
                    }
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admininvoice/generate/', $row->rest_ID) . '" title="Generate Invoice"><i class="fa fa-file-pdf-o"></i></a>
                    ';
                }

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
                            $html .=  ' label-success p-1">' . $row->accountName;
                    }
                }
                $html .=  "</span>";
                return $html;
            })
            ->make(true);
    }
    public function invoiceform($rest = 0)
    {
        $invoiceID = 0;
        if (isset($_GET['invoice']) && !empty($_GET['invoice'])) {
            $invoiceID = stripslashes($_GET['invoice']);
        }
        if ($rest != 0 && $invoiceID != 0) {
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
            $invoice = $this->MRestActions->getInvoiceDetails($rest, $invoiceID);

            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => stripslashes($restData->rest_Name) . " Invoice Details",
                'title' => stripslashes($restData->rest_Name) . " Invoice Details",
                'action' => 'admininvoice',
                'MRestActions' => $this->MRestActions,
                'rest' => $restData,
                'invoice' => $invoice,
                'member' => $member,
                'css' => 'chosen,jquery-ui,admin/datepicker',
                'js' => 'chosen.jquery,jquery-ui,admin/datepicker',
                'side_menu' => array('Billing', 'Manage Invoice'),
            );
            return view('admin.forms.invoice', $data);
        }
    }

    public function generate($rest = 0)
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
            if (count($member) > 0) {


                $data = array(
                    'sitename' => $settings['name'],
                    'pagetitle' => stripslashes($restData->rest_Name) . " Invoice Details",
                    'title' => stripslashes($restData->rest_Name) . " Invoice Details",
                    'action' => 'admininvoice',
                    'MRestActions' => $this->MRestActions,
                    'rest' => $restData,
                    'member' => $member,
                    'css' => 'chosen,admin/jquery-ui',
                    'js' => 'chosen.jquery,admin/jquery-ui',
                    'side_menu' => array('Billing', 'Manage Invoice'),
                );
                return view('admin.forms.invoice', $data);
            } else {
                return returnMsg('error', 'admininvoice', "Looks like Restaurant is not our member , Please try again.");
            }
        } else {
            if (Input::has('rest_ID')) {
                $t = array();
                $data = array();
                $restID = Input::get('rest_ID');
                $restData = $rest = $this->MRestActions->getRest($restID);
                $member = $this->MRestActions->getAccountDetails($restID);
                $countryID = Session::get('admincountry');
                if (empty($countryID)) {
                    $countryID = 1;
                }
                $country = MGeneral::getCountry($countryID);
                $reference_number = Input::get('reference_number');
                $invoice_date = Input::get('invoice_date');
                $subscription_price = $spot_light_video = $hi_light_video = $bottom_banner_home = $banner_design = 0;
                $top_banner = $bottom_banner = $home_page_slider = $horizon_banner = $bronze_box_banner = 0;
                $horizon_banner_second = $gold_box_banner = $sliver_box_banner = $sponsorship_banner = 0;
                $horizon_banner_third = $logo_box = 0;
                $options = "";
                if (isset($_POST['subscription_yes']) && !empty($_POST['subscription_yes'])) {
                    $subscription_price = Input::get('subscription_price');
                    $options['subscription'] = $subscription_price;
                }
                if (isset($_POST['spot_light_video']) && !empty($_POST['spot_light_video'])) {
                    $spot_light_video = Input::get('spot_light_video_value');
                    $options['Spot-Light-Video'] = $spot_light_video;
                }
                if (isset($_POST['hi_light_video']) && !empty($_POST['hi_light_video'])) {
                    $hi_light_video = Input::get('hi_light_video_value');
                    $options['Hi-Light-Video'] = $hi_light_video;
                }
                if (isset($_POST['banner_design']) && !empty($_POST['banner_design'])) {
                    $banner_design = Input::get('banner_design_value');
                    $options['Banner-Design'] = $banner_design;
                }

                if (isset($_POST['top_banner']) && !empty($_POST['top_banner'])) {
                    $top_banner = Input::get('top_banner_value');
                    $options['Top-Banner'] = $top_banner;
                }
                if (isset($_POST['bottom_banner']) && !empty($_POST['bottom_banner'])) {
                    $bottom_banner = Input::get('bottom_banner_value');
                    $options['Bottom-Banner'] = $bottom_banner;
                }
                if (isset($_POST['home_page_slider']) && !empty($_POST['home_page_slider'])) {
                    $home_page_slider = Input::get('home_page_slider_value');
                    $options['Home-Page-Slider'] = $home_page_slider;
                }
                if (isset($_POST['horizon_banner']) && !empty($_POST['horizon_banner'])) {
                    $horizon_banner = Input::get('horizon_banner_value');
                    $options['Horizon-Banner'] = $horizon_banner;
                }
                if (isset($_POST['bottom_banner_home']) && !empty($_POST['bottom_banner_home'])) {
                    $bottom_banner_home = Input::get('bottom_banner_home_value');
                    $options['Bottom-Bbanner-Home'] = $bottom_banner_home;
                }
                if (isset($_POST['horizon_banner_second']) && !empty($_POST['horizon_banner_second'])) {
                    $horizon_banner_second = Input::get('horizon_banner_second_value');
                    $options['Horizon-Banner-Second'] = $horizon_banner_second;
                }
                if (isset($_POST['gold_box_banner']) && !empty($_POST['gold_box_banner'])) {
                    $gold_box_banner = Input::get('gold_box_banner_value');
                    $options['Gold-Box-Banner'] = $gold_box_banner;
                }
                if (isset($_POST['sliver_box_banner']) && !empty($_POST['sliver_box_banner'])) {
                    $sliver_box_banner = Input::get('sliver_box_banner_value');
                    $options['Sliver-Box-Banner'] = $sliver_box_banner;
                }
                if (isset($_POST['bronze_box_banner']) && !empty($_POST['bronze_box_banner'])) {
                    $bronze_box_banner = Input::get('bronze_box_banner_value');
                    $options['Bronze-Box-Banner'] = $bronze_box_banner;
                }

                if (isset($_POST['sponsorship_banner']) && !empty($_POST['sponsorship_banner'])) {
                    $sponsorship_banner = Input::get('sponsorship_banner_value');
                    $options['Sponsorship-Banner'] = $sponsorship_banner;
                }
                if (isset($_POST['horizon_banner_third']) && !empty($_POST['horizon_banner_third'])) {
                    $horizon_banner_third = Input::get('horizon_banner_third_value');
                    $options['Horizon-Banner-Third'] = $horizon_banner_third;
                }
                if (isset($_POST['logo_box']) && !empty($_POST['logo_box'])) {
                    $logo_box = Input::get('logo_box_value');
                    $options['Logo-Box'] = $logo_box;
                }
                $creative_price = $advertings_price = 0;
                $creative_price = $spot_light_video + $hi_light_video + $banner_design;
                $advertings_price = $bottom_banner_home + $top_banner + $bottom_banner + $home_page_slider + $horizon_banner + $bronze_box_banner;
                $advertings_price += $horizon_banner_second + $gold_box_banner + $sliver_box_banner + $sponsorship_banner + $horizon_banner_third + $logo_box;
                $itotal = $subscription_price + $creative_price + $advertings_price;
                $discount_price = Input::get('discount_price');
                $total_price = Input::get('total_price');
                $payment_option = Input::get('payment_option');
                $tmp_total = $itotal - $discount_price;
                if ($tmp_total == $total_price) {
                    //ok price   
                } else {
                    return returnMsg('error', 'admininvoice/generate/', "something happen wrong during calculation, Please try again.", [$restID]);
                }
                $startup_price = $monthly_price = $installment_duration = 0;
                $down_payment = $monthly_price = $installment_duration = 0;
                if ($payment_option == 2) {
                    $down_payment = Input::get('down_payment');
                    $monthly_price = Input::get('monthly_price');
                    $installment_duration = Input::get('installment_duration');
                }
                $option_list = "";
                $option_value = "";
                if (is_array($options)) {
                    foreach ($options as $key => $value) {
                        if ($option_list == "") {
                            $option_list = $key;
                        } else {
                            $option_list .= ',' . $key;
                        }
                        if ($option_value == "") {
                            $option_value = $value;
                        } else {
                            $option_value .= ',' . $value;
                        }
                    }
                }
                $t['option_list'] = $option_list;
                $t['option_value'] = $option_value;
                $t['total_price'] = $total_price;
                $t['invoice_number'] = Input::get('invoice_number');
                $t['reference_number'] = $reference_number;
                $t['account_type'] = $rest->rest_Subscription;
                $t['subscription_price'] = $subscription_price;
                $t['creative_price'] = $creative_price;
                $t['advertings_price'] = $advertings_price;
                $t['discount_price'] = $discount_price;
                $t['total_price'] = $tmp_total;

                $t['payment_option'] = Input::get('payment_option');
                $t['down_payment'] = $down_payment;
                $t['monthly_price'] = $monthly_price;
                $t['installment_duration'] = $installment_duration;
                $t['invoice_date'] = $invoice_date;
                $is_draft = 0;

                if (isset($_POST['is_draft']) && !empty($_POST['is_draft'])) {
                    $is_draft = 1;
                }
                $t['is_draft'] = $is_draft;
                if (isset($_POST['invoiceID']) && !empty($_POST['invoiceID'])) {
                    $this->MRestActions->saveInvoice($t);
                } else {
                    $this->MRestActions->generateInvoice($t);
                }
                if (Session::get('admincountryName') != "") {
                    $settings = Config::get('settings.' . Session::get('admincountryName'));
                } else {
                    $settings = Config::get('settings.default');
                }
                /* COMMON CALCULATION */
                $duration = $type = "";
                switch ($rest->rest_Subscription) {
                    case 0:
                        $type = "Free";
                        break;
                    case 1:
                        $type = "Bronze";
                        break;
                    case 2:
                        $type = "Silver";
                        break;
                    case 3:
                        $type = "Gold";
                        break;
                }
                if ($rest->member_duration == 0) {
                    $duration = "Unlimited";
                } elseif ($rest->member_duration == 3) {
                    $duration = "3 Months";
                } elseif ($rest->member_duration == 6) {
                    $duration = "6 Months";
                } elseif ($rest->member_duration == 12) {
                    $duration = "1 Year";
                } elseif ($rest->member_duration == 24) {
                    $duration = "2 Years";
                }
                if ($rest->rest_Subscription == 0) {
                    $expiredate = "Unlimited Time";
                } else {
                    if ($member->date_upd == "") {
                        $dateadd = strtotime($member->date_add);
                        $dur = $rest->member_duration;
                        $dateadd = strtotime("+" . $dur . " months", $dateadd);
                        $expiredate = date("Y-m-d", $dateadd);
                    } else {
                        $dateadd = strtotime($member->date_upd);
                        $dur = $rest->member_duration;
                        $dateadd = strtotime("+" . $dur . " months", $dateadd);
                        $expiredate = date("Y-m-d", $dateadd);
                    }
                }
                $t['type'] = $type;
                $t['duration'] = $duration;
                $t['memDate'] = $rest->member_date;
                $t['expiredate'] = $expiredate;
                $t['manager_name'] = $member->full_name;
                $t['email'] = $member->email;
                $t['phone'] = $member->phone;
                $t['settings'] = $settings;
                $sufratiUser = $settings['teamEmails'];
                $t['country'] = $country;
                $t['restname'] = stripslashes($restData->rest_Name);
                $t['restnameAr'] = stripslashes($restData->rest_Name_Ar);
                $t['restaurant'] = $restData;
                $t['title'] = "Invoice details";
                $t['heading_title'] = $subject = stripslashes($restData->rest_Name) . " Invoice details";
                $t['sitename'] = $settings['name'];
                $t['pdf'] = true;
                //$msgtousers = $this->load->view('mails/invoice', $t, true);
                if ($is_draft == 1) {
                    try {
                        Mail::queue('emails.restaurant.invoice', $t, function ($message) use ($subject) {
                            $subject = $subject . ' - DRAFT';
                            $message->to("ha@azooma.co", 'Azooma')->subject($subject);
                            //$message->to("info@azooma.co", 'Azooma')->subject($subject);
                            //$message->cc("accounts@sufrati", 'Azooma')->subject($subject);
                            //$message->bcc("ha@azooma.co", 'Azooma')->subject($subject);
                        });
                    } catch (Exception $e) {
                        return returnMsg('error', 'admininvoice', $e->getMessage());
                    }
                    $this->MAdmins->addActivity('Invoice sent as Draft for ' . stripslashes($rest->rest_Name));
                    return returnMsg('success', 'admininvoice', stripslashes(($restData->rest_Name)) . ' Invoice is send as draft successfully');
                } else {
                    $userEmails = "";
                    if (isset($member->email)) {
                        $userEmails = $member->email;
                        $userEmails = explode(",", $userEmails);
                    }
                    if (is_array($userEmails)) {
                        try {
                            Mail::queue('emails.restaurant.invoice', $t, function ($message) use ($subject, $userEmails, $sufratiUser) {
                                $message->to("ha@azooma.co", 'Azooma')->subject($subject);
                                //$message->to($userEmails[0], 'Azooma')->subject($subject);
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
                                    //$message->cc($ccemail, 'Azooma')->subject($subject);
                                }
                                //$message->bcc($sufratiUser, 'Azooma')->subject($subject);
                            });
                        } catch (Exception $e) {
                            return returnMsg('error', 'admininvoice', $e->getMessage());
                        }
                        $this->MAdmins->addActivity('Invoice sent for ' . stripslashes($rest->rest_Name));
                        return returnMsg('success', 'admininvoice', stripslashes(($restData->rest_Name)) . ' Invoice is sent successfully');
                    } else {
                        return returnMsg('error', 'admininvoice/generate/',  "something went wrong, Please try again.", [$restData->rest_ID]);
                    }
                }
            }
        }
    }

    function view($rest = 0)
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
        $restData = $this->MRestActions->getRest($rest);
        $member = $this->MRestActions->getAccountDetails($rest);
        $invoice = $this->MRestActions->getInvoiceDetails($rest);
        $data = array(
            'sitename' => $settings['name'],
            'pagetitle' => stripslashes($restData->rest_Name) . " View Invoice Details",
            'title' => stripslashes($restData->rest_Name) . " View Invoice Details",
            'action' => 'admininvoice',
            'MRestActions' => $this->MRestActions,
            'rest' => $restData,
            'member' => $member,
            'invoice' => $invoice,
            'css' => 'chosen,jquery-ui,admin/datepicker',
            'js' => 'chosen.jquery,jquery-ui,admin/datepicker'
        );
        return view('admin.partials.invoicedetails', $data);
    }

    function status($status = 0)
    {
        $invoiceID = 0;
        $rest_ID = 0;
        if (isset($_GET['invoiceID']) && !empty($_GET['invoiceID'])) {
            $invoiceID = stripslashes($_GET['invoiceID']);
        }
        if (isset($_GET['rest_ID']) && !empty($_GET['rest_ID'])) {
            $rest_ID = stripslashes($_GET['rest_ID']);
        }
        $countryID = Session::get('admincountry');
        if (empty($countryID)) {
            $countryID = 1;
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = MGeneral::getCountry($countryID);
        $restData = $rest = $this->MRestActions->getRest($rest_ID);
        $member = $this->MRestActions->getAccountDetails($rest_ID);
        $invoice = $this->MRestActions->getInvoiceDetails($rest_ID, $invoiceID);
        $subject = "";
        $filename = "";
        $flash_message = "";
        $userEmails = "";
        if (isset($member['email'])) {
            $userEmails = $member->email;
            $userEmails = explode(",", $userEmails);
        }
        if ($status == 0) {
            return returnMsg('error', 'admininvoice/view/', "something happen wrong with status, Please try again.", [$rest_ID]);
        } else if ($status == 3) {
            $this->MRestActions->updateInvoice($invoiceID, $rest_ID, 3);
            $this->MAdmins->addActivity('Invoice is Cancelled for ' . $rest->rest_Name);
            return returnMsg('success', 'admininvoice', "Invoice is Cancelled successfully");
        } else if ($status == 2) {
            $this->MRestActions->updateInvoice($invoiceID, $rest_ID, 2);
            $subject = "Invoice Reminder";
            $filename = "invoice_reminder";
            $flash_message = "Invoice Reminder send successfully";
            $this->MAdmins->addActivity('Invoice Reminder for ' . $rest->rest_Name);
        } else if ($status == 1) {
            $this->MRestActions->updateInvoice($invoiceID, $rest_ID, 1);
            $subject = "Invoice Receipt";
            $filename = "invoice_receipt";
            $flash_message = "Invoice Paid and reciept send successfully";
            $this->MAdmins->addActivity('Invoice Paid and reciept send for ' . $rest->rest_Name);
        }
        if (is_array($userEmails)) {
            $duration = $type = "";
            switch ($rest->rest_Subscription) {
                case 0:
                    $type = "Free";
                    break;
                case 1:
                    $type = "Bronze";
                    break;
                case 2:
                    $type = "Silver";
                    break;
                case 3:
                    $type = "Gold";
                    break;
            }
            if ($rest->member_duration == 0)
                $duration = "Unlimited";
            elseif ($rest->member_duration == 3)
                $duration = "3 Months";
            elseif ($rest->member_duration == 6)
                $duration = "6 Months";
            elseif ($rest->member_duration == 12)
                $duration = "1 Year";
            elseif ($rest->member_duration == 24)
                $duration = "2 Years";

            if ($rest->rest_Subscription == 0) {
                $expiredate = "Unlimited Time";
            } else {
                $dateadd = $rest->member_date;
                $dur = $rest->member_duration;
                $expiredate = strtotime("+" . $dur . " months", strtotime($dateadd));
                $expiredate = date("Y-m-d", $expiredate);
            }
            $t['settings'] = $settings;
            $sufratiUser = $settings['teamEmails'];
            $t['country'] = $country;
            $t['total_price'] = $invoice->monthly_price;
            $t['payment_option'] = $invoice->payment_option;
            $t['down_payment'] = $invoice->down_payment;
            $t['monthly_price'] = $invoice->monthly_price;
            $t['installment_duration'] = $invoice->installment_duration;
            $t['reference_number'] = $invoice->reference_number;
            $t['invoice_date'] = $invoice->invoice_date;
            $t['subscription_price'] = $invoice->subscription_price;
            $t['creative_price'] = $invoice->creative_price;
            $t['advertings_price'] = $invoice->advertings_price;
            $t['discount_price'] = $invoice->discount_price;
            $t['total_price'] = $invoice->total_price;
            $t['invoice_number'] = $invoice->invoice_number;

            $t['account_type'] = $rest->rest_Subscription;
            $t['restname'] = stripslashes($rest->rest_Name);
            $t['type'] = $type;
            $t['duration'] = $duration;
            $t['memDate'] = $rest->member_date;
            $t['expiredate'] = $expiredate;
            $t['manager_name'] = $member->full_name;
            $t['email'] = $member->email;
            $t['phone'] = $member->phone;

            $t['title'] = $subject;
            $t['heading_title'] = $subject;
            $t['sitename'] = $settings['name'];

            try {
                Mail::queue('emails.restaurant.' . $filename, $t, function ($message) use ($subject, $userEmails, $sufratiUser) {
                    $message->to("ha@azooma.co", 'Azooma')->subject($subject);
                    //$message->to($userEmails[0], 'Azooma')->subject($subject);
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
                        //$message->cc($ccemail, 'Azooma')->subject($subject);
                    }
                    //$message->bcc($sufratiUser, 'Azooma')->subject($subject);
                });
            } catch (Exception $e) {
                return returnMsg('error', 'admininvoice', $e->getMessage());
            }
            return returnMsg('success', 'admininvoice', stripslashes(($restData->rest_Name)) . $flash_message);
        } else {
            return returnMsg('error', 'admininvoice/generate/', "something went wrong, Please try again.", [$restData->rest_ID]);
        }
    }
}
