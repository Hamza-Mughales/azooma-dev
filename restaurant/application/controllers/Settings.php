<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends MY_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Mbooking',"MBooking");
        $this->load->model('Mrestbranch',"MRestBranch");
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == '')
        {
                redirect('home/login');
        }
    }
    
    function index($item=0){
     
        $rest=$restid=$this->session->userdata('rest_id');
       $data['id_user']= $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['pagetitle']=$data['title']=lang('contact_details')." - ".(htmlspecialchars($data['rest']['rest_Name']));
        $data['member']=  $this->MRestBranch->getAccountDetails($rest);
        
        $data['js']='member,validate';
        $data['main']='settings';
        $data['side_menu'] = array("settings", "account_settings");
        $this->layout->view('settings',$data);
    }
    
    function save(){
  
        if(rest_id()){
            $restid=rest_id();
            $rest=$restdata=$this->MGeneral->getRest($restid,false,true);
            $member= $this->MRestBranch->getAccountDetails( $restid);
            $this->MRestBranch->updateMemberContacts();
            returnMsg("success",'settings',(htmlspecialchars($rest['rest_Name']))." ".lang('account_updated'));
        }else{
            returnMsg("error","settings",lang('proccess_error'));
        }
    }
  
}