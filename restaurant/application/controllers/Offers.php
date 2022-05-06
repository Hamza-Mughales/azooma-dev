<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Offers extends MY_Controller {

    public $data;

    function __construct() {
        parent::__construct();
        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Mbooking',"MBooking");
        $this->load->model('Mrestbranch',"MRestBranch");
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if ($this->session->userdata('restuser') == '') {
            redirect('home/login');
        }
    }

    public function index() {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['pagetitle'] = $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];
        $data['offers'] = $this->MRestBranch->getAllOffers($rest);
        $data['total'] = $this->MRestBranch->getAllTotalOffers($rest);

        $data['main'] = 'offers';
        $data['side_menu'] = array("offers");

        $this->layout->view('offers', $data);
    }

    function categories($item = 0) {
        $limit = 20;
        $ajax = 0;
        $offset = 0;
        if (isset($_GET['ajax']) && ($_GET['ajax'] != "")) {
            $ajax = ($_GET['ajax']);
        }
        if (isset($_GET['per_page']) && ($_GET['per_page'] != "")) {
            $offset = ($_GET['per_page']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');

        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $config['base_url'] = base_url() . 'offers/categories?limit=' . $limit;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['uri_segment'] = 4;
        $config['num_links'] = 4;
        $config['first_link'] = '<--';
        $config['first_tag_open'] = '<a href="#">';
        $config['first_tag_class'] = '</a>';
        $config['last_link'] = '-->';
        $config['anchor_class'] = 'class="ajax-pagination-link"';
        $config['full_tag_open'] = '<div class="pagination ajax-pagination table-results" id="table-results">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class="active"><a href="javascript:void(0);" >';
        $config['cur_tag_close'] = '</a></span>';
        $config['total_rows'] = $data['total'] = $this->MRestBranch->getTotalOfferCategories(1);
        $this->pagination->initialize($config);

        $data['offers'] = $this->MRestBranch->getAllOfferCategories(1, $limit, $offset);

        $data['pagetitle'] = (htmlspecialchars($restdata['rest_Name'])) . ' - Offer Categories';
        $data['main'] = 'offerscategories';
        $data['side_menu'] = array("offers","offerscategories");

        $this->layout->view('offerscategories', $data);
    }

    function form($id = 0) {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $newFlag = TRUE;

        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['offercategories'] = $this->MRestBranch->getAllOfferCategories(1);
        $data['restbranches'] = $this->MRestBranch->getAllBranches($rest);
        if ($id != 0) {
            $newFlag = FALSE;
            $data['offer'] = $this->MRestBranch->getOffer($id);
            $data['title'] = $data['pagetitle'] = ($data['offer']['offerName']);
            $data['restoffercategory'] = $this->MRestBranch->getOfferCategory($id);
            $data['restofferbranches'] = $this->MRestBranch->getOfferBranch($id);
        } else {
            $data['title'] = $data['pagetitle'] = lang('new_offer');
        }

        if ($newFlag) {
            ######PERMISSIONS#######
            $permissions = $this->MBooking->restPermissions($restid);
            $sub_detail_permissions = explode(',', $permissions['sub_detail']);
            if (in_array(10, $sub_detail_permissions) || in_array(11, $sub_detail_permissions)) {
                $totalOffers = $this->MRestBranch->getAllTotalOffers($rest);
                $availableOffers = 0;
                if (in_array(10, $sub_detail_permissions)) {
                    $availableOffers = 3;
                } elseif (in_array(11, $sub_detail_permissions)) {
                    $availableOffers = 30;
                }
                if ($totalOffers >= $availableOffers) {
                    $this->session->set_flashdata('error', lang('you_can_add').' ' . $availableOffers . ' '.lang('offer_plan_error'));
                    returnMsg('error','accounts',lang('you_can_add').' ' . $availableOffers . ' '.lang('offer_plan_error'));
                }
            } else {
                $this->session->set_flashdata('error', lang('gallry_plan_error'));
               returnMsg('error','accounts',lang('gallry_plan_error'));
            }
        }

        $data['main'] = 'offerform';
        $data['js'] = 'chosen,validate,jquery-ui,ckeditor/ckeditor';
        $data['css'] = 'chosen,jquery-ui';
        $data['side_menu'] = array("offers","add_offer");

        $this->layout->view('offerform', $data);
    }

    function save($option = "") {
        
        $rest = $this->input->post('rest_ID');
        $rest = $restid = $this->session->userdata('rest_id');
        $restaurant = $restdata = $this->MGeneral->getRest($restid, false, true);
        $restname = $restaurant['rest_Name'];
        if ($this->input->post('offerName')) {
            if ($this->input->post('id')) {
                //do nothing
            } else {
                ######PERMISSIONS#######
                $permissions = $this->MBooking->restPermissions($restid);
                $sub_detail_permissions = explode(',', $permissions['sub_detail']);
                if (in_array(10, $sub_detail_permissions) || in_array(11, $sub_detail_permissions)) {
                    $totalOffers = $this->MRestBranch->getAllTotalOffers($rest);
                    $availableOffers = 0;
                    if (in_array(10, $sub_detail_permissions)) {
                        $availableOffers = 3;
                    } elseif (in_array(11, $sub_detail_permissions)) {
                        $availableOffers = 30;
                    }
                    if ($totalOffers >= $availableOffers) {
                        $this->session->set_flashdata('error',  lang('you_can_add').' ' . $availableOffers . ' '.lang('offer_plan_error'));
                      // redirect('accounts');
                      returnMsg('error','accounts',lang('you_can_add').' ' . $availableOffers . ' '.lang('offer_plan_error'));
                    }
                } else {
                    $this->session->set_flashdata('error', lang('gallry_plan_error'));
                    //redirect('accounts');
                   returnMsg('error','accounts',lang('gallry_plan_error'));

                }
            }

            $this->load->library('images');
            $id=$this->input->post('id');
            if ($this->input->post('id')) {
                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $image = $this->upload_image('image', $this->config->item('upload_url') . 'images/offers/');
                    list($width, $height, $type, $attr) = getimagesize($this->config->item('upload_url') . 'images/offers/' . $image);
                    if ($width < 200 || $height < 200) {
                   
                      //  returnMsg("error","offers/form?rest=" . $rest,'الصورة صغيرة جدا. يرجى تحميل الحجم الصحيح (200 × 200)  بكسل ');
                        returnMsg('error',"offers/form/$id?rest=" . $rest,lang('img_upload_size_error'));

                    }
                    if (($width > 800) || ($height > 500)) {
                        $this->images->resize($this->config->item('upload_url') . 'images/offers/' . $image, 800, 500, $this->config->item('upload_url') . 'images/offers/' . $image);
                    }
                    //$this->images->resize($this->config->item('upload_url').'images/offers/' . $image,100,100,$this->config->item('upload_url').'images/offers/thumb/' .$image);
                    $this->images->squareThumb($this->config->item('upload_url') . 'images/offers/' . $image, $this->config->item('upload_url').'images/offers/thumb/' . $image, 100);
                } else {
                    $image = $_POST['image_old'];
                }
                if (is_uploaded_file($_FILES['imageAr']['tmp_name'])) {
                    $imageAr = $this->upload_image('imageAr', $this->config->item('upload_url') . 'images/offers/');
                    $width = $height = 0;
                    list($width, $height, $type, $attr) = getimagesize($this->config->item('upload_url') . 'images/offers/' . $imageAr);
                    if ($width < 200 || $height < 200) {
                        returnMsg('error',"offers/form/$id?rest=" . $rest,lang('img_upload_size_error'));
                    }
                    if (($width > 800) || ($height > 500)) {
                        $this->images->resize($this->config->item('upload_url') . 'images/offers/' . $imageAr, 800, 500, $this->config->item('upload_url') . 'images/offers/' . $imageAr);
                    }
                    //$this->images->resize($this->config->item('upload_url').'images/offers/' . $imageAr,100,100,$this->config->item('upload_url').'images/offers/thumb/' .$imageAr);
                    $this->images->squareThumb($this->config->item('upload_url') . 'images/offers/' . $imageAr, $this->config->item('upload_url').'images/offers/thumb/' . $imageAr, 100);
                } else {
                    $imageAr = $_POST['imageAr_old'];
                }
                $offer_id = $this->input->post('id');
                $this->MRestBranch->updateOffer($image, $imageAr);
                $this->MRestBranch->updateRest($rest);
                $this->MGeneral->addActivity(lang('offer_update_log'), $offer_id);
       
                returnMsg("success",'offers',lang('offer_update_success'));
            } else {
                $image = $imageAr = "";
                if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $image = $this->upload_image('image', $this->config->item('upload_url') . 'images/offers/');
                    $this->images->resize($this->config->item('upload_url') . 'images/offers/' . $image, 100, 100, $this->config->item('upload_url').'images/offers/thumb/' . $image);
                    $this->images->squareThumb($this->config->item('upload_url') . 'images/offers/' . $image, $this->config->item('upload_url').'images/offers/thumb/' . $image, 100);
                }
                if (is_uploaded_file($_FILES['imageAr']['tmp_name'])) {
                    $imageAr = $this->upload_image('imageAr', $this->config->item('upload_url') . 'images/offers/');
                    $this->images->resize($this->config->item('upload_url') . 'images/offers/' . $imageAr, 100, 100, $this->config->item('upload_url').'images/offers/thumb/' . $imageAr);
                    $this->images->squareThumb($this->config->item('upload_url') . 'images/offers/' . $imageAr, $this->config->item('upload_url') . 'images/offers/thumb/' . $imageAr, 100);
                }
                $offer_id = $this->MRestBranch->addOffer($image, $imageAr);
                $this->MRestBranch->updateRest($rest);
                $this->MGeneral->addActivity(lang('offer_add_log'), $offer_id);
              
                returnMsg("success","offers",lang('offer_add_success'));

            }
        } else {
          
            returnMsg("error","offers",lang('proccess_error'));

        }
    }

    function status($id = 0) {
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $this->MRestBranch->updateRest($rest);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $offer = $this->MRestBranch->getOffer($id);
        $this->MRestBranch->changeOfferStatus($id);
        if ($offer['status'] == 1) {
            returnMsg("success",'offers',lang('offer_deactivaed'));

        } else {
            returnMsg("success",'offers', lang('offer_deactivaed'));
        }
    }

    function delete($id = 0) {
      
        $rest = $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $offer = $this->MRestBranch->getOffer($id);
        $this->MRestBranch->deleteOffer($id);
        $this->MRestBranch->updateRest($rest);
     
        returnMsg("success",'offers', lang('offer_deleted'));

    }

    function upload_image($name, $dir, $default = 'no_image.jpg') {
        $uploadDir = $dir;
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $filename = $_FILES[$name]['name'];
        
            $rand = rand(0, 10000 - 1);
            $date = date('YmdHis');
            $file_name = $_FILES[$name]['name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $new_filename = $rand . $date . "." . $file_ext;
            $uploadFile_1 = uniqid('sufrati') . $new_filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            $fileName = $_FILES[$name]['name'];
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
                $image_name = $uploadFile_1;
            else
                $image_name = $default;
        } else
            $image_name = $default;

        return $image_name;
    }

}
