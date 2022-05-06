<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MVideo extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function getAllVideos($rest=-1,$status=0,$limit=0,$offset="",$sort="latest",$current=0,$titleflag=false){
        $this->db->select('rest_video.*,(SELECT restaurant_info.rest_Name FROM restaurant_info WHERE restaurant_info.rest_ID=rest_video.rest_ID) as restaurant');
        $this->db->select('(SELECT COUNT(*) FROM videocomment WHERE videocomment.videoID=rest_video.id AND videocomment.status=1) as comment');
        if($rest!=-1){
            if($rest==1){
                $this->db->where('rest_ID >',0);
            }else{
                $this->db->where('rest_ID',$rest);
            }
        }
        if($current!=0){
            $this->db->where('rest_video.id !=',$current);
        }
        if($status!=0){
            $this->db->where('status',1);
        }
        
        if($titleflag==true){
            $this->db->where('name_ar', "")->or_where('video_description_ar',"");
        }
        
        if($limit!=0){
            $this->db->limit($limit,$offset);
        }
        switch($sort){
            case "latest":
                $this->db->order_by('add_date','DESC');
                break;
            case "name":
                $this->db->order_by('name_en','ASC');
                break;
            case 'popular':
                $this->db->order_by('view','DESC');
                break;
        }
        $q=$this->db->get('rest_video');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getVideo($video,$status=0){
        $this->db->where('id',$video);
        if($status!=0){
            $this->db->where('status',1);
        }
        $q=  $this->db->get('rest_video');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getComments($video=0,$status=0){
        $this->db->where('videoID',$video);
        if($status!=0){
            $this->db->where('status',1);
        }
        $q=  $this->db->get('videocomment');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getTotalVideos($rest=-1,$status=0,$titleflag=false){
        if($rest!=-1){
            if($rest==1){
                $this->db->where('rest_ID >',0);
            }else{
                $this->db->where('rest_ID',$rest);
            }
        }
        if($status!=0){
            $this->db->where('status',1);
        }
        if($titleflag==true){
            $this->db->where('name_ar', "")->or_where('video_description_ar',"");
        }
        return $this->db->count_all_results('rest_video');
    }
    
    function getRestVideo($id=0){
        $this->db->where('id',$id);
        $q=$this->db->get('rest_video');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function addRestVideo(){
        $status=0;
        if(isset($_POST['status'])){
            $status=1;
        }
        $data=array(
            'name_en'=>  ($this->input->post('name_en')),
            'name_ar'=>  ($this->input->post('name_ar')),
            'youtube_en'=>  ($this->input->post('youtube_en')),
            'youtube_ar'=>  ($this->input->post('youtube_ar')),
            'video_description'=>  ($this->input->post('video_description')),
            'video_description_ar'=>  ($this->input->post('video_description_ar')),
            'video_tags'=>  ($this->input->post('video_tags')),
            'video_tags_ar'=>  ($this->input->post('video_tags_ar')),
            'rest_ID'=>  ($this->input->post('rest_ID')),
            'status'=>$status,
            'updatedAt'=>date('Y-m-d H:i:s',now())
        );
        $this->db->insert('rest_video',$data);
        return $this->db->insert_id();
    }
    
    function updateRestVideo(){
        $status=0;
        if(isset($_POST['status'])){
            $status=1;
        }
        $data=array(
            'name_en'=>  ($this->input->post('name_en')),
            'name_ar'=>  ($this->input->post('name_ar')),
            'youtube_en'=>  ($this->input->post('youtube_en')),
            'youtube_ar'=>  ($this->input->post('youtube_ar')),
            'video_description'=>  ($this->input->post('video_description')),
            'video_description_ar'=>  ($this->input->post('video_description_ar')),
            'video_tags'=>  ($this->input->post('video_tags')),
            'video_tags_ar'=>  ($this->input->post('video_tags_ar')),
            'rest_ID'=>  ($this->input->post('rest_ID')),
            'status'=>$status,
            'updatedAt'=>date('Y-m-d H:i:s',now())
        );
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('rest_video',$data);
    }
    
    function changeStatusRestVideo($id=0){
        $this->db->where('id',$id);
        $q=$this->db->get('rest_video');
        if($q->num_rows()>0){
            $video=$q->row_Array();
            if($video['status']==1){
                $data=array(
                    'status'=>0,
                    'updatedAt'=>date('Y-m-d H:i:s',now())
                );
            }else{
                $data=array(
                    'status'=>1,
                    'updatedAt'=>date('Y-m-d H:i:s',now())
                );
            }
            $this->db->where('id',$id);
            $this->db->update('rest_video',$data);
        }
    }
	
} 
//End
?>