<?php
//ACORR connects to database for dailycomment
require 'db/connect.php';
?>
            <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validation.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/datepicker.js"></script>
            
            <link href="<?php echo base_url();?>css/datepicker.css" rel="stylesheet" type="text/css" />
            
            <script type="text/javascript" src="<?php echo base_url();?>js/bpopup.js"></script>
            
            <link href="<?php echo base_url();?>css/bpopup.css" rel="stylesheet" type="text/css" />
            
            

            <div id="wrapper">
<div id="conarea1">
    <!-- Form content -->
        <div id="app-daysheet">
         <div class="page-head" style="margin-left: 50px;"><img src="<?php echo base_url();?>images/schedule.png" /><span class="page-headlbl" style="position: relative; top: -10px;">DAYSHEET</span></div>
         
         
        <!-- <div class="title-daysheet">DAYSHEET</div> -->
        <?php
            if(isset($_GET['page'])) $get_page = $_GET['page'];
            else $get_page = 1;
            if(isset($_GET['show'])) $show_url = '&show='.$_GET['show'];
            else $show_url = '';
            
            $frmurl = site_url().'daysheet/search?page='.$get_page.$show_url;
            
         // config decimal pointer
                            $decimal_pointer = $this->config->item('decimal_point');
                            $dec_point = $decimal_pointer['point'];
                            $prg = $decimal_pointer['prr'];
                            $dollar = $decimal_pointer['dollar'];
            
        ?>
        <form name="daysheet-form" id="frmdaysheet" method="post" action="<?php echo $frmurl; ?>">        

        <div class="search-new" style="width: 900px !important; margin-left: 10px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td width="6%">From Date</td>
                                <td width="10%"><input class="txt-box" type="text" name="fdate" id="fdate" value="<?php echo $this->session->userdata('fdate'); ?>" readonly/></td>
                                <td width=5%>To Date</td>
                                <td width="10%"><input class="txt-box" type="text" name="todate" id="todate" value="<?php echo $this->session->userdata('todate'); ?>" readonly/></td>
                                <td width="5%" style="text-align:right;">
                                    <input type="hidden" name="mode" id="mode" value="<?php if(isset($_POST['mode']) && $_POST['mode']!='') echo $_POST['mode']; ?>"/>
                                    <input type="hidden" name="book_id" class="book-id" id="book-id" />
                                    <input type="hidden" name="updated_bookid" id="updated_bookid" />
                                    <input type="hidden" name="mail_confirm_log" id="mail_confirm_log" value="no" />
                                    
                                    <input type="submit" name="sub-btn" class="btn" value="Show daysheet" onclick="return validateSubmit()" />  
                                </td>
                              <td width="1%" style="text-align:right;">&nbsp;</td>
                              <td width="35%" style="text-align:center"><b><font color='Red'>							 
<?php 
//ACORR insert comment  
	If ($this->session->userdata('fdate') == ""){ 
		echo "No Date selected yet";
	} else {
		$dateselected = $this->session->userdata('fdate');
		$datereversed = implode("/", array_reverse(explode("/", $dateselected)));		
		$query = mysql_query("SELECT comment FROM dailycomments WHERE date = '" . $datereversed . "'");
		
		//echo (mysql_num_rows($query) !== 0) ? mysql_result($query, 0, 'comment') : 'No comment for '.$dateselected.'';
		echo (mysql_num_rows($query) !== 0) ? mysql_result($query, 0, 'comment') : '';
	}
?></font></b></td>
                              <td width="5%" style="text-align:right;"><?php If ($this->session->userdata('fdate') != ""){ 
		echo '<input class="btn" type=button onClick="adddailycomment()" value="Add/Edit">';
	}?>
                              <td width="1%" style="text-align:right;">&nbsp;</td>
                            </tr>
                            </tbody>
            </table>
        </div>
        
        <br/><br/>
        <div id="notify-msg" class="notifymsg">Successfully updated<br/><br/></div>
        
        <?php
            $count = 0;    
            if(count($result_data)>0) {
                  
                // order by section
                $order_date = array();
                $order_pickup = array();
                $order_batch = array();
                
                for($s=0; $s<count($result_data); $s++) {
                    
                    $directions = $result_data[$s]['direction'];
                    $autoid = $result_data[$s]['auto'];
                    
                    if($autoid != 0)   {
                        
               if(($directions=='both' || $directions=='departure')) {
                   
                   if((($result_data[$s]['dep_date']>=$this->session->userdata('fdbdate') && $result_data[$s]['dep_date']<=$this->session->userdata('todbdate')) || ($this->session->userdata('fdbdate') == "" && $this->session->userdata('todbdate') == ""))) {
                    
                    $order_date[] = strtotime($result_data[$s]['dep_date']);
                    $order_pickup[] = $result_data[$s]['dep_pickuptime'];
                    $order_batch[] = $result_data[$s]['dep_batch'];
                    
                   }
               }
               if(($directions=='both' || $directions=='arrival')) {
                   
                   if((($result_data[$s]['arr_date']>=$this->session->userdata('fdbdate') && $result_data[$s]['arr_date']<=$this->session->userdata('todbdate')) || ($this->session->userdata('fdbdate') == "" && $this->session->userdata('todbdate') == ""))) {

                     $order_date[] = strtotime($result_data[$s]['arr_date']);  
                     $order_pickup[] = $result_data[$s]['arr_pickuptime'];
                     $order_batch[] = $result_data[$s]['arr_batch'];
                       
                   }
                   }    
                } // auto id not null
                }
                // order by section end
                
                $row = array();
                $m = 0;
                for($s=0; $s<count($result_data); $s++) {
                    
                        $res_suburb = '';
                        
                        $pickup_address = '';
                        
                        $drop_address = '';
                        
                        $directions = '';
                        
                        $depres_suburb = '';
                        
                        $deppickup_address = '';
                        
                        $depdrop_address = '';
                        
                        $dep_date = '';
                        
                        $arr_date = '';
                        
                        $dep_est = '';
                        $arr_est = '';
                    
                    $directions = $result_data[$s]['direction'];
                    
                    $book_type = $result_data[$s]['type'];
                    
                    $autoid = $result_data[$s]['auto'];
                    $book_flag = $result_data[$s]['mflag'];
                    
                 if($autoid != 0)   {
                    
               if(($directions=='both' || $directions=='departure')) {
                   
                   if((($result_data[$s]['dep_date']>=$this->session->userdata('fdbdate') && $result_data[$s]['dep_date']<=$this->session->userdata('todbdate')) || ($this->session->userdata('fdbdate') == "" && $this->session->userdata('todbdate') == ""))) {
                    
                       $row[$m] = $result_data[$s];
                       
                          //  if($result_data[$s]['dep_address2']!='') $deppickup_address = $result_data[$s]['dep_address1'].", ".$result_data[$s]['dep_address2'].", ".$result_data[$s]['dep_suburb'];
                            if($result_data[$s]['dep_suburb']!='') $deppickup_address = $result_data[$s]['dep_address1']."<br/> ".$result_data[$s]['dep_suburb'];
                            
                            // Other dep drop address
                            if($result_data[$s]['dep_drop_address2']!='') $other_drop_address = $result_data[$s]['dep_drop_address1'].', '.$result_data[$s]['dep_drop_address2'].', '.$result_data[$s]['dep_drop_suburb'];
                            else if($result_data[$s]['dep_drop_suburb']!='') $other_drop_address = $result_data[$s]['dep_drop_address1'].', '.$result_data[$s]['dep_drop_suburb'];
                                
                            if($book_type=='AP') $depdrop_address = $result_data[$s]['dep_terminal'];
                            else if($book_type=='DH') $depdrop_address = 'White Bay';
                            else if($book_type=='CQ') $depdrop_address = 'Circular Quay';
                            else if($book_type=='CS') $depdrop_address = 'Central Station';
                            else if($book_type=='Other') $depdrop_address = $other_drop_address;
                            
                            $dep_date = date('d/m/Y',strtotime($result_data[$s]['dep_date']));
                       
                            if($book_flag=='multiple') {
                                $dep_disabled = "disabled=disabled";
                                $book_autoval = '';
                                $book_typehidden = '';
                            }
                            else {
                                $dep_disabled = '';
                                
                                $book_autoval = '<input type="hidden" name="autoval[]" id="autoval" value="'.$autoid.'" />';
                                $book_typehidden = '<input type="hidden" name="dirval[]" id="dirval" value="Departure" />';
                            }
                            
                                                                                        $options = $getdriverval;
                                                                                        $opt = 'id="depdriver_val_'.$autoid.'" style="width:100px;"'.$dep_disabled.'';
                                                                                        $optval = $result_data[$s]['dep_driver'];
                                                                                         $depdriver = form_dropdown('driver_val[]', $options,$optval,$opt);

                            // pickup time dropdown
                                            $dep_pickhours = '';
                                            $dep_pickmin = '';
                                            if($result_data[$s]['dep_pickuptime']!='' && $result_data[$s]['dep_pickuptime']!=':') {
                                                $dep_picktime = explode(':',$result_data[$s]['dep_pickuptime']);
                                               $dep_pickhours = $dep_picktime[0];
                                                $dep_pickmin = @$dep_picktime[1];
                                                if($dep_pickmin==0) $dep_pickmin = 00;
                                            }
                                        
                            $dep_pickhrs = array(''=>'');
                            
                            for($k=0;$k<24;$k++) {
                                $k = str_pad($k, 2, "0", STR_PAD_LEFT);
                                $dep_pickhrs[$k] = $k;
                            }
                            
                            $depopt = 'id="deppichrs_val_'.$autoid.'" onchange="updatePopup('.$autoid.',\''.$book_flag.'\')" '.$dep_disabled.'';
                            $depoptval = $dep_pickhours;
                            $deppichrs = form_dropdown('pichrs_val[]', $dep_pickhrs,$depoptval,$depopt);

                            $dep_pickminarr = array(''=>'');
                            for($l=0;$l<60;$l+=15) {
                                $l = str_pad($l, 2, "0", STR_PAD_LEFT);
                                $dep_pickminarr[$l] = $l;
                            }
                            
                            $depminopt = 'id="deppicmin_val_'.$autoid.'" onchange="updatePopup('.$autoid.',\''.$book_flag.'\')" '.$dep_disabled.'';
                            $depminoptval = $dep_pickmin;
                            $deppicmin = form_dropdown('picmin_val[]', $dep_pickminarr,$depminoptval,$depminopt);
                            
                            // Passengers
                            if($result_data[$s]['dep_passengers']==10) $dep_passengers = 'Charter';
                            else  $dep_passengers = $result_data[$s]['dep_passengers'];
                            
                            if($result_data[$s]['dep_babyseats']!=0) $dep_babyseats = $result_data[$s]['dep_babyseats'];
                            else $dep_babyseats = '';
                            
                            if($result_data[$s]['dep_estfare']) {
                                $expdepest = @explode('$',$result_data[$s]['dep_estfare']);
                                if(count($expdepest)==2) $dep_est = @$expdepest[1];
                                else $dep_est = $result_data[$s]['dep_estfare'];
                            }
                            
                            // batch text box
                            $depbatch = '';
                            if($result_data[$s]["dep_batch"]!='empty') $depbatch = $result_data[$s]["dep_batch"];
                            
                            $batch_dep = '<input type="text" class="batchtext" name="batch[]" id="depbatch_'.$autoid.'" value="'.$depbatch.'" size="3" '.$dep_disabled.'/>';
                                
                            $row[$m]['bookdir'] = $directions;
                            
                       $row[$m]['type'] = "Departure";
                       $row[$m]['auto'] = $autoid;
                       $row[$m]['date'] = $dep_date;
                       $row[$m]['pickuptime'] = $deppichrs;
                       $row[$m]['pickupmin'] = $deppicmin;
                       $row[$m]['pickupaddress'] = $deppickup_address;
                       $row[$m]['dropaddress'] = $depdrop_address;
                       $row[$m]['passengers'] = $dep_passengers;
                       $row[$m]['babyseats'] = $dep_babyseats;
                       $row[$m]['amount'] = $dollar.number_format(preg_replace($prg, '', $result_data[$s]['dep_estfare']), $dec_point, '.', '');
                       $row[$m]['fltime'] = $result_data[$s]['dep_ourtime'];
                       $row[$m]['client'] = $result_data[$s]['client'];
                       $row[$m]['comments'] = $result_data[$s]['dep_comments'];
                       $row[$m]['ptime'] = $result_data[$s]['dep_pickuptime'];
                      
                       $row[$m]['driver'] = $depdriver;
                       $row[$m]['driverval'] = $result_data[$s]['dep_driver'];;
                       $row[$m]['mflag'] = $result_data[$s]['mflag'];
                       $row[$m]['multid'] = $result_data[$s]['multid'];
                       $row[$m]['createdby'] = $result_data[$s]['created_by'];
                       $row[$m]['updatedby'] = $result_data[$s]['updated_by'];
                       $row[$m]['hpickhrs'] = $dep_pickhours;
                       $row[$m]['hpickmin'] = $dep_pickmin;
                       $row[$m]['hdriver'] = $result_data[$s]['dep_driver'];
                       $row[$m]['hbooktype'] = $book_type;
                       $row[$m]['hestfare'] = $dollar.number_format(preg_replace($prg, '', $result_data[$s]['dep_estfare']), $dec_point, '.', '');
                       $row[$m]['harrflight'] = $result_data[$s]['arr_flight'];
					   $row[$m]['hdepflight'] = $result_data[$s]['dep_flight']; //ACorr
                       $row[$m]['harrourtime'] = $result_data[$s]['arr_ourtime'];
                       $row[$m]['htotal'] = $result_data[$s]['total'];
                       $row[$m]['harrterminal'] = $result_data[$s]['arr_terminal'];
                       $row[$m]['hdate'] = $result_data[$s]['dep_date'];
                       $row[$m]['cancelbook'] = $result_data[$s]['cancel_book'];
                       // export excel vars
                       $row[$m]['exdate'] = $result_data[$s]['arr_date'];
                       $row[$m]['exestfare'] = $dollar.number_format(preg_replace($prg, '', $result_data[$s]['arr_estfare']), $dec_point, '.', '');
                       $row[$m]['exflight'] = $result_data[$s]['arr_flight'];
                       $row[$m]['exourtime'] = $result_data[$s]['arr_ourtime'];
                       
                       $row[$m]['exarrdate'] = $result_data[$s]['arr_date'];
                       $row[$m]['exdepdate'] = $result_data[$s]['dep_date'];
                       $row[$m]['exdeppickup'] = $result_data[$s]['dep_pickuptime'];
                       $row[$m]['exarrpickup'] = $result_data[$s]['arr_pickuptime'];
                       
                       $row[$m]['book_confirmed'] = $result_data[$s]['dep_booking_confirmed'];
                       $row[$m]['paid_status'] = $result_data[$s]['paid_status'];
                       $row[$m]['payment_method'] = $result_data[$s]['payment_method'];
                       
                       $row[$m]['direction'] = $directions;
                       $row[$m]['autohidden'] = $book_autoval;
                       $row[$m]['booktypehidden'] = $book_typehidden;
                       
                       $row[$m]['totalpassengers'] = $result_data[$s]['dep_passengers'];
                       $row[$m]['totalestfare'] = $dep_est;
                       
                       $row[$m]['batch'] = $batch_dep;
                       $row[$m]['batchval'] = $result_data[$s]['dep_batch'];
                       
                       $m++;
                     
                   }
                   
               }
               
               if(($directions=='both' || $directions=='arrival')) {
                   
                   if((($result_data[$s]['arr_date']>=$this->session->userdata('fdbdate') && $result_data[$s]['arr_date']<=$this->session->userdata('todbdate')) || ($this->session->userdata('fdbdate') == "" && $this->session->userdata('todbdate') == ""))) {

                       $row[$m] = $result_data[$s];
                       
                            //if($result_data[$s]['arr_address2']!='') $drop_address = $result_data[$s]['arr_address1'].", ".$result_data[$s]['arr_address2'].", ".$result_data[$s]['arr_suburb'];
                            if($result_data[$s]['arr_suburb']!='') $drop_address = $result_data[$s]['arr_address1']."<br/> ".$result_data[$s]['arr_suburb'];
                            
                            // Other arrival pickup
                            if($result_data[$s]['arr_drop_address2']!='') $other_arr_pickup = $result_data[$s]['arr_drop_address1'].', '.$result_data[$s]['arr_drop_address2'].', '.$result_data[$s]['arr_drop_suburb'];
                            else if($result_data[$s]['arr_drop_suburb']!='') $other_arr_pickup = $result_data[$s]['arr_drop_address1'].', '.$result_data[$s]['arr_drop_suburb'];
                            
                            if($book_type=='AP') {
                                if($result_data[$s]['arr_flight']!='') $pickup_address = $result_data[$s]['arr_flight'];
                                else $pickup_address = $result_data[$s]['arr_terminal'];
                            }
                            else if($book_type=='DH') $pickup_address = 'White Bay';
                            else if($book_type=='CQ') $pickup_address = 'Circular Quay';
                            else if($book_type=='CS') $pickup_address = 'Central Station';
                            else if($book_type=='Other') $pickup_address = $other_arr_pickup;
                            
                            if($book_flag=='multiple') { 
                                $arr_disabled = "disabled=disabled";
                                $book_autoval = '';
                                $book_typehidden = '';
                            }
                            else {
                                $arr_disabled = '';
                                
                                $book_autoval = '<input type="hidden" name="autoval[]" id="autoval" value="'.$autoid.'" />';
                                $book_typehidden = '<input type="hidden" name="dirval[]" id="dirval" value="Arrival" />';
                            }
                            
                            $arr_date = date('d/m/Y',strtotime($result_data[$s]['arr_date']));
                            // driver dropdown
                            $options = $getdriverval;
                            $opt = 'id="arrdriver_val_'.$autoid.'" style="width:100px;"'.$arr_disabled.'';
                            $optval = $result_data[$s]['arr_driver'];
                            $arrdriver = form_dropdown('driver_val[]', $options,$optval,$opt);

                            // pickup time dropdown
                                            $pickhours = '';
                                            $pickmin = '';
                                            $arr_pickuptime = '';
                                            
                                            if($result_data[$s]['arr_pickuptime']!='' && $result_data[$s]['arr_pickuptime']!=':') {
                                                $exp_picktime = explode(':',$result_data[$s]['arr_pickuptime']);
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
                                                    
                                                    $arr_pickuptime = $pickhours.":".$arrmin;
                                                
                                            }
                            $pickhrs = array(''=>'');
                            for($j=0;$j<24;$j++) {
                                $j = str_pad($j, 2, "0", STR_PAD_LEFT);
                                $pickhrs[$j] = $j;
                            }
                            
                            $opt = 'id="arrpichrs_val_'.$autoid.'" onchange="updatePopup('.$autoid.',\''.$book_flag.'\')" '.$arr_disabled.'';
                            $optval = $pickhours;
                            $arrpichrs = form_dropdown('pichrs_val[]', $pickhrs,$optval,$opt);
                            
                            $arr_pickminarr = array(''=>'');
                            for($f=0;$f<60;$f+=5) {
                                $f = str_pad($f, 2, "0", STR_PAD_LEFT);
                                $arr_pickminarr[$f] = $f;
                            }
                            
                            $arrminopt = 'id="arrpicmin_val_'.$autoid.'" onchange="updatePopup('.$autoid.',\''.$book_flag.'\')" '.$arr_disabled.'';
                            $arrminoptval = $arrmin;
                            $arrpicmin = form_dropdown('picmin_val[]', $arr_pickminarr,$arrminoptval,$arrminopt);
                            
                            // Passengers
                            if($result_data[$s]['arr_passengers']==10) $arr_passengers = 'Charter';
                            else $arr_passengers = $result_data[$s]['arr_passengers'];
                            
                            if($result_data[$s]['arr_babyseats']!=0) $arr_babyseats = $result_data[$s]['arr_babyseats'];
                            else $arr_babyseats = '';
                            
                            if($result_data[$s]['arr_estfare']) {
                                $exparrest = @explode('$',$result_data[$s]['arr_estfare']);
                                if(count($exparrest)==2) $arr_est = @$exparrest[1];
                                else $arr_est = $result_data[$s]['arr_estfare'];
                            }
                            
                            // batch text box
                            $arrbatch = '';
                            if($result_data[$s]["arr_batch"]!='empty') $arrbatch = $result_data[$s]["arr_batch"];
                            
                            $batch_arr = '<input type="text" class="batchtext" name="batch[]" id="arrbatch_'.$autoid.'" value="'.$arrbatch.'" size="3" '.$arr_disabled.'/>';
                            
                            $row[$m]['bookdir'] = $directions;
                            
                       $row[$m]['type'] = "Arrival";
                       $row[$m]['auto'] = $autoid;
                       $row[$m]['date'] = $arr_date;
                       $row[$m]['pickuptime'] = $arrpichrs;
                       $row[$m]['pickupmin'] = $arrpicmin;
                       $row[$m]['pickupaddress'] = $pickup_address;
                       $row[$m]['dropaddress'] = $drop_address;
                       $row[$m]['passengers'] = $arr_passengers;
                       $row[$m]['babyseats'] = $arr_babyseats;
                       $row[$m]['amount'] = $dollar.number_format(preg_replace($prg, '', $result_data[$s]['arr_estfare']), $dec_point, '.', '');
                       $row[$m]['fltime'] = $result_data[$s]['arr_ourtime'];
                       $row[$m]['client'] = $result_data[$s]['client'];
                       $row[$m]['comments'] = $result_data[$s]['arr_comments'];
                       $row[$m]['ptime'] = $arr_pickuptime;
                     
                       $row[$m]['driver'] = $arrdriver;
                       $row[$m]['driverval'] = $result_data[$s]['arr_driver'];;
                       $row[$m]['mflag'] = $result_data[$s]['mflag'];
                       $row[$m]['multid'] = $result_data[$s]['multid'];
                       $row[$m]['createdby'] = $result_data[$s]['created_by'];
                       $row[$m]['updatedby'] = $result_data[$s]['updated_by'];
                       $row[$m]['hpickhrs'] = $pickhours;
                       $row[$m]['hpickmin'] = $pickmin;
                       $row[$m]['hdriver'] = $result_data[$s]['arr_driver'];
                       $row[$m]['hbooktype'] = $book_type;
                       $row[$m]['hestfare'] = $dollar.number_format(preg_replace($prg, '', $result_data[$s]['arr_estfare']), $dec_point, '.', '');
                       $row[$m]['harrflight'] = $result_data[$s]['arr_flight'];
					    $row[$m]['hdepflight'] = $result_data[$s]['dep_flight']; //ACorr
                       $row[$m]['harrourtime'] = $result_data[$s]['arr_ourtime'];
                       $row[$m]['htotal'] = $result_data[$s]['total'];
                       $row[$m]['harrterminal'] = $result_data[$s]['arr_terminal'];
                       $row[$m]['hdate'] = $result_data[$s]['arr_date'];
                       $row[$m]['cancelbook'] = $result_data[$s]['cancel_book'];
                       
                       // export excel vars
                       $row[$m]['exdate'] = $result_data[$s]['dep_date'];
                       $row[$m]['exestfare'] = $dollar.number_format(preg_replace($prg, '', $result_data[$s]['dep_estfare']), $dec_point, '.', '');
                       $row[$m]['exflight'] = $result_data[$s]['dep_flight'];
                       $row[$m]['exourtime'] = $result_data[$s]['dep_ourtime'];
                       
                       $row[$m]['exarrdate'] = $result_data[$s]['arr_date'];
                       $row[$m]['exdepdate'] = $result_data[$s]['dep_date'];
                       $row[$m]['exdeppickup'] = $result_data[$s]['dep_pickuptime'];
                       $row[$m]['exarrpickup'] = $result_data[$s]['arr_pickuptime'];
                       
                       
                       $row[$m]['book_confirmed'] = $result_data[$s]['arr_booking_confirmed'];
                       $row[$m]['paid_status'] = $result_data[$s]['paid_status'];
                       $row[$m]['payment_method'] = $result_data[$s]['payment_method'];
                       
                       $row[$m]['direction'] = $directions;
                       
                       $row[$m]['autohidden'] = $book_autoval;
                       $row[$m]['booktypehidden'] = $book_typehidden;
                       
                       $row[$m]['totalpassengers'] = $result_data[$s]['arr_passengers'];
                       $row[$m]['totalestfare'] = $arr_est;
                       
                       $row[$m]['batch'] = $batch_arr;
                       $row[$m]['batchval'] = $result_data[$s]['arr_batch'];
                       
                       $m++;
                   }
               } 
                   
                } // auto id not null
                
                }
                
                $count = count($row);
                
              array_multisort($order_batch, SORT_ASC, $order_date, SORT_ASC, $order_pickup, SORT_ASC, $row);


            } // count if end
                ?>

                        <div id="update-top" style="display:none; float: left;">
                            <input type="button" name="savbtn" id="savebtn" value="Update" class="bgbtn" onclick="return modeType()"/>
                        </div>

                        <div id="print-top" style="display:none; float: right; position: relative; left: 313px;">
                            <span class="excel-link"></span> <!-- for loading image -->
                            <input type="button" name="printbtn" id="printbtn" value="Print" class="bgbtn" onclick="return exportExcel()"/>
                        </div>
        <br/><br/>
        
        <table width="133%" border="0" cellpadding="0" cellspacing="0" class="grid-tbl">
            <tr>
                <td colspan="17" style="text-align: center">
                    <h2>Un-Allocated Bookings</h2>
                </td>
            </tr>
            <tr class="tit-td">
                
                <td>Conf</td>
                
                <td style="width: 3%;">Batch</td>
                
                <td style="width: 7%;">B.No.</td>
                
                <td style="width: 11%;">Date</td>
                
                <td>P/up Time</td>
                
                <td style="width: 15%;">P/up Address</td>
                
                <td style="width: 15%;">Drop off Address</td>
                
                <td style="width: 4%;">Pax</td>
                
                <td style="width: 3%;">B.S</td>
                
                <td style="width: 8%;">Amt</td>
                
                <td style="width: 5%;">Flt Time</td>
                
                <td style="width: 11%;">Client Name</td>
                
                <td style="width: 10%;">Number</td>
                
                <td>Driver</td>
                
                <td style="width: 4%;">Cmts</td>
                
                 <td style="width: 11%;">Collect Payment</td>
                
                <td>Last Modified by</td>
                
            </tr>
            <?php
            
            $update_show = 'disable';
            $kl = 0;
            $total_est = 0;
            $total_passengers = 0;
            
            if($count>0) {
                $k = 0;
                $reccount = $count;
                
                $flag = 'line';
                
                    for ($r=0; $r < $reccount; $r++ ) {
                        
                    // batch order with space
                       if((($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) || (($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2))) {
            
                        if((($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0') || (($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0')) {

                            if($flag=='line') {
                                
                                $flag = 'unline';
                            }
                            
                            $depbatchval = $row[$r]['batchval'];
                            
                            if($store_batch!=$depbatchval) {
                                
                                if($k!=0) echo '<tr><td colspan="17"></td></tr>';
                             
                                $flag = 'line';
                                $store_batch = $row[$r]['batchval'];
                            } 
                            
                           }
                        } 
                        // batch order with space end
                        

                       if(($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) {
            
                        if(($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0' || $row[$r]['driverval']=='') {
                    
                            if($row[$r]['book_confirmed']==1) $dep_confirm_checked = 'checked=checked';
                            else $dep_confirm_checked = '';
                            
            ?>
            
                <tr id="rowcolor_<?php echo $r; ?>">
                    
                        <input type="hidden" name="mflag[]" id="mflag" value="<?php echo $row[$r]['mflag']; ?>" />
                        <input type="hidden" name="multid[]" id="multid" value="<?php echo $row[$r]['multid']; ?>" />
                        <input type="hidden" name="unalldirval[]" id="unalldirval" value="<?php echo $row[$r]['type']; ?>" />
                        
                        <input type="hidden" name="bookdir[]" id="bookdir" value="<?php echo $row[$r]['bookdir']; ?>" />
                        <td>
                            <?php 
                                if($row[$r]['mflag']=='multiple') $dep_chk_disable = 'disabled=disabled';
                                else { 
                                    $dep_chk_disable = '';
                                }
                             ?>
                            <input type="checkbox" name="chk_confirm[<?php echo $kl; ?>]" value="1" <?php echo $dep_confirm_checked; ?> <?php echo $dep_chk_disable; ?>/>
                            <?php if($row[$r]['mflag']=='single') $kl++; ?>
                        </td>
                        
                        <td>
                            <?php echo $row[$r]['batch']; ?>
                        </td>
                        
                    <td style="word-break: break-all;">
                        <a href="http://www.hillshuttle.com.au/App/booking/edit/<?php echo $row[$r]['auto']; ?>"><?php echo $row[$r]['auto']; ?></a>
                        
                        <?php echo $row[$r]['autohidden']; ?>
                        <?php echo $row[$r]['booktypehidden']; ?>
                        
                        <input type="hidden" name="hbooktype[]" value="<?php echo $row[$r]['hbooktype']; ?>" />
                        <input type="hidden" name="hdate[]" value="<?php echo $row[$r]['hdate']; ?>" />
                        <input type="hidden" name="hestfare[]" value="<?php echo $row[$r]['hestfare']; ?>" />
                        <input type="hidden" name="harrflight[]" value="<?php echo $row[$r]['harrflight']; ?>" />
                        <input type="hidden" name="hdepflight[]" value="<?php echo $row[$r]['hdepflight']; //ACorr?>" />
                        <input type="hidden" name="harrourtime[]" value="<?php echo $row[$r]['harrourtime']; ?>" />
                        <input type="hidden" name="htotal[]" value="<?php echo $row[$r]['htotal']; ?>" />
                        <input type="hidden" name="harrterminal[]" value="<?php echo $row[$r]['harrterminal']; ?>" />
                    </td>
                        
                    <td style="word-break: break-all;"><a href="javascript:;" onclick="highlightRow(<?php echo $r; ?>)"><?php echo $row[$r]['date']; ?></a></td>
                    
                    <td nowrap >
                        <?php if($row[$r]['pickuptime']!=':') echo $row[$r]['pickuptime']; ?> <?php if($row[$r]['pickupmin']!='') echo $row[$r]['pickupmin']; ?>
                        <input type="hidden" name="hpickhrs[]" value="<?php echo $row[$r]['hpickhrs']; ?>" />
                        <input type="hidden" name="hpickmin[]" value="<?php echo $row[$r]['hpickmin']; ?>" />
                        <input type="hidden" name="hpickup[]" value="<?php echo $row[$r]['pickupaddress']; ?>" />
                    </td>
                        
                    <td style="word-break: break-all;"><?php echo $row[$r]['pickupaddress']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['dropaddress']; ?> <?php if($row[$r]['hdepflight']!="")echo " - ".$row[$r]['hdepflight']; //ACorr?></td>
                    
                    <td style="word-break: break-all;"><?php if ($row[$r]['passengers'] == 10) { echo "Charter"; } else { echo $row[$r]['passengers'];} ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['babyseats']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['amount']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['fltime']; ?></td>
                    
                    <td style="word-break: break-all;">
                        <?php if($row[$r]['client']) echo $this->daysheet_model->getClient($row[$r]['client']); ?>
                        <input type="hidden" name="hclient[]" value="<?php echo $row[$r]['client']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;"><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone($row[$r]['client']); ?><br /><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone2($row[$r]['client']); ?></td>
                    
                    <td>
                        <?php echo $row[$r]['driver']; ?>
                        <input type="hidden" name="hdriver[]" value="<?php echo $row[$r]['hdriver']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;">
                        
                        <a href="javascript:;" id="viewcmd_<?php echo $row[$r]['auto']; ?>" onclick="showPopup('<?php echo $row[$r]['auto']; ?>','<?php echo $k; ?>','unallocate')" nowrap>View</a>
                    </td>
                    
                    <td style="word-break: break-all;">
                        <?php 
                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office
                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver
                            else $paidstatus = '';
                            
                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';
                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
								else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr
                                else $paymethod = '';
                            
                                if($paidstatus!='' || $paymethod!='') echo $paidstatus.' / '.$paymethod;
                            ?>
                    </td> 
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['updatedby']; ?></td>
                    
                </tr>
                
            <?php 
               $k++;
               
               $update_show = 'enable';
               
                    } // if cond end
                    } // cancel book end
                     else if(($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2)) {
            
                        if(($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0' || $row[$r]['driverval']=='') {
            
                            if($row[$r]['book_confirmed']==1) $arr_confirm_checked = 'checked=checked';
                            else $arr_confirm_checked = '';
                            
                            ?>
                
                <tr id="rowcolor_<?php echo $r; ?>">
                    
                        <input type="hidden" name="mflag[]" id="mflag" value="<?php echo $row[$r]['mflag']; ?>" />
                        <input type="hidden" name="multid[]" id="multid" value="<?php echo $row[$r]['multid']; ?>" />
                        <input type="hidden" name="unalldirval[]" id="unalldirval" value="<?php echo $row[$r]['type']; ?>" />
                        
                        <input type="hidden" name="bookdir[]" id="bookdir" value="<?php echo $row[$r]['bookdir']; ?>" />
                        <td>
                            <?php 
                                if($row[$r]['mflag']=='multiple') $arr_chk_disable = 'disabled=disabled';
                                else { 
                                    $arr_chk_disable = '';
                                }
                             ?>
                            
                            <input type="checkbox" name="chk_confirm[<?php echo $kl; ?>]" value="1" <?php echo $arr_confirm_checked; ?> <?php echo $arr_chk_disable; ?>/>
                            <?php if($row[$r]['mflag']=='single') $kl++; ?>
                        </td>
                        
                        <td>
                            <?php echo $row[$r]['batch']; ?>
                        </td>
                        
                    <td style="word-break: break-all;">
                        <a href="http://www.hillshuttle.com.au/App/booking/edit/<?php echo $row[$r]['auto']; ?>"><?php echo $row[$r]['auto']; ?></a>
                        <?php echo $row[$r]['autohidden']; ?>
                        <?php echo $row[$r]['booktypehidden']; ?>
                        
                        <input type="hidden" name="hbooktype[]" value="<?php echo $row[$r]['hbooktype']; ?>" />
                        <input type="hidden" name="hdate[]" value="<?php echo $row[$r]['hdate']; ?>" />
                        <input type="hidden" name="hestfare[]" value="<?php echo $row[$r]['hestfare']; ?>" />
                        <input type="hidden" name="harrflight[]" value="<?php echo $row[$r]['harrflight']; ?>" />
                        <input type="hidden" name="harrourtime[]" value="<?php echo $row[$r]['harrourtime']; ?>" />
                        <input type="hidden" name="htotal[]" value="<?php echo $row[$r]['htotal']; ?>" />
                        <input type="hidden" name="harrterminal[]" value="<?php echo $row[$r]['harrterminal']; ?>" />
                    </td>
                        
                    <td style="word-break: break-all;"><a href="javascript:;" onclick="highlightRow(<?php echo $r; ?>)"><?php echo $row[$r]['date']; ?></a></td>                    
                    
                    <td nowrap >
                        <?php if($row[$r]['pickuptime']!=':') echo $row[$r]['pickuptime']; ?> <?php if($row[$r]['pickupmin']!='') echo $row[$r]['pickupmin']; ?>
                        <input type="hidden" name="hpickhrs[]" value="<?php echo $row[$r]['hpickhrs']; ?>" />
                        <input type="hidden" name="hpickmin[]" value="<?php echo $row[$r]['hpickmin']; ?>" />
                        <input type="hidden" name="hpickup[]" value="<?php echo $row[$r]['pickupaddress']; ?>" />
                    </td>
                        
                    <td style="word-break: break-all;"><?php echo $row[$r]['pickupaddress']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['dropaddress']; ?></td>
                    
                    <td style="word-break: break-all;"><?php if ($row[$r]['passengers'] == 10) { echo "Charter"; } else { echo $row[$r]['passengers'];} ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['babyseats']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['amount']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['fltime']; ?></td>
                    
                    <td style="word-break: break-all;">
                        <?php if($row[$r]['client']) echo $this->daysheet_model->getClient($row[$r]['client']); ?>
                        <input type="hidden" name="hclient[]" value="<?php echo $row[$r]['client']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;"><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone($row[$r]['client']); ?><br /><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone2($row[$r]['client']); ?></td>
                    
                    <td>
                        <?php echo $row[$r]['driver']; ?>
                        <input type="hidden" name="hdriver[]" value="<?php echo $row[$r]['hdriver']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;">
                        
                        <a href="javascript:;" id="viewcmd_<?php echo $row[$r]['auto']; ?>" onclick="showPopup('<?php echo $row[$r]['auto']; ?>','<?php echo $k; ?>','unallocate')" nowrap>View</a>
                    </td>
                    
                     <td style="word-break: break-all;">
                        <?php 
                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office
                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver
                            else $paidstatus = '';
                            
                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';
                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
                                else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr
								else $paymethod = '';
                            
                                if($paidstatus!='' || $paymethod!='') echo $paidstatus.' / '.$paymethod;
                            ?>
                    </td> 
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['updatedby']; ?></td>
                    
                </tr>
                
            <?php 
               $k++;
               $update_show = 'enable';
                    } // if cond end
                    } // else if cancel book end   
               
                    
            } // for loop end
                  } // empty cond end
                  ?>
                <?php
                
                if(empty($k)) {
            ?>
                
                <tr>
                    
                    <td style="text-align: center;" colspan="17">No records found</td>
                 
                </tr>
            <?php
            
                }
                ?>
                
        </table>
            <br/><br/>    
        <table width="133%" border="0" cellpadding="0" cellspacing="0" class="grid-tbl">
            <tr>
                <td colspan="17" style="text-align: center;">
                   <h2>Allocated Bookings</h2> 
                </td>
            </tr>
            <tr class="tit-td">
                
                <td>Conf</td>
                
                <td style="width: 3%;">Batch</td>
                
                <td style="width: 7%;">B.No.</td>
                
                <td style="width: 11%;">Date</td>
                
                <td>P/up Time</td>
                
                <td style="width: 15%;">P/up Address</td>
                
                <td style="width: 15%;">Drop off Address</td>
                
                <td style="width: 4%;">Pax</td>
                
                <td style="width: 3%;">B.S</td>
                
                <td style="width: 8%;">Amt</td>
                
                <td style="width: 5%;">Flt Time</td>
                
                <td style="width: 11%;">Client Name</td>
                
                <td style="width: 10%;">Number</td>
                
                <td>Driver</td>
                
                <td style="width: 4%;">Cmts</td>
                
                <td style="width: 11%;">Collect Payment</td>
                
                <td>Last Modified by</td>
                
            </tr>
            <?php
            if($count>0) {
                $k = 0;
                
                $allocate_flag=='line';
                
                    for ($r=0; $r < $count; $r++ ) {
                        
                    // batch order with space
                       if((($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) || (($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2))) {
            
                        if((($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0') || (($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0')) {

                            if($allocate_flag=='line') {
                                
                                $allocate_flag = 'unline';
                            }
                            
                            $alloc_batchval = $row[$r]['batchval'];
                            
                            if($alloc_store_batch!=$alloc_batchval) {
                                
                                if($k!=0) echo '<tr><td colspan="17"></td></tr>';
                             
                                $allocate_flag = 'line';
                                $alloc_store_batch = $row[$r]['batchval'];
                            } 
                            
                           }
                        } 
                        // batch order with space end
                        
                      if(($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) {
                          
                        if(($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0' && $row[$r]['driverval']!='') {
            
                            if($row[$r]['book_confirmed']==1) $dep1_confirm_checked = 'checked=checked';
                            else $dep1_confirm_checked = '';
                            
                            ?>
            
                <tr id="rowcolor_<?php echo $r; ?>">
                        <input type="hidden" name="mflag[]" id="mflag" value="<?php echo $row[$r]['mflag']; ?>" />
                        <input type="hidden" name="multid[]" id="multid" value="<?php echo $row[$r]['multid']; ?>" />
                        <input type="hidden" name="unalldirval[]" id="unalldirval" value="<?php echo $row[$r]['type']; ?>" />
                        <input type="hidden" name="alldirval[]" id="alldirval" value="<?php echo $row[$r]['type']; ?>" />
                        <input type="hidden" name="allmflag[]" id="allmflag" value="<?php echo $row[$r]['mflag']; ?>" />
                        <input type="hidden" name="allmultid[]" id="allmultid" value="<?php echo $row[$r]['multid']; ?>" />
                        
                        <input type="hidden" name="bookdir[]" id="bookdir" value="<?php echo $row[$r]['bookdir']; ?>" />
                    
                        <td>
                            <?php 
                                if($row[$r]['mflag']=='multiple') $dep1_chk_disable = 'disabled=disabled';
                                else { 
                                    $dep1_chk_disable = '';
                                }
                             ?>
                            
                            <input type="checkbox" name="chk_confirm[<?php echo $kl; ?>]" value="1" <?php echo $dep1_confirm_checked; ?> <?php echo $dep1_chk_disable; ?>/>
                            <?php if($row[$r]['mflag']=='single') $kl++; ?>
                        </td>
                        
                        <td>
                            <?php echo $row[$r]['batch']; ?>
                        </td>
                        
                    <td style="word-break: break-all;">
                        <a href="http://www.hillshuttle.com.au/App/booking/edit/<?php echo $row[$r]['auto']; ?>"><?php echo $row[$r]['auto']; ?></a>
                        <?php echo $row[$r]['autohidden']; ?>
                        <?php echo $row[$r]['booktypehidden']; ?>
                        
                        <input type="hidden" name="hbooktype[]" value="<?php echo $row[$r]['hbooktype']; ?>" />
                        <input type="hidden" name="hdate[]" value="<?php echo $row[$r]['hdate']; ?>" />
                        <input type="hidden" name="hestfare[]" value="<?php echo $row[$r]['hestfare']; ?>" />
                        <input type="hidden" name="harrflight[]" value="<?php echo $row[$r]['harrflight']; ?>" />
                        <input type="hidden" name="harrourtime[]" value="<?php echo $row[$r]['harrourtime']; ?>" />
                        <input type="hidden" name="htotal[]" value="<?php echo $row[$r]['htotal']; ?>" />
                        <input type="hidden" name="harrterminal[]" value="<?php echo $row[$r]['harrterminal']; ?>" />
                    </td>
                        
                    <td style="word-break: break-all;"><a href="javascript:;" onclick="highlightRow(<?php echo $r; ?>)"><?php echo $row[$r]['date']; ?></a></td>
                    
                    <td nowrap>
                        <?php if($row[$r]['pickuptime']!=':') echo $row[$r]['pickuptime']; ?> <?php if($row[$r]['pickupmin']!='') echo $row[$r]['pickupmin']; ?>
                        <input type="hidden" name="hpickhrs[]" value="<?php echo $row[$r]['hpickhrs']; ?>" />
                        <input type="hidden" name="hpickmin[]" value="<?php echo $row[$r]['hpickmin']; ?>" />
                        <input type="hidden" name="hpickup[]" value="<?php echo $row[$r]['pickupaddress']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['pickupaddress']; ?> </td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['dropaddress']; //Acorr edit here?> <?php if($row[$r]['hdepflight']!="")echo " - ".$row[$r]['hdepflight']; //ACorr?></td> 
                    
                    <td style="word-break: break-all;"><?php if ($row[$r]['passengers'] == 10) { echo "Charter"; } else { echo $row[$r]['passengers'];} ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['babyseats']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['amount']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['fltime']; ?></td>
                    
                    <td style="word-break: break-all;">
                        <?php if($row[$r]['client']) echo $this->daysheet_model->getClient($row[$r]['client']); ?>
                        <input type="hidden" name="hclient[]" value="<?php echo $row[$r]['client']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;"><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone($row[$r]['client']); ?><br /><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone2($row[$r]['client']); ?></td>
                    
                    <td>
                        <?php echo $row[$r]['driver']; ?>
                        <input type="hidden" name="hdriver[]" value="<?php echo $row[$r]['hdriver']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;">
                        
                        <a href="javascript:;" id="viewcmd_<?php echo $row[$r]['auto']; ?>" onclick="showPopup('<?php echo $row[$r]['auto']; ?>','<?php echo $k; ?>','allocate')" nowrap>View</a>
                    </td>
                    
                   <td style="word-break: break-all;">
                        <?php 
                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office
                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver
                            else $paidstatus = '';
                            
                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';
                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
                                else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr
								else $paymethod = '';
                                
                                if($paidstatus!='' || $paymethod!='') echo $paidstatus.' / '.$paymethod;
                            ?>
                  </td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['updatedby']; ?></td>
                    
                </tr>
            <?php 
               $k++;
               $update_show = 'enable';
                    }  // if condition end
                      } // cancel book end
                      else if(($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2)) {
                          
                        if(($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0' && $row[$r]['driverval']!='') {
            
                            if($row[$r]['book_confirmed']==1) $arr1_confirm_checked = 'checked=checked';
                            else $arr1_confirm_checked = '';
                            
                            ?>
                
                <tr id="rowcolor_<?php echo $r; ?>">
                        <input type="hidden" name="mflag[]" id="mflag" value="<?php echo $row[$r]['mflag']; ?>" />
                        <input type="hidden" name="multid[]" id="multid" value="<?php echo $row[$r]['multid']; ?>" />
                        <input type="hidden" name="unalldirval[]" id="unalldirval" value="<?php echo $row[$r]['type']; ?>" />
                        <input type="hidden" name="alldirval[]" id="alldirval" value="<?php echo $row[$r]['type']; ?>" />
                        <input type="hidden" name="allmflag[]" id="allmflag" value="<?php echo $row[$r]['mflag']; ?>" />
                        <input type="hidden" name="allmultid[]" id="allmultid" value="<?php echo $row[$r]['multid']; ?>" />
                    
                        <input type="hidden" name="bookdir[]" id="bookdir" value="<?php echo $row[$r]['bookdir']; ?>" />
                        
                        <td>
                            <?php 
                                if($row[$r]['mflag']=='multiple') $arr1_chk_disable = 'disabled=disabled';
                                else { 
                                    $arr1_chk_disable = '';
                                }
                             ?>
                            
                            <input type="checkbox" name="chk_confirm[<?php echo $kl; ?>]" value="1" <?php echo $arr1_confirm_checked; ?> <?php echo $arr1_chk_disable; ?>/>
                            <?php if($row[$r]['mflag']=='single') $kl++; ?>
                        </td>
                        
                        <td>
                            <?php echo $row[$r]['batch']; ?>
                        </td>
                        
                    <td style="word-break: break-all;">
                        <a href="http://www.hillshuttle.com.au/App/booking/edit/<?php echo $row[$r]['auto']; ?>"><?php echo $row[$r]['auto']; ?></a>
                        <?php echo $row[$r]['autohidden']; ?>
                        <?php echo $row[$r]['booktypehidden']; ?>
                        
                        <input type="hidden" name="hbooktype[]" value="<?php echo $row[$r]['hbooktype']; ?>" />
                        <input type="hidden" name="hdate[]" value="<?php echo $row[$r]['hdate']; ?>" />
                        <input type="hidden" name="hestfare[]" value="<?php echo $row[$r]['hestfare']; ?>" />
                        <input type="hidden" name="harrflight[]" value="<?php echo $row[$r]['harrflight']; ?>" />
                        <input type="hidden" name="harrourtime[]" value="<?php echo $row[$r]['harrourtime']; ?>" />
                        <input type="hidden" name="htotal[]" value="<?php echo $row[$r]['htotal']; ?>" />
                        <input type="hidden" name="harrterminal[]" value="<?php echo $row[$r]['harrterminal']; ?>" />
                    </td>
                        
                    <td style="word-break: break-all;"><a href="javascript:;" onclick="highlightRow(<?php echo $r; ?>)"><?php echo $row[$r]['date']; ?></a></td>
                    
                    <td nowrap>
                        <?php if($row[$r]['pickuptime']!=':') echo $row[$r]['pickuptime']; ?> <?php if($row[$r]['pickupmin']!='') echo $row[$r]['pickupmin']; ?>
                        <input type="hidden" name="hpickhrs[]" value="<?php echo $row[$r]['hpickhrs']; ?>" />
                        <input type="hidden" name="hpickmin[]" value="<?php echo $row[$r]['hpickmin']; ?>" />
                        <input type="hidden" name="hpickup[]" value="<?php echo $row[$r]['pickupaddress']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['pickupaddress']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['dropaddress']; ?></td>
                    
                    <td style="word-break: break-all;"><?php if ($row[$r]['passengers'] == 10) { echo "Charter"; } else { echo $row[$r]['passengers'];} ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['babyseats']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['amount']; ?></td>
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['fltime']; ?></td>
                    
                    <td style="word-break: break-all;">
                        <?php if($row[$r]['client']) echo $this->daysheet_model->getClient($row[$r]['client']); ?>
                        <input type="hidden" name="hclient[]" value="<?php echo $row[$r]['client']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;"><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone($row[$r]['client']); ?><br /><?php if($row[$r]['client']) echo $this->daysheet_model->getClientphone2($row[$r]['client']); ?></td>
                    
                    <td>
                        <?php echo $row[$r]['driver']; ?>
                        <input type="hidden" name="hdriver[]" value="<?php echo $row[$r]['hdriver']; ?>" />
                    </td>
                    
                    <td style="word-break: break-all;">
                        
                        <a href="javascript:;" id="viewcmd_<?php echo $row[$r]['auto']; ?>" onclick="showPopup('<?php echo $row[$r]['auto']; ?>','<?php echo $k; ?>','allocate')" nowrap>View</a>
                    </td>
                    
                    <td style="word-break: break-all;">
                        <?php 
                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office
                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver
                            else $paidstatus = '';
                            
                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';
                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
                                else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr
								else $paymethod = '';
                                
                                if($paidstatus!='' || $paymethod!='') echo $paidstatus.' / '.$paymethod;
                            ?>
                    </td> 
                    
                    <td style="word-break: break-all;"><?php echo $row[$r]['updatedby']; ?></td>
                    
                </tr>
            <?php 
               $k++;
               $update_show = 'enable';
                    }  // if condition end
                    
                      } // else if cancel book end  
                      
            } // for loop end
            
                 } // empty cond end
                 
                  ?>
                <?php
                
                if(empty($k)) {
            ?>
                
                <tr>
                    
                    <td style="text-align: center;" colspan="17">No records found</td>
                 
                </tr>
            <?php
            
                }
                ?>
                
        </table>
                <br/>
                <?php if($update_show=='enable') { ?>
                
                        <div style="float: left;">
                            <input type="button" name="savbtn" id="savebtn" value="Update" class="bgbtn" onclick="return modeType()"/>
                        </div>

                        <div style="float: right; position: relative; left: 313px;">
                            <span class="excel-link"></span> <!-- for loading image -->
                            <input type="button" name="printbtn" id="printbtn" value="Print" class="bgbtn" onclick="return exportExcel()"/>
                        </div>
            
        <script>
                    $("#update-top").css('display','inline');
                    $("#print-top").css('display','inline');
                </script>
                <?php }  else { ?>
                
        <script>
                    $("#update-top").css('display','none');
                    $("#print-top").css('display','none');
                </script>
                
                <?php } ?>
                

            
        </form>
        <!-- </div> -->
    </div>
    <div style="clear: both;"></div>
    <!-- Form content end -->
</div>

         </div>
            <div style="clear: both;"></div>
            
            <!-- pop-up content -->
            <div id="element_to_pop_up" style="display: none; border: 1px solid green; background-color: white;">
                            <span class="button bClose">
                                <span>X</span>
                            </span>
                                
                                    <table width="100%" align="center">
                                        <tr>
                                            <td>
                                                <input type="hidden" name="cmdauto" id="cmdauto"/>
                                                <input type="hidden" name="cmdrow" id="cmdrow"/>
                                                <input type="hidden" name="cmdtype" id="cmdtype"/>
                                                <textarea name="comments" id="comments" rows="5" cols="50"></textarea>
                                                <div id="comment-html"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"><input type="button" name="cmdsave" id="cmdsave" value="Save" class="bgbtn" />
                                            <input type="button" name="cmdcancel" id="cmdcancel" value="Cancel" class="bgbtn bClose" /></td>
                                        </tr>
                                    </table>
            </div>  
            
            <div id="mail_confirm_pop_up">
                            <span class="button bClose">
                                <span>X</span>
                            </span>
                    <div id="bookid_content"></div> 
                    
            </div>            
            
            <!-- pop-up content end -->
<script>

   $('#fdate').datepick();
    
    $('#todate').datepick();

    $(".batchtext").numeric();
// pop-up start
function showPopup(id,rid,val) {
    
    $('#cmdauto').val(id);
    $('#cmdrow').val(rid);
    $('#cmdtype').val(val);
    
        var bkdir = document.getElementsByName('bookdir[]');
        var bkdirval = bkdir[rid].value; 
    
    if(val=='allocate') {
        var dir1 = document.getElementsByName('alldirval[]');
        var dirval1 = dir1[rid].value; 

        var cmflag1 = document.getElementsByName('allmflag[]');
        var flagval1 = cmflag1[rid].value; 

        var mulid1 = document.getElementsByName('allmultid[]');
        var multid1 = mulid1[rid].value; 
    }
    else {
        var dir1 = document.getElementsByName('unalldirval[]');
        var dirval1 = dir1[rid].value; 

        var cmflag1 = document.getElementsByName('mflag[]');
        var flagval1 = cmflag1[rid].value; 

        var mulid1 = document.getElementsByName('multid[]');
        var multid1 = mulid1[rid].value; 
    }
    
                $(document).ready(function() {
                        $.ajax({
                           url: "<?php echo base_url(); ?>common/dsviewcomment",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{aid: ""+id+"",dir: ""+dirval1+"",flag: ""+flagval1+"",mid: ""+multid1+""},
                           success: function(data){
                              // alert(data);
                              var splval = data.split('~~');
                              var cmval = splval[1];
                              var cmhtml = splval[0];
                              //alert(cmhtml);
                               if(data) {
                                   $('#comments').val(cmval);
                                   
                                   if(bkdirval == 'both') {
                                       
                                    if(cmhtml) $('#comment-html').html('<span style="width: 405px; height: 100px; overflow: auto;">'+cmhtml+'</span>');
                                    else $('#comment-html').html('');
                                    
                                   }
                                   else {
                                       $('#comment-html').html('');
                                   } 
                               }
                               else { 
                                   $('#comments').val('');
                                   $('#comment-html').html('');
                               }
                           }
                        });
                });

                ;(function($) {
                         // DOM Ready
                        $(function() {
                                    // Triggering bPopup when click event is fired
                                    $('#element_to_pop_up').bPopup();

                        });

                    })(jQuery);
        }
       
$('#cmdsave').click(function() {
    var cmtdata = $('#comments').val();
    var cmtauto = $('#cmdauto').val();
    var cmtrow = $('#cmdrow').val();
    var cmttype = $('#cmdtype').val();
    
    if(cmttype=='allocate') {
        var dir = document.getElementsByName('alldirval[]');
        var dirval = dir[cmtrow].value; 

        var cmflag = document.getElementsByName('allmflag[]');
        var flagval = cmflag[cmtrow].value; 

        var mulid = document.getElementsByName('allmultid[]');
        var multid = mulid[cmtrow].value; 
    }
    else {
        var dir = document.getElementsByName('unalldirval[]');
        var dirval = dir[cmtrow].value; 

        var cmflag = document.getElementsByName('mflag[]');
        var flagval = cmflag[cmtrow].value; 

        var mulid = document.getElementsByName('multid[]');
        var multid = mulid[cmtrow].value; 
    }

                $(document).ready(function() {
                        $.ajax({
                           url: "<?php echo base_url(); ?>common/dssavecomment",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{cmd: ""+cmtdata+"",cmauto: ""+cmtauto+"",dir: ""+dirval+"",cmtflag: ""+flagval+"",mid: ""+multid+""},
                           success: function(data){
                             //  alert(data);
                               $('.bClose').click();
                           }
                        });
                });

});

        function gridSave(id,type) {
            
            var depdir = '';
            var arrdir = '';
            var depdri = '';
            var arrdri = '';
            
            depdir = $('#depdirval_'+id).val();
            arrdir = $('#arrdirval_'+id).val();
            
            depdri = $('#depdriver_val_'+id).val();
            arrdri = $('#arrdriver_val_'+id).val();
            
            var sdate = $('#fdate').val();
            
			$.post("<?php echo base_url(); ?>common/daysheet", {depdir: depdir,arrdir: arrdir,depdri: depdri,arrdri: arrdri,uid: id,sdate: sdate,type: type}, function(data){
                          //  alert(data);
                            $('#notify-msg').css('display','inline')
                            
                            setTimeout("$('#notify-msg').fadeOut();", 1200);
    			});
            
        }
        
        function adddailycomment() {
			var val = $('#fdate').val();
			url = "../../db.php?currentdate="+val;
			newwindow=window.open(url,'name','height=250,width=385');
			//var left = (screen.width/2)-(w/2);
 			//var top = (screen.height/2)-(h/2);
			//var w = (385);
			//var h = (250);
			//var title = ("Daily Comments");
  			//return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

			if (window.focus) {newwindow.focus()}
				return false;
			
			
			
		}
		
		function validateSubmit() {
            var val = $('#fdate').val();
            var toval = $('#todate').val();
            $('#mode').val('search');
            
            if(val=='') {
                alert('Enter from date');
                $('#fdate').focus();
                return false;
            }
            else {
                $('form').attr('action','<?php echo site_url(); ?>daysheet/search?page=1');
            }
        }
        
        function modeType() {

            $('#mode').val('save');
        
         var bid = $('#book-id').val();
         if(bid) {
             var conmail = confirm('Do you want to send email confirmation?');
             
             if(conmail==true) {
         
                var bookids = $('#book-id').val();
                $('#mail_confirm_log').val('yes');
                
                                $.post("<?php echo base_url(); ?>common/daysheetpopup", {ids: bookids}, function(data){
                                  //  alert(data);
                                  $('#bookid_content').html(data);

                                });

                        ;(function($) {
                                 // DOM Ready
                                $(function() {
                                            // Triggering bPopup when click event is fired
                                            $('#mail_confirm_pop_up').bPopup();

                                });

                            })(jQuery);
             }
             else {
                 
             $('#book-id').val('');
             $('#updated_bookid').val('');
             $('#mail_confirm_log').val('no');
                 
                $('#frmdaysheet').submit();
                return true; 
             
             }
         }
         else {
             
             $('#book-id').val('');
             $('#updated_bookid').val('');
             $('#mail_confirm_log').val('no');
             
            $('#frmdaysheet').submit();
            return true; 
         
         }
                        
        
        }
        
        function getDateval() {
            
        }
        
        function exportExcel() {
           
                    $('.excel-link').html('<img src="<?php echo base_url(); ?>images/loader.gif" />');
			$.post("<?php echo base_url(); ?>daysheet_excel.php", {dataval: <?php echo json_encode($row); ?>}, function(data){
                           // alert(data);
                         if(data) {
                             $('.excel-link').html('');
                            window.location.href = "<?php echo base_url(); ?>excel_open.php?type=excel&filename="+data+"&mode=daysheet";
                         }
                        });
            
        }
        
        function updatePopup(id,flag) {
        
            if(id) {
                var bid = $('#book-id').val();
                var comid = id;
                if(bid) var comval = bid+','+comid;
                else var comval = comid;
                $('#book-id').val(comval);
            }
        }
        
        function mailConfirm() {
            
            var chkcount = $(".bookid_list:checked").length;
            if(chkcount==0) {
                alert('Please select atleast one')
                return false;
            }
            else {
            var bkval = [];
            var k = 0;
            $('.bookid_list:checked').each(function(){ 
                bkval[k] = this.value;
                k++;
                }); 
                
                $('#updated_bookid').val(bkval);
            
                $('#frmdaysheet').submit();
                return true; 
            }
        }
        
        function chkSelectall() {

        $('.bookid_list:checkbox').each(function(){ 
                if(this.checked) { 
                    this.checked = false; 
                } else { 
                    this.checked = true; 
                } 
            }); 

        }
        
        function popupClose() {
            $('.bClose').click();
                $('#frmdaysheet').submit();
                return true; 
            
        }
        
        function highlightRow(id) {
        //    alert(id);
            
            $('tr[id^=rowcolor_]').css('background', 'white');

            $("#rowcolor_"+id).css('background','#d5ddca');
            
        }
		 function checkComment() {
            var val = $('#fdate').val();
                        
            if(val=='') {
                alert('Enter a comment');
                $('#dailynews').focus();
                return false;
            } else {
				$('#dailynews').val(val);
				return false;
			}
        }
		
</script>            