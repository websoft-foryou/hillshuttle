<?php
class Daysheet_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
                $this->load->model('booking_model');

	}
        
	function search()
	{
         
               $fdate = '';
               $todate = '';
               
                            $decimal_pointer = $this->config->item('decimal_point');
                            $dec_point = $decimal_pointer['point'];
                            $prg = $decimal_pointer['prr'];
                            $dollar = $decimal_pointer['dollar'];
               
            if($_POST) {
                
                // grid update
                if((isset($_POST['autoval']) && $_POST['autoval']!='') && $_POST['mode']=='save') {
                    
                     for($k=0; $k<count($_POST['autoval']); $k++) {
                         $upid = '';
                         $aid = '';
                         $depdriver = '';
                         $arrdriver = '';
                         $deppickuptime = '';
                         $arrpickuptime = '';
                         $data = '';
                          
                         //echo $_POST['dep_confirm'][1]; exit;
                       //if($_POST['pichrs_val'][$k]!='' && $_POST['picmin_val'][$k]!='') {
                           
                        if($_POST['dirval'][$k]=='Departure') {
                            
                           $depdriver = $_POST['driver_val'][$k];

                           $pickhrsval = '00';
                           $pickminval = '00';
                           
                            if($_POST['pichrs_val'][$k]!='0') $pickhrsval = $_POST['pichrs_val'][$k];
                            if($_POST['picmin_val'][$k]!='0') $pickminval = $_POST['picmin_val'][$k];

                            if($pickhrsval!='' || $pickminval!='') {
                                
                                if($pickhrsval=='') $pickhrsval = '00';
                                if($pickminval=='') $pickminval = '00';
                                
                                $deppickuptime = $pickhrsval.':'.$pickminval;
                                
                            }
                            
                         $depconfirm = $_POST['chk_confirm'][$k];
                         
                         if($_POST['batch'][$k]!='') $depbatch = $_POST['batch'][$k];
                         else $depbatch = 'empty';
                         
                            $data = array('dep_driver'=>$depdriver,'dep_pickuptime'=>$deppickuptime,'dep_booking_confirmed'=>$depconfirm,'dep_batch'=>$depbatch);
                            
                         //   echo $_POST['autoval'][$k].'-dep_driver='.$depdriver.'-dep_pickuptime='.$deppickuptime.'-dep_booking_confirmed='.$depconfirm.'-dep_batch='.$depbatch;
                          //  echo '<br/>';
                        }

                        if($_POST['dirval'][$k]=='Arrival') {
                            
                           $arrdriver = $_POST['driver_val'][$k];
                           
                           $arrpickhrsval = '00';
                           $arrpickminval = '00';
                           
                            if($_POST['pichrs_val'][$k]!='0') $arrpickhrsval = $_POST['pichrs_val'][$k];
                            if($_POST['picmin_val'][$k]!='0') $arrpickminval = $_POST['picmin_val'][$k];

                            if($arrpickhrsval!='' || $arrpickminval!='') {
                                
                                if($arrpickhrsval=='') $arrpickhrsval = '00';
                                if($arrpickminval=='') $arrpickminval = '00';
                                
                                $arrpickuptime = $arrpickhrsval.':'.$arrpickminval;
                            }
                            
                         $arrconfirm = $_POST['chk_confirm'][$k];
                         
                         if($_POST['batch'][$k]!='') $arrbatch = $_POST['batch'][$k];
                         else $arrbatch = 'empty';
                            
                            $data = array('arr_driver'=>$arrdriver,'arr_pickuptime'=>$arrpickuptime,'arr_booking_confirmed'=>$arrconfirm,'arr_batch'=>$arrbatch);
                         //   echo $_POST['autoval'][$k].'-arr_driver='.$arrdriver.'-arr_pickuptime='.$arrpickuptime.'-arr_booking_confirmed='.$arrconfirm.'-arr_batch='.$arrbatch;
                         //   echo '<br/>';
                        }
                        
                        $aid = $_POST['autoval'][$k];
                            
                        if($aid) {
                            $this->tbl_name = "booking";
                            $this->db->where('id', $aid);
                            $this->db->update($this->tbl_name,$data);
                            
                           $this->tbl_name = "multipickup_booking";
                           $this->db->where('book_id', $aid);
                           $this->db->update($this->tbl_name,$data);
                           
                        }
                            // get multi booking data
                           // $book_all = $this->getMultibooking($upid);
                           
                       // }
                  //   }
                        // add to mail_trigger table
                        $msgcontent = '';
                        $mdepdate = '';
                        $mdepaddress = '';
                        $depestfareval = '';
                        $arrflightval = '';
                        $arrourtimeval = '';
                        $totalval = '';
                        $wait_place = '';
                        $arrterminalval = '';
                        
                    }
                    
                }
                
                // session value
                $searchval = array('fdate'=>$_POST['fdate'],'todate'=>$_POST['todate']);
                
                $this->session->set_userdata($searchval);
                
                // mail configuration
                        if($_POST['updated_bookid']!='' && $_POST['mail_confirm_log']=='yes') {
                            $this->daysheetMailsend($_POST['updated_bookid']);
                        }
                
            } 
// update end
            
            // search form start
               if($this->session->userdata('fdate')) { $exp_fdate = explode('/',$this->session->userdata('fdate'));
                
                    $fdate = $exp_fdate[2].'-'.$exp_fdate[1].'-'.$exp_fdate[0];
               }

               if($this->session->userdata('todate')) { $exp_todate = explode('/',$this->session->userdata('todate'));
                
                    $todate = $exp_todate[2].'-'.$exp_todate[1].'-'.$exp_todate[0];
               } 
               
               $this->session->set_userdata(array('showdate'=>$this->session->userdata('fdate')));

               if($this->session->userdata('todate')=='') $todate = $fdate;
               
               if($this->session->userdata('fdate')=='') $fdate = $todate;
               
               $where = '';
               if($fdate=='' && $todate=='') { 
                   $fdate = date('Y-m-d');
                    $todate = date('Y-m-d');
               } 
               
               $drivdate = array('fdbdate'=>$fdate,'todbdate'=>$todate);
               $this->session->set_userdata($drivdate);
               
               if(isset($fdate) && $fdate != '') $where .= " WHERE ((dep_date >= '".$fdate."' OR arr_date >= '".$fdate."') AND (dep_date <= '".$todate."' OR arr_date <= '".$todate."') AND cancel_book!=3)";
               
                $query = "(SELECT id as auto,user,client,type,direction,dep_address1,dep_address2,dep_suburb,dep_phone,dep_mobile,dep_drop_address1,dep_drop_address2,dep_drop_suburb,dep_date,dep_flight,dep_airline,dep_origin,dep_terminal,dep_time,dep_ourtime,dep_yourtime,dep_pickuptime,dep_passengers,dep_babyseats,dep_estfare,dep_driver,dep_comments,arr_address1,arr_address2,arr_suburb,arr_phone,arr_mobile,arr_drop_address1,arr_drop_address2,arr_drop_suburb,arr_date,arr_flight,arr_airline,arr_origin,arr_terminal,arr_time,arr_ourtime,arr_yourtime,arr_pickuptime,arr_passengers,arr_babyseats,arr_estfare,arr_driver,arr_comments,total,payment_method,book_type,created_date as multid,'single' as mflag,created_by,updated_by,cancel_book,dep_booking_confirmed,arr_booking_confirmed,paid_status,dep_batch,arr_batch FROM booking ".$where.") 
                    UNION 
                    (SELECT book_id as auto,user,client,type,direction,dep_address1,dep_address2,dep_suburb,dep_phone,dep_mobile,dep_drop_address1,dep_drop_address2,dep_drop_suburb,dep_date,dep_flight,dep_airline,dep_origin,dep_terminal,dep_time,dep_ourtime,dep_yourtime,dep_pickuptime,dep_passengers,dep_babyseats,dep_estfare,dep_driver,dep_comments,arr_address1,arr_address2,arr_suburb,arr_phone,arr_mobile,arr_drop_address1,arr_drop_address2,arr_drop_suburb,arr_date,arr_flight,arr_airline,arr_origin,arr_terminal,arr_time,arr_ourtime,arr_yourtime,arr_pickuptime,arr_passengers,arr_babyseats,arr_estfare,arr_driver,arr_comments,total,payment_method,book_type,id as multid,multi_flag as mflag,created_by,updated_by,cancel_book,dep_booking_confirmed,arr_booking_confirmed,paid_status,dep_batch,arr_batch FROM multipickup_booking ".$where.") ORDER BY dep_date DESC,arr_date DESC";
                
                
         //   echo $query;
                $data = $this->db->query($query);
          
                return $data->result_array();
            
	}
        
        function getBooking($id) {

                $query = "SELECT * FROM booking WHERE id='".$id."'";
            
                $data = $this->db->query($query);
          
                return $data->result_array();
            
        }

        function getMultibooking($id) {

                $query = "SELECT * FROM multipickup_booking WHERE id='".$id."'";
            
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
                
                if($row) $cliname = $row[0]['first_name']."<br/>".$row[0]['last_name'];
                
                else $cliname = '';
                
                return $cliname;
            
        }

        function getClientphone($val) {

                $query = 'SELECT mobile FROM clients WHERE id='.$val;
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                if($row) $cliphone = $row[0]['mobile'];
                
                else $cliphone = '';
                
                return $cliphone;
            
        }
		
		        function getClientphone2($val) {

                $query = 'SELECT phone FROM clients WHERE id='.$val;
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                if($row) $cliphone2 = $row[0]['phone'];
                
                else $cliphone2 = '';
                
                return $cliphone2;
            
        }
        
        function getDriver($val) {

                $query = 'SELECT first_name,last_name FROM drivers WHERE id='.$val;			
				
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                return $row[0]['first_name']." ".$row[0]['last_name'];
            
        }
       
        function getClientmail($id) {
            
                $query = "SELECT email FROM clients WHERE id='".$id."'";
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                if($row[0]['email']!='') {
                    $mailaddress = $row[0]['email'];
                }
                else $mailaddress = '';
                
                return $mailaddress;
            
        }
        
        function getMailtemp($val,$dir) {

                $query = "SELECT * FROM email_templates WHERE type='".$val."' AND direction='".$dir."'";
            
                $data = $this->db->query($query);
          
                $row = $data->result_array();
                
                return $row;
            
        }
        
        function daysheetMailsend($id) {
            
                            $decimal_pointer = $this->config->item('decimal_point');
                            $dec_point = $decimal_pointer['point'];
                            $prg = $decimal_pointer['prr'];
                            $dollar = $decimal_pointer['dollar'];
            
            $bktype = explode(',',$id);
            $total = count($bktype);
            
            for($k=0; $k<$total; $k++) {
                
                 //   $exp_books = explode('~~',$bktype[$k]);
                    
                        $book_id = $bktype[$k];
                        //$book_flag = $exp_books[1];
                    
                            // updated booking table
                            $today_date = date('Y-m-d H:i:s');
                            $bk_data = array('updated_by'=>$this->session->userdata('sess_username'),'updated_date'=>$today_date,);
                            $this->tbl_name = "booking";
                            $this->db->where('id', $book_id);
                            $this->db->update($this->tbl_name,$bk_data);

                            
                            $this->tbl_name = "mail_trigger";
                            // get mail content from email template table
                            $default_email_config = $this->config->item('default_email_config');

                            $book_row = $this->getBookdata($book_id);

                            // get client mail address
                            $tomail = $this->getClientmail($book_row[0]['client']);
                            
                            // get mail template
                            $direction = strtolower($book_row[0]['direction']);
                            
                            $booktype = $book_row[0]['type'];
                            
                            $msgrow = $this->getMailtemp($booktype,$direction);
                            // receiver
                            if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];
                            else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];
                            else if($tomail!='') $receiver = $tomail;
                            else $receiver = '';
                            
                            // subject
                            $sub_ject = str_replace('{Booking Reference Number}',$book_id,$msgrow[0]['subject']);
                            // msg content
                            
                            if($book_row[0]['dep_address2']!='') $deppickup_address = $book_row[0]['dep_address1'].", ".$book_row[0]['dep_address2'].", ".$book_row[0]['dep_suburb'];
                            else if($book_row[0]['dep_suburb']!='') $deppickup_address = $book_row[0]['dep_address1'].", ".$book_row[0]['dep_suburb'];
                            
                            if($book_row[0]['arr_address2']!='') $arrpickup_address = $book_row[0]['arr_address1'].", ".$book_row[0]['arr_address2'].", ".$book_row[0]['arr_suburb'];
                            else if($book_row[0]['arr_suburb']!='') $arrpickup_address = $book_row[0]['arr_address1'].", ".$book_row[0]['arr_suburb'];
                            
                            $mdepdate = date('d/m/Y',strtotime($book_row[0]['dep_date']));
                            $marrdate = date('d/m/Y',strtotime($book_row[0]['arr_date']));
                            $mdepaddress = $deppickup_address;
                            $marraddress = $arrpickup_address;
                            $depestfareval = $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', '');
                            $arrestfareval = $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', '');
                            $arrflightval = $book_row[0]['arr_flight'];
                            $arrourtimeval = $book_row[0]['arr_ourtime'];
                            $totalval = $dollar.number_format(preg_replace($prg, '', $book_row[0]['total']), $dec_point, '.', '');
                            $arrterminalval = $book_row[0]['arr_terminal'];
                            $deppickuptime = $book_row[0]['dep_pickuptime'];
                            $arrpickuptime = $book_row[0]['arr_pickuptime'];
                            
                            // waiting place
                            if($arrflightval!='') {

                                $exparrfl = explode('QF',$arrflightval);
                                $exp_arrflightval = '';

                                if(isset($exparrfl[1])) $exp_arrflightval = $exparrfl[1];

                                if($arrterminalval=='Dom') {
                                    if($exp_arrflightval>=400 && $exp_arrflightval<=1599) {

                                        $wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (1)</b> after collecting luggage.';
                                    }

                                    else if($exp_arrflightval>=1600) {

                                        $wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (1)</b> after collecting luggage.';
                                    }
                                    else {
                        		//Ramya - as requested by Andrew on 22/05/2013 - for all other flights below message should be included
                        		$wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (6)</b> after collecting luggage.';
                                        
                    		    }
                                }

                            }

                                if($arrterminalval=='Int') {
                                    $wait_place = "Please wait for the driver inside the <b>Arrivals Hall at McDonalds, which is located at the Gate 'A' end of the terminal</b> when you clear customs.";
                                }
                            
                            // get passenger name
                            $passenger = $this->booking_model->getClientname($book_row[0]['client']);
                            
                            $msgcontent = $msgrow[0]['content'];
                            $msgcontent = str_replace('{passenger}', $passenger, $msgcontent);
                            $msgcontent = str_replace('{depdate}', $mdepdate, $msgcontent);
                            $msgcontent = str_replace('{arrdate}', $marrdate, $msgcontent);
                            $msgcontent = str_replace('{depaddress}', $mdepaddress, $msgcontent);
                            $msgcontent = str_replace('{arraddress}', $marraddress, $msgcontent);
                            $msgcontent = str_replace('{deppickup}', $deppickuptime, $msgcontent);
                            $msgcontent = str_replace('{arrpickup}', $arrpickuptime, $msgcontent);
                            $msgcontent = str_replace('{depest}', $depestfareval, $msgcontent);
                            $msgcontent = str_replace('{arrest}', $arrestfareval, $msgcontent);
                            $msgcontent = str_replace('{arrflight}', $arrflightval, $msgcontent);
                            $msgcontent = str_replace('{arrfltime}', $arrourtimeval, $msgcontent);
                            $msgcontent = str_replace('{totalest}', $totalval, $msgcontent);
                            $msgcontent = str_replace('{waitingplace}', $wait_place, $msgcontent);
                            
                            // booking data
                          $depaddress2val = $book_row[0]['dep_address2'];
                          $depdest = $book_row[0]['dep_address1'].', '.$book_row[0]['dep_address2'].', '.$book_row[0]['dep_suburb'];
                          $mdepaddress = $book_row[0]['dep_address1'].', '.$book_row[0]['dep_suburb'];
                          
                          $arraddress2val = $book_row[0]['arr_address2'];
                          $arrdest = $book_row[0]['arr_address1'].', '.$book_row[0]['arr_address2'].', '.$book_row[0]['arr_suburb'];
                          $marraddress = $book_row[0]['arr_address1'].', '.$book_row[0]['arr_suburb'];
                          
                          $depdropaddress2val = $book_row[0]['dep_drop_address2'];
                          $depdropdest = $book_row[0]['dep_drop_address1'].', '.$book_row[0]['dep_drop_address2'].', '.$book_row[0]['dep_drop_suburb'];
                          $mdepdropaddress = $book_row[0]['dep_drop_address1'].', '.$book_row[0]['dep_drop_suburb'];
                          
                          $arrdropaddress2val = $book_row[0]['arr_drop_address2'];
                          $arrdropdest = $book_row[0]['arr_drop_address1'].', '.$book_row[0]['arr_drop_address2'].', '.$book_row[0]['arr_drop_suburb'];
                          $marrdropaddress = $book_row[0]['arr_drop_address1'].', '.$book_row[0]['arr_drop_suburb'];
                          
                    if($booktype=='Other') {
                        
                        if($depaddress2val!='') $dep_destination = $depdest;
                        else $dep_destination = $mdepaddress;

                        if($arraddress2val!='') $arr_destination = $arrdest;
                        else $arr_destination = $marraddress;

                        if($depdropaddress2val!='') $dep_drop_destination = $depdropdest;
                        else $dep_drop_destination = $mdepdropaddress;

                        if($arrdropaddress2val!='') $arr_drop_destination = $arrdropdest;
                        else $arr_drop_destination = $marrdropaddress;
                        
                        if($direction=='departure') $msgcontent = str_replace('{dep_destination}', $dep_destination, $msgcontent);
                        else if($direction=='arrival') $msgcontent = str_replace('{arr_destination}', $arr_destination, $msgcontent);
                        else if($direction=='both') {
                            $msgcontent = str_replace('{dep_destination}', $dep_destination, $msgcontent);
                            $msgcontent = str_replace('{arr_destination}', $arr_destination, $msgcontent);
                        }
                        
                        $msgcontent = str_replace('{dep_pickup_address}', $dep_destination, $msgcontent);
                        $msgcontent = str_replace('{dep_dropoff_address}', $dep_drop_destination, $msgcontent);
                        $msgcontent = str_replace('{arr_pickup_address}', $arr_destination, $msgcontent);
                        $msgcontent = str_replace('{arr_dropoff_address}', $arr_drop_destination, $msgcontent);
                        
                    }
                            
                            // from mail address
                            $frm_mail = $default_email_config['from'];
                            $crdate = date('Y-m-d H:i:s');
                            $mdata = array('book_id'=>$_POST['autoval'][$k],'from'=>$frm_mail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);
                            
                            $this->db->insert($this->tbl_name,$mdata);
            }
        }
        
        function getBookdata($id) {
            
                //if($flag=='multiple') $query = 'SELECT * FROM multipickup_booking WHERE book_id='.$id.'';
                $query = 'SELECT * FROM booking WHERE id='.$id.'';
            
                $data = $this->db->query($query);
          
                return $data->result_array();
            
        }
        
	function daysheetDriverdata()

	{

		$this->tbl_name = "drivers";

					$this->db->select(array('id','first_name','last_name'));

                                        $this->db->where('status','1');

					$recset = $this->db->get($this->tbl_name);

		$arr = array();

		$arr[] = "";

		foreach ($recset->result() as $row)

		{

		   $arr[$row->id] = $row->first_name.' '.$row->last_name;

		}

		return $arr;

	}
        
        
}
?>