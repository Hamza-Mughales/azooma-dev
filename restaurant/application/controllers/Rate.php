<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rate extends MY_Controller
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mgeneral', "MGeneral");
        $this->load->model('Mbooking', "MBooking");
        $this->load->model('Mrestbranch', "MRestBranch");
        $this->load->model('RestModel', "RestModel");
    }
    public function index()
    {
        $data['rates'] = $this->RestModel->getRestRatings(rest_id());
        $data['title']=lang('ratings');
        $data['side_menu']=array('ratings');
        $this->layout->view("rating", $data);
    }
}
