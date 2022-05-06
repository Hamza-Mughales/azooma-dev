<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Accounts extends MY_Controller
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mgeneral', "MGeneral");
        $this->load->model('Mbooking', "MBooking");
        $this->load->model('Mrestbranch', "MRestBranch");
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if ($this->session->userdata('restuser') == '') {
            redirect('home/login');
        }
    }

    function index($item = 0)
    {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings =  $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['pagetitle'] = $data['title'] = "Account Details - " . (htmlspecialchars($data['rest']['rest_Name']));
        $data['member'] =  $this->MRestBranch->getAccountDetails($rest);
       $data['subscription']=Smart::get_table_info("subscription","*",array("rest_ID"=>rest_id()),false);
        $data['js'] = 'validate';
        $data['side_menu'] = array("account", "upgrade_accounts");
        $this->layout->view('account', $data);
    }

    function save()
    {
        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);

        $restid = $this->session->userdata('rest_id');
        $id_user = $this->session->userdata('id_user');
        $data['settings'] = $settings =  $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restinfo = $this->MGeneral->getRest($restid, false, true);

        $restType = $this->MGeneral->getRestType($restinfo['rest_type']);
        $emailList = $this->MRestBranch->getMemberEmail($id_user);
        $email = explode(',', $emailList['email']);
        $rest = ucwords($restinfo['rest_Name']) . " Resturant";

        if ($this->input->post('preset') == 0) {
            $account = "Bronze";
        } elseif ($this->input->post('preset') == 1) {
            $account = "Silver";
        } else {
            $account = "Gold";
        }

        $data['restname'] = $restinfo['rest_Name'];
        $data['resttype'] = $restType['name'];
        $data['account'] = $account;
        $data['duration'] = $this->input->post('duration');
        $data['msg'] = $this->input->post('msg');
        $data['referenceNo'] = $emailList['referenceNo'];
        $data['fullname'] = $emailList['full_name'];
        $data['logo'] = $logo;
        $data['phone'] = $emailList['phone'];
        $data['reqdate'] = date('d-m-Y');
        $data['emailList'] = $email;
        $data['addservices'] = $this->input->post('addservices');

        $sufratiUser = array();
        $sufratiUser[] = "info@azooma.co";
        $sufratiUser[] = "data@sufrati.com";
        $sufratiUser[] = "fasil@sufrati.com";
        $sufratiUser[] = "kareem@primedigiko.com";

        $this->session->unset_userdata('account');
        $this->session->unset_userdata('duration');
        $this->session->unset_userdata('msg');
        $this->session->unset_userdata('addservices');
        $user_data_account = array(
            'account'       => $account,
            'duration'      => $this->input->post('duration'),
            'msg'           => $this->input->post('msg'),
            'addservices'   => $this->input->post('addservices')
        );
        $this->session->set_userdata($user_data_account);


        $msg = $this->load->view('mails/PreSetAccount', $data, true);
        $subject = ucwords($restinfo['rest_Name']) . " Resturant Upgrade Account Request";
        $this->email->from($email[0], $restinfo['rest_Name']);
        $this->email->to($sufratiUser);
        $this->email->subject($subject);
        $this->email->message($msg);
        $this->email->send();

        returnMsg("success", "success", 'Thank you for your request. One of our sales team members will contact you soon.');
    }
    public function set_plan($id)
    {
        $data = array();
        if ($id == 1) {
            $data['accountType'] = 1;
            $data['sub_detail'] = '4,9,16,11,17,14,15,13,12';
            $data['allowed_messages'] = 100000000;
        } else {
            $data['accountType'] = 0;
            $data['sub_detail'] = 1;
            $data['allowed_messages'] = 50;
        }
        $check = Smart::get_table_info("subscription", "*", array("rest_ID" => rest_id()));
        if (empty($check)) {
            $data['date_add'] = date("Y-m-d H:i:s");
            $data['country'] = 1;
            $data['rest_ID'] = rest_id();
            Smart::insert("subscription", $data);
        }
        else{
          
            Smart::update("subscription", $data,array("rest_ID"=>rest_id()));
        }
     
        returnMsg("success", "accounts", 'Thank you for your request.Your plan changed successfuly. One of our sales team members will contact you soon.');

    }
}
