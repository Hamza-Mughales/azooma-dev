<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Polls extends MY_Controller {
    public $data;
    function __construct(){
        parent::__construct();

        $this->load->model('Mpoll','MPoll');
        $this->load->model('Mgeneral',"MGeneral");
        $this->load->model('Mbooking',"MBooking");
        $this->load->model('Mrestbranch',"MRestBranch");
        $this->load->library('images');
        $this->load->library('pagination');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == ''){
            redirect('home/login');
        }
    }

    function index(){
        $limit=20;
        $offset=0;
        $ajax=0;
        $restaurant="";
        if(isset($_GET['ajax'])&&($_GET['ajax']!="")){
            $ajax=($_GET['ajax']);
        }
        if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $limit=($_GET['limit']);
        }
        if(isset($_GET['per_page'])&&($_GET['per_page']!="")){
            $offset=($_GET['per_page']);
        }
        
        $restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
       
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$rest=$this->MGeneral->getRest($restid,false,true);

        $data['limit']=$limit;
        $data['offset']=$offset;
	$data['rest_ID']=$restid;
        $data['nonew']=true;
        $data['poll']=  $this->MPoll->getAllPolls($restid,0,$limit,$offset);
        $config['base_url'] = base_url().'polls?limit='.$limit;
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
        $config['total_rows']=$data['total']=$this->MPoll->getTotalPolls($restid,0);
        $this->load->library('parser');
        $html= $this->parser->parse('pollhomepage',$data, true);
        $this->pagination->initialize($config);
        if($ajax==0){
            if(isset($rest['rest_Name'])){
                    $data['title']=$data['pagetitle']=(htmlspecialchars($rest['rest_Name']))." - Polls";
            }else{
                    $data['title']=$data['pagetitle']="All Polls";
            }
            $data['heads']=array('','Location','Location Arabic','Restaurant','City','District','Actions');
            $data['value']=$html;
           
            $data['main']='pollhome';
            $this->load->view('template',$data);
        }else{
            $result['html']=$html;
            $result['pagination']=$this->pagination->create_links();
            $output=json_encode($result);
            $this->output->set_content_type('application/json');
            $this->output->set_output($output);
        }
    }
    
    function form($id=0){
        $restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $newFlag=TRUE;
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$rest=$this->MGeneral->getRest($restid,false,true);
        
        if($id!=0){
            $newFlag=FALSE;
            $data['options']=$this->MPoll->getPollOptions($id);
            $data['poll']=$this->MPoll->getPoll($id);
            $data['title']=$data['pagetitle']=$data['poll']['question'];
        }else{
            $data['title']=$data['pagetitle']=(htmlspecialchars($rest['rest_Name']))." - New Poll";
        }
        
        if($newFlag){
            ######PERMISSIONS#######
            $permissions=$this->MBooking->restPermissions($restid);
            $sub_detail_permissions=explode(',',$permissions['sub_detail']);
            if( in_array(13,$sub_detail_permissions) && $permissions['accountType']==3 ){
            }else{
                $this->session->set_flashdata('error', 'Your current package does not have this service. Please upgrade your package.');
                redirect('accounts');
            }
        }
        
        $data['js']='poll,validate';
        $data['main']='pollform';
        $this->load->view('template',$data);
    }
    
    function save(){
        if($this->input->post('question')){
            if($this->input->post('id')){
                $poll=  $this->input->post('id');
                $rest_ID=  $this->input->post('rest_ID');
		$permissions=$this->MBooking->restPermissions($rest_ID);
                $sub_detail_permissions=explode(',',$permissions['sub_detail']);
                if( in_array(13,$sub_detail_permissions) ){
                }else{
                    $this->session->set_flashdata('error', 'Your current package does not have this service. Please upgrade your package.');
                    redirect('accounts');
                }
                
                $options=$this->MPoll->getPollOptions($poll);
                if(is_uploaded_file($_FILES['image']['tmp_name'])){
                    $image= $this->MGeneral->uploadImage('image',$this->config->item('upload_url').'images/poll/');
                    list($width, $height, $type, $attr)= getimagesize($this->config->item('upload_url').'images/poll/'.$image);
                    if($width<200 && $height<200){
                        $this->session->set_flashdata('error', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
                        redirect("ar/polls/form?restaurant=".$rest_ID);
                    }
                    if(($width>=400)||($height>=300)){
                        $this->images->resize($this->config->item('upload_url').'images/poll/' . $image,400,300,$this->config->item('upload_url').'images/poll/' .$image);
                    }
                    $this->images->resize($this->config->item('upload_url').'images/poll/' . $image,100,100,$this->config->item('upload_url').'images/poll/thumb/' .$image);
                    $this->images->squareThumb($this->config->item('upload_url').'images/poll/' . $image,$this->config->item('upload_url').'images/poll/thumb/'.$image,100);
                }
                else{
                    $image = $_POST['imageOld'];
                }
                $this->MPoll->updatePollQuestion($image);
                if(count($options)>0){
                    foreach ($options as $option){
                        if($this->input->post('field-'.$option['id'])){
                            $field=($this->input->post('field-'.$option['id']));
                            $field_ar=($this->input->post('field_ar-'.$option['id']));
                            $status=$option['status'];
                            $this->MPoll->updatePollAnswer($field,$field_ar,$status,$poll,$option['id']);
                        }else{
                            $this->MPoll->deleteAnswer($option['id']);
                        }
                    }
                }
                if(isset($_POST['option'])){
                    $option=$_POST['option'];$optionar=$_POST['option_ar'];
                    for($i=0;$i<count($option);$i++){
                        if($option[$i]!=""){
                            $field=$option[$i];
                            $fieldar=$optionar[$i];
                            $this->MPoll->addPollAnswer($field,$fieldar,1,$poll);
                        }
                    }
                }
                $this->MRestBranch->updateRest($rest_ID);
                $this->session->set_flashdata('message','Poll updated successfully');
                $this->MGeneral->addActivity('We have Updated our Poll.',$poll);
                redirect('polls');
		
            }else{
                $image="";
                if(is_uploaded_file($_FILES['image']['tmp_name'])){
                    $image= $this->MGeneral->uploadImage('image',$this->config->item('upload_url').'images/poll/');
                    list($width, $height, $type, $attr)= getimagesize($this->config->item('upload_url').'images/poll/'.$image);
                    if(($width>=400)||($height>=300)){
                        $this->images->resize('images/poll/' . $image,400,300,$this->config->item('upload_url').'images/poll/' .$image);
                    }
                    $this->images->resize($this->config->item('upload_url').'images/poll/' . $image,100,100,$this->config->item('upload_url').'images/poll/thumb/' .$image);
                    $this->images->squareThumb($this->config->item('upload_url').'images/poll/' . $image,$this->config->item('upload_url').'images/poll/thumb/'.$image,100);
                }
                $rest_ID=  $this->input->post('rest_ID');
                $poll=$this->MPoll->addPollQuestion($image);
                if(isset($_POST['option'])){
                    $option=$_POST['option'];$optionar=$_POST['option_ar'];
                    for($i=0;$i<count($option);$i++){
                        if($option[$i]!=""){
                            $field=$option[$i];
                            $fieldar=$optionar[$i];
                            $this->MPoll->addPollAnswer($field,$fieldar,1,$poll);
                        }
                    }
                }
                $this->MRestBranch->updateRest($rest_ID);
                $this->session->set_flashdata('message','Poll added successfully');
                $this->MGeneral->addActivity('We have Added a New Poll.',$poll);
                redirect('polls');
            }
        }else{
            $this->session->set_flashdata('error','Some error happened Please try again');
            redirect('polls');
        }
    }
    
    function questionstatus($poll=0){
        $cuisine=$this->MPoll->getPoll($poll);
        if($cuisine['status']==1){
            $this->MPoll->deActivateQuestion($poll);
            $this->session->set_flashdata('message','Poll Deactivated successfully');
        }else{
            $this->MPoll->activateQuestion($poll);
            $this->session->set_flashdata('message','Poll Activated successfully');
        }
        if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $offset=($_GET['per_page']);
            $limit=($_GET['limit']);
            redirect('polls?limit='.$limit.'&per_page='.$offset);
        }else{
            redirect('polls');
        }
    }
    
    function questiondelete($id=0){
        $cuisine=$this->MPoll->getPoll($id);
        $this->MPoll->deleteQuestion($id);
        $this->session->set_flashdata('message','Poll deleted successfully');
        if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $offset=($_GET['per_page']);
            $limit=($_GET['limit']);
            redirect('polls?limit='.$limit.'&per_page='.$offset);
        }else{
            redirect('polls');
        }
    }
    
    function options($poll=0){
        $limit=20;
        $offset=0;
        $ajax=0;
	$data['limit']=$limit;
        $data['offset']=$offset;
        $restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$rest=$this->MGeneral->getRest($restid,false,true);
        $data['id']=$poll;
	$data['options']=$this->MPoll->getPollOptions($poll);
        $data['poll']=$this->MPoll->getPoll($poll);
        $data['pagetitle']=$data['title']=$data['poll']['question'];
        
        $data['main']='polloptions';
        $this->load->view('template',$data);
    }
    
    function optionform($id=0,$pollid=0){
        if($this->input->post('field')){
            $poll=$this->input->post('poll_id');
            $status=$this->input->post('status');
            if(isset($status)){
                $status=1;
            }else{
                $status=0;
            }
            
            $field=$this->input->post('field');
            $field_ar=$this->input->post('field_ar');
            $option_id=$this->input->post('id');
            if($this->input->post('id')){
                $this->MPoll->updatePollAnswer($field,$field_ar,$status,$poll,$this->input->post('id'));
                $this->session->set_flashdata('message','Poll updated successfully');
                
                redirect('polls/options/'.$poll);
            }else{
                $option_id=$this->MPoll->addPollAnswer($field,$field_ar,$status,$poll);
                $this->session->set_flashdata('message','Poll added successfully');
                redirect('polls/options/'.$poll);
            }
        }else{
            $restid=$this->session->userdata('rest_id');
            $uuserid=$this->session->userdata('id_user');
            $permissions=$this->MBooking->restPermissions($restid);
            $permissions=explode(',',$permissions['sub_detail']);
            $data['settings']=$settings=  $this->MGeneral->getSettings();
            $data['sitename']=$this->MGeneral->getSiteName();
            $data['logo']=$logo=$this->MGeneral->getLogo();
            $data['rest']=$restdata=$rest=$this->MGeneral->getRest($restid,false,true);

            if(isset ($_GET['poll'])&&($_GET['poll']!="")){
                $poll=($_GET['poll']);
            }
            if($id!=0){
                $data['option']=$this->MPoll->getPollOption($id);
                $data['pagetitle']=$data['title']=$data['option']['field'];
                $data['poll']=$this->MPoll->getPoll($pollid);
                $data['poll_id']=$data['poll']['id'];
            }else{
                if(isset($_GET['poll'])){
                    $pollid=$_GET['poll'];
                }
                $data['poll']=$this->MPoll->getPoll($pollid);
                $data['poll_id']=$data['poll']['id'];
                $data['pagetitle']=$data['title']=$data['title']="New Option";
            }
           
            $data['main']='polloptionform';
            $data['js']='validate';
            $this->load->view('template',$data);
        }
    }
    
    
    function optionstatus($poll=0){
        $cuisine=$this->MPoll->getPollOption($poll);
        if($cuisine['status']==1){
            $this->MPoll->deActivateAnswer($poll);
            $this->session->set_flashdata('message','Poll options Deactivated successfully');           
        }else{
            $this->MPoll->activateAnswer($poll);
            $this->session->set_flashdata('message','Poll options Activated successfully');
        }
        if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $offset=($_GET['per_page']);
            $limit=($_GET['limit']);
            redirect('polls/options/'.$cuisine['poll_id'].'?limit='.$limit.'&per_page='.$offset);
        }else{
            redirect('polls/options/'.$cuisine['poll_id']);
        }
    }
    
    function optiondelete($id=0){
        $cuisine=$this->MPoll->getPollOption($id);
        $this->MPoll->deleteAnswer($id);
        $this->session->set_flashdata('message','Poll options deleted successfully');
        if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $offset=($_GET['per_page']);
            $limit=($_GET['limit']);
            redirect('polls/options/'.$cuisine['poll_id'].'?limit='.$limit.'&per_page='.$offset);
        }else{
        redirect('polls/options/'.$cuisine['poll_id']);
        }
    }
}