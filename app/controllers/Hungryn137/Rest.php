<?php

use Yajra\DataTables\Facades\DataTables;

class Rest extends AdminController {

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


        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant', 'City', 'Cuisine', 'Membership', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Restaurants',
            'title' => 'All Restaurants',
            'action' => 'adminrestaurants',
            'country' => $country,
            'side_menu' => array('Restaurant Mgmt','Restaurants'),
        );

        // dump($data);die;
        return view('admin.partials.restaurants', $data);
    }
    public function getRestData(){
         $district = "";
        $query = DB::table('restaurant_info');
        $query->select('restaurant_info.*', DB::Raw('(select status FROM booking_management WHERE rest_id=restaurant_info.rest_ID Limit 1 ) AS membershipstatus'), DB::Raw("( SELECT getCuisineName(restaurant_info.rest_ID,'en') ) as cuisines"), DB::Raw("( SELECT getCityName(restaurant_info.rest_ID,'en') ) as cities"));

      
        if (!in_array(0, adminCountry())) {
            $query->whereIn("restaurant_info.country",  adminCountry());
        }
        if (get('status')) {
            $query->where('restaurant_info.rest_Status', intval(get('status')));
        }
        if (get('city')) {
            $query->join('rest_branches', function($join) {
                $join->on('rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            });
            $query->where('rest_branches.city_ID', '=', get('city'));
           
        }
        if (get('rest_viewed') && get('rest_viewed') != 0) {
            $query->where('restaurant_info.rest_Viewed > ', get('rest_viewed'));
        }
        if (get('cuisine')>0) {
            $query->join('restaurant_cuisine', 'restaurant_cuisine.rest_ID', '=', 'restaurant_info.rest_ID');
            $query->where('restaurant_cuisine.cuisine_ID', '=', intval(get('cuisine')));
        }
        if (get('best')) {
            $query->join('restaurant_bestfor', 'restaurant_bestfor.rest_ID', '=', 'restaurant_info.rest_ID');
            $query->where('restaurant_bestfor.bestfor_ID', '=', get('best'));
        }
        if (get('membership')) {
            $query->where('restaurant_info.rest_Subscription', get('membership'));
        }
        if (get('price')) {
            $query->where('restaurant_info.price_range', get('price'));
        }
  
         $sort=get('sort');
        if ($sort != "") {
            switch ($sort) {
              
                case 'latest':
                    $query->orderBy('restaurant_info.rest_RegisDate', 'DESC');
                    break;
                case 'popular':
                    $query->select('restaurant_info.*',DB::raw('(SELECT COUNT(likee_info.id) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1) as likes'), DB::Raw('(select status FROM booking_management WHERE rest_id=restaurant_info.rest_ID Limit 1 ) AS membershipstatus'), DB::Raw("( SELECT getCuisineName(restaurant_info.rest_ID,'en') ) as cuisines"), DB::Raw("( SELECT getCityName(restaurant_info.rest_ID,'en') ) as cities"));
                    $query->orderBy('likes', 'DESC');
                    break;
                case 'favorite':
                    $query->where('restaurant_info.sufrati_favourite','>=', 1);
                    break;
            }
        } 
    
  
        return  DataTables::of($query)
            ->addColumn('action', function ($rest) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info m-1 mytooltip" href="'.route('adminrestaurants/form/',$rest->rest_ID).' title="Edit Content"><i class="fa fa-edit"></i></a>';
                    

                if ($rest->rest_Status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="'.route('adminrestaurants/status/',$rest->rest_ID).'" title="Activate "><i class="fa fa-check"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="'.route('adminrestaurants/status/',$rest->rest_ID).'" title="Deactivate"><i class="fa fa-ban"></i></a>';
                }
                $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-btn" href="#" link="'.route('adminrestaurants/delete/',$rest->rest_ID).'" title="Delete"><i class="fa fa-trash"></i></a>';
                if ($rest->rest_Status == 1) {
                    if ($rest->sufrati_favourite == 0) {
                                                      
                           $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="'.route('adminfavorites/favourite/', $rest->rest_ID).'" rel="tooltip" title="Add to Sufrati Favourites">
                            <i class="fa fa-star"></i>
                        </a>';
                     } else { 
                        $btns .='<a class="btn btn-xs btn-info m-1 mytooltip" href="'.route('adminfavorites/remove/', $rest->rest_ID) . '?rest=1'.'" rel="tooltip" title="Remove from Sufrati Favourites">
                            <i class="fa fa-heart"></i>
                        </a>';
                    
                    }
                    if (!isset($rest->membershipstatus) OR $rest->membershipstatus == "") {
                        
                        $btns .='<a class="btn btn-xs btn-info m-1 mytooltip" href="'.route('adminrestaurants/newmember/',$rest->rest_ID).'" title="Make Sufrati Member">
                            <i class="fa '.($rest->rest_Subscription == "" ? 'fa-arrow-up' : 'fa-info').'"></i>
                        </a>';
                       
                    } elseif (isset($rest->membershipstatus) && $rest->membershipstatus > 0) {
                        
                        $btns .='<a class="btn btn-xs btn-info m-1 mytooltip" href="'.route('adminmembers/contacts/',$rest->rest_ID).'" title="Update Membership Contacts "><i class="fa fa-book"></i></a>
                        <a class="btn btn-xs btn-info m-1 mytooltip" href="'.route('adminmembers/details/',$rest->rest_ID).'" title="Update Membership Details"><i class="fa fa-briefcase"></i></a>';
                            
                        }
                    }
                return $btns;
            })
            ->editColumn('rest_Name', function ($rest) {
                $html='
                <span class="'.($rest->rest_Status == 0?"line-through":"").' 
                ' .($rest->is_read == 0? "new-row":"").'" >';
                $html.=  stripslashes($rest->rest_Name) .'</span>';
                return $html;
            })
            ->editColumn('cities', function ($rest) {
                $html= '';
                if (empty($rest->cities)) {
                    $html= '-';
                } else {
                    $html.= str_replace(",", "<br>", $rest->cities);
                }
                return $html;
            })
            ->editColumn('rest_Subscription', function ($rest) {
                $html= '<span class="label p-1 ';
                if ($rest->rest_Subscription == 0) {
                    $html.= ' label-danger">Not a Member';
                } else {
                    switch ($rest->rest_Subscription) {
                        case 0:
                            $html.= ' label-default">Free member';
                            break;
                        case 1;
                        $html.= ' label-success">Bronze member';
                            break;
                        case 2:
                            $html.= ' label-info">Silver member';
                            break;
                        case 3:
                            $html.= ' label-warning">Gold Member';
                            break;
                    }
                }
                $html.= "</span>";
                return $html;
            })
    

            ->editColumn('lastUpdatedOn', function ($rest) {
                if ($rest->lastUpdatedOn == "" || $rest->lastUpdatedOn == "0000-00-00 00:00:00") {
                    return date('d/m/Y', strtotime($rest->rest_RegisDate));
                } else {
                    return date('d/m/Y', strtotime($rest->lastUpdatedOn));
                }
            })
            ->make(true);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $resttype = $this->MRestActions->getAllRestTypes(1);
        $bestfor = $this->MGeneral->getAllBestFor(1);
        $cuisines = $this->MGeneral->getAllCuisine(1);
        $reststyle = $this->MRestActions->getAllRestStyles();
        $mastercuisines = $this->MGeneral->getAllMasterCuisine();
        $grouprests = $this->MRestActions->getAllGroupRestaurants(1);
        if ($id != 0) {
            $page = $this->MRestActions->getRest($id);
            if ($page->is_read == 0) {
                $this->MRestActions->read($id);
            }
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->rest_Name,
                'title' => $page->rest_Name,
                'rest' => $page,
                'grouprests' => $grouprests,
                'resttype' => $resttype,
                'reststyle' => $reststyle,
                'grouprests' => $grouprests,
                'cuisines' => $cuisines,
                'mastercuisines' => $mastercuisines,
                'bestfor' => $bestfor,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => ['Restaurant Mgmt','Restaurants'],
            );
            $data['restcuisines'] = $restcuisines = $this->MGeneral->getRestaurantCuisines($id);
            $data['restbestfors'] = $restbestfors = $this->MGeneral->getRestaurantBestFors($id);
            $data['openHours'] = $this->MRestActions->getRestaurantTimings($id);
            $data['restdays'] = $this->MRestActions->getRestaurantDays($id);
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Restaurant',
                'title' => 'New Restaurant',
                'grouprests' => $grouprests,
                'resttype' => $resttype,
                'reststyle' => $reststyle,
                'grouprests' => $grouprests,
                'cuisines' => $cuisines,
                'mastercuisines' => $mastercuisines,
                'bestfor' => $bestfor,
                'css' => 'chosen',
                'js' => 'chosen.jquery',
                'side_menu' => array('Restaurant Mgmt','Add Restaurants'),
            );
        }

        return view('admin.forms.restaurant', $data);
    }

    public function save() {
        if (Input::get('rest_Name')) {
            $image = "";
            $actualWidth = "";
            $ratio = "0";
            if (Input::hasFile('rest_Logo')) {
                $file = Input::file('rest_Logo');
                $temp_name = $_FILES['rest_Logo']['tmp_name'];
                $filename = $file->getClientOriginalName();
                $logo = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
                $thumbHeight = null;
                $conserveProportion = true;
                $positionX = 0; // px
                $positionY = 0; // px
                $position = 'MM';
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
                $thumbLayer = clone $largeLayer;
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                if ($actualWidth < 150 && $actualHeight < 150) {
                    return returnMsg('error','adminrestaurants','Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/logos/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/logos/" . $save_name);
                $changelayer = clone $layer;
                // $changelayer->resizeInPixel(200, 200);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/", $save_name, true, null, 95);


                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/logos/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(45, 45);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/45/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(40, 40);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/40/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(70, 70);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/70/", $save_name, true, null, 95);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/logos/thumb", $save_name, true, null, 95);
            } else {
                if (Input::has('rest_Logo_old')) {
                    $logo = Input::get('rest_Logo_old');
                } else {
                    $logo = 'default_logo.gif';
                }
            }
            if (Input::get('rest_ID')) {
                $rest = $_POST['rest_ID'];
                $this->MRestActions->updateRestaurant($logo);
                $allrestEmails = $_POST['rest_Email'];
                $allrestEmails[] = $_POST['your_Email'];
                $this->MRestActions->addUpdateRestSubscriberEmail($allrestEmails, $_POST['your_Name']);
                $this->MRestActions->updateRestCuisines($rest);
                $this->MRestActions->updateRestBestFor($rest);
                $this->MRestActions->updateOpenHours($rest);
                $this->MRestActions->updateRestBookingConactEmails($rest, $_POST['rest_Email']);
                $openning_manner = $_POST['openning_manner'];
                if (isset($openning_manner) && !empty($openning_manner)) {
                    if ($openning_manner == "Closed Down") {
                        $this->MRestActions->updateMembershipStatus($rest);
                    }
                }
                if (Input::get('restbusiness_type') == '2') {
                    if ($this->MRestActions->getGroupRest($rest) > 0) {
                        $this->MRestActions->updateGroupRest($rest);
                    } else {
                        $this->MRestActions->addGroupRest($rest);
                    }
                }
                $this->MAdmins->addActivity('Updated Restaurant ' . Input::get('rest_Name'));
                if (Input::get('ref')) {
                    $per_page = Input::get('per_page');
                    $limit = Input::get('limit');
                    return returnMsg('success','adminrestaurants', stripslashes((post('rest_Name'))) . ' Restaurant Updated succesfully',[$rest]);
                } else {
                    return returnMsg('success','adminrestaurants/form/', stripslashes((post('rest_Name'))) . ' Restaurant Updated succesfully',[$rest]);
                }
            } else {
                $rest = $this->MRestActions->addRestaurant($logo);
                $allrestEmails = $_POST['rest_Email'];
                $allrestEmails[] = $_POST['your_Email'];
                $this->MRestActions->addUpdateRestSubscriberEmail($allrestEmails, $_POST['your_Name']);
                $this->MRestActions->addRestCuisines($rest);
                $this->MRestActions->addRestBestFor($rest);
                $this->MRestActions->addOpenHours($rest);
                if (Input::get('restbusiness_type') == '2') {
                    $this->MRestActions->addGroupRest($rest);
                }
                $this->MAdmins->addActivity('Added Restaurant ' . stripslashes(Input::get('rest_Name')));
                return returnMsg('success','adminrestaurants/branches', stripslashes((post('rest_Name'))) . ' Restaurant added succesfully',[$rest]);

            }
        } else {
            return returnMsg('error','adminrestaurants', "something went wrong, Please try again.");

        }
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MRestActions->getRest($id);
        if (count($page) > 0) {
            if ($page->rest_Status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'rest_Status' => $status
            );

            DB::table('restaurant_info')->where('rest_ID', $id)->update($data);
            $this->MAdmins->addActivity('Welcome Message Status changed successfully.' . $page->rest_Name);
            return returnMsg('success','adminrestaurants',  "Welcome Message Status changed successfully.");

        }
        return returnMsg('error','adminrestaurants', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MRestActions->getRest($id);
        if (count($page) > 0) {
            $this->MRestActions->deleteRest($id);
            $this->MAdmins->addActivity($page->rest_Name . ' deleted successfully.');
            return returnMsg('success','adminrestaurants', $page->rest_Name . ' deleted successfully.');
        }
        return returnMsg('error','adminrestaurants', "something went wrong, Please try again.");
    }

    function comments($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest = $this->MRestActions->getRest($id);
        $lists = $this->MRestActions->getRestaurantComments($id);
        $overallcomments = $this->MRestActions->getRestaurantCommentsCount($id);
        $rating = $this->MRestActions->restRating($id);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant', 'City', 'Cuisine', 'Membership', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Restaurants',
            'title' => 'All Restaurants',
            'action' => 'adminrestaurants',
            'MGeneral' => $this->MGeneral,
            'rest' => $rest,
            'rest_ID' => $id,
            'overallcomments' => $overallcomments,
            'rating' => $rating,
            'lists' => $lists,
            'side_menu' => ['adminrestaurants','Add Restaurants'],
        );
        return view('admin.partials.restcommentspolls', $data);
    }

    function emails() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $member = "";
        $restaurant = "";
        $limit = 20;
        if (isset($_GET['membership']) && ($_GET['membership'] != "")) {
            $member = ($_GET['membership']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['restaurant']) && ($_GET['restaurant'] != "")) {
            $restaurant = ($_GET['restaurant']);
        }

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        // $lists = $this->MRestActions->getAllRestaurantEmails($limit, $member, $restaurant);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant', 'Manager Name', 'Emails', 'Management Emails', 'Last Update'),
            'pagetitle' => 'List of All Restaurants Emails',
            'title' => 'All Restaurants Emails',
            'action' => 'adminrestaurants/emails',
            'MGeneral' => $this->MGeneral,
            // 'lists' => $lists,
            'side_menu' => array('Restaurant Mgmt','Restaurant Emails'),
        );

        return view('admin.partials.restemails', $data);
    }

    public function emails_data_table()
    {
        $query = DB::table('restaurant_info');
        // $query = MRestActions::select('rest_Name', 'lastUpdatedOn', 'your_Name', 
            // DB::raw('( SELECT booking_management.email FROM booking_management WHERE booking_management.rest_id=restaurant_info.rest_ID) as booking'), 
            // DB::raw('CONCAT(rest_Email, " ", your_Email) AS email'));
        if (!in_array(0, adminCountry())) {
            $query->where('rest_Email', '!=', '')->where('rest_Status', '=', '1')->orderBy('rest_Subscription', 'DESC');
        }
        if (Input::has('membership')) {
            $query->where('rest_Subscription', '=', intval(get('membership')));
        }
        return  DataTables::of($query)
            ->editColumn('restaurant', function ($list) {
                return  stripslashes(($list->rest_Name));
            })
            ->editColumn('manager', function ($list) {
                return  stripslashes(($list->your_Name));
            })
            ->editColumn('emails', function ($list) {
                return  trim(str_replace(" ", "<br>", str_replace(",", "<br>", $list->rest_Email)));
            })
            ->editColumn('manager_emails', function ($list) {
                return  trim(str_replace(" ", "<br>", str_replace(",", "<br>", $list->your_Email)));
            })
            
            ->editColumn('updatedAt', function ($list) {
                if ($list->lastUpdatedOn == "") {
                    return date('d/m/Y', strtotime($list->createdAt));
                } else {
                    return date('d/m/Y', strtotime($list->lastUpdatedOn));
                }
            })
            ->make(true);
    }

    function mostview() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $sort = "popular";
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Restaurant', 'Membership Status', 'Total', 'Last Update'),
            'pagetitle' => 'List of Most Restaurants Views',
            'title' => 'Most Restaurants Views',
            'action' => 'adminrestaurants/mostview',
            'MGeneral' => $this->MGeneral,
            'side_menu' => array('Categories / Lists','Most Viewed'),
        );
        return view('admin.partials.restmostview', $data);
    }

    public function mostview_data_table()
    {
        $query = DB::table('restaurant_info');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        return  DataTables::of( $query)
            ->addColumn('restaurant', function ($list) {
                $btns = '';
                    $btns = stripslashes($list->rest_Name) . ' - ' . stripslashes($list->rest_Name_Ar);

                return $btns;
            })
           
            ->addColumn('total', function ($list) {
                $btns = '<span class="label';
                    if ($list->rest_Subscription == 0) {
                        $btns .= ' label-danger">Not a Member';
                    } else {
                        switch ($list->rest_Subscription) {
                            case 0:
                                $btns .= ' label-default">Free member';
                                break;
                            case 1;
                                $btns .= ' lable-success">Bronze member';
                                break;
                            case 2:
                                $btns .= ' label-info">Silver member';
                                break;
                            case 3:
                                $btns .= ' label-warning">Gold Member';
                                break;
                        }
                    }
                    $btns .= "</span>";
                    
                return $btns;
            })

            ->addColumn('membership_status', function ($list) {
                
                $btns = stripslashes(($list->rest_Viewed));
                return $btns;
            })

            ->addColumn('last_update', function ($list) {
                    if ($list->lastUpdatedOn == "") {
                        $btns = date('d/m/Y', strtotime($list->createdAt));
                    } else {
                        $btns = date('d/m/Y', strtotime($list->lastUpdatedOn));
                    }

                return $btns;
            })
            
            ->make(true);
    }

    function newmember($id = 0) {
        if ($id != 0) {
            $check = $this->MRestActions->check_user($id);
            if ($check == TRUE) {
                return Redirect::route('adminrestaurants')->with('error', "This restaurant has already an account");
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
            $resttype = $this->MRestActions->getAllRestTypes(1);
            $bestfor = $this->MGeneral->getAllBestFor(1);
            $cuisines = $this->MGeneral->getAllCuisine(1);
            $rest = $this->MRestActions->getRest($id);
            $memberFlag = $this->MRestActions->check_user($id);
            $member = $this->MRestActions->getAccountDetails($rest->rest_ID);

            $data = array(
                'sitename' => $settings['name'],
                'headings' => array('Restaurant', 'Emails', 'Management Emails', 'Last Update'),
                'pagetitle' => "Create member accoutn for " . stripslashes($rest->rest_Name),
                'title' => "Create member accoutn for " . stripslashes($rest->rest_Name),
                'action' => 'adminrestaurants/newmember/',
                'MGeneral' => $this->MGeneral,
                'rest' => $rest,
                'memberFlag' => $memberFlag,
                'js' => 'chosen.jquery,jquery-ui,admin/datepicker',
                'css' => 'jquery-ui,admin/datepicker',
                'side_menu' => ['Restaurant Mgmt'],
            );
            return view('admin.partials.creatememberdetails', $data);
        } else {
            return returnMsg('error','adminrestaurants',"something went wrong, Please try again.");
        }
    }

    function savemember($id = 0) {
        if (Input::has('rest_ID')) {
            $check = $this->MRestActions->check_user($_POST['rest_ID']);
            if ($check == TRUE) {
                return returnMsg('error','adminrestaurants/newmember/', "This restaurant has already an account",[post('rest_ID')]);

            }
            $countryID = Session::get('admincountry');
            if (empty($countryID)) {
                $countryID = 1;
            }
            $country = MGeneral::getCountry($countryID);
            $rest = $this->MRestActions->getRest(Input::get('rest_ID'));
            $pass = "";
            $ref = "";
            $restname = stripslashes($rest->rest_Name);
            $restname = str_replace(" ", "", $restname);
            $restname = str_replace("'", "", $restname);
            $restnameLength = strlen($restname);
            if ($restnameLength == 1) {
                $ref = $restname . '00';
                $pass = $restname . '00' . mt_rand(333, 999);
            } elseif ($restnameLength == 2) {
                $ref = $restname . '0';
                $pass = $restname . '0' . mt_rand(333, 999);
            } else {
                $ref = substr($restname, 0, 3);
                $pass = substr($restname, 0, 3) . mt_rand(333, 999);
            }
            $user_name = stripslashes($rest->rest_Name);
            $user_name = str_replace("'", "", $user_name);
            $user_name = str_replace(" ", "", $user_name);
            $user_name = trim($user_name);
            $this->MClients->AddMemberContacts($pass, $user_name);
            $member = $this->MClients->getBookingManagementID($rest->rest_ID);
            $reference = $ref . $member->id_user . $member->id_user . date("d") . date("m") . date("y");
            $this->MClients->addMemberDetails($reference, $member->id_user);
            $duration = "2 Months";
            $type = "Free";
            $sevices = "<ul style='line-height: 22px;font-size:14px;margin: 0px;'>
                                <li>Update your profile page details</li>
                                <li>List & map all your locations</li>
                                <li>Uploadphotos to your gallery</li>
                                <li>Add your Menu</li>
                                </ul>";
            $sevicesAr = "<ul style='line-height: 22px;font-size:14px;margin: 0px;text-align:right;' dir='rtl'>
                                <li>تحديث تفاصيل صفحة حسابك</li>
                                <li>تسجيل و تحديد كل مواقعك</li>
                                <li>تحميل الصور إلى المعرض الخاص بك</li>
                                <li>إضافة القائمة الخاصة بالمطعم</li>
                                </ul>";

            $userEmails = "";
            if (isset($_POST['emails'])) {
                $userEmails = Input::get('emails');
            }
            $sufratiUser = array("info@azooma.co", "passwords@azooma.co", "data@azooma.com", "admin@azooma.com", "kareem@primedigiko.com", 'ha@azooma.com');
            if (is_array($userEmails)) {
                $data = array();
                if (Session::get('admincountryName') != "") {
                    $settings = Config::get('settings.' . Session::get('admincountryName'));
                } else {
                    $settings = Config::get('settings.default');
                }
                $data['settings'] = $settings;
                $data['country'] = $country;
                $data['type'] = $type;
                $data['sevices'] = $sevices;
                $data['user_name'] = $user_name;
                $data['restname'] = stripslashes($rest->rest_Name);
                $data['restnameAr'] = stripslashes($rest->rest_Name_Ar);
                $data['restaurant'] = $rest;
                $data['password'] = $pass;
                $data['memdate'] = date('Y-m-d', strtotime($_POST['member_date']));
                $data['duration'] = $duration;
                $data['title'] = "Admin account";
                $data['sitename'] = $settings['name'];
                $subject = "Your admin account at Sufrati";
                Mail::queue('emails.restaurant.memberaccountnew', $data, function($message) use ($subject, $userEmails, $sufratiUser) {
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
                });
                return returnMsg('success','adminrestaurants', "Congratulation! " . stripslashes($_POST['rest_Name']) . ' is now Sufrati Free Member, Email is sent to restaurant successfully');
            }
            return returnMsg('error','adminrestaurants', "something went wrong, Please try again.");

        }
    }

}
