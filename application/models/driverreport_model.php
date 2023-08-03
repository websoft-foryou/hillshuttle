<?php
class Driverreport_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}
        
	function search()
	{
         
                $fdate = '';
                $todate = '';
                $terminal = '';
                $suburb = '';
                $driv_assign = '';
                $driver = '';
                $driver_vals = '';
                $all_drivers = '';
                $alldrivers_val = '';
                $arr_sub = '';
                $suburbval = '';
                
            if($_POST) {
               
                if(isset($_POST['driv_assign'])) $driv_assign = $_POST['driv_assign'];
                if(isset($_POST['all_drivers'])) $all_drivers = $_POST['all_drivers'];
                if(isset($_POST['driver_val'])) $driver_vals = $_POST['driver_val'];
                if(isset($_POST['alldrivers_val'])) $alldrivers_val = $_POST['alldrivers_val'];
                if(isset($_POST['suburb'])) $suburbval = $_POST['suburb'];
                
                if(isset($_POST['suburb'])) {
                    
                    $arr_sub = '';
                   foreach ($_POST['suburb'] as $sub) {
                       $arr_sub.= "'".$sub."',";
                   }
                    $arr_sub = substr($arr_sub,0,-1);
                }
                
                $searchval = array('driver'=>$driver_vals,'terminal'=>$_POST['terminal'],'suburb'=>$arr_sub,'suburbval'=>$suburbval,'direction'=>$_POST['direction'],'drivassign'=>$driv_assign,'alldrivers'=>$all_drivers,'alldriversval'=>$alldrivers_val,'fdate'=>$_POST['fdate'],'todate'=>$_POST['todate']);
                
                $this->session->set_userdata($searchval);
            } 
            
               //print_r($_POST); exit;
               if($this->session->userdata('driver')) $driver = $this->session->userdata('driver');
               
               if($this->session->userdata('terminal')) $terminal = $this->session->userdata('terminal');
               
               if($this->session->userdata('suburb')) $suburb = $this->session->userdata('suburb');
               
               if($this->session->userdata('direction')) $direction = $this->session->userdata('direction');
               
               if($this->session->userdata('drivassign')) $driv_assign = $this->session->userdata('drivassign');

               if($this->session->userdata('alldrivers')) $all_drivers = $this->session->userdata('alldrivers');
               
               if($this->session->userdata('alldriversval')) $alldrivers_val = $this->session->userdata('alldriversval');
               
               if($this->session->userdata('fdate')) { $exp_fdate = explode('/',$this->session->userdata('fdate'));
                
                    $fdate = $exp_fdate[2].'-'.$exp_fdate[1].'-'.$exp_fdate[0];
                    
               }
               
               if($this->session->userdata('todate')) { $exp_tdate = explode('/',$this->session->userdata('todate'));
                
                    $todate = $exp_tdate[2].'-'.$exp_tdate[1].'-'.$exp_tdate[0];
                    
               }
               
               if($this->session->userdata('todate')=='') $todate = $fdate;
               
               if($this->session->userdata('fdate')=='') $fdate = $todate;
               //echo $fdate; exit;
               
                    $drivdate = array('fdbdate'=>$fdate,'todbdate'=>$todate);
                    $this->session->set_userdata($drivdate);
               
               $where = '';
               
               if(isset($fdate) && $fdate != '' && $direction=='departure') $where[] .= " dep_date >= '".$fdate."'";
               if(isset($fdate) && $fdate != '' && $direction=='arrival') $where[] .= " arr_date >= '".$fdate."'";
               if(isset($fdate) && $fdate != '' && $direction=='both') $where[] .= " (dep_date >= '".$fdate."' OR arr_date >= '".$fdate."')";
               
               if(isset($todate) && $todate != '' && $direction=='departure') $where[] .= " dep_date <= '".$todate."'";
               if(isset($todate) && $todate != '' && $direction=='arrival') $where[] .= " arr_date <= '".$todate."'";
               if(isset($todate) && $todate != '' && $direction=='both') $where[] .= " (dep_date <= '".$todate."' OR arr_date <= '".$todate."')";
               
               if(isset($direction)) {
                   
                   // terminal
                   if(isset($terminal) && $terminal!='' && $direction=='departure') $where[] .= " dep_terminal = '".$terminal."'";
                   else if(isset($terminal) && $terminal!='' && $direction=='arrival') $where[] .= " arr_terminal = '".$terminal."'";
                   else if(isset($terminal) && $terminal!='' && $direction=='both') $where[] .= " (dep_terminal = '".$terminal."' OR arr_terminal = '".$terminal."')";
                   
                    // suburb
                   if(isset($suburb) && $suburb!='' && $direction=='departure') $where[] .= " dep_suburb IN (".$suburb.")";
                   else if(isset($suburb) && $suburb!='' && $direction=='arrival') $where[] .= " arr_suburb IN (".$suburb.")";
                   else if(isset($suburb) && $suburb!='' && $direction=='both') $where[] .= " (dep_suburb IN (".$suburb.") OR arr_suburb IN (".$suburb."))";
                   
                    // driver
                   if(isset($driver) && $driver!='' && $direction=='departure') $where[] .= " dep_driver = '".$driver."'";
                   else if(isset($driver) && $driver!='' && $direction=='arrival') $where[] .= " arr_driver = '".$driver."'";
                   else if(isset($driver) && $driver!='' && $direction=='both') $where[] .= " (dep_driver = '".$driver."' OR arr_driver = '".$driver."')";
                   
                    // driver unassign
                   if(isset($driv_assign) && $driv_assign!='' && $direction=='departure') $where[] .= " dep_driver = '0'";
                   else if(isset($driv_assign) && $driv_assign!='' && $direction=='arrival') $where[] .= " arr_driver = '0'";
                   else if(isset($driv_assign) && $driv_assign!='' && $direction=='both') $where[] .= " (dep_driver = '0' OR arr_driver = '0')";

                    // all drivers
                   if(isset($alldrivers_val) && $alldrivers_val!='' && $direction=='departure') $where[] .= " dep_driver IN (".$alldrivers_val.")";
                   else if(isset($alldrivers_val) && $alldrivers_val!='' && $direction=='arrival') $where[] .= " arr_driver IN (".$alldrivers_val.")";
                   else if(isset($alldrivers_val) && $alldrivers_val!='' && $direction=='both') $where[] .= " ((dep_driver IN (".$alldrivers_val.")) OR (arr_driver IN (".$alldrivers_val.")))";
                   
               }
               
               if($where) $where = 'WHERE'.implode(' AND',$where).' AND cancel_book!=3';
               
                $query = "(SELECT id,user,client,type,direction,dep_address1,dep_address2,dep_suburb,dep_phone,dep_mobile,dep_drop_address1,dep_drop_address2,dep_drop_suburb,dep_date,dep_flight,dep_airline,dep_origin,dep_terminal,dep_time,dep_ourtime,dep_yourtime,dep_pickuptime,dep_passengers,dep_babyseats,dep_estfare,dep_driver,dep_comments,arr_address1,arr_address2,arr_suburb,arr_phone,arr_mobile,arr_drop_address1,arr_drop_address2,arr_drop_suburb,arr_date,arr_flight,arr_airline,arr_origin,arr_terminal,arr_time,arr_ourtime,arr_yourtime,arr_pickuptime,arr_passengers,arr_babyseats,arr_estfare,arr_driver,arr_comments,total,payment_method,book_type,created_date,updated_date,cancel_book,dep_booking_confirmed,arr_booking_confirmed,paid_status FROM booking ".$where.") 
                    UNION 
                    (SELECT id,user,client,type,direction,dep_address1,dep_address2,dep_suburb,dep_phone,dep_mobile,dep_drop_address1,dep_drop_address2,dep_drop_suburb,dep_date,dep_flight,dep_airline,dep_origin,dep_terminal,dep_time,dep_ourtime,dep_yourtime,dep_pickuptime,dep_passengers,dep_babyseats,dep_estfare,dep_driver,dep_comments,arr_address1,arr_address2,arr_suburb,arr_phone,arr_mobile,arr_drop_address1,arr_drop_address2,arr_drop_suburb,arr_date,arr_flight,arr_airline,arr_origin,arr_terminal,arr_time,arr_ourtime,arr_yourtime,arr_pickuptime,arr_passengers,arr_babyseats,arr_estfare,arr_driver,arr_comments,total,payment_method,book_type,created_date,updated_date,cancel_book,dep_booking_confirmed,arr_booking_confirmed,paid_status FROM multipickup_booking ".$where.") ORDER BY dep_date DESC, arr_date DESC";
          //  echo $query;
                $data = $this->db->query($query);
          
                return $data->result_array();
            
	}
        
        function emptyData() {

                $query = 'SELECT * FROM booking WHERE id=0';
            
                $data = $this->db->query($query);
          
                return $data->result_array();
            
        }
        
        function getClient($val) {

                $query = 'SELECT first_name,last_name FROM clients WHERE id='.$val;
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                if($row) $flname = $row[0]['first_name']." ".$row[0]['last_name'];
                else $flname='';
                
                return $flname;
            
        }
        
        function getDriver($val) {

                $query = 'SELECT first_name,last_name FROM drivers WHERE id='.$val;
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                if($row) $dname = $row[0]['first_name']." ".$row[0]['last_name'];
                else $dname = '';
                
                return $dname;
            
        }

    function multiServiceSelect($id,$suburb) {
          //print_r($suburb); exit;
            $this->hsdb->hs_open();
          $arr_sub = '';
          $selected = '';
            if(isset($suburb) && $suburb!='') {
                   
                   foreach ($suburb as $sub) {
                       $arr_sub.= "'".$sub."',";
                   }
                    $arr_sub = substr($arr_sub,0,-1);
            }
            
          $rows = $this->hsdb->hs_read_rows_sql("SELECT id,suburb from suburb where id='".$id."' AND suburb IN (".$arr_sub.")");                                              
          if(count($rows)>0) $selected="selected";
          
          return $selected;
    }
        

}
?>