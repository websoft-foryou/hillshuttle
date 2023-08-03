<?php



class Booking_model extends CI_Model

{



	function __construct()

	{

		parent::__construct();

	}        



	function getBookingdata($data = 0,$offset,$limit,$order_field,$order_by)



	{



            $this->tbl_name = "booking";



            



            $this->db->select('booking.*,clients.state,clients.first_name,clients.last_name,clients.suburb,clients.address1,clients.address2,clients.gender,clients.phone,clients.mobile,clients.email,clients.comments');



            



            $this->db->join('clients','booking.client=clients.id','left outer');



            



            if($data) {



                



                $where = array('booking.id'=>$data);



            



                $this->db->where($where);



            }



            else {



                $this->db->where("booking.id !='' AND booking.client !='0'");                



            }



            



         /*   if($order_field) {



             //   $order_field = $order_field.',updated_date';



                $this->db->order_by($order_field, $order_by);



            } */



            $this->db->order_by('id','desc');



            $query = $this->db->get($this->tbl_name,$limit,$offset);



            return $query->result_array();



	}







        function getNumRows($txt,$fld) {



            



            $this->tbl_name = "booking";



            



                $this->db->select('booking.*,clients.state,clients.first_name,clients.last_name');







                $this->db->join('clients','booking.client=clients.id','left outer');



            



            if($txt) {



                $txt = strtolower($txt);



                if($fld=='dep_flight') {



                    $where = array($fld=>$txt);



                    $this->db->like($fld,$txt,'after');



                    



                    $where = array('arr_flight'=>$txt);



                    $this->db->or_like('arr_flight',$txt,'after');



                }



                else if($fld=='dep_airline') {



                    $where = array($fld=>$txt);



                    $this->db->where($where);



                    



                    $where = array('arr_airline'=>$txt);



                    $this->db->or_where($where);



                }



                else if($fld=='dep_terminal') {



                    $where = array($fld=>$txt);



                    $this->db->where($where);



                    



                    $where = array('arr_terminal'=>$txt);



                    $this->db->or_where($where);



                }



                else if($fld=='first_name') {



                    $where = array('clients.first_name'=>$txt);



                    $this->db->like('clients.first_name',$txt,'after');



                    



                }



                else if($fld=='last_name') {



                    $where = array('clients.last_name'=>$txt);



                    $this->db->like('clients.last_name',$txt,'after');



                    



                }



                else if($fld=='cancel_book') {

                    

                    $this->db->where("cancel_book !='0'");

                }

                



                else {



                    $where = array($fld=>$txt);



                    $this->db->where($where);



                }



            }



            $this->db->where("booking.id !='' AND booking.client !='0'");  

            

            $this->db->order_by('booking.id','desc');



            return $this->db->count_all_results($this->tbl_name);



        }



        



	function getFilterdata($txt,$fld,$offset,$limit,$order_field,$order_by)



	{



            $this->tbl_name = "booking";



            



            $txt = strtolower($txt);



            



                $this->db->select('booking.*,clients.state,clients.first_name,clients.last_name');







                $this->db->join('clients','booking.client=clients.id','left outer');



            



                if($fld=='dep_flight') {



                    $where = array($fld=>$txt);



                    $this->db->like($fld,$txt,'after');



                    



                    $where = array('arr_flight'=>$txt);



                    $this->db->or_like('arr_flight',$txt,'after');



                }



                else if($fld=='dep_airline') {



                    $where = array($fld=>$txt);



                    $this->db->where($where);



                    



                    $where = array('arr_airline'=>$txt);



                    $this->db->or_where($where);



                }



                else if($fld=='dep_terminal') {



                    $where = array($fld=>$txt);



                    $this->db->where($where);



                    



                    $where = array('arr_terminal'=>$txt);



                    $this->db->or_where($where);



                }



                else if($fld=='first_name') {



                    $where = array('clients.first_name'=>$txt);



                    $this->db->like('clients.first_name',$txt,'after');



                    



                }



                else if($fld=='last_name') {



                    $where = array('clients.last_name'=>$txt);



                    $this->db->like('clients.last_name',$txt,'after');



                    



                }



                else if($fld=='cancel_book') {

                    

                    $this->db->where("cancel_book !='0'");

                }



                else {



                    $where = array($fld=>$txt);



                    $this->db->where($where);



                }



                $this->db->where("booking.id !='' AND booking.client !='0'");

                

                $this->db->order_by('booking.id','desc');



                $query = $this->db->get($this->tbl_name,$limit,$offset);





                return $query->result_array();



	}



        



        function addBooking()



        {



            $this->tbl_name = "booking";



            



            // delete empty booking



			//PRAKASH ----- 22-May-2013

			

            //$this->db->where('id', $this->session->userdata('dynamicbookid'));



            //$this->db->delete($this->tbl_name);



            //PRAKASH ----- 22-May-2013

            



            $book_id = '';



            



            $client = $_POST['clientval'];



            



            $btype = $_POST['type'];



            



            $direction = $_POST['direction'];



            



            $arrterminalval = '';



            



            $arrdateval = '';



            



            $depdateval = '';



            



            $depaddress1val = '';



            $depaddress2val = '';



            $depsuburbval = '';



            $depphoneval = '';



            $depmobileval = '';



            $depdropaddress1val = '';



            $depdropaddress2val = '';



            $depdropsuburbval = '';



            $depdropphoneval = '';



            $depdropmobileval = '';



            $depflightval = '';



            $depairlineval = '';



            $deporiginval = '';



            $depterminalval = '';



            $depourtimeval = '';



            $deppassengersval = '';



            $depbabyseatsval = '';



            $depestfareval = '';



            $depdriverval = '';



            $depcommentsval = '';



            



            $arrsuburbval = '';



            $arrphoneval = '';



            $arrmobileval = '';



            $arrflightval = '';



            $arrairlineval = '';



            $arraddress1val = '';



            $arraddress2val = '';



            $arrdropsuburbval = '';



            $arrdropphoneval = '';



            $arrdropmobileval = '';



            $arrdropaddress1val = '';



            $arrdropaddress2val = '';



            $arroriginval = '';



            $arrourtimeval = '';



            $arrpassengersval = '';



            $arrbabyseatsval = '';



            $arrestfareval = '';



            $arrdriverval = '';



            $arrcommentsval = '';



            $totalval = '';



            $paymentmethodval = '';



            $book_cancel = 0;



            $paid_status = '';



            



            // cancel booking



            $dep_cancel = $_POST['depcancel'];



            $arr_cancel = $_POST['arrcancel'];



            



                if($dep_cancel!='' && $arr_cancel!='') $book_cancel = 3;



                else if($dep_cancel!='' && $arr_cancel=='') $book_cancel = 1;



                else if($dep_cancel=='' && $arr_cancel!='') $book_cancel = 2;



            



            



                $depsuburb = $_POST['dep_suburb'];



                



                $depaddress1 = $_POST['dep_address1'];



                



                $depaddress2 = $_POST['dep_address2'];



                



                $depmobile = $_POST['dep_mobile'];



                



                $depphone = $_POST['dep_phone'];







                $depdropsuburb = $_POST['dep_drop_suburb'];



                



                $depdropaddress1 = $_POST['dep_drop_address1'];



                



                $depdropaddress2 = $_POST['dep_drop_address2'];



                



                $depdropmobile = $_POST['dep_drop_mobile'];



                



                $depdropphone = $_POST['dep_drop_phone'];



                



                $depflight = $_POST['dep_flight'];



                



                $depairline = $_POST['dep_airline'];



                



                $deporigin = $_POST['dep_origin'];



                



                if(isset($_POST['dep_terminal']) && $_POST['dep_terminal']!='') $depterminal = $_POST['dep_terminal'];



                



                $depourtime = $_POST['dep_ourtime'];



                



                $deppassengers = $_POST['dep_passengers'];



                



                $depbabyseats = $_POST['dep_babyseats'];



                



                $depestfare = $_POST['dep_estfare'];



                



                $depdriver = $_POST['dep_driver'];



                



                $depcomments = $_POST['dep_comments'];



                



                $arrsuburb = $_POST['arr_suburb'];



              



                $arraddress1 = $_POST['arr_address1'];



                



                $arraddress2 = $_POST['arr_address2'];



                



                $arrmobile = $_POST['arr_mobile'];



                



                $arrphone = $_POST['arr_phone'];







                $arrdropsuburb = $_POST['arr_drop_suburb'];



              



                $arrdropaddress1 = $_POST['arr_drop_address1'];



                



                $arrdropaddress2 = $_POST['arr_drop_address2'];



                



                $arrdropmobile = $_POST['arr_drop_mobile'];



                



                $arrdropphone = $_POST['arr_drop_phone'];



                



                $arrflight = $_POST['arr_flight'];



                



                $arrairline = $_POST['arr_airline'];



                



                $arrorigin = $_POST['arr_origin'];



                



                if(isset($_POST['arr_terminal']) && $_POST['arr_terminal']!='') $arrterminal = $_POST['arr_terminal'];



                



                $arrourtime = $_POST['arr_ourtime'];



                



                $arrpassengers = $_POST['arr_passengers'];



                



                $arrbabyseats = $_POST['arr_babyseats'];



                



                $arrestfare = $_POST['arr_estfare'];



                



                $arrdriver = $_POST['arr_driver'];



                



                $arrcomments = $_POST['arr_comments'];



                



                $total = $_POST['total'];



                



                $paymentmethod = $_POST['payment_method'];



                



                $depdate = $_POST['dep_date'];



                



                $pstatus = $_POST['paid_status'];



                



                if($_POST['arr_date'][0]!='') $arrdate = $_POST['arr_date'];



            

/*

            if($_POST['dep_yourhours'][0]!='0') $yourhrs = $_POST['dep_yourhours'];

            if($_POST['dep_yourmin'][0]!='0') $yourmin = $_POST['dep_yourmin'];

*/

            



            if($_POST['dep_pickhours'][0]!='0') $pickhrs = $_POST['dep_pickhours'];



            if($_POST['dep_pickmin'][0]!='0') $pickmin = $_POST['dep_pickmin'];



          //  $pickam = $_POST['dep_pickam'];



            

/*

            if($_POST['arr_yourhours'][0]!='0') $arryourhrs = $_POST['arr_yourhours'];

            if($_POST['arr_yourmin'][0]!='0') $arryourmin = $_POST['arr_yourmin'];

*/            



            if($_POST['arr_pickhours'][0]!='0') $arrpickhrs = $_POST['arr_pickhours'];



            if($_POST['arr_pickmin'][0]!='0') $arrpickmin = $_POST['arr_pickmin'];



          //  $arrpickam = $_POST['arr_pickam'];



            



            if($_POST['dep_time'][0]!='0') $thrs = $_POST['dep_time'];



            if($_POST['dep_tmin'][0]!='0') $tmin = $_POST['dep_tmin'];



          //  $tam = $_POST['dep_tam'];



            



            if($_POST['arr_time'][0]!='0') $arrthrs = $_POST['arr_time'];



            if($_POST['arr_tmin'][0]!='0') $arrtmin = $_POST['arr_tmin'];



          //  $arrtam = $_POST['arr_tam'];



            


           /*Original code */
		   $today_date = date('Y-m-d H:i:s');
			
			/* Code to reflect AEST */
			//$today_date = date('Y-m-d H:i:s',strtotime('+10 Hours'));



       



            $yourhrsval = 0;



            $yourminval = '00';



            



            $pickhrsval = 0;



            $pickminval = '00';



            



            $arryourhrsval = 0;



            $arryourminval = '00';



            



            $arrpickhrsval = 0;



            $arrpickminval = '00';



            



            $thrsval = 0;



            $tminval = '00';



            



            $arrthrsval = 0;



            $arrtminval = '00';



            



            for($i=0;$i<count($_POST['countval']);$i++) {



                



            if($_POST['dep_date'][0]!='') {    



            if(@$depdate[$i]!='') {



                



                $exp_date = explode('/',$depdate[$i]);



                



                $depdateval = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];



            }



            }



            



            if($_POST['arr_date'][0]!='') {



            if(@$arrdate[$i]!='') {



                



                $exp_date = explode('/',$arrdate[$i]);



                



                $arrdateval = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];



            } 



            }



            



            if($btype=='1') $booktype = 'AP';



            



            else if($btype=='2') $booktype = 'DH';



            



            else if($btype=='3') $booktype = 'CQ';



            



            else if($btype=='4') $booktype = 'CS'; 



            



            else if($btype=='5') $booktype = 'Other'; 



            

/*

            if($_POST['dep_yourhours'][0]!='0') $yourhrsval = $yourhrs[$i];

            if($_POST['dep_yourmin'][0]!='0') $yourminval = $yourmin[$i];

            $depyourtime = $yourhrsval.':'.$yourminval;

*/

            $depyourtime = '';



            if($_POST['dep_pickhours'][0]!='0') $pickhrsval = $pickhrs[$i];



            if($_POST['dep_pickmin'][0]!='0') $pickminval = $pickmin[$i];



           // $pickam = $pickam[$i];



            



            $deppickuptime = $pickhrsval.':'.$pickminval;



            

/*

            if($_POST['arr_yourhours'][0]!='0') $arryourhrsval = $arryourhrs[$i];

            if($_POST['arr_yourmin'][0]!='0') $arryourminval = $arryourmin[$i];

            $arryourtime = $arryourhrsval.':'.$arryourminval;

*/

            $arryourtime = '';

            



            if($_POST['arr_pickhours'][0]!='0') $arrpickhrsval = $arrpickhrs[$i];



            if($_POST['arr_pickmin'][0]!='0') $arrpickminval = $arrpickmin[$i];



          //  $arrpickam = $arrpickam[$i];



            



            $arrpickuptime = $arrpickhrsval.':'.$arrpickminval;







            if($_POST['dep_time'][0]!='0') $thrsval = $thrs[$i];



            if($_POST['dep_tmin'][0]!='0') $tminval = $tmin[$i];



          //  $tam = $tam[$i];



            



            $deptime = $thrsval.':'.$tminval;



            



            if($_POST['arr_time'][0]!='0') $arrthrsval = $arrthrs[$i];



            if($_POST['arr_tmin'][0]!='0') $arrtminval = $arrtmin[$i];



          //  $arrtam = $arrtam[$i];



            



            $arrtime = $arrthrsval.':'.$arrtminval;



                



            if(isset($_POST['dep_terminal']) && $_POST['dep_terminal']!='') $depterminalval = @$depterminal[$i];



            if(isset($_POST['arr_terminal']) && $_POST['arr_terminal']!='') $arrterminalval = @$arrterminal[$i];







            $depaddress1val = @$depaddress1[$i];



            $depaddress2val = @$depaddress2[$i];



            $depsuburbval = @$depsuburb[$i];



            $depphoneval = @$depphone[$i];



            $depmobileval = @$depmobile[$i];



            $depdropaddress1val = @$depdropaddress1[$i];



            $depdropaddress2val = @$depdropaddress2[$i];



            $depdropsuburbval = @$depdropsuburb[$i];



            $depdropphoneval = @$depdropphone[$i];



            $depdropmobileval = @$depdropmobile[$i];



            $depflightval = strtoupper(@$depflight[$i]);



            $depairlineval = @$depairline[$i];



            $deporiginval = @$deporigin[$i];



            $depourtimeval = @$depourtime[$i];



            $deppassengersval = @$deppassengers[$i];



            $depbabyseatsval = @$depbabyseats[$i];



            $depestfareval = @$depestfare[$i];



            $depdriverval = @$depdriver[$i];



            $depcommentsval = @$depcomments[$i];



            



            $arrsuburbval = @$arrsuburb[$i];



            $arrphoneval = @$arrphone[$i];



            $arrmobileval = @$arrmobile[$i];



            $arrflightval = strtoupper(@$arrflight[$i]);



            $arrairlineval = @$arrairline[$i];



            $arraddress1val = @$arraddress1[$i];



            $arraddress2val = @$arraddress2[$i];



            $arrdropsuburbval = @$arrdropsuburb[$i];



            $arrdropphoneval = @$arrdropphone[$i];



            $arrdropmobileval = @$arrdropmobile[$i];



            $arrdropaddress1val = @$arrdropaddress1[$i];



            $arrdropaddress2val = @$arrdropaddress2[$i];



            $arroriginval = @$arrorigin[$i];



            $arrourtimeval = @$arrourtime[$i];



            $arrpassengersval = @$arrpassengers[$i];



            $arrbabyseatsval = @$arrbabyseats[$i];



            $arrestfareval = @$arrestfare[$i];



            $arrdriverval = @$arrdriver[$i];



            $arrcommentsval = @$arrcomments[$i];



            $totalval = @$total[$i];



            $paymentmethodval = @$paymentmethod[$i];



            $paid_status = @$pstatus[$i];



            



            $moredata = array('id'=>$_POST['latest_bookid'],



                                            'user'=>'0',



                                            'client'=>$client,



                                            'type'=>$booktype,



                                            'direction'=>$direction,



                                            'dep_address1'=>$depaddress1val,



                                            'dep_address2'=>$depaddress2val,



                                            'dep_suburb'=>$depsuburbval,



                                            'dep_phone'=>$depphoneval,



                                            'dep_mobile'=>$depmobileval,



                                            'dep_drop_address1'=>$depdropaddress1val,



                                            'dep_drop_address2'=>$depdropaddress2val,



                                            'dep_drop_suburb'=>$depdropsuburbval,



                                            'dep_drop_phone'=>$depdropphoneval,



                                            'dep_drop_mobile'=>$depdropmobileval,



                                            'dep_date'=>$depdateval,



                                            'dep_flight'=>$depflightval,



                                            'dep_airline'=>$depairlineval,



                                            'dep_origin'=>$deporiginval,



                                            'dep_terminal'=>$depterminalval,



                                            'dep_time'=>$deptime,



                                            'dep_ourtime'=>$depourtimeval,



                                            'dep_yourtime'=>$depyourtime,



                                            'dep_pickuptime'=>$deppickuptime,



                                            'dep_passengers'=>$deppassengersval,



                                            'dep_babyseats'=>$depbabyseatsval,



                                            'dep_estfare'=>$depestfareval,



                                            'dep_driver'=>$depdriverval,



                                            'dep_comments'=>$depcommentsval,



                                            'arr_address1'=>$arraddress1val,



                                            'arr_address2'=>$arraddress2val,



                                            'arr_suburb'=>$arrsuburbval,



                                            'arr_phone'=>$arrphoneval,



                                            'arr_mobile'=>$arrmobileval,



                                            'arr_drop_address1'=>$arrdropaddress1val,



                                            'arr_drop_address2'=>$arrdropaddress2val,



                                            'arr_drop_suburb'=>$arrdropsuburbval,



                                            'arr_drop_phone'=>$arrdropphoneval,



                                            'arr_drop_mobile'=>$arrdropmobileval,



                                            'arr_date'=>$arrdateval,



                                            'arr_flight'=>$arrflightval,



                                            'arr_airline'=>$arrairlineval,



                                            'arr_origin'=>$arroriginval,



                                            'arr_terminal'=>$arrterminalval,



                                            'arr_time'=>$arrtime,



                                            'arr_ourtime'=>$arrourtimeval,



                                            'arr_yourtime'=>$arryourtime,



                                            'arr_pickuptime'=>$arrpickuptime,



                                            'arr_passengers'=>$arrpassengersval,



                                            'arr_babyseats'=>$arrbabyseatsval,



                                            'arr_estfare'=>$arrestfareval,



                                            'arr_driver'=>$arrdriverval,



                                            'arr_comments'=>$arrcommentsval,



                                            'total'=>$totalval,



                                            'payment_method'=>$paymentmethodval,



                                            'created_by'=>$this->session->userdata('sess_username'),



                                            'created_date'=>$today_date,



                                            'updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel,



                                            'paid_status'=>$paid_status



                                           ); 



            



            // mail flight condition



            $wait_place = '';



            if($arrflightval!='') {



                



                $exparrfl = explode('QF',$arrflightval);



                $exp_arrflightval = '';



                



                if(isset($exparrfl[1])) $exp_arrflightval = $exparrfl[1];



                



                if($arrterminalval=='Dom') {



                    if($exp_arrflightval>=400 && $exp_arrflightval<=1599) {







                        $wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (1)</b> after collecting luggage.';



                    }

                    else if($exp_arrflightval>=1600) {







                        //$wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (3)</b> after collecting luggage.';
						
						//ACorr
						$wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (1)</b> after collecting luggage.';



                    }

                    else{

                         //Ramya - as requested by Andrew on 22/05/2013 - for all other flights below message should be included

                        $wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (6)</b> after collecting luggage.';

                    }



                }



                



            }



                if($arrterminalval=='Int') {



                    $wait_place = "Please wait for the driver inside the <b>Arrivals Hall at McDonalds, which is located at the Gate 'A' end of the terminal</b> when you clear customs.";



                }



            



            



            $mdepdate = date('d/m/Y',strtotime($depdateval));



            $marrdate = date('d/m/Y',strtotime($arrdateval));



            



            $mdepaddress = $depaddress1val.", ".$depsuburbval;



            $depdest = $depaddress1val.", ".$depaddress2val.', '.$depsuburbval;







            $mdepdropaddress = $depdropaddress1val.", ".$depdropsuburbval;



            $depdropdest = $depdropaddress1val.", ".$depdropaddress2val.', '.$depdropsuburbval;



            



            $marraddress = $arraddress1val.", ".$arrsuburbval;



            $arrdest = $arraddress1val.", ".$arraddress2val.', '.$arrsuburbval;







            $marrdropaddress = $arrdropaddress1val.", ".$arrdropsuburbval;



            $arrdropdest = $arrdropaddress1val.", ".$arrdropaddress2val.', '.$arrdropsuburbval;



            



            // mail flight condition end



            



            // add booking table



            if($i==0) {



			

                //$this->db->insert($this->tbl_name,$moredata);PRAKASH - 22/05/2013

				

				$this->db->where('id',$_POST['latest_bookid']);

				$this->db->update($this->tbl_name,$moredata);

				

                //PRAKASH - 22/05/2013

                //$book_id = $this->db->insert_id();



                $book_id = $_POST['latest_bookid'];



                



                // multi pickup address save to multipickup_booking table



                $this->tbl_name = 'multipickup_assoc';



                



                $this->db->select('*');



                



                $this->db->where('book_id',$book_id);



                $this->db->where('book_id !=',0);



                $this->db->where('direction','dep');



                



                $query = $this->db->get($this->tbl_name);



                



                $pickrow = $query->result_array();



                



                if(count($pickrow)>0) {



                    



                    for($k=0; $k<count($pickrow); $k++) {



            



                        if($pickrow[$k]['suburb']!='') {



                            $pickup_suburb = $pickrow[$k]['suburb'];



                            $pickup_address1 = $pickrow[$k]['address1'];



                            $pickup_address2 = $pickrow[$k]['address2'];



                            $pickup_phone = $pickrow[$k]['phone'];



                            $pickup_mobile = $pickrow[$k]['mobile'];



                            $pickup_est = $pickrow[$k]['est'];



                            



                        }



                        else {



                            $pickup_suburb = $depsuburbval;



                            $pickup_address1 = $depaddress1val;



                            $pickup_address2 = $depaddress2val;



                            $pickup_phone = $depphoneval;



                            $pickup_mobile = $depmobileval;







                        }







                        if($pickrow[$k]['drop_suburb']!='') {



                            $pickup_drop_suburb = $pickrow[$k]['drop_suburb'];



                            $pickup_drop_address1 = $pickrow[$k]['drop_address1'];



                            $pickup_drop_address2 = $pickrow[$k]['drop_address2'];



                            $pickup_drop_phone = $pickrow[$k]['drop_phone'];



                            $pickup_drop_mobile = $pickrow[$k]['drop_mobile'];



                            $pickup_est = $pickrow[$k]['drop_est'];



                            



                        }



                        else {



                            $pickup_drop_suburb = $depdropsuburbval;



                            $pickup_drop_address1 = $depdropaddress1val;



                            $pickup_drop_address2 = $depdropaddress2val;



                            $pickup_drop_phone = $depdropphoneval;



                            $pickup_drop_mobile = $depdropmobileval;







                        }



                        



                        $pickupdata = array('book_id'=>$pickrow[$k]['book_id'],



                                            'user'=>'0',



                                            'client'=>$client,



                                            'type'=>$booktype,



                                            'direction'=>$direction,



                                            'dep_address1'=>$pickup_address1,



                                            'dep_address2'=>$pickup_address2,



                                            'dep_suburb'=>$pickup_suburb,



                                            'dep_phone'=>$pickup_phone,



                                            'dep_mobile'=>$pickup_mobile,



                                            'dep_drop_address1'=>$pickup_drop_address1,



                                            'dep_drop_address2'=>$pickup_drop_address2,



                                            'dep_drop_suburb'=>$pickup_drop_suburb,



                                            'dep_drop_phone'=>$pickup_drop_phone,



                                            'dep_drop_mobile'=>$pickup_drop_mobile,



                                            'dep_date'=>$depdateval,



                                            'dep_flight'=>$depflightval,



                                            'dep_airline'=>$depairlineval,



                                            'dep_origin'=>$deporiginval,



                                            'dep_terminal'=>$depterminalval,



                                            'dep_time'=>$deptime,



                                            'dep_ourtime'=>$depourtimeval,



                                            'dep_yourtime'=>$depyourtime,



                                            'dep_pickuptime'=>$deppickuptime,



                                            'dep_passengers'=>$pickrow[$k]['passengers'],



                                            'dep_babyseats'=>$depbabyseatsval,



                                            'dep_estfare'=>$pickup_est,



                                            'dep_driver'=>$depdriverval,



                                            'dep_comments'=>$pickrow[$k]['comment'],



                                            'arr_address1'=>'',



                                            'arr_address2'=>'',



                                            'arr_suburb'=>'',



                                            'arr_phone'=>'',



                                            'arr_mobile'=>'',



                                            'arr_drop_address1'=>'',



                                            'arr_drop_address2'=>'',



                                            'arr_drop_suburb'=>'',



                                            'arr_drop_phone'=>'',



                                            'arr_drop_mobile'=>'',



                                            'arr_date'=>'',



                                            'arr_flight'=>'',



                                            'arr_airline'=>'',



                                            'arr_origin'=>'',



                                            'arr_terminal'=>'',



                                            'arr_time'=>'',



                                            'arr_ourtime'=>'',



                                            'arr_yourtime'=>'',



                                            'arr_pickuptime'=>'',



                                            'arr_passengers'=>'',



                                            'arr_babyseats'=>'',



                                            'arr_estfare'=>'',



                                            'arr_driver'=>'',



                                            'arr_comments'=>'',



                                            'total'=>$totalval,



                                            'payment_method'=>$paymentmethodval,



                                            'multi_flag'=>'multiple',



                                            'created_by'=>$this->session->userdata('sess_username'),



                                            'created_date'=>$today_date,



                                            'updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel,



                                            'paid_status'=>$paid_status



                                           ); 



                        



                        $this->tbl_name = 'multipickup_booking';



                        $this->db->insert($this->tbl_name,$pickupdata);



                        



                    }



                    // update flag multipickup_assoc table



                    $this->tbl_name = 'multipickup_assoc';



                    $mfield = array('flag'=>1);



                    $this->db->where('book_id',$book_id);



                    $this->db->where('direction','dep');



                    $this->db->update($this->tbl_name,$mfield);



                    



                }



                



                // multi dropoff address save to multipickup_booking table



                $this->tbl_name = 'multipickup_assoc';



                



                $this->db->select('*');



                



                $this->db->where('book_id',$book_id);



                $this->db->where('book_id !=',0);



                $this->db->where('direction','arr');



                



                $query = $this->db->get($this->tbl_name);



                



                $droprow = $query->result_array();



                



                if(count($droprow)>0) {



                    



                    for($k=0; $k<count($droprow); $k++) {



            



                        if($droprow[$k]['suburb']!='') {



                            $arrpickup_suburb = $droprow[$k]['suburb'];



                            $arrpickup_address1 = $droprow[$k]['address1'];



                            $arrpickup_address2 = $droprow[$k]['address2'];



                            $arrpickup_phone = $droprow[$k]['phone'];



                            $arrpickup_mobile = $droprow[$k]['mobile'];



                            $arrpickup_est = $droprow[$k]['est'];



                            



                        }



                        else {



                            $arrpickup_suburb = $depsuburbval;



                            $arrpickup_address1 = $depaddress1val;



                            $arrpickup_address2 = $depaddress2val;



                            $arrpickup_phone = $depphoneval;



                            $arrpickup_mobile = $depmobileval;







                        }







                        if($droprow[$k]['drop_suburb']!='') {



                            $arr_drop_suburb = $droprow[$k]['drop_suburb'];



                            $arr_drop_address1 = $droprow[$k]['drop_address1'];



                            $arr_drop_address2 = $droprow[$k]['drop_address2'];



                            $arr_drop_phone = $droprow[$k]['drop_phone'];



                            $arr_drop_mobile = $droprow[$k]['drop_mobile'];



                            $arrpickup_est = $droprow[$k]['drop_est'];



                            



                        }



                        else {



                            $arr_drop_suburb = $depdropsuburbval;



                            $arr_drop_address1 = $depdropaddress1val;



                            $arr_drop_address2 = $depdropaddress2val;



                            $arr_drop_phone = $depdropphoneval;



                            $arr_drop_mobile = $depdropmobileval;







                        }



                        



                        $dropdata = array('book_id'=>$droprow[$k]['book_id'],



                                            'user'=>'0',



                                            'client'=>$client,



                                            'type'=>$booktype,



                                            'direction'=>$direction,



                                            'dep_address1'=>'',



                                            'dep_address2'=>'',



                                            'dep_suburb'=>'',



                                            'dep_phone'=>'',



                                            'dep_mobile'=>'',



                                            'dep_drop_address1'=>'',



                                            'dep_drop_address2'=>'',



                                            'dep_drop_suburb'=>'',



                                            'dep_drop_phone'=>'',



                                            'dep_drop_mobile'=>'',



                                            'dep_date'=>'',



                                            'dep_flight'=>'',



                                            'dep_airline'=>'',



                                            'dep_origin'=>'',



                                            'dep_terminal'=>'',



                                            'dep_time'=>'',



                                            'dep_ourtime'=>'',



                                            'dep_yourtime'=>'',



                                            'dep_pickuptime'=>'',



                                            'dep_passengers'=>'',



                                            'dep_babyseats'=>'',



                                            'dep_estfare'=>'',



                                            'dep_driver'=>'',



                                            'dep_comments'=>'',



                                            'arr_address1'=>$arrpickup_address1,



                                            'arr_address2'=>$arrpickup_address2,



                                            'arr_suburb'=>$arrpickup_suburb,



                                            'arr_phone'=>$arrpickup_phone,



                                            'arr_mobile'=>$arrpickup_mobile,



                                            'arr_drop_address1'=>$arr_drop_address1,



                                            'arr_drop_address2'=>$arr_drop_address2,



                                            'arr_drop_suburb'=>$arr_drop_suburb,



                                            'arr_drop_phone'=>$arr_drop_phone,



                                            'arr_drop_mobile'=>$arr_drop_mobile,



                                            'arr_date'=>$arrdateval,



                                            'arr_flight'=>$arrflightval,



                                            'arr_airline'=>$arrairlineval,



                                            'arr_origin'=>$arroriginval,



                                            'arr_terminal'=>$arrterminalval,



                                            'arr_time'=>$arrtime,



                                            'arr_ourtime'=>$arrourtimeval,



                                            'arr_yourtime'=>$arryourtime,



                                            'arr_pickuptime'=>$arrpickuptime,



                                            'arr_passengers'=>$droprow[$k]['passengers'],



                                            'arr_babyseats'=>$arrbabyseatsval,



                                            'arr_estfare'=>$arrpickup_est,



                                            'arr_driver'=>$arrdriverval,



                                            'arr_comments'=>$droprow[$k]['comment'],



                                            'total'=>$totalval,



                                            'payment_method'=>$paymentmethodval,



                                            'multi_flag'=>'multiple',



                                            'created_by'=>$this->session->userdata('sess_username'),



                                            'created_date'=>$today_date,



                                            'updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel,



                                            'paid_status'=>$paid_status



                                           ); 



                        



                        $this->tbl_name = 'multipickup_booking';



                        $this->db->insert($this->tbl_name,$dropdata);



                        



                    }



                    // update flag multipickup_assoc table



                    $this->tbl_name = 'multipickup_assoc';



                    $mfield = array('flag'=>1);



                    $this->db->where('book_id',$book_id);



                    $this->db->where('direction','arr');



                    $this->db->update($this->tbl_name,$mfield);



                    



                }                



                



                // mail trigger



                if($_POST['mailconfirm']=='send') {



                   



                    $default_email_config = $this->config->item('default_email_config');



                    $frmmail = $default_email_config['from'];



                    // get client mail address



                    $tomail = $this->getClientmail($client);



                    



                    // get mail template



                    $msgrow = $this->getMailtemp($booktype,$direction);



                    // receiver



                    if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];



                    else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];



                    else if($tomail!='') $receiver = $tomail;



                    else $receiver = '';



                    // subject



                    $sub_ject = str_replace('{Booking Reference Number}',$book_id,$msgrow[0]['subject']);



                    



                    $passenger = $this->getClientname($client);



                    



                    $msgcontent = '';



                    



                    $msgcontent .= $msgrow[0]['content'];



					
					
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



                    



                    // mail save to mail trigger table



                    $this->tbl_name = "mail_trigger";



                    $crdate = date('Y-m-d H:i:s');



                    $mdata = array('book_id'=>$book_id,'from'=>$frmmail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);



                            



                    $this->db->insert($this->tbl_name,$mdata);



                    



                } // mail confirmation end



                



                    // mail status table



                    $this->tbl_name = "booking_confirm_status";



                    $crdate = date('Y-m-d H:i:s');



                    if($_POST['mailconfirm']=='send') $mstatus = 1;



                    else $mstatus = 0;



                        



                    $sdata = array('book'=>$book_id,'user'=>$this->session->userdata('sess_userid'),'status'=>$mstatus,'created_date'=>$crdate);



                            



                    $this->db->insert($this->tbl_name,$sdata);



                



                



            }



            



            }



            $redirect_link = 'booking/edit/'.$book_id;

            redirect($redirect_link);



        }



        



        function editBooking($id)



        {



            $this->tbl_name = "booking";



            



           // print_r($_POST); exit;



            $book_id = '';



            $btype = '';



            



            $client = $_POST['clientval'];



            



            $btype = $_POST['type'];



            



            if(empty($btype)) $btype = $_POST['cancel_bookval'];



            



            $direction = $_POST['direction'];



            



            $arrterminalval = '';



            



            $arrdateval = '';



            



            $depdateval = '';



            



            $depaddress1val = '';



            $depaddress2val = '';



            $depsuburbval = '';



            $depphoneval = '';



            $depmobileval = '';



            $depdropaddress1val = '';



            $depdropaddress2val = '';



            $depdropsuburbval = '';



            $depdropphoneval = '';



            $depdropmobileval = '';



            $depflightval = '';



            $depairlineval = '';



            $deporiginval = '';



            $depterminalval = '';



            $depourtimeval = '';



            $deppassengersval = '';



            $depbabyseatsval = '';



            $depestfareval = '';



            $depdriverval = '';



            $depcommentsval = '';



            



            $arrsuburbval = '';



            $arrphoneval = '';



            $arrmobileval = '';



            $arrflightval = '';



            $arrairlineval = '';



            $arraddress1val = '';



            $arraddress2val = '';



            $arrdropsuburbval = '';



            $arrdropphoneval = '';



            $arrdropmobileval = '';



            $arrdropaddress1val = '';



            $arrdropaddress2val = '';



            $arroriginval = '';



            $arrourtimeval = '';



            $arrpassengersval = '';



            $arrbabyseatsval = '';



            $arrestfareval = '';



            $arrdriverval = '';



            $arrcommentsval = '';



            $totalval = '';



            $paymentmethodval = '';



            $book_cancel = 0;



            $dep_cancel = '';



            $arr_cancel = '';



            $paid_status = '';



            



            // cancel booking



            if(isset($_POST['depcancel'])) $dep_cancel = $_POST['depcancel'];



            if(isset($_POST['arrcancel'])) $arr_cancel = $_POST['arrcancel'];



            



                if($dep_cancel!='' && $arr_cancel!='') $book_cancel = 3;



                else if($dep_cancel!='' && $arr_cancel=='') $book_cancel = 1;



                else if($dep_cancel=='' && $arr_cancel!='') $book_cancel = 2;



            



                $depsuburb = $_POST['dep_suburb'];



                



                $depaddress1 = $_POST['dep_address1'];



                



                $depaddress2 = $_POST['dep_address2'];



                



                $depmobile = $_POST['dep_mobile'];



                



                $depphone = $_POST['dep_phone'];







                $depdropsuburb = $_POST['dep_drop_suburb'];



                



                $depdropaddress1 = $_POST['dep_drop_address1'];



                



                $depdropaddress2 = $_POST['dep_drop_address2'];



                



                $depdropmobile = $_POST['dep_drop_mobile'];



                



                $depdropphone = $_POST['dep_drop_phone'];



                



                $depflight = $_POST['dep_flight'];



                



                $depairline = $_POST['dep_airline'];



                



                $deporigin = $_POST['dep_origin'];



                



                if(isset($_POST['dep_terminal']) && $_POST['dep_terminal']!='') $depterminal = $_POST['dep_terminal'];



                



                $depourtime = $_POST['dep_ourtime'];



                



                $deppassengers = $_POST['dep_passengers'];



                



                $depbabyseats = $_POST['dep_babyseats'];



                



                $depestfare = $_POST['dep_estfare'];



                



                $depdriver = $_POST['dep_driver'];



                



                $depcomments = $_POST['dep_comments'];



                



                $arrsuburb = $_POST['arr_suburb'];



                



                $arraddress1 = $_POST['arr_address1'];



                



                $arraddress2 = $_POST['arr_address2'];



                



                $arrmobile = $_POST['arr_mobile'];



                



                $arrphone = $_POST['arr_phone'];







                $arrdropsuburb = $_POST['arr_drop_suburb'];



                



                $arrdropaddress1 = $_POST['arr_drop_address1'];



                



                $arrdropaddress2 = $_POST['arr_drop_address2'];



                



                $arrdropmobile = $_POST['arr_drop_mobile'];



                



                $arrdropphone = $_POST['arr_drop_phone'];



                



                $arrflight = $_POST['arr_flight'];



                



                $arrairline = $_POST['arr_airline'];



                



                $arrorigin = $_POST['arr_origin'];



                



                if(isset($_POST['arr_terminal']) && $_POST['arr_terminal']!='') $arrterminal = $_POST['arr_terminal'];



                



                $arrourtime = $_POST['arr_ourtime'];



                



                $arrpassengers = $_POST['arr_passengers'];



                



                $arrbabyseats = $_POST['arr_babyseats'];



                



                $arrestfare = $_POST['arr_estfare'];



                



                $arrdriver = $_POST['arr_driver'];



                



                $arrcomments = $_POST['arr_comments'];



                



                $total = $_POST['total'];



                



                $paymentmethod = $_POST['payment_method'];



                



                $depdate = $_POST['dep_date'];



                



                $arrdate = $_POST['arr_date'];



                



                $pstatus = $_POST['paid_status'];



            



                if($_POST['arr_date'][0]!='') $arrdate = $_POST['arr_date'];



            

/*

            if($_POST['dep_yourhours'][0]!='0') $yourhrs = $_POST['dep_yourhours'];

            if($_POST['dep_yourmin'][0]!='0') $yourmin = $_POST['dep_yourmin'];

*/

            

            if($_POST['dep_pickhours'][0]!='0') $pickhrs = $_POST['dep_pickhours'];



            if($_POST['dep_pickmin'][0]!='0') $pickmin = $_POST['dep_pickmin'];



          //  $pickam = $_POST['dep_pickam'];



            

/*

            if($_POST['arr_yourhours'][0]!='0') $arryourhrs = $_POST['arr_yourhours'];

            if($_POST['arr_yourmin'][0]!='0') $arryourmin = $_POST['arr_yourmin'];

*/

            if($_POST['arr_pickhours'][0]!='0') $arrpickhrs = $_POST['arr_pickhours'];



            if($_POST['arr_pickmin'][0]!='0') $arrpickmin = $_POST['arr_pickmin'];



          //  $arrpickam = $_POST['arr_pickam'];



            



            if($_POST['dep_time'][0]!='0') $thrs = $_POST['dep_time'];



            if($_POST['dep_tmin'][0]!='0') $tmin = $_POST['dep_tmin'];



          //  $tam = $_POST['dep_tam'];



            



            if($_POST['arr_time'][0]!='0') $arrthrs = $_POST['arr_time'];



            if($_POST['arr_tmin'][0]!='0') $arrtmin = $_POST['arr_tmin'];



            



            $today_date = date('Y-m-d H:i:s');



            



            $yourhrsval = 0;



            $yourminval = '00';



            



            $pickhrsval = 0;



            $pickminval = '00';



            



            $arryourhrsval = 0;



            $arryourminval = '00';



            



            $arrpickhrsval = 0;



            $arrpickminval = '00';



            



            $thrsval = 0;



            $tminval = '00';



            



            $arrthrsval = 0;



            $arrtminval = '00';



            



            for($i=0;$i<count($_POST['countval']);$i++) {



                



            if($_POST['dep_date'][0]!='') {    



            if(@$depdate[$i]!='') {



                



                $exp_date = explode('/',$depdate[$i]);



                



                $depdateval = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];



            }



            }



            



            if($_POST['arr_date'][0]!='') {



            if(@$arrdate[$i]!='') {



                



                $exp_date = explode('/',$arrdate[$i]);



                



                $arrdateval = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];



            } 



            }



            



            if($btype=='1') $booktype = 'AP';



            



            else if($btype=='2') $booktype = 'DH';



            



            else if($btype=='3') $booktype = 'CQ';



            



            else if($btype=='4') $booktype = 'CS'; 



            



            else if($btype=='5') $booktype = 'Other'; 



            

/*

            if($_POST['dep_yourhours'][0]!='0') $yourhrsval = $yourhrs[$i];

            if($_POST['dep_yourmin'][0]!='0') $yourminval = $yourmin[$i];

            $depyourtime = $yourhrsval.':'.$yourminval;

*/

            $depyourtime = '';



            if($_POST['dep_pickhours'][0]!='0') $pickhrsval = $pickhrs[$i];



            if($_POST['dep_pickmin'][0]!='0') $pickminval = $pickmin[$i];



           // $pickam = $pickam[$i];



            



            $deppickuptime = $pickhrsval.':'.$pickminval;



            

/*

            if($_POST['arr_yourhours'][0]!='0') $arryourhrsval = $arryourhrs[$i];

            if($_POST['arr_yourmin'][0]!='0') $arryourminval = $arryourmin[$i];

            $arryourtime = $arryourhrsval.':'.$arryourminval;

*/

            $arryourtime = '';



            if($_POST['arr_pickhours'][0]!='0') $arrpickhrsval = $arrpickhrs[$i];



            if($_POST['arr_pickmin'][0]!='0') $arrpickminval = $arrpickmin[$i];



          //  $arrpickam = $arrpickam[$i];



            



            $arrpickuptime = $arrpickhrsval.':'.$arrpickminval;







            if($_POST['dep_time'][0]!='0') $thrsval = $thrs[$i];



            if($_POST['dep_tmin'][0]!='0') $tminval = $tmin[$i];



          //  $tam = $tam[$i];



            



            $deptime = $thrsval.':'.$tminval;



            



            if($_POST['arr_time'][0]!='0') $arrthrsval = $arrthrs[$i];



            if($_POST['arr_tmin'][0]!='0') $arrtminval = $arrtmin[$i];



          //  $arrtam = $arrtam[$i];



            



            $arrtime = $arrthrsval.':'.$arrtminval;



                



            if(isset($_POST['dep_terminal']) && $_POST['dep_terminal']!='') $depterminalval = @$depterminal[$i];



            if(isset($_POST['arr_terminal']) && $_POST['arr_terminal']!='') $arrterminalval = @$arrterminal[$i];







            $depaddress1val = @$depaddress1[$i];



            $depaddress2val = @$depaddress2[$i];



            $depsuburbval = @$depsuburb[$i];



            $depphoneval = @$depphone[$i];



            $depmobileval = @$depmobile[$i];



            $depdropaddress1val = @$depdropaddress1[$i];



            $depdropaddress2val = @$depdropaddress2[$i];



            $depdropsuburbval = @$depdropsuburb[$i];



            $depdropphoneval = @$depdropphone[$i];



            $depdropmobileval = @$depdropmobile[$i];



            $depflightval = strtoupper(@$depflight[$i]);



            $depairlineval = @$depairline[$i];



            $deporiginval = @$deporigin[$i];



            $depourtimeval = @$depourtime[$i];



            $deppassengersval = @$deppassengers[$i];



            $depbabyseatsval = @$depbabyseats[$i];



            $depestfareval = @$depestfare[$i];



            $depdriverval = @$depdriver[$i];



            $depcommentsval = @$depcomments[$i];



            



            $arrsuburbval = @$arrsuburb[$i];



            $arrphoneval = @$arrphone[$i];



            $arrmobileval = @$arrmobile[$i];



            $arrflightval = strtoupper(@$arrflight[$i]);



            $arrairlineval = @$arrairline[$i];



            $arraddress1val = @$arraddress1[$i];



            $arraddress2val = @$arraddress2[$i];



            $arrdropsuburbval = @$arrdropsuburb[$i];



            $arrdropphoneval = @$arrdropphone[$i];



            $arrdropmobileval = @$arrdropmobile[$i];



            $arrdropaddress1val = @$arrdropaddress1[$i];



            $arrdropaddress2val = @$arrdropaddress2[$i];



            $arroriginval = @$arrorigin[$i];



            $arrourtimeval = @$arrourtime[$i];



            $arrpassengersval = @$arrpassengers[$i];



            $arrbabyseatsval = @$arrbabyseats[$i];



            $arrestfareval = @$arrestfare[$i];



            $arrdriverval = @$arrdriver[$i];



            $arrcommentsval = @$arrcomments[$i];



            $totalval = @$total[$i];



            $paymentmethodval = @$paymentmethod[$i];



            $paid_status = @$pstatus[$i];



                



            // mail flight condition



            $wait_place = '';



            if($arrflightval!='') {



                



                $exparrfl = explode('QF',$arrflightval);



                $exp_arrflightval = '';



                



                if(isset($exparrfl[1])) $exp_arrflightval = $exparrfl[1];



                



                if($arrterminalval=='Dom') {



                    if($exp_arrflightval>=400 && $exp_arrflightval<=1599) {

                        $wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (1)</b> after collecting luggage.';



                    }

                    else if($exp_arrflightval>=1600) {

                        //$wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (3)</b> after collecting luggage.';

						//ACorr
						$wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (1)</b> after collecting luggage.';

                    }

                    else{

                         //Ramya - as requested by Andrew on 22/05/2013 - for all other flights below message should be included

                        $wait_place = 'Please wait for the driver at <b>Baggage Carousel Number (6)</b> after collecting luggage.';

                    }

                        



                }



                



            }



                if($arrterminalval=='Int') {



                    $wait_place = "Please wait for the driver inside the <b>Arrivals Hall at McDonalds, which is located at the Gate 'A' end of the terminal</b> when you clear customs.";



                }



            



            



            $mdepdate = date('d/m/Y',strtotime($depdateval));



            $marrdate = date('d/m/Y',strtotime($arrdateval));



            



            $mdepaddress = $depaddress1val.", ".$depsuburbval;



            $depdest = $depaddress1val.", ".$depaddress2val.', '.$depsuburbval;



            



            $mdepdropaddress = $depdropaddress1val.", ".$depdropsuburbval;



            $depdropdest = $depdropaddress1val.", ".$depdropaddress2val.', '.$depdropsuburbval;



            



            $marraddress = $arraddress1val.", ".$arrsuburbval;



            $arrdest = $arraddress1val.", ".$arraddress2val.', '.$arrsuburbval;



            



            $marrdropaddress = $arrdropaddress1val.", ".$arrdropsuburbval;



            $arrdropdest = $arrdropaddress1val.", ".$arrdropaddress2val.', '.$arrdropsuburbval;



            



            // mail flight condition end



            



            if($i==0) {



                



                // departure booking save



                if(empty($_POST['depcancel'])) {



                    $depdata = array('user'=>'0',



                                            'client'=>$client,



                                            'type'=>$booktype,



                                            'direction'=>$direction,



                                            'dep_address1'=>$depaddress1val,



                                            'dep_address2'=>$depaddress2val,



                                            'dep_suburb'=>$depsuburbval,



                                            'dep_phone'=>$depphoneval,



                                            'dep_mobile'=>$depmobileval,



                                            'dep_drop_address1'=>$depdropaddress1val,



                                            'dep_drop_address2'=>$depdropaddress2val,



                                            'dep_drop_suburb'=>$depdropsuburbval,



                                            'dep_drop_phone'=>$depdropphoneval,



                                            'dep_drop_mobile'=>$depdropmobileval,



                                            'dep_date'=>$depdateval,



                                            'dep_flight'=>$depflightval,



                                            'dep_airline'=>$depairlineval,



                                            'dep_origin'=>$deporiginval,



                                            'dep_terminal'=>$depterminalval,



                                            'dep_time'=>$deptime,



                                            'dep_ourtime'=>$depourtimeval,



                                            'dep_yourtime'=>$depyourtime,



                                            'dep_pickuptime'=>$deppickuptime,



                                            'dep_passengers'=>$deppassengersval,



                                            'dep_babyseats'=>$depbabyseatsval,



                                            'dep_estfare'=>$depestfareval,



                                            'dep_driver'=>$depdriverval,



                                            'dep_comments'=>$depcommentsval,



                                            'total'=>$totalval,



                                            'payment_method'=>$paymentmethodval,



                                            'updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel,



                                            'paid_status'=>$paid_status



                



                                           );  



                }



                else {



                    $depdata = array('updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel



                        



                        );



                }



                    $this->db->where('id', $id);



                    $this->db->update($this->tbl_name,$depdata);



                



                // arrival booking save



                if(empty($_POST['arrcancel'])) {



                        $arrdata = array('user'=>'0',



                                            'client'=>$client,



                                            'type'=>$booktype,



                                            'direction'=>$direction,



                                            'arr_address1'=>$arraddress1val,



                                            'arr_address2'=>$arraddress2val,



                                            'arr_suburb'=>$arrsuburbval,



                                            'arr_phone'=>$arrphoneval,



                                            'arr_mobile'=>$arrmobileval,



                                            'arr_drop_address1'=>$arrdropaddress1val,



                                            'arr_drop_address2'=>$arrdropaddress2val,



                                            'arr_drop_suburb'=>$arrdropsuburbval,



                                            'arr_drop_phone'=>$arrdropphoneval,



                                            'arr_drop_mobile'=>$arrdropmobileval,



                                            'arr_date'=>$arrdateval,



                                            'arr_flight'=>$arrflightval,



                                            'arr_airline'=>$arrairlineval,



                                            'arr_origin'=>$arroriginval,



                                            'arr_terminal'=>$arrterminalval,



                                            'arr_time'=>$arrtime,



                                            'arr_ourtime'=>$arrourtimeval,



                                            'arr_yourtime'=>$arryourtime,



                                            'arr_pickuptime'=>$arrpickuptime,



                                            'arr_passengers'=>$arrpassengersval,



                                            'arr_babyseats'=>$arrbabyseatsval,



                                            'arr_estfare'=>$arrestfareval,



                                            'arr_driver'=>$arrdriverval,



                                            'arr_comments'=>$arrcommentsval,



                                            'total'=>$totalval,



                                            'payment_method'=>$paymentmethodval,



                                            'updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel,



                                            'paid_status'=>$paid_status



                



                                           );  



            



                }



                else {



                    $arrdata = array('updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel



                        



                        );



                }



                



                    $this->db->where('id', $id);



                    $this->db->update($this->tbl_name,$arrdata);



                



                // delete exist multipickup address booking



                $this->tbl_name = "multipickup_booking";



                $this->db->where('book_id', $id);



                $this->db->delete($this->tbl_name);



                



                



                // multi pickup address save to multipickup_booking table



                $this->tbl_name = 'multipickup_assoc';



                



                $this->db->select('*');



                



                $this->db->where('book_id',$id);



                



                $this->db->where('direction','dep');



                



                $query = $this->db->get($this->tbl_name);



                



                $pickrow = $query->result_array();



                



                if(count($pickrow)>0) {



                    



                    $pickup_suburb = '';



                    $pickup_address1 = '';



                    $pickup_address2 = '';



                    $pickup_phone = '';



                    $pickup_mobile = '';



                    



                    $pickup_drop_suburb = '';



                    $pickup_drop_address1 = '';



                    $pickup_drop_address2 = '';



                    $pickup_drop_phone = '';



                    $pickup_drop_mobile = '';



                    



                    for($k=0; $k<count($pickrow); $k++) {



            



                        if($pickrow[$k]['suburb']!='') {



                            $pickup_suburb = $pickrow[$k]['suburb'];



                            $pickup_address1 = $pickrow[$k]['address1'];



                            $pickup_address2 = $pickrow[$k]['address2'];



                            $pickup_phone = $pickrow[$k]['phone'];



                            $pickup_mobile = $pickrow[$k]['mobile'];



                            $pickup_est = $pickrow[$k]['est'];



                            



                        }



                        else {



                            $pickup_suburb = $depsuburbval;



                            $pickup_address1 = $depaddress1val;



                            $pickup_address2 = $depaddress2val;



                            $pickup_phone = $depphoneval;



                            $pickup_mobile = $depmobileval;







                        }







                        if($pickrow[$k]['drop_suburb']!='') {



                            $pickup_drop_suburb = $pickrow[$k]['drop_suburb'];



                            $pickup_drop_address1 = $pickrow[$k]['drop_address1'];



                            $pickup_drop_address2 = $pickrow[$k]['drop_address2'];



                            $pickup_drop_phone = $pickrow[$k]['drop_phone'];



                            $pickup_drop_mobile = $pickrow[$k]['drop_mobile'];



                            $pickup_est = $pickrow[$k]['drop_est'];



                            



                        }



                        else {



                            $pickup_drop_suburb = $depdropsuburbval;



                            $pickup_drop_address1 = $depdropaddress1val;



                            $pickup_drop_address2 = $depdropaddress2val;



                            $pickup_drop_phone = $depdropphoneval;



                            $pickup_drop_mobile = $depdropmobileval;







                        }



                        



                        $pickupdata = array('book_id'=>$pickrow[$k]['book_id'],



                                            'user'=>'0',



                                            'client'=>$client,



                                            'type'=>$booktype,



                                            'direction'=>$direction,



                                            'dep_address1'=>$pickup_address1,



                                            'dep_address2'=>$pickup_address2,



                                            'dep_suburb'=>$pickup_suburb,



                                            'dep_phone'=>$pickup_phone,



                                            'dep_mobile'=>$pickup_mobile,



                                            'dep_drop_address1'=>$pickup_drop_address1,



                                            'dep_drop_address2'=>$pickup_drop_address2,



                                            'dep_drop_suburb'=>$pickup_drop_suburb,



                                            'dep_drop_phone'=>$pickup_drop_phone,



                                            'dep_drop_mobile'=>$pickup_drop_mobile,



                                            'dep_date'=>$depdateval,



                                            'dep_flight'=>$depflightval,



                                            'dep_airline'=>$depairlineval,



                                            'dep_origin'=>$deporiginval,



                                            'dep_terminal'=>$depterminalval,



                                            'dep_time'=>$deptime,



                                            'dep_ourtime'=>$depourtimeval,



                                            'dep_yourtime'=>$depyourtime,



                                            'dep_pickuptime'=>$deppickuptime,



                                            'dep_passengers'=>$pickrow[$k]['passengers'],



                                            'dep_babyseats'=>$depbabyseatsval,



                                            'dep_estfare'=>$pickup_est,



                                            'dep_driver'=>$depdriverval,



                                            'dep_comments'=>$pickrow[$k]['comment'],



                                            'arr_address1'=>'',



                                            'arr_address2'=>'',



                                            'arr_suburb'=>'',



                                            'arr_phone'=>'',



                                            'arr_mobile'=>'',



                                            'arr_drop_address1'=>'',



                                            'arr_drop_address2'=>'',



                                            'arr_drop_suburb'=>'',



                                            'arr_drop_phone'=>'',



                                            'arr_drop_mobile'=>'',



                                            'arr_date'=>'',



                                            'arr_flight'=>'',



                                            'arr_airline'=>'',



                                            'arr_origin'=>'',



                                            'arr_terminal'=>'',



                                            'arr_time'=>'',



                                            'arr_ourtime'=>'',



                                            'arr_yourtime'=>'',



                                            'arr_pickuptime'=>'',



                                            'arr_passengers'=>'',



                                            'arr_babyseats'=>'',



                                            'arr_estfare'=>'',



                                            'arr_driver'=>'',



                                            'arr_comments'=>'',



                                            'total'=>$totalval,



                                            'payment_method'=>$paymentmethodval,



                                            'multi_flag'=>'multiple',



                                            'created_by'=>$this->session->userdata('sess_username'),



                                            'created_date'=>$today_date,



                                            'updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel,



                                            'paid_status'=>$paid_status



                                           ); 



                        



                        $this->tbl_name = 'multipickup_booking';



                        $this->db->insert($this->tbl_name,$pickupdata);



                        



                    }



                    // update flag multipickup_assoc table



                    $this->tbl_name = 'multipickup_assoc';



                    $mfield = array('flag'=>1);



                    $this->db->where('book_id',$id);



                    $this->db->where('direction','dep');



                    $this->db->update($this->tbl_name,$mfield);



                }



                



                // multi dropoff address save to multipickup_booking table



                $this->tbl_name = 'multipickup_assoc';



                



                $this->db->select('*');



                



                $this->db->where('book_id',$id);



                



                $this->db->where('direction','arr');



                



                $query = $this->db->get($this->tbl_name);



                



                $droprow = $query->result_array();



                



                if(count($droprow)>0) {



                    



                    $arrpickup_suburb = '';



                    $arrpickup_address1 = '';



                    $arrpickup_address2 = '';



                    $arrpickup_phone = '';



                    $arrpickup_mobile = '';



                    



                    $arr_drop_suburb = '';



                    $arr_drop_address1 = '';



                    $arr_drop_address2 = '';



                    $arr_drop_phone = '';



                    $arr_drop_mobile = '';



                    



                    for($k=0; $k<count($droprow); $k++) {



            



                        if($droprow[$k]['suburb']!='') {



                            $arrpickup_suburb = $droprow[$k]['suburb'];



                            $arrpickup_address1 = $droprow[$k]['address1'];



                            $arrpickup_address2 = $droprow[$k]['address2'];



                            $arrpickup_phone = $droprow[$k]['phone'];



                            $arrpickup_mobile = $droprow[$k]['mobile'];



                            $arrpickup_est = $droprow[$k]['est'];



                            



                        }



                        else {



                            $arrpickup_suburb = $arrsuburbval;



                            $arrpickup_address1 = $arraddress1val;



                            $arrpickup_address2 = $arraddress2val;



                            $arrpickup_phone = $arrphoneval;



                            $arrpickup_mobile = $arrmobileval;







                        }







                        if($droprow[$k]['drop_suburb']!='') {



                            $arr_drop_suburb = $droprow[$k]['drop_suburb'];



                            $arr_drop_address1 = $droprow[$k]['drop_address1'];



                            $arr_drop_address2 = $droprow[$k]['drop_address2'];



                            $arr_drop_phone = $droprow[$k]['drop_phone'];



                            $arr_drop_mobile = $droprow[$k]['drop_mobile'];



                            $arrpickup_est = $droprow[$k]['drop_est'];



                            



                        }



                        else {



                            $arr_drop_suburb = $arrdropsuburbval;



                            $arr_drop_address1 = $arrdropaddress1val;



                            $arr_drop_address2 = $arrdropaddress2val;



                            $arr_drop_phone = $arrdropphoneval;



                            $arr_drop_mobile = $arrdropmobileval;







                        }



                        



                        $pickupdata = array('book_id'=>$droprow[$k]['book_id'],



                                            'user'=>'0',



                                            'client'=>$client,



                                            'type'=>$booktype,



                                            'direction'=>$direction,



                                            'dep_address1'=>'',



                                            'dep_address2'=>'',



                                            'dep_suburb'=>'',



                                            'dep_phone'=>'',



                                            'dep_mobile'=>'',



                                            'dep_drop_address1'=>'',



                                            'dep_drop_address2'=>'',



                                            'dep_drop_suburb'=>'',



                                            'dep_drop_phone'=>'',



                                            'dep_drop_mobile'=>'',



                                            'dep_date'=>'',



                                            'dep_flight'=>'',



                                            'dep_airline'=>'',



                                            'dep_origin'=>'',



                                            'dep_terminal'=>'',



                                            'dep_time'=>'',



                                            'dep_ourtime'=>'',



                                            'dep_yourtime'=>'',



                                            'dep_pickuptime'=>'',



                                            'dep_passengers'=>'',



                                            'dep_babyseats'=>'',



                                            'dep_estfare'=>'',



                                            'dep_driver'=>'',



                                            'dep_comments'=>'',



                                            'arr_address1'=>$arrpickup_address1,



                                            'arr_address2'=>$arrpickup_address2,



                                            'arr_suburb'=>$arrpickup_suburb,



                                            'arr_phone'=>$arrpickup_phone,



                                            'arr_mobile'=>$arrpickup_mobile,



                                            'arr_drop_address1'=>$arr_drop_address1,



                                            'arr_drop_address2'=>$arr_drop_address2,



                                            'arr_drop_suburb'=>$arr_drop_suburb,



                                            'arr_drop_phone'=>$arr_drop_phone,



                                            'arr_drop_mobile'=>$arr_drop_mobile,



                                            'arr_date'=>$arrdateval,



                                            'arr_flight'=>$arrflightval,



                                            'arr_airline'=>$arrairlineval,



                                            'arr_origin'=>$arroriginval,



                                            'arr_terminal'=>$arrterminalval,



                                            'arr_time'=>$arrtime,



                                            'arr_ourtime'=>$arrourtimeval,



                                            'arr_yourtime'=>$arryourtime,



                                            'arr_pickuptime'=>$arrpickuptime,



                                            'arr_passengers'=>$droprow[$k]['passengers'],



                                            'arr_babyseats'=>$arrbabyseatsval,



                                            'arr_estfare'=>$arrpickup_est,



                                            'arr_driver'=>$arrdriverval,



                                            'arr_comments'=>$droprow[$k]['comment'],



                                            'total'=>$totalval,



                                            'payment_method'=>$paymentmethodval,



                                            'multi_flag'=>'multiple',



                                            'created_by'=>$this->session->userdata('sess_username'),



                                            'created_date'=>$today_date,



                                            'updated_by'=>$this->session->userdata('sess_username'),



                                            'updated_date'=>$today_date,



                                            'cancel_book'=>$book_cancel,



                                            'paid_status'=>$paid_status



                                           ); 



                        



                        $this->tbl_name = 'multipickup_booking';



                        $this->db->insert($this->tbl_name,$pickupdata);



                        



                    }



                    // update flag multipickup_assoc table



                    $this->tbl_name = 'multipickup_assoc';



                    $mfield = array('flag'=>1);



                    $this->db->where('book_id',$id);



                    $this->db->where('direction','arr');



                    $this->db->update($this->tbl_name,$mfield);



                }



                



                // mail trigger



                if($_POST['mailconfirm']=='send') {



                   



                    $default_email_config = $this->config->item('default_email_config');



                    $frmmail = $default_email_config['from'];



                    // get client mail address



                    $tomail = $this->getClientmail($client);



                    



                    $msgcontent = '';



                    



                    // direction both with cancel or with out cancel



                    if($direction=='both') {



                        



                        $default_cancel = 'enable';



                        



                        if((empty($_POST['depcancel']) || empty($_POST['arrcancel']))) {



                            



                        // cancel booking option based on mail 



                        if(empty($_POST['arrcancel']) && $_POST['depcancel']!='') $direction = 'arrival';



                        else if(empty($_POST['depcancel']) && $_POST['arrcancel']!='') $direction = 'departure';



                        else if(empty($_POST['arrcancel']) && empty($_POST['depcancel'])) $direction = 'both';



                        



                    // get mail template



                    $msgrow = $this->getMailtemp($booktype,$direction);



                    



                    // subject



                    $sub_ject = str_replace('{Booking Reference Number}',$id,$msgrow[0]['subject']);



                    



                    $passenger = $this->getClientname($client);



                    



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



                        // receiver mail



                        if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];



                        else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];



                        else if($tomail!='') $receiver = $tomail;



                        else $receiver = '';



                        



                        // mail save to mail trigger table



                        $this->tbl_name = "mail_trigger";



                        $crdate = date('Y-m-d H:i:s');



                        $mdata = array('book_id'=>$id,'from'=>$frmmail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);







                        $this->db->insert($this->tbl_name,$mdata);



                    



                    }



                    else if($_POST['hiddepcheck']=='yes' && $_POST['hidarrcheck']=='yes') {



                        // both cancel



                        



                        if($booktype=='AP') $msgrow = $this->getMailtempBasedonId($eid=32);



                        else if($booktype=='Other') $msgrow = $this->getMailtempBasedonId($eid=37);



                        else $msgrow = $this->getMailtempBasedonId($eid=34);



                        $sub_ject = "Booking cancelled for ".$id;



                        $msgcontent = $msgrow[0]['content'];



                        



                        $book_row = $this->getBookdetails($id); // booking details



                        



                        $bktype = $this->getBooktype($id); // book type



                        



                        $msgcontent = str_replace('from {username}', '', $msgcontent);



                        $msgcontent = str_replace('The below', 'Your below', $msgcontent);



                        



                        $msgcontent = str_replace('{transfer}', $bktype['transfer'], $msgcontent);



                        $msgcontent = str_replace('{bookid}', $id, $msgcontent);



                        



                        // Departure



                        $msgcontent = str_replace('{suburb}', $book_row[0]['dep_suburb'], $msgcontent);



                        $msgcontent = str_replace('{address1}', $book_row[0]['dep_address1'], $msgcontent);



                        $msgcontent = str_replace('{address2}', $book_row[0]['dep_address2'], $msgcontent);



                        $msgcontent = str_replace('{mobile}', $book_row[0]['dep_mobile'], $msgcontent);



                        $msgcontent = str_replace('{phone}', $book_row[0]['dep_phone'], $msgcontent);



                        $msgcontent = str_replace('{flight}', $book_row[0]['dep_flight'], $msgcontent);



                        $msgcontent = str_replace('{airline}', $book_row[0]['dep_airline'], $msgcontent);



                        $msgcontent = str_replace('{origin}', $book_row[0]['dep_origin'], $msgcontent);



                        $msgcontent = str_replace('{terminal}', $book_row[0]['dep_terminal'], $msgcontent);



                        $msgcontent = str_replace('{depdate}', $book_row[0]['dep_date'], $msgcontent);



                        $msgcontent = str_replace('{fltime}', $bktype['fltime'], $msgcontent);



                        $msgcontent = str_replace('{passengers}', $book_row[0]['dep_passengers'], $msgcontent);



                        $msgcontent = str_replace('{babyseats}', $book_row[0]['dep_babyseats'], $msgcontent);



                        $msgcontent = str_replace('{comments}', $book_row[0]['dep_comments'], $msgcontent);



                        $msgcontent = str_replace('{depestfare}', $book_row[0]['dep_estfare'], $msgcontent);







                        // Arrival



                        $msgcontent = str_replace('{arrsuburb}', $book_row[0]['arr_suburb'], $msgcontent);



                        $msgcontent = str_replace('{arraddress1}', $book_row[0]['arr_address1'], $msgcontent);



                        $msgcontent = str_replace('{arraddress2}', $book_row[0]['arr_address2'], $msgcontent);



                        $msgcontent = str_replace('{arrmobile}', $book_row[0]['arr_mobile'], $msgcontent);



                        $msgcontent = str_replace('{arrphone}', $book_row[0]['arr_phone'], $msgcontent);



                        $msgcontent = str_replace('{arrflight}', $book_row[0]['arr_flight'], $msgcontent);



                        $msgcontent = str_replace('{arrairline}', $book_row[0]['arr_airline'], $msgcontent);



                        $msgcontent = str_replace('{arrorigin}', $book_row[0]['arr_origin'], $msgcontent);



                        $msgcontent = str_replace('{arrterminal}', $book_row[0]['arr_terminal'], $msgcontent);



                        $msgcontent = str_replace('{arrdate}', $book_row[0]['arr_date'], $msgcontent);



                        $msgcontent = str_replace('{arrfltime}', $bktype['fltime'], $msgcontent);



                        $msgcontent = str_replace('{arrpassengers}', $book_row[0]['arr_passengers'], $msgcontent);



                        $msgcontent = str_replace('{arrbabyseats}', $book_row[0]['arr_babyseats'], $msgcontent);



                        $msgcontent = str_replace('{arrcomments}', $book_row[0]['arr_comments'], $msgcontent);



                        $msgcontent = str_replace('{arrestfare}', $book_row[0]['arr_estfare'], $msgcontent);



                        



                    if($booktype=='Other') {



                        



                        if($depaddress2val!='') $dep_destination = $depdest;



                        else $dep_destination = $mdepaddress;







                        if($arraddress2val!='') $arr_destination = $arrdest;



                        else $arr_destination = $marraddress;



                        



                        $msgcontent = str_replace('{deptransfer}', $dep_destination, $msgcontent);



                        $msgcontent = str_replace('{arrtransfer}', $arr_destination, $msgcontent);



                        



                        // Departure



                        



                        $msgcontent = str_replace('{deppickupsuburb}', $book_row[0]['dep_suburb'], $msgcontent);



                        $msgcontent = str_replace('{deppickupaddress1}', $book_row[0]['dep_address1'], $msgcontent);



                        $msgcontent = str_replace('{deppickupaddress2}', $book_row[0]['dep_address2'], $msgcontent);



                        $msgcontent = str_replace('{deppickupmobile}', $book_row[0]['dep_mobile'], $msgcontent);



                        $msgcontent = str_replace('{deppickupphone}', $book_row[0]['dep_phone'], $msgcontent);



                        



                        $msgcontent = str_replace('{depdropsuburb}', $book_row[0]['dep_drop_suburb'], $msgcontent);



                        $msgcontent = str_replace('{depdropaddress1}', $book_row[0]['dep_drop_address1'], $msgcontent);



                        $msgcontent = str_replace('{depdropaddress2}', $book_row[0]['dep_drop_address2'], $msgcontent);



                        $msgcontent = str_replace('{depdropmobile}', $book_row[0]['dep_drop_mobile'], $msgcontent);



                        $msgcontent = str_replace('{depdropphone}', $book_row[0]['dep_drop_phone'], $msgcontent);



                        



                        // Arrival



                        



                        $msgcontent = str_replace('{arrpickupsuburb}', $book_row[0]['arr_drop_suburb'], $msgcontent);



                        $msgcontent = str_replace('{arrpickupaddress1}', $book_row[0]['arr_drop_address1'], $msgcontent);



                        $msgcontent = str_replace('{arrpickupaddress2}', $book_row[0]['arr_drop_address2'], $msgcontent);



                        $msgcontent = str_replace('{arrpickupmobile}', $book_row[0]['arr_drop_mobile'], $msgcontent);



                        $msgcontent = str_replace('{arrpickupphone}', $book_row[0]['arr_drop_phone'], $msgcontent);



                        



                        $msgcontent = str_replace('{arrdropsuburb}', $book_row[0]['arr_suburb'], $msgcontent);



                        $msgcontent = str_replace('{arrdropaddress1}', $book_row[0]['arr_address1'], $msgcontent);



                        $msgcontent = str_replace('{arrdropaddress2}', $book_row[0]['arr_address2'], $msgcontent);



                        $msgcontent = str_replace('{arrdropmobile}', $book_row[0]['arr_mobile'], $msgcontent);



                        $msgcontent = str_replace('{arrdropphone}', $book_row[0]['arr_phone'], $msgcontent);



                        



                    }



                        



                        $texp_arrest = explode('$',$book_row[0]['arr_estfare']);



                        $texp_depest = explode('$',$book_row[0]['dep_estfare']);



                        $ttotal = $texp_depest[1]+$texp_arrest[1];



                        $cur_total = '$'.$ttotal;



                        



                        $msgcontent = str_replace('{total}', $cur_total, $msgcontent);



                        



                        // receiver mail



                        if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];



                        else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];



                        else if($tomail!='') $receiver = $tomail;



                        else $receiver = '';



                        



                        // mail save to mail trigger table



                        $this->tbl_name = "mail_trigger";



                        $crdate = date('Y-m-d H:i:s');



                        $mdata = array('book_id'=>$id,'from'=>$frmmail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);







                        $this->db->insert($this->tbl_name,$mdata);



                        



                        $default_cancel = 'disable';



                    }



                    



                    if($default_cancel=='enable') {



                        



                      if($_POST['hiddepcheck']=='yes') {  



                        



                        // Departure one cancel mail



                          



                        if($booktype=='AP') $msgrow = $this->getMailtempBasedonId($eid=33);



                        else if($booktype=='Other') $msgrow = $this->getMailtempBasedonId($eid=38);



                        else $msgrow = $this->getMailtempBasedonId($eid=35);



                        $sub_ject = "Booking cancelled for ".$id;



                        $msgcontent = $msgrow[0]['content'];



                        



                        $book_row = $this->getBookdetails($id); // booking details



                        



                        $bktype = $this->getBooktype($id); // book type



                        



                        $msgcontent = str_replace('from {username}', '', $msgcontent);



                        $msgcontent = str_replace('The below', 'Your below', $msgcontent);



                        $msgcontent = str_replace('{direction}', 'Departure details', $msgcontent);



                        $msgcontent = str_replace('{transfer}', $bktype['transfer'], $msgcontent);



                        $msgcontent = str_replace('{bookid}', $id, $msgcontent);



                        $msgcontent = str_replace('{suburb}', $book_row[0]['dep_suburb'], $msgcontent);



                        $msgcontent = str_replace('{address1}', $book_row[0]['dep_address1'], $msgcontent);



                        $msgcontent = str_replace('{address2}', $book_row[0]['dep_address2'], $msgcontent);



                        $msgcontent = str_replace('{mobile}', $book_row[0]['dep_mobile'], $msgcontent);



                        $msgcontent = str_replace('{phone}', $book_row[0]['dep_phone'], $msgcontent);



                        $msgcontent = str_replace('{flight}', $book_row[0]['dep_flight'], $msgcontent);



                        $msgcontent = str_replace('{airline}', $book_row[0]['dep_airline'], $msgcontent);



                        $msgcontent = str_replace('{origin}', $book_row[0]['dep_origin'], $msgcontent);



                        $msgcontent = str_replace('{terminal}', $book_row[0]['dep_terminal'], $msgcontent);



                        $msgcontent = str_replace('{depdate}', $book_row[0]['dep_date'], $msgcontent);



                        $msgcontent = str_replace('{fltime}', $bktype['fltime'], $msgcontent);



                        $msgcontent = str_replace('{passengers}', $book_row[0]['dep_passengers'], $msgcontent);



                        $msgcontent = str_replace('{babyseats}', $book_row[0]['dep_babyseats'], $msgcontent);



                        $msgcontent = str_replace('{comments}', $book_row[0]['dep_comments'], $msgcontent);



                        $msgcontent = str_replace('{estfare}', $book_row[0]['dep_estfare'], $msgcontent);



                        



                    if($booktype=='Other') {



                        



                        if($depaddress2val!='') $dep_destination = $depdest;



                        else $dep_destination = $mdepaddress;







                        $msgcontent = str_replace('{othertransfer}', $dep_destination, $msgcontent);



                        



                        $msgcontent = str_replace('{pickupsuburb}', $book_row[0]['dep_suburb'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress1}', $book_row[0]['dep_address1'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress2}', $book_row[0]['dep_address2'], $msgcontent);



                        $msgcontent = str_replace('{pickupmobile}', $book_row[0]['dep_mobile'], $msgcontent);



                        $msgcontent = str_replace('{pickupphone}', $book_row[0]['dep_phone'], $msgcontent);



                        



                        $msgcontent = str_replace('{dropsuburb}', $book_row[0]['dep_drop_suburb'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress1}', $book_row[0]['dep_drop_address1'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress2}', $book_row[0]['dep_drop_address2'], $msgcontent);



                        $msgcontent = str_replace('{dropmobile}', $book_row[0]['dep_drop_mobile'], $msgcontent);



                        $msgcontent = str_replace('{dropphone}', $book_row[0]['dep_drop_phone'], $msgcontent);



                        



                    }



                        



                        // receiver mail



                        if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];



                        else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];



                        else if($tomail!='') $receiver = $tomail;



                        else $receiver = '';



                      



                        // mail save to mail trigger table



                        $this->tbl_name = "mail_trigger";



                        $crdate = date('Y-m-d H:i:s');



                        $mdata = array('book_id'=>$id,'from'=>$frmmail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);







                        $this->db->insert($this->tbl_name,$mdata);



                        



                      }



                      



                      if($_POST['hidarrcheck']=='yes') {  



                          



                        // Arrival cancel mail



                          



                        if($booktype=='AP') $msgrow = $this->getMailtempBasedonId($eid=33);



                        else if($booktype=='Other') $msgrow = $this->getMailtempBasedonId($eid=38);



                        else $msgrow = $this->getMailtempBasedonId($eid=35);



                        $sub_ject = "Booking cancelled for ".$id;



                        $msgcontent = $msgrow[0]['content'];



                        



                        // booking details



                        $book_row = $this->getBookdetails($id);



                        



                        $bktype = $this->getBooktype($id);



                        



                        $msgcontent = str_replace('from {username}', '', $msgcontent);



                        $msgcontent = str_replace('The below', 'Your below', $msgcontent);



                        $msgcontent = str_replace('{direction}', 'Arrival details', $msgcontent);



                        $msgcontent = str_replace('{transfer}', $bktype['transfer'], $msgcontent);



                        $msgcontent = str_replace('{bookid}', $id, $msgcontent);



                        $msgcontent = str_replace('{suburb}', $book_row[0]['arr_suburb'], $msgcontent);



                        $msgcontent = str_replace('{address1}', $book_row[0]['arr_address1'], $msgcontent);



                        $msgcontent = str_replace('{address2}', $book_row[0]['arr_address2'], $msgcontent);



                        $msgcontent = str_replace('{mobile}', $book_row[0]['arr_mobile'], $msgcontent);



                        $msgcontent = str_replace('{phone}', $book_row[0]['arr_phone'], $msgcontent);



                        $msgcontent = str_replace('{flight}', $book_row[0]['arr_flight'], $msgcontent);



                        $msgcontent = str_replace('{airline}', $book_row[0]['arr_airline'], $msgcontent);



                        $msgcontent = str_replace('{origin}', $book_row[0]['arr_origin'], $msgcontent);



                        $msgcontent = str_replace('{terminal}', $book_row[0]['arr_terminal'], $msgcontent);



                        $msgcontent = str_replace('{depdate}', $book_row[0]['arr_date'], $msgcontent);



                        $msgcontent = str_replace('{fltime}', $bktype['arrfltime'], $msgcontent);



                        $msgcontent = str_replace('{passengers}', $book_row[0]['arr_passengers'], $msgcontent);



                        $msgcontent = str_replace('{babyseats}', $book_row[0]['arr_babyseats'], $msgcontent);



                        $msgcontent = str_replace('{comments}', $book_row[0]['arr_comments'], $msgcontent);



                        $msgcontent = str_replace('{estfare}', $book_row[0]['arr_estfare'], $msgcontent);



                          



                    if($booktype=='Other') {



                        



                        if($arraddress2val!='') $arr_destination = $arrdest;



                        else $arr_destination = $marraddress;



                        



                        $msgcontent = str_replace('{othertransfer}', $arr_destination, $msgcontent);



                        



                        $msgcontent = str_replace('{pickupsuburb}', $book_row[0]['arr_drop_suburb'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress1}', $book_row[0]['arr_drop_adress1'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress2}', $book_row[0]['arr_drop_address2'], $msgcontent);



                        $msgcontent = str_replace('{pickupmobile}', $book_row[0]['arr_drop_mobile'], $msgcontent);



                        $msgcontent = str_replace('{pickupphone}', $book_row[0]['arr_drop_phone'], $msgcontent);



                        



                        $msgcontent = str_replace('{dropsuburb}', $book_row[0]['arr_suburb'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress1}', $book_row[0]['arr_address1'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress2}', $book_row[0]['arr_address2'], $msgcontent);



                        $msgcontent = str_replace('{dropmobile}', $book_row[0]['arr_mobile'], $msgcontent);



                        $msgcontent = str_replace('{dropphone}', $book_row[0]['arr_phone'], $msgcontent);



                        



                    }



                        



                        // receiver mail



                        if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];



                        else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];



                        else if($tomail!='') $receiver = $tomail;



                        else $receiver = '';



                      



                        // mail save to mail trigger table



                        $this->tbl_name = "mail_trigger";



                        $crdate = date('Y-m-d H:i:s');



                        $mdata = array('book_id'=>$id,'from'=>$frmmail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);







                        $this->db->insert($this->tbl_name,$mdata);



                        



                      }



                      



                     }



                    



                    }



                    



                    else if($direction=='departure') {



                        



                        if(empty($_POST['depcancel'])) {



                        // get mail template



                        $msgrow = $this->getMailtemp($booktype,$direction);



                        // subject



                        $sub_ject = str_replace('{Booking Reference Number}',$id,$msgrow[0]['subject']);



                        



                        $passenger = $this->getClientname($client);



                        



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



                        



                    }



                    else {



                        // cancel mail



                        if($booktype=='AP') $msgrow = $this->getMailtempBasedonId($eid=33);



                        else if($booktype=='Other') $msgrow = $this->getMailtempBasedonId($eid=38);



                        else $msgrow = $this->getMailtempBasedonId($eid=35);



                        $sub_ject = "Booking cancelled for ".$id;



                        $msgcontent = $msgrow[0]['content'];



                        



                        $book_row = $this->getBookdetails($id); // booking details



                        



                        $bktype = $this->getBooktype($id); // book type



                        



                        $msgcontent = str_replace('from {username}', '', $msgcontent);



                        $msgcontent = str_replace('The below', 'Your below', $msgcontent);



                        $msgcontent = str_replace('{direction}', 'Departure details', $msgcontent);



                        $msgcontent = str_replace('{transfer}', $bktype['transfer'], $msgcontent);



                        $msgcontent = str_replace('{bookid}', $id, $msgcontent);



                        $msgcontent = str_replace('{suburb}', $book_row[0]['dep_suburb'], $msgcontent);



                        $msgcontent = str_replace('{address1}', $book_row[0]['dep_address1'], $msgcontent);



                        $msgcontent = str_replace('{address2}', $book_row[0]['dep_address2'], $msgcontent);



                        $msgcontent = str_replace('{mobile}', $book_row[0]['dep_mobile'], $msgcontent);



                        $msgcontent = str_replace('{phone}', $book_row[0]['dep_phone'], $msgcontent);



                        $msgcontent = str_replace('{flight}', $book_row[0]['dep_flight'], $msgcontent);



                        $msgcontent = str_replace('{airline}', $book_row[0]['dep_airline'], $msgcontent);



                        $msgcontent = str_replace('{origin}', $book_row[0]['dep_origin'], $msgcontent);



                        $msgcontent = str_replace('{terminal}', $book_row[0]['dep_terminal'], $msgcontent);



                        $msgcontent = str_replace('{depdate}', $book_row[0]['dep_date'], $msgcontent);



                        $msgcontent = str_replace('{fltime}', $bktype['fltime'], $msgcontent);



                        $msgcontent = str_replace('{passengers}', $book_row[0]['dep_passengers'], $msgcontent);



                        $msgcontent = str_replace('{babyseats}', $book_row[0]['dep_babyseats'], $msgcontent);



                        $msgcontent = str_replace('{comments}', $book_row[0]['dep_comments'], $msgcontent);



                        $msgcontent = str_replace('{estfare}', $book_row[0]['dep_estfare'], $msgcontent);



                        



                    if($booktype=='Other') {



                        



                        if($depaddress2val!='') $dep_destination = $depdest;



                        else $dep_destination = $mdepaddress;







                        $msgcontent = str_replace('{othertransfer}', $dep_destination, $msgcontent);



                        



                        $msgcontent = str_replace('{pickupsuburb}', $book_row[0]['dep_suburb'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress1}', $book_row[0]['dep_address1'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress2}', $book_row[0]['dep_address2'], $msgcontent);



                        $msgcontent = str_replace('{pickupmobile}', $book_row[0]['dep_mobile'], $msgcontent);



                        $msgcontent = str_replace('{pickupphone}', $book_row[0]['dep_phone'], $msgcontent);



                        



                        $msgcontent = str_replace('{dropsuburb}', $book_row[0]['dep_drop_suburb'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress1}', $book_row[0]['dep_drop_address1'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress2}', $book_row[0]['dep_drop_address2'], $msgcontent);



                        $msgcontent = str_replace('{dropmobile}', $book_row[0]['dep_drop_mobile'], $msgcontent);



                        $msgcontent = str_replace('{dropphone}', $book_row[0]['dep_drop_phone'], $msgcontent);



                        



                        



                    }



                        



                    }



                    



                        // receiver mail



                        if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];



                        else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];



                        else if($tomail!='') $receiver = $tomail;



                        else $receiver = '';



                        



                    // mail save to mail trigger table



                    $this->tbl_name = "mail_trigger";



                    $crdate = date('Y-m-d H:i:s');



                    $mdata = array('book_id'=>$id,'from'=>$frmmail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);



                            



                    $this->db->insert($this->tbl_name,$mdata);



                        







                }



                    else if($direction=='arrival') {



                        if(empty($_POST['arrcancel'])) {



                        // get mail template



                        $msgrow = $this->getMailtemp($booktype,$direction);



                        // subject



                        $sub_ject = str_replace('{Booking Reference Number}',$id,$msgrow[0]['subject']);







                        $passenger = $this->getClientname($client);



                        



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



                        



                    }



                    else {



                        // cancel mail



                        if($booktype=='AP') $msgrow = $this->getMailtempBasedonId($eid=33);



                        else if($booktype=='Other') $msgrow = $this->getMailtempBasedonId($eid=38);



                        else $msgrow = $this->getMailtempBasedonId($eid=35);



                        $sub_ject = "Booking cancelled for ".$id;



                        $msgcontent = $msgrow[0]['content'];



                        



                        // booking details



                        $book_row = $this->getBookdetails($id);



                        



                        $bktype = $this->getBooktype($id);



                        



                        $msgcontent = str_replace('from {username}', '', $msgcontent);



                        $msgcontent = str_replace('The below', 'Your below', $msgcontent);



                        $msgcontent = str_replace('{direction}', 'Arrival details', $msgcontent);



                        $msgcontent = str_replace('{transfer}', $bktype['transfer'], $msgcontent);



                        $msgcontent = str_replace('{bookid}', $id, $msgcontent);



                        $msgcontent = str_replace('{suburb}', $book_row[0]['arr_suburb'], $msgcontent);



                        $msgcontent = str_replace('{address1}', $book_row[0]['arr_address1'], $msgcontent);



                        $msgcontent = str_replace('{address2}', $book_row[0]['arr_address2'], $msgcontent);



                        $msgcontent = str_replace('{mobile}', $book_row[0]['arr_mobile'], $msgcontent);



                        $msgcontent = str_replace('{phone}', $book_row[0]['arr_phone'], $msgcontent);



                        $msgcontent = str_replace('{flight}', $book_row[0]['arr_flight'], $msgcontent);



                        $msgcontent = str_replace('{airline}', $book_row[0]['arr_airline'], $msgcontent);



                        $msgcontent = str_replace('{origin}', $book_row[0]['arr_origin'], $msgcontent);



                        $msgcontent = str_replace('{terminal}', $book_row[0]['arr_terminal'], $msgcontent);



                        $msgcontent = str_replace('{depdate}', $book_row[0]['arr_date'], $msgcontent);



                        $msgcontent = str_replace('{fltime}', $bktype['arrfltime'], $msgcontent);



                        $msgcontent = str_replace('{passengers}', $book_row[0]['arr_passengers'], $msgcontent);



                        $msgcontent = str_replace('{babyseats}', $book_row[0]['arr_babyseats'], $msgcontent);



                        $msgcontent = str_replace('{comments}', $book_row[0]['arr_comments'], $msgcontent);



                        $msgcontent = str_replace('{estfare}', $book_row[0]['arr_estfare'], $msgcontent);



                        



                    if($booktype=='Other') {



                        



                        if($arraddress2val!='') $arr_destination = $arrdest;



                        else $arr_destination = $marraddress;



                        



                        $msgcontent = str_replace('{othertransfer}', $arr_destination, $msgcontent);



                        



                        $msgcontent = str_replace('{dropsuburb}', $book_row[0]['arr_suburb'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress1}', $book_row[0]['arr_address1'], $msgcontent);



                        $msgcontent = str_replace('{dropaddress2}', $book_row[0]['arr_address2'], $msgcontent);



                        $msgcontent = str_replace('{dropmobile}', $book_row[0]['arr_mobile'], $msgcontent);



                        $msgcontent = str_replace('{dropphone}', $book_row[0]['arr_phone'], $msgcontent);







                        $msgcontent = str_replace('{pickupsuburb}', $book_row[0]['arr_drop_suburb'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress1}', $book_row[0]['arr_drop_address1'], $msgcontent);



                        $msgcontent = str_replace('{pickupaddress2}', $book_row[0]['arr_drop_address2'], $msgcontent);



                        $msgcontent = str_replace('{pickupmobile}', $book_row[0]['arr_drop_mobile'], $msgcontent);



                        $msgcontent = str_replace('{pickupphone}', $book_row[0]['arr_drop_phone'], $msgcontent);



                        



                    }



                        



                    }



                    



                        // receiver mail



                        if($msgrow[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$msgrow[0]['email'];



                        else if($msgrow[0]['email']!='') $receiver = $msgrow[0]['email'];



                        else if($tomail!='') $receiver = $tomail;



                        else $receiver = '';



                    



                    // mail save to mail trigger table



                    $this->tbl_name = "mail_trigger";



                    $crdate = date('Y-m-d H:i:s');



                    $mdata = array('book_id'=>$id,'from'=>$frmmail,'to'=>$receiver,'subject'=>$sub_ject,'message'=>$msgcontent,'created_date'=>$crdate);



                            



                    $this->db->insert($this->tbl_name,$mdata);



                        



                }      



                



            } // mail confirmation end



            



            // mail status table



                    $this->tbl_name = "booking_confirm_status";



                    $crdate = date('Y-m-d H:i:s');



                    if($_POST['mailconfirm']=='send') $mstatus = 1;



                    else $mstatus = 0;



                        



                    $sdata = array('book'=>$id,'user'=>$this->session->userdata('sess_userid'),'status'=>$mstatus,'created_date'=>$crdate);



                            



                    $this->db->insert($this->tbl_name,$sdata);



                



            }



         



            



            }



            $redirect_link = 'booking/edit/'.$id;

            redirect($redirect_link);

            



        }



        



        function delete($id) {



            // booking table



            $this->tbl_name = "booking";



            



            $this->db->where('id', $id);



            



            $this->db->delete($this->tbl_name);



            // multipickup_booking table



            $this->tbl_name = "multipickup_booking";



            



            $this->db->where('book_id', $id);



            



            $this->db->delete($this->tbl_name);



            



        }



        



        function getDriver($val) {







                $query = 'SELECT first_name,last_name FROM drivers WHERE id='.$val;



            



                $data = $this->db->query($query);



          



                $row = $data->result_array();



                



                return $row[0]['first_name']." ".$row[0]['last_name'];



            



        }



        



	function getDriverdata()



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



        



	function getAlldriver()



	{



		$this->tbl_name = "drivers";



					$this->db->select(array('id'));



                                        $this->db->where('status','1');



					$recset = $this->db->get($this->tbl_name);





		$arr = "";



                if(count($recset->result()) > 0) {

                    

		foreach ($recset->result() as $row)



		{



		   $arr.= $row->id.',';



		}



                $arr = substr($arr,0,-1);

                }



		return $arr;



	}



        



        function getMorebookdata($id) {



            



		$this->tbl_name = "booking_assoc";



					$this->db->select('*');



                                        $this->db->where('book_id',$id);



					$query = $this->db->get($this->tbl_name);



            



                                        return $query->result_array(); 



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







        function getClientname($id) {



            



                $query = "SELECT first_name, last_name FROM clients WHERE id='".$id."'";



            



                $data = $this->db->query($query);



          



                $row = $data->result_array();



                



                if($row) {



                    $cli_name = $row[0]['first_name'].' '.$row[0]['last_name'];



                }



                else $cli_name = '';



                



                return $cli_name;



            



        }



        



        function getMailtemp($val,$dir) {







                $query = "SELECT * FROM email_templates WHERE type='".$val."' AND direction='".$dir."'";



            



                $data = $this->db->query($query);



          



                $row = $data->result_array();



                



                return $row;



            



        }



        



        function getMailtempBasedonId($id) {







                $query = "SELECT * FROM email_templates WHERE id='".$id."'";



            



                $data = $this->db->query($query);



          



                $row = $data->result_array();



                



                return $row;



            



        }



        



        function delPickup($book) {



            



            $this->tbl_name = "multipickup_assoc";



            



            //$this->db->where('book_id', $next_id);



            $this->db->where('flag', 0);



            $this->db->where('book_id', $book);



            



            $this->db->delete($this->tbl_name);



            



            redirect('booking');



        } 







        function autoPickup($book) {



            



            $this->tbl_name = "multipickup_assoc";



            



           // $this->db->where('book_id', $next_id);



            $this->db->where('flag', 0);



            $this->db->where('book_id', $book);



            



            $this->db->delete($this->tbl_name);



        }



        



      function getBookdetails($bookid)  {



          



                $this->tbl_name = "booking";







                $this->db->select('*');







                $this->db->where('id',$bookid);







                $query = $this->db->get($this->tbl_name);







               return $query->result_array();



          



      }



      



      function getBooktype($bookid) {







                $this->tbl_name = "booking";







                $this->db->select('*');







                $this->db->where('id',$bookid);







                $query = $this->db->get($this->tbl_name);







               $book_row = $query->result_array();



          



               $bktype = $book_row[0]['type'];



               



               $depourtime = $book_row[0]['dep_ourtime'];



               $arrourtime = $book_row[0]['arr_ourtime'];



               $dtime = $book_row[0]['dep_time'];



               $atime = $book_row[0]['arr_time'];



               



                    switch ($bktype) {







                        case 'AP':



                            $transfer = 'Sydney Airport';



                            $fltime = $depourtime;



                            $arrfltime = $arrourtime;



                            break;







                        case 'DH':



                            $transfer = 'White Bay';



                            $fltime = $dtime;



                            $arrfltime = $atime;



                            break;







                        case 'CQ':



                            $transfer = 'Circular Quay';



                            $fltime = $dtime;



                            $arrfltime = $atime;



                            break;







                        case 'CS':



                            $transfer = 'Central Station';



                            $fltime = $dtime;



                            $arrfltime = $atime;



                            break;







                        case 'Other':



                            $transfer = 'Other';



                            $fltime = $dtime;



                            $arrfltime = $atime;



                            break;







                    }  



                    



                    return array('transfer'=>$transfer,'fltime'=>$fltime,'arrfltime'=>$arrfltime);



      }



      



      function addEmptybook() {



          



                        $this->tbl_name = 'booking';



                        



                        // delete empty booking

						

						//PRAKASH ----- 22-May-2013



                        /*$this->db->where('user','0');



                        $this->db->where('client','0');



                        $this->db->delete($this->tbl_name);*/



                        //PRAKASH ----- 22-May-2013

						



                        $empty_data = array('user'=>'0','client'=>'0');



                        $this->db->insert($this->tbl_name,$empty_data);



                        $dynamic_book_id = $this->db->insert_id();



                        



                $empty_book_session = array('dynamicbookid'=>$dynamic_book_id,'currentupdateid'=>$dynamic_book_id);



                $this->session->set_userdata($empty_book_session);



          return  $dynamic_book_id;



      }



}



?>