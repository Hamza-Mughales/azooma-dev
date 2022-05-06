<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


/**
 * SmartLife Path Helper
 *
 * @package        CodeIgniter
 * @subpackage    Tools
 * @category    Helpers
 * @author        Arafat Thabet <arafat.733011506@gmail.com>
 */


if (!function_exists("files_path")) {
    function files_path()
    {
        //$ci=get_instance();
        //$upload_url=$ci->config->item('upload_url');
        return '../uploads/';
        return "files/";
    }
}
if (!function_exists("menu_path")) {
    function menu_path()
    {
        $path = files_path() . ' menu/';
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
if (!function_exists("menu_pdf_path")) {
    function menu_pdf_path()
    {
        $path = files_path() . ' menu/menu_pdf/';
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
/**
 *
 * return system files  path 
 *
 * @return    string
 */

if (!function_exists("app_files_url")) {
    function app_files_url()
    {

        $ci = get_instance();
        $app_files_url = $ci->config->item('app_files_url');
        return $app_files_url;
    }
}

if (!function_exists("gallery_files_path")) {
    function gallery_files_path()
    {
        $path = files_path() . ' Gallery/';
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
if (!function_exists("offer_files_path")) {
    function offer_files_path()
    {
        $path = files_path() . 'images/offers/';
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