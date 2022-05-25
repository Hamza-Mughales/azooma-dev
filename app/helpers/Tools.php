<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

if (!function_exists('css_path')) {
    function css_path()
    {
        return 'new_css/';
    }
}

if (!function_exists('js_path')) {
    function js_path()
    {
        return 'new_js/';
    }
}

if (!function_exists('menu')) {
    function menu($menu, $menu_name)
    {
        if ($menu && in_array($menu_name, $menu))
            return true;

        return false;
    }
}

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        return View::make($view, $data);
    }
}

if (!function_exists('__')) {
    function __($key)
    {
        return trans($key);
    }
}

if (!function_exists('collect')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection
     */
    function collect($value = null)
    {
        return new Collection($value);
    }
}
if (!function_exists('adminCountry')) {
    function adminCountry()
    {

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = [1];
            return $country;
        }
        $country=explode(',',$country);
        return $country;
        
    }
}

if (!function_exists('message_box')) {
    function message_box($message_type)
    {
       $message ='';
       $message=Session::get("$message_type");
       $retval='';
        if($message){
            $lang_type=__("$message_type");
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

    /**
     * @param string $type [error or success]
     * @param string $route
     * @param string $message
     * @return string
     */
    if (!function_exists('returnMsg')){
        function returnMsg($type,$route, $message, $param = [])
        {
         
            Session::flash($type, $message);
            if (!$route) {
            return  Redirect::route('adminhome');
    
            }
            if (!empty($route)) {
                return  Redirect::route($route, $param);
              
            }
            return false;
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
        return  Input::get("$val");
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
        if(Input::has($val))
        return  Input::get("$val");
        else
        return '';
    }
}
// ------------------------------------------------------------------------
/**
 *
 * Return old input Value
 *
 * @return    string
 */

if (!function_exists("old")) {
    function old($val = false)
    {
        return  Input::old($val);
     
    }
}

if(!function_exists('upload_url')){
    function upload_url($path=''){
       return Config::get('settings.uploadurl').$path;
    }
}
if (!function_exists("menu_pdf_path")) {
    function menu_pdf_path()
    {
        $path = './uploads/menu/menu_pdf/';
        if (!is_dir($path)) :
            mkdir($path, 0777, true);
            $fileContent = '';
            $fileName = 'index.html';
            $filePath = $path . $fileName;

            file_put_contents($filePath, $fileContent);
        endif;
        return $path;
    }
}
if (!function_exists("countryName")) {
    function countryName($id)
    {
        $id=intval($id);
          $country= DB::table('aaa_country')->where('id','=',$id)->first();
          return isset($country->name) ? $country->name :'';
    }
}
if (!function_exists("cityName")) {
    function cityName($id)
    {
        $id=intval($id);

          $country= DB::table('city_list')->where('city_ID','=',$id)->first();
          return isset($country->city_Name) ? $country->city_Name :'';
    }
}