<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Layout {

    public function view($view, $data = array()) {
        $ci = get_instance();

        $view_data['subview'] = $view;
    
        $view_data = array_merge($view_data, $data);
        
        //$ci->load->view('employee/layout/index', $view_data);
        $ci->load->view('layout/index', $view_data);
    }


}