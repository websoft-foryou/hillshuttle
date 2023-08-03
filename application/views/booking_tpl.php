<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
    $page_number = $_GET['page'];
    
?>
            <script type="text/javascript" src="<?php echo base_url();?>js/bpopup.js"></script>
            <link href="<?php echo base_url();?>css/bpopup.css" rel="stylesheet" type="text/css" />

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/booking.png" /><span class="page-headlbl">BOOKING</span></div>
        
        <table width="100%" align="left">
            
            <tr>
                
                <td align="left"><?php echo anchor('/booking/add','<img src="'.base_url().'images/add.png" title="add"/><span class="add-headlbl">Add Record</span>'); ?></td>
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>booking/index/id/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" id="search_txt" value="<?php echo $this->session->userdata('book_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld" onchange="searchDrop(this.value)">
                                    
                                    <option value="booking.id" <?php if($this->session->userdata('book_searchfld')=='booking.id') echo 'selected'; ?>>Booking Number</option>
                                    
                                    <option value="first_name" <?php if($this->session->userdata('book_searchfld')=='first_name') echo 'selected'; ?>>First name</option>
                                    
                                    <option value="last_name" <?php if($this->session->userdata('book_searchfld')=='last_name') echo 'selected'; ?>>Surname</option>
                                    
                                    <option value="mobile" <?php if($this->session->userdata('book_searchfld')=='mobile') echo 'selected'; ?>>Mobile Number</option>
                                    
                                    <option value="type" <?php if($this->session->userdata('book_searchfld')=='type') echo 'selected'; ?>>Type</option>
                                    
                                    <option value="dep_flight" <?php if($this->session->userdata('book_searchfld')=='dep_flight') echo 'selected'; ?>>Flight</option>
                                    
                                    <option value="direction" <?php if($this->session->userdata('book_searchfld')=='direction') echo 'selected'; ?>>Direction</option>
                                    
                                    
                                    <option value="cancel_book" <?php if($this->session->userdata('book_searchfld')=='cancel_book') echo 'selected'; ?>>Cancelled</option>
                                    
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'booking/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                            
                            </label>
                        
                        </div>
                    
                    </form>
                
                </td>
            
            </tr>
        
        </table>
        <br/>
        
        <table class="table-contents">
            
            <tr>
                <th class="table-subhead" style="width: 30px;">Cancel</th>
                
                <th class="table-subhead" style="width: 100px;">Booking Number</th>
                
                <th class="table-subhead">Client</th>
                
                <th class="table-subhead">Type</th>
                
                <th class="table-subhead">Flight</th>
                
                <th class="table-subhead" style="width: 110px;">Direction</th>
                
                <th class="table-subhead">Suburb</th>
                
                <th class="table-subhead" style="width: 100px;">Date</th>
                
                <th class="table-subhead" style="width: 100px;">Pick-up Time</th>
                
                <th colspan="2" class="table-subhead" style="width: 50px;">Action</th>
            
            </tr>
            <?php
                
 if(count($book_data)>0) {
                    
                    foreach ($book_data as $row) {
                    
                       $cli_name = $row['first_name'].' '.$row['last_name'];
                        
                        if($row['direction']=='both') {
                            $direction_val = 'Departure / Arrival';
                            
                            // date
                            $deptval = strtotime($row['dep_date']);
                            $arrtval = strtotime($row['arr_date']);
                            if($deptval<$arrtval) { 
                                $bk_date = $row['arr_date'];
                            }
                            else { 
                                $bk_date = $row['dep_date'];
                            } 
                            
                            // flight
                        $depflight = $row['dep_flight'];
                        
                        $arrflight = $row['arr_flight'];
                        
                        if($depflight!='' || $arrflight!='') $both_flight = $depflight.' / '.$arrflight;
                        
                        else $both_flight = '';
                        
                        $bk_flight = $both_flight;
                          
                        // Suburb
                            $ap_suburb = $row['dep_suburb'].' / '.$row['arr_terminal'];     
                            
                            $bk_suburb = $row['dep_suburb'].' / '.$row['arr_suburb'];
                            
                            // date
                        if($row['dep_date']!='0000-00-00') $depdate = date('d/M/Y',strtotime($row['dep_date'])); 
                        if($row['arr_date']!='0000-00-00') $arrdate = date('d/M/Y',strtotime($row['arr_date'])); 
                            
                        $bk_dateval = $depdate.' / '.$arrdate;
                        
                        // Pickup time
                        if($row['dep_pickuptime']!=':' && $row['dep_pickuptime']!='0:00' && $row['dep_pickuptime']!=':00') $deppickup = $row['dep_pickuptime'];
                        if($row['arr_pickuptime']!=':' && $row['arr_pickuptime']!='0:00' && $row['arr_pickuptime']!=':00') $arrpickup = $row['arr_pickuptime'];                        

                        if($deppickup!='' || $arrpickup!='') $both_pickup = $deppickup.' / '.$arrpickup;
                        else $both_pickup = '';

                        $bk_pickup = $both_pickup;
                        }
                        
                        if($row['direction']=='departure') {
                            
                            $direction_val = 'Departure';
                            
                            $bk_date = $row['dep_date'];
                            
                            $bk_flight = $row['dep_flight'];
                            
                            $ap_suburb = $row['dep_suburb'];
                            
                            $bk_suburb = $row['dep_suburb'];
                            
                            if($row['dep_date']!='0000-00-00') $depdate = date('d/M/Y',strtotime($row['dep_date'])); 
                            $bk_dateval = $depdate;
                            
                            if($row['dep_pickuptime']!=':' && $row['dep_pickuptime']!='0:00' && $row['dep_pickuptime']!=':00') $deppickup = $row['dep_pickuptime'];
                            $bk_pickup = $deppickup;
                        }
                        
                        if($row['direction']=='arrival') {
                            
                            $direction_val = 'Arrival';
                            
                            $bk_date = $row['arr_date'];
                            
                            $bk_flight = $row['arr_flight'];
                            
                            $ap_suburb = $row['arr_suburb'];
                            
                            $bk_suburb = $row['arr_suburb'];
                            
                            if($row['arr_date']!='0000-00-00') $arrdate = date('d/M/Y',strtotime($row['arr_date'])); 
                            $bk_dateval = $arrdate;
                            
                            if($row['arr_pickuptime']!=':' && $row['arr_pickuptime']!='0:00' && $row['arr_pickuptime']!=':00') $arrpickup = $row['arr_pickuptime'];
                            $bk_pickup = $arrpickup;
                        }
            ?>          
                <tr>
                    
                                <td>
                                     <?php 
                                     $tdate = strtotime('Today');
                                     $bkdate = strtotime($bk_date);
                                     
                                     
                                        if($tdate<=$bkdate && $row['direction']=='departure' && $row['cancel_book']!=1 && $row['cancel_book']!=3) { 
                                     ?>   
                                        <input type="checkbox" name="canid" id="canid_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" title="Cancel" onclick="cancelPop('<?php echo $row['id']; ?>','<?php echo $row['direction']; ?>','<?php echo $row['cancel_book']; ?>')"/> 
                                        <?php 
                                        } else if($tdate<=$bkdate && $row['direction']=='arrival' && $row['cancel_book']!=2 && $row['cancel_book']!=3) { 
                                        ?>
                                        
                                        <input type="checkbox" name="canid" id="canid_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" title="Cancel" onclick="cancelPop('<?php echo $row['id']; ?>','<?php echo $row['direction']; ?>','<?php echo $row['cancel_book']; ?>')"/> 
                                        
                                        <?php } else if($tdate<=$bkdate && $row['direction']=='both' && $row['cancel_book']!=3) { ?>
                                        
                                        <input type="checkbox" name="canid" id="canid_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" title="Cancel" onclick="cancelPop('<?php echo $row['id']; ?>','<?php echo $row['direction']; ?>','<?php echo $row['cancel_book']; ?>')"/> 
                                        
                                        <?php } else if($row['cancel_book'] == 1 || $row['cancel_book'] == 2 || $row['cancel_book'] == 3) echo 'Cancelled'; ?>
                                </td>
                    
                                <td><?php echo $row['id']; ?></td>

                                <td align="left"><?php echo $cli_name; ?></td>

                                <td><?php echo $row['type']; ?></td>

                                <td align="left"><?php echo $bk_flight; ?></td>

                                <td><?php echo $direction_val; ?></td>

                                <td align="left"><?php echo ($row['type']=='AP')? $ap_suburb : $bk_suburb; ?></td>

                                <td><?php echo $bk_dateval; ?></td>

                                <td><?php echo $bk_pickup; ?></td>

                                <td align="center"><?php echo anchor('/booking/edit/'.$row['id'],'<img src="'.base_url().'images/edit.png" title="edit"/>'); ?></td>

                                <td align="center">

                                <?php $url = base_url().'index.php/booking/delete/'.$row['id']; ?>

                                    <a href="javascript:;" onClick="return delRec('<?php echo $url; ?>')"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a>

                                </td>

                
                </tr>
            <?php 
                
                    }
                    
                }           
                
                else {
            ?>
                
                <tr>
                    
                    <td colspan="11" align="center">No record found</td>
                
                </tr>
            <?php
            
                }
                
                if($page_links) {
            ?>
                <tr>
                    
                    <td colspan="11" align="right"><?php echo $page_links; ?></td>
                
                </tr>
        
                <?php } ?>
                
        </table>
    
    </div>
    
                <!-- Popup -->
                    <div id="element_to_pop_up" style="display: none; border: 2px double black; background-color: white;">
                            <span class="button" onclick="closePopup()">
                                <span>X</span>
                            </span>
                        <span class="bClose"></span>

                        <div id="cancelform">
                        <fieldset><legend align="center"><b>Choose option you want to cancel</b></legend>
                        <table width="100%" align="center">
                            <tr>
                                <td><br/></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <input type="hidden" name="cbookid" id="cbookid" />
                                    <input type="hidden" name="dirval" id="dirval" />
                                    <input type="hidden" name="cancelval" id="cancelval" />
                                    
                                    <span id="calcelhtml"></span>
                                    
                                    <table>
                                        <tr>
                                            <td><input type="radio" name="canceldir" id="candep" class="can" value="1" /></td><td>Departure</td>
                                        </tr>
                                        
                                        <tr><td><br/></td></tr>
                                        
                                        <tr>
                                            <td><input type="radio" name="canceldir" id="canarr" class="can" value="2" /></td><td>Arrival</td>
                                        </tr>
                                        
                                        <tr><td><br/></td></tr>
                                        
                                        <tr>
                                            <td><input type="radio" name="canceldir" id="canboth" class="can" value="3" checked /></td><td>Both</td>
                                        </tr>
                                    </table>
                                    
                                </td>
                            </tr>
                            <tr><td><br/></td></tr>
                            <tr>
                                <td align="center"><input type="button" name="popsave" id="formconfirm" value="OK" class="bgbtn"/>
                                    <div id="popuperror"></div>
                                <br/><br/>
                                </td>
                            </tr>
                        </table>
                        </fieldset>
                        </div>
                        
                        <div id="sureform" style="display:none;" align="center">
                            <h3>Are you sure you want to cancel?</h3>
                            <div align="center"><input type="button" name="popyes" id="popsave" value="Yes" class="bgbtn popsave"/>
                            <input type="button" name="popno" id="popno" value="No" class="bgbtn" onclick="closePopup()"/></div>
                            <div id="popuperror"></div>
                        </div>
                    </div>
                 <!-- Popup end -->    
    <!-- Form content end -->

</div>


<script type="text/javascript">
    
function cancelPop(id,dir,cval) {
//alert(cval);
;(function($) {

         // DOM Ready
        $(function() {

            $('#cbookid').val(id);
            $('#dirval').val(dir);
            $('#cancelval').val(cval);
            
            if(dir!='both') {
                $('#cancelform').css('display','none');
                $('#sureform').css('display','inline');
            }
            else {
                $('#cancelform').css('display','inline');
                $('#sureform').css('display','none');
                
            }
            
            if(cval==1) {
                $("#calcelhtml").html('<div align="center">Departure cancelled</div><br/>');
                $("#candep").attr('disabled','disabled');
                $("#canarr").removeAttr('disabled');
            }
            else if(cval==2) {
                $("#calcelhtml").html('<div align="center">Arrival cancelled</div><br/>');
                $("#candep").removeAttr('disabled');
                $("#canarr").attr('disabled','disabled');
            }
            else {
                $("#calcelhtml").html('');
                $("#candep").removeAttr('disabled');
                $("#canarr").removeAttr('disabled');
            }
                    // Triggering bPopup when click event is fired
                    $('#element_to_pop_up').bPopup();
            
        });

    })(jQuery);
    
}

$("#formconfirm").click(function() {
    $("#cancelform").css('display','none');
    $("#sureform").css('display','inline');
});

$(".popsave").click(function() {

    var mailconfirm = confirm('Do you want to send email confirmation?');
    if(mailconfirm==true) var conmail = '1';
    else var conmail = '0';
        
                    var cid = $("#cbookid").val();
                    var btn = $('.can:checked').val();
                    var dir = $("#dirval").val();
                    var cancelval = $("#cancelval").val();
                    
                        $('#popuperror').html('<img src="images/loader.gif">')
			$.post("<?php echo base_url(); ?>common/cancelbook", {cid: ""+cid+"", pdir: ""+btn+"", dir: ""+dir+"", cval: ""+cancelval+"", cmail: ""+conmail+"", mode: 'booking'}, function(data){
				//alert(data);  
                                if(data==1) {
                                    //window.location.reload( true );
                                    <?php if($page_number) { ?> window.location.href = '<?php echo base_url(); ?>booking?page=<?php echo $page_number; ?>'; <?php } else { ?>
                                           window.location.href = '<?php echo base_url(); ?>booking';
                                           <?php } ?>
                                }
                                
			});
                    
    
});

    function closePopup() {
        $('.bClose').click();
        
        $("input:checkbox").attr("checked", false);
    }

    function delRec(url) {
        
        var q = confirm('Are you sure you want to delete this record?');
        
        if(q==true) {
            
            window.location=url;
            
            return true;
        }
        
        else return false;
        
    }
    
    function searchDrop(val) {
        //alert(val);
        if(val == 'cancel_book') {
            
            $('#search_txt').val('Cancelled');
            
            $('#search_txt').attr('readonly',true);
        }
        else {
            
            $('#search_txt').val('');
            $('#search_txt').attr('readonly',false);
        }
    }
</script>

<?php

    if($this->session->userdata('book_searchfld')=='cancel_book') {
?>
<script>
    $('#search_txt').attr('readonly',true);
</script>

    <?php } ?>
