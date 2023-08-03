<?php



include('db_connect.php');



    $cisess_cookie = $_COOKIE['ci_session'];

     $cisess_cookie = stripslashes($cisess_cookie);

     $cisess_cookie = unserialize($cisess_cookie);

     $cisess_session_id = $cisess_cookie['session_id'];

    $cisess_query = "SELECT user_data FROM ci_sessions WHERE session_id = '$cisess_session_id'";



     $cisess_result = mysql_query($cisess_query);

     if (!$cisess_result) {

       die("Invalid Query");

     }

     $cisess_row = mysql_fetch_assoc($cisess_result);

     $cisess_data = unserialize($cisess_row['user_data']);



$data = $_POST['dataval'];



                        // define deciaml point

                            $dec_point = DECPOINT;

                            $prg = PREG;

                            $dollar = DOLLAR;



require_once 'Classes/PHPExcel.php';



// Create new PHPExcel object

$objPHPExcel = new PHPExcel();



// Set properties

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")

							 ->setLastModifiedBy("Maarten Balliauw")

							 ->setTitle("Office 2007 XLSX Test Document")

							 ->setSubject("Office 2007 XLSX Test Document")

							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")

							 ->setKeywords("office 2007 openxml php")

							 ->setCategory("Test result file");





 if(count($data)>0) {

     

     $row=6;

     $result = array();

     $m = 0;



                //    $perminfo = $objPHPExcel->getActiveSheet()->setTitle('report');                 

 /*    $row1 = array();

     for($i=0;$i<count($data);$i++) {

         $directions = $data[$i]['direction'];

               if((($directions=='both' || $directions=='departure') &&  $cisess_data['direction']=='both') || (($directions=='departure' || $directions=='both') && $cisess_data['direction']=='departure')) {

                   

                   if(($cisess_data['terminal']==$data[$i]['dep_terminal'] || $cisess_data['terminal'] == "0") && ($cisess_data['driver']==$data[$i]['dep_driver'] || ($cisess_data['driver']=='' || $cisess_data['driver']=='0')) && (@in_array($data[$i]['dep_suburb'],$cisess_data['suburbval']) || $cisess_data['suburbval'] == '') && (($data[$i]['dep_date']>=$cisess_data['fdbdate'] && $data[$i]['dep_date']<=$cisess_data['todbdate']) || ($cisess_data['fdbdate'] == "" && $cisess_data['todbdate'] == ""))) {

                       $row1[] = strtotime($data[$i]['dep_date']);

                   }

                   }



               if((($directions=='both' || $directions=='arrival') && $cisess_data['direction']=='both') || (($directions=='arrival' || $directions=='both') && $cisess_data['direction']=='arrival')) {

                   

                   if(($cisess_data['terminal']==$data[$i]['arr_terminal'] || $cisess_data['terminal'] == "0") && ($cisess_data['driver']==$data[$i]['arr_driver'] || ($cisess_data['driver']=='' || $cisess_data['driver']=='0')) && (@in_array($data[$i]['arr_suburb'],$cisess_data['suburbval']) || $cisess_data['suburbval'] == '') && (($data[$i]['arr_date']>=$cisess_data['fdbdate'] && $data[$i]['arr_date']<=$cisess_data['todbdate']) || ($cisess_data['fdbdate'] == "" && $cisess_data['todbdate'] == ""))) {



                       $row1[] = strtotime($data[$i]['arr_date']);

                       

                   }

                   }                   

     } */

     

     

     for($i=0;$i<count($data);$i++) {

 

         $k = $i-1;

         

         $predate_day = '';

         

         $date_day = '';

         

                        $res_suburb = '';

                        

                        $deppickup_address = '';

                        

                        $depdrop_address = '';

                        

                        $pickup_address = '';

                        

                        $drop_address = '';

                        

                        $pickuptime = '';

                        

                        $pax = '';

                        

                        $ftime = '';

                        

                        $dcomm = '';

                        

                        $dphone = '';

                        

                        $directions = '';

                        

                        $amount = '';

                        

                        $client = '';

                        

                        $mobile = '';

                        

                        $driver = '';

                        

                        $depres_suburb = '';

                        

                        $other_drop_address = '';

                        

                        $other_arr_pickup = '';

                        

                        $dep_passengers_count = '';

                        

                        $arr_passengers_count = '';

                        

                        $dep_est = '';

                        $arr_est = '';

                        

                        

                        $directions = $data[$i]['direction'];

                        $book_type = $data[$i]['type'];



               if((($directions=='both' || $directions=='departure') &&  $cisess_data['direction']=='both') || (($directions=='departure' || $directions=='both') && $cisess_data['direction']=='departure')) {

                   

                   if(($cisess_data['terminal']==$data[$i]['dep_terminal'] || $cisess_data['terminal'] == "0") && ($cisess_data['driver']==$data[$i]['dep_driver'] || ($cisess_data['driver']=='' || $cisess_data['driver']=='0')) && (@in_array($data[$i]['dep_suburb'],$cisess_data['suburbval']) || $cisess_data['suburbval'] == '') && (($data[$i]['dep_date']>=$cisess_data['fdbdate'] && $data[$i]['dep_date']<=$cisess_data['todbdate']) || ($cisess_data['fdbdate'] == "" && $cisess_data['todbdate'] == ""))) {

                   

                       $result[$m] = $data[$i];

                       

                            if($data[$i]['dep_address2']!='') $deppickup_address = $data[$i]['dep_address1'].", ".$data[$i]['dep_address2'].", ".$data[$i]['dep_suburb'];

                            else if($data[$i]['dep_suburb']!='') $deppickup_address = $data[$i]['dep_address1'].", ".$data[$i]['dep_suburb'];

                            

                            // Other dep drop address

                            if($data[$i]['dep_drop_address2']!='') $other_drop_address = $data[$i]['dep_drop_address1'].', '.$data[$i]['dep_drop_address2'].', '.$data[$i]['dep_drop_suburb'];

                            else if($data[$i]['dep_drop_suburb']!='') $other_drop_address = $data[$i]['dep_drop_address1'].', '.$data[$i]['dep_drop_suburb'];

                            

                            //$depdrop_address = $data[$i]['dep_terminal'];

                            if($book_type=='AP') $depdrop_address = $data[$i]['dep_terminal'];

                            else if($book_type=='DH') $depdrop_address = 'White Bay';

                            else if($book_type=='CQ') $depdrop_address = 'Circular Quay';

                            else if($book_type=='CS') $depdrop_address = 'Central Station';

                            else if($book_type=='Other') $depdrop_address = $other_drop_address;

                            

                        

                            if($data[$i]['dep_date']!='' && $data[$i]['dep_date']!='0000-00-00') $depdate = $data[$i]['dep_date'];

                            else $depdate = '';

                            

                            if($data[$i]['dep_pickuptime']!=':') $pickuptime = $data[$i]['dep_pickuptime'];

                      

                            // Passengers

                            if($data[$i]['dep_passengers']==11) $dep_passengers = 'Charter';

                            else $dep_passengers = $data[$i]['dep_passengers'];

                            

                            if($data[$i]['dep_babyseats']!=0) $dep_babyseats = $data[$i]['dep_babyseats'];

                            else $dep_babyseats = '';

                            

                            if($data[$i]['dep_estfare']) {

                                $expdepest = @explode('$',$data[$i]['dep_estfare']);

                                if(count($expdepest)==2) $dep_est = @$expdepest[1];

                                else $dep_est = $data[$i]['dep_estfare'];

                            }

                            

                            $result[$m]['bookdir'] = $directions;

                            

                       $result[$m]['type'] = "Departure";

                       $result[$m]['date'] = $depdate;

                       $result[$m]['pickuptime'] = $pickuptime;

                       $result[$m]['pickupaddress'] = $deppickup_address;

                       $result[$m]['dropaddress'] = $depdrop_address;

                       $result[$m]['passengers'] = $dep_passengers;

                       $result[$m]['babyseats'] = $dep_babyseats;

                       $result[$m]['amount'] = $dollar.@number_format(preg_replace($prg, '', $data[$i]['dep_estfare']), $dec_point, '.', '');

                       $result[$m]['fltime'] = $data[$i]['dep_ourtime'];

                       $result[$m]['client'] = $data[$i]['client'];

                       $result[$m]['mobile'] = $data[$i]['dep_mobile'];

                       $result[$m]['driver'] = $data[$i]['dep_driver'];

                       $result[$m]['comments'] = $data[$i]['dep_comments'];

                       $result[$m]['cancelbook'] = $data[$i]['cancel_book'];

                       $result[$m]['book_confirmed'] = $data[$i]['dep_booking_confirmed'];

                       $result[$m]['payment_method'] = $data[$i]['payment_method'];

                       $result[$m]['paid_status'] = $data[$i]['paid_status'];

                       $result[$m]['book_type'] = $book_type;

                       

                       // comments

                       $result[$m]['exdate'] = $data[$i]['arr_date'];

                       $result[$m]['exestfare'] = $dollar.@number_format(preg_replace($prg, '', $data[$i]['arr_estfare']), $dec_point, '.', '');

                       $result[$m]['exflight'] = $data[$i]['arr_flight'];

                       $result[$m]['exourtime'] = $data[$i]['arr_ourtime'];

                       

                       $result[$m]['exarrdate'] = $data[$i]['arr_date'];

                       $result[$m]['exdepdate'] = $data[$i]['dep_date'];



                       $result[$m]['exarrpickup'] = $data[$i]['arr_pickuptime'];

                       $result[$m]['exdeppickup'] = $data[$i]['dep_pickuptime'];

                       

                       $result[$m]['direction'] = $directions;

                       

                       $result[$m]['totalpassengers'] = $data[$i]['dep_passengers'];

                       $result[$m]['totalestfare'] = $dep_est;

                       

                       $m++;

                            

               }

     }

               if((($directions=='both' || $directions=='arrival') && $cisess_data['direction']=='both') || (($directions=='arrival' || $directions=='both') && $cisess_data['direction']=='arrival')) {

                   

                   if(($cisess_data['terminal']==$data[$i]['arr_terminal'] || $cisess_data['terminal'] == "0") && ($cisess_data['driver']==$data[$i]['arr_driver'] || ($cisess_data['driver']=='' || $cisess_data['driver']=='0')) && (@in_array($data[$i]['arr_suburb'],$cisess_data['suburbval']) || $cisess_data['suburbval'] == '') && (($data[$i]['arr_date']>=$cisess_data['fdbdate'] && $data[$i]['arr_date']<=$cisess_data['todbdate']) || ($cisess_data['fdbdate'] == "" && $cisess_data['todbdate'] == ""))) {

                   

                        $result[$m] = $data[$i];

                        

                            if($data[$i]['arr_address2']!='') $drop_address = $data[$i]['arr_address1'].", ".$data[$i]['arr_address2'].", ".$data[$i]['arr_suburb'];

                            else if($data[$i]['arr_suburb']!='') $drop_address = $data[$i]['arr_address1'].", ".$data[$i]['arr_suburb'];

                                

                            // Other arrival pickup

                            if($data[$i]['arr_drop_address2']!='') $other_arr_pickup = $data[$i]['arr_drop_address1'].', '.$data[$i]['arr_drop_address2'].', '.$data[$i]['arr_drop_suburb'];

                            else if($data[$i]['arr_drop_suburb']!='') $other_arr_pickup = $data[$i]['arr_drop_address1'].', '.$data[$i]['arr_drop_suburb'];

                            

                            //$pickup_address = $data[$i]['arr_flight'];

                            if($book_type=='AP') {

                                if($data[$i]['arr_flight']!='') $pickup_address = $data[$i]['arr_flight'];

                                else $pickup_address = $data[$i]['arr_terminal'];
								
                            }

                            else if($book_type=='DH') $pickup_address = 'White Bay';

                            else if($book_type=='CQ') $pickup_address = 'Circular Quay';

                            else if($book_type=='CS') $pickup_address = 'Central Station';

                            else if($book_type=='Other') $pickup_address = $other_arr_pickup;

                        



                            if($data[$i]['arr_date']!='' && $data[$i]['arr_date']!='0000-00-00') $arrdate = $data[$i]['arr_date'];

                            else $arrdate = '';

                            

                            if($data[$i]['arr_pickuptime']!=':') {

                                //$pickuptime = $data[$i]['arr_pickuptime'];

                                

                                                $exp_picktime = explode(':',$data[$i]['arr_pickuptime']);

                                                $pickhours = $exp_picktime[0];

                                                

                                                $arrpickmin = @$exp_picktime[1];

                                                

                                                    if ($arrpickmin < 05)

                                                        $arrmin = '00';

                                                    else if ($arrpickmin > 05 && $arrpickmin < 10)

                                                        $arrmin = '05';

                                                    else if ($arrpickmin > 10 && $arrpickmin < 15)

                                                        $arrmin = 10;

                                                    else if ($arrpickmin > 15 && $arrpickmin < 20)

                                                        $arrmin = 20;

                                                    else if ($arrpickmin > 20 && $arrpickmin < 25)

                                                        $arrmin = 20;

                                                    else if ($arrpickmin > 25 && $arrpickmin < 30)

                                                        $arrmin = 25;

                                                    else if ($arrpickmin > 30 && $arrpickmin < 35)

                                                        $arrmin = 30;

                                                    else if ($arrpickmin > 35 && $arrpickmin < 40)

                                                        $arrmin = 35;

                                                    else if ($arrpickmin > 40 && $arrpickmin < 45)

                                                        $arrmin = 40;

                                                    else if ($arrpickmin > 45 && $arrpickmin < 50)

                                                        $arrmin = 45;

                                                    else if ($arrpickmin > 50 && $arrpickmin < 55)

                                                        $arrmin = 50;

                                                    else if ($arrpickmin > 55)

                                                        $arrmin = 55;

                                                    else $arrmin = $arrpickmin;

                                                    

                                                    $pickuptime = $pickhours.":".$arrmin;

                                

                            }

                            

                            // Passengers

                            if($data[$i]['arr_passengers']==11) $arr_passengers = 'Charter';

                            else $arr_passengers = $data[$i]['arr_passengers'];

                            

                            if($data[$i]['arr_babyseats']!=0) $arr_babyseats = $data[$i]['arr_babyseats'];

                            else $arr_babyseats = '';

                            

                            if($data[$i]['arr_estfare']) {

                                $exparrest = @explode('$',$data[$i]['arr_estfare']);

                                if(count($exparrest)==2) $arr_est = @$exparrest[1];

                                else $arr_est = $data[$i]['arr_estfare'];

                            }

                            

                            $result[$m]['bookdir'] = $directions;

                            

                       $result[$m]['type'] = "Arrival";

                       $result[$m]['date'] = $arrdate;

                       $result[$m]['pickuptime'] = $pickuptime;

                       $result[$m]['pickupaddress'] = $pickup_address;

                       $result[$m]['dropaddress'] = $drop_address;

                       $result[$m]['passengers'] = $arr_passengers;

                       $result[$m]['babyseats'] = $arr_babyseats;

                       $result[$m]['amount'] = $dollar.@number_format(preg_replace($prg, '', $data[$i]['arr_estfare']), $dec_point, '.', '');

                       $result[$m]['fltime'] = $data[$i]['arr_ourtime'];

                       $result[$m]['client'] = $data[$i]['client'];

                       $result[$m]['mobile'] = $data[$i]['arr_mobile'];

                       $result[$m]['driver'] = $data[$i]['arr_driver'];

                       $result[$m]['comments'] = $data[$i]['arr_comments'];

                       $result[$m]['cancelbook'] = $data[$i]['cancel_book'];

                       $result[$m]['book_confirmed'] = $data[$i]['arr_booking_confirmed'];

                       $result[$m]['payment_method'] = $data[$i]['payment_method'];

                       $result[$m]['paid_status'] = $data[$i]['paid_status'];

                       $result[$m]['book_type'] = $book_type;

                       

                       // comments

                       $result[$m]['exdate'] = $data[$i]['dep_date'];

                       $result[$m]['exestfare'] = $dollar.@number_format(preg_replace($prg, '', $data[$i]['dep_estfare']), $dec_point, '.', '');

                       $result[$m]['exflight'] = $data[$i]['dep_flight'];

                       $result[$m]['exourtime'] = $data[$i]['dep_ourtime'];

                       

                       $result[$m]['exarrdate'] = $data[$i]['arr_date'];

                       $result[$m]['exdepdate'] = $data[$i]['dep_date'];

                       

                       $result[$m]['exarrpickup'] = $data[$i]['arr_pickuptime'];

                       $result[$m]['exdeppickup'] = $data[$i]['dep_pickuptime'];

                       

                       $result[$m]['direction'] = $directions;

                       

                       $result[$m]['totalpassengers'] = $data[$i]['arr_passengers'];

                       $result[$m]['totalestfare'] = $arr_est;

                       

                       $m++;

                            

               }

        }

     } 



     // order by section

  /*   $row2 = array();

     for ($j=0; $j < count($result); $j++ ) {

         

         if(($result[$j]['type']=='Departure' && $result[$j]['cancelbook']!=1)) { 

            $row2[] = strtotime($result[$j]['dep_date']);

            

         }

         if(($result[$j]['type']=='Arrival' && $result[$j]['cancelbook']!=2)) { 

            $row2[] = strtotime($result[$j]['arr_date']);

         }

         

     } */

     

     // Departure Arrival cancel condition / order by condition

     $re_assign = array();

      $date_order = array();

      $pickup_order = array();

      

     for ($t=0; $t < count($result); $t++ ) {

         

         if(($result[$t]['type']=='Departure' && $result[$t]['cancelbook']!=1)) { 

            $re_assign[$t] = $result[$t];

            

            $date_order[] = strtotime($result[$t]['dep_date']);

            

            $pickup_order[] = $result[$t]['dep_pickuptime'];

         }

         if(($result[$t]['type']=='Arrival' && $result[$t]['cancelbook']!=2)) { 

            $re_assign[$t] = $result[$t];

            

            $date_order[] = strtotime($result[$t]['arr_date']);

            

            $pickup_order[] = $result[$t]['arr_pickuptime'];

         }

         

     }

     

     // array multi row

     array_multisort($date_order, SORT_ASC, $pickup_order, SORT_ASC, $re_assign);

     

            $total_est = 0;

            $total_passengers = 0;

     

            $filename_format = '';

     // loop for final result

        for ($r=0; $r < count($re_assign); $r++ ) {

            

                

                   $k = $r-1;

                   $date_day = @date("D",strtotime($re_assign[$r]['date']));

                   $date_num = @date("d",strtotime($re_assign[$r]['date']));

                   $full_day = @date("l",strtotime($re_assign[$r]['date']));

                   $date_format = @date("jS F Y",strtotime($re_assign[$r]['date']));

                   $full_date = $full_day." ".$date_format;

                   

                   // excel file name

                   if($r==0) {

                       

                    $filename_date_num = @date("d",strtotime($re_assign[$r]['date']));

                    $filename_date_day = @date("D",strtotime($re_assign[$r]['date']));

                    

                       $filename_format = $filename_date_num." ".$filename_date_day;

                   }

                   

                   if($r!=0) $predate_day = @date("D",strtotime($re_assign[$k]['date']));

            

                if($date_day!=$predate_day) {  

                    $row=6;

                    if($r==0) {

                           $perminfo = $objPHPExcel->getActiveSheet()->setTitle($date_format);                 

                    }

                    else {

                            $perminfo  = $objPHPExcel->createSheet();

                            $perminfo ->setTitle($date_format);

                    } 

                  

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);

$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);

$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0); 

                    

$pageMargins = $perminfo->getPageMargins();

//$pageMargins->setTop('.1');

//$pageMargins->setBottom('.1');

$pageMargins->setLeft('.2');

$pageMargins->setRight('.2');



                     $perminfo ->getRowDimension('1')->setRowHeight(15);

                     $perminfo ->getRowDimension('2')->setRowHeight(15);

                     $perminfo ->getRowDimension('3')->setRowHeight(15);

                     

                     $perminfo ->getDefaultStyle()->getFont()->setName('sans-serif');

                     $perminfo ->getDefaultStyle()->getFont()->setSize(12);

                     $perminfo ->getDefaultStyle()->getFont()->setBold(true);

                     $perminfo ->getColumnDimension('A')->setWidth(6);

                     $perminfo ->getColumnDimension('B')->setWidth(23);

                     $perminfo ->getColumnDimension('C')->setWidth(30);

                     $perminfo ->getColumnDimension('D')->setWidth(30);

                     $perminfo ->getColumnDimension('E')->setWidth(8);

                     $perminfo ->getColumnDimension('F')->setWidth(5);

                     $perminfo ->getColumnDimension('G')->setWidth(10);

                     $perminfo ->getColumnDimension('H')->setWidth(7);

                     $perminfo ->getColumnDimension('I')->setWidth(25);

                     $perminfo ->getColumnDimension('J')->setWidth(15);

                     $perminfo ->getColumnDimension('K')->setWidth(20);

                     $perminfo ->getColumnDimension('L')->setWidth(35);

                     $perminfo ->getColumnDimension('M')->setWidth(16);

                     $perminfo ->getCell('B2')->getHyperlink()->setUrl('http://www.hillshuttle.com.au');

                     $perminfo ->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

                     $perminfo ->setShowGridlines(false);

                   //  $perminfo ->getStyle('C3')->getFont()->setBold(false);

                     

                     $perminfo ->getDefaultRowDimension()->setRowHeight(23);

                     $perminfo ->getStyle('A4:M4')->getFont()->setBold(true);

                     $perminfo ->getStyle('A4:M4')->getFont()->setSize(15);

                     

                     $perminfo ->getStyle('A1:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     $perminfo ->getStyle('A4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     $perminfo ->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     

                     $perminfo ->getStyle('A4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('B4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('B4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('B4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('B4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('C4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('D4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('D4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('D4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('D4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('E4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('E4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('E4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('F4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('F4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('F4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle('G4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('G4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('G4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('G4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle('H4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('H4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('H4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('H4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle('I4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('I4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('I4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('I4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('J4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('J4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('J4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('J4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('K4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('K4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('K4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('K4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('L4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('L4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('L4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('L4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('M4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('M4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('M4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('M4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle('A5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('B5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('B5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('B5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('B5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('C5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('E5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('E5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('E5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('F5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('F5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('F5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('F5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle('G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('G5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('G5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle('H5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('H5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('H5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('H5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle('I5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('I5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('I5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('J5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('J5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('K5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('K5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('L5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('L5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('L5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle('M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('M5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('M5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                 /*    $perminfo ->getStyle('C3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('C3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     

                    $styleArray = array(

                           'borders' => array(

                                 'outline' => array(

                                        'style' => PHPExcel_Style_Border::BORDER_THIN,

                                        'color' => array('rgb' => 'C0C0C0'),

                                 ),

                           ),

                    );                     

                                         //$perminfo ->getStyle('C3')->getBorders()->getAllBorders()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLUE));

                    $perminfo ->getStyle('C3')->applyFromArray($styleArray); */



                     $perminfo ->getStyle('D1')->getFont()->setBold(true);

                     $perminfo ->getStyle('D1')->getFont()->setSize(12);

                     

                     $perminfo->setCellValue('B1','Hills Airport Shuttle Pty Ltd')

                                ->setCellValue('C1','ABN 43 127 889 703')

                                ->setCellValue('D1','Drivers must check vehicle for roadworthy daily.')

                                ->setCellValue('J1','Private and Confidential')

                                ->setCellValue('B2','www.hillshuttle.com.au')

                                ->setCellValue('C2','Tel: 1300 139 271 / (02) 9899 1804')

                                ->setCellValue('D2','Drivers must not be under the influence of drugs or alcohol')

                                ->setCellValue('A3','')

                                ->setCellValue('B3',$full_date)

                                ->setCellValue('C3','Mobile 0411 034 350')

                                ->setCellValue('D3','while operating any vehicles.');

                                

                                $perminfo->setCellValue('A4','Conf')

                                ->setCellValue('B4','P/up time')

                                ->setCellValue('C4','P/up Address')

                                ->setCellValue('D4','Drop of Address')

                                ->setCellValue('E4','Pax')

                                ->setCellValue('F4','BSR')         

                                ->setCellValue('G4','Amount')

                                ->setCellValue('H4','Time')

                                ->setCellValue('I4','Name')

                                ->setCellValue('J4','Number')

                                ->setCellValue('K4','Driver')

                                ->setCellValue('L4','Comments')

                                ->setCellValue('M4','');

                    }

                  



                                $perminfo ->getStyle("A".$row.":M".$row)->getFont()->setSize(15);

                                $perminfo ->getStyle("A".$row.":M".$row)->getFont()->setBold(true);

                    

                     $perminfo ->getStyle("A".$row.":M".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    

                     $perminfo ->getStyle("A".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("B".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("C".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("D".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("E".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("F".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("G".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("H".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("I".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("J".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("K".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("L".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("M".$row)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle("C".$row)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("D".$row)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("I".$row)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("K".$row)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("L".$row)->getAlignment()->setWrapText(true);

                     $perminfo ->getRowDimension($row)->setRowHeight(-1);

                     

                     $perminfo ->getStyle("G".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                     $perminfo ->getStyle("G".$row)->getNumberFormat()->setFormatCode('$#,##0.00## ;[Red]-#,##0.## $');

                     

                     if(@$re_assign[$r]['book_confirmed']==1) $bkconfirmed = 'Yes';

                     else $bkconfirmed = 'No';

                         

                     $paid_status = '';

                     $paymethod = '';

                     $depdateval = '';

                     $arrdateval = '';

                     $dep_comments = '';

                     $bkcancel = '';

                     $dep_pickup = '';

                     $arr_pickup = '';

                     $bktype = '';

                     $paidstatus = '';

                     

                        $depdateval = @strtotime($re_assign[$r]['exdepdate']);

                        $arrdateval = @strtotime($re_assign[$r]['exarrdate']);



                        $dep_comments = @$re_assign[$r]['comments'];

                        $bkcancel = @$re_assign[$r]['cancelbook'];

                        

                        $dep_pickup = @$re_assign[$r]['exdeppickup'];

                        $arr_pickup = @$re_assign[$r]['exarrpickup'];

                        

                        $bktype = @$re_assign[$r]['book_type'];

                        

                        if(@$re_assign[$r]['type']=='Departure') {

                            

                   $depflag = false;

                    if(($depdateval<$arrdateval) && $bkcancel!=2) {

                        $depflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $bkcancel!=2 && ($dep_pickup<$arr_pickup)) {

                        $depflag = true;

                    }

                           

                    if(@$re_assign[$r]['bookdir'] == 'both') {

                        if($depflag==true) {

                            if($bktype=='AP') $dep_comments .= " Ret ".date("d/m/Y",strtotime($re_assign[$r]['exdate']))." ".$re_assign[$r]['exflight']." ".$re_assign[$r]['exourtime']." ".$re_assign[$r]['exestfare'];

                            else $dep_comments .= " Ret ".date("d/m/Y",strtotime($re_assign[$r]['exdate']))." ".$re_assign[$r]['exestfare'];

                        }

                    }

                        }

                        

                        if(@$re_assign[$r]['type']=='Arrival') {

                            

                   $arrflag = false;

                    if(($depdateval>$arrdateval) && $bkcancel!=1) {

                        $arrflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $bkcancel!=1 && ($dep_pickup>$arr_pickup)) {

                        $arrflag = true;

                    }

                           

                    if(@$re_assign[$r]['bookdir'] == 'both') {

                        if($arrflag==true) {

                            if($bktype=='AP') $dep_comments .= " ".date("d/m/Y",strtotime($re_assign[$r]['exdate']))." ".$re_assign[$r]['exflight']." ".$re_assign[$r]['exourtime']." ".$re_assign[$r]['exestfare'];

                            else $dep_comments .= " ".date("d/m/Y",strtotime($re_assign[$r]['exdate']))." ".$re_assign[$r]['exestfare'];

                        }

                    }

                        }

                        

                            if(@$re_assign[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office

                            else if(@$re_assign[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver

                            else $paidstatus = '';

                            

                                if(@$re_assign[$r]['payment_method']=='credit card') $paymethod = 'CC';

                                else if(@$re_assign[$r]['payment_method']=='cash') $paymethod = 'Cash';

                                else $paymethod = '';

                            

                                if($paidstatus!='' || $paymethod!='') $paid_status = $paidstatus.' / '.$paymethod;

                            

                            $total_passengers += @$re_assign[$r]['totalpassengers'];

                            $total_est += @$re_assign[$r]['totalestfare'];

                                

                        $perminfo->setCellValue("A".$row, @$bkconfirmed);        

                        $perminfo->setCellValue("B".$row, @$re_assign[$r]['pickuptime']);

                        $perminfo->setCellValue("C".$row, @$re_assign[$r]['pickupaddress']);

                        $perminfo->setCellValue("D".$row, @$re_assign[$r]['dropaddress']);

                        $perminfo->setCellValue("E".$row, @$re_assign[$r]['passengers']);

                        $perminfo->setCellValue("F".$row, @$re_assign[$r]['babyseats']);

                        $perminfo->setCellValue("G".$row, @$re_assign[$r]['totalestfare']);

                        $perminfo->setCellValue("H".$row, @$re_assign[$r]['fltime']);

                        $perminfo->setCellValue("I".$row, @getClient($re_assign[$r]['client'],'name'));

                        $perminfo->setCellValue("J".$row, "'".@getClient($re_assign[$r]['client'],'phone')."'");

                        $perminfo->setCellValue("K".$row, @getDriver($re_assign[$r]['driver']));

                        $perminfo->setCellValue("L".$row, @$dep_comments);

                        $perminfo->setCellValue("M".$row, @$paid_status);

                        

                         $row++;

           

        }

     

     /*   if(count($re_assign)>0) {

        $passengers_count = 'Total Passengers: '.$total_passengers;

        $est_count = 'Total Amount: $'.@number_format(round((float)$total_est,2),2);

        

     $perminfo->setCellValue("A".$row, $passengers_count);

     $row = $row+1;

     $perminfo->setCellValue("A".$row, $est_count);

        } */

        

 }

 

 

 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet

$objPHPExcel->setActiveSheetIndex(0);



//$filename  = "report_".strtotime("now").".xls";

if($filename_format) {

$filename_format = str_replace(' ','_',$filename_format);

$filename = $filename_format.".xls";

$path = "excel_file/".$filename;

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save($path);



}

else $filename = 'empty';





echo $filename;



function getClient($val,$type) {

    

    $qry = 'select first_name,last_name,mobile from clients where id='.$val;

    $result = @mysql_query($qry);

    $num = @mysql_fetch_array($result);

    if($type=='name') return $num['first_name']." ".$num['last_name'];

    else return $num['mobile'];

}



function getDriver($val) {

    

    $qry = 'select first_name,last_name from drivers where id='.$val;

    $result = @mysql_query($qry);

    $row = @mysql_fetch_array($result);

    return $row['first_name']." ".$row['last_name'];

}



?>