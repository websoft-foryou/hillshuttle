<?php
class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
	function authenticateUser($data)
	{
            $this->tbl_name = "users";
            
            $username = $data['username'];
            
            $pass = $data['password'];
            
            $this->db->select('id, first_name, last_name, username, type, status');
            
            $where = array('username'=>$username,'password'=>$pass);
            
            $this->db->where($where);
            
            $where_status = array('status'=>'1');
            
            $this->db->where($where_status);
            
            $query = $this->db->get($this->tbl_name);
            
            return $query->result();
	}
}
?>