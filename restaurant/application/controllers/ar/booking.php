<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Booking extends CI_Controller {
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
	
    public function index()
    {
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);

        $data['pagetitle'] = $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar']))." -  الحجوزات ";
        $data['css']='ar';
        $data['main']='ar/booking';
        $this->load->view('ar/template',$data);
    }
}