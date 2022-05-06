<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Branches extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->library('pagination');
        $this->load->library('images');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == ''){
            redirect('home/login');
        }
    }
	
    public function index(){
        $city="";
        $limit=20;
        if(isset ($_GET['city'])&&($_GET['city']!="")){
            $city=($_GET['city']);
            $cityArray=$this->MGeneral->getCity($city);
        }    
        
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

        $data['branches']=$this->MRestBranch->getAllBranches($restid,$city,'','',TRUE);
        $data['total']=$this->MRestBranch->getTotalBranches($restid,$city);
        
        $data['restid']=$restid;
        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar']))." - ".$settings['nameAr'];
        $data['css']='ar';
        $data['main']='ar/branches';
        $this->load->view('ar/template',$data);
    }
    
    public function branch($cityid)
    {
        $city="";
        $limit=20;
        if(isset ($cityid)&&($cityid!="")){
            $city=($cityid);
            $cityArray=$this->MGeneral->getCity($city);
        }    
        
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

        $data['branches']=$this->MRestBranch->getAllBranches($restid,$city);
        $data['total']=$this->MRestBranch->getTotalBranches($restid,$city);
        
        $data['city']=$cityArray['city_Name_ar'];
        $data['css']='ar';
        $data['restid']=$restid;
        $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar']))." - ".$settings['nameAr'];
        $data['main']='ar/branch';
        $this->load->view('ar/template',$data);
    }
    
    function from($rest_id,$br_id=0){
        $restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['cities']=  $this->MGeneral->getAllCity(1);        
        $data['hotels']=$this->MRestBranch->getAllHotels(1);
        $data['bodyfunction']='onLoad="initialise()"';
        $data['branch']=$branch=$this->MRestBranch->getBranch($br_id);
        if($br_id==0){
            $data['title']='فرع جديد - '.(htmlspecialchars($data['rest']['rest_Name_Ar']));
        }else{
            $data['title']=(htmlspecialchars($branch['br_loc_ar'])).' - '.(htmlspecialchars($branch['district_Name_Ar'])).' - '.(htmlspecialchars($branch['city_Name_Ar']));
        }
        
        $data['main']='ar/branchform';
        $data['css']='ar';        
        $data['js']='branchform,validate';
        $this->load->view('ar/template',$data);
    }
    
    function save(){
        if($this->input->post('city_ID')){
            $city_ID=$this->input->post('city_ID');
            $rest=$this->input->post('rest_fk_id');
            if($this->input->post('br_id')){
                $branch=$this->input->post('br_id');
                $this->MRestBranch->updateBranch();
                if($_POST['branch_type']=="Hotel Restaurant"){
                    if($this->MRestBranch->getHotel($branch)>0){
                        $this->MRestBranch->updateBranchHotel($branch);
                    }else{
                        $this->MRestBranch->addBranchHotel($branch);
                    }   
                }
                $this->MRestBranch->updateRest($rest);
                $this->session->set_flashdata('message','تم تحديث الفرع بنجاح');
		$this->MGeneral->addActivity('We have changed our branch info.',$branch);
                
            }else{
                $branch=$this->MRestBranch->addBranch();
                if($this->input->post('branch_type')=="Hotel Restaurant"){
                    $this->MRestActions->addBranchHotel($branch);
                }
                $this->session->set_flashdata('message','تم تحديث الفرع بنجاح');
		$this->MGeneral->addActivity('We have opened our new branch.',$branch);
                $this->MRestBranch->updateRest($rest);                
            }
            
            $firstTimeLogin=$this->session->userdata('firstTimeLogin');
            if(isset($firstTimeLogin) && $firstTimeLogin==TRUE){
                $data['firstTimeLogin']=$this->session->userdata('firstTimeLogin');
                $restid=$this->session->userdata('rest_id');
                $uuserid=$this->session->userdata('id_user');
                $profilecompletionstatus=$this->MGeneral->getProfileCompletionStatus($restid,$uuserid);
                if($profilecompletionstatus['profilecompletion']==1){
                    $this->MGeneral->updateProfileCompletionStatus($restid,$uuserid,2);
                    redirect('ar');
                }
            }
            redirect("ar/branches/branch/".$city_ID);
        }
    }
    
    function photofrom($image_id=0){
        $restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions_sub_detail=explode(',',$permissions['sub_detail']);
        if($permissions['accountType']==0){
            $this->session->set_flashdata('error', 'حزمة الخاص بك لا تحتوي على هذا العرض. الرجاء ترقية الحزمة الخاصة بك');
            redirect('ar/accounts');
        }
        
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['cities']=  $this->MGeneral->getAllCity(1);
        
        $data['hotels']=$this->MRestBranch->getAllHotels(1);
        
        $data['branches']=$this->MRestBranch->getAllBranches($restid);
        if($image_id==0){
            $data['title']='صورة فرع جديد - '.(htmlspecialchars($data['rest']['rest_Name_Ar']));
        }else{
            $data['photo']=$photo=$this->MRestBranch->getUserGalleryImage($image_id);
            $data['title']=(htmlspecialchars($photo['title'])).' - '.(htmlspecialchars($photo['title_ar']));
        }
        $data['main']='ar/branchphotoform';
        $data['js']='branchform,validate';
        $data['css']='ar';
        $this->load->view('ar/template',$data);
    }
    
    function savebranchimage(){
        $rest=$this->input->post('rest_fk_id');
        if($this->input->post('br_id') && $this->input->post('br_id')!="" ){
            $br_id=$this->input->post('br_id');
            $restname=$this->input->post('rest_Name');
            $image="";
            $title=$title_ar="";
            $ratio=$width=0;
            if(is_uploaded_file($_FILES['branch_image']['tmp_name'])){
                $image	= $this->MGeneral->uploadImage('branch_image','../uploads/Gallery/');
                list($width, $height, $type, $attr)= getimagesize('../uploads/Gallery/'.$image);
                if($width<200 && $height<200){
                    $this->session->set_flashdata('error', 'الصورة صغيرة جدا. يرجى تحميل الحجم الصحيح (200 × 200)  بكسل ');
                    redirect("ar/branches/photofrom/".$rest);
                }
                if(($width>800)||($height>500)){
                    $this->images->resize('../uploads/Gallery/' . $image,800,500,'../uploads/Gallery/' .$image);
                }
                    
                list($width, $height, $type, $attr)= getimagesize('../uploads/Gallery/'.$image);
                $ratio= $width/$height;
                $config['source_image']	= '../uploads/Gallery/'. $image;
                $config['wm_text'] = $restname.' - Sufrati.com';
                $config['wm_type'] = 'text';
                $config['wm_font_path'] = './css/text.ttf';
                $config['wm_font_size']	= '13';
                $config['wm_font_color'] = 'ffffff';
                $config['wm_vrt_alignment'] = 'bottom';
                $config['wm_hor_alignment'] = 'right';
                $config['wm_padding']='-10';
                $this->image_lib->initialize($config);
                $this->image_lib->watermark();
                $this->image_lib->clear();
                $config['maintain_ratio'] = TRUE;
                $this->load->library('images',$config);
                $height1=round($height*(200/$width));
                $height2=round($height*(230/$width));
                $this->images->squareThumb('../uploads/Gallery/' . $image,'../uploads/Gallery/thumb/' . $image,100);
                $this->images->resize('../uploads/Gallery/' . $image,200,$height1,'../uploads/Gallery/200/' .$image);
                $this->images->resize('../uploads/Gallery/' . $image,230,$height2,'../uploads/Gallery/230/' .$image);
                $this->images->resize('../uploads/Gallery/' . $image,45,45,'../uploads/Gallery/45/' .$image);
                $this->images->squareThumb('../uploads/Gallery/' . $image,'../uploads/Gallery/200x200/' . $image,200);
                $this->images->squareThumb('../uploads/Gallery/' . $image,'../uploads/Gallery/150x150/' . $image,150);
				$theight=$height*(400/$width);
                $this->images->resize('../uploads/Gallery/' . $image,400,$theight,'../uploads/Gallery/400x/' .$image);

            }else{
                $image=($this->input->post('branch_image_old'));
            }
            $title=($this->input->post('title'));
            $title_ar=($this->input->post('title_ar'));
            $branch=$this->MRestBranch->getBranch($br_id);
            $restData=$this->MGeneral->getRest($rest);
            if($title=="" || empty($title) ){
                $title=$restData['rest_Name'].' '.$branch['br_loc'];
            }
            if($title_ar=="" || empty($title_ar) ){
                $title_ar=$restData['rest_Name_Ar'].' '.$branch['br_loc_ar'];
            }
            
            if($this->input->post('image_ID')){
                $image_ID=$this->input->post('image_ID');
                $this->MRestBranch->updateRest($rest);
                $this->MRestBranch->updateBranchImage($image_ID,$image,$title,$title_ar,$ratio,$width);                
            }else{
                $this->MRestBranch->updateRest($rest);
                $this->MRestBranch->addBranchImage($image,$title,$title_ar,$ratio,$width);            
            }
           
            $this->session->set_flashdata('message', 'تم تحديث صورة الفرع بنجاح');
            redirect("ar/branches/photos/".$br_id."/".$rest);
        }elseif(empty($br_id)){
            
        }
        
    }
    
    function photos($br_id=0,$rest_id){
        $restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions_sub_detail=explode(',',$permissions['sub_detail']);
        if($permissions['accountType']==0){
            $this->session->set_flashdata('error', 'حزمة الخاص بك لا تحتوي على هذا العرض. الرجاء ترقية الحزمة الخاصة بك');
            redirect('ar/accounts');
        }
        
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['branch']=$branch=$this->MRestBranch->getBranch($br_id);
        $data['title']=$branch['br_loc_ar'].' - '.$branch['district_Name_Ar'].' - '.$branch['city_Name_Ar'];
        $data['branchImages']=$this->MRestBranch->getBranchImages($br_id);
        $data['main']='ar/branchImages';
        $data['js']='branchform,validate';
        $data['css']='ar';
        $this->load->view('ar/template',$data);
    }
    
    function usergallerystatus($id=0){
        if(isset($_GET['id'])&&($_GET['id']!="")){
            $id=$_GET['id'];
        }
	$photo=$this->MRestBranch->getUserGalleryImage($id);
	if($photo['status']==1){
            $this->MRestBranch->deActivateUserGalleryImage($id);
            $this->session->set_flashdata('message','إلغاء تفعيل الصورة بنجاح');
        }else{
            $this->MRestBranch->activateUserGalleryImage($id);
            if(($photo['user_ID']!="")&&($photo['user_ID']!=0)){
                $this->MRestBranch->addNotification($photo['user_ID'],$id,'Photo approved','وافق الصورة');
            }
            $this->session->set_flashdata('message','تفعيل الصورة بنجاح');
        }
        if(isset($_GET['rest']) && !empty($_GET['rest'])){
            $this->MRestBranch->updateRest($_GET['rest']);
        }
        redirect("ar/branches/photos/".$_GET['br_id']."/".$_GET['rest']);
    }
    
    function usergallerydelete($id=0){
	if(isset($_GET['id'])&&($_GET['id']!="")){
            $id=$_GET['id'];
        }
        $this->MRestBranch->deleteUserGalleryImage($id);
        $this->session->set_flashdata('message','تفعيل حذف الصورة  بنجاح');  
        if(isset($_GET['rest']) && !empty($_GET['rest'])){
            $this->MRestBranch->updateRest($_GET['rest']);
        }
        redirect("ar/branches/photos/".$_GET['br_id']."/".$_GET['rest']);
    }
    
}