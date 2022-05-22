<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends CI_Model{
    function __construct() {
        parent::__construct();
    }
	
	public function get_notification($rest_id, $status = null, $limit =null)
	{
		$this->db->select('*');
		$this->db->from("notifications");

		if ( $status != null ) {
			$this->db->where(['rest_ID'=> $rest_id, 'status'=> $status] );
		} else {
			$this->db->where('rest_ID', $rest_id );
		}
		
		if ($limit != nulL) {
			$this->db->limit($limit);
		}

		$this->db->order_by('id', 'DESC');
		
		$notifications = $this->db->get();

		return $notifications->result();
	}
	 
}
