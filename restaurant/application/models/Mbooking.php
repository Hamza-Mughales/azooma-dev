<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MBooking extends CI_Model{
    function __construct() {
        parent::__construct();
    }
	
	public function memeberAccountStatus($username,$password)
	{
		$this->db->select('*');
		$this->db->from('booking_management');
		$this->db->where(array('user_name'=>$username,'password'=>$password));
		$query = $this->db->get();
		$results = $query->row_array();
		return $results;
	}
	
	public function restPermissions( $id )
	{

		$this->db->from('subscription');
		$this->db->where('rest_ID', $id);
		$query = $this->db->get();
		$row = $query->row_array();
		return $row;
	}
        public function getMemmberAccountDetails($id)
	{
            $this->db->select('user_name,password,preferredlang,full_name,email,phone');
            $this->db->where('id_user', $id);
            $this->db->where('status', 1);
            $query = $this->db->get('booking_management');
            $results = $query->row_array();
            return $results;
	}
        
        public function changePassword( $id = NULL )
	{
            $data=array();
            $data['password'] = $_POST['new_password'];
            $data['date_upd']= date('Y-m-d H:i:s');
            $this->db->where('id_user', $id);
            $this->db->update('booking_management', $data);
	}
	 
}
