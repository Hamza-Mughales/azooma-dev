<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == '')
        {
                redirect('home/login');
        }
    }
    
    function index($item=0){
        
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['pagetitle']=$data['title']="تعديل إعدادات حسابك - ".(htmlspecialchars($data['rest']['rest_Name_Ar']));
        $data['member']=  $this->MRestBranch->getAccountDetails($rest);
        
        $data['css']='ar';
        $data['js']='member,validate';
        $data['main']='ar/settings';
        $this->load->view('ar/template',$data);
    }
    
    function save(){
        if($this->input->post('rest_ID')){
            $restid=$this->session->userdata('rest_id');
            $rest=$restdata=$this->MGeneral->getRest($restid,false,true);
            $member= $this->MRestBranch->getAccountDetails($rest['rest_ID']);
            $this->MRestBranch->updateMemberContacts();
            $this->session->set_flashdata('message',(htmlspecialchars($rest['rest_Name'])).' Account contact details updated');
            redirect('ar/settings');
        }else{
            $this->session->set_flashdata('error','Some error occured, Pleas try again.');
            redirect('ar/settings');
        }
    }
  
}