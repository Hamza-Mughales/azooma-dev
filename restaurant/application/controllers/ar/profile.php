<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == ''){
            redirect('home/login');
        }
    }
	
    public function index(){
        $restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);

        $data['resttype']=$this->MRestBranch->getAllRestTypes(1);
        $data['bestfor']=$this->MGeneral->getAllBestFor(1);
        $data['cuisines']=$this->MGeneral->getAllCuisine(1);
        
        $data['allowed_chars']='1000';

        $data['restcuisines']=$restcuisines=$this->MGeneral->getRestaurantCuisines($restid);
        $data['restbestfors']=$restbestfors=$this->MGeneral->getRestaurantBestFors($restid);
        $data['openHours']=$this->MRestBranch->getRestaurantTimings($restid);
        $data['restdays']=$this->MRestBranch->getRestaurantDays($restid);

        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar']))." - ".$settings['nameAr'];
        $data['css']='ar,chosen';
        $data['js']='chosen,validate';
        $data['main']='ar/rest_details';
        $this->load->view('ar/template',$data);
    }
        
    function save($id=0){        
            if($this->input->post('rest_ID')){
                if(is_uploaded_file($_FILES['rest_Logo']['tmp_name'])){
                    $logo = $this->image_upload('rest_Logo','../uploads/logos/','default_logo.gif');
                    if($logo != 'default_logo.gif'){
                        $this->load->library('images');
                        $this->images->resize('../uploads/logos/' . $logo,130,130,'../uploads/logos/' .$logo);
                        $this->images->squareThumb('../uploads/logos/' . $logo,'../uploads/logos/thumb/' . $logo,30);
                        $this->images->squareThumb('../uploads/logos/' . $logo,'../uploads/logos/45/' . $logo,45);
                        $this->images->squareThumb('../uploads/logos/' . $logo,'../uploads/logos/40/' . $logo,40);
                    }
                }else{
                    $logo=($this->input->post('rest_Logo_old'));
                }
                $rest=$_POST['rest_ID'];
                $this->MRestBranch->updateRestaurant($logo);
                $this->MRestBranch->updateRestCuisines($rest);
                //$this->MRestBranch->updateRestBestFor($rest);
                $this->MRestBranch->updateOpenHours($rest);
                $this->session->set_flashdata('message',$_POST['rest_Name_Ar'].'  تحديث بنجاح ');
                $this->MRestBranch->updateRest($rest);
                $firstTimeLogin=$this->session->userdata('firstTimeLogin');
                if(isset($firstTimeLogin) && $firstTimeLogin==TRUE){
                    $data['firstTimeLogin']=$this->session->userdata('firstTimeLogin');
                    $restid=$this->session->userdata('rest_id');
                    $uuserid=$this->session->userdata('id_user');
                    $profilecompletionstatus=$this->MGeneral->getProfileCompletionStatus($restid,$uuserid);
                    if($profilecompletionstatus['profilecompletion']==0){
                        $this->MGeneral->updateProfileCompletionStatus($restid,$uuserid,1);
                        redirect('ar');
                    }
                }                
                redirect('ar/profile');
            }else{
                $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
                redirect('ar/profile');
            }        
    }
    
    function image_upload($name,$dir,$default='no_image.jpg'){
	$uploadDir = $dir;
	if ( $_FILES[$name]['name'] != '' &&  $_FILES[$name]['name'] != 'none'){
            $filename=$_FILES[$name]['name'];	
            $filename=str_replace(' ', '_', $filename);
            $uploadFile_1 = uniqid('sufrati') . $filename;
            $uploadFile1  = $uploadDir. $uploadFile_1; 
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
		$image_name = $uploadFile_1;
            else
		$image_name = $default;				
        }
        else
            $image_name = $default;
        return $image_name;		
   }
}