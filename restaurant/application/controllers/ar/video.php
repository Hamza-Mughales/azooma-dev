<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Video extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->model('MVideo');
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == ''){
            redirect('home/login');
        }
    }

    public function index()
    {
        $limit=20;
        $ajax=0;
        $offset=0;
        if(isset($_GET['ajax'])&&($_GET['ajax']!="")){
            $ajax=($_GET['ajax']);
        }
        if(isset($_GET['per_page'])&&($_GET['per_page']!="")){
            $offset=($_GET['per_page']);
        }
        if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $limit=($_GET['limit']);
        }
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        
        $config['base_url'] = base_url().'ar/video?limit='.$limit;
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
        $config['total_rows']=$data['total']=$this->MVideo->getTotalVideos($rest,0);
        $this->pagination->initialize($config);
        
        $data['pagetitle'] = $data['title'] = (htmlspecialchars($restdata['rest_Name_Ar']))." - كليبات الفيدي ";
        $data['css']='ar';
        $data['videos']=  $this->MVideo->getAllVideos($rest,0,$limit,$offset);
        
        $data['main']='ar/video';
        $this->load->view('ar/template',$data);
    }
    
    function form($id=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $newFlag=TRUE;
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        
        if($id!=0){
            $newFlag=FALSE;
            $data['video']=$this->MVideo->getRestVideo($id);
            $data['title']=$data['pagetitle']=$data['video']['name_ar'];
        }else{
            $data['title']=$data['pagetitle']='إضافة  فيديو - '.(htmlspecialchars($restdata['rest_Name_Ar']));
        }
        
        if($newFlag){
            ######PERMISSIONS#######
            $permissions=$this->MBooking->restPermissions($restid);
            $sub_detail_permissions=explode(',',$permissions['sub_detail']);        
            if( in_array(15,$sub_detail_permissions) ){
                 $totalVideos=$this->MVideo->getTotalVideos($rest);
                 $availableVideos=0;
                 if($permissions['accountType']==2){##SLIVER ACCOUNT
                     $availableVideos=1;
                 }elseif($permissions['accountType']==300){ ##GOLD ACCOUNT
                     $availableVideos=300;
                 }
                 if( $totalVideos >= $availableVideos ){                     
                     $this->session->set_flashdata('error', 'يمكنك إضافة '.$this->MGeneral->convertToArabic($availableVideos).' الفيديو فقط.  يرجى تحديث اشتراك.');
                     redirect('ar/accounts');
                 }
             }else{
                 $this->session->set_flashdata('error', 'حزمة الخاص بك لا تحتوي على هذا العرض. الرجاء ترقية الحزمة الخاصة بك');
                 redirect('ar/accounts');
             }
        }
        $data['css']='ar';
        $data['main']='ar/videoform';
        $data['js']='validate';
        $this->load->view('ar/template',$data);
    }
    
    function save($option=""){
        $rest=$restid=$this->input->post('rest_ID');
        $restaurant=$restdata=$this->MGeneral->getRest($restid,false,true);
        $restname=$restaurant['rest_Name'];
        if($this->input->post('name_en')){
            if($this->input->post('id')){
                $video_id=$this->input->post('id');
                $this->MVideo->updateRestVideo();
                $this->MRestBranch->updateRest($rest);
                $this->session->set_flashdata('message','تم تحديث معلوماتك بنجاح');
                $this->MGeneral->addActivity('We have Updated our video.',$video_id);
                redirect('ar/video');
            }else{
                $video_id=$this->MVideo->addRestVideo();
                $this->MRestBranch->updateRest($rest);
                $this->session->set_flashdata('message','تم تحميل معلوماتك بنجاح');
                $this->MGeneral->addActivity('We have added a New video.',$video_id);
                redirect('ar/video');
            }
        }else{
            $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/video');
        }
    }
    
    function status($id=0){
        $rest=($_GET['rest']);
        $offer=$this->MVideo->getRestVideo($id);
        $this->MVideo->changeStatusRestVideo($id);
        $this->MRestBranch->updateRest($rest);
        if($offer['status']==1){    
            $this->session->set_flashdata('message',' الفيديو الغير نشط بنجاح ');
        }else{
            $this->session->set_flashdata('message','  الفيديو المنشط بنجاح ');
        }
        redirect('ar/video');
    }
}