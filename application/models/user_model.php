<?php
class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
        
	function getUsersdata($data = 0,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = 'users';
            
            $this->db->select('*');
            
            if($data) {
                
                $where = array('id'=>$data);
            
                $this->db->where($where);
            }
            
            if($order_field) $this->db->order_by($order_field, $order_by);
            
            $query = $this->db->get($this->tbl_name,$limit,$offset);
            
            $rec_array = $query->result_array();
            
            return $rec_array;
	}
        
        function getNumRows($txt,$fld) {
            
            $this->tbl_name = "users";
            
            if($txt) {
                
                $txt = strtolower($txt);
            
                $this->db->select('*');

                    if($fld=='type' && $txt=='administrator') $where = array($fld=>1);

                    else if($fld=='type' && $txt=='user') $where = array($fld=>2);

                    else $where = array($fld=>$txt);

                    $this->db->where($where);

            }
            
            return $this->db->count_all_results($this->tbl_name);
        }
        

	function getFilterdata($txt,$fld,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = "users";
            
            $txt = strtolower($txt);
            
            $this->db->select('*');
            
                if($fld=='type' && $txt=='administrator') $this->db->like($fld,1,'after');
                
                else if($fld=='type' && $txt=='user') $this->db->like($fld,2,'after');
                
                else $this->db->like($fld,$txt,'after');

            $this->db->order_by($order_field, $order_by);
            
            $query = $this->db->get($this->tbl_name,$limit,$offset);
            
            return $query->result_array();
	}
        
        function addUser($data)
        {
            $this->tbl_name = "users";
            
            if(isset($data['status']) && $data['status']=='on') $data['status'] = 1;
                
            else $data['status'] = 0;
            
            $this->db->insert($this->tbl_name,$data);
            
        }
        
        function editUser($data,$id)
        {
            $this->tbl_name = "users";
            
            if(isset($data['status']) && $data['status']=='on') $data['status'] = 1;
                
            else $data['status'] = 0;
            
            $this->db->where('id', $id);
            
            $this->db->update($this->tbl_name,$data);
            
        }
        
        function delete($id) {
            
            $this->tbl_name = "users";
            
            $this->db->where('id', $id);
            
            $this->db->delete($this->tbl_name);
            
        }
        
        
}
?>