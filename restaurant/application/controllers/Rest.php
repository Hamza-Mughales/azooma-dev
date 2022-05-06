<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rest extends MY_Controller
{
    public $data;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mgeneral', "MGeneral");
        $this->load->model('Mrestbranch', "MRestBranch");

    }


public function activities()
    {
        $limit = 50000000;
        $ajax = 0;
        $offset = 0;
     

        $restid = rest_id();
        $uuserid = $this->session->userdata('id_user');

        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);



        $data['activities'] = $this->MRestBranch->getActivities($uuserid, $limit, $offset);

        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];

        $data['main'] = 'activities';
        $this->layout->view('activities', $data);
    }
}