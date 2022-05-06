<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->library('pagination');
        $this->load->library('images');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == '')
        {
                redirect('home/login');
        }
    }
    
    function index($item=0){
        $limit=20;
        $ajax=0;
        $offset=0;
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        if(isset($_GET['sort'])&&($_GET['sort']!="")){
            $sort=($_GET['sort']);
        }
        if(isset($_GET['ajax'])&&($_GET['ajax']!="")){
            $ajax=($_GET['ajax']);
        }
	if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $limit=($_GET['limit']);
        }
	
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['pagetitle']=$data['title']="الصور - ".(htmlspecialchars($data['rest']['rest_Name_Ar']));
        
        $config['base_url'] = base_url().'photos?limit='.$limit;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['uri_segment'] = 4;
        $config['num_links'] = 4;
        $config['first_link'] = '<--';
        $config['first_tag_open'] = '<a href="#">';
        $config['first_tag_class'] = '</a>';
        $config['last_link'] = '-->';
        $config['anchor_class']='class="ajax-pagination-link"';
        $config['full_tag_open'] = '<div class="pagination ajax-pagination table-results" id="table-results">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class="active"><a href="javascript:void(0);" >';
        $config['cur_tag_close'] = '</a></span>';
        $config['total_rows']=$data['total']=$this->MRestBranch->getTotalRestImages($restid);
        $this->pagination->initialize($config);
        
        $data['images']=  $this->MRestBranch->getAllRestImages($rest);
        $data['css']='ar';
        $data['main']='ar/gallery';        
        $this->load->view('ar/template',$data);
    }
    
      function image($image=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $sub_detail_permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $newFlag=TRUE;
        
         if($image!=0){
             $newFlag=FALSE;
            $data['image']=$imageData=$this->MRestBranch->getRestImage($image);
            if($permissions['accountType']==0 && $imageData['user_ID']!=""){
                $this->session->set_flashdata('error', 'حزمة الخاص بك لا تحتوي على هذا العرض. الرجاء ترقية الحزمة الخاصة بك');
                redirect('ar/accounts');
            } 
            $data['pagetitle']=$data['title']=$data['image']['title_ar'].' - '.(htmlspecialchars($data['rest']['rest_Name_Ar']));;
        }else{
            $newFlag=TRUE;
            $data['pagetitle']=$data['title']='اضف صورة - '.(htmlspecialchars($data['rest']['rest_Name_Ar']));;
        }
        
        if($newFlag){
            ######PERMISSIONS#######
            $availableImage=0;
            if($permissions['accountType']==0){
                $availableImage=3;
            }
            if(in_array(6,$sub_detail_permissions)){
                $availableImage=3;
            }elseif(in_array(7,$sub_detail_permissions)){
                $availableImage=6;
            }elseif(in_array(8,$sub_detail_permissions)){
                $availableImage=120;
            }elseif(in_array(9,$sub_detail_permissions)){
                $availableImage=120;
            }
            
            $noOfImages=$this->MRestBranch->getRestAllImages($restid);
            //echo $availableImage;echo '- '.$noOfImages;exit; 
            if(in_array(6,$sub_detail_permissions) || in_array(7,$sub_detail_permissions) || in_array(8,$sub_detail_permissions)  || in_array(9,$sub_detail_permissions) ){
                if( $noOfImages >= $availableImage ){
                    $this->session->set_flashdata('error', 'يمكنك إضافة '.$this->MGeneral->convertToArabic($availableImage).' صورة فقط.  يرجى تحديث اشتراكك.');
                    redirect('ar/accounts');
                }
            }elseif($permissions['accountType']==0 && $noOfImages >= $availableImage ){
                $this->session->set_flashdata('error', 'يمكنك إضافة '.$this->MGeneral->convertToArabic($availableImage).' صورة فقط.  يرجى تحديث اشتراكك.');
                redirect('ar/accounts');
            }elseif( $permissions['accountType'] > 0  ){
                $this->session->set_flashdata('error', 'يمكنك إضافة '.$this->MGeneral->convertToArabic($availableImage).' صورة فقط.  يرجى تحديث اشتراكك.');
                redirect('ar/accounts');
            }
        }
       
        $data['css']='ar';
        $data['main']='ar/imageform';
	$data['js']='validate';
        $this->load->view('ar/template',$data);
    }
    
    function save($option=""){
        $rest=$this->input->post('rest_ID');
        $restaurant=$restdata=$this->MGeneral->getRest($rest,false,true);
        $restname=$restaurant['rest_Name'];
        if($this->input->post('title')){
            
            ######PERMISSIONS#######
            $permissions=$this->MBooking->restPermissions($rest);
            $sub_detail_permissions=explode(',',$permissions['sub_detail']);
            $availableImage=3;
            if(in_array(6,$sub_detail_permissions)){
                $availableImage=3;
            }elseif(in_array(7,$sub_detail_permissions)){
                $availableImage=6;
            }elseif(in_array(8,$sub_detail_permissions)){
                $availableImage=120;
            }elseif(in_array(9,$sub_detail_permissions)){
                $availableImage=120;
            }

            $noOfImages=$this->MRestBranch->getRestAllImages($rest);
            if(in_array(6,$sub_detail_permissions) || in_array(7,$sub_detail_permissions) || in_array(8,$sub_detail_permissions)  || in_array(9,$sub_detail_permissions) ){
                if( $noOfImages > $availableImage ){
                    $this->session->set_flashdata('error', 'يمكنك إضافة '.$this->MGeneral->convertToArabic($availableImage).' صورة فقط.  يرجى تحديث اشتراكك.');
                    redirect('ar/accounts');
                }
            }
            
            $image="";
            $width="";
            if($this->input->post('image_ID')){
                if(is_uploaded_file($_FILES['image_full']['tmp_name'])){
                    $image	= $this->MGeneral->uploadImage('image_full','../uploads/Gallery/');
                    list($width, $height, $type, $attr)= getimagesize('../uploads/Gallery/'.$image);
                    if($width<200 && $height<200){
                        $this->session->set_flashdata('error', 'الصورة صغيرة جدا. يرجى تحميل الحجم الصحيح (200 × 200)  بكسل ');
                        redirect("ar/gallery/image/''?rest=".$rest);
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
                }
                else{
                    $image = $_POST['image_full_old'];
                    $ratio=$_POST['ratio_old'];
                }
                $image_ID=$this->input->post('image_ID');
                $this->MRestBranch->updateRestImage($image,$ratio,$width);
                $this->MRestBranch->updateRest($rest);
                $this->session->set_flashdata('message','تحديث الصورة بنجاح');
                $this->MGeneral->addActivity('A new image is added. ',$image_ID);
		redirect('ar/gallery?rest='.$rest);
            }else{
                if(is_uploaded_file($_FILES['image_full']['tmp_name'])){
			$image	= $this->MGeneral->uploadImage('image_full','../uploads/Gallery/');
                        list($width, $height, $type, $attr)= getimagesize('../uploads/Gallery/'.$image);
                        if($width<200 || $height<200){
                            $this->session->set_flashdata('error', 'الصورة صغيرة جدا. يرجى تحميل الحجم الصحيح (200 × 200)  بكسل ');
                            redirect("ar/gallery/image?rest=".$rest);
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
                        
                        $image_ID=$this->MRestBranch->addRestImage($image,$ratio,$width);
                        $this->MGeneral->addActivity('A new image is added. ',$image_ID);
                        $this->MRestBranch->updateRest($rest);
                }
                $this->session->set_flashdata('message','إضافة الصورة بنجاح');                
		redirect('ar/gallery?rest='.$rest);
            }
        }else{
            $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/gallery');
        }
    }
    
    function delete($image=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $this->MRestBranch->updateRest($rest);
        if($image!=0){
            $this->MRestBranch->deleteRestImage($image);
            $this->session->set_flashdata('message','تفعيل حذف الصورة  بنجاح');
            redirect('ar/gallery');
        }else{
            $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/gallery');
        }
    }
    
    function makeFeaturedImage($image=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $rest=0;
        if(isset($_GET['rest']) && !empty($_GET['rest'])){
            $rest=$_GET['rest'];
        }
        if($image!=0 && $rest!=0){
            $permissions=$this->MBooking->restPermissions($rest);
            $imageData=$this->MRestBranch->getRestImage($image);
            if($permissions['accountType']==0 && $imageData['user_ID']!=""){
                $this->session->set_flashdata('error', 'حزمة الخاص بك لا تحتوي على هذا العرض. الرجاء ترقية الحزمة الخاصة بك');
                redirect('ar/accounts');
            }
            
            $this->MRestBranch->makeFeaturedImage($image,$rest);
            $this->MRestBranch->updateRest($rest);
            $this->session->set_flashdata('message','تفعيل الصورة  بنجاح');
            redirect('ar/gallery');
        }else{
            $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/gallery');
        }
    }
    
    function unsetFeaturedImage($image=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $rest=0;
        if(isset($_GET['rest']) && !empty($_GET['rest'])){
            $rest=$_GET['rest'];
        }
        if($image!=0 && $rest!=0){            
            $this->MRestBranch->unsetAsFeaturedImage($image,$rest);
            $this->MRestBranch->updateRest($rest);
            $this->session->set_flashdata('message','تفعيل الصورة  بنجاح');
            redirect('ar/gallery');
        }else{
            $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/gallery');
        }
    }
    
    
    
    
}