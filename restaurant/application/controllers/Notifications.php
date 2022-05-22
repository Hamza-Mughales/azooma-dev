<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notifications extends MY_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Notification');
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == ''){
            redirect('home/login');
        }
    }
	
    public function index()
    {
        
        $restid=$this->session->userdata('rest_id');
        $rest_notifs = $this->Notification->get_notification($restid);
        
        
        $restdata = $this->MGeneral->getRest($restid,false,true);
        $data['pagetitle'] = $data['title'] = (htmlspecialchars($restdata['rest_Name']))." - Notifications ";
        $data['tableheading'] = '';
        
        $data['notifications'] = $rest_notifs;
        $data['main'] = 'notifications';
        $data['side_menu'] = array("menu", "index");
        $data['notification_model'] = $this->Notification;
        
        
        $this->db->where(['status' => 1,'rest_ID' => $restid]);
        $up = $this->db->update('notifications',['status'=> 0]);

        $this->layout->view('notification', $data);
    }
}