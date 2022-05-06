<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menus extends MY_Controller {

    public $data;

    function __construct() {
        parent::__construct();
        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Mbooking',"MBooking");
        $this->load->model('Mrestbranch',"MRestBranch");
        $this->load->library('pagination');
        $this->load->library('images');
        //$this->output->enable_profiler(true);
        if ($this->session->userdata('restuser') == '') {
            redirect('home/login');
        }
    }

    function index($item = 0) {
        $limit = 20;
        $ajax = $offset = 0;
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['ajax']) && ($_GET['ajax'] != "")) {
            $ajax = ($_GET['ajax']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }

        if (isset($_GET['menu_id']) && ($_GET['menu_id'] != "")) {
            $menu_id = $_GET['menu_id'];
        } else {
            $menu_id = 0;
        }
        if (isset($_GET['item']) && ($_GET['item'] != "")) {
            $item = $_GET['item'];
        } else {
            $item = 0;
        }

        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['title'] = lang('menu_for')." " . (htmlspecialchars($data['rest']['rest_Name']));

        if ($item != 0) {
            $data['menus'] = $this->MRestBranch->getAllMenuItems($rest, $item);
            $data['total'] = $this->MRestBranch->getTotalMenuItems($rest, $item);
            $data['cat'] = $this->MRestBranch->getMenuCat($item);
            $data['pagetoptitle'] = lang('menu_items');
            $data['pagetitlelink'] = lang('add_menu_item');
            $data['pageview'] = "";
            $data['tmp_link'] = "";
            $data['tableheading'] = lang('item_name');
            $data['tableheadingAr'] =lang('item_name_ar');
            $data['topName'] = lang('Items');
        } elseif ($menu_id != 0) {
            $data['menus'] = $this->MRestBranch->getAllMenuCats($rest, 0, $menu_id);
            $data['total'] = $this->MRestBranch->getTotalMenuCats($rest, $menu_id);
            $data['pagetoptitle'] = lang('menu_category');
            $data['pagetitlelink'] = lang('add_menu_category');
            $data['pageview'] = lang('view_items');
            $data['tmp_link'] = "";
            $data['tableheading'] = lang('category_name');
            $data['tableheadingAr'] = lang('category_name_ar');
            $data['topName'] = lang('categories');
        } else {
            $data['menus'] = $this->MRestBranch->getAllMenu($rest);
            $data['total'] = $this->MRestBranch->getTotalMenu($rest);
            $data['pagetoptitle'] = lang('menu_types');
            $data['pagetitlelink'] =lang('add_menu_types');
            $data['pageview'] = lang('view_categories');
            $data['tmp_link'] = "";
            $data['tableheading'] = lang('menu_name');
            $data['tableheadingAr'] =  lang('menu_name_ar');
            $data['topName'] =lang('types');
        }

        $data['main'] = 'menu';
        $data['side_menu'] = array("menu", "index");
        $this->layout->view('menu', $data);
    }

    function form() {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $newFlag = TRUE;
        if (isset($_GET['menu_id']) && ($_GET['menu_id'] != "")) {
            $menu_id = $_GET['menu_id'];
        } else {
            $menu_id = 0;
        }
        if (isset($_GET['cat_id']) && ($_GET['cat_id'] != "")) {
            $cat_id = $_GET['cat_id'];
        } else {
            $cat_id = 0;
        }

        $data['permissions'] = $permissions = $this->MBooking->restPermissions($restid);
        $data['sub_detail_permissions'] = $sub_detail_permissions = explode(',', $permissions['sub_detail']);

        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        if (isset($_GET['cat']) && ($_GET['cat'] != "")) {
            $data['item'] = 1;
            $data['cat'] = $this->MRestBranch->getMenuCat($_GET['cat']);
            if (isset($_GET['item']) && ($_GET['item'] != "")) {
                $newFlag = FALSE;
                $data['menuitem'] = $this->MRestBranch->getMenuItem($_GET['item']);
                $data['title'] = $data['pagetitle'] = lang('updating_menu_item').' ' . $data['menuitem']['menu_item'];
            } else {
                $newFlag = TRUE;
                $data['pagetitle'] = lang('New').' - ' . $data['cat']['cat_name'];
            }
        } elseif (isset($_GET['menu_id']) && ($_GET['menu_id'] != "") && ( isset($_GET['cat_id']) && ( $_GET['cat_id'] != "" || $_GET['cat_id'] == "0" ) )) {
            $data['category'] = 1;
            $data['menuList'] = $this->MRestBranch->getAllMenu($rest);

            if (isset($_GET['cat_id']) && (empty($_GET['cat_id']))) {
                $newFlag = TRUE;
                $data['title'] = $data['pagetitle'] = lang('new_menu_category').' ' . (htmlspecialchars($data['rest']['rest_Name']));
            } else {
                $newFlag = FALSE;
                $data['menucat'] = $this->MRestBranch->getMenuCat($cat_id, $menu_id);
                $data['title'] = $data['pagetitle'] = lang('update_menu_category').' ' . $data['menucat']['cat_name'];
            }
        } else {
            $data['menu'] = 1;
            if ($menu_id == 0) {
                $newFlag = TRUE;
                $data['title'] = $data['pagetitle'] = lang('new_menu_type').' ' . (htmlspecialchars($data['rest']['rest_Name']));
            } else {
                $newFlag = FALSE;
                $data['menucat'] = $this->MRestBranch->getMenu($menu_id);
                $data['title'] = $data['pagetitle'] = lang('updating_menu_type').' ' . $data['menucat']['menu_name'];
            }
        }
        if ($newFlag) {
            ######PERMISSIONS#######
            $availableMenuType = 0;
            $availableMenuCats = 0;
            $availableMenuCatItems = 0;
            if ($permissions['accountType'] == 0) { ##FREE ACCOUNT
                $availableMenuType = 1;
                $availableMenuCats = 3;
                $availableMenuCatItems = 3;
            } elseif ($permissions['accountType'] == 1) { ##BRONZE ACCOUNT
                $availableMenuType = 5;
                $availableMenuCats = 100;
                $availableMenuCatItems = 100;
            } elseif ($permissions['accountType'] == 2) { ##SLIVER ACCOUNT
                $availableMenuType = 5;
                $availableMenuCats = 100;
                $availableMenuCatItems = 100;
            } elseif ($permissions['accountType'] == 3) { ##GOLD ACCOUNT
                $availableMenuType = 5;
                $availableMenuCats = 100;
                $availableMenuCatItems = 100;
            }
           
            ##MENU TYPE###
            if (isset($data['menu']) && !empty($data['menu'])) {
                $totalMenu = $this->MRestBranch->getTotalMenu($restid);
                if ($totalMenu >= $availableMenuType) {
                    $this->session->set_flashdata('error', lang('menu_type_plan_error'));
                    returnMsg("error","accounts",lang('menu_type_plan_error'));
                }
            }
         
            ##MENU CATEGORIES###
            if (isset($data['category']) && !empty($data['category'])) {
                $totalMenuCats = $this->MRestBranch->getTotalMenuCats($restid);
                if ($totalMenuCats >= $availableMenuCats) {
                    $this->session->set_flashdata('error', lang('menu_cat_plan_error'));
                    returnMsg("error","accounts",lang('menu_cat_plan_error'));
                }
            }
         
            ##MENU ITEMS###
            if (isset($data['item']) && !empty($data['item'])) {
                $totalMenuCats = $this->MRestBranch->getTotalMenuItems($restid, $data['cat']['cat_id']);
                if ($totalMenuCats >= $availableMenuCatItems) {
                    $this->session->set_flashdata('error',lang('menu_cats_plan_error'));
                    returnMsg("error","accounts",lang('menu_cats_plan_error'));
                }
            }
        }//edit flag
      
        $data['main'] = 'menuform';
        $data['js'] = 'validate';
        $data['side_menu'] = array("menu", "index");
        $this->layout->view('menuform', $data);
    }

    function save($option = "") {
        ######PERMISSIONS#######
        $msg='';
        $restid = $this->session->userdata('rest_id');
        $permissions = $this->MBooking->restPermissions($restid);
        $sub_detail_permissions = explode(',', $permissions['sub_detail']);
        $firstTimeLogin = $this->session->userdata('firstTimeLogin');
        $availableMenuType = 0;
        $availableMenuCats = 0;
        $availableMenuCatItems = 0;
        if ($permissions['accountType'] == 0) { ##FREE ACCOUNT
            $availableMenuType = 1;
            $availableMenuCats = 3;
            $availableMenuCatItems = 3;
        } elseif ($permissions['accountType'] == 1) { ##BRONZE ACCOUNT
            $availableMenuType = 5;
            $availableMenuCats = 100;
            $availableMenuCatItems = 100;
        } elseif ($permissions['accountType'] == 2) { ##SLIVER ACCOUNT
            $availableMenuType = 5;
            $availableMenuCats = 100;
            $availableMenuCatItems = 100;
        } elseif ($permissions['accountType'] == 3) { ##GOLD ACCOUNT
            $availableMenuType = 5;
            $availableMenuCats = 100;
            $availableMenuCatItems = 100;
        }
     
        if ($option == "menu") {
            $rest = $this->input->post('rest_ID');
            $rest_data = $restdata = $this->MGeneral->getRest($rest, false, true);
            $menuID = 0;
            if ($this->input->post('menu_name')) {
                if ($this->input->post('menu_id')) {
                    $menuID = $menu_id = $this->input->post('menu_id');
                    $this->MRestBranch->updateMenu();
                    $this->MRestBranch->updateRest($rest);
                    $msg= lang('m_type_updated_success');
                    $this->MGeneral->addActivity(lang('new_type_log'), $menu_id);
                } else {
                    ##MENU TYPE###
                    $totalMenu = $this->MRestBranch->getTotalMenu($restid);
                    if ($totalMenu >= $availableMenuType) {
                        $this->session->set_flashdata('error', lang('menu_type_plan_error'));
                        returnMsg("error","accounts",lang('menu_type_plan_error'));
                    }
                  
                    $menuID = $last_insert_id = $this->MRestBranch->addMenu();
                    $this->MRestBranch->updateMenuCats($rest, $last_insert_id);
                    $this->MRestBranch->updateRest($rest);
                    $msg= lang('m_type_added');
                    $this->MGeneral->addActivity(lang('new_type_log'), $last_insert_id);
                }
               
                if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                    $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                    $restid = $this->session->userdata('rest_id');
                    $uuserid = $this->session->userdata('id_user');
                    $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
                    if ($profilecompletionstatus['profilecompletion'] == 2) {
                        //$this->MGeneral->updateProfileCompletionStatus($restid,$uuserid,3);
                        $msg= lang('m_cat_added_for').' ' . $this->input->post('menu_name');
                        
                        returnMsg("success",'menus?rest=' . $rest . '&menu_id=' . $menuID,$msg);
                    }
        
                   
                }
               
                          returnMsg("success",'menus',$msg);

            } else {
                returnMsg("error",'menus',lang('proccess_error'));

            }
        
        }
        if ($option == "menucategory") {
            $rest = $this->input->post('rest_ID');
            $rest_data = $restdata = $this->MGeneral->getRest($rest, false, true);
            $cat_name = $this->input->post('cat_name');
            if ($this->input->post('cat_name')) {
                $catID = 0;
                $menuID = $cat_id = $this->input->post('menu_id');
                if ($this->input->post('cat_id')) {
                    $catID = $cat_id = $this->input->post('cat_id');
                    $this->MRestBranch->updateMenuCat();
                    $this->MRestBranch->updateRest($rest);
                    $msg= lang('m_type_add_success');
                    $this->MGeneral->addActivity(lang('m_type_add_log'), $cat_id);
                    //redirect('menus?rest='.$rest.'&cat_id='.$_POST['cat_id'].'&menu_id='.$_POST['menu_id']);
                } else {
                    ##MENU CATEGORIES###
                    $totalMenuCats = $this->MRestBranch->getTotalMenuCats($restid);
                    if ($totalMenuCats >= $availableMenuCats) {
                        $this->session->set_flashdata('error', lang('menu_cat_plan_error'));
                        returnMsg("error","accounts",lang('menu_cat_plan_error'));
                    }
                    $catID = $last_inserted_id = $this->MRestBranch->addMenuCat();
                    $this->MRestBranch->updateRest($rest);
                    $msg=lang('m_cat_add_success');
                    $this->MGeneral->addActivity(lang('m_cat_add_log'), $last_inserted_id);
                    //redirect('menus?rest='.$rest.'&cat_id='.$last_inserted_id.'&menu_id='.$_POST['menu_id']);
                }

                $firstTimeLogin = $this->session->userdata('firstTimeLogin');
                if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                    $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                    $restid = $this->session->userdata('rest_id');
                    $uuserid = $this->session->userdata('id_user');
                    $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
                    if ($profilecompletionstatus['profilecompletion'] == 2) {
                        //$this->MGeneral->updateProfileCompletionStatus($restid,$uuserid,3);
                        $msg= lang('m_add_item_success').' ' . $this->input->post('cat_name');
                        returnMsg("success",'menus?rest=' . $rest . '&menu_id=' . $menuID . '&cat_id=' . $catID . '&item=' . $catID,$msg);
                      
                    }
                }
              
                returnMsg("success",'menus?rest=' . $rest . '&cat_id=' . $catID . '&menu_id=' . $_POST['menu_id'],$msg);

            } else {
          
                returnMsg("error",'menus',lang('proccess_error'));

            }
        }
        if ($option == "menuitem") {
            $rest = $this->input->post('rest_ID');
            $rest_data = $restdata = $this->MGeneral->getRest($rest, false, true);
            if ($this->input->post('menu_item')) {
                $cat = $this->input->post('cat_id');
                $menu_item_id = $this->input->post('id');
                $menu_id = $this->input->post('menu_id');
                $permissions = $this->MBooking->restPermissions($rest);
                $sub_detail_permissions = explode(',', $permissions['sub_detail']);
                if ($permissions['accountType'] != 0) {
                    if (is_uploaded_file($_FILES['menuItem_image']['tmp_name'])) {
                        $image = $this->upload_image('menuItem_image', $this->config->item('upload_url').'images/menuItem/');
                        list($width, $height, $type, $attr) = getimagesize($this->config->item('upload_url').'images/menuItem/' . $image);
                        if ($width < 200 && $height < 200) {
                            returnMsg("error","menus/form?rest=" . $rest . "&cat=" . $cat . "&item=" . $menu_item_id . "&menu_id=" . $menu_id,'Image is very small. Please upload image which must be bigger than 200*200 width and height.');

                        }
                        if (($width > 800) || ($height > 500)) {
                            $this->images->resize($this->config->item('upload_url').'images/menuItem/' . $image, 800, 500, $this->config->item('upload_url').'images/menuItem/thumb/' . $image);
                        }
                        $ratio = $width / $height;
                        $config['source_image'] = $this->config->item('upload_url').'images/menuItem/' . $image;
                        $config['wm_text'] = (($rest_data['rest_Name'])) . ' - ' . (($this->input->post('menu_item'))) . ' - Sufrati.com';
                        $config['wm_type'] = 'text';
                        $config['wm_font_path'] = './css/text.ttf';
                        $config['wm_font_size'] = '13';
                        $config['wm_font_color'] = 'ffffff';
                        $config['wm_vrt_alignment'] = 'bottom';
                        $config['wm_hor_alignment'] = 'right';
                        $config['wm_padding'] = '-10';
                        $config['image_library'] = 'gd2';
                        $this->image_lib->initialize($config);
                        //$this->image_lib->watermark();
                        //$this->image_lib->clear();
                        $config['maintain_ratio'] = TRUE;
                        $this->load->library('images', $config);
                        $this->images->squareThumb($this->config->item('upload_url').'images/menuItem/' . $image, $this->config->item('upload_url').'images/menuItem/thumb/' . $image, 100);
                    } else {
                        $image = ($this->input->post('rest_Logo_old'));
                    }
                } else {
                    $image = "";
                }
                

                $menu_item = $this->input->post('menu_item');
                if ($this->input->post('id')) {
                    $item_id = $this->input->post('id');
                    $this->MRestBranch->updateMenuItem($image);
                    $this->MRestBranch->updateRest($rest);
                    $msg=lang('m_item_edit_success');
                    $this->MGeneral->addActivity(lang('m_item_edit_log'), $item_id);
                    //redirect('menus?rest='.$rest.'&cat_id='.$cat.'&menu_id='.$menu_id.'&item='.$cat);
                } else {
                    ##MENU ITEMS###
                    $totalMenuCats = $this->MRestBranch->getTotalMenuItems($restid, $this->input->post('cat_id'));
                    if ($totalMenuCats >= $availableMenuCatItems) {
                        $this->session->set_flashdata('error', lang('menu_cat_plan_error'));
                        returnMsg("error","accounts",lang('menu_cat_plan_error'));
                    }
                    
                    $item_id = $this->MRestBranch->addMenuItem($image);
                    $this->MRestBranch->updateRest($rest);
                    $msg= lang('m_item_add_done');
                    $this->MGeneral->addActivity(lang('m_item_add_log'), $item_id);
                    //redirect('menus?rest='.$rest.'&cat_id='.$cat.'&menu_id='.$menu_id.'&item='.$cat);
                }

                $firstTimeLogin = $this->session->userdata('firstTimeLogin');
                if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                    $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                    $restid = $this->session->userdata('rest_id');
                    $uuserid = $this->session->userdata('id_user');
                    $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
                    if ($profilecompletionstatus['profilecompletion'] == 2) {
                        $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 3);
                        
                        returnMsg("success","",$msg);

                    }
                }
               
                returnMsg("success",'menus?rest=' . $rest . '&cat_id=' . $cat . '&menu_id=' . $menu_id . '&item=' . $cat,$msg);

            } else {
                returnMsg("error",'menus',lang('proccess_error'));
            }
        }
    
    }

    function delete($branch = 0) {
        $rest = ($_GET['rest']);
        $rest_data = $this->MGeneral->getRest($rest, false, true);
        $this->MRestBranch->updateRest($rest);
        if (isset($_GET['menu_id']) && !isset($_GET['cat_id']) && !isset($_GET['item'])) {
            $this->MRestBranch->deleteMenu(($_GET['menu_id']), $rest);
            returnMsg("success","menus",lang('m_type_deleted'));
        } elseif (isset($_GET['menu_id']) && isset($_GET['cat_id'])) {
            $cat_id = ($_GET['cat_id']);
            $menu_id = ($_GET['menu_id']);
            $this->MRestBranch->deleteMenuCat($cat_id, $menu_id, $rest);
        
            returnMsg("success",'menus?rest=' . $rest . '&cat_id=' . $cat_id . '&menu_id=' . $menu_id,lang('m_cat_deleted'));

        } elseif (isset($_GET['cat'])) {
            $this->MRestBranch->deleteMenuItem(($_GET['item']));
      
            returnMsg("success",'menus?rest=' . $rest . '&item=' . $_GET['cat'] . '&cat_id=' . $_GET['cat'] . '&menu_id=' . $_GET['menu_id'],lang('m_item_deleted'));

        } else {
            redirect('menus');
        }
    }

    function pdf($id = 0) {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');

        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['pagetitle'] = $data['title'] = lang('menu_pdf')." " . (htmlspecialchars($data['rest']['rest_Name']));

        $data['menus'] = $this->MRestBranch->getAllMenuPDF($rest);
        $data['total'] = $this->MRestBranch->getTotalMenuPDF($rest);
        $data['main'] = 'menupdf';
        $data['side_menu'] = array("menu", "pdf");

        $this->layout->view('menupdf', $data);
    }

    function formpdf($pdf = 0) {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $sub_detail_permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $editFlag = FALSE;

        if ($pdf == 0) {
            $editFlag = FALSE;
            $data['title'] = $data['pagetitle'] = lang("new_pdf_menu");
        } else {
            $editFlag = TRUE;
            $data['title'] = $data['pagetitle'] = lang('edit_pdf_menu');
            $data['menu'] = $this->MRestBranch->getPDFMenu($pdf);
        }

        ######PERMISSIONS#######
        if (!$editFlag) {
            $available_pdfMenu = 0;
            if ($permissions['accountType'] == 0) { ##FREE ACCOUNT
                $available_pdfMenu = 1;
            } elseif ($permissions['accountType'] == 1) { ##BRONZE ACCOUNT
                $available_pdfMenu = 3;
            } elseif ($permissions['accountType'] == 2) { ##SLIVER ACCOUNT
                $available_pdfMenu = 4;
            } elseif ($permissions['accountType'] == 3) { ##GOLD ACCOUNT
                $available_pdfMenu = 5;
            }
            $totalMenuPDF = $this->MRestBranch->getTotalMenuPDF($restid);
            if ($totalMenuPDF >= $available_pdfMenu) {
                $this->session->set_flashdata('error', lang('pdf_menu_plan_error'));
                returnMsg("error",'accounts',lang('pdf_menu_plan_error'));
            }
        }

        $data['main'] = 'menupdfform';
        $data['js'] = 'validate';
        $data['side_menu'] = array("menu", "pdf");

        $this->layout->view('menupdfform', $data);
    }

    function savepdf() {
        if ($this->input->post('rest_ID')) {
            $rest = $this->input->post('rest_ID');
            ini_set('memory_limit', '-1');
            if ($this->input->post('title')) {
                $menu = $menuar = "";
                $numPages = $numPagesAr = 0;
                $this->MRestBranch->updateRest($rest);
                if ($this->input->post('id')) {
                    $menu_id = $this->input->post('id');
                    if (is_uploaded_file($_FILES['menu']['tmp_name'])) {
                        $ext = pathinfo($_FILES['menu_ar']['name'], PATHINFO_EXTENSION);
                        
                        if (!in_array($ext, array('pdf'))) {
                       
                            returnMsg("error",'menus/formpdf/' . $menu_id . '?rest=' . $this->input->post('rest_ID'),lang('upload_pdf_file'));
                        }
                        $menu = $this->upload_pdf('menu',menu_pdf_path());
                        $numPages = $this->savePdfAsImage($menu,menu_pdf_path(), menu_pdf_path());
                    } else {
                        $menu = $_POST['menu_old'];
                        $numPages = $_POST['pagenumber'];
                    }
                    if (is_uploaded_file($_FILES['menu_ar']['tmp_name'])) {
                        $ext = pathinfo($_FILES['menu_ar']['name'], PATHINFO_EXTENSION);
                        if (!in_array($ext, array('pdf'))) {
                            returnMsg("error",'menus/formpdf/' . $menu_id . '?rest=' . $this->input->post('rest_ID'),lang('upload_pdf_file'));

                        }
                        $menuar = $this->upload_pdf('menu_ar',menu_pdf_path());
                        $numPagesAr = $this->savePdfAsImage($menuar, menu_pdf_path(), menu_pdf_path());
                    } else {
                        $menuar = $_POST['menu_ar_old'];
                        $numPagesAr = $_POST['pagenumberAr'];
                    }
                    $this->MRestBranch->updatePDFMenu($menu, $menuar, $numPages, $numPagesAr);
                
                    $this->MGeneral->addActivity(lang('edit_pdf_menu_log'), $menu_id);
                    returnMsg("success",'menus/pdf',lang('edit_pdf_menu_success'));
                } else {
                    if (is_uploaded_file($_FILES['menu']['tmp_name'])) {
                        $ext = pathinfo($_FILES['menu']['name'], PATHINFO_EXTENSION);
                        if (!in_array($ext, array('pdf'))) {
                            $this->session->set_flashdata('error', 'Please upload pdf file.');
                            redirect('menus/formpdf?rest=' . $this->input->post('rest_ID'));
                        }
                        $menu = $this->upload_pdf('menu', menu_pdf_path());
                        $numPages = $this->savePdfAsImage($menu, menu_pdf_path(), menu_pdf_path());
                    }
                    if (is_uploaded_file($_FILES['menu_ar']['tmp_name'])) {
                        $ext = pathinfo($_FILES['menu_ar']['name'], PATHINFO_EXTENSION);
                        if (!in_array($ext, array('pdf'))) {
                            returnMsg("error",'menus/formpdf?rest=' . $this->input->post('rest_ID'),lang('upload_pdf_file'));

                        }
                        $menuar = $this->upload_pdf('menu_ar', menu_pdf_path());
                        $numPagesAr = $this->savePdfAsImage($menuar,menu_pdf_path(), menu_pdf_path());
                    }
                    $menu_id = $this->MRestBranch->addPDFMenu($menu, $menuar, $numPages, $numPagesAr);
                    $this->MGeneral->addActivity(lang('edit_pdf_menu_log'), $menu_id);
                    returnMsg("success",'menus/pdf',lang('add_pdf_menu_success'));

                }
            }
        } else {
      
            returnMsg('error','menus/pdf',lang('proccess_error'));
        }
    }

    function deletepdf($pdf = 0) {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $this->MRestBranch->updateRest($rest);
        $this->MRestBranch->deleteMenuPDF($pdf);
       
        returnMsg("success",'menus/pdf',lang('pdf_menu_deleted'));

    }

    function upload_pdf($name, $directory) {
        $uploadDir = $directory;
        // ======================= upload 1 ===========================
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $uploadFile_1 = uniqid('sufrati') . $_FILES[$name]['name'];
            $rand = rand(0, 10000 - 1);
            $date = date('YmdHis');
            $file_name = $_FILES[$name]['name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $new_filename = $rand . $date . "." . $file_ext;
            $uploadFile_1 = uniqid('sufrati').$new_filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1)) {
                //print "File is valid, and was successfully uploaded. \n\n ";
            } else {
                return null;
            }
            return $uploadFile_1;
        }
        else
            return null;
    }

    ##Haroon

    function upload_image($name, $dir, $default = 'no_image.jpg') {
        $uploadDir = $dir;
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $filename = $_FILES[$name]['name'];
            $filename = str_replace(' ', '_', $filename);
            $uploadFile_1 = uniqid('sufrati') . $filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            $fileName = $_FILES[$name]['name'];
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
                $image_name = $uploadFile_1;
            else
                $image_name = $default;
        }
        else
            $image_name = $default;

        return $image_name;
    }

    function savePdfAsImage($fname, $directory, $savedir) {
    return 0;
        $filename = $directory . $fname;
        if ($fname != "" && file_exists($filename)) {
            $pdf = $filename;
            $pages = $this->getNumPagesPdf($pdf);
            $name = explode('.', $fname);
            if (mkdir($savedir . $name[0], 0755)) {
                for ($i = 0; $i < $pages; $i++) {
                    $j = $i + 1;
                    $im = new imagick();
                    $im->readimage($pdf . '[' . $i . ']');
                    $im->setImageFormat('jpg');
                    file_put_contents($savedir . $name[0] . '/' . $j . '.jpg', $im);
                }
            }
            return $pages;
        }
    }

    function getNumPagesPdf($filepath) {
return 0;
        $fp = @fopen(preg_replace("/\[(.*?)\]/i", "", $filepath), "r");
        if ($fp) {
            $max = 0;
            while (!feof($fp)) {
                $line = fgets($fp, 255);
                if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                    preg_match('/[0-9]+/', $matches[0], $matches2);
                    if ($max < $matches2[0])
                        $max = $matches2[0];
                }
            }
            fclose($fp);
        }else {
            // return 2;
        }
        if ($max == 0) {
            $im = new imagick($filepath);
            $max = $im->getNumberImages();
        }

        return $max;
    }

}