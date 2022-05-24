<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller
{

    public $data;

    function __construct()
    {
        parent::__construct();

        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Mbooking',"MBooking");
        $this->load->model('Mrestbranch',"MRestBranch");
        $this->load->model('Notification');
        $this->load->library('pagination');
        $sys_lang=$this->session->userdata("lang");
        if($sys_lang=='arabic' or $sys_lang=='english'){
         $this->lang->load($sys_lang,  $sys_lang);
        }
        else{
            $this->session->set_userdata('lang', 'arabic'); 
            $this->lang->load('arabic', 'arabic');
        }
    }

    public function index()
    {
       
        if ($this->session->userdata('restuser') == '') {
            redirect('home/login');
        } else {
            $this->load->model("RestModel", "rest_model");
            $restid =rest_id();
            $data['statics']=$this->rest_model->getDashboardData($restid);

            $uuserid = $this->session->userdata('id_user');
            $permissions = $this->MBooking->restPermissions($restid);
            $permissions = explode(',', $permissions['sub_detail']);
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['sitename'] = $this->MGeneral->getSiteName();
            $data['logo'] = $logo = $this->MGeneral->getLogo();
            $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
            $data['rating_text'] = $this->rest_model->getRatingtext($restid);
            $overallRatings = $this->MRestBranch->getOverallRatings($restid);
            if (is_array($overallRatings)) {
                $count_overallRatings = count($overallRatings);
                $food = $service = $atmosphere = $rating_value = $presentation = $variety = 0;
                foreach ($overallRatings as $rows1) {
                    $food = $food + $rows1['rating_Food'];
                    $service = $service + $rows1['rating_Service'];
                    $atmosphere = $atmosphere + $rows1['rating_Atmosphere'];
                    $rating_value = $rating_value + $rows1['rating_Value'];
                    $presentation = $presentation + $rows1['rating_Presentation'];
                    $variety = $variety + $rows1['rating_Variety'];
                }
                $resfood = ($food / $count_overallRatings);
                $resservice = ($service / $count_overallRatings);
                $resatmosphere = ($atmosphere / $count_overallRatings);
                $resrating_value = ($rating_value / $count_overallRatings);
                $respresentation = ($presentation / $count_overallRatings);
                $resvariety = ($variety / $count_overallRatings);

                $data['overallratings'] = ($resfood + $resservice + $resatmosphere + $resrating_value + $respresentation + $resvariety) / 6;
            } else {
                $data['overallratings'] = 'Not Rated Yet';
            }
            $data['like_percentage'] = $this->MRestBranch->get_like_percentage($restid);
            $data['like_by'] = $this->MRestBranch->get_like_by($restid);

            $data['favourite'] = $this->MRestBranch->getFavourites($restid);
            $data['comments'] = $this->MRestBranch->getTotalComments($restid);
            $lastlogin = $this->MGeneral->getLastLogin($uuserid);
            
       

            $data['newcomments'] = $this->MRestBranch->getTotalNewComments($restid, $lastlogin);
            $data['newphotos'] = $this->MRestBranch->getTotalNewPhotos($restid, $lastlogin);
            $data['recommendations'] = $this->MRestBranch->getTotalRecommendation($restid, $lastlogin);
            $data['latestRatings'] = $this->MRestBranch->getTotalNewRatingsNew($restid, $lastlogin);
            $data['getlates'] = $this->MRestBranch->getLatestRatings($restid, 1, 5);
            $data['activities'] = $this->MRestBranch->getActivities($uuserid, 5);
            $data['latestUserUpload'] = $this->MRestBranch->getLatestUploads($restid, 1, 5);
            $data['latestcomments'] = $this->MRestBranch->getLatestComments($restid, 1, 5);
            $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];
            $firstTimeLogin = $this->session->userdata('firstTimeLogin');
            $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
            if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                $data['profilecompletionstatus'] = $profilecompletionstatus;
            } elseif ($profilecompletionstatus['profilecompletion'] < 5) {
                $data['profilecompletionstatus'] = $profilecompletionstatus;
                $data['firstTimeLogin'] = TRUE;
            }
            $data['gelary_images'] =  $this->rest_model->getRestGalaryImages(rest_id());

            $data['main'] = 'home';
            $data['home'] = 'home';
            $data['total_comments'] =  intval($this->MRestBranch->getCountComments($restid));
            $data['total_diners'] =  intval($this->MRestBranch->getCountDiners($restid));

            $YearsChart = $this->db->distinct()->select('YEAR(created_at) as year')
                                    ->where('rest_ID', $restid)
                                    ->order_by('year','DESC')
                                    ->get('analytics')
                                    ->result();
            
            $years_chart = [] ;
            foreach ($YearsChart as $value) {
                $years_chart[] = $value->year;
            }
            $data['YearsChart'] = $years_chart;
    
            $data['side_menu'] = array("home");
            $this->layout->view('home', $data);
        }
    }

    public function visitors_chart()
    {
        $year ='';
        if ($this->input->post('year')) {
            $year = $this->input->post('year');
        }

        $TotalVisits =  $this->getVisitNew( "", $year, rest_id());
        $EnglishVisits = $this->getVisitNew( 'en', $year, rest_id());
        $ArabicVisits = $this->getVisitNew( 'ar', $year, rest_id());
        
        // dd($years_chart);
        
        $total_visits = $english_visits = $arabic_visits = [];
        
        for ( $i = 1; $i <= 12; $i++) { 
            $month_visitor = $month_visitor_en = $month_visitor_ar = 0;
            
            foreach ($TotalVisits as $t) {
                
                if ( $i == intval($t->month)) {
                    $month_visitor = intval($t->total) ;
                }
            }
            $total_visits[] = $month_visitor;
            
            foreach ($EnglishVisits as $t) {
                
                if ( $i == intval($t->month)) {
                    $month_visitor_en = intval($t->total) ;
                }
            }
            $english_visits[] = $month_visitor_en;
            
            foreach ($ArabicVisits as $t) {
                
                if ( $i == intval($t->month)) {
                    $month_visitor_ar = intval($t->total) ;
                }
            }
            $arabic_visits[] = $month_visitor_ar;
        }

        $data = array(
            'TotalVisits' => $total_visits,
            'EnglishVisits' => $english_visits,
            'ArabicVisits' => $arabic_visits
        );

            $data =  json_encode($data);
        

        // dd($data);
        echo($data);
    }

    public function getVisitNew( $lang = "", $y = '', $rest_id = null) {
        $ana = $this->db->select('count(id) total,MONTH(created_at) month');
        
        if (!empty($y)) {
            $year = $y;
        } else {
            $year =  date("Y");
        }
        
        $date_from = date("$year-01-01");
        $date_to = date("$year-21-31");
        
        $this->db->where("created_at >=", $date_from);
        $this->db->where("created_at <=", $date_to);

        if (!empty($lang)) {
            $this->db->where('lang', $lang);
        }
        
        if (!empty($rest_id)) {
            $this->db->where('rest_ID', $rest_id);
        }
        $this->db->group_by('month');
        return $this->db->get('analytics')->result();
    }

    public function set_language($lang)
    {

        if ($lang == 'arabic' or $lang == 'english') {
            $this->session->set_userdata('lang', $lang);
        } else {
            $this->session->set_userdata('lang', 'arabic');
        }

        redirect($_SERVER["HTTP_REFERER"]);
    }
    public function comments()
    {
        $limit = 5000;
        $ajax = 0;
        $offset = 0;
        if (isset($_GET['ajax']) && ($_GET['ajax'] != "")) {
            $ajax = ($_GET['ajax']);
        }
        if (isset($_GET['per_page']) && ($_GET['per_page'] != "")) {
            $offset = ($_GET['per_page']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }

        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['limit'] = $limit;
        $data['per_page'] = $offset;

        $config['base_url'] = base_url() . 'home/comments?limit=' . $limit;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['uri_segment'] = 4;
        $config['num_links'] = 4;
        $config['first_link'] = '<--';
        $config['first_tag_open'] = '<a href="#">';
        $config['first_tag_class'] = '</a>';
        $config['last_link'] = '-->';
        $config['anchor_class'] = 'class="ajax-pagination-link"';
        $config['full_tag_open'] = '<div class="pagination ajax-pagination table-results" id="table-results">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class="active"><a href="javascript:void(0);" >';
        $config['cur_tag_close'] = '</a></span>';
        $config['total_rows'] = $data['total'] = $this->MRestBranch->getCountLatestComments($restid);

        $this->pagination->initialize($config);

        $data['latestcomments'] = $latestcomments = $this->MRestBranch->getLatestComments($restid, 1, $limit, $offset);

        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];

        $data['main'] = 'comments';
        $data['side_menu'] = array("customer_comments");
        $this->layout->view('comments', $data);
    }
    public function usercommentstatus()
    {
        if (isset($_GET['id']) && ($_GET['id'] != "")) {
            $id = $_GET['id'];
        }
        $cuisine = $this->MRestBranch->getRestaurantComment($id);
        if ($cuisine['review_Status'] == 1) {
            $this->MRestBranch->deActivateRestComment($id);
            $msg = lang('comment_deactive');
            returnMsg("success", 'home/comments', $msg);
        } else {
            $this->MRestBranch->activateRestComment($id);
            $this->MGeneral->addUserActivity($cuisine['user_ID'], $cuisine['rest_ID'], "Commented on", 'تم الرفع الصورة ل', $id);
            //  $this->commentsNotification($id, $cuisine['user_ID'], $cuisine['rest_ID'], $cuisine['review_Msg']);

            $msg = lang('comment_activeted');
            returnMsg("success", 'home/comments', $msg);
        }
    }

    public function userUploads()
    {
        $limit = 50000000;
        $ajax = 0;
        $offset = 0;
        if (isset($_GET['ajax']) && ($_GET['ajax'] != "")) {
            $ajax = ($_GET['ajax']);
        }
        if (isset($_GET['per_page']) && ($_GET['per_page'] != "")) {
            $offset = ($_GET['per_page']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }

        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['limit'] = $limit;
        $data['per_page'] = $offset;

        $config['base_url'] = base_url() . 'home/userUploads?limit=' . $limit;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['uri_segment'] = 4;
        $config['num_links'] = 4;
        $config['first_link'] = '<--';
        $config['first_tag_open'] = '<a href="#">';
        $config['first_tag_class'] = '</a>';
        $config['last_link'] = '-->';
        $config['anchor_class'] = 'class="ajax-pagination-link"';
        $config['full_tag_open'] = '<div class="pagination ajax-pagination table-results" id="table-results">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class="active"><a href="javascript:void(0);" >';
        $config['cur_tag_close'] = '</a></span>';
        $config['total_rows'] = $data['total'] = $this->MRestBranch->getTotalLatestUploads($restid);
        $this->pagination->initialize($config);

        $data['latestUserUpload'] = $this->MRestBranch->getLatestUploads($restid, 1, $limit, $offset);

        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];
        $data['side_menu'] = array("gallery", "user_photo");

        $data['main'] = 'useruploads';
        $this->layout->view('useruploads', $data);
    }

    public function usergallerystatus()
    {
        if (isset($_GET['id']) && ($_GET['id'] != "")) {
            $id = $_GET['id'];
        }
        $msg = '';
        $cuisine = $this->MRestBranch->getUserGalleryImage($id);

        $rest = $restid = $this->session->userdata('rest_id');
        $permissions = $this->MBooking->restPermissions($restid);
        if ($permissions['accountType'] == 0 && $cuisine['user_ID'] != "") {

            returnMsg("error", "accounts", lang('gallry_plan_error'));
        }

        if ($cuisine['status'] == 1) {
            $this->MRestBranch->deActivateUserGalleryImage($id);
            $msg = lang('img_deactive_message');
        } else {
            $this->MRestBranch->activateUserGalleryImage($id);
            $msg = lang('img_active_message');
        }
        $this->MRestBranch->updateRest($rest);
        if (isset($_GET['ref'])) {
            returnMsg("success", 'home/userUploads?limit=' . $_GET['limit'] . '&per_page=' . $_GET['per_page'], $msg);
        } else
            returnMsg("success", 'home/userUploads', $msg);
    }



    public function ratings()
    {
        $limit = 20;
        $ajax = 0;
        $offset = 0;
        if (isset($_GET['ajax']) && ($_GET['ajax'] != "")) {
            $ajax = ($_GET['ajax']);
        }
        if (isset($_GET['per_page']) && ($_GET['per_page'] != "")) {
            $offset = ($_GET['per_page']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }

        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $config['base_url'] = base_url() . 'home/ratings?limit=' . $limit;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['uri_segment'] = 4;
        $config['num_links'] = 4;
        $config['first_link'] = '<--';
        $config['first_tag_open'] = '<a href="#">';
        $config['first_tag_class'] = '</a>';
        $config['last_link'] = '-->';
        $config['anchor_class'] = 'class="ajax-pagination-link"';
        $config['full_tag_open'] = '<div class="pagination ajax-pagination table-results" id="table-results">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class="active"><a href="javascript:void(0);" >';
        $config['cur_tag_close'] = '</a></span>';
        $config['total_rows'] = $data['total'] = $this->MRestBranch->getCountLatestRatings($restid);
        $this->pagination->initialize($config);

        $data['getlates'] = $this->MRestBranch->getLatestRatings($restid, 1, $limit, $offset);

        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];

        $data['main'] = 'ratings';
        $this->load->view('template', $data);
    }

    public function login()
    {
        $this->lang->load('english', 'english');
        $redirect = "";
        if (isset($_GET['redirect']) && ($_GET['redirect'] != "")) {
            $redirect = $_GET['redirect'];
        }
        $data['redirect'] = $redirect;
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $this->MGeneral->getLogo();
        $data['js'] = "validate";
        $this->load->view('login', $data);
    }

    public function forgot()
    {
        $redirect = "";
        if (isset($_GET['redirect']) && ($_GET['redirect'] != "")) {
            $redirect = $_GET['redirect'];
        }
        $data['redirect'] = $redirect;
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $this->MGeneral->getLogo();
        $data['js'] = "validate,jequery-ui";
        $this->load->view('forgot', $data);
    }

    function login_form_submit()
    {
        $user = ($this->input->post('User'));
        $password = ($this->input->post('Password'));
        // var_dump($user,$password);
        $userinfrom = $this->MBooking->memeberAccountStatus($user, $password);
       
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;
        $logo = $this->MGeneral->getLogo();
        $this->email->initialize($config);

        if (empty($userinfrom)) {
            $this->session->set_flashdata('error', 'Please Give Valid User Name and Password');
            redirect("home/login");
        } else {
            if ($userinfrom['status'] == 0) {
                $this->session->set_flashdata('error', 'Your account is not active. Please contact at <a href="mailto:info@azooma.co">info@azooma.co</a> ');
                redirect("home/login");
            }

            $data = array();
            $data['user'] = $user;
            $data['password'] = $password;
            $rows = $this->MGeneral->memberinfo($data['user']);
            if (empty($rows) || !is_array($rows)) {
                $this->session->set_flashdata('error', 'Your account is deleted. Please contact at <a href="mailto:info@azooma.co">info@azooma.co</a> ');
                redirect("home/login");
            }
            $restdata = $this->MGeneral->getRest($rows['rest_id'], false, true);
            if (empty($restdata) || !is_array($restdata)) {
                $this->session->set_flashdata('error', 'Your account is deleted. Please contact at <a href="mailto:info@azooma.co">info@azooma.co</a> ');
                redirect("home/login");
            }
            if ($restdata['rest_Status'] == 0) {
                $this->session->set_flashdata('error', 'Your account is not active. Please contact at <a href="mailto:info@azooma.co">info@azooma.co</a> ');
                redirect("home/login");
            }
            $accDura = $this->MGeneral->accountDuration($rows['rest_id']);
            $firstlogin = $this->MGeneral->firstLogin($rows['id_user']);
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['sitename'] = $this->MGeneral->getSiteName();
            $data['logo'] = $this->MGeneral->getLogo();

            if ($firstlogin == TRUE) {
                $firstTime_user_data = array(
                    'firstTimeLogin' => TRUE,
                    'id_booking_id_user' => $rows['id_user']
                );
                $this->session->set_userdata($firstTime_user_data);

                $firstlog = TRUE;
                $data['rows'] = $rows;
                $data['restaurant'] = $restdata;
                $data['restname'] = stripslashes($rows['rest_Name']);
                $data['restnameAr'] = stripslashes($rows['rest_Name_Ar']);
                $this->load->library('parser');
                if ($_POST['language'] == 1) {
                    $msg = $this->parser->parse('mails/firstLoginAr', $data, true);
                } else {
                    $msg = $this->parser->parse('mails/firstLogin', $data, true);
                }
                $subject = stripslashes($rows['rest_Name']) . " has started managing his profile";
                $this->email->from("admin@azooma.co", "Azooma.co");
                $this->email->to("info@azooma.co");
                $lists = array('sales@azooma.co', 'data@azooma.co', 'kareem@primedigiko.com');
                $this->email->cc($lists);
                $this->email->bcc('admin@azooma.co', 'ha@azooma.co');
                $this->email->subject($subject);
                $this->email->message($msg);
                $this->email->send();
            } else {
                $firstlog = FALSE;
            }

            if ($restdata['is_account_expire'] == 1) {
                $this->session->set_flashdata('error', 'Your account is Expired. Please contact at <a href="mailto:info@azooma.co">info@azooma.co</a>');
                redirect("home/login");
            }

            $this->MGeneral->insertlogin($rows['id_user']);
            if ($accDura['date_upd'] == "") {
                $dateadd = strtotime($accDura['date_add']);
                $dur = $rows['member_duration'];
                $dateadd = strtotime("+" . $dur . " months", $dateadd);
                $expireDate = date("Y-m-d", $dateadd);
            } else {
                $dateadd = strtotime($accDura['date_upd']);
                $dur = $rows['member_duration'];
                $dateadd = strtotime("+" . $dur . " months", $dateadd);
                $expireDate = date("Y-m-d", $dateadd);
            }

            if (($expireDate == Date("Y-m-d")) && ($dur > 0)) {
                //Update account to free and send email to client
                $this->MGeneral->addMemberDeatilsLog($rows['rest_id']);
                $updatacc = $this->MGeneral->updateAccount($rows['rest_id']);
                $upddur = $this->MGeneral->updateDuration($rows['rest_id']);

                $data['restname'] = $rows['rest_Name'];
                $data['settings'] = $settings = $this->MGeneral->getSettings();
                $data['logo'] = $this->MGeneral->getLogo();

                $this->load->library('parser');
                $msg = $this->parser->parse('mails/accountExpired', $data, true);
                $emaillist = explode(",", $rows['email']);
                $subject = "Your Account Expired at Azooma.co";

                $this->email->from("info@azooma.co", "Azooma.co");
                $this->email->to($emaillist);
                $this->email->subject($subject);
                $this->email->message($msg);
                $this->email->send();

                $this->email->from("notifications@azooma.co", "Azooma ");
                $this->email->to("info@azooma.co");
                $this->email->subject($subject);
                $this->email->message($msg);
                $this->email->send();

                $this->session->set_flashdata('error', 'Your account is Expired. Please contact at <a href="mailto:info@azooma.co">info@azooma.co</a>');
                redirect("home/login");
            }
            $user_data = array(
                'fullname' => $rows['full_name'],
                'restuser' => $data['user'],
                'id_user' => $rows['id_user'],
                'language' => $_POST['language'],
                'rest_id' => $rows['rest_id'],
                'firstlogin' => $firstlog,
                'logged_in' => TRUE,
                "lang"=>(post('language')==1 ? "arabic" :"english"),
               

            );
            $this->session->set_userdata($user_data);
            if (isset($_POST['remember_me']) && post('remember_me') == 'on') {
                setcookie('remember_me_user_name',post('User'));
                setcookie('remember_me_password',post('Password'));
                setcookie('remember_me',post('remember_me'));
               
                redirect('home');
            } else {
                setcookie('remember_me_user_name',null);
                setcookie('remember_me_password',null);
                setcookie('remember_me',null);
                unset($_COOKIE['remember_me_user_name']);
                unset($_COOKIE['remember_me_password']);
                unset($_COOKIE['remember_me']);
                redirect('home');
            }
        }
    }

    function logout()
    {
        if ($this->session->userdata('restuser') != '') {
            $this->session->unset_userdata('restuser');
        }
        redirect('home/login');
    }

    function logo()
    {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];

        $data['main'] = 'logo';
        $this->layout->view('logo', $data);
    }

    function savelogo()
    {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        if ($this->input->post('rest_ID')) {
            if (is_uploaded_file($_FILES['rest_Logo']['tmp_name'])) {
                $logo = $this->image_upload('rest_Logo', '../uploads/logos/', 'default_logo.gif');
                if ($logo != 'default_logo.gif') {
                    /* $this->load->library('images');
                    $this->images->resize('../uploads/logos/' . $logo, 130, 130, '../uploads/logos/' . $logo);
                    $this->images->squareThumb('../uploads/logos/' . $logo, '../uploads/logos/thumb/' . $logo, 30);
                    $this->images->squareThumb('../uploads/logos/' . $logo, '../uploads/logos/45/' . $logo, 45);
                    $this->images->squareThumb('../uploads/logos/' . $logo, '../uploads/logos/40/' . $logo, 40);*/
                }
            } else {
                $logo = ($this->input->post('rest_Logo_old'));
            }
            $this->MRestBranch->updateLogo($logo, $restid);
            $firstTimeLogin = $this->session->userdata('firstTimeLogin');
            if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                $restid = $this->session->userdata('rest_id');
                $uuserid = $this->session->userdata('id_user');
                $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
                if ($profilecompletionstatus['profilecompletion'] == 3) {
                    $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 4);
                }
            }
            returnMsg("success", 'home',  post('rest_Name') . lang('logo_updated'));
        } else {

            returnMsg("error", 'home/logo',lang('proccess_error'));
        }
    }

    function password()
    {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];
        $data['js'] = 'validate';
        $data['main'] = 'password';
        $this->layout->view('password', $data);
    }

    function savepassword()
    {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        if ($this->input->post('rest_ID')) {
            $memInfo = $this->MBooking->getMemmberAccountDetails($uuserid);
            if ($_POST['current_password'] != $memInfo['password']) {
                $this->session->set_flashdata('error', 'The current password you entered is wrong. Please enter correct password.');
                redirect("home/password");
            } else {
                $this->MBooking->changePassword($uuserid);

                returnMsg("success", "home", post('rest_Name') . ' Your Password updated successfully');
            }
        } else {

            returnMsg("error", 'home/password', 'Some error happened Please try again');
        }
    }

    public function response($userid, $reviewID)
    {
        $restid = $this->session->userdata('rest_id');
        $permissions = $this->MBooking->restPermissions($restid);
        $sub_detail_permissions = explode(',', $permissions['sub_detail']);
        if (true or in_array(14, $sub_detail_permissions)) {
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['sitename'] = $this->MGeneral->getSiteName();
            $data['logo'] = $logo = $this->MGeneral->getLogo();
            $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

            $data['comment'] = $comment = $this->MRestBranch->getUserComment($userid, $reviewID);
            $data['user_info'] = $user_info = $this->MRestBranch->getUser($userid);
            if ($user_info['user_NickName'] != "") {
                $data['User_Name'] = $user_info['user_NickName'];
            } else {
                $data['User_Name'] = $user_info['user_FullName'];
            }
            $data['pagetitle'] = $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];
            $data['js'] = 'validate';
            $data['main'] = 'response';
            $data['title'] = lang('reply');
            $data['side_menu'] = array("customer_comments");

            $this->layout->view('response', $data);
        } else {
            returnMsg("error", "accounts", lang('comment_reply_plan'));
        }
    }



    public function sendresponse()
    {
        $user_ID = $_POST['user_ID'];
        $restid = $_POST['rest_ID'];
        $msg = '';
        $review_ID = $_POST['review_ID'];
        if ((isset($user_ID) && !empty($user_ID)) && (isset($restid) && !empty($restid))) {
            $this->MRestBranch->savecommentreply($user_ID);
            $user_info = $this->MRestBranch->getUser($user_ID);
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['sitename'] = $this->MGeneral->getSiteName();
            $data['logo'] = $logo = $this->MGeneral->getLogo();
            $data['rest'] = $rest = $this->MGeneral->getRest($restid, false, true);

            $this->load->library('email');
            $config['charset'] = 'utf-8';
            $config['mailtype'] = 'html';
            $config['wordwrap'] = TRUE;
            $this->email->initialize($config);
            $restaurantComment = $this->MRestBranch->getRestaurantComment($review_ID);

            if ($restaurantComment['review_Status'] == 1) {
                $link = "<a href='" . $this->config->item('sa_url') . 'rest/' . $rest['seo_url'] . "#comment-" . $review_ID . "'>comment</a>";
            } else {
                $link = "comment";
            }
            $completemsg = '"' . $_POST['replymsg'] . '"';
            $data['msg'] = $completemsg;
            $data['link'] = $link;
            $name = "";
            if ($user_info['user_NickName'] != "") {
                $name = $user_info['user_NickName'];
            } else {
                $name = $user_info['user_FullName'];
            }
            $data['name'] = $name;
            $data['title'] = lang('comments_reply');
            $data['restname'] = stripslashes($rest['rest_Name']);
            $msg = $this->load->view('mails/restResponse', $data, true);
            $subject = stripslashes($rest['rest_Name']) . " ".lang('repy_subject');
            $this->email->from("info@azooma.co", "Azooma.co");
            $this->email->to($user_info['user_Email']);
            $this->email->bcc($this->config->item("teamemails"));
            $this->email->subject($subject);
            $this->email->message($msg);
            $this->email->send();
            $msg = lang('email_r_sent');
            returnMsg("success", 'home/comments', $msg);
        } else {

            $msg = lang('proccess_error');
            returnMsg("error", 'home/comments', $msg);
        }
        if (isset($_POST['ref'])) {
            //    redirect('home/comments?limit=' . $_POST['limit'] . '&per_page=' . $_POST['per_page']);
        } else
            redirect('home');
    }

    function image_upload($name, $dir, $default = 'no_image.jpg')
    {
        $uploadDir = $dir;
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $filename = $_FILES[$name]['name'];
            $filename = str_replace(' ', '_', $filename);
            $uploadFile_1 = uniqid('azooma') . $filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
                $image_name = $uploadFile_1;
            else
                $image_name = $default;
        } else
            $image_name = $default;
        return $image_name;
    }

    function commentsNotification($user_activity_id = 0, $user_id = 0, $rest_id = 0, $review_Msg)
    {
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);

        $userInfo = $this->MRestBranch->getUser($user_id);
        $rest = $this->MGeneral->getRest($rest_id, false, true);
        $allusers = $this->MGeneral->getAllUsersCommentedOnRest($user_id, $rest_id);

        $sufratiUser = array();
        $sufratiUser[] = "info@azooma.co";
        $sufratiUser[] = "data@azooma.co";
        $sufratiUser[] = "fasil@azooma.co";

        $username = $userInfo['user_NickName'];
        if ($username == "") {
            $username = $userInfo['user_FullName'];
        }


        $data = array();
        $data['logo'] = $this->MGeneral->getLogo();
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['user'] = $userInfo;
        $data['rest'] = $rest;
        $data['title'] = "Commented on " . $rest['rest_Name'];
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['review_Msg'] = $review_Msg;
        $data['user_activity_id'] = $user_activity_id;
        $msgtouser = $this->load->view('mails/commentNotifyuser', $data, true);
        $this->email->from('info@azooma.co', "Azooma.co");
        $this->email->message($msgtouser);
        if (is_array($userInfo) && $userInfo['user_Status'] == 1) {
            if ($this->MGeneral->checkNotificationStatus($user_id)) {
                $this->email->to($userInfo['user_Email']);
                $this->email->subject('Your Comment on ' . $rest['rest_Name'] . ' is Approved - Azooma.co');
                $this->email->send();
            }
        }

        if (is_array($allusers)) {

            foreach ($allusers as $user) {
                $otheruserInfo = "";
                $otheruserInfo = $this->MRestBranch->getUser($user['user_ID']);
                if (is_array($otheruserInfo) && $otheruserInfo['user_Status'] == 1) {
                    if ($this->MGeneral->checkNotificationStatus($user['user_ID'])) {
                        $data['user'] = "";
                        $data['user'] = $otheruserInfo;
                        $data['commentUser'] = $username;
                        $msgtootheruser = $this->load->view('mails/commentNotifyotheruser', $data, true);
                        $this->email->message($msgtootheruser);

                        $this->email->subject($username . ' Commented on ' . $rest['rest_Name'] . ' - Azooma.co');
                        $this->email->to($otheruserInfo['user_Email']);
                        $this->email->send();
                    }
                }
            }
        }

        if ($rest['rest_Email'] != "") {
            //send email to rest
            $data = array();
            $data['logo'] = $this->MGeneral->getLogo();
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['user'] = $userInfo;
            $data['rest'] = $rest;
            $data['title'] = "Commented on " . $rest['rest_Name'];
            $data['sitename'] = $settings['name'];
            $data['review_Msg'] = $review_Msg;
            $data['user_activity_id'] = $user_activity_id;
            $msgtorest = $this->load->view('mails/commentNotifyRest', $data, true);
            $this->email->from('info@azooma.co', "Azooma.co");
            $this->email->to($rest['rest_Email']);

            $this->email->bcc($sufratiUser);

            //            foreach( $sufratiUser as  $sufratiemail){
            //                $this->email->bcc($sufratiemail);
            //            }

            $this->email->subject($username . ' Commented on ' . $rest['rest_Name'] . ' at www.azooma.co');
            $this->email->message($msgtorest);
            $this->email->send();
        }
    }

    public function restpassword()
    {
        
        if ($_POST['user_email'] == "" || $_POST['user_name'] == "") {
            $this->session->set_flashdata('error', 'Please Enter user Name and Your Email Address.');
            redirect("home/forgot");
        }
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $rest_name = trim(post('rest_name'));
        //        $rest_data=$this->MGeneral->getRestByName($rest_name);
        //        if(empty($rest_data) || ! is_array($rest_data)){
        //            $this->session->set_flashdata('error', 'Restaurant Name is not correct. Please enter correct.');
        //            redirect("home/forgot");
        //        }
        $rest_info = Smart::get_table_info("booking_management","*",array("user_name"=>post("user_name")),false);
        if (empty($rest_info)) {
            $this->session->set_flashdata('error', 'User Name is not correct. Please enter correct.');
            redirect("home/forgot");
        }
        $rest_id=$rest_info->rest_id;
        $admindata = $this->MGeneral->getAdminDetails($_POST['user_email'], $rest_id);
        if (empty($admindata)) {
            $this->session->set_flashdata('error', 'Your email is not correct. Please enter correct email.');
            redirect("home/forgot");
        } else {
            $data['username'] = $admindata['user_name'];
            $data['restname'] = $admindata['rest_Name'];
            $data['password'] = $admindata['password'];

            $email = explode(',', $admindata['email']);

            $msg = $this->load->view('mails/password', $data, true);

            $sufratiUser = array();
            $sufratiUser[] = "info@azooma.co";
            $sufratiUser[] = "data@azooma.co";
            $sufratiUser[] = "fasil@azooma.co";

            $this->email->from('info@azooma.co', 'Azooma.co');
            $this->email->to($email);
            $this->email->bcc('passwords@azooma.co');
            $this->email->subject('Your admin password at Azooma');
            $this->email->message($msg);
            $this->email->send();

            $this->email->from('info@azooma.co', 'Azooma.co');
            $this->email->to($sufratiUser);
            $this->email->subject('Restaurant updated his admin password at Azooma');
            $this->email->message($msg);
            $this->email->send();
            $this->session->set_flashdata('message', 'Password is reset successfully. Please check your email for your password.');
            redirect('home/login');
        }
    }

    function suggest($var = "")
    {
        $this->load->library('sphinxclient');
        $offset = 0;
        $limit = 6;

        $this->sphinxclient->SetServer("localhost", 9312);
        $this->sphinxclient->SetMatchMode(SPH_MATCH_BOOLEAN);

        $q = ($_GET['term']);

        //Restaurants
        $this->sphinxclient->setLimits($offset, $limit);
        $this->sphinxclient->setSortMode(SPH_SORT_ATTR_DESC, "rest_viewed");
        $restin = $this->sphinxclient->Query($q . '*', 'restfull');
        if (!empty($restin["matches"])) {
            $restresults = $restin['total'];
            //$data['resttotal']=$restresults;
            foreach ($restin["matches"] as $doc => $docinfo) {
                $restaurants[] = $doc;
            }
            if (count($restaurants) > 0) {
                $restaurants = join(',', $restaurants);
                $restq = "SELECT rest_Name,rest_Name_Ar,restaurant_info.rest_ID FROM restaurant_info,booking_management WHERE booking_management.rest_id = restaurant_info.rest_ID  AND restaurant_info.rest_ID in ($restaurants)";
                $query = $this->db->query($restq);
                $restaurants = $query->result_Array();
            }
        } else {
            //Restaurants Soundex
            $this->sphinxclient->setLimits($offset, $limit);
            $this->sphinxclient->setSortMode(SPH_SORT_ATTR_DESC, "rest_viewed");
            $restin = $this->sphinxclient->Query($q, 'rest');
            if (!empty($restin["matches"])) {
                $restresults = $restin['total'];
                $data['resttotal'] = $restresults;
                foreach ($restin["matches"] as $doc => $docinfo) {
                    $restaurants[] = $doc;
                }
                if (count($restaurants) > 0) {
                    $restaurants = join(',', $restaurants);
                    $restq = "SELECT rest_Name,rest_Name_Ar,restaurant_info.rest_ID FROM restaurant_info,booking_management WHERE booking_management.rest_id = restaurant_info.rest_ID  AND restaurant_info.rest_ID in ($restaurants)";
                    $query = $this->db->query($restq);
                    $restaurants = $query->result_Array();
                }
            }
        }
        $output = json_encode($restaurants);
        $this->output->set_content_type('application/json');
        $this->output->set_output($output);
    }

    function readComment($id = 0)
    {
        $this->MGeneral->readUserComment($id);
    }

    function readPhoto($id = 0)
    {
        $this->MGeneral->readUserPhoto($id);
    }

    function readRating($id = 0)
    {
        $this->MGeneral->readUserRating($id);
    }
}
