<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MyDiners extends MY_Controller
{

    public $data;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Mbooking',"MBooking");
        $this->load->model('Mrestbranch',"MRestBranch");
        $this->load->library('pagination');
        $this->load->library('images');
        Smart::model("DinersModel");
        //$this->output->enable_profiler(true);
        if ($this->session->userdata('restuser') == '') {
            redirect('home/login');
        }

        #audienceType
        #   1=> Single Diner
        #   2=> All Diners
        #   3=> Selected Diners
        #
    }

    function index()
    {
        $sortby = "";
        if (isset($_GET['sortby']) && !empty($_GET['sortby'])) {
            $sortby = $_GET['sortby'];
        }
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
    
      
        $data['total_diner'] = $this->DinersModel->getTotalDiners($restid, 1);
        $data['pagetitle'] = $data['title'] = lang('my_diner');
        $data['member'] = $this->MRestBranch->getAccountDetails($rest);

        $data['js'] = 'member,validate';
        $data['main'] = 'customers';
        $data['sortby'] = $sortby;
        $data['side_menu'] = array("mydiners","index");

        $this->layout->view('customers', $data);
    }

    function sendMessage()
    {
        $rest = $restid = $this->session->userdata('rest_id');
        $data['member'] = $member = $this->MRestBranch->getAccountDetails($rest);
        if ($member['allowed_messages'] > 0) {
        } else {
            $this->session->set_flashdata('message',lang('my_diner_plan_error'));
            returnMsg("error","accounts",lang('my_diner_plan_error'));
        }
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $sitename = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['likedpeople'] = $this->MRestBranch->getLikeUsers($restid);
      
        $data['diners'] = $this->DinersModel->getAllMyDiners();
        $user_ID = 0;
        $type = 0;
        $title = "";
        if (isset($_REQUEST['user_ID']) && !empty($_REQUEST['user_ID'])) {
            $user_ID = ($_REQUEST['user_ID']);
            $user = $this->MRestBranch->getUser($user_ID);
            $data['user'] = $user;
            $type = 1;
            $title = "Send Message to ";
            $title .= $user['user_NickName'] == "" ? $user['user_FullName'] : $user['user_NickName'];
        } else {
            $type = 2;
            $title = "Send Message";
        }
        $data['audienceType'] = $type;
        $data['pagetitle'] = $title;
        $data['title'] = lang('my_diner_title') . $sitename;

        $data['js'] = 'member,validate,charCount';
        $data['main'] = 'messagediner';
        $data['side_menu'] = array("mydiners","sendMessage");

        $this->layout->view('messagediner', $data);
    }

    function savemessage()
    {
     
        if ($this->input->post('subject')) {
            $rest = $restid = $this->session->userdata('rest_id');
            $rest_data = $this->MGeneral->getRest($restid, false, true);
            $member = $this->MRestBranch->getAccountDetails($rest);
            if ($member['allowed_messages'] > 0) {
                $image = "";
                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $image = $this->upload_image('image', 'images/');
                    list($width, $height, $type, $attr) = getimagesize('images/' . $image);
                    if ($width < 200 && $height < 200) {
                        $msg= lang('img_upload_size_error');
                        returnMsg("error","mydiners/sendMessage",$msg);
                    }
                    if (($width > 800) || ($height > 500)) {
                        $this->images->resize('images/' . $image, 640, 500, 'images/' . $image);
                    }
                    $this->images->squareThumb('images/' . $image, 'images/thumb/' . $image, 100);
                } else {
                    if (isset($_POST['image_old'])) {
                        $image = ($this->input->post('image_old'));
                    }
                }
                if ($this->input->post('id')) {
                    $id = $this->input->post('id');
                    $messageData = $this->MRestBranch->getDinerMessage($id);
                    $total_receiver = 0;
                    if (isset($_POST['user_ID']) && !empty($_POST['user_ID'])) { //SINGLE USER
                        $total_receiver = 1;
                        $user_ID = ($_POST['user_ID']);
                        $this->MRestBranch->updateDinerMessage($id, $rest, $total_receiver, $user_ID, $image);
                    } else {
                        $audienceType = $this->input->post('audienceType');
                        if ($audienceType == 3) {
                            $receivers = $this->input->post('diners');
                            $total_receiver = count($receivers);
                            $receivers = implode(",", $receivers);
                            $this->MRestBranch->updateDinerMessage($id, $rest, $total_receiver, $receivers, $image);
                        } else {
                            $likedpeople = $this->MRestBranch->getLikeUsers($restid, 0, "", "", $audienceType);
                            $total_receiver = count($likedpeople);
                            $this->MRestBranch->updateDinerMessage($id, $rest, $total_receiver, '', $image);
                        }
                    }
                    if ($messageData['status'] == 0) {
                        redirect('mydiners/view/' . $id);
                    } else {
                        $msg= lang('saved_msg_done');
                        returnMsg("success","mydiners/sendMessage",$msg);
                    }
                } else {
                    $id = 0;
                    $rest = $restid = $this->session->userdata('rest_id');
                    if (isset($_POST['user_ID']) && !empty($_POST['user_ID'])) { //SINGLE USER
                        $total_receiver = 1;
                        $user_ID = ($_POST['user_ID']);
                        $id = $this->MRestBranch->addDinerMessage($rest, $total_receiver, $user_ID, $image);
                    } else {
                        $audienceType = $this->input->post('audienceType');
                        $audienceType = $this->input->post('audienceType');
                        if ($audienceType == 3) {
                            $receivers = $this->input->post('diners');
                            $total_receiver = count($receivers);
                            $receivers = implode(",", $receivers);
                            $id = $this->MRestBranch->addDinerMessage($rest, $total_receiver, $receivers, $image);
                        } else {
                            $likedpeople = $this->MRestBranch->getLikeUsers($restid, 0, "", "", $audienceType);
                            $total_receiver = count($likedpeople);
                            $id = $this->MRestBranch->addDinerMessage($rest, $total_receiver, '', $image);
                        }
                    }
                    redirect('mydiners/view/' . $id);
                }
            } else {
                $this->session->set_flashdata('message', lang('diner_msg_error_plan'));
                returnMsg("error","accounts",lang('diner_msg_error_plan'));

                //returnMsg("success","mydiners/sendMessage",$msg);

            }
        }
    }

    function dinermessages()
    {
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $rest = $restid = $this->session->userdata('rest_id');
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);

        $data['pagetitle'] = $data['title'] = lang("all_messages");
        $data['member'] = $this->MRestBranch->getAccountDetails($rest);
        $data['messages'] = $this->MRestBranch->getAllDinerMessages($rest);
        $data['total'] = count($data['messages']);
        $data['main'] = 'viewmessages';
        $data['side_menu'] = array("mydiners","dinermessages");

        $this->layout->view('viewmessages', $data);
    }

    function view($id)
    {
        if (!empty($id)) {
            $rest = $restid = $this->session->userdata('rest_id');
            $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
            $data['event'] = $messageData = $this->MRestBranch->getDinerMessage($id);
            //$likedpeople = $this->MRestBranch->getLikeUsers($restid, 0, "", "", $audienceType);
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['sitename'] = $this->MGeneral->getSiteName();
            $data['logo'] = $logo = $this->MGeneral->getLogo();
            $data['action'] = "11";
            $data['title'] = "Diner Message";
            $this->load->view('mails/dinermessage', $data);
        } else {
            show_404();
        }
    }

    function edit($id)
    {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $sitename = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['member'] = $this->MRestBranch->getAccountDetails($rest);
        $data['diners'] = $this->DinersModel->getAllMyDiners();

        if (!empty($id)) {
            $diner = "";
            $data['event'] = $messageData = $this->MRestBranch->getDinerMessage($id);
            $data['likedpeople'] = $this->MRestBranch->getLikeUsers($restid);
            $diner = $messageData['audienceType'];
            $title = "";
            $type = "";
            if ($diner == "1") {
                $user_ID = $messageData['recipients'];
                $user = $this->MRestBranch->getUser($user_ID);
                $data['user'] = $user;
                $type = 1;
                $title = "Edit Message to ";
                $title .= $user['user_NickName'] == "" ? $user['user_FullName'] : $user['user_NickName'];
            } else {
                $type = 1;
                $title = "Edit Message ";
            }
            $data['audienceType'] = $type;
            $data['pagetitle'] = $title;
            $data['title'] = "Prepare Message for Dinner's | " . $sitename;

            $data['js'] = 'member,validate,charCount';
            $data['main'] = 'messagediner';
            $this->layout->view('messagediner', $data);
        } else {
            show_404();
        }
    }

    function send($id)
    {
     
        if (!empty($id)) {
            $data['settings'] = $settings = $this->MGeneral->getSettings();
            $data['sitename'] = $this->MGeneral->getSiteName();
            $data['logo'] = $logo = $this->MGeneral->getLogo();
            $rest = $restid = $this->session->userdata('rest_id');
            $member = $this->MRestBranch->getAccountDetails($rest);
            if ($member['allowed_messages'] > 0) {
                $data['event'] = $messageData = $this->MRestBranch->getDinerMessage($id);
                $audiences = $this->MRestBranch->getLikeUsers($restid, "", $messageData['audienceType'], $messageData['recipients']);
                $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
                $data['title'] = $subject = stripslashes($messageData['subject']);
                $data['sitename'] = $settings['name'];
                $siteemail = $data['settings']['email'];
                $config['charset'] = 'utf-8';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;

                $this->load->library('email');
                $this->email->initialize($config);
                $this->email->from($settings['email'], $settings['name']);
                $counter = 0;
                $names = array();
                $emaillist = array();
                $ids = array();
               
              $to_emails=$this->DinersModel->getToList($id);
                $newsLetterMsg = $this->load->view('mails/dinermessage', $data, true);
                ignore_user_abort(true);
                set_time_limit(0);
                   $this->load->helper("email_message_helper");
                   sendSysMail($to_emails,$newsLetterMsg,$subject);
       

                $this->MRestBranch->updateSendStatusDinerMessage($id);
                $allowed_messages = $member['allowed_messages'];
                $allowed_messages = $allowed_messages - 1;
                $this->MRestBranch->updateAllowedMessage($rest, $allowed_messages);
           
         
                returnMsg("success",'mydiners/dinermessages',lang('send_msg_done'));
            } else {
                $this->session->set_flashdata('message', lang('diner_msg_error_plan'));
                returnMsg("error",'accounts',lang('diner_msg_error_plan'));

            }
        } else {
            show_404();
        }
    }

    function upload_image($name, $dir, $default = 'no_image.jpg')
    {
        $uploadDir = $dir;
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $filename = $_FILES[$name]['name'];
            $filename = str_replace(' ', '_', $filename);
            $uploadFile_1 = uniqid('azooma') . $filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            $fileName = $_FILES[$name]['name'];
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
                $image_name = $uploadFile_1;
            else
                $image_name = $default;
        } else
            $image_name = $default;

        return $image_name;
    }
    /**
     *
     * Return ediners mployees grid list 
     * HTML helper functions get_emp_list_action()
     * @access    public
     * @params  [filter data array , count row true or false]
     * @return    json
     */
    public function get_diners_grid_filter()
    {


        $_content = array();
        $count = true;


        
        $data['lang'] = sys_lang();
        $get_data = get();
        Smart::model("DinersModel");
        $_POST["sSortDir_0"] = "asc";
        $_POST["iSortCol_0"] = 1;
        $count = $this->DinersModel->getDinersList($get_data, true);
        $diner_list = $this->DinersModel->getDinersList($get_data);
        $card_data = '';

        $total_rate = 0;
        foreach ($diner_list as $v) :


            $card_input_data = $v;
            $follower=$this->DinersModel->countUserFollowers($card_input_data->user_ID);
            $other_data['follower']=$follower;
            $other_data['reviews']=$this->DinersModel->countUserReviews($card_input_data->user_ID);
            $card_data .= $this->diner_card($card_input_data,$other_data);


        endforeach;
        $total_records = intval($count->count);
        $offset = intval($_POST['iDisplayStart']);
        returnJson(["data" => $card_data, "total_records" => $total_records, "offset" => $offset]);
    }
    private function diner_card($card_data,$other_data=array()){
        $remoteFile =app_files_url(). 'images/'.$card_data->image;
        $upload_url=$this->config->item('upload_url');
       $handle = file_exists($upload_url.'images/'.$card_data->image);
        $img=        $handle ? app_files_url().'images/'.$card_data->image: base_url("images/user-default.svg");
        $html='';
        $sa_url=$this->config->item('sa_url');
 
        $html.='<div class="col-md-6 col-lg-3 box-col-6">
        <div class="card custom-card p-0">
            <div class="card-profile"><img class="rounded-circle" src="'.$img.'" alt=""></div>
            <div class="text-center profile-details">
            <h5>'.$card_data->user_FullName.'</h5>
            <h6>'.$card_data->city_name." ".($card_data->user_Country ?  " ,".$card_data->user_Country:'').'</h6>
            </div>
            <div class="card-footer row">
                <div class="col-6">
                    <h6>'.lang('followers').'</h6>
                    <h5 class="counter">'.$other_data['follower'].'</h5>
                </div>
                <div class="col-6">
                    <h6>'.lang('reviews').'</h6>
                    <h5><span class="counter">'.$other_data['reviews'].'</span></h5>
                </div>
            
            </div>
            <div class="card-footer row">
                <div class="col-6">
                <a class="text-dark" title="'.lang('send_msg').'" href="'.base_url('mydiners/sendMessage?user_ID=' . $card_data->user_ID).'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </a>
                </div>
            
                <div class="col-6">
                <a class="text-dark" title="'.lang('view').'" href="'.$sa_url.'user/' . $card_data->user_ID.'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>                </a>
                </div>
            </div>
        </div>
    </div>';
    return $html;
    }
    function does_url_exists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
}
