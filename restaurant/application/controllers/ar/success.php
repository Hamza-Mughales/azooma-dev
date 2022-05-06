<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Success extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == ''){
            redirect('home/login');
        }
    }
    
    function index($item=0){
        $account=$restid=$this->session->userdata('account');
        if(!isset($account) || $account==""){
            redirect('ar/accounts');
        }
        
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['pagetitle']=$data['title']="ترقية حسابك - ".(htmlspecialchars($data['rest']['rest_Name_Ar']));
        $data['member']=  $this->MRestBranch->getAccountDetails($rest);
        
        $data['js']='validate';
        $data['css']='ar';
        $data['main']='ar/success';
        $this->load->view('ar/template',$data);
    }
    
}