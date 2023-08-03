<?php
class Driver_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
        
	function getDriversdata($data = 0,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = "drivers";
            
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
            
            $this->tbl_name = "drivers";
            
            if($txt) {
                
                $txt = strtolower($txt);
            
                $this->db->select('*');

                if($fld=='state' && $txt=='act') $where = array($fld=>1);
                
                else if($fld=='state' && $txt=='nsw') $where = array($fld=>2);
                
                else if($fld=='state' && $txt=='nt') $where = array($fld=>3);
                
                else if($fld=='state' && $txt=='qld') $where = array($fld=>4);
                
                else if($fld=='state' && $txt=='sa') $where = array($fld=>5);
                
                else if($fld=='state' && $txt=='tas') $where = array($fld=>6);
                
                else if($fld=='state' && $txt=='vic') $where = array($fld=>7);
                
                else if($fld=='state' && $txt=='wa') $where = array($fld=>8);

                else $where = array($fld=>$txt);

                $this->db->where($where);

            }
            
            return $this->db->count_all_results($this->tbl_name);
        }
        

	function getFilterdata($txt,$fld,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = "drivers";
            
            $txt = trim(strtolower($txt));
            
            $this->db->select('*');
            
                if($fld=='state' && $txt=='act') $this->db->like($fld,1,'after');
                
                else if($fld=='state' && $txt=='nsw') $this->db->like($fld,2,'after');
                
                else if($fld=='state' && $txt=='nt') $this->db->like($fld,3,'after');
                
                else if($fld=='state' && $txt=='qld') $this->db->like($fld,4,'after');
                
                else if($fld=='state' && $txt=='sa') $this->db->like($fld,5,'after');
                
                else if($fld=='state' && $txt=='tas') $this->db->like($fld,6,'after');
                
                else if($fld=='state' && $txt=='vic') $this->db->like($fld,7,'after');
                
                else if($fld=='state' && $txt=='wa') $this->db->like($fld,8,'after');
                
                else $this->db->like($fld,$txt,'after');

            $this->db->order_by($order_field, $order_by);
            
            $query = $this->db->get($this->tbl_name,$limit,$offset);
            
            return $query->result_array();
	}
        
        function addDriver($data)
        {
            $this->tbl_name = "drivers";
            
            if(isset($data['dob']) && $data['dob']!='') {
                
                $exp_date = explode('/',$data['dob']);
                
                $data['dob'] = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
            }
            else  $data['dob'] = '';
                
            if(isset($data['status']) && $data['status']=='on') $data['status'] = 1;
                
            else $data['status'] = 0;
            
            $this->db->insert($this->tbl_name,$data);
            
        }
        
        function editDriver($data,$id)
        {
            $this->tbl_name = "drivers";
            
            if(isset($data['dob']) && $data['dob']!='') {
                
                $exp_date = explode('/',$data['dob']);
                
                $data['dob'] = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
            }
            else  $data['dob'] = '';
            
            if(isset($data['status']) && $data['status']=='on') $data['status'] = 1;
                
            else $data['status'] = 0;
            
            $this->db->where('id', $id);
            
            $this->db->update($this->tbl_name,$data);
            
        }
        
        function delete($id) {
            
            $this->tbl_name = "drivers";
            
            $this->db->where('id', $id);
            
            $this->db->delete($this->tbl_name);
            
        }
        
}
?>