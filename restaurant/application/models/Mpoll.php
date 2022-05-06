<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MPoll extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function getLatestPoll(){
        $this->db->where('status',1)->where('rest_ID',0);
        $this->db->order_by('date_add',"DESC");
        $q=$this->db->get('fpoll_poll');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getResult($poll=0){
        $this->db->select('field,COUNT(field) as vote');
        $this->db->where('poll_id',$poll);
        $this->db->group_by('field');
        $this->db->order_by('vote','DESC');
        $q=$this->db->get('fpoll_options');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getAllPolls($restaurant=0,$status=0,$limit=0,$offset=""){
        $this->db->select('fpoll_poll.*,(SELECT restaurant_info.rest_Name FROM restaurant_info WHERE restaurant_info.rest_ID=fpoll_poll.rest_ID) as restaurant');
        if($status!=0){
            $this->db->where('status',1);
        }
        if($restaurant!=0){
            $this->db->where('rest_ID',$restaurant);
        }
        if($limit!=0){
            $this->db->limit($limit,$offset);
        }
        $this->db->order_by('status','DESC');
        $this->db->order_by('date_add','DESC');
        $q=$this->db->get('fpoll_poll');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getPastPolls($poll,$limit=10){
        $this->db->where('id !=',$poll);
        if($limit!=0){
            $this->db->limit($limit);
        }
        $this->db->where('status',1);
        $this->db->order_by('date_add','DESC');
        $q=  $this->db->get('fpoll_poll');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getTotalPolls($restaurant=0,$status=0){
        if($status!=0){
            $this->db->where('status',1);
        }
        if($restaurant!=0){
            $this->db->where('rest_ID',$restaurant);
        }
        return $this->db->count_all_results('fpoll_poll');
    }
    
    function getPollOptions($poll=0,$status=0){
        if($poll!=0){
            $this->db->where('poll_id',$poll);
        }
        if($status!=0){
            $this->db->where('status',1);
        }
        $q=$this->db->get('fpoll_options');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getTotalPollOptions($poll=0,$status=0){
        if($poll!=0){
            $this->db->where('poll_id',$poll);
        }
        if($status!=0){
            $this->db->where('status',1);
        }
        return $this->db->count_all_results('fpoll_options');
    }
    
    function getPoll($id=0){
        $this->db->where('id',$id);
        $q=$this->db->get('fpoll_poll');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getPollOption($id=0){
        $this->db->where('id',$id);
        $q=$this->db->get('fpoll_options');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function addPollQuestion($image){
        $status=0;
        if(isset($_POST['status'])){
            $status=1;
        }
        $data=array(
            'question'=>  ($this->input->post('question')),
            'question_ar'=>  ($this->input->post('question_ar')),
            'description'=>  ($this->input->post('description')),
            'descriptionAr'=>  ($this->input->post('descriptionAr')),
            'image'=>$image,
            'status'=>$status,
            'rest_ID'=>  ($this->input->post('rest_ID')),
            'updatedAt'=>date('Y-m-d H:i:s',now())
        );
        $this->db->insert('fpoll_poll',$data);
        return $this->db->insert_id();
    }
    
    function updatePollQuestion($image){
        $status=0;
        if(isset($_POST['status'])){
            $status=1;
        }
        $data=array(
            'question'=>  ($this->input->post('question')),
            'question_ar'=>  ($this->input->post('question_ar')),
            'description'=>  ($this->input->post('description')),
            'descriptionAr'=>  ($this->input->post('descriptionAr')),
            'image'=>$image,
            'status'=>$status,
            'rest_ID'=>  ($this->input->post('rest_ID')),
            'updatedAt'=>date('Y-m-d H:i:s',now())
        );
        $this->db->where('id',  $this->input->post('id'));
        $this->db->update('fpoll_poll',$data);
    }
    
    function deleteQuestion($id){
        $this->db->where('id',$id);
        $this->db->delete('fpoll_poll');
    }
    
    function activateQuestion($id=0){
        $data=array(
                'status'=>1,
                'updatedAt'=>date('Y-m-d H:i:s',now())
            );
        $this->db->where('id',$id);
        $this->db->update('fpoll_poll',$data);
   }
   
   function deActivateQuestion($id=0){
        $data=array(
                'status'=>0,
                'updatedAt'=>date('Y-m-d H:i:s',now())
            );
        $this->db->where('id',$id);
        $this->db->update('fpoll_poll',$data);
   }
    
   function addPollAnswer($field,$field_ar,$status=1,$poll=0){
        $data=array(
            'field'=>  $field,
            'field_ar'=>  $field_ar,
            'status'=>$status,
            'poll_id'=>$poll,
            'updatedAt'=>date('Y-m-d H:i:s',now())
        );
        $this->db->insert('fpoll_options',$data);
        return $this->db->insert_id();
    }
    
    function updatePollAnswer($field,$field_ar,$status=1,$poll=0,$id=0){
        $data=array(
            'field'=>  $field,
            'field_ar'=>  $field_ar,
            'status'=>$status,
            'poll_id'=>$poll,
            'updatedAt'=>date('Y-m-d H:i:s',now())
        );
        $this->db->where('id',$id);
        $this->db->update('fpoll_options',$data);
    }
    
    function deleteAnswer($id){
        $this->db->where('id',$id);
        $this->db->delete('fpoll_options');
    }
    
    function activateAnswer($id=0){
        $data=array(
                'status'=>1,
                'updatedAt'=>date('Y-m-d H:i:s',now())
            );
        $this->db->where('id',$id);
        $this->db->update('fpoll_options',$data);
   }
   
   function deActivateAnswer($id=0){
        $data=array(
                'status'=>0,
                'updatedAt'=>date('Y-m-d H:i:s',now())
            );
        $this->db->where('id',$id);
        $this->db->update('fpoll_options',$data);
   }
   
   
   
}
//End of File