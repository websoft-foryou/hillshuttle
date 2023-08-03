<?php
class Mail_log_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
        
	function getTempdata($data = 0,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = 'mail_trigger';
            
            $this->db->select('*');
            
            if($order_field) $this->db->order_by($order_field, $order_by);
            
            $query = $this->db->get($this->tbl_name,$limit,$offset);
            
            $rec_array = $query->result_array();
            
            return $rec_array;
	}
        
        function getNumRows($txt,$fld) {
            
            $this->tbl_name = "mail_trigger";
            
            if($txt!='') {
                
                $txt = strtolower($txt);
            
                $this->db->select('*');

                    $where = array($fld=>$txt);

                    $this->db->where($where);

            }
            
            return $this->db->count_all_results($this->tbl_name);
        }
        

	function getFilterdata($txt,$fld,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = "mail_trigger";
            
            $txt = strtolower($txt);
            
            $this->db->select('*');
            
                if($fld=='sent_date') {
                    $dtxt = '';
                    $extxt = explode('/', $txt);
                    if(count($extxt)=='3') $dtxt = $extxt[2].'-'.$extxt[1].'-'.$extxt[0];
                    else $dtxt = $txt;
                    $where = array('date(sent_date)'=>$dtxt);
                    $this->db->where($where);
                    //$this->db->like('date(sent_date)',$txt,'after');
                }
                else $this->db->like($fld,$txt,'after');
                
            $this->db->order_by($order_field, $order_by);
            
            $query = $this->db->get($this->tbl_name,$limit,$offset);
            
            return $query->result_array();
	}
        
        
}
?>