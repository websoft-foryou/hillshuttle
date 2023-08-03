<?php
    $page_number = $_GET['page'];
?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validation.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/datepicker.js"></script>
            
            <link href="<?php echo base_url();?>css/datepicker.css" rel="stylesheet" type="text/css" />

            <script type='text/javascript' src='<?php echo base_url();?>js/jquery.autocomplete.js'></script>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
            
            <script type="text/javascript" src="<?php echo base_url();?>js/bpopup.js"></script>
            <link href="<?php echo base_url();?>css/bpopup.css" rel="stylesheet" type="text/css" />
            
<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <?php if(empty($client_row[0]['bkform'])) { ?>
        <div class="page-head"><img src="<?php echo base_url();?>images/new-client.png" /><span class="page-headlbl"><?php if($client_row[0]['id']) echo 'EDIT CLIENT'; else echo 'ADD CLIENT'; ?></span></div>
        
        <?php if(!empty($client_row[0]['id'])) { ?>
        <div class="editclient-existclient">
            <table class="table-forms" align="center">
        
                <tr>
            
                    <td class="field-left">Client: </td>
            
                    <td>
                
                        <input type="text" name="client" id="client" autocomplete="off" value="" style="width: 285px; padding: 5px;"/>
                        <br/><span style="font-size: 10px; color: gray;">Start typing to view existing clients</span>            
                        
                    </td>
            
                </tr>
            </table>
            <br/><br/>
        </div>
        
        <?php 
        }
        
        } 
        else echo "<span class='page-head'>Client</span>";
        ?>
        
        <form name="client_form" method="post" action="add" onSubmit="return clientValidate()"> 
    
            <table class="table-forms" align="center">
        
                <tr>
            
                    <td class="field-left">First Name: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="hidden" name="cli_id" id="cli_id" value="<?php echo $client_row[0]['id']; ?>" />
                        <input type="hidden" name="redirect" id="redirect" value="client"/>
                        <input type="text" name="clientinfo[first_name]" id="first_name" tabindex="1" value="<?php echo $client_row[0]['first_name']; ?>" style="text-transform: capitalize;"/>
            
                    </td>
            
                    <td class="field-left">Surname: <span class="red-star">*</span></td>
            
                    <td>
                        <input type="text" name="clientinfo[last_name]" id="last_name" tabindex="2" value="<?php echo $client_row[0]['last_name']; ?>" style="text-transform: capitalize;"/>
            
                    </td>
        
                </tr>
        
                <tr>
            
                    <td class="field-left">Gender: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <span id="gender_lable"><input type="radio" name="clientinfo[gender]" id="gender" value="M" <?php if($client_row[0]['gender']=='M') echo 'checked'; ?> tabindex="3"/>&nbsp;&nbsp;Male &nbsp;&nbsp;<input type="radio" name="clientinfo[gender]" id="fgender" value="F" <?php if($client_row[0]['gender']=='F') echo 'checked'; ?> tabindex="4"/>&nbsp;&nbsp;Female</span>
            
                    </td>
            
                    <td class="field-left">Address1: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="text" name="clientinfo[address1]" id="address1" tabindex="4" value="<?php echo $client_row[0]['address1']; ?>"/>
            
                    </td>
        
                </tr>
        
                <tr>
            
                    <td class="field-left">Address2: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <input type="text" name="clientinfo[address2]" id="address2" tabindex="6" value="<?php echo $client_row[0]['address2']; ?>"/>
            
                    </td>
                    
                    <td class="field-left">Suburb: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="text" name="clientinfo[suburb]" id="suburb" autocomplete="off" tabindex="7" value="<?php echo $client_row[0]['suburb']; ?>"/>
            
                      <div class="suggestionsBox-sub" id="suggestions-sub" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                           <div class="suggestionList" id="suggestionsList-sub"> &nbsp; </div>
                      </div>
                        
                    </td>
                    
                </tr>
        
                <tr>
            
                    <td class="field-left">Contact Number1: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="text" name="clientinfo[mobile]" id="mobile" tabindex="8" value="<?php if($client_row[0]['mobile']!='0') echo $client_row[0]['mobile']; ?>" onkeypress="return numeric(event)"/>
            
                    </td>
                    
                    <td class="field-left">Contact Number2: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <input type="text" name="clientinfo[phone]" id="phone" tabindex="9" value="<?php if($client_row[0]['phone']!='0') echo $client_row[0]['phone']; ?>" onkeypress="return numeric(event)"/>
                
                        <span id="labl_phone" class="alt-lbl">Enter phone</span>
            
                    </td>
                    
                </tr>
        
                <tr>

                    <td class="field-left">Email: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <input type="text" name="clientinfo[email]" id="email" tabindex="10" value="<?php echo $client_row[0]['email']; ?>"/>
            
                    </td>

                    <td class="field-left">Comments: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <textarea name="clientinfo[comments]" id="comments" tabindex="11" cols="25" rows="4"><?php echo $client_row[0]['comments']; ?></textarea>
            
                    </td>
                    
                </tr> 
    
            <?php 
                if($client_row[0]['id']) {
                        $created = '';
                        $updated = '';
                        
                        if($client_row[0]['created_date']!='') $created = date('d/M/Y',$client_row[0]['created_date']);
                        
                        if($client_row[0]['updated_date']!='') $updated = date('d/M/Y',$client_row[0]['updated_date']);
                
                ?>
                <tr>
                    
                        <td class="field-left">Registration Type: <span class="red-star">&nbsp;</span></td>

                        <td>

                            <?php if($client_row[0]['cli_type']=='1') echo 'Online'; else echo 'Phone / Email'; ?>

                        </td>
                
                    <td class="field-left">Created by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $client_row[0]['created_by']; ?></td>
                    
                </tr>
                
                <tr>
                
                    <td class="field-left">Created date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $created; ?></td>

                    <td class="field-left">Updated by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $client_row[0]['updated_by']; ?></td>

                </tr>
                
                <tr>

                    <td class="field-left">Updated date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $updated; ?></td>

                    <td></td>
                    <td></td>
                    
                </tr>
                
                <?php } ?>                  
            </table>
            
            <?php if(empty($client_row[0]['bkform'])) { ?>
            <div align="center"><input type="submit" name="client" value="Save" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'clients"><span class="bgbtn">Cancel</span></a>'; ?></div>
            <?php } ?>
        </form>
    
    </div>
    <!-- Form content end -->

    <!-- Prior booking start -->
    <?php if(empty($client_row[0]['bkform']) && (!empty($client_row[0]['id']))) { ?>
    <div>
                    <fieldset>
                        
                        <legend class="table-tophead" align="center">Prior Bookings</legend>
                        <br/>
        
<table class="table-contents" bgcolor="#f2f2f2" width="50%">
            
                        <tr>
                            <th class="table-subhead">Cancel</th>
                            
                            <th class="table-subhead">Booking</th>
                            
                            <th class="table-subhead">Type</th>
                            
                            <th class="table-subhead">Flight</th>
                            
                            <th class="table-subhead">Airline</th>
                            
                            <th class="table-subhead">Direction</th>
                            
                            <th class="table-subhead">Terminal</th>
                            
                            <th colspan="3" class="table-subhead">Time</th>
                            
                            <th colspan="2" class="table-subhead">Suburb</th>
                            
                            <th colspan="2" class="table-subhead">Address</th>
                            
                        </tr>
            <?php
                $prior = array();
                $m = 0;
                for($s=0; $s<count($prior_row); $s++) {
            
                        $res_suburb = '';
                        
                        $pickup_address = '';
                        
                        $drop_address = '';
                        
                        $directions = '';
                        
                        $depres_suburb = '';
                        
                        $deppickup_address = '';
                        
                        $depdrop_address = '';
                    
                    $directions = $prior_row[$s]['direction'];
                    
                    $book_type = $prior_row[$s]['type'];
                    
                                 $autoid = $prior_row[$s]['id'];
                                
               if($directions=='both' || $directions=='departure') {
                   
                       $prior[$m] = $prior_row[$s];
                       
                                if($prior_row[$s]['type']=='AP') $btime = $prior_row[$s]['dep_ourtime'];
                                else $btime = $prior_row[$s]['dep_time'];
                                
                                if($prior_row[$s]['dep_date']!='' && $prior_row[$s]['dep_date']!='0000-00-00') $pridepdate = date('d/m/Y',strtotime($prior_row[$s]['dep_date']));
                                
                                if($prior_row[$s]['direction']=='departure') $bdir = 'dep';
                                else if($prior_row[$s]['direction']=='arrival') $bdir = 'arr';
                                else if($prior_row[$s]['direction']=='both') $bdir = 'both';
                                
                                
                       $prior[$m]['dirval'] = $prior_row[$s]['direction'];
                       
                       $prior[$m]['bookid'] = $prior_row[$s]['id'];
                       $prior[$m]['type'] = $prior_row[$s]['type'];
                       $prior[$m]['flight'] = $prior_row[$s]['dep_flight'];
                       $prior[$m]['airline'] = $prior_row[$s]['dep_airline'];
                       $prior[$m]['direction'] = 'Departure';
                       $prior[$m]['terminal'] = $prior_row[$s]['dep_terminal'];
                       $prior[$m]['date'] =  $pridepdate;
                       $prior[$m]['fltime'] = $btime;
                       $prior[$m]['clisuburb'] = $client_row[0]['suburb'];
                       $prior[$m]['suburb'] = $prior_row[$s]['dep_suburb'];
                       $prior[$m]['cliaddress'] = $client_row[0]['address1'];
                       $prior[$m]['address'] = $prior_row[$s]['dep_address1'];
                       $prior[$m]['fldate'] = $prior_row[$s]['dep_date'];
                       $prior[$m]['cancelbook'] = $prior_row[$s]['cancel_book'];
                       
                       $m++;
                    
               }
               
               if($directions=='both' || $directions=='arrival') {
                   
                       $prior[$m] = $prior_row[$s];
                       
                                if($prior_row[$s]['type']=='AP') $btime = $prior_row[$s]['arr_ourtime'];
                                else $btime = $prior_row[$s]['arr_time'];
                                
                                if($prior_row[$s]['arr_date']!='' && $prior_row[$s]['arr_date']!='0000-00-00') $priarrdate = date('d/m/Y',strtotime($prior_row[$s]['arr_date']));
                                
                                if($prior_row[$s]['direction']=='departure') $bdir = 'dep';
                                else if($prior_row[$s]['direction']=='arrival') $bdir = 'arr';
                                else if($prior_row[$s]['direction']=='both') $bdir = 'both';
                                
                                
                       $prior[$m]['dirval'] = $prior_row[$s]['direction'];
                                
                       $prior[$m]['bookid'] = $prior_row[$s]['id'];
                       $prior[$m]['type'] = $prior_row[$s]['type'];
                       $prior[$m]['flight'] = $prior_row[$s]['arr_flight'];
                       $prior[$m]['airline'] = $prior_row[$s]['arr_airline'];
                       $prior[$m]['direction'] = 'Arrival';
                       $prior[$m]['terminal'] = $prior_row[$s]['arr_terminal'];
                       $prior[$m]['date'] = $priarrdate;
                       $prior[$m]['fltime'] = $btime;
                       $prior[$m]['clisuburb'] = $client_row[0]['suburb'];
                       $prior[$m]['suburb'] = $prior_row[$s]['arr_suburb'];
                       $prior[$m]['cliaddress'] = $client_row[0]['address1'];
                       $prior[$m]['address'] = $prior_row[$s]['arr_address1'];
                       $prior[$m]['fldate'] = $prior_row[$s]['arr_date'];
                       $prior[$m]['cancelbook'] = $prior_row[$s]['cancel_book'];
                       
                       $m++;
                   
               } 
                }
                ?>
                
                <?php
              $count = count($prior);
                
                $paging_config = $this->config->item('paging_config'); 
              
                          $showrecs = $paging_config['per_page'];

                          $pagerange = $paging_config['num_links'];

                            require('page_config.php');
                // pagination end
                       
                if($count>0) {
                    for ($r=$startrec; $r < $reccount; $r++ ) {
                        
                ?>
                <tr>
                    <td>
                        <?php
                        $tdate = strtotime('Today');
                        
                        $bkdate = strtotime($prior[$r]['fldate']);
                        
                          if($tdate<=$bkdate && $prior[$r]['direction']=='Departure' && $prior[$r]['cancelbook']!=1 && $prior[$r]['cancelbook']!=3) { ?>
                            
                            <input type="checkbox" name="canid" id="canid_<?php echo $prior[$r]['bookid']; ?>" value="<?php echo $prior[$r]['bookid']; ?>" title="Cancel" onclick="cancelPop('<?php echo $prior[$r]['bookid']; ?>','<?php echo $prior[$r]['dirval']; ?>','<?php echo $prior[$r]['cancelbook']; ?>')"/>
                            
                        <?php } else if($tdate<=$bkdate && $prior[$r]['direction']=='Arrival' && $prior[$r]['cancelbook']!=2 && $prior[$r]['cancelbook']!=3) {  ?>
                            
                            <input type="checkbox" name="canid" id="canid_<?php echo $prior[$r]['bookid']; ?>" value="<?php echo $prior[$r]['bookid']; ?>" title="Cancel" onclick="cancelPop('<?php echo $prior[$r]['bookid']; ?>','<?php echo $prior[$r]['dirval']; ?>','<?php echo $prior[$r]['cancelbook']; ?>')"/>
                            
                            <?php } 
                            
                            else if($prior[$r]['direction']=='Departure' && ($prior[$r]['cancelbook'] == 1 || $prior[$r]['cancelbook'] == 3)) echo 'Cancelled'; 
                            
                            else if($prior[$r]['direction']=='Arrival' && ($prior[$r]['cancelbook'] == 2 || $prior[$r]['cancelbook'] == 3)) echo 'Cancelled'; 
                            
                            ?>
                    </td>
                    
                    <td>
                        <?php $bsdate = base64_encode($prior[$r]['fldate']); ?>
                        <a href="<?php echo base_url(); ?>booking/edit/<?php echo $prior[$r]['bookid']; ?>" style="color:blue !important;"><?php echo $prior[$r]['bookid']; ?></a>
                    </td>
                    
                    <td><?php echo $prior[$r]['type']; ?></td>
                    
                    <td><?php echo $prior[$r]['flight']; ?></td>
                    
                    <td><?php echo $prior[$r]['airline']; ?></td>
                    
                    <td><?php echo $prior[$r]['direction']; ?></td>
                    
                    <td><?php echo $prior[$r]['terminal']; ?></td>
                    
                    <td><?php echo $prior[$r]['date']; ?></td>
                    
                    <td><?php echo $prior[$r]['fltime']; ?></td>
                    
                    <td><?php echo $prior[$r]['clisuburb']; ?></td>
                    
                    <td><?php echo $prior[$r]['suburb']; ?></td>
                    
                    <td><?php echo $prior[$r]['cliaddress']; ?></td>
                    
                    <td><?php echo $prior[$r]['address']; ?></td>
                    
                </tr>
            <?php 
               
                    } 
                    
                }
                else {
            ?>
                
                <tr>
                    
                    <td colspan="13" align="center">No record found</td>
                
                </tr>
            <?php
            
                }
                
               ?>
                <?php if(count($prior_row)>0) { 
                    if($count>20) { ?>
                <tr>

                    <td colspan="13" align="right">
                        
                        <?php

                          $target_url = base_url().'clients/edit/'.$client_row[0]['id'];

                          $this->common_model->showpagenav($page, $pagecount, $target_url);

                        ?>
                        
                    </td>

                </tr>
                <?php } } ?>
               
        </table> 
                    </fieldset>
    </div>
    <?php } ?>
    <!-- Prior booking end -->
    
                <!-- Popup -->
                    <div id="book_cancel_popup" style="display: none; border: 2px double black; background-color: white;">
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
    
</div>


<script type="text/javascript">
    
    $('#dob').datepick();
    
$.post("<?php echo base_url(); ?>ajax.php", {websuburb: "suburb"}, function(data){
				//alert(data);
                                var subval = [];
                                if(data.length >0) {
                                    var spldata = data.split(',');
                                   
                                    for(var i=0; i<spldata.length; i++) {
                                        subval[i] = ""+spldata[i]+"";
                                    }
                                   // alert(subval);
                                    $("#suburb").autocomplete(subval);      
                                        
				}
                                
			});
                        
        function getSuburb(inputString){
		//alert(inputString);
    
                
            /*    if(inputString.length == 0) {
                        $('#suggestions-sub').fadeOut();
		} else {
		
			$.post("<?php //echo base_url(); ?>ajax.php", {websuburb: ""+inputString+""}, function(data){
				//alert(data);
                                if(data.length >0) {
                                        
                                            if(data.length >0) {
                                                $('#suggestions-sub').fadeIn();
                                                $('#suggestionsList-sub').html(data);
                                                $('#suburb').removeClass('load');
                                            }
                                        
				} 
			});
		} */
	}

	function fillSuburbpass(thisValue) {
		//alert(dir);
                
                $('#suburb').val(thisValue);
                
                setTimeout("$('#suggestions-sub').fadeOut();", 600);
                
	}

function numeric(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 32 || charCode > 57 )) {
             //alert('Numbers only allowed');
            return false;
         }
       else  return true;
}
        
    function clientValidate() {
        
        var flag = true;
        
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        
        var fval = document.getElementById('first_name').value;
        
        var lval = document.getElementById('last_name').value;

        var ccid = document.getElementById('cli_id').value;
        
        var streetval = document.getElementById('address1').value;
        
        var suburbval = document.getElementById('suburb').value;
        
        var mobileval = document.getElementById('mobile').value;
        
        var emailval = document.getElementById('email').value;
        
        if(fval=='') {
            
            document.getElementById('first_name').style.backgroundColor='yellow';
            
            flag = false;
        }
        
        else document.getElementById('first_name').style.backgroundColor='white';
        
        if(lval=='') {
            
            document.getElementById('last_name').style.backgroundColor='yellow';
            
            flag = false;
        
        }
        
        else document.getElementById('last_name').style.backgroundColor='white';
        
        if(streetval=='') {
            
            document.getElementById('address1').style.backgroundColor='yellow';
            
            flag = false;
        
        }
        
        else document.getElementById('address1').style.backgroundColor='white';

        if(suburbval=='') {
            
            document.getElementById('suburb').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        
        else document.getElementById('suburb').style.backgroundColor='white';

        if(mobileval=='') {
            
            document.getElementById('mobile').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        
        else document.getElementById('mobile').style.backgroundColor='white';

        if(emailval!='') {
        if(filter.test(emailval)==false) {
            
            document.getElementById('email').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        
        else document.getElementById('email').style.backgroundColor='white';
        }
        
        if(ccid!='') {
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php echo base_url(); ?>common/clientval",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{fval: ""+fval+"",lval: ""+lval+"",ccid: ""+ccid+"",add: ""+streetval+"",mail: ""+emailval+"",suburb: ""+suburbval+""},
                       success: function(data){
                         //  alert(data); 
                            if(data!=0) { 
                                alert('Client already exist. Please try another name or address or suburb or email.'); 
                                 flag = false;
                            }
                            
                       }
                    });
            });
        } 
        
        if(suburbval!='') {
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php echo base_url(); ?>ajax.php",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{clisuburbval: "clisuburbvalidate",queryString: ""+suburbval+""},
                       success: function(data){
                         //  alert(data);
                            if(data==0) { 
                                alert('Select valid Suburb'); 
                                 document.getElementById('suburb').style.backgroundColor='yellow';
                                 flag = false;
                            }
                            else document.getElementById('suburb').style.backgroundColor='white';

                       }
                    });
            });
            
        }
        
        if(flag==true) {
            var page = confirm('Do you want to Redirect to the Booking form?');
            if(page) $('#redirect').val('booking');
            return true;
        }
        
        else return false;
        
    }
    
    
$().ready(function() {   
    
$.post("<?php echo base_url(); ?>common/client", {queryString: "client"}, function(data){
                                
                                var dataval = [];
                                
                                var mmval = eval('(' + data + ')');
                                
                                var cname = mmval.name;
                                var splname = cname.split('~~');
                             //   alert(cname);
                                var cval = mmval.to;
                                var splto = cval.split('~~');
                                
                                for(var k=0; k<splname.length; k++) {
                                  dataval[k] = { name: ""+splname[k]+"", to: ""+splto[k]+""}
                                } 
                                
                              
                                $("#client").autocomplete(dataval, {
                                                minChars: 0,
                                                width: 310,
                                                autoFill: false,
                                                formatItem: function(row, i, max) {
                                                        return row.name;
                                                }
                                        });    

                                $("#client").result(log).next().click(function() {
                                                            $(this).prev().search();

                                                    });
                                                    
                                function log(event, data, formatted) {
                                        
                                        getClientdata(data.to);
                                }
                              
			});
                        
                        
                        });
            
    
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
                    $('#book_cancel_popup').bPopup();
            
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
                    
                        $('#popuperror').html('<img src="<?php echo base_url(); ?>images/loader.gif">')
			$.post("<?php echo base_url(); ?>common/cancelbook", {cid: ""+cid+"", pdir: ""+btn+"", dir: ""+dir+"", cval: ""+cancelval+"", cmail: ""+conmail+"", mode: 'client'}, function(data){
				//alert(data);  
                                if(data==1) {
                                    //window.location.reload( true );
                                    <?php if($page_number) { ?> window.location.href = '<?php echo base_url(); ?>clients/edit/<?php echo $client_row[0]['id']; ?>?page=<?php echo $page_number; ?>'; <?php } else { ?>
                                           window.location.href = '<?php echo base_url(); ?>clients/edit/<?php echo $client_row[0]['id']; ?>';
                                           <?php } ?>
                                }
                                
			});
                    
    
});

    function closePopup() {
        $('.bClose').click();
        
        $("input:checkbox").attr("checked", false);
    }
    
            function getClientdata(id) {

            if(id) {
                
                $('#client-data').css('display','inline');
                
                $(document).ready(function() {
                        $.ajax({
                           url: "<?php echo base_url(); ?>clients/getclient",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{id: ""+id+""},
                           success: function(data){
                           //    alert(data);
                               if(data) {
                                  var client = eval('(' + data + ')');

                                         var fval = client.fname;
                                         var lval = client.lname;
                                         var streetval = client.address1;
                                         var address2 = client.address2;
                                         var mobileval = client.mobile;
                                         var phoneval = client.phone;
                                         var emailval = client.email;
                                         var suburbval = client.suburb;
                                         var cligender = client.gender;
                                         var cmtval = client.comments;
                                         var cid = id;
                                         
                                         if(cligender=='M') $("#gender").attr("checked", true);
                                         else $("#gender").attr("checked", false);
                                         
                                         if(cligender=='F') $("#fgender").attr("checked", true);
                                         else $("#fgender").attr("checked", false);
                                             
                                         $('#cli_id').val(id);
                                         
                                         $('#first_name').val(fval);
                                         
                                         $('#last_name').val(lval);
                                         
                                     //    $('#gender').html(gendval);
                                         
                                         $('#address1').val(streetval);
                                         
                                         $('#address2').val(address2);
                                         
                                         $('#suburb').val(suburbval);
                                         
                                         $('#mobile').val(mobileval);
                                         
                                         $('#phone').val(phoneval);
                                         
                                         $('#email').val(emailval);
                                         
                                         $('#comments').val(cmtval);
                               }

                           }
                       });
                 });
                 
                }

            }
    
</script>