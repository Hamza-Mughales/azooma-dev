<?php

//session_start();

/**
 * Description of MY_Controller
 *
 * @author Trescoder
 */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
      
      $sys_lang=$this->session->userdata("lang");
      if($sys_lang=='arabic' or $sys_lang=='english'){
       $this->lang->load($sys_lang,  $sys_lang);
      }
      else{
          $this->session->set_userdata('lang', 'arabic'); 
          $this->lang->load('arabic', 'arabic');
      }
  
        if (loggedin() != true) {
            redirect('home/login');
        }
    }
 

}