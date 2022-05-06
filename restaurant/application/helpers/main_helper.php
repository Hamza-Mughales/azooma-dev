<?php
if(!function_exists("css_path")){
 function css_path(){
     return "css/new_css/";
 }
}
if(!function_exists("js_path")){
    function js_path(){
        return "js/new_js/";
    }
   }
   if(!function_exists("loggedin")){
    function loggedin(){
        $ci=get_instance();
        if ($ci->session->userdata('restuser') == '') {
            return false;
        }
        else{
            return true;
        }
    }
   }
   if (!function_exists('message_box')) {
    function message_box($message_type)
    {
      
        $CI =get_instance();

       $message ='';
   
       $message=$CI->session->flashdata("$message_type");
       $retval='';
        if($message){
       
            $lang_type=lang($message_type);
            $retval.="<script>  $(document).ready(function() {
                (function ($) {Swal.fire(
                ' $lang_type!',
                '$message',
                '$message_type'
            );    }(jQuery));});</script>";
        }
            return $retval;
        }
    }

    if (!function_exists('returnMsg')){
        function returnMsg($type,$uri, $message)
        {
            $CI =get_instance();
            $CI->session->set_flashdata($type, $message);
            if (!$uri) {
                $uri = get_instance()->config->site_url(get_instance()->uri->uri_string());
    
            }
            if (!empty($uri)) {
                redirect($uri);
              
            }
            return false;
        }
    }
    /**
 *
 * get nav menu page  active 
 * @params
 * [$menu  = menu var ]
 * [$menu_name  = menu link name ]
 * @return  bool
 */
if (!function_exists("menu")) {
    function menu($menu, $menu_name)
    {

        if ($menu && in_array($menu_name, $menu)) :
            return true;
        else :
            return false;
        endif;
    }
}
/**
 *
 * return current language of user
 *
 * @access    public
 * @return    String
 */
if (!function_exists("sys_lang")) {
    function sys_lang()
    {
        $CI = &get_instance();
        $lang = $CI->session->userdata('lang');
       
        
        if (!$lang) {
            $lang = "english";
        }
        return $lang;
    }
}

// ------------------------------------------------------------------------
/**
 *
 * Return Get Header Value
 *
 * @return    Variant
 */

if (!function_exists("get")) {
    function get($val = false)
    {
        return get_instance()->input->get($val);
    }
}
// ------------------------------------------------------------------------
/**
 *
 * Return POST Header Value
 *
 * @return    Variant
 */

if (!function_exists("post")) {
    function post($val = false)
    {
        return get_instance()->input->post($val);
    }
}
// ------------------------------------------------------------------------
/**
 *
 * Return rest id 
 *
 * @return    int
 */

if (!function_exists("rest_id")) {
    function rest_id()
    {
        return get_instance()->session->userdata('rest_id');
    }
}
// ------------------------------------------------------------------------
/**
 *
 * Return rest info 
 *
 * @return    int
 */

if (!function_exists("rest_info")) {
    function rest_info()
    {
        return Smart::get_table_info("restaurant_info","*",array("rest_ID"=>rest_id()),false);
    }
}
/**
 *
 * Return this_user id 
 *
 * @return    int
 */

if (!function_exists("this_user")) {
    function this_user()
    {
        return get_instance()->session->userdata('id_user');
    }
}

/**
 *
 * Return Json  array output
 *
 * @return    Json Array
 */

if (!function_exists("returnJson")) {
    function returnJson($data = array())
    {
        header_remove();
        http_response_code(200);
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Status: 200');
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
        exit();
    }
}
/**
 *
 * Return site email 
 *
 * @return    string
 */

if (!function_exists("site_email")) {
    function site_email()
    {
      return "info@azooma.co"; 
    }
}
