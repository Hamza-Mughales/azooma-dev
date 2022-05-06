<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Success extends MY_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Mbooking',"MBooking");
        $this->load->model('Mrestbranch',"MRestBranch");
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
       
    }
    
    function index($item=0){
        $account=$restid=$this->session->userdata('account');
        if(!isset($account) || $account==""){
            redirect('accounts');
        }
        
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['pagetitle']=$data['title']="Upgrade account success - ".(htmlspecialchars($data['rest']['rest_Name']));
        $data['member']=  $this->MRestBranch->getAccountDetails($rest);
        
        $data['js']='validate';
        $data['main']='success';
        $data['side_menu'] = array("accounts");
        $this->layout->view('success',$data);
    }
    
}