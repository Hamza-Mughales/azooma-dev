<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Branches extends MY_Controller
{

    public $data;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Mgeneral', "MGeneral");
        $this->load->model('Mbooking', "MBooking");
        $this->load->model('Mrestbranch', "MRestBranch");
        $this->load->library('pagination');
        $this->load->library('images');
        if ($this->session->userdata('restuser') == '') {
            redirect('home/login');
        }
    }

    public function index()
    {
        $city = "";
        $limit = 20;
        if (isset($_GET['city']) && ($_GET['city'] != "")) {
            $city = ($_GET['city']);
            $cityArray = $this->MGeneral->getCity($city);
        }

        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['resttype'] = $this->MRestBranch->getAllRestTypes(1);
        $data['bestfor'] = $this->MGeneral->getAllBestFor(1);
        $data['cuisines'] = $this->MGeneral->getAllCuisine(1);

        $data['branches'] = $this->MRestBranch->getAllBranches($restid, $city, '', '', TRUE);
        $data['total'] = $this->MRestBranch->getTotalBranches($restid, $city);

        $data['restid'] = $restid;
        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];
        $data['side_menu'] = array("branches", "index");
        $data['main'] = 'branches';
        $this->layout->view('branches', $data);
    }

    public function branch($cityid)
    {
        $city = "";
        $limit = 5000000;
        if (isset($cityid) && ($cityid != "")) {
            $city = ($cityid);
            $cityArray = $this->MGeneral->getCity($city);
        }

        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);

        $data['resttype'] = $this->MRestBranch->getAllRestTypes(1);
        $data['bestfor'] = $this->MGeneral->getAllBestFor(1);
        $data['cuisines'] = $this->MGeneral->getAllCuisine(1);

        $data['branches'] = $this->MRestBranch->getAllBranches($restid, $city);
        $data['total'] = $this->MRestBranch->getTotalBranches($restid, $city);

        $data['city'] = $cityArray['city_Name'];

        $data['restid'] = $restid;
        $data['title'] = (htmlspecialchars($restdata['rest_Name'])) . " - " . $settings['name'];
        $data['main'] = 'branch';
        $data['side_menu'] = array("branches", "branch");
        $this->layout->view('branch', $data);
    }

    function from($rest_id, $br_id = 0)
    {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $country = 0;
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $country = $restdata['country'];
        $data['cities'] = $this->MGeneral->getAllCity(1, $country);
        $data['main'] = 'branchform';
        $data['hotels'] = $this->MRestBranch->getAllHotels(1);
        $data['bodyfunction'] = 'onLoad="initialise()"';
        $data['branch'] = $branch = $this->MRestBranch->getBranch($br_id);
        if ($br_id == 0) {
            $data['title'] = lang('new_branch').' - ' . (htmlspecialchars($data['rest']['rest_Name']));
        } else {
            $data['title'] = (htmlspecialchars($branch['br_loc'])) . ' - ' . (htmlspecialchars($branch['district_Name'])) . ' - ' . (htmlspecialchars($branch['city_Name']));
        }

        $data['js'] = 'branchform,validate';
        $data['css'] = 'admin,docs';
        $data['side_menu'] = array("branches", "add_new_branch");
        $this->layout->view('branchform', $data);
    }

    function save()
    {
        $msg = '';
        if ($this->input->post('city_ID')) {
            $city_ID = $this->input->post('city_ID');
            $rest = $this->input->post('rest_fk_id');
            if ($this->input->post('br_id')) {
                $branch = $this->input->post('br_id');
                $this->MRestBranch->updateBranch();
                if ($_POST['branch_type'] == "Hotel Restaurant") {
                    if ($this->MRestBranch->getHotel($branch) > 0) {
                        $this->MRestBranch->updateBranchHotel($branch);
                    } else {
                        $this->MRestBranch->addBranchHotel($branch);
                    }
                }
                $this->MRestBranch->updateRest($rest);
                $msg = lang('branch_updated');

                $this->MGeneral->addActivity(lang('branch_updated_log'), $branch);
            } else {
                $branch = $this->MRestBranch->addBranch();
                if ($this->input->post('branch_type') == "Hotel Restaurant") {
                    $this->MRestActions->addBranchHotel($branch);
                }
                $msg =lang('branch_added');
                $this->MGeneral->addActivity(lang('branch_added_log'), $branch);
                $this->MRestBranch->updateRest($rest);
            }
            $firstTimeLogin = $this->session->userdata('firstTimeLogin');
            if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                $restid = $this->session->userdata('rest_id');
                $uuserid = $this->session->userdata('id_user');
                $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
                if ($profilecompletionstatus['profilecompletion'] == 1) {
                    $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 2);

                    redirect();
                }
            }
            returnMsg("success", "branches/branch/" . $city_ID, $msg);
            redirect("branches/branch/" . $city_ID);
        }
    }

    function photofrom($image_id = 0)
    {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');
        $permissions = $this->MBooking->restPermissions($restid);
        $permissions_sub_detail = explode(',', $permissions['sub_detail']);
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['cities'] = $this->MGeneral->getAllCity(1);
        $data['main'] = 'branchphotoform';
        $data['hotels'] = $this->MRestBranch->getAllHotels(1);
        if ($permissions['accountType'] == 0) {
            returnMsg("success",'accounts',lang('account_paln_msg'));

        }
        $data['branches'] = $this->MRestBranch->getAllBranches($restid);
        if ($image_id == 0) {
            $data['title'] =lang('new_branch_photo').' - ' . (htmlspecialchars($data['rest']['rest_Name']));
        } else {
            $data['photo'] = $photo = $this->MRestBranch->getUserGalleryImage($image_id);
            $data['title'] = (htmlspecialchars($photo['title'])) . ' - ' . (htmlspecialchars($photo['title_ar']));
        }

        $data['js'] = 'branchform,validate';
        $data['css'] = 'admin,docs';
        $data['side_menu'] = array("branches", "add_new_branch_photo");

        $this->layout->view('branchphotoform', $data);
    }

    function savebranchimage()
    {
        $rest = $this->input->post('rest_fk_id');
        if ($this->input->post('br_id') && $this->input->post('br_id') != "") {
            $br_id = $this->input->post('br_id');
            $restname = (($this->input->post('rest_Name')));
            $image = "";
            $title = $title_ar = "";
            $ratio = $width = 0;
            $msg='';
            if (is_uploaded_file($_FILES['branch_image']['tmp_name'])) {
                $image = $this->MGeneral->uploadImage('branch_image', $this->config->item('upload_url') . 'Gallery/');
                list($width, $height, $type, $attr) = getimagesize($this->config->item('upload_url') . 'Gallery/' . $image);
                if ($width < 200 && $height < 200) {

                    returnMsg("error","branches/photofrom/" . $rest,lang('img_upload_size_error'));
                }
                if (($width > 800) || ($height > 500)) {
                    $this->images->resize($this->config->item('upload_url') . 'Gallery/' . $image, 800, 500, $this->config->item('upload_url') . 'Gallery/' . $image);
                }

                list($width, $height, $type, $attr) = getimagesize($this->config->item('upload_url') . 'Gallery/' . $image);
                $ratio = $width / $height;
                $config['source_image'] = $this->config->item('upload_url') . 'Gallery/' . $image;
                $config['wm_text'] = $restname . ' - Azooma.co';
                $config['wm_type'] = 'text';
                $config['wm_font_path'] = './css/text.ttf';
                $config['wm_font_size'] = '13';
                $config['wm_font_color'] = 'ffffff';
                $config['wm_vrt_alignment'] = 'bottom';
                $config['wm_hor_alignment'] = 'right';
                $config['wm_padding'] = '-10';
                $config['image_library'] = 'GD2';
                $this->image_lib->initialize($config);
                //$this->image_lib->watermark();
                //$this->image_lib->clear();
                $config['maintain_ratio'] = TRUE;
                $this->load->library('images', $config);
                $height1 = round($height * (200 / $width));
                $height2 = round($height * (230 / $width));
                $this->images->squareThumb($this->config->item('upload_url') . 'Gallery/' . $image, $this->config->item('upload_url') . 'Gallery/thumb/' . $image, 100);
                $this->images->resize($this->config->item('upload_url') . 'Gallery/' . $image, 200, $height1, $this->config->item('upload_url') . 'Gallery/200/' . $image);
                $this->images->resize($this->config->item('upload_url') . 'Gallery/' . $image, 230, $height2, $this->config->item('upload_url') . 'Gallery/230/' . $image);
                $this->images->resize($this->config->item('upload_url') . 'Gallery/' . $image, 45, 45, $this->config->item('upload_url') . 'Gallery/45/' . $image);
                $this->images->squareThumb($this->config->item('upload_url') . 'Gallery/' . $image, $this->config->item('upload_url') . 'Gallery/200x200/' . $image, 200);
                $this->images->squareThumb($this->config->item('upload_url') . 'Gallery/' . $image, $this->config->item('upload_url') . 'Gallery/150x150/' . $image, 150);
                $theight = $height * (400 / $width);
                $this->images->resize($this->config->item('upload_url') . 'Gallery/' . $image, 400, $theight, $this->config->item('upload_url') . 'Gallery/400x/' . $image);
            } else {
                $image = ($this->input->post('branch_image_old'));
            }
            $title = ($this->input->post('title'));
            $title_ar = ($this->input->post('title_ar'));
            $branch = $this->MRestBranch->getBranch($br_id);
            $restData = $this->MGeneral->getRest($rest);
            if ($title == "" || empty($title)) {
                $title = $restData['rest_Name'] . ' ' . $branch['br_loc'];
            }
            if ($title_ar == "" || empty($title_ar)) {
                $title_ar = $restData['rest_Name_Ar'] . ' ' . $branch['br_loc_ar'];
            }

            if ($this->input->post('image_ID')) {
                $image_ID = $this->input->post('image_ID');
                $this->MRestBranch->updateBranchImage($image_ID, $image, $title, $title_ar, $ratio, $width);
                $this->MRestBranch->updateRest($rest);
                $msg=lang('branch_img_updated');
            } else {
                $this->MRestBranch->addBranchImage($image, $title, $title_ar, $ratio, $width);
                $this->MRestBranch->updateRest($rest);
                $msg=lang('branch_img_upladed');
            }
           
            returnMsg("success","branches/photos/" . $br_id . "/" . $rest,$msg);
        } elseif (empty($br_id)) {
        }
    }

    function photos($br_id = 0, $rest_id)
    {
        $restid = $this->session->userdata('rest_id');
        $uuserid = $this->session->userdata('id_user');

        $permissions = $this->MBooking->restPermissions($restid);
        $permissions_sub_detail = explode(',', $permissions['sub_detail']);
        if ($permissions['accountType'] == 0) {

            returnMsg("success",'accounts',lang('account_paln_msg'));
        }
        $data['settings'] = $settings = $this->MGeneral->getSettings();
        $data['sitename'] = $this->MGeneral->getSiteName();
        $data['logo'] = $logo = $this->MGeneral->getLogo();
        $data['rest'] = $restdata = $this->MGeneral->getRest($restid, false, true);
        $data['branch'] = $branch = $this->MRestBranch->getBranch($br_id);
        $data['title'] = (htmlspecialchars($branch['br_loc'])) . ' - ' . (htmlspecialchars($branch['district_Name'])) . ' - ' . (htmlspecialchars($branch['city_Name']));
        $data['branchImages'] = $this->MRestBranch->getBranchImages($br_id);
        $data['main'] = 'branchImages';
        $data['js'] = 'branchform,validate';
        $data['css'] = 'admin,docs';
        $data['side_menu'] = array("branches", "branchImages");

        $this->layout->view('branchImages', $data);
    }

    function usergallerystatus($id = 0)
    {
        if (isset($_GET['id']) && ($_GET['id'] != "")) {
            $id = $_GET['id'];
        }
        $msg = '';
        $photo = $this->MRestBranch->getUserGalleryImage($id);
        if ($photo['status'] == 1) {
            $this->MRestBranch->deActivateUserGalleryImage($id);
            $msg = lang('img_deactive_message');
        } else {
            $this->MRestBranch->activateUserGalleryImage($id);
            if (($photo['user_ID'] != "") && ($photo['user_ID'] != 0)) {
                $this->MRestBranch->addNotification($photo['user_ID'], $id, 'Photo approved', 'وافق الصورة');
            }
            $msg = lang('img_active_message');
        }
        if (isset($_GET['rest']) && !empty($_GET['rest'])) {
            $this->MRestBranch->updateRest($_GET['rest']);
        }
        returnMsg("success", "branches/photos/" . $_GET['br_id'] . "/" . $_GET['rest'], $msg);
    }

    function usergallerydelete($id = 0)
    {
        if (isset($_GET['id']) && ($_GET['id'] != "")) {
            $id = $_GET['id'];
        }
        $this->MRestBranch->deleteUserGalleryImage($id);

        if (isset($_GET['rest']) && !empty($_GET['rest'])) {
            $this->MRestBranch->updateRest($_GET['rest']);
        }
        returnMsg("success", "branches/photos/" . $_GET['br_id'] . "/" . $_GET['rest'], lang("delete_success"));
    }
    public function delete_branch($id, $city_id)
    {
        $data['status'] = 0;
        $where['br_id'] = intval($id);

        $saved = Smart::update("rest_branches", $data, $where);
        if ($saved) {
            returnMsg("success", "branches/branch/$city_id", lang("delete_success"));
        } else {
            returnMsg("error", "branches/branch/$city_id", lang("delete_error"));
        }
    }
}
