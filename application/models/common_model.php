<?php

class Common_model extends CI_Model

{

	function __construct()

	{

		parent::__construct();



	}

        

	function mailValidate($val,$ccid)

	{

            $this->tbl_name = "drivers";

            

            $this->db->select('email');

            

            if($ccid!='') {

                $this->db->where('id !=',$ccid);

            }

            

            $where = array('email'=>$val);

            

            $this->db->where($where);

            

           // $query = $this->db->get($this->tbl_name);

            

            //return $query->result();

            return $this->db->count_all_results($this->tbl_name);

	}

        

	function clientAutosuggest($val)

	{

            $this->tbl_name = "clients";

            

            $this->db->select('id,first_name,last_name,suburb');

            

          //  $where = array('first_name'=>$val);

            

          //  $this->db->like($where);

            

            $query = $this->db->get($this->tbl_name);

            

        /*    $clidata = '';

                 foreach ($query->result() as $list) {

                     $client_name = $list->first_name.' '.$list->last_name.' ('.$list->suburb.')';

                      $clidata.= ",".$client_name;

                 }

                 echo $clidata; */



                $clidata = '';

                $cid = '';

                 foreach ($query->result() as $list) {

                     $client_name = $list->first_name.' '.$list->last_name.' ('.$list->suburb.')';

                      $clidata.= str_replace("'","",$client_name)."~~";

                      

                      $cid.= $list->id."~~";

                 }

               //  $clidata = substr($clidata,0,-1);

              //   $cid = substr($cid,0,-1);

                 

                 echo '{';

                 echo "name:'$clidata',to:'$cid'";            

                 echo '}';

            

            

	}

        

	function clientAutosuggestgrid($val,$autoid)

	{

            $this->tbl_name = "clients";

            

            $this->db->select('id,first_name,last_name');

            

            $where = array('first_name'=>$val);

            

            $this->db->like($where);

            

            $query = $this->db->get($this->tbl_name);

            

             foreach ($query->result() as $list) {

                 $client_name = $list->first_name.' '.$list->last_name;

                 echo '<ul>';

                    echo '<li onClick="fillGrid(\''.$list->id.'\',\''.$client_name.'\',\''.$autoid.'\');">'.$client_name.'</li>';

                 echo '</ul>'; 

             }

	}



	function driverAutosuggestgrid($val,$autoid)

	{

            $this->tbl_name = "drivers";

            

            $this->db->select('id,first_name,last_name');

            

            $where = array('first_name'=>$val);

            

            $this->db->like($where);

            

            $query = $this->db->get($this->tbl_name);

            

             foreach ($query->result() as $list) {

                 $driver_name = $list->first_name.' '.$list->last_name;

                 echo '<ul>';

                    echo '<li onClick="filldriverGrid(\''.$list->id.'\',\''.$driver_name.'\',\''.$autoid.'\');">'.$driver_name.'</li>';

                 echo '</ul>'; 

             }

	}

        

	function clientDetails($val)

	{

            $this->tbl_name = "clients";

            

            $this->db->select('address1,address2,phone,mobile,suburb');

            

            $where = array('id'=>$val);

            

            $this->db->where($where);

            

            $query = $this->db->get($this->tbl_name);

            

            $row = $query->result_array();

            $address1 = addslashes($row[0]['address1']);

            $address2 = addslashes($row[0]['address2']);

            $suburb = ucfirst(addslashes($row[0]['suburb']));

            $phone = addslashes($row[0]['phone']);

            $mobile = addslashes($row[0]['mobile']);

            

            echo '{';

            echo "address1:'$address1',";

            echo "address2:'$address2',";

            echo "suburb:'$suburb',";

            echo "phone:'$phone',";

            echo "mobile:'$mobile'";

            echo '}';

            

	}

        

	function driverAutosuggest($val)

	{

            $this->tbl_name = "drivers";

            

            $this->db->select('id,first_name,last_name');

            

            $where = array('first_name'=>$val);

            

            $this->db->like($where);

            

            $query = $this->db->get($this->tbl_name);

            

             foreach ($query->result() as $list) {

                 $driver_name = $list->first_name.' '.$list->last_name;

                 echo '<ul>';

                    echo '<li onClick="fillDriver(\''.$list->id.'\',\''.$driver_name.'\');">'.$driver_name.'</li>';

                 echo '</ul>'; 

             }

	}

        

        function daysheetSave($depdir,$arrdir,$depdri,$arrdri,$uid,$sdate,$type) {

            

            $this->tbl_name = "booking";

            

            if($depdir=='departure' && $type=='dep') $data = array('dep_driver'=>$depdri);

            if($arrdir=='arrival' && $type=='arr') $data = array('arr_driver'=>$arrdri);

            

            $this->db->where('id', $uid);

            

            $this->db->update($this->tbl_name,$data);

            

        }

        

        function showpagenav($page, $pagecount, $scriptname)

        {



        ?>



        <table border="0" cellspacing="4" cellpadding="4" align="right" style="overflow: auto;">



        <tr style="border: 0;">



         <?php if ($page > 1) { ?>



        <td style="border: 0;"><a href="<?php echo $scriptname; ?>?page=<?php echo $page - 1 ?>"><span class="nav_links">&laquo;</span></a>&nbsp;</td>



        <?php } ?>



        <?php



          $pagerange = 20;







          if ($pagecount > 1) {







          if ($pagecount % $pagerange != 0) {



            $rangecount = intval($pagecount / $pagerange) + 1;



          }



          else {



            $rangecount = intval($pagecount / $pagerange);



          }



          for ($i = 1; $i < $rangecount + 1; $i++) {



            $startpage = (($i - 1) * $pagerange) + 1;



            $count = min($i * $pagerange, $pagecount);







            if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {



              for ($j = $startpage; $j < $count + 1; $j++) {



                if ($j == $page) {



        ?>



        <td style="border: 0;"><strong><span class="hlight_current" ><?php echo $j ?></span></strong></td>



        <?php } else { ?>



        <td style="border: 0;"><a href="<?php echo $scriptname; ?>?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>



        <?php } } } else { ?>



        <td style="border: 0;"><a href="<?php echo $scriptname; ?>?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>



        <?php } } } ?>



        <?php if ($page < $pagecount) { ?>



        <td style="border: 0;">&nbsp;<a href="<?php echo $scriptname; ?>?page=<?php echo $page + 1 ?>" ><span class="nav_links">&raquo;</span></a>&nbsp;</td>



        <?php } ?>



        </tr>



        </table>



        <?php

        }

    // pagination end

    

	function getClidel($val)

	{

            $this->tbl_name = "booking";

            

            $this->db->select('id');

            

            $where = array('client'=>$val);

            

            $this->db->where($where);

            

            return $this->db->count_all_results($this->tbl_name);

	}

        

        // popup pickup save

	function savePickup()

	{

                            $decimal_pointer = $this->config->item('decimal_point');

                            $dec_point = $decimal_pointer['point'];

                            $prg = $decimal_pointer['prr'];

                            $dollar = $decimal_pointer['dollar'];

            

            $mauto = $_POST['mauto'];

            

            $bid = $_POST['bid'];

            if($bid) $next_id = $bid;

            else $next_id = $this->session->userdata('dynamicbookid');

                

            if($next_id!='' && $next_id!=0) {

                

            $clival = $_POST['client'];

            $subval = $_POST['suburb'];

            $addval1 = $_POST['add1'];

            $addval2 = $_POST['add2'];

            $mobval = $_POST['mobile'];

            $phoneval = $_POST['phone'];

            $commentval = $_POST['comment'];

            $pdirection = $_POST['pdir'];

            $pdestination = $_POST['dest'];

            $pax = $_POST['pax'];

            $book_type = $_POST['btype'];

            $pop_est = $_POST['pest'];

            if($pop_est=='$') $pop_est = 0;

            else $pop_est = $dollar.number_format(preg_replace($prg, '', $pop_est), $dec_point, '.', '');

            

            $bookval = $next_id;

            

            if(($pdirection=='dep' && $pdestination=='pickup') || ($pdirection=='arr' && $pdestination=='drop')) {

                

                $data = array('book_id'=>$bookval,'client'=>$clival,'suburb'=>$subval,'address1'=>$addval1,'address2'=>$addval2,'phone'=>$phoneval,'mobile'=>$mobval,'passengers'=>$pax,'comment'=>$commentval,'est'=>$pop_est,'direction'=>$pdirection,'type'=>$book_type,'destination'=>$pdestination);

            }

            else if(($pdirection=='dep' && $pdestination=='drop') || ($pdirection=='arr' && $pdestination=='pickup')) {

                

                $data = array('book_id'=>$bookval,'client'=>$clival,'passengers'=>$pax,'comment'=>$commentval,'drop_suburb'=>$subval,'drop_address1'=>$addval1,'drop_address2'=>$addval2,'drop_phone'=>$phoneval,'drop_mobile'=>$mobval,'drop_passengers'=>$pax,'drop_comment'=>$commentval,'drop_est'=>$pop_est,'direction'=>$pdirection,'type'=>$book_type,'destination'=>$pdestination);

            }

            

            $this->tbl_name = "multipickup_assoc";

            

            if($mauto) {

                $this->db->where('id', $mauto);



                $this->db->update($this->tbl_name,$data);

                

            }

            

            else $this->db->insert($this->tbl_name,$data);

            

            }

            

            return $next_id;

	}

        

	function showPickup($id,$dir,$type,$destination)

	{

            if($id) $bid = $id;

            else $bid = $this->session->userdata('dynamicbookid');

            

            if($bid!='' && $bid!=0) {

                

            $this->tbl_name = "multipickup_assoc";

            

            $this->db->select('*');

            

            $this->db->where('book_id',$bid);

            

            $this->db->where('direction',$dir);

            

            $this->db->where('type',$type);

            

            $this->db->where('destination',$destination);

            

            $query = $this->db->get($this->tbl_name);

            

            return $query->result_array();

            }

	}



	function delPickup($id,$dir,$type,$destination)

	{

            $this->tbl_name = "multipickup_assoc";

            

            $this->db->where('id', $id);

            

            $this->db->where('direction', $dir);

            

            $this->db->where('type',$type);

            

            $this->db->where('destination',$destination);

            

            $this->db->delete($this->tbl_name);

	}



	function popupClient($val)

	{

            $this->tbl_name = "clients";

            

            $this->db->select('id,first_name,last_name');

            

            $where = array('first_name'=>$val);

            

            $this->db->like($where);

            

            $query = $this->db->get($this->tbl_name);

            

                 foreach ($query->result() as $list) {

                     $client_name = $list->first_name.' '.$list->last_name;

                     echo '<ul>';

                        echo '<li onClick="popfill(\''.$list->id.'\',\''.$client_name.'\');">'.$client_name.'</li>';

                     echo '</ul>'; 

                 }

	}

        

	function getClientname($val)

	{

            $this->tbl_name = "clients";

            

            $this->db->select('first_name,last_name,suburb');

            

            $where = array('id'=>$val);

            

            $this->db->where($where);

            

            $query = $this->db->get($this->tbl_name);

            

            $row = $query->result_array();

            

            return $row[0]['first_name'].' '.$row[0]['last_name'].' ('.$row[0]['suburb'].')';

	}



	function clientValidate($fval,$lval,$ccid,$add,$mail,$suburb)

	{

            

            $this->tbl_name = "clients";

            

            $this->db->select('first_name,last_name');

            

            //$where = array('first_name'=>$fval,'last_name'=>$lval);

            if($ccid!='') {

                $this->db->where('id !=',$ccid);

            }

            

            $this->db->where('first_name',$fval);

            

            $this->db->where('last_name',$lval);

            

            $this->db->like('address1',$add);

            

            $this->db->where('email',$mail);

            

            $this->db->where('suburb',$suburb);

            

            $query = $this->db->get($this->tbl_name);

            

            $row = $query->result_array();

            

            return count($row);

	}



	function userValidate($fval,$lval,$ccid)

	{

            

            $this->tbl_name = "users";

            

            $this->db->select('first_name,last_name');

            

            //$where = array('first_name'=>$fval,'last_name'=>$lval);

            if($ccid!='') {

                $this->db->where('id !=',$ccid);

            }

            

            $this->db->where('first_name',$fval);

            

            $this->db->where('last_name',$lval);

            

            $query = $this->db->get($this->tbl_name);

            

            $row = $query->result_array();

            

            return count($row);

	}



	function driverValidate($fval,$lval,$ccid)

	{

            

            $this->tbl_name = "drivers";

            

            $this->db->select('first_name,last_name');

            

            //$where = array('first_name'=>$fval,'last_name'=>$lval);

            if($ccid!='') {

                $this->db->where('id !=',$ccid);

            }

            

            $this->db->where('first_name',$fval);

            

            $this->db->where('last_name',$lval);

            

            $query = $this->db->get($this->tbl_name);

            

            $row = $query->result_array();

            

            return count($row);

	}



	function getComments($aid,$dir,$flag,$mid)

	{

                            $decimal_pointer = $this->config->item('decimal_point');

                            $dec_point = $decimal_pointer['point'];

                            $prg = $decimal_pointer['prr'];

                            $dollar = $decimal_pointer['dollar'];

            

            if($dir=='Departure') {

                $this->db->select('*');

            }

            else {

                $this->db->select('*');

            }

            

            if($flag!='multiple') {

                $this->tbl_name = "booking";

                $this->db->where('id',$aid);

            }

            else {

                $this->tbl_name = "multipickup_booking";

                $this->db->where('id',$mid);

                

            }                



                $query = $this->db->get($this->tbl_name);



                $row = $query->result_array();



                

                if($dir=='Departure') {



                   $depdateval = strtotime($row[0]['dep_date']);

                   $arrdateval = strtotime($row[0]['arr_date']);

                   $arrcancel = $row[0]['cancel_book'];

                   $dep_pickup = $row[0]['dep_pickuptime'];

                   $arr_pickup = $row[0]['arr_pickuptime'];

                   $book_type = $row[0]['type'];

                   

                   $depflag = false;

                    if(($depdateval<$arrdateval) && $arrcancel!=2) {

                        $depflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $arrcancel!=2 && ($dep_pickup<$arr_pickup)) {

                        $depflag = true;

                    }

                    

                   if($depflag==true) {

                    $dep_rows = '<div><b>Arrival details</b>

                                    <table>

                                        <tr>

                                            <td>Date: </td>

                                            <td>'.date("d/m/Y",strtotime($row[0]['arr_date'])).'</td>

                                        </tr>';

                    if($book_type=='AP') {

                                        $dep_rows .= '<tr>

                                            <td>Flight: </td>

                                            <td>'.$row[0]['arr_flight'].'</td>

                                        </tr>

                                        <tr>

                                            <td>Arrival Flight Time: </td>

                                            <td>'.$row[0]['arr_ourtime'].'</td>

                                        </tr>';

                    }

                                        $dep_rows .= '<tr>

                                            <td>Est fare: </td>

                                            <td>'.$dollar.number_format(preg_replace($prg, '', $row[0]['arr_estfare']), $dec_point, '.', '').'</td>

                                        </tr>

                                    </table>

                        

                                </div>';

                   }

                   else $dep_rows = '';

                    

                    $dep_rows .= '~~'.$row[0]['dep_comments'];

                    

                    return $dep_rows;

                }

                else {

                    

                   $depdateval = strtotime($row[0]['dep_date']);

                   $arrdateval = strtotime($row[0]['arr_date']);

                   $depcancel = $row[0]['cancel_book'];

                   $dep_pickup = $row[0]['dep_pickuptime'];

                   $arr_pickup = $row[0]['arr_pickuptime'];

                   $book_type = $row[0]['type'];

                    

                   $arrflag = false;

                    if(($depdateval>$arrdateval) && $depcancel!=1) {

                        $arrflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $depcancel!=1 && ($dep_pickup>$arr_pickup)) {

                        $arrflag = true;

                    }

                   

                   if($arrflag==true) {

                    

                    $arr_rows = '<div><b>Departure details</b>

                                    <table>

                                        <tr>

                                            <td>Date: </td>

                                            <td>'.date("d/m/Y",strtotime($row[0]['dep_date'])).'</td>

                                        </tr>';

                    if($book_type=='AP') {

                                        $arr_rows .= '<tr>

                                            <td>Flight: </td>

                                            <td>'.$row[0]['dep_flight'].'</td>

                                        </tr>

                                        <tr>

                                            <td>Departure Flight Time: </td>

                                            <td>'.$row[0]['dep_ourtime'].'</td>

                                        </tr>';

                    }

                                        $arr_rows .= '<tr>

                                            <td>Est fare: </td>

                                            <td>'.$dollar.number_format(preg_replace($prg, '', $row[0]['dep_estfare']), $dec_point, '.', '').'</td>

                                        </tr>

                                    </table>

                        

                                </div>';

                   }

                   else $arr_rows = '';

                    

                    $arr_rows .= '~~'.$row[0]['arr_comments'];

                    return $arr_rows;

                }

            

	}

        

	function savedsComments($cmd,$aid,$dir,$flag,$mid)

	{

            if($dir=='Departure') $data = array('dep_comments'=>$cmd);

            else $data = array('arr_comments'=>$cmd);

            

            if($flag!='multiple') {

                $this->tbl_name = "booking";

                $this->db->where('id',$aid);

            }

            else {

                $this->tbl_name = "multipickup_booking";

                $this->db->where('id',$mid);

                

            }

                    

            $data_row = $this->db->update($this->tbl_name,$data);

            

            return $data_row;

	}

        

	function clientLogid($uval,$csub)

	{

            $exval = explode(" ",$uval);

            $fval = $exval[0];

            $lval = $exval[1];

            

            $this->tbl_name = "clients";

            

            $this->db->select('id');

            

            $this->db->where('first_name',$fval);

            

            $this->db->where('last_name',$lval);

            

            $this->db->where('suburb',$csub);

            

            $query = $this->db->get($this->tbl_name);

            

            $row = $query->result_array();

            

            return $row[0]['id'];

	}

        

	function cancelBook($bookid,$canval,$dir,$hcval,$cmail,$mode)

	{

                            $decimal_pointer = $this->config->item('decimal_point');

                            $dec_point = $decimal_pointer['point'];

                            $prg = $decimal_pointer['prr'];

                            $dollar = $decimal_pointer['dollar'];

            

                $this->tbl_name = "booking";

                $this->db->where('id',$bookid);

                

                $cancelid = 0;

                

                if($hcval==0) {

                    if($dir=='departure') {

                        $data = array('cancel_book'=>1);

                        $cancelid = 1;

                    }

                    

                    else if($dir=='arrival') {

                        $data = array('cancel_book'=>2);

                        $cancelid = 2;

                    }

                    

                    else {

                        $data = array('cancel_book'=>$canval);

                        $cancelid = $canval;

                    }

                }

                else {

                    

                    $data = array('cancel_book'=>3);

                    $cancelid = 3;

                }

                

                $data_row = $this->db->update($this->tbl_name,$data);

                

            // cancel mail start

            if($cmail=='1') {

                

                // get booking details

                $this->tbl_name = "booking";



                $this->db->select('*');



                $this->db->where('id',$bookid);



                $query = $this->db->get($this->tbl_name);



                $book_row = $query->result_array();

                

                $direction = $book_row[0]['direction'];

                $bktype = $book_row[0]['type'];

                $client = $book_row[0]['client'];

                

                // departure details

                $depaddress1 = $book_row[0]['dep_address1'];

                $depaddress2 = $book_row[0]['dep_address2'];

                $depsuburb = $book_row[0]['dep_suburb'];

                $depphone = $book_row[0]['dep_phone'];

                $depmobile = $book_row[0]['dep_mobile'];

                

                $depdropaddress1 = $book_row[0]['dep_drop_address1'];

                $depdropaddress2 = $book_row[0]['dep_drop_address2'];

                $depdropsuburb = $book_row[0]['dep_drop_suburb'];

                $depdropphone = $book_row[0]['dep_drop_phone'];

                $depdropmobile = $book_row[0]['dep_drop_mobile'];

                

                $depflight = $book_row[0]['dep_flight'];

                $depdate = $book_row[0]['dep_date'];

                $depairline = $book_row[0]['dep_airline'];

                $deporigin = $book_row[0]['dep_origin'];

                $depterminal = $book_row[0]['dep_terminal'];

                $dtime = $book_row[0]['dep_time'];

                $depourtime = $book_row[0]['dep_ourtime'];

                $depyourtime = $book_row[0]['dep_yourtime'];

                $deppickuptime = $book_row[0]['dep_pickuptime'];

                $deppassengers = $book_row[0]['dep_passengers'];

                $depbabyseats = $book_row[0]['dep_babyseats'];

                $depestfare = $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', '');

                $depcomments = $book_row[0]['dep_comments'];



                // arrival details

                $arraddress1 = $book_row[0]['arr_address1'];

                $arraddress2 = $book_row[0]['arr_address2'];

                $arrsuburb = $book_row[0]['arr_suburb'];

                $arrphone = $book_row[0]['arr_phone'];

                $arrmobile = $book_row[0]['arr_mobile'];

                

                $arrdropaddress1 = $book_row[0]['arr_drop_address1'];

                $arrdropaddress2 = $book_row[0]['arr_drop_address2'];

                $arrdropsuburb = $book_row[0]['arr_drop_suburb'];

                $arrdropphone = $book_row[0]['arr_drop_phone'];

                $arrdropmobile = $book_row[0]['arr_drop_mobile'];

                

                $arrflight = $book_row[0]['arr_flight'];

                $arrdate = $book_row[0]['arr_date'];

                $arrairline = $book_row[0]['arr_airline'];

                $arrorigin = $book_row[0]['arr_origin'];

                $arrterminal = $book_row[0]['arr_terminal'];

                $atime = $book_row[0]['arr_time'];

                $arrourtime = $book_row[0]['arr_ourtime'];

                $arryourtime = $book_row[0]['arr_yourtime'];

                $arrpickuptime = $book_row[0]['arr_pickuptime'];

                $arrpassengers = $book_row[0]['arr_passengers'];

                $arrbabyseats = $book_row[0]['arr_babyseats'];

                $arrestfare = $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', '');

                $arrcomments = $book_row[0]['arr_comments'];

              //  $total = $book_row[0]['total'];

                

                $texp_arrest = explode('$',$arrestfare);

                $texp_depest = explode('$',$depestfare);

                $ttotal = $texp_depest[1]+$texp_arrest[1];

                $total = '$'.$ttotal;

                

                

                $mquery = '';

                $transfer = '';

                $mail_row = '';

                

                if($mode=='booking') {

                    

                if($bktype=="AP" && $direction=='both' && $cancelid==3) $mail_row = $this->getMailtemp($eid=32);

                

                else if($bktype=="AP" && $direction=='both' && $cancelid!=3) $mail_row = $this->getMailtemp($eid=33);

                

                else if($bktype=="AP" && ($direction=='departure' || $direction=='arrival') && $cancelid!=3) $mail_row = $this->getMailtemp($eid=33);

                

                else if($bktype=="Other" && $direction=='both' && $cancelid==3) $mail_row = $this->getMailtemp($eid=37);

                

                else if($bktype=="Other" && $direction=='both' && $cancelid!=3) $mail_row = $this->getMailtemp($eid=38);

                

                else if($bktype=="Other" && ($direction=='departure' || $direction=='arrival') && $cancelid!=3) $mail_row = $this->getMailtemp($eid=38);

                

                else if($bktype!="AP" && $direction=='both' && $cancelid==3) $mail_row = $this->getMailtemp($eid=34);

                

                else if($bktype!="AP" && $direction=='both' && $cancelid!=3) $mail_row = $this->getMailtemp($eid=35);

                

                else if($bktype!="AP" && ($direction=='departure' || $direction=='arrival') && $cancelid!=3) $mail_row = $this->getMailtemp($eid=35);

                

                }

                else {

                    

                if($bktype=="AP" && $direction=='both' && $cancelid==3) $mail_row = $this->getMailtemp($eid=32);

                

                else if($bktype=="AP" && $direction=='both' && $cancelid!=3) $mail_row = $this->getMailtemp($eid=33);

                

                else if($bktype=="AP" && ($direction=='departure' || $direction=='arrival') && $cancelid!=3) $mail_row = $this->getMailtemp($eid=33);

                

                else if($bktype!="AP" && $direction=='both' && $cancelid==3) $mail_row = $this->getMailtemp($eid=34);

                

                else if($bktype!="AP" && $direction=='both' && $cancelid!=3) $mail_row = $this->getMailtemp($eid=35);

                

                else if($bktype!="AP" && ($direction=='departure' || $direction=='arrival') && $cancelid!=3) $mail_row = $this->getMailtemp($eid=35);

                    

                }

                

                    $subject = str_replace('{booking referance No}',$bookid,$mail_row[0]['subject']);

                    

                    $tomail = $this->getClientmail($client);

                    

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

                    

                    $message = $mail_row[0]['content'];

                    

                    $message = str_replace('from {username}','',$message);

                    $message = str_replace('The below','Your below',$message);

                    $message = str_replace('{transfer}',$transfer,$message);

                    $message = str_replace('{bookid}',$bookid,$message);

                    

                    // departure

                    if($cancelid==1 || $cancelid==3) {

                        

                        $message = str_replace('{suburb}',$depsuburb,$message);

                        $message = str_replace('{address1}',$depaddress1,$message);

                        $message = str_replace('{address2}',$depaddress2,$message);

                        $message = str_replace('{mobile}',$depmobile,$message);

                        $message = str_replace('{phone}',$depphone,$message);

                        $message = str_replace('{flight}',$depflight,$message);

                        $message = str_replace('{airline}',$depairline,$message);

                        $message = str_replace('{origin}',$deporigin,$message);

                        $message = str_replace('{terminal}',$depterminal,$message);

                        $message = str_replace('{depdate}',$depdate,$message);

                        $message = str_replace('{fltime}',$fltime,$message);

                        $message = str_replace('{passengers}',$deppassengers,$message);

                        $message = str_replace('{babyseats}',$depbabyseats,$message);

                        $message = str_replace('{comments}',$depcomments,$message);

                        $message = str_replace('{depestfare}',$depestfare,$message);

                        

                    }

                    // arrival

                    else if($cancelid==2) {

                        

                        $message = str_replace('{suburb}',$arrsuburb,$message);

                        $message = str_replace('{address1}',$arraddress1,$message);

                        $message = str_replace('{address2}',$arraddress2,$message);

                        $message = str_replace('{mobile}',$arrmobile,$message);

                        $message = str_replace('{phone}',$arrphone,$message);

                        $message = str_replace('{flight}',$arrflight,$message);

                        $message = str_replace('{airline}',$arrairline,$message);

                        $message = str_replace('{origin}',$arrorigin,$message);

                        $message = str_replace('{terminal}',$arrterminal,$message);

                        $message = str_replace('{depdate}',$arrdate,$message);

                        $message = str_replace('{fltime}',$arrfltime,$message);

                        $message = str_replace('{passengers}',$arrpassengers,$message);

                        $message = str_replace('{babyseats}',$arrbabyseats,$message);

                        $message = str_replace('{comments}',$arrcomments,$message);

                        $message = str_replace('{estfare}',$arrestfare,$message);

                        

                    }

                    

                    $message = str_replace('{arrsuburb}',$arrsuburb,$message);

                    $message = str_replace('{arraddress1}',$arraddress1,$message);

                    $message = str_replace('{arraddress2}',$arraddress2,$message);

                    $message = str_replace('{arrmobile}',$arrmobile,$message);

                    $message = str_replace('{arrphone}',$arrphone,$message);

                    $message = str_replace('{arrflight}',$arrflight,$message);

                    $message = str_replace('{arrairline}',$arrairline,$message);

                    $message = str_replace('{arrorigin}',$arrorigin,$message);

                    $message = str_replace('{arrterminal}',$arrterminal,$message);

                    $message = str_replace('{arrdate}',$arrdate,$message);

                    $message = str_replace('{arrfltime}',$arrfltime,$message);

                    $message = str_replace('{arrpassengers}',$arrpassengers,$message);

                    $message = str_replace('{arrbabyseats}',$arrbabyseats,$message);

                    $message = str_replace('{arrcomments}',$arrcomments,$message);

                    $message = str_replace('{arrestfare}',$arrestfare,$message);



                    $message = str_replace('{total}',$total,$message);

                

                    if($cancelid==1) {

                        

                        $message = str_replace('{direction}','Departure details',$message);

                        

                        $message = str_replace('{estfare}',$depestfare,$message);

                    }

                    else if($cancelid==2) {

                        

                        $message = str_replace('{direction}','Arrival details',$message);

                        

                        $message = str_replace('{estfare}',$arrestfare,$message);

                    }

                       

                    // Other mail template

                    if($bktype=='Other') {

                        

                    // departure

                        if(($direction=='departure' || $direction=='both') && $cancelid==1) {

                        $message = str_replace('{pickupsuburb}', $depsuburb, $message);

                        $message = str_replace('{pickupaddress1}', $depaddress1, $message);

                        $message = str_replace('{pickupaddress2}', $depaddress2, $message);

                        $message = str_replace('{pickupmobile}', $depmobile, $message);

                        $message = str_replace('{pickupphone}', $depphone, $message);

                        

                        $message = str_replace('{dropsuburb}', $depdropsuburb, $message);

                        $message = str_replace('{dropaddress1}', $depdropaddress1, $message);

                        $message = str_replace('{dropaddress2}', $depdropaddress2, $message);

                        $message = str_replace('{dropmobile}', $depdropmobile, $message);

                        $message = str_replace('{dropphone}', $depdropphone, $message);

                        }

                        

                        // arrival

                        if(($direction=='arrival' || $direction=='both') && $cancelid==2) {

                        $message = str_replace('{dropsuburb}', $arrsuburb, $message);

                        $message = str_replace('{dropaddress1}', $arraddress1, $message);

                        $message = str_replace('{dropaddress2}', $arraddress2, $message);

                        $message = str_replace('{dropmobile}', $arrmobile, $message);

                        $message = str_replace('{dropphone}', $arrphone, $message);



                        $message = str_replace('{pickupsuburb}', $arrdropsuburb, $message);

                        $message = str_replace('{pickupaddress1}', $arrdropaddress1, $message);

                        $message = str_replace('{pickupaddress2}', $arrdropaddress2, $message);

                        $message = str_replace('{pickupmobile}', $arrdropmobile, $message);

                        $message = str_replace('{pickupphone}', $arrdropphone, $message);

                        }

                        

                        // both departure

                        $message = str_replace('{deppickupsuburb}', $depsuburb, $message);

                        $message = str_replace('{deppickupaddress1}', $depaddress1, $message);

                        $message = str_replace('{deppickupaddress2}', $depaddress2, $message);

                        $message = str_replace('{deppickupmobile}', $depmobile, $message);

                        $message = str_replace('{deppickupphone}', $depphone, $message);

                        

                        $message = str_replace('{depdropsuburb}', $depdropsuburb, $message);

                        $message = str_replace('{depdropaddress1}', $depdropaddress1, $message);

                        $message = str_replace('{depdropaddress2}', $depdropaddress2, $message);

                        $message = str_replace('{depdropmobile}', $depdropmobile, $message);

                        $message = str_replace('{depdropphone}', $depdropphone, $message);

                        

                        // both arrival

                        $message = str_replace('{arrpickupsuburb}', $arrdropsuburb, $message);

                        $message = str_replace('{arrpickupaddress1}', $arrdropaddress1, $message);

                        $message = str_replace('{arrpickupaddress2}', $arrdropaddress2, $message);

                        $message = str_replace('{arrpickupmobile}', $arrdropmobile, $message);

                        $message = str_replace('{arrpickupphone}', $arrdropphone, $message);

                        

                        $message = str_replace('{arrdropsuburb}', $arrsuburb, $message);

                        $message = str_replace('{arrdropaddress1}', $arraddress1, $message);

                        $message = str_replace('{arrdropaddress2}', $arraddress2, $message);

                        $message = str_replace('{arrdropmobile}', $arrmobile, $message);

                        $message = str_replace('{arrdropphone}', $arrphone, $message);

                        // Other mail template end

                    }

                    

                    // mail save to mail trigger table

                    $default_email_config = $this->config->item('default_email_config');

                    $frmmail = $default_email_config['from'];

                    

                    // to

                    if($mail_row[0]['email']!='' && $tomail!='') $receiver = $tomail.','.$mail_row[0]['email'];

                    else if($mail_row[0]['email']!='') $receiver = $mail_row[0]['email'];

                    else if($tomail!='') $receiver = $tomail;

                    else $receiver = '';

                    

                    $this->tbl_name = "mail_trigger";

                    $crdate = date('Y-m-d H:i:s');

                    $mdata = array('book_id'=>$bookid,'from'=>$frmmail,'to'=>$receiver,'subject'=>$subject,'message'=>$message,'created_date'=>$crdate);

                            

                    $this->db->insert($this->tbl_name,$mdata);

                

            } // cancel mail end

            

            // mail status table

                    $this->tbl_name = "booking_confirm_status";

                    $crdate = date('Y-m-d H:i:s');

                    $sdata = array('book'=>$bookid,'user'=>$this->session->userdata('sess_userid'),'status'=>$cmail,'created_date'=>$crdate);

                            

                    $this->db->insert($this->tbl_name,$sdata);

            

                

                // cancel mail end

            

            return $data_row;

	}

        

        function getMailtemp($id) {



                $query = "SELECT * FROM email_templates WHERE id='".$id."'";

            

                $data = $this->db->query($query);

          

                $row = $data->result_array();

                

                return $row;

            

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

        

}

?>