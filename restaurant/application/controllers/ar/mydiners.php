<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MyDiners extends CI_Controller {

    public $data;

    function __construct() {
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->library('pagination');
        $this->load->library('images');
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

    function index() {
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

        $data['likedpeople'] = $this->MRestBranch->getLikeUsers($restid, $sortby);
        $data['totallikedpeople'] = $this->MRestBranch->getLikePercentage($restid, 1);
        $data['pagetitle'] = $data['title'] = "عملائي";
        $data['member'] = $this->MRestBranch->getAccountDetails($rest);

        $data['js'] = 'member,validate';
        $data['css'] = 'ar';
        $data['main'] = 'ar/customers';
        $data['sortby'] = $sortby;
        $this->load->view('ar/template', $data);
    }

    function sendMessage() {
        $rest = $restid = $this->session->userdata('rest_id');
        $data['member'] = $member = $this->MRestBranch->getAccountDetails($rest);
        if ($member['allowed_messages'] > 0) {
            
        } else {
            $this->session->set_flashdata('message', 'You have already used your allowed messages, Please contact us if you want to send more.');
            redirect('accounts');
        }
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $sitename = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['likedpeople'] = $this->MRestBranch->getLikeUsers($restid);
        $user_ID = 0;
        $type = 0;
        $title = "";
        if (isset($_REQUEST['user_ID']) && !empty($_REQUEST['user_ID'])) {
            $user_ID = ($_REQUEST['user_ID']);
            $user = $this->MRestBranch->getUser($user_ID);
            $data['user'] = $user;
            $type = 1;
            $title = "ارسل رسالة ";
            $title .= $user['user_NickName'] == "" ? $user['user_FullName'] : $user['user_NickName'];
        } else {
            $type = 2;
            $title = "ارسل رسالة";
        }
        $data['audienceType'] = $type;
        $data['pagetitle'] = $title;
        $data['title'] = "Prepare Message for Dinner's | " . $sitename;

        $data['js'] = 'member,validate,charCount';
        $data['css'] = 'ar';
        $data['main'] = 'ar/messagediner';
        $this->load->view('ar/template', $data);
    }

    function savemessage() {
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
                        $this->session->set_flashdata('error', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                        redirect("ar/mydiners/sendMessage");
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
                            $receivers = $this->input->post('msg');
                            $total_receiver = count($receivers);
                            $receivers = implode(",", $receivers);
                            $this->MRestBranch->updateDinerMessage($id, $rest, $total_receiver, $receivers, $image);
                        } else {
                            $likedpeople = $this->MRestBranch->getLikeUsers($restid, 0, "", "", $audienceType);
                            $total_receiver = count($likedpeople);
                            $this->MRestBranch->updateDinerMessage($id, $rest, $total_receiver,'',$image);
                        }
                    }
                    if ($messageData['status'] == 0) {
                        redirect('ar/mydiners/view/' . $id);
                    } else {
                        $this->session->set_flashdata('message', 'Message save save succesfully');
                        redirect('ar/mydiners/dinermessages');
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
                            $receivers = $this->input->post('msg');
                            $total_receiver = count($receivers);
                            $receivers = implode(",", $receivers);
                            $id = $this->MRestBranch->addDinerMessage($rest, $total_receiver, $receivers, $image);
                        } else {
                            $likedpeople = $this->MRestBranch->getLikeUsers($restid, 0, "", "", $audienceType);
                            $total_receiver = count($likedpeople);
                            $id = $this->MRestBranch->addDinerMessage($rest, $total_receiver,'', $image);
                        }
                    }
                    redirect('ar/mydiners/view/' . $id);
                }
            } else {
                $this->session->set_flashdata('message', 'You have already used your allowed messages, Please contact us if you want to send more.');
                redirect('ar/accounts');
            }
        }
    }

    function dinermessages() {
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $rest = $restid = $this->session->userdata('rest_id');
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);

        $data['pagetitle'] = $data['title'] = "All Messages";
        $data['member'] = $this->MRestBranch->getAccountDetails($rest);
        $data['messages'] = $this->MRestBranch->getAllDinerMessages($rest);
        $data['total'] = count($data['messages']);
        $data['css'] = 'ar';
        $data['main'] = 'ar/viewmessages';
        $this->load->view('ar/template', $data);
    }

    function view($id) {
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

    function edit($id) {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $sitename = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['member'] = $this->MRestBranch->getAccountDetails($rest);
        
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
            $data['css'] = 'ar';
            $data['main'] = 'ar/messagediner';
            $this->load->view('ar/template', $data);
        } else {
            show_404();
        }
    }

    function send($id) {
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
//                $emaillist[] = 'ha@sufrati.com';
//                $names[] = "Haroon";
//                $emaillist[] = 'aas@sufrati.com';
//                $names[] = "Amer";

                if (is_array($audiences)) {
                    foreach ($audiences as $audience) {
                        if (!empty($audience['user_Email'])) {
                            $name = "";
                            if (!empty($audience['user_NickName'])) {
                                $name = $audience['user_NickName'];
                            } else {
                                $name = $audience['user_FullName'];
                            }
                            $emaillist[] = $audience['user_Email'];
                            $names[] = $name;
                            $ids[] = $audience['user_ID'];
                            $counter++;
                        }
                    }
                }
                $newsLetterMsg = $this->load->view('mails/dinermessage', $data, true);
                $this->load->spark('personalized-email/1.0.3');
                $count = count($emaillist);
                
                /*                 * ******
                 * Directory Local --> /Users/walidsanchez/Development/Sites/sufrati/sa/Mail
                 * 
                 * Directory online --> /home/diner/public_html/sa/Mail
                 */
                $this->load->library('personalizedmailer', array(
                    'pmdatadir' => '/home/diner/public_html/sa/Mail',
                    'domain' => 'sufrati.com',
                    'silent' => TRUE
                ));

                $this->personalizedmailer->initqueue(array(
                    'addresses' => $emaillist,
                    'msgtemplate' => $newsLetterMsg,
                    'subject' => $subject,
                    'fromname' => "Sufrati Newsletter",
                    'fromaddr' => 'noreply@newsletter.sufrati.com',
                    'HTML' => true,
                    'loopdelay' => 2,
                    'varsearch' => array('[name]', '[email]', '[id]'),
                    'varreplace' => array($names, $emaillist, $ids),
                    'ciemailconfig' => array(
                        'useragent' => 'Sufrati Mailer'
                    )
                ));
                
                $this->MRestBranch->updateSendStatusDinerMessage($id);
                $allowed_messages = $member['allowed_messages'];
                $allowed_messages = $allowed_messages - 1;
                $this->MRestBranch->updateAllowedMessage($rest, $allowed_messages);
                ignore_user_abort(true);
                set_time_limit(0);
                $this->personalizedmailer->sendtolist();


                $this->session->set_flashdata('message', 'Message sent succesfully');
                redirect('mydiners/dinermessages');
            } else {
                $this->session->set_flashdata('message', 'You have already used your allowed messages, Please contact us if you want to send more.');
                redirect('accounts');
            }
        } else {
            show_404();
        }
    }
    
    function upload_image($name, $dir, $default = 'no_image.jpg') {
        $uploadDir = $dir;
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $filename = $_FILES[$name]['name'];
            $filename = str_replace(' ', '_', $filename);
            $uploadFile_1 = uniqid('sufrati') . $filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            $fileName = $_FILES[$name]['name'];
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
                $image_name = $uploadFile_1;
            else
                $image_name = $default;
        }
        else
            $image_name = $default;

        return $image_name;
    }

}
