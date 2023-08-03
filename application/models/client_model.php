<?php
class Client_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
        
	function getClientsdata($data = 0,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = "clients";
            
            $this->db->select('*');
            
            if($data) {
                
                $where = array('id'=>$data);
            
                $this->db->where($where);
            }
            
            //if($order_field) $this->db->order_by($order_field, $order_by);
            $this->db->order_by('id', 'desc');
            
            $query = $this->db->get($this->tbl_name,$limit,$offset);
            
            return $query->result_array();
	}

        function getNumRows($txt,$fld) {
            
            $this->tbl_name = "clients";
            
            if($txt) {
                
                $txt = strtolower($txt);
            
                $this->db->select('*');

                if($fld=='address') {
                   $this->db->like('address1',$txt,'after'); 
                   $this->db->or_like('suburb',$txt,'after'); 
                }
                else {
                    $this->db->like($fld,$txt,'after');
                }

            }
            
            return $this->db->count_all_results($this->tbl_name);
        }
        
	function getFilterdata($txt,$fld,$offset,$limit,$order_field,$order_by)
	{
            $this->tbl_name = "clients";
            
            $txt = strtolower($txt);
            
            $this->db->select('*');
            
            if($fld=='address') {
               $this->db->like('address1',$txt,'after'); 
               $this->db->or_like('suburb',$txt,'after'); 
            }
            else {
                $this->db->like($fld,$txt,'after');
            }
                //$this->db->order_by($order_field, $order_by);
                $this->db->order_by('id', 'desc');
            
            $query = $this->db->get($this->tbl_name,$limit,$offset);
            
            return $query->result_array();
	}
        
        function addClient($data)
        {
            
            if(isset($data['dob']) && $data['dob']!='') {
                
                $exp_date = explode('/',$data['dob']);
                
                $data['dob'] = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
            }
            else $data['dob'] = '';
            
            // check duplicate
            $fval = $data['first_name'];
            $lval = $data['last_name'];
            $add = $data['address1'];
            $mail = $data['email'];
            $suburb = $data['suburb'];
            
            $this->tbl_name = "clients";
            
            $this->db->select('*');
            
            $this->db->where('first_name',$fval);
            
            $this->db->where('last_name',$lval);
            
            $this->db->like('address1',$add);
            
            if($mail) $this->db->where('email',$mail);
            
            $this->db->where('suburb',$suburb);
            
            $query = $this->db->get($this->tbl_name);
            
            $row = $query->result_array();
            
            $clicount = count($row);
            
            if($clicount>0) {
                
                // update client
                if(empty($mail)) unset($data['email']);
                
                $cid = $row[0]['id'];
                
                $this->db->where('id', $cid);
            
                $this->db->update($this->tbl_name,$data);
                
                return $cid;
            }
            else {
                // insert client
                
            $pass = $this->rand_string(6);
            
            $data['password'] = md5($pass);
            
            $climail = $data['email'];
            
            $this->tbl_name = "clients";
            
            $this->db->insert($this->tbl_name,$data);
            
            $last_insert_id = $this->db->insert_id();
            
            if($climail) $this->clientMail($climail,$pass);
            
            return $last_insert_id;
            
            }
            
        }
        
        function editClient($data,$id)
        {
            $this->tbl_name = "clients";
            
            if(isset($data['dob']) && $data['dob']!='') {
                
                $exp_date = explode('/',$data['dob']);
                
                $data['dob'] = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
            }
            else $data['dob'] = '';
            
            $this->db->where('id', $id);
            
            $this->db->update($this->tbl_name,$data);
            
        }
        
        function delete($id) {
            
            $this->tbl_name = "clients";
            
            $this->db->where('id', $id);
            
            $this->db->delete($this->tbl_name);
            
        }
        
	function getPriordata($data = 0)
	{
            $this->tbl_name = "booking";
            
            $this->db->select('*');
            
            if($data) {
                
                $where = array('client'=>$data);
            
                $this->db->where($where);
            }
            
            $this->db->order_by('id', 'desc');
            
            $query = $this->db->get($this->tbl_name);
            
            return $query->result_array();
	}

        function clientMail($receiver,$pass) {
            
            $this->tbl_name = "mail_trigger";
                            // from mail address
            $msgrow = $this->getMailtemp();
            
                            $default_email_config = $this->config->item('default_email_config');
                            $frm_mail = $default_email_config['from'];
                            
        $subject = $msgrow[0]['subject'];
        
        $message = $msgrow[0]['content'];
        $message = str_replace('{email}',$receiver,$message);
        $message = str_replace('{password}',$pass,$message);
                            
                            $crdate = date('Y-m-d H:i:s');
                            $mdata = array('from'=>$frm_mail,'to'=>$receiver,'subject'=>$subject,'message'=>$message,'created_date'=>$crdate);
                            
                            $this->db->insert($this->tbl_name,$mdata);
            
        }
        
        function getMailtemp() {

                $query = "select * from email_templates where id=29";
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                return $row;
            
        }
        
function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}
        
}
?>