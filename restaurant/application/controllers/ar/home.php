<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    public $data;

    function __construct() {
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->model('Mgeneral',"MGeneral");

        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
    }

    public function index() {
        if ($this->session->userdata('restuser') == '') {
            redirect('home/login');
        } else {
            $restid = $this->session->userdata('rest_id');
            $uuserid = $this->session->userdata('id_user');
            $permissions = $this->MBooking->restPermissions($restid);
            $permissions = explode(',', $permissions['sub_detail']);
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['sitename'] = $this->MGeneral->getSiteName();
            $data['logo'] = $logo = $this->MGeneral->getLogo();
            $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

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
            $data['favourite'] = $this->MRestBranch->getFavourites($restid);
            $data['comments'] = $this->MRestBranch->getTotalComments($restid);
            $lastlogin = $this->MGeneral->getLastLogin($uuserid);
            $data['newcomments'] = $this->MRestBranch->getTotalNewComments($restid, $lastlogin);
            $data['newphotos'] = $this->MRestBranch->getTotalNewPhotos($restid, $lastlogin);
            $data['recommendations'] = $this->MRestBranch->getTotalRecommendation($restid, $lastlogin);
            $data['recommendations'] = $this->MRestBranch->getTotalRecommendation($restid, $lastlogin);
            $data['latestRatings'] = $this->MRestBranch->getTotalNewRatingsNew($restid, $lastlogin);
            $data['getlates'] = $this->MRestBranch->getLatestRatings($restid, 1, 5);
            $data['activities'] = $this->MRestBranch->getActivities($uuserid, 5);
            $data['latestUserUpload'] = $this->MRestBranch->getLatestUploads($restid, 1, 5);
            $data['latestcomments'] = $this->MRestBranch->getLatestComments($restid, 1, 5);
            $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
            $firstTimeLogin = $this->session->userdata('firstTimeLogin');
            $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
            if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                $data['profilecompletionstatus'] = $profilecompletionstatus;
            } elseif ($profilecompletionstatus['profilecompletion'] < 5) {
                $data['profilecompletionstatus'] = $profilecompletionstatus;
                $data['firstTimeLogin'] = TRUE;
            }
            $data['main'] = 'ar/home';
            $data['css'] = 'ar';
            $data['home'] = 'ar/home';
            $this->load->view('ar/template', $data);
        }
    }

    public function comments() {
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

        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['limit'] = $limit;
        $data['per_page'] = $offset;

        $config['base_url'] = base_url() . 'ar/home/comments?limit=' . $limit;
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

        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
        $data['css'] = 'ar';
        $data['main'] = 'ar/comments';
        $this->load->view('ar/template', $data);
    }

    public function usercommentstatus() {
        if (isset($_GET['id']) && ($_GET['id'] != "")) {
            $id = $_GET['id'];
        }
        $cuisine = $this->MRestBranch->getRestaurantComment($id);
        if ($cuisine['review_Status'] == 1) {
            $this->MRestBranch->deActivateRestComment($id);
            $this->session->set_flashdata('message', 'إلغاء تفعيل تعليق بنجاح ');
        } else {
            $this->MRestBranch->activateRestComment($id);
            $this->MGeneral->addUserActivity($cuisine['user_ID'], $cuisine['rest_ID'], "تعليق على", 'تم الرفع الصورة ل', $id);
            $this->commentsNotification($id, $cuisine['user_ID'], $cuisine['rest_ID'], $cuisine['review_Msg']);
            $this->session->set_flashdata('message', ' تفعيل تعليق بنجاح ');
        }
        if (isset($_GET['ref'])) {
            redirect('ar/home/comments?limit=' . $_GET['limit'] . '&per_page=' . $_GET['per_page']);
        }else
            redirect('ar/home');
    }

    public function userUploads() {
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
        $data['limit'] = $limit;
        $data['per_page'] = $offset;

        $config['base_url'] = base_url() . 'ar/home/userUploads?limit=' . $limit;
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

        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
        $data['css'] = 'ar';
        $data['main'] = 'ar/useruploads';
        $this->load->view('ar/template', $data);
    }

    public function usergallerystatus() {
        if (isset($_GET['id']) && ($_GET['id'] != "")) {
            $id = $_GET['id'];
        }
        $cuisine = $this->MRestBranch->getUserGalleryImage($id);

        $rest = $restid = $this->session->userdata('rest_id');
        $permissions = $this->MBooking->restPermissions($restid);
        if ($permissions['accountType'] == 0 && $cuisine['user_ID'] != "") {
            $this->session->set_flashdata('error', 'حزمة الخاص بك لا تحتوي على هذا العرض. الرجاء ترقية الحزمة الخاصة بك');
            redirect('ar/accounts');
        }

        if ($cuisine['status'] == 1) {
            $this->MRestBranch->deActivateUserGalleryImage($id);
            $this->session->set_flashdata('message', 'إلغاء تفعيل الصورة بنجاح');
        } else {
            $this->MRestBranch->activateUserGalleryImage($id);
            $this->session->set_flashdata('message', 'تفعيل الصورة بنجاح');
        }
        $this->MRestBranch->updateRest($rest);
        if (isset($_GET['ref'])) {
            redirect('ar/home/userUploads?limit=' . $_GET['limit'] . '&per_page=' . $_GET['per_page']);
        }else
            redirect('ar/home');
    }

    public function activities() {
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

        $config['base_url'] = base_url() . 'ar/home/activities?limit=' . $limit;
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
        $config['total_rows'] = $data['total'] = $this->MRestBranch->getCountActivities($uuserid);
        $this->pagination->initialize($config);

        $data['activities'] = $this->MRestBranch->getActivities($uuserid, $limit, $offset);

        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
        $data['css'] = 'ar';
        $data['main'] = 'ar/activities';
        $this->load->view('ar/template', $data);
    }

    public function ratings() {
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

        $config['base_url'] = base_url() . 'ar/home/ratings?limit=' . $limit;
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

        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
        $data['css'] = 'ar';
        $data['main'] = 'ar/ratings';
        $this->load->view('ar/template', $data);
    }

    public function login() {
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

    function logout() {
        if ($this->session->userdata('restuser') != '') {
            $this->session->sess_destroy();
        }
        redirect('home/login');
    }

    function logo() {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
        $data['css'] = 'ar';
        $data['main'] = 'ar/logo';
        $this->load->view('ar/template', $data);
    }

    function savelogo() {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        if ($this->input->post('rest_ID')) {
            if (is_uploaded_file($_FILES['rest_Logo']['tmp_name'])) {
                $logo = $this->image_upload('rest_Logo', '../uploads/logos/', 'default_logo.gif');
                if ($logo != 'default_logo.gif') {
                    $this->load->library('images');
                    $this->images->resize('../uploads/logos/' . $logo, 130, 130, '../uploads/logos/' . $logo);
                    $this->images->squareThumb('../uploads/logos/' . $logo, '../uploads/logos/thumb/' . $logo, 30);
                    $this->images->squareThumb('../uploads/logos/' . $logo, '../uploads/logos/45/' . $logo, 45);
                    $this->images->squareThumb('../uploads/logos/' . $logo, '../uploads/logos/40/' . $logo, 40);
                }
            } else {
                $logo = ($this->input->post('rest_Logo_old'));
            }
            $this->MRestBranch->updateLogo($logo, $restid);
            $this->session->set_flashdata('message', $_POST['rest_Name'] . ' تحديث شعار بنجاح');
            redirect('ar/home');
        } else {
            $this->session->set_flashdata('error', 'حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/home/logo');
        }
    }

    function password() {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
        $data['css'] = 'ar';
        $data['js'] = 'validate';
        $data['main'] = 'ar/password';
        $this->load->view('ar/template', $data);
    }

    function savepassword() {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        if ($this->input->post('rest_ID')) {
            $memInfo = $this->MBooking->getMemmberAccountDetails($uuserid);
            if ($_POST['current_password'] != $memInfo['password']) {
                $this->session->set_flashdata('error', 'كلمة السر التي أدخلتها غير صحيحة. من فضلك ادخل كلمة السر الصحيحة ');
                redirect("home/password");
            } else {
                $this->MBooking->changePassword($uuserid);
                $this->session->set_flashdata('message', $_POST['rest_Name_Ar'] . ' تم تحديث كلمة السر الخاصة بك بنجاح ');
                redirect('ar/home');
            }
        } else {
            $this->session->set_flashdata('error', 'حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/home/password');
        }
    }

    public function response($userid, $reviewID) {
        $restid = $this->session->userdata('rest_id');
        $permissions = $this->MBooking->restPermissions($restid);
        $sub_detail_permissions = explode(',', $permissions['sub_detail']);
        if (in_array(14, $sub_detail_permissions)) {
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
            $data['pagetitle'] = $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar'])) . " - " . $settings['nameAr'];
            $data['js'] = 'validate';
            $data['css'] = 'ar';
            
            $data['main'] = 'ar/response';
            $this->load->view('ar/template', $data);
        } else {
            $this->session->set_flashdata('error', 'عفوا اشتراكك الحالى لايسمح لك بالرد  اشترك معنا الان لسامح لك استخدام هذي الخاصية اضغط هنا للحصول على مزيد من الاستفسار');
            redirect('ar/accounts');
        }
    }

    public function sendresponse() {
        $user_ID = $_POST['user_ID'];
        $restid = $_POST['rest_ID'];
        $review_ID = $_POST['review_ID'];
        if (isset($user_ID) && !empty($user_ID)) {
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
            $data['restname'] = stripslashes($rest['rest_Name']);

            $msg = $this->load->view('mails/restResponse', $data, true);
            $subject = stripslashes($rest['rest_Name']) . " replied to your comment on azooma.co";
            $this->email->from("info@azooma.co", "Azooma.co");
            $this->email->to($user_info['user_Email']);   
            $this->email->bcc($this->config->item("teamemails"));
            $this->email->subject($subject);
            $this->email->message($msg);
            $this->email->send();
            $this->session->set_flashdata('message', 'Your email has been sent to User.');
        } else {
            $this->session->set_flashdata('error', 'Some error occurred, Please try again.');
        }
        if (isset($_POST['ref'])) {
            redirect('ar/home/comments?limit=' . $_POST['limit'] . '&per_page=' . $_POST['per_page']);
        }else
            redirect('ar/home');
    }

    function image_upload($name, $dir, $default = 'no_image.jpg') {
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
        }
        else
            $image_name = $default;
        return $image_name;
    }

    function commentsNotification($user_activity_id = 0, $user_id = 0, $rest_id = 0, $review_Msg) {
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
        $msgtorest = $this->load->view('mails/commentNotifyuser', $data, true);
        $this->email->from('info@azooma.co', "Azooma.co");
        $this->email->message($msgtorest);
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
            foreach ($sufratiUser as $sufratiemail) {
                $this->email->bcc($sufratiemail);
            }
            $this->email->subject($username . ' Commented on ' . $rest['rest_Name'] . ' at www.azooma.co');
            $this->email->message($msgtorest);
            $this->email->send();
        }
    }

    function readComment($id = 0) {
        $this->MGeneral->readUserComment($id);
    }

    function readPhoto($id = 0) {
        $this->MGeneral->readUserPhoto($id);
    }

    function readRating($id = 0) {
        $this->MGeneral->readUserRating($id);
    }

}