            <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validation.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/datepicker.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/bpopup.js"></script>
            
            <link href="<?php echo base_url();?>css/datepicker.css" rel="stylesheet" type="text/css" />
            
            <link href="<?php echo base_url();?>css/bpopup.css" rel="stylesheet" type="text/css" />
            
            <script type="text/javascript" src="<?php echo base_url();?>js/blockui.js"></script>
            <script type='text/javascript' src='<?php echo base_url();?>js/jquery.autocomplete.js'></script>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
                 
<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        <div><a class="bookfrm-daysheetbtn" href="<?php echo base_url();?>daysheet" target="_blank">DaySheet</a></div>
        <form name="book_form" method="post" action="add" onSubmit="return addValidate()">
         <!-- <form name="book_form" method="post" action="add"> -->
         <?php
            
            //  cancel checkbox checked
           $cancel_book = $book_row[0]['cancel_book'];
                 $dep_checked = '';
                 $arr_checked = '';
             
             if($cancel_book==1) {
                 $dep_checked = 'checked'; // check box
             }
             else if($cancel_book==2) {
                 $arr_checked = 'checked'; // check box
             }
             else if($cancel_book==3) {
                 $arr_checked = 'checked';
                 $dep_checked = 'checked';
                 
             }
         $book_dir = $book_row[0]['direction'];
         
         if($book_row[0]['type']=='AP') $book_type = 1;
         else if($book_row[0]['type']=='DH') $book_type = 2;
         else if($book_row[0]['type']=='CQ') $book_type = 3;
         else if($book_row[0]['type']=='CS') $book_type = 4;
         else if($book_row[0]['type']=='Other') $book_type = 5;
         
         // config decimal pointer
                            $decimal_pointer = $this->config->item('decimal_point');
                            $dec_point = $decimal_pointer['point'];
                            $prg = $decimal_pointer['prr'];
                            $dollar = $decimal_pointer['dollar'];
                            
         
         ?>
         
        <div class="page-head"><img src="<?php echo base_url();?>images/new-client.png" /><span class="page-headlbl"><?php if($book_row[0]['id']) echo 'EDIT BOOKING'; else echo 'ADD BOOKING'; ?></span></div>
        
        <div class="booking-style-content">
            
            <div class="topselection">
            <table class="tbl-booking" width="100%" cellpadding="0" cellspacing="0">
            
                <tr>
                    
                    <td width="25%">Create a new booking for:</td>

                    <td width="75%">
                        <select name="type" id="new-book" onChange="newBook(this.value,'<?php if(isset($_GET['cid'])) echo $_GET['cid']; ?>','<?php echo $book_row[0]['id']; ?>','<?php echo $book_row[0]['client']; ?>')" style="width: 300px; height: 25px;">
                            <option value="0">Select</option>
                            <option value="1" <?php if($book_row[0]['type']=='AP') echo 'selected'; ?>>The Airport</option>
                            <option value="2" <?php if($book_row[0]['type']=='DH') echo 'selected'; ?>>White Bay</option>
                            <option value="3" <?php if($book_row[0]['type']=='CQ') echo 'selected'; ?>>Circular Quay</option>
                            <option value="4" <?php if($book_row[0]['type']=='CS') echo 'selected'; ?>>Central Station</option>
                            <option value="5" <?php if($book_row[0]['type']=='Other') echo 'selected'; ?>>Other</option>
                        </select>
                        <input type="hidden" name="cancel_bookval" id="cancel-bookval" value="<?php if($book_row[0]['type']=='AP') echo '1'; else if($book_row[0]['type']=='DH') echo '2'; else if($book_row[0]['type']=='CQ') echo '3'; else if($book_row[0]['type']=='CS') echo '4'; if($book_row[0]['type']=='Other') echo '5'; ?>" />
                        
                        <input type="hidden" name="latest_bookid" id="latest_bookid" value="<?php echo $empty_book; ?>" />
                        
                    </td>

                </tr>

            </table>
            </div>
            
        <!-- Airport -->
        <div id="airport-opt" style="display: block;">
            
            <div class="topselection">
                
            <table class="tbl-booking" width="100%" cellpadding="0" cellspacing="0">
                
                <tr>
                    <td width="25%">Choose option:</td>
                    
                    <td width="75%">
                        
                        <table width="60%" border="0" cellspacing="0" cellpadding="0"><tr>
                        <td><input type="radio" name="airport_str" <?php if($book_row[0]['direction']=='departure') echo 'checked="checked"'; ?> onClick="viewForm('air-dep',document.getElementById('new-book').value)"/>&nbsp;&nbsp;Departure</td>
                        <td><input type="radio" name="airport_str" <?php if($book_row[0]['direction']=='arrival') echo 'checked="checked"'; ?> onClick="viewForm('air-arr',document.getElementById('new-book').value)"/>&nbsp;&nbsp;Arrival</td>
                        <td><input type="radio" name="airport_str" <?php if($book_row[0]['direction']=='both') echo 'checked="checked"'; ?> onClick="viewForm('air-both',document.getElementById('new-book').value)"/>&nbsp;&nbsp;Both</td>
                        </tr></table>
                    </td>
                    
                </tr>
                
            </table>
            
        </div>
        
           </div> 
        </div>

        <div id="airport-form-content" style="display: none;">
            
          <div class="booking-style-content">    
              
              <div class="topselection">
                  
                            <table class="tbl-booking" width="100%" cellpadding="0" cellspacing="0" style="margin-top: -22px;">
                                <tr>
                                    
                                    <td width="25%">ID: &nbsp;</td>
                                <td width="75%">
                                    <?php if($book_row[0]['id']) echo $book_row[0]['id']; else echo 'New'; ?>
                                    <input type="hidden" name="direction" id="direction_val" />
                                    <input type="hidden" name="get-direction" id="get-direction" />
                                    <input type="hidden" name="modeval" id="modeval" value="common" />
                                    <input type="hidden" name="countval[]" id="countval" />
                                    <input type="hidden" name="mailconfirm" id="mailconfirm" value="noneed" />
                                    
                                    <input type="hidden" name="hiddepcheck" id="hiddepcheck" value="no" />
                                    <input type="hidden" name="hidarrcheck" id="hidarrcheck" value="no" />
                                    
                                </td>
                                </tr>
                                <?php if($book_row[0]['id']) { ?>
                                <tr>
                                    <td>Registration Type: &nbsp;</td>
                                    <td><?php if($book_row[0]['book_type']=='1') echo 'Online'; else echo 'Phone / Email'; ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                <td>Client: <span class="red-star">*</span></td>
                                <td>
                                    <input type="hidden" name="book_id" id="book_id" value="<?php echo $book_row[0]['id']; ?>" />
                                    <input type="hidden" name="clientval" id="client_val" value="<?php echo $book_row[0]['client']; ?>"/>
                                    <?php
                                    $cliname = '';
                                        if($book_row[0]['client']!='') {
                                            $cliname = $book_row[0]['first_name'].' '.$book_row[0]['last_name'];
                                            $clisuburb = $book_row[0]['suburb'];
											//$cliphone = $book_row[0]['phone']; //ACorr add mobile to search
                                        }
                                    ?>
                                    <input type="text" name="client" id="client" autocomplete="off" value="<?php if($cliname) echo trim($cliname).' ('.$clisuburb.')'; ?>" style="width: 285px; padding: 5px;" onkeyup="return hideClientform(this.value)"/>
                                    
                                    <div class="suggestionsBox" id="suggestions" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                                        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
                                      </div>
                                    
                                    <?php
                                        if(!empty($book_row[0]['id'])) $cli_mode = 'add';
                                        else $cli_mode = 'add';
                                    ?>
                                    <a href="javascript:;" onclick="addNewclient('<?php echo $cli_mode; ?>','','')" class="newclient-title">Add client</a>
                                    <br/><span style="font-size: 10px; color: gray;">Start typing to view existing clients</span>
                                </td>
                                </tr>
                                
                            </table>
          </div>
            
        </div>
            
            <!-- Client content -->
            <div id="client-content" style="display: none;">
                <div id="add-client"></div>
                
                <input type="hidden" name="clitype" id="clitype" />
                <div align="center" id="client-save-btn"><input type="button" name="client_btn" id="client-btn" value="Save" class="bgbtn" onclick="return clientSave()"/></div>
                <div class="bottom-line">&nbsp;</div>
            </div>
            
            <!-- Client content end -->
        
<!-- Option Both start -->
<div class="lftpanel" id="dep-form-content" style="display: none;" align="center">
    <div id="departure_contents" style="display: none;">
<h2 style="color:#0D7FBC !important;">Departure</h2>
<?php if($book_row[0]['id']!='') { ?>
    <span style="float: left; padding: 10px; margin-top: -20px;">
        <input type="checkbox" name="depcancel" id="depcancel" value="1" <?php echo $dep_checked; ?> onclick="depcancelClick('<?php echo $book_dir; ?>')" />Cancel
    </span>
<?php } ?>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
    
  <tr class="heading">
    <td colspan="2"><span id="dep-pickup-head">Address Details</span></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" width="40%">Suburb:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="60%">
                                                    <input type="text" name="dep_suburb[]" id="dep-suburb" autocomplete="off" value="<?php echo $book_row[0]['dep_suburb']; ?>" />
                                                    <div class="suggestionsBox-sub" id="suggestions-sub" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                                                        <div class="suggestionList" id="suggestionsList-sub"> &nbsp; </div>
                                                      </div>
    </td>
  </tr>
  <tr>
    <td align="left">Address1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="dep_address1[]" id="dep-address1" value="<?php echo $book_row[0]['dep_address1']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Address2</td>
    <td align="left"><input type="text" name="dep_address2[]" id="dep-address2" value="<?php echo $book_row[0]['dep_address2']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Contact Number1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="dep_mobile[]" id="dep-mobile" value="<?php if($book_row[0]['dep_mobile']!='0') echo $book_row[0]['dep_mobile']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
    <td align="left">Contact Number2:</td>
    <td align="left"><input type="text" name="dep_phone[]" id="dep-phone" value="<?php if($book_row[0]['dep_phone']!='0') echo $book_row[0]['dep_phone']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
      <td colspan="2" align="center">
                                         <div id="showpickup" style="max-height: 200px; overflow: auto;">
                                         <?php 
                                         $getpickup = $this->common_model->showPickup($book_row[0]['id'],'dep',$book_type,'pickup');

                                            if(count($getpickup)>0) {
                                         ?>
                                                <table width="100%" class="popup-table-contents" bgcolor="#f2f2f2">
                                                    <!-- <th>Client</th> -->
                                                    <th>Suburb</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th colspan="2">Action</th>
                                                    <?php for($k=0; $k<count($getpickup); $k++) { ?>
                                                    <tr>
                                                        
                                                        <td><?php echo $getpickup[$k]['suburb']; ?></td>
                                                        <td><?php echo $getpickup[$k]['address1']; ?></td>
                                                        <td><?php echo $getpickup[$k]['mobile']; ?></td>
                                                        <td align="center"><a href="javascript:;" class="showpickup" onclick="editPickup('<?php echo $getpickup[$k]['id']; ?>','<?php echo $getpickup[$k]['suburb']; ?>','<?php echo $getpickup[$k]['address1']; ?>','<?php echo $getpickup[$k]['address2']; ?>','<?php echo $getpickup[$k]['phone']; ?>','<?php echo $getpickup[$k]['mobile']; ?>','<?php echo $getpickup[$k]['passengers']; ?>','<?php echo $getpickup[$k]['comment']; ?>','<?php echo $getpickup[$k]['drop_suburb']; ?>','<?php echo $getpickup[$k]['drop_address1']; ?>','<?php echo $getpickup[$k]['drop_address2']; ?>','<?php echo $getpickup[$k]['drop_phone']; ?>','<?php echo $getpickup[$k]['drop_mobile']; ?>','<?php echo $getpickup[$k]['drop_passengers']; ?>','<?php echo $getpickup[$k]['drop_comment']; ?>','<?php echo $getpickup[$k]['direction']; ?>','<?php echo $getpickup[$k]['destination']; ?>','<?php echo $getpickup[$k]['est']; ?>','<?php echo $getpickup[$k]['dep_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
                                                        <td align="center"><a href="javascript:;" class="showpickup" onclick="delPickup('<?php echo $getpickup[$k]['id']; ?>','<?php echo $getpickup[$k]['book_id']; ?>','dep','<?php echo $book_type; ?>','pickup')" ><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                         <?php } ?>
                                        </div>
                                        <a href="javascript:;" id="my-button" nowrap onclick="arrpickupAddress('deppickup')">Add More Pickup Address</a>
          
      </td>
  </tr>
</table>

<!-- Other drop of address -->
<div id="other-dep-dropoff">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
    
  <tr class="heading">
    <td colspan="2">Drop-off Address Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" width="40%">Suburb:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="60%">
                                                    <input type="text" name="dep_drop_suburb[]" id="dep-drop-suburb" autocomplete="off" value="<?php echo $book_row[0]['dep_drop_suburb']; ?>" />
                                                    <div class="suggestionsBox-sub" id="suggestions-sub" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                                                        <div class="suggestionList" id="suggestionsList-sub"> &nbsp; </div>
                                                      </div>
    </td>
  </tr>
  <tr>
    <td align="left">Address1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="dep_drop_address1[]" id="dep-drop-address1" value="<?php echo $book_row[0]['dep_drop_address1']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Address2</td>
    <td align="left"><input type="text" name="dep_drop_address2[]" id="dep-drop-address2" value="<?php echo $book_row[0]['dep_drop_address2']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Contact Number1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="dep_drop_mobile[]" id="dep-drop-mobile" value="<?php if($book_row[0]['dep_drop_mobile']!='0') echo $book_row[0]['dep_drop_mobile']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
    <td align="left">Contact Number2:</td>
    <td align="left"><input type="text" name="dep_drop_phone[]" id="dep-drop-phone" value="<?php if($book_row[0]['dep_drop_phone']!='0') echo $book_row[0]['dep_drop_phone']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
      <td colspan="2" align="center">
                                         <div id="showpickup-depdrop" style="max-height: 200px; overflow: auto;">
                                         <?php 
                                         $getdepdrop = $this->common_model->showPickup($book_row[0]['id'],'dep',$book_type,'drop');
                                            if(count($getdepdrop)>0) {
                                         ?>
                                                <table width="100%" class="popup-table-contents" bgcolor="#f2f2f2">
                                                    <!-- <th>Client</th> -->
                                                    <th>Suburb</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th>Action</th>
                                                    <?php for($k=0; $k<count($getdepdrop); $k++) { ?>
                                                    <tr>
                                                        
                                                        <td><?php echo $getdepdrop[$k]['drop_suburb']; ?></td>
                                                        <td><?php echo $getdepdrop[$k]['drop_address1']; ?></td>
                                                        <td><?php echo $getdepdrop[$k]['drop_mobile']; ?></td>
                                                        <td align="center"><a href="javascript:;" class="showpickup-depdrop" onclick="editPickup('<?php echo $getdepdrop[$k]['id']; ?>','<?php echo $getdepdrop[$k]['suburb']; ?>','<?php echo $getdepdrop[$k]['address1']; ?>','<?php echo $getdepdrop[$k]['address2']; ?>','<?php echo $getdepdrop[$k]['phone']; ?>','<?php echo $getdepdrop[$k]['mobile']; ?>','<?php echo $getdepdrop[$k]['passengers']; ?>','<?php echo $getdepdrop[$k]['comment']; ?>','<?php echo $getdepdrop[$k]['drop_suburb']; ?>','<?php echo $getdepdrop[$k]['drop_address1']; ?>','<?php echo $getdepdrop[$k]['drop_address2']; ?>','<?php echo $getdepdrop[$k]['drop_phone']; ?>','<?php echo $getdepdrop[$k]['drop_mobile']; ?>','<?php echo $getdepdrop[$k]['drop_passengers']; ?>','<?php echo $getdepdrop[$k]['drop_comment']; ?>','<?php echo $getdepdrop[$k]['direction']; ?>','<?php echo $getdepdrop[$k]['destination']; ?>','<?php echo $getdepdrop[$k]['est']; ?>','<?php echo $getdepdrop[$k]['drop_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
                                                        <td align="center"><a href="javascript:;" class="showpickup-depdrop" onclick="delPickup('<?php echo $getdepdrop[$k]['id']; ?>','<?php echo $getdepdrop[$k]['book_id']; ?>','dep','<?php echo $book_type; ?>','drop')" title="delete"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                         <?php } ?>
                                        </div>
                                        <a href="javascript:;" id="my-drop-button" nowrap onclick="arrpickupAddress('depdrop')">Add More Drop-off Address</a>
          
      </td>
  </tr>
</table>
    
</div>
<!-- Other drop of address end -->
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr class="heading">
    <td colspan="2">Passenger Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" width="40%">Passengers:</td>
    <td align="left" width="60%">
                                            <select name="dep_passengers[]" id="dep-passengers" onchange="getPassengers(this.value,0)">
                                                <option value="0">Select</option>
                                                <?php
                                                    for($i=1;$i<11;$i++) {
                                                ?>
                                                    <option value="<?php echo $i; ?>" <?php if($book_row[0]['dep_passengers']==$i || $i==1) echo 'selected'; ?>><?php if($i==10) echo 'Charter'; else echo $i; ?></option>
                                                <?php } ?>
                                            </select>
    </td>
  </tr>
  <tr>
    <td align="left">Baby Seats:</td>
    <td align="left">
                                            <select name="dep_babyseats[]" id="dep-babyseats" onchange="getBaby(this.value,0)">
                                                <option value="0">Select</option>
                                                <?php
                                                    for($i=1;$i<4;$i++) {
                                                ?>
                                                    <option value="<?php echo $i; ?>" <?php if($book_row[0]['dep_babyseats']==$i) echo 'selected'; ?>><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div id="airport-depfields">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr class="heading">
    <td colspan="2">Flight Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td align="left" width="38%">Flight:<span style="color: red; font-size: 12px;">&nbsp;</span></td>
    <td align="left" width="59%"><input type="text" name="dep_flight[]" id="dep-flight" value="<?php echo $book_row[0]['dep_flight']; ?>" onkeyup="getFlight(this.value,0);" autocomplete="off" style="text-transform: uppercase;"/></td>
  </tr>
  <tr>
   <td align="left">Origin / Dest:</td>
    <td align="left">
                                                    <!-- <div id="deporigin-val"><?php //if($book_row[0]['dep_origin']!='<span>flight not found</span>' && $book_row[0]['dep_origin']!='') echo $book_row[0]['dep_origin']; else { ?><span class="ferror">Flight not found</span><?php // } ?></div> -->
                                                    <div id="deporigin-val"><?php if($book_row[0]['dep_origin']!='<span>flight not found</span>' && $book_row[0]['dep_origin']!='') echo $book_row[0]['dep_origin']; ?></div>
                                                    <input type="hidden" name="dep_origin[]" id="dep-origin" value="<?php echo $book_row[0]['dep_origin']; ?>"/>
    </td>
  </tr>
  <tr>
    <td align="left">Airline:</td>
    <td align="left"><input type="text" name="dep_airline[]" id="dep-airline" value="<?php echo $book_row[0]['dep_airline']; ?>"/></td>
  </tr>
  <tr>
    <td align="left">Terminal:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><span id="dep_bothterm"><input type="radio" name="dep_terminal[]" value="Dom" id="dep-dom" <?php if($book_row[0]['dep_terminal']=='Dom') echo 'checked'; ?>/>Domestic<input type="radio" name="dep_terminal[]" value="Int" id="dep-int" <?php if($book_row[0]['dep_terminal']=='Int') echo 'checked'; ?>/>International</span></td>
  </tr>
</table>
</div>
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr>
    <td align="left" width="38%">Date:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="59%"><input type="text" name="dep_date[]" id="dep-date" value="<?php if($book_row[0]['dep_date']!='0000-00-00' && $book_row[0]['dep_date']!='') echo date('d/m/Y',strtotime($book_row[0]['dep_date'])); ?>" onclick="dateDirec('D')"/></td>
  </tr>
</table>
<div id="airport-dep-flight">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr>
    <td align="left" width="38%">Departure Flight Time:</td>
    <td align="left" width="59%"><input type="text" name="dep_ourtime[]" id="dep-ourtime" value="<?php echo $book_row[0]['dep_ourtime']; ?>"/></td>
  </tr>
</table>
</div>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr class="heading">
    <td colspan="2">Pickup Time Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

 <div id="airport-time-depfields">
<!-- <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr>
    <td align="left" width="38%">Itinerary Time:</td>
    <td align="left" width="59%">
                                        <?php /*
                                        $yourhours = '';
                                        $yourmin = '';
                                        $youram = '';
                                        
                                            if($book_row[0]['dep_yourtime']!='') {
                                                $exp_yourtime = explode(':',$book_row[0]['dep_yourtime']);
                                                $yourhours = $exp_yourtime[0];
                                                //$yourmin = substr($exp_yourtime[1],0,-2);
                                                $yourmin = $exp_yourtime[1];
                                                if($yourmin==0) $yourmin = '00';
                                                $youram = substr($exp_yourtime[1],2);
                                               // print_r($yourmin);
                                            } */
                                        ?>
                                        <select name="dep_yourhours[]" id="dep-yourhours">
                                            <option value="0">Hours</option>
                                            <?php /*
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($yourhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            } */
                                            ?>
                                        </select>
                                        
                                        <select name="dep_yourmin[]" id="dep-yourmin">
                                            <option value="0">Minutes</option>
                                            <?php /*
                                            for($i=0;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php  if(!empty($yourmin) && $yourmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            } */
                                            ?>
                                        </select>
    </td>
  </tr>
</table> -->
</div>

<div id="non-airport-depfields">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr>
    <td align="left" width="38%">Boarding Time:</td>
    <td align="left" width="59%">
                                        <?php
                                        $thours = '';
                                        $tmin = '';
                                        $tam = '';
                                        
                                            if($book_row[0]['dep_time']!='') {
                                                $exp_time = explode(':',$book_row[0]['dep_time']);
                                                $thours = $exp_time[0];
                                                //$tmin = substr($exp_time[1],0,-2);
                                                $tmin = $exp_time[1];
                                                if($tmin==0) $tmin = '00';
                                                $tam = substr($exp_time[1],2);
                                             //   print_r($yourmin);
                                            }
                                        ?>
                                        
                                        <select name="dep_time[]" id="dep-time">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($thours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="dep_tmin[]" id="dep-tmin">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=0;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($tmin) && $tmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
    </td>
  </tr>
</table>
</div>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr>
    <td align="left" width="38%">Pickup time:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="59%">
                                        <?php
                                        $pickhours = '';
                                        $pickmin = '';
                                        $pickam = '';
                                        
                                            if($book_row[0]['dep_pickuptime']!='') {
                                                $exp_picktime = explode(':',$book_row[0]['dep_pickuptime']);
                                                $pickhours = $exp_picktime[0];
                                                //$pickmin = substr($exp_picktime[1],0,-2);
                                                $pickmin = $exp_picktime[1];
                                                if($pickmin==0) $pickmin = '00';
                                                $pickam = substr($exp_picktime[1],2);
                                             //   print_r($yourmin);
                                            }
                                            
                                        ?>
                                        
                                        <select name="dep_pickhours[]" id="dep-pickhours" onchange="depEstcharge(this.value)">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($pickhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="dep_pickmin[]" id="dep-pickmin">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=0;$i<60;$i+=15) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($pickmin) && $pickmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
   </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="heading">
    <td colspan="2">Other Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">Comments:</td>
    <td align="left"><textarea name="dep_comments[]" id="dep-comments" cols="20" rows="3"><?php echo $book_row[0]['dep_comments']; ?></textarea></td>
  </tr>
  <tr>
    <td align="left">Estimated Fare:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left">
                                         <input type="text" name="dep_estfare[]" id="dep-estfare" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', ''); ?>" onkeyup="getTotalestimate()" onclick="depestDollar()" autocomplete="off"/>
                                        <!-- <input type="text" name="dep_estfare[]" id="mandep-estfare" value="<?php //echo $book_row[0]['dep_estfare']; ?>" autocomplete="off"/> -->
                                        <input type="hidden" name="depautoest[]" id="depautoest" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', ''); ?>"/>
    </td>
  </tr>
  <tr>
    <td align="left">Driver:</td>
    <td align="left">
                                                                          <?php
                                                                                        $options = $getdriverval;
                                                                                        $opt = 'id="dep_driver"';
                                                                                        $optval = $book_row[0]['dep_driver'];
                                                                                         echo form_dropdown('dep_driver[]', $options,$optval,$opt);
                                                                          ?>
        
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>

</div>
</div>
    
<div class="clear clearfix"></div>


<div class="ritpanel" id="arr-form-content" style="display: none;" align="center">
    <div id="arrival_contents" style="display: none;">
    <h2 style="color:#0D7FBC !important;">Arrival</h2>
    
  <?php if($book_row[0]['id']!='') { ?>  
    <span style="float: left; padding: 10px; margin-top: -20px;">
        <input type="checkbox" name="arrcancel" id="arrcancel" value="2" <?php echo $arr_checked; ?> onclick="arrcancelClick('<?php echo $book_dir; ?>')" />Cancel
    </span>
    <div style="clear: both;"></div>
    <?php } ?>
    
    <!-- other Pickup off address -->
    <div id="other-arr-dropoff">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">
  <tr class="heading">
    <td colspan="2">Pickup Address Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" width="40%">Suburb:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="60%">
                                                    <input type="text" name="arr_drop_suburb[]" id="arr-drop-suburb" autocomplete="off" value="<?php echo $book_row[0]['arr_drop_suburb']; ?>" />
    </td>
  </tr>
  <tr>
    <td align="left">Address1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="arr_drop_address1[]" id="arr-drop-address1" value="<?php echo $book_row[0]['arr_drop_address1']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Address2</td>
    <td align="left"><input type="text" name="arr_drop_address2[]" id="arr-drop-address2" value="<?php echo $book_row[0]['arr_drop_address2']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Contact Number1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="arr_drop_mobile[]" id="arr-drop-mobile" value="<?php if($book_row[0]['arr_drop_mobile']!='0') echo $book_row[0]['arr_drop_mobile']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
    <td align="left">Contact Number2:</td>
    <td align="left"><input type="text" name="arr_drop_phone[]" id="arr-drop-phone" value="<?php if($book_row[0]['arr_drop_phone']!='0') echo $book_row[0]['arr_drop_phone']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
      <td colspan="2" align="center">
                                         <div id="showdropoff-arrpick" style="max-height: 200px; overflow: hidden;">
                                         <?php 
                                         $getarrpickup = $this->common_model->showPickup($book_row[0]['id'],'arr',$book_type,'pickup');
                                            if(count($getarrpickup)>0) {
                                         ?>
                                                <table width="100%" class="popup-table-contents" bgcolor="#dddddd">
                                                    <th>Suburb</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th>Action</th>
                                                    <?php for($k=0; $k<count($getarrpickup); $k++) { ?>
                                                    <tr>
                                                        <td><?php echo $getarrpickup[$k]['drop_suburb']; ?></td>
                                                        <td><?php echo $getarrpickup[$k]['drop_address1']; ?></td>
                                                        <td><?php echo $getarrpickup[$k]['drop_mobile']; ?></td>
                                                        <td align="center"><a href="javascript:;" class="showdropoff-arrpick" onclick="editPickup('<?php echo $getarrpickup[$k]['id']; ?>','<?php echo $getarrpickup[$k]['suburb']; ?>','<?php echo $getarrpickup[$k]['address1']; ?>','<?php echo $getarrpickup[$k]['address2']; ?>','<?php echo $getarrpickup[$k]['phone']; ?>','<?php echo $getarrpickup[$k]['mobile']; ?>','<?php echo $getarrpickup[$k]['passengers']; ?>','<?php echo $getarrpickup[$k]['comment']; ?>','<?php echo $getarrpickup[$k]['drop_suburb']; ?>','<?php echo $getarrpickup[$k]['drop_address1']; ?>','<?php echo $getarrpickup[$k]['drop_address2']; ?>','<?php echo $getarrpickup[$k]['drop_phone']; ?>','<?php echo $getarrpickup[$k]['drop_mobile']; ?>','<?php echo $getarrpickup[$k]['drop_passengers']; ?>','<?php echo $getarrpickup[$k]['drop_comment']; ?>','<?php echo $getarrpickup[$k]['direction']; ?>','<?php echo $getarrpickup[$k]['destination']; ?>','<?php echo $getarrpickup[$k]['est']; ?>','<?php echo $getarrpickup[$k]['drop_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
                                                        <td align="center"><a href="javascript:;" class="showdropoff-arrpick" onclick="delPickup('<?php echo $getarrpickup[$k]['id']; ?>','<?php echo $getarrpickup[$k]['book_id']; ?>','arr','<?php echo $book_type; ?>','pickup')" title="delete"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                         <?php } ?>
                                        </div>
                                        <a href="javascript:;" id="arrmy-drop-button" nowrap onclick="arrpickupAddress('arrpickup')">Add More Pickup Address</a>
          
      </td>
  </tr>
</table>
        
    </div>
    <!-- other pickup address end -->
    
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">
  <tr class="heading">
    <td colspan="2"><span id="arr-pickup-head">Address Details</span></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" width="40%">Suburb:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="60%">
                                                    <input type="text" name="arr_suburb[]" id="arr-suburb" autocomplete="off" value="<?php echo $book_row[0]['arr_suburb']; ?>" />
                                                    <div class="suggestionsBox-sub" id="suggestions-arrsub" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                                                        <div class="suggestionList" id="suggestionsList-arrsub"> &nbsp; </div>
                                                      </div>
    </td>
  </tr>
  <tr>
    <td align="left">Address1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="arr_address1[]" id="arr-address1" value="<?php echo $book_row[0]['arr_address1']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Address2</td>
    <td align="left"><input type="text" name="arr_address2[]" id="arr-address2" value="<?php echo $book_row[0]['arr_address2']; ?>" /></td>
  </tr>
  <tr>
    <td align="left">Contact Number1:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><input type="text" name="arr_mobile[]" id="arr-mobile" value="<?php if($book_row[0]['arr_mobile']!='0') echo $book_row[0]['arr_mobile']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
    <td align="left">Contact Number2:</td>
    <td align="left"><input type="text" name="arr_phone[]" id="arr-phone" value="<?php if($book_row[0]['arr_phone']!='0') echo $book_row[0]['arr_phone']; ?>" onkeypress="return numeric(event)"/></td>
  </tr>
  <tr>
      <td colspan="2" align="center">
                                         <div id="showdropoff" style="max-height: 200px; overflow: hidden;">
                                         <?php
                                         $getdropoff = $this->common_model->showPickup($book_row[0]['id'],'arr',$book_type,'drop');
                                            if(count($getdropoff)>0) {
                                         ?>
                                                <table width="100%" class="popup-table-contents" bgcolor="#dddddd">
                                                    <th>Suburb</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th>Action</th>
                                                    <?php for($k=0; $k<count($getdropoff); $k++) { ?>
                                                    <tr>
                                                        <td><?php echo $getdropoff[$k]['suburb']; ?></td>
                                                        <td><?php echo $getdropoff[$k]['address1']; ?></td>
                                                        <td><?php echo $getdropoff[$k]['mobile']; ?></td>
                                                        <td align="center"><a href="javascript:;" class="showdropoff" onclick="editPickup('<?php echo $getdropoff[$k]['id']; ?>','<?php echo $getdropoff[$k]['suburb']; ?>','<?php echo $getdropoff[$k]['address1']; ?>','<?php echo $getdropoff[$k]['address2']; ?>','<?php echo $getdropoff[$k]['phone']; ?>','<?php echo $getdropoff[$k]['mobile']; ?>','<?php echo $getdropoff[$k]['passengers']; ?>','<?php echo $getdropoff[$k]['comment']; ?>','<?php echo $getdropoff[$k]['drop_suburb']; ?>','<?php echo $getdropoff[$k]['drop_address1']; ?>','<?php echo $getdropoff[$k]['drop_address2']; ?>','<?php echo $getdropoff[$k]['drop_phone']; ?>','<?php echo $getdropoff[$k]['drop_mobile']; ?>','<?php echo $getdropoff[$k]['drop_passengers']; ?>','<?php echo $getdropoff[$k]['drop_comment']; ?>','<?php echo $getdropoff[$k]['direction']; ?>','<?php echo $getdropoff[$k]['destination']; ?>','<?php echo $getdropoff[$k]['est']; ?>','<?php echo $getdropoff[$k]['drop_est']; ?>')" ><img src="<?php echo base_url();?>images/edit.png" title="edit"/></a></td>
                                                        <td align="center"><a href="javascript:;" class="showdropoff" onclick="delPickup('<?php echo $getdropoff[$k]['id']; ?>','<?php echo $getdropoff[$k]['book_id']; ?>','arr','<?php echo $book_type; ?>','drop')"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                         <?php } ?>
                                        </div>
                                        <!-- <span id="arr-pickup-lable"></span>-->
                                        <a href="javascript:;" id="arrmy-button" nowrap onclick="arrpickupAddress('arrdrop')">Add More Drop-off Address</a>
          
      </td>
  </tr>
</table>
  
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">    
  <tr class="heading">
    <td colspan="2">Passenger Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" width="40%">Passengers:</td>
                                    <td align="left" width="60%">
                                        <select name="arr_passengers[]" id="arr-passengers" onchange="getPassengers(this.value,1)">
                                            <option value="0">Select</option>
                                            <?php
                                                for($i=1;$i<11;$i++) {
                                            ?>
                                                <option value="<?php echo $i; ?>" <?php if($book_row[0]['arr_passengers']==$i  || $i==1) echo 'selected'; ?>><?php if($i==10) echo 'Charter'; else echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
  </tr>
  <tr>
    <td align="left">Baby Seats:</td>
                                    <td align="left">
                                        <select name="arr_babyseats[]" id="arr-babyseats" onchange="getBaby(this.value,1)">
                                            <option value="0">Select</option>
                                            <?php
                                                for($i=1;$i<4;$i++) {
                                            ?>
                                                <option value="<?php echo $i; ?>" <?php if($book_row[0]['arr_babyseats']==$i) echo 'selected'; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    
<div id="airport-arrfields">    
    <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">
  <tr class="heading">
    <td colspan="2">Flight Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td align="left" width="38%">Flight:<span style="color: red; font-size: 12px;">&nbsp;</span></td>
    <td align="left" width="59%"><input type="text" name="arr_flight[]" id="arr-flight" value="<?php echo $book_row[0]['arr_flight']; ?>" onkeyup="getFlight(this.value,1);" autocomplete="off" style="text-transform: uppercase;"/></td>
  </tr>
  <tr>
   <td align="left">Origin / Dest:</td>
                                                <td align="left">
                                                    <!-- <div id="arrorigin-val"><?php //if($book_row[0]['arr_origin']!='<span>flight not found</span>' && $book_row[0]['arr_origin']!='') echo $book_row[0]['arr_origin']; else { ?><span class="ferror">Flight not found</span><?php // } ?></div> -->
                                                    <div id="arrorigin-val"><?php if($book_row[0]['arr_origin']!='<span>flight not found</span>' && $book_row[0]['arr_origin']!='') echo $book_row[0]['arr_origin']; ?></div>
                                                    <input type="hidden" name="arr_origin[]" id="arr-origin" value="<?php echo $book_row[0]['arr_origin']; ?>"/>
                                                </td>
  </tr>
  <tr>
    <td align="left">Airline:</td>
    <td align="left"><input type="text" name="arr_airline[]" id="arr-airline" value="<?php echo $book_row[0]['arr_airline']; ?>"/></td>
  </tr>
  <tr>
    <td align="left">Terminal:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left"><span id="arr_bothterm"><input type="radio" name="arr_terminal[]" value="Dom" id="arr-dom" <?php if($book_row[0]['arr_terminal']=='Dom') echo 'checked'; ?>/>Domestic<input type="radio" name="arr_terminal[]" value="Int" id="arr-int" <?php if($book_row[0]['arr_terminal']=='Int') echo 'checked'; ?>/>International</span></td>
  </tr>
</table>
</div>
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">    
  <tr>
    <td align="left" width="38%">Date:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="59%"><input type="text" name="arr_date[]" id="arr-date" value="<?php if($book_row[0]['arr_date']!='0000-00-00' && $book_row[0]['arr_date']!='') echo date('d/m/Y',strtotime($book_row[0]['arr_date'])); ?>" onclick="dateDirec('A')"/></td>
  </tr>
</table>
<div id="airport-arr-flight">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">    
  <tr>
    <td align="left" width="38%">Arrival Flight Time:</td>
    <td align="left" width="59%"><input type="text" name="arr_ourtime[]" id="arr-ourtime" value="<?php echo $book_row[0]['arr_ourtime'] ?>"/></td>
  </tr>
    </table>
</div>
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">    
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    
    <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">
  <tr class="heading">
    <td colspan="2">Pickup Time Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    </table>
    
    <div id="airport-time-arrfields">
  <!--  <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">
  <tr>
    <td align="left" width="38%">Itinerary Time:</td>
    <td align="left" width="59%">
                                        <?php /*
                                        $arryourhours = '';
                                        $arryourmin = '';
                                        $arryouram = '';
                                        
                                            if($book_row[0]['arr_yourtime']!='') {
                                                $exp_yourtime = explode(':',$book_row[0]['arr_yourtime']);
                                                $arryourhours = $exp_yourtime[0];
                                               // $arryourmin = substr($exp_yourtime[1],0,-2);
                                                 $arryourmin = $exp_yourtime[1];
                                                 if($arryourmin==0) $arryourmin = '00';
                                                $arryouram = substr($exp_yourtime[1],2);
                                             //   print_r($yourmin);
                                            } */
                                        ?>
                                        <select name="arr_yourhours[]" id="arr-yourhours">
                                            <option value="0">Hours</option>
                                            <?php /* 
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arryourhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            } */
                                            ?>
                                        </select>
                                        
                                        <select name="arr_yourmin[]" id="arr-yourmin">
                                            <option value="0">Minutes</option>
                                            <?php /*
                                            for($i=0;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($arryourmin) && $arryourmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            } */
                                            ?>
                                        </select>
                                        
    </td>
  </tr>
    </table> -->
</div> 

<div id="non-airport-arrfields">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">
  <tr>
    <td align="left" width="38%">Docking Time:</td>
    <td align="left" width="59%">
                                        <?php
                                        $arrthours = '';
                                        $arrtmin = '';
                                        $arrtam = '';
                                        
                                            if($book_row[0]['arr_time']!='') {
                                                $arrexp_time = explode(':',$book_row[0]['arr_time']);
                                                $arrthours = $arrexp_time[0];
                                                //$arrtmin = substr($arrexp_time[1],0,-2);
                                                $arrtmin = $arrexp_time[1];
                                                if($arrtmin==0) $arrtmin = '00';
                                                $arrtam = substr($arrexp_time[1],2);
                                             //   print_r($yourmin);
                                            }
                                        ?>
                                        
                                        <select name="arr_time[]" id="arr-time">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arrthours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="arr_tmin[]" id="arr-tmin">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=0;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($arrtmin) && $arrtmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
    </td>
  </tr>
</table>
</div>
    
    <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2" style="background:#f4f4f4; text-indent:10px;">
  <tr>
    <td align="left" width="38%">Pickup time:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left" width="59%">
                                        <?php
                                        $arrpickhours = '';
                                        $arrpickmin = '';
                                        $arrpickam = '';
                                        
                                            if($book_row[0]['arr_pickuptime']!='') {
                                                $exp_picktime = explode(':',$book_row[0]['arr_pickuptime']);
                                                $arrpickhours = $exp_picktime[0];
                                               // $arrpickmin = substr($exp_picktime[1],0,-2);
                                                $arrpickmin = $exp_picktime[1];
                                                
                                                    if ($arrpickmin < 05)
                                                        $arrmin = '00';
                                                    else if ($arrpickmin > 05 && $arrpickmin < 10)
                                                        $arrmin = 05;
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
                                                
                                                $arrpickam = substr($exp_picktime[1],2);
                                               // print_r($exp_picktime);
                                            }
                                        ?>
                                        
                                        <select name="arr_pickhours[]" id="arr-pickhours" onchange="arrEstcharge()">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arrpickhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="arr_pickmin[]" id="arr-pickmin" onchange="arrEstcharge()">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=0;$i<60;$i+=5) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($arrmin) && $arrmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="heading">
    <td colspan="2">Other Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">Comments:</td>
    <td align="left"><textarea name="arr_comments[]" id="arr-comments" cols="20" rows="3"><?php echo $book_row[0]['arr_comments']; ?></textarea></td>
  </tr>
  <tr>
    <td align="left">Estimated Fare:<span style="color: red; font-size: 12px;">*</span></td>
    <td align="left">
                                        <input type="text" name="arr_estfare[]" id="arr-estfare" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', ''); ?>" onkeyup="getTotalestimate()" onclick="arrestDollar()" autocomplete="off"/>
                                        <!-- <input type="text" name="arr_estfare[]" id="manarr-estfare" value="<?php //echo $book_row[0]['arr_estfare']; ?>" autocomplete="off"/> -->
                                        <input type="hidden" name="arrautoest[]" id="arrautoest" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', ''); ?>"/>
    </td>
  </tr>
  <tr>
    <td align="left">Driver:</td>
    <td align="left">
                                                                          <?php
                                                                                        $options = $getdriverval;
                                                                                        $opt = 'id="arr_driver"';
                                                                                        $optval = $book_row[0]['arr_driver'];
                                                                                         echo form_dropdown('arr_driver[]', $options,$optval,$opt);
                                                                          ?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
    </table>
    
</div>
</div>
<!-- Option Both end -->  
<br/><br/>
<div style="clear: both;"></div>
<div class="clear clearfix"></div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tbl2">
  <tr class="heading">
    <td colspan="2">Fare Details</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Total Estimated Fare: <span style="color: red; font-size: 12px;">*</span></td>
    <td>
                                        <div id="both-total" style="display: none;"><input type="text" name="total[]" id="fare-total" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['total']), $dec_point, '.', ''); ?>" style="position:relative; left: 7px;"/></div>
                                        
                                        <div id="dep-total" style="display: none;"><input type="text" name="dep-totalval" id="dep-totalval" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', ''); ?>" style="position:relative; left: 7px;"/></div>
                                        
                                        <div id="arr-total" style="display: none;"><input type="text" name="arr-totalval" id="arr-totalval" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', ''); ?>" style="position:relative; left: 7px;"/></div>
                                        
                                        <!-- <input type="text" name="total[]" id="bothfare-total" value="<?php //echo $book_row[0]['total'] ?>" style="position:relative; left: 7px;"/> -->
    </td>
  </tr>
  
  <tr>
    <td align="right">Payment Through:<span style="color: red; font-size: 12px;">&nbsp;</span></td>
    <td>
                                        <select name="paid_status[]" id="paid-status" style="position:relative; left: 7px;">
                                            <option value="0"></option>
                                            <option value="1" <?php if($book_row[0]['paid_status']=='1') echo 'selected'; ?>>Office</option>
                                            <option value="2" <?php if($book_row[0]['paid_status']=='2') echo 'selected'; ?>>Driver</option>
                                        </select>
    </td>
  </tr>
  
  <tr>
    <td align="right">Payment Method:<span style="color: red; font-size: 12px;">&nbsp;</span></td>
    <td>
                                        <select name="payment_method[]" id="payment-method" style="position:relative; left: 7px;">
                                            <option value="0"></option>
                                            <option value="cash" <?php if($book_row[0]['payment_method']=='cash') echo 'selected'; ?>>Cash</option>
                                            <option value="credit card" <?php if($book_row[0]['payment_method']=='credit card') echo 'selected'; ?>>Credit card</option>
                                            <option value="direct debit" <?php if($book_row[0]['payment_method']=='direct debit') echo 'selected'; //ACorr ?>>Direct Debit</option> 
                                        </select>
    </td>
  </tr>
  
</table>

<table width="50%" align="center" border="0" cellpadding="0" cellspacing="0" class="tbl2">
  <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>

            <?php 
                if($book_row[0]['id']) {
                        $created = '';
                        $updated = '';
						
                       
                        if($book_row[0]['created_date']!='0000-00-00 00:00:00') $created = date('d/M/Y',strtotime($book_row[0]['created_date']));
						                        
                        if($book_row[0]['updated_date']!='0000-00-00 00:00:00') $updated = date('d/M/Y',strtotime($book_row[0]['updated_date']));

                ?>
                <tr>
                
                    <td class="field-left">Created by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $book_row[0]['created_by']; ?></td>
                    
                    <td class="field-left">Created date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $created; ?></td>

                </tr>
                
                <tr>
                
                    <td class="field-left">Updated by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $book_row[0]['updated_by']; ?></td>

                    <td class="field-left">Updated date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $updated; ?></td>
                    
                </tr>
                
                <?php } ?> 
                
</table>
            <br/><br/>
            <div align="center">
                <?php 
                    if($book_row[0]['id']!='') $label_mode = 'edit';
                    else $label_mode = 'add';
                    if($this->session->userdata('dynamicbookid')) $current_bookid = $this->session->userdata('dynamicbookid');
                    else $current_bookid = '0';
                ?>
                <input type="submit" name="book" id="bookbtn" value="Save" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="javascript:;" onclick="pageLeft('.$current_bookid.',\''.$label_mode.'\')"><span class="bgbtn">Cancel</span></a>'; ?>
            </div>
<br/><br/>
        </div>
        </form>
        
    </div>
    <!-- Form content end -->
    
</div>
            
<!-- <button id="my-button">POP IT UP</button> -->
            <!-- Element to pop up -->
            <div id="element_to_pop_up" style="display: none; border: 1px solid green; background-color: white;">
                            <span class="button bClose">
                                <span>X</span>
                            </span>
                                
                                    <table width="100%">
                                        <tr>
                                            <th colspan="2" align="center" style="color: #047ea7; font-size: 14px;"><span id="popup-title"></span></th>
                                        </tr>
                                            <tr>
                                                <td class="field-left">Suburb: <span class="red-star">*</span></td>                                                
                                                <td>
                                                    <input type="text" name="pop_suburb" id="pop_suburb" autocomplete="off" />
                                                    <div class="suggestionsBox-sub" id="popsuggestions-sub" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                                                        <div class="suggestionList" id="popsuggestionsList-sub"> &nbsp; </div>
                                                      </div>
                                                    <input type="hidden" name="auto" id="auto" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="field-left">Address1: <span class="red-star">*</span></td>
                                                <td><input type="text" name="pop_address1" id="pop_address1" /></td>
                                            </tr>
                                            <tr>
                                                <td class="field-left">Address2: <span class="red-star">&nbsp;</span></td>
                                                <td><input type="text" name="pop_address2" id="pop_address2" /></td>
                                            </tr>
                                            <tr>
                                                <td class="field-left">Contact Number1: <span class="red-star">*</span></td>
                                                <td><input type="text" name="pop_mobile" id="pop_mobile" onkeypress="return numeric(event)"/></td>
                                            </tr>
                                            <tr>
                                                <td class="field-left">Contact Number2: <span class="red-star">&nbsp;</span></td>
                                                <td><input type="text" name="pop_phone" id="pop_phone" onkeypress="return numeric(event)"/></td>
                                            </tr>
                                            <tr>
                                                <td class="field-left">Passengers: <span class="red-star">&nbsp;</span></td>
                                                <td>
                                                    <select name="pop_passengers" id="pop_passengers">
                                                        <!-- <option value="0">Select</option> -->
                                                        <option value="0">Select</option> <!--Allow 0 passengers ACORR -->
                                                        <?php
                                                            for($i=1;$i<11;$i++) {
                                                        ?>
                                                            <option value="<?php echo $i; ?>"><?php if($i==10) echo 'Charter'; else echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="field-left">Comments: <span class="red-star">&nbsp;</span></td>
                                                <td><textarea name="pop_comment" id="pop_comment" cols="25" rows="4"/></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="field-left">Estimated Fare: <span class="red-star">&nbsp;</span></td>
                                                <td><input type="text" name="pop_est" id="pop_est" /></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <span id="popbtnval"></span>
                                                    <span id="destination-val"></span>
                                                    <input type="button" name="popup-save" id="popup-save" value="Save" class="bgbtn"/>&nbsp;&nbsp;<input type="button" name="popup-cancel" id="popup-cancel" value="Cancel" class="bgbtn bClose"/>
                                                </td>
                                            </tr>
                                    </table>
            </div>
<script type="text/javascript">
    <?php if(empty($book_row[0]['id'])) { ?>

                $(document).ready(function() {

                       $.post("<?php echo base_url(); ?>clients/add", {mode: "booking"}, function(data){     
                              //alert(data);

                              if(data) {
                                  $('#add-client').html(data);
                               }
                       });
               }); 
        <?php } ?>

function addNewclient(mode,id,type) {

        if(document.getElementById('client-content').style.display=='none') {
            
            $('#client-content').css('display','inline');
        }
        else {
            
            $('#client-content').css('display','none');
        }

        if(id=='') id = $('#client_val').val();
        
    //$('#client-content').toggle('slow',function() {
        
        $('#clitype').val('');
                   
                    if(mode=='edit') {
                        
                        if(type=='editform') {
                            
                            $.blockUI({ message: '<h1>Please wait...</h1>', 
                                css: { padding: '15px', backgroundColor: '#000', color: '#fff', fontSize: '10px' } }); 
                            
                        }
                        
                            $(document).ready(function() {
                                    $.ajax({
                                       url: "<?php echo base_url(); ?>clients/getclient",
                                       type:"POST",
                                       cache: false,
                                       async:false,
                                       data:{id: ""+id+""},
                                       success: function(data){
                                          // alert(data);
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
                                                     $('#clitype').val('edit');

                                                      $.post("<?php echo base_url(); ?>clients/add", {mode: "booking",dir: "client",fval: ""+fval+"",lval: ""+lval+"",streetval: ""+streetval+"",address2: ""+address2+"",mobileval: ""+mobileval+"",phoneval: ""+phoneval+"",emailval: ""+emailval+"",suburbval: ""+suburbval+"",gendval: ""+cligender+"",cid: ""+cid+"",cmtval: ""+cmtval+""}, function(cont){     
                                                             //alert(data);
                                                             if(cont) {
                                                                 
                                                                 if(type=='editform') $.unblockUI();
                                                                 
                                                                 $('#add-client').html(cont);
                                                                 $('#cli_id').val(id);
                                                             }
                                                      }); 
                                                      
                                           }

                                       }
                                   });
                             });

                       
                    } 
                    
   // });
}

function getClientcontent(id,mode) {
//    alert(id);
  
     $(document).ready(function() {
             $.ajax({
                url: "<?php echo base_url(); ?>clients/getclient",
                type:"POST",
                cache: false,
                async:false,
                data:{id: ""+id+""},
                success: function(data){
                   // alert(data);
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
                              $('#clitype').val('edit');

                         if(mode=='clitext') {
                             
                             $('#client-content').css('display','inline');
                             
                             $('#add-client').html('<img src="<?php echo base_url(); ?>images/loader.gif" style="margin-left:500px; margin-top: 10px;"/>');
                             
                               $.post("<?php echo base_url(); ?>clients/add", {mode: "booking",dir: "client",fval: ""+fval+"",lval: ""+lval+"",streetval: ""+streetval+"",address2: ""+address2+"",mobileval: ""+mobileval+"",phoneval: ""+phoneval+"",emailval: ""+emailval+"",suburbval: ""+suburbval+"",gendval: ""+cligender+"",cid: ""+cid+"",cmtval: ""+cmtval+""}, function(data){     
                                      //alert(data);
                                      if(data) {
                                          $('#add-client').html(data);
                                          $('#cli_id').val(id);
                                      }
                               }); 
                               
                         }
                         else {
                         
                           $('#client-content').toggle('slow',function() {

                               $.post("<?php echo base_url(); ?>clients/add", {mode: "booking",dir: "client",fval: ""+fval+"",lval: ""+lval+"",streetval: ""+streetval+"",address2: ""+address2+"",mobileval: ""+mobileval+"",phoneval: ""+phoneval+"",emailval: ""+emailval+"",suburbval: ""+suburbval+"",gendval: ""+cligender+"",cid: ""+cid+"",cmtval: ""+cmtval+""}, function(data){     
                                      //alert(data);
                                      if(data) {
                                          $('#add-client').html(data);
                                          $('#cli_id').val(id);
                                      }
                               }); 
                               }); 
                         
                         }
                    }
                    
                }
            });
      });
            
                                        
}

function clientSave() {

        var flag = true;
        
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        
        var fval = document.getElementById('first_name').value;
        
        var lval = document.getElementById('last_name').value;

        var streetval = document.getElementById('address1').value;
        
        var address2 = document.getElementById('address2').value;
        
        var suburbval = document.getElementById('suburb').value;
        
        var mobileval = document.getElementById('mobile').value;
        
        var phoneval = document.getElementById('phone').value;
        
        var emailval = document.getElementById('email').value;
        
        var cmtval = document.getElementById('comments').value;
        
        var cid = document.getElementById('cli_id').value;
        
        var cligender = '';
        
        var mgen = $("#gender").is(':checked');
        var fgen = $("#fgender").is(':checked');
        
        if(mgen) cligender = $("#gender").val();
        if(fgen) cligender = $("#fgender").val();

        var ctype = $('#clitype').val();
        
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
        
                            $.blockUI({ message: '<h1>Please wait...</h1>', 
                                css: { padding: '15px', backgroundColor: '#000', color: '#fff', fontSize: '12px' } }); 
        //alert(cid);
        if(ctype=='edit') var dirurl = 'clients/edit';
        else var dirurl = 'clients/add';
        
            $.post("<?php echo base_url(); ?>"+dirurl, {bktype: "bkaddclient",fval: ""+fval+"",lval: ""+lval+"",streetval: ""+streetval+"",address2: ""+address2+"",mobileval: ""+mobileval+"",phoneval: ""+phoneval+"",emailval: ""+emailval+"",suburbval: ""+suburbval+"",gendval: ""+cligender+"",cid: ""+cid+"",cmtval: ""+cmtval+""}, function(data){     
                   //alert(data);
                   if(data) {
                       $.unblockUI();
                   
                       $('#client').val(fval+' '+lval+' ('+suburbval+')');
                       $('#client_val').val(data); 
                       fill(data)
                   }
                   
                });

        }
        else return false;
        

}

 function depDisable(dir) {  
   $("#dep-suburb").attr("disabled", "disabled");
   $("#dep-address1").attr("disabled", "disabled");
   $("#dep-address2").attr("disabled", "disabled");
   $("#dep-mobile").attr("disabled", "disabled");
   $("#dep-phone").attr("disabled", "disabled");
   $("#dep-drop-suburb").attr("disabled", "disabled");
   $("#dep-drop-address1").attr("disabled", "disabled");
   $("#dep-drop-address2").attr("disabled", "disabled");
   $("#dep-drop-mobile").attr("disabled", "disabled");
   $("#dep-drop-phone").attr("disabled", "disabled");
   $("#dep-passengers").attr("disabled", "disabled");
   $("#dep-babyseats").attr("disabled", "disabled");
   $("#dep-flight").attr("disabled", "disabled");
   $("#dep-airline").attr("disabled", "disabled");
   $("#dep-dom").attr("disabled", "disabled");
   $("#dep-int").attr("disabled", "disabled");
   $("#dep-date").attr("disabled", "disabled");
   $("#dep-ourtime").attr("disabled", "disabled");
   $("#dep-time").attr("disabled", "disabled");
   $("#dep-tmin").attr("disabled", "disabled");
   //$("#dep-yourhours").attr("disabled", "disabled");
   //$("#dep-yourmin").attr("disabled", "disabled");
   $("#dep-pickhours").attr("disabled", "disabled");
   $("#dep-pickmin").attr("disabled", "disabled");
   $("#dep-comments").attr("disabled", "disabled");
   $("#dep-estfare").attr("disabled", "disabled");
   $("#dep_driver").attr("disabled", "disabled");
   
   $("#my-button").css("display",'none');
   $("#my-drop-button").css("display",'none');
   $(".showpickup").css("display",'none');
   $(".showpickup-depdrop").css("display",'none');
   
   if(dir=='both') {
        $("#dep-total").css("display",'none');
        $("#arr-total").css("display",'inline');
        $("#both-total").css("display",'none');
   }
   else {
        $("#new-book").attr("disabled", "disabled");
        $("#client").attr("disabled", "disabled");
        $("#fare-total").attr("disabled", "disabled");
        $("#payment-method").attr("disabled", "disabled");
        $("#paid-status").attr("disabled", "disabled");
        $("#dep-totalval").attr("disabled", "disabled");
       
       $("#dep-total").css("display",'inline');
   }
   $("#bookbtn").removeAttr("disabled");
   
 }

 function removedepDisable(dir,depval,arrval) {  
   $("#dep-suburb").removeAttr("disabled");
   $("#dep-address1").removeAttr("disabled");
   $("#dep-address2").removeAttr("disabled");
   $("#dep-mobile").removeAttr("disabled");
   $("#dep-phone").removeAttr("disabled");
   $("#dep-drop-suburb").removeAttr("disabled");
   $("#dep-drop-address1").removeAttr("disabled");
   $("#dep-drop-address2").removeAttr("disabled");
   $("#dep-drop-mobile").removeAttr("disabled");
   $("#dep-drop-phone").removeAttr("disabled");
   $("#dep-passengers").removeAttr("disabled");
   $("#dep-babyseats").removeAttr("disabled");
   $("#dep-flight").removeAttr("disabled");
   $("#dep-airline").removeAttr("disabled");
   $("#dep-dom").removeAttr("disabled");
   $("#dep-int").removeAttr("disabled");
   $("#dep-date").removeAttr("disabled");
   $("#dep-ourtime").removeAttr("disabled");
   //$("#dep-yourhours").removeAttr("disabled");
   //$("#dep-yourmin").removeAttr("disabled");
   $("#dep-time").removeAttr("disabled");
   $("#dep-tmin").removeAttr("disabled");
   $("#dep-pickhours").removeAttr("disabled");
   $("#dep-pickmin").removeAttr("disabled");
   $("#dep-comments").removeAttr("disabled");
   $("#dep-estfare").removeAttr("disabled");
   $("#dep_driver").removeAttr("disabled");
   
    $("#new-book").removeAttr("disabled");
    $("#client").removeAttr("disabled");
    $("#fare-total").removeAttr("disabled");
    $("#payment-method").removeAttr("disabled");
    $("#paid-status").removeAttr("disabled");
    $("#dep-totalval").removeAttr("disabled");
   
   $("#my-button").css("display",'inline');
   $("#my-drop-button").css("display",'inline');
   $(".showpickup").css("display",'inline');
   $(".showpickup-depdrop").css("display",'inline');
   
   if((dir=='both' && depval==true && arrval==true) || (dir=='both' && depval==false && arrval==false)) {
        var depest = $('#dep-estfare').val();
        var arrest = $('#arr-estfare').val();
        var spldepest = depest.split('$');
        depest = spldepest[1];

        var splarrest = arrest.split('$');
        arrest = splarrest[1];

        var totest = parseFloat(depest)+parseFloat(arrest);
        totest = totest.toFixed(2);
       
        $('#fare-total').val('$'+totest);
        
        $("#dep-total").css("display",'none');
        $("#arr-total").css("display",'none');
        $("#both-total").css("display",'inline');
   }
    else if(dir=='both' && depval==false && arrval==true) { 
        $("#dep-total").css("display",'inline');
        $("#arr-total").css("display",'none');
        $("#both-total").css("display",'none');
    }  
    
   else $("#dep-total").css("display",'inline');
   
   $("#bookbtn").removeAttr("disabled");
   
 }

 function arrDisable(dir) {  
     
   $("#arr-suburb").attr("disabled", "disabled");
   $("#arr-address1").attr("disabled", "disabled");
   $("#arr-address2").attr("disabled", "disabled");
   $("#arr-mobile").attr("disabled", "disabled");
   $("#arr-phone").attr("disabled", "disabled");
   $("#arr-drop-suburb").attr("disabled", "disabled");
   $("#arr-drop-address1").attr("disabled", "disabled");
   $("#arr-drop-address2").attr("disabled", "disabled");
   $("#arr-drop-mobile").attr("disabled", "disabled");
   $("#arr-drop-phone").attr("disabled", "disabled");
   $("#arr-passengers").attr("disabled", "disabled");
   $("#arr-babyseats").attr("disabled", "disabled");
   $("#arr-flight").attr("disabled", "disabled");
   $("#arr-airline").attr("disabled", "disabled");
   $("#arr-dom").attr("disabled", "disabled");
   $("#arr-int").attr("disabled", "disabled");
   $("#arr-date").attr("disabled", "disabled");
   $("#arr-ourtime").attr("disabled", "disabled");
   //$("#arr-yourhours").attr("disabled", "disabled");
  // $("#arr-yourmin").attr("disabled", "disabled");
   $("#arr-time").attr("disabled", "disabled");
   $("#arr-tmin").attr("disabled", "disabled");
   $("#arr-pickhours").attr("disabled", "disabled");
   $("#arr-pickmin").attr("disabled", "disabled");
   $("#arr-comments").attr("disabled", "disabled");
   $("#arr-estfare").attr("disabled", "disabled");
   $("#arr_driver").attr("disabled", "disabled");
   
   $("#arrmy-button").css("display",'none');
   $("#arrmy-drop-button").css("display",'none');
   $(".showdropoff").css("display",'none');
   $(".showdropoff-arrpick").css("display",'none');
   
   if(dir=='both') {
        $("#dep-total").css("display",'inline');
        $("#arr-total").css("display",'none');
        $("#both-total").css("display",'none');
   }
   else {
        $("#new-book").attr("disabled", "disabled");
        $("#client").attr("disabled", "disabled");
        $("#fare-total").attr("disabled", "disabled");
        $("#payment-method").attr("disabled", "disabled");
        $("#paid-status").attr("disabled", "disabled");
        $("#arr-totalval").attr("disabled", "disabled");
       
       $("#arr-total").css("display",'inline');
   }
   
   $("#bookbtn").removeAttr("disabled");
   
 }

 function removearrDisable(dir,arrval,depval) {
     
   $("#arr-suburb").removeAttr("disabled");
   $("#arr-address1").removeAttr("disabled");
   $("#arr-address2").removeAttr("disabled");
   $("#arr-mobile").removeAttr("disabled");
   $("#arr-phone").removeAttr("disabled");
   $("#arr-drop-suburb").removeAttr("disabled");
   $("#arr-drop-address1").removeAttr("disabled");
   $("#arr-drop-address2").removeAttr("disabled");
   $("#arr-drop-mobile").removeAttr("disabled");
   $("#arr-drop-phone").removeAttr("disabled");
   $("#arr-passengers").removeAttr("disabled");
   $("#arr-babyseats").removeAttr("disabled");
   $("#arr-flight").removeAttr("disabled");
   $("#arr-airline").removeAttr("disabled");
   $("#arr-dom").removeAttr("disabled");
   $("#arr-int").removeAttr("disabled");
   $("#arr-date").removeAttr("disabled");
   $("#arr-ourtime").removeAttr("disabled");
 //  $("#arr-yourhours").removeAttr("disabled");
 //  $("#arr-yourmin").removeAttr("disabled");
   $("#arr-time").removeAttr("disabled");
   $("#arr-tmin").removeAttr("disabled");
   $("#arr-pickhours").removeAttr("disabled");
   $("#arr-pickmin").removeAttr("disabled");
   $("#arr-comments").removeAttr("disabled");
   $("#arr-estfare").removeAttr("disabled");
   $("#arr_driver").removeAttr("disabled");
   
    $("#new-book").removeAttr("disabled");
    $("#client").removeAttr("disabled");
    $("#fare-total").removeAttr("disabled");
    $("#payment-method").removeAttr("disabled");
    $("#paid-status").removeAttr("disabled");
    $("#arr-totalval").removeAttr("disabled");
   
   $("#arrmy-button").css("display",'inline');
   $("#arrmy-drop-button").css("display",'inline');
   $(".showdropoff").css("display",'inline');
   $(".showdropoff-arrpick").css("display",'inline');
   
   if((dir=='both' && arrval==true && depval==true) || (dir=='both' && arrval==false && depval==false)) {
        var depest = $('#dep-estfare').val();
        var arrest = $('#arr-estfare').val();
        var spldepest = depest.split('$');
        depest = spldepest[1];

        var splarrest = arrest.split('$');
        arrest = splarrest[1];

        var totest = parseFloat(depest)+parseFloat(arrest);
       totest = totest.toFixed(2);
       
        $('#fare-total').val('$'+totest);
        
        $("#dep-total").css("display",'none');
        $("#arr-total").css("display",'none');
        $("#both-total").css("display",'inline');
   }
    else if(dir=='both' && arrval==false && depval==true) { 
        $("#dep-total").css("display",'none');
        $("#arr-total").css("display",'inline');
        $("#both-total").css("display",'none');
        
    }  
   
   else $("#arr-total").css("display",'inline');
   
   $("#bookbtn").removeAttr("disabled");
   
 }

 function bothDisable(can) {  
   $(":radio").attr("disabled", "disabled");
   $(":text").attr("disabled", "disabled");
   $("select").attr("disabled", "disabled");
   $("textarea").attr("disabled", "disabled");
   
   $("#arrmy-button").css("display",'none');
   $("#my-button").css("display",'none');
   $("#arrmy-drop-button").css("display",'none');
   $("#my-drop-button").css("display",'none');
   
   $(".showpickup").css("display",'none');
   $(".showpickup-depdrop").css("display",'none');
   $(".showdropoff").css("display",'none');
   $(".showdropoff-arrpick").css("display",'none');
   
   $("#dep-total").css("display",'none');
   $("#arr-total").css("display",'none');
   $("#both-total").css("display",'inline');
   
   if(can==3) $("#bookbtn").attr("disabled", "disabled");
   else  $("#bookbtn").removeAttr("disabled");
 }


function depcancelClick(dir) {
    var depval = document.getElementById('depcancel').checked;
    var arrval = document.getElementById('arrcancel').checked;
    
    if(depval==true) $("#hiddepcheck").val('yes');
    else $("#hiddepcheck").val('no');
    
    var orgbook = $('#new-book').val();
    $('#cancel-bookval').val(orgbook);
    
    if(depval==true && arrval==false) {
        depDisable(dir)
    }
    else if(depval==true && arrval==true) bothDisable(0)
    else removedepDisable(dir,depval,arrval)
    
}

function arrcancelClick(dir) {
    var arrval = document.getElementById('arrcancel').checked;
    var depval = document.getElementById('depcancel').checked;
    
    if(arrval==true) $("#hidarrcheck").val('yes');
    else $("#hidarrcheck").val('no');
    
    var orgbook = $('#new-book').val();
    $('#cancel-bookval').val(orgbook);
    
    if(arrval==true && depval==false) arrDisable(dir)
    else if(arrval==true && depval==true) bothDisable(0)
    else removearrDisable(dir,arrval,depval)
    
}

    // popup function start
/* ;(function($) {

         // DOM Ready
        $(function() {

            $('#pop_mobile').numeric();
            $('#pop_phone').numeric();
            $('#pop_suburb').alpha();
            
            // Binding a click event
            // From jQuery v.1.7.0 use .on() instead of .bind()
            // dep popup
            $('#my-button').bind('click', function(e) {
           // $('#pop_client_val').val('');
           // $('#pop_client').val('');
            $('#pop_suburb').val('');
            $('#pop_address1').val('');
            $('#pop_address2').val('');
            $('#pop_mobile').val('');
            $('#pop_phone').val('');
            $('#pop_comment').val('');
            $('#pop_passengers').val('');
            $('#popbtnval').html('<input type="hidden" name="popupdir" id="popupdir" value="dep"/>');
            $('#popup-title').html('Pick-up Address');
            
            var clival = $('#client_val').val();
            if(clival=='') { alert('Please choose client above'); return false; }
            else {
                    // Prevents the default action to be triggered. 
                    e.preventDefault();

                    // Triggering bPopup when click event is fired
                    $('#element_to_pop_up').bPopup();
                }
            });
            
            // arr popup
            $('#arrmy-button').bind('click', function(e) {
                
            alert('hi');
            $('#pop_suburb').val('');
            $('#pop_address1').val('');
            $('#pop_address2').val('');
            $('#pop_mobile').val('');
            $('#pop_phone').val('');
            $('#pop_comment').val('');
            $('#pop_passengers').val('');
            $('#popbtnval').html('<input type="hidden" name="popupdir" id="popupdir" value="arr"/>');
            $('#popup-title').html('Drop-off Address');
            
            var clival = $('#client_val').val();
            if(clival=='') { alert('Please choose client above'); return false; }
            else {
                    // Prevents the default action to be triggered. 
                    e.preventDefault();

                    // Triggering bPopup when click event is fired
                    $('#element_to_pop_up').bPopup();
                }
            });

        });

    })(jQuery); */
    
    // arrival Other pickup address
    function arrpickupAddress(type) {
    
    $('input:text').removeAttr('disabled');
    $('select').removeAttr('disabled');
    $('textarea').removeAttr('disabled');
    $('#auto').val('');
    
    var dirval = '';
    var titleval = '';
    var destval = '';
    
          //  $('#pop_suburb').alpha();
    
    if(type=='deppickup') {
        dirval = 'dep';
        titleval = 'Pickup Address';
        destval = 'pickup';
    }
    else if(type=='depdrop') {
        dirval = 'dep';
        titleval = 'Drop-off Address';
        destval = 'drop';
    }
    else if(type=='arrpickup') {
        dirval = 'arr';
        titleval = 'Pickup Address';
        destval = 'pickup';
    }
    else if(type=='arrdrop') {
        dirval = 'arr';
        titleval = 'Drop-off Address';
        destval = 'drop';
    }
    
            $('#pop_suburb').val('');
            $('#pop_address1').val('');
            $('#pop_address2').val('');
            $('#pop_mobile').val('');
            $('#pop_phone').val('');
            $('#pop_comment').val('');
            $('#pop_passengers').val('');
            $('#pop_est').val('$');
            
            $('#popbtnval').html('<input type="hidden" name="popupdir" id="popupdir" value="'+dirval+'"/>');
            $('#destination-val').html('<input type="hidden" name="destval" id="destval" value="'+destval+'"/>');
            $('#popup-title').html(titleval);
            
            var clival = $('#client_val').val();
            if(clival=='') { alert('Please choose client above'); return false; }
            else {

                    // Triggering bPopup when click event is fired
                    $('#element_to_pop_up').bPopup();
                }
        
    }

$('#popup-save').click(function() {
    var btype = $('#new-book').val();
    
    var clival = $('#client_val').val();
    var subval = $('#pop_suburb').val();
    var addval1 = $('#pop_address1').val();
    var addval2 = $('#pop_address2').val();
    var mobval = $('#pop_mobile').val();
    var phoneval = $('#pop_phone').val();
    var comval = $('#pop_comment').val();
    var bid = $('#book_id').val();
    var pdir = $('#popupdir').val();
    var pdest = $('#destval').val();
    var poppax = $('#pop_passengers').val();
    var popest = $('#pop_est').val();
    
    var mauto = $('#auto').val();
    
    var popbook_type = $('#new-book').val();
    
    
    var flag = true;
  /*  if(clival=='') {
        $('#pop_client').css('background','yellow');
        flag = false;
    }
    else $('#pop_client').css('background','white');
    */
    if(subval=='') {
        $('#pop_suburb').css('background','yellow');
        flag = false;
    }
    else $('#pop_suburb').css('background','white');

    if(addval1=='') {
        $('#pop_address1').css('background','yellow');
        flag = false;
    }
    else $('#pop_address1').css('background','white');

    if(mobval=='') {
        $('#pop_mobile').css('background','yellow');
        flag = false;
    }
    else $('#pop_mobile').css('background','white');

    if(popbook_type!=5) {
        
    if((pdir=='dep' && pdest=='pickup') || (pdir=='arr' && pdest=='drop')) {
            if(subval!='') {
                $(document).ready(function() {
                        $.ajax({
                           url: "<?php echo base_url(); ?>ajax.php",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{clisuburbval: "clisuburbvalidate",queryString: ""+subval+""},
                           success: function(data){
                              // alert(data);
                                if(data==0) { 
                                    alert('Select valid suburb'); 
                                    $('#pop_suburb').css('background','yellow');
                                     flag = false;
                                }
                                else $('#pop_suburb').css('background','white');

                           }
                        });
                });
                
            }
            }
        }
          //  else {
            
             var regex = new RegExp("^[a-zA-Z ]+$");
             if(subval.match(regex)==null) {
                alert('Special Character and Number not allowed');
                $('#pop_suburb').css('background','yellow');
                flag = false;
             }
             else $('#pop_suburb').css('background','white');
            
           // }

    if(flag==true) {

        if(pdir=='dep') {
        
        $.post("<?php echo base_url(); ?>common/savepickup", {client: ""+clival+"",suburb: ""+subval+"",add1: ""+addval1+"",add2: ""+addval2+"",mobile: ""+mobval+"",phone: ""+phoneval+"",comment: ""+comval+"",bid: ""+bid+"",pdir: ""+pdir+"",pax: ""+poppax+"",dest: ""+pdest+"",btype: ""+btype+"",mauto: ""+mauto+"",pest: ""+popest+""}, function(data){     
            //   alert(data);
             if(pdest=='pickup')  $('#showpickup').html(data);
             else $('#showpickup-depdrop').html(data);
               $('.bClose').click();
            });
        }
        if(pdir=='arr') {
        $.post("<?php echo base_url(); ?>common/savedropoff", {client: ""+clival+"",suburb: ""+subval+"",add1: ""+addval1+"",add2: ""+addval2+"",mobile: ""+mobval+"",phone: ""+phoneval+"",comment: ""+comval+"",bid: ""+bid+"",pdir: ""+pdir+"",pax: ""+poppax+"",dest: ""+pdest+"",btype: ""+btype+"",mauto: ""+mauto+"",pest: ""+popest+""}, function(arrdata){     
            //   alert(data);
               if(pdest=='drop') $('#showdropoff').html(arrdata);
               else $('#showdropoff-arrpick').html(arrdata);
               $('.bClose').click();
            });
           }
        }
});

    function delPickup(aid,bid,dir,type,dest) {
    
        var cval = confirm('Are you sure you want to delete this record?');
        if(cval==true) {
            $.post("<?php echo base_url(); ?>common/delpickup", {id: ""+aid+"",book: ""+bid+"",dir: ""+dir+"",type: ""+type+"",dest: ""+dest+""}, function(data){     
                   if(dir=='dep') {
                       if(dest=='pickup') $('#showpickup').html(data);
                       else $('#showpickup-depdrop').html(data);
                   }
                   else {
                       if(dest=='drop') $('#showdropoff').html(data);
                       else $('#showdropoff-arrpick').html(data);
                   }
                });
        }
    }

    function editPickup(aid,sub,add1,add2,ph,mb,pas,cm,dsub,dadd1,dadd2,dph,dmb,dpas,dcm,dir,des,est,dest) {
    
              $('#auto').val(aid);
              
    var dirval = '';
    var titleval = '';
    var destval = '';
    var type = dir+des;          
              
    if(type=='deppickup') {
        dirval = 'dep';
        titleval = 'Pickup Address';
        destval = 'pickup';
    }
    else if(type=='depdrop') {
        dirval = 'dep';
        titleval = 'Drop-off Address';
        destval = 'drop';
    }
    else if(type=='arrpickup') {
        dirval = 'arr';
        titleval = 'Pickup Address';
        destval = 'pickup';
    }
    else if(type=='arrdrop') {
        dirval = 'arr';
        titleval = 'Drop-off Address';
        destval = 'drop';
    }
    
    if(sub) {
            $('#pop_suburb').val(sub);
            $('#pop_address1').val(add1);
            $('#pop_address2').val(add2);
            $('#pop_mobile').val(mb);
            $('#pop_phone').val(ph);
            $('#pop_comment').val(cm);
            $('#pop_passengers').val(pas);
            $('#pop_est').val(est);
    }
    else {
            $('#pop_suburb').val(dsub);
            $('#pop_address1').val(dadd1);
            $('#pop_address2').val(dadd2);
            $('#pop_mobile').val(dmb);
            $('#pop_phone').val(dph);
            $('#pop_comment').val(dcm);
            $('#pop_passengers').val(dpas);
            $('#pop_est').val(dest);
    }
    
            $('#popbtnval').html('<input type="hidden" name="popupdir" id="popupdir" value="'+dirval+'"/>');
            $('#destination-val').html('<input type="hidden" name="destval" id="destval" value="'+destval+'"/>');
            $('#popup-title').html(titleval);
            
                    // Triggering bPopup when click event is fired
                    $('#element_to_pop_up').bPopup();
        
    }

        function popClient(inputString){
		if(inputString.length == 0) {
			$('#popsuggestions').fadeOut();
		} else {
		$('#pop_client').addClass('load');
			$.post("<?php echo base_url(); ?>common/popclient", {queryString: ""+inputString+""}, function(data){
				//alert(data);
                                if(data.length >0) {
					$('#popsuggestions').fadeIn();
					$('#popsuggestionsList').html(data);
					$('#pop_client').removeClass('load');
				}
                                else {
					$('#popsuggestions').fadeIn();
					$('#popsuggestionsList').html('<ul><li>No record found</li></ul>');
					$('#pop_client').removeClass('load');
                                    
                                }
			});
		} 

	}

	function popfill(thisValue,name) {
		//alert(thisValue);
                $('#pop_client').val(name);
                $('#pop_client_val').val(thisValue);
		setTimeout("$('#popsuggestions').fadeOut();", 600);
        }
        
        $.post("<?php echo base_url(); ?>ajax.php", {popsuburb: "suburb"}, function(data){
				//alert(data);
                                var subval = [];
                                if(data.length >0) {
                                    var spldata = data.split(',');
                                   // var subdata = [data];  
                                    for(var i=0; i<spldata.length; i++) {
                                        subval[i] = ""+spldata[i]+"";
                                    }
                                   // var subdata = subval;
                                   // alert(subval);
                                    $("#pop_suburb").autocomplete(subval);      
                                        
				}
                                
			});
        
    // popup function end
    
    function addAttach() {
     var id = document.getElementById("attach_id").value;
     var frmval = $('#new-book').val();
     var type = $('#direction_val').val();
     
$.post("<?php echo base_url(); ?>common/index", {frmval: ""+frmval+"",type: ""+type+"",auto: ""+id+""}, function(data){     
      
      $("#divAttach").append("<div id='row" + id + "' style='position:relative; left:-10px;'><div align='right'><a href='#' onClick='removeAttach(\"#row" + id + "\"); return false;'><img src='<?php echo base_url();?>images/ico-delete.gif' title='Remove' style='position:relative; left:10px; top:5px;' /></a></div>"+data+"<div align='right'><a href='#' align='right' onClick='removeAttach(\"#row" + id + "\"); return false;'><img src='<?php echo base_url();?>images/ico-delete.gif' title='Remove' style='position:relative; left:10px; top:5px;' /></a></div><hr/><br/><br/></div>");
     id = (id - 1) + 2;
     document.getElementById("attach_id").value = id;
    });
}
    function removeAttach(id) {
     $(id).remove();
    }    
    
    
    
    
    $('#dep-date').datepick();
    
    $('#arr-date').datepick();
   
$().ready(function() {   
    /*    function logclient() {
            
        var clinameval = $('#client').val();
        var splclient = clinameval.split('(');
        var cliname = splclient[0];
        var clisuburb = splclient[1];
        
        $.post("<?php //echo base_url(); ?>common/autoclientval", {queryString: ""+cliname+"",suburb: ""+clisuburb+""}, function(data){
				//alert(data);
                               $('#client_val').val(data); 
                               fill(data);
                                
			});
	
        } */
	
        
$.post("<?php echo base_url(); ?>common/client", {queryString: "client"}, function(data){
				//alert(data);
                         /*       var subval = [];
                                if(data.length >0) {
                                    var spldata = data.split(',');
                                    for(var i=0; i<spldata.length; i++) {
                                        subval[i] = ""+spldata[i]+"";
                                    }
                                    $("#client").autocomplete(subval);   
                                  
				} */
                                
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
                                      //  alert(data.to);
                                        $('#client_val').val(data.to); 
                                        fill(data.to);

                                        getClientcontent(data.to,'clitext');
                                }
                              
			});
                        
                        
                   /*     $("#client").result(logclient).next().click(function() {
                                    $(this).prev().search();
                                   
                            }); */
                         
                        
                        });
    
	function fill(thisValue) {
		//alert(thisValue);
                
                if(thisValue) {
			$.post("<?php echo base_url(); ?>common/clidetails", {client: thisValue}, function(data){
                                
                                var dat = eval('(' + data + ')');
                                
                                $('#dep-address1').val(dat.address1);
                                $('#dep-address2').val(dat.address2);
                                $('#dep-suburb').val(dat.suburb);
                                $('#dep-phone').val(dat.phone);
                                $('#dep-mobile').val(dat.mobile);
                                $('#arr-address1').val(dat.address1);
                                $('#arr-address2').val(dat.address2);
                                $('#arr-suburb').val(dat.suburb);
                                $('#arr-phone').val(dat.phone);
                                $('#arr-mobile').val(dat.mobile);
                                
                                if(dat.suburb) {
                                        var s0 = '';
                                        var p0 = '';
                                        var b0 = '';
                                        var a0 = '';
                                        var s1 = '';
                                        var p1 = '';
                                        var b1 = '';
                                        var a1 = 1;
                                        
                                        var deppickhours = 0;
                                        var arrpickhours = 0;
                                        var arrpickmin = 0;
                                        
                                        var bktype = $('#new-book').val();
                                      
                                     //   var dir = $('#direction_val').val();
                                        
                                        s0 = dat.suburb;
                                        p0 = $('#dep-passengers').val();
                                        b0 = $('#dep-babyseats').val();
                                        s1 = dat.suburb;
                                        p1 = $('#arr-passengers').val();
                                        b1 = $('#arr-babyseats').val();
                                        

                                        if(document.getElementById('dep-pickhours')) deppickhours = $('#dep-pickhours').val();
                                        if(document.getElementById('arr-pickhours')) arrpickhours = $('#arr-pickhours').val();
                                        if(document.getElementById('arr-pickmin')) arrpickmin = $('#arr-pickmin').val();

                                        if(bktype!=5) {
                                            $.post("<?php echo base_url(); ?>ajax.php", {fee: "y",s0: ""+s0+"",p0: ""+p0+"",b0: ""+b0+"",a0: ""+a0+"",s1: ""+s1+"",p1: ""+p1+"",b1: ""+b1+"",a1: ""+a1+"",dhours: ""+deppickhours+"",ahours: ""+arrpickhours+"",amin: ""+arrpickmin+"",bktype: ""+bktype+""}, function(data){

                                                    var dat = eval('(' + data + ')');
                                                    $('#dep-estfare').val(dat.fee0);
                                                    $('#arr-estfare').val(dat.fee1);
                                                    //alert(dir);
                                                    $('#fare-total').val(dat.fee);
                                                    $('#dep-totalval').val(dat.fee0);
                                                    $('#arr-totalval').val(dat.fee1);
                                                    // hidden val
                                                    $('#depautoest').val(dat.fee0);
                                                    $('#arrautoest').val(dat.fee1);
                                                    
                                            });
                                    }
                                }
			});
                        }
                
	}

        function autoDriver(inputString){
		if(inputString.length == 0) {
			$('#suggestions-driver').fadeOut();
		} else {
		$('#driver').addClass('load');
			$.post("<?php echo base_url(); ?>common/driver", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions-driver').fadeIn();
					$('#suggestionsList-driver').html(data);
					$('#driver').removeClass('load');
				}
                                else {
					$('#suggestions-driver').fadeIn();
					$('#suggestionsList-driver').html('<ul><li>No record found</li></ul>');
					$('#driver').removeClass('load');
                                    
                                }
			});
		} 

	}

	function fillDriver(thisValue,name) {
		//alert(thisValue);
                $('#driver').val(name);
                $('#driver_val').val(thisValue);
		setTimeout("$('#suggestions-driver').fadeOut();", 600);
                //alert(thisValue);
	}

        function getPassengers(val,dir) {
                                if(val) {
                                        var s0 = '';
                                        var p0 = '';
                                        var b0 = '';
                                        var a0 = '';
                                        var s1 = '';
                                        var p1 = '';
                                        var b1 = '';
                                        var a1 = 1;

                                        var deppickhours = 0;
                                        var arrpickhours = 0;
                                        var arrpickmin = 0;
                                        var bktype = $('#new-book').val();

                                        if(document.getElementById('dep-suburb')) s0 = $('#dep-suburb').val();
                                        if(dir==0) p0 = val;
                                        else p0 = $('#dep-passengers').val();
                                        if(document.getElementById('dep-babyseats')) b0 = $('#dep-babyseats').val();
                                        if(document.getElementById('arr-suburb')) s1 = $('#arr-suburb').val();
                                        if(dir==1) p1 = val;
                                        else p1 = $('#arr-passengers').val();
                                        if(document.getElementById('arr-babyseats')) b1 = $('#arr-babyseats').val();


                                        if(document.getElementById('dep-pickhours')) deppickhours = $('#dep-pickhours').val();
                                        if(document.getElementById('arr-pickhours')) arrpickhours = $('#arr-pickhours').val();
                                        if(document.getElementById('arr-pickmin')) arrpickmin = $('#arr-pickmin').val();

                                        if(bktype!=5) {
                                            
                                            $.post("<?php echo base_url(); ?>ajax.php", {fee: "y",s0: ""+s0+"",p0: ""+p0+"",b0: ""+b0+"",a0: ""+a0+"",s1: ""+s1+"",p1: ""+p1+"",b1: ""+b1+"",a1: ""+a1+"",dhours: ""+deppickhours+"",ahours: ""+arrpickhours+"",amin: ""+arrpickmin+"",bktype: ""+bktype+""}, function(data){

                                                    var dat = eval('(' + data + ')');
                                                    $('#dep-estfare').val(dat.fee0);
                                                    $('#arr-estfare').val(dat.fee1);
                                                    $('#fare-total').val(dat.fee);
                                                    
                                                    $('#dep-totalval').val(dat.fee0);
                                                    $('#arr-totalval').val(dat.fee1);
                                                    // hidden val
                                                    $('#depautoest').val(dat.fee0);
                                                    $('#arrautoest').val(dat.fee1);
                                                    
                                            });
                                    }
                                }
        
        }

        function getBaby(val,dir) {
                                if(val) {
                                        var s0 = '';
                                        var p0 = '';
                                        var b0 = '';
                                        var a0 = '';
                                        var s1 = '';
                                        var p1 = '';
                                        var b1 = '';
                                        var a1 = 1;

                                        var deppickhours = 0;
                                        var arrpickhours = 0;
                                        var arrpickmin = 0;
                                        var bktype = $('#new-book').val();

                                        if(document.getElementById('dep-suburb')) s0 = $('#dep-suburb').val();
                                        if(document.getElementById('dep-passengers')) p0 = $('#dep-passengers').val();
                                        if(dir==0) b0 = val;
                                        else b0 = $('#dep-babyseats').val();
                                        if(document.getElementById('arr-suburb')) s1 = $('#arr-suburb').val();
                                        if(document.getElementById('arr-passengers')) p1 = $('#arr-passengers').val();
                                        if(dir==1) b1 = val;
                                        else b1 = $('#arr-babyseats').val();

                                        if(document.getElementById('dep-pickhours')) deppickhours = $('#dep-pickhours').val();
                                        if(document.getElementById('arr-pickhours')) arrpickhours = $('#arr-pickhours').val();
                                        if(document.getElementById('arr-pickmin')) arrpickmin = $('#arr-pickmin').val();

                                        if(bktype!=5) {
                                            $.post("<?php echo base_url(); ?>ajax.php", {fee: "y",s0: ""+s0+"",p0: ""+p0+"",b0: ""+b0+"",a0: ""+a0+"",s1: ""+s1+"",p1: ""+p1+"",b1: ""+b1+"",a1: ""+a1+"",dhours: ""+deppickhours+"",ahours: ""+arrpickhours+"",amin: ""+arrpickmin+"",bktype: ""+bktype+""}, function(data){

                                                    var dat = eval('(' + data + ')');
                                                    $('#dep-estfare').val(dat.fee0);
                                                    $('#arr-estfare').val(dat.fee1);
                                                    $('#fare-total').val(dat.fee);
                                                    
                                                    $('#dep-totalval').val(dat.fee0);
                                                    $('#arr-totalval').val(dat.fee1);
                                                    // hidden val
                                                    $('#depautoest').val(dat.fee0);
                                                    $('#arrautoest').val(dat.fee1);
                                                    
                                            });
                                    }
                                }
        
        }

$.post("<?php echo base_url(); ?>ajax.php", {suburb: "suburb",dir: "1"}, function(data){
				//alert(data);
                                var subval = [];
                                if(data.length >0) {
                                    var spldata = data.split(',');
                                   // var subdata = [data];  
                                    for(var i=0; i<spldata.length; i++) {
                                        subval[i] = ""+spldata[i]+"";
                                    }
                                   // var subdata = subval;
                                   // alert(subval);
                                    $("#dep-suburb").autocomplete(subval);      
                                    //$("#dep-drop-suburb").autocomplete(subval);      
                                    $("#arr-suburb").autocomplete(subval);      
                                    //$("#arr-drop-suburb").autocomplete(subval);      
                                        
				}
                                
			});

        function getSuburb(inputString,dir){
		//alert(inputString);
                if(inputString.length == 0) {
			if(dir==1) $('#suggestions-arrsub').fadeOut();
                        else $('#suggestions-sub').fadeOut();
		} else {
		
			$.post("<?php echo base_url(); ?>ajax.php", {suburb: ""+inputString+"",dir: ""+dir+""}, function(data){
				if(data.length >0) {
					if(dir==1) {
                                            if(data.length >0) {
                                                $('#suggestions-arrsub').fadeIn();
                                                $('#suggestionsList-arrsub').html(data);
                                                $('#arr-suburb').removeClass('load');
                                            }
                                        }
                                        if(dir==0) {
                                            if(data.length >0) {
                                                $('#suggestions-sub').fadeIn();
                                                $('#suggestionsList-sub').html(data);
                                                $('#dep-suburb').removeClass('load');
                                            }
                                        }
				}
			});
		} 
	}

        $("#dep-suburb").result(fillSuburb).next().click(function() {
           // $(this).prev().search();
        });

        $("#arr-suburb").result(fillSuburb).next().click(function() {
           // $(this).prev().search();
        });

	function fillSuburb() {
		//alert('hi');
               
                    var s0 = '';
                    var p0 = '';
                    var b0 = '';
                    var a0 = '';
                    var s1 = '';
                    var p1 = '';
                    var b1 = '';
                    var a1 = 1;
                    
                    var deppickhours = 0;
                    var arrpickhours = 0;
                    var arrpickmin = 0;
                    var bktype = $('#new-book').val();
                        
                    if(document.getElementById('dep-suburb')) s0 = $('#dep-suburb').val();
                    if(document.getElementById('dep-passengers')) p0 = $('#dep-passengers').val();
                    if(document.getElementById('dep-babyseats')) b0 = $('#dep-babyseats').val();
                    if(document.getElementById('arr-suburb')) s1 = $('#arr-suburb').val();
                    if(document.getElementById('arr-passengers')) p1 = $('#arr-passengers').val();
                    if(document.getElementById('arr-babyseats')) b1 = $('#arr-babyseats').val();
                    
                    if(document.getElementById('dep-pickhours')) deppickhours = $('#dep-pickhours').val();
                    if(document.getElementById('arr-pickhours')) arrpickhours = $('#arr-pickhours').val();
                    if(document.getElementById('arr-pickmin')) arrpickmin = $('#arr-pickmin').val();
                    
                    if(bktype!=5) {
                        
			$.post("<?php echo base_url(); ?>ajax.php", {fee: "y",s0: ""+s0+"",p0: ""+p0+"",b0: ""+b0+"",a0: ""+a0+"",s1: ""+s1+"",p1: ""+p1+"",b1: ""+b1+"",a1: ""+a1+"",dhours: ""+deppickhours+"",ahours: ""+arrpickhours+"",amin: ""+arrpickmin+"",bktype: ""+bktype+""}, function(data){
                               // alert(data);
                                var dat = eval('(' + data + ')');
                              //  alert(dat.fee0);
                                $('#dep-estfare').val(dat.fee0);
                                $('#arr-estfare').val(dat.fee1);
                                $('#fare-total').val(dat.fee);
                                
                                $('#dep-totalval').val(dat.fee0);
                                $('#arr-totalval').val(dat.fee1);
                                // hidden val
                                $('#depautoest').val(dat.fee0);
                                $('#arrautoest').val(dat.fee1);
                                
			});
                    }
               
	}
    
        function getFlight(inputString,dir){
        
        inputString = inputString.toUpperCase();
        
		if(dir==1) {
                    var dateval = $('#arr-date').val();
                    var direct = 'A';
                }
                else {
                    var dateval = $('#dep-date').val();
                    var direct = 'D';
                }
                //alert(dateval);
			$.post("<?php echo base_url(); ?>ajax.php", {flight: ""+inputString+"",date: ""+dateval+"",dir: ""+direct+""}, function(data){
    				//alert(data);
                                var dat = eval('(' + data + ')');
                             //   alert(dat.time);
                              if(dat.time!='' && dat.time!='Date not specified') {
                                var ftimeval = dat.time;
                                var timesplt = ftimeval.split(':');
                                var timehrs = timesplt[0];
                                var pmam = 'pm';
                                var flttime = '';
                                var timeform = 12;
                                var timepmsplt = '';
                                
                                if(timesplt[1].indexOf(pmam)!=-1) {
                                    
                                 if(timesplt[1]) { 
                                     var timepm = timesplt[1].split('pm');
                                     timepmsplt = timepm[0]; 
                                  } 
                                  
                                  var sumtim = '';
                                  
                                  if(timehrs>0 && timehrs!=12) {
                                      
                                      sumtim = parseInt(timehrs)+parseInt(timeform);
                                      
                                  }
                                  
                                  else sumtim = timehrs;

                                    flttime = sumtim+':'+timepmsplt;
                                    
                                }
                                else {
                                    var addtim;
                                    
                                 if(timesplt[1]) { var timepm = timesplt[1].split('am');
                                  timepmsplt = timepm[0]; } 
                              
                                  if(timehrs==12) {
                                    addtim = '00';
                                  }
                                    else addtim = timehrs;
                              
                                  flttime = addtim+':'+timepmsplt;  
                                
                                }
                                
                              } 
                                  
                                  
                                if(dir==1) {
                                  //  alert('1');
                                    
                                    $('#arrorigin-val').html(dat.dest);
                                    $('#arr-origin').val(dat.dest);
                                    if(dat.airline) $('#arr-airline').val(dat.airline);
                                    if(flttime) $('#arr-ourtime').val(flttime);
                                    
                                    if(dat.terminal=='I') {
                                        $('#arr-dom').attr("checked", false);
                                        $('#arr-int').attr("checked", true);
                                    }
                                    else if(dat.terminal=='D') {
                                        $('#arr-dom').attr("checked", true);
                                        $('#arr-int').attr("checked", false);
                                    }
                                }
                                else {
                                  //  alert('not1');
                                  /*  if(dat.dest=='<span class=ferror>Flight not found</span>' || dat.dest=='<span class=ferror>This is an Arrival flight</span>') { $('#bookbtn').attr('disabled', true); }
                                    else $('#bookbtn').attr('disabled', false); */
                                        
                                    $('#deporigin-val').html(dat.dest);
                                    $('#dep-origin').val(dat.dest);
                                    if(dat.airline) $('#dep-airline').val(dat.airline);
                                    if(flttime) $('#dep-ourtime').val(flttime);
                                    
                                    if(dat.terminal=='I') {
                                        $('#dep-dom').attr("checked", false);
                                        $('#dep-int').attr("checked", true);
                                    }
                                    else if(dat.terminal=='D') {
                                        $('#dep-dom').attr("checked", true);;
                                        $('#dep-int').attr("checked", false);
                                    }
                                    
                                }
			});
		//} 
	}
        
        function dateDirec(val) {
            $('#get-direction').val(val);
            $('#modeval').val('common');
        }
        
        function getDateval() {
            //alert('hi');
          var gd = $('#get-direction').val();
          var fval = '';
          var fdir = '';
           if(gd=='D') {
               fval = $('#dep-flight').val();
               fdir = 0;
           }
           else {
               fval = $('#arr-flight').val();
               fdir = 1;
           }
           
           if(document.getElementById('airport-depfields').style.display=='inline' || document.getElementById('airport-arrfields').style.display=='inline')  {   
            if(document.getElementById('dep-flight') || document.getElementById('arr-flight')) getFlight(''+fval+'',fdir);
           }
        }
        
        function newBook(val,cid,bid,client) {
            
            if(val!=0) {
               // $("input:radio").attr("checked", false);
                //if(cid=='' || bid=='') $('input:text').val('');
                $('#airport-opt').css('display','inline');
                if(document.getElementById('airport-form-content')) $('#airport-form-content').css('display','none');
            }
            else {
                $('#airport-opt').css('display','none');
            }
            
            $('#divAttach').html('');
            $('#GRwrapper0').css('display','none');
            // fill all value based on client
            if(cid!='' || bid!='') {
                
                var clival = '';
                if(cid) clival = cid;
                else if(client) clival = client;
                
			$.post("<?php echo base_url(); ?>common/cliname", {cid: ""+clival+""}, function(data){
				//alert(data);
                                if(data) {
                                    $('#client').val(data);
                                    $('#client_val').val(clival); 
                                    
                                    fill(clival);
                                }
			});
                   }
            
        }
        
        function viewForm(val,opt) {
          //  alert(val);
          //  alert(opt);
            if(val=='air-dep' && opt==1) {
                
                $('#direction_val').val('departure');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','none');
                
                
                
                $('#departure_contents').css('display','block');
                
                $('#arrival_contents').css('display','none');
                
                $('#airport-fields').css('display','inline');
                
                $('#airport-depfields').css('display','inline');
                
                $('#airport-arrfields').css('display','inline');
                
                $('#airport-time-fields').css('display','inline');
                
                $('#airport-time-depfields').css('display','inline');
                
                $('#airport-dep-flight').css('display','inline');
                
                $('#airport-time-arrfields').css('display','inline');
                
                $('#airport-arr-flight').css('display','inline');
                
                $('#non-airport-fields').css('display','none');
                
                $('#non-airport-depfields').css('display','none');
                
                $('#non-airport-arrfields').css('display','none');
                
                $('#dep-total').css('display','inline');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','none'); 
                
                $('#other-dep-dropoff').css('display','none'); 
                $('#dep-pickup-head').html('Address Details');
                
            }
            else if(val=='air-arr' && opt==1) {
               
                $('#direction_val').val('arrival');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','none');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#departure_contents').css('display','none');
                
                $('#airport-fields').css('display','inline');
                
                $('#airport-depfields').css('display','inline');
                
                $('#airport-arrfields').css('display','inline');
                
                $('#airport-time-fields').css('display','inline');
                
                $('#airport-time-depfields').css('display','inline');
                
                $('#airport-dep-flight').css('display','inline');
                
                $('#airport-time-arrfields').css('display','inline');
                
                $('#airport-arr-flight').css('display','inline');
                
                $('#non-airport-fields').css('display','none');
                
                $('#non-airport-depfields').css('display','none');
                
                $('#non-airport-arrfields').css('display','none');
                
                $('#dep-total').css('display','none');
                $('#arr-total').css('display','inline');
                $('#both-total').css('display','none'); 
                
                $('#other-arr-dropoff').css('display','none'); 
                $('#arr-pickup-head').html('Address Details');
                
            }
            else if(val=='air-both' && opt==1) {
                
                $('#direction_val').val('both');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','inline');
                
                
                $('#arrival_contents').css('display','block');
                
                $('#departure_contents').css('display','block');
                
                $('#airport-fields').css('display','inline');
                
                $('#airport-depfields').css('display','inline');
                
                $('#airport-arrfields').css('display','inline');
                
                $('#airport-time-fields').css('display','inline');
                
                $('#airport-time-depfields').css('display','inline');
                
                $('#airport-dep-flight').css('display','inline');
                
                $('#airport-time-arrfields').css('display','inline');
                
                $('#airport-arr-flight').css('display','inline');
                
                $('#non-airport-fields').css('display','none');
                
                $('#non-airport-depfields').css('display','none');
                
                $('#non-airport-arrfields').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','inline'); 
                
                $('#other-dep-dropoff').css('display','none');
                $('#other-arr-dropoff').css('display','none');
                $('#dep-pickup-head').html('Address Details');
                $('#arr-pickup-head').html('Address Details');
                
            }
            else if(val=='air-dep' && opt==2) {
                
                $('#direction_val').val('departure');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','none');
                
                
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#arrival_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','inline');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','none'); 
                
                $('#other-dep-dropoff').css('display','none');
                $('#dep-pickup-head').html('Address Details');
                
                
            }
            else if(val=='air-arr' && opt==2) {
                
                $('#direction_val').val('arrival');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','none');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#departure_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','inline');
                $('#both-total').css('display','none'); 
                
                $('#other-arr-dropoff').css('display','none');
                $('#arr-pickup-head').html('Address Details');
                
            }
            else if(val=='air-both' && opt==2) {
                
                $('#direction_val').val('both');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','inline'); 
                
                $('#other-dep-dropoff').css('display','none');
                $('#other-arr-dropoff').css('display','none');
                $('#dep-pickup-head').html('Address Details');
                $('#arr-pickup-head').html('Address Details');
                
            }
            else if(val=='air-dep' && opt==3) {
                
                $('#direction_val').val('departure');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','none');
                
                
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#arrival_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','inline');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','none'); 
                
                $('#other-dep-dropoff').css('display','none');
                $('#dep-pickup-head').html('Address Details');
                
            }
            else if(val=='air-arr' && opt==3) {
                
                $('#direction_val').val('arrival');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','none');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#departure_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','inline');
                $('#both-total').css('display','none'); 
                
                $('#other-arr-dropoff').css('display','none');
                $('#arr-pickup-head').html('Address Details');
                
            }
            else if(val=='air-both' && opt==3) {
                
                $('#direction_val').val('both');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','inline'); 
                
                $('#other-dep-dropoff').css('display','none');
                $('#other-arr-dropoff').css('display','none');
                $('#dep-pickup-head').html('Address Details');
                $('#arr-pickup-head').html('Address Details');
                
            }
            else if(val=='air-dep' && opt==4) {
                
                $('#direction_val').val('departure');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','none');
                
                
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#arrival_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','inline');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','none'); 
                
                $('#other-dep-dropoff').css('display','none');
                $('#dep-pickup-head').html('Address Details');
            }
            else if(val=='air-arr' && opt==4) {
                
                $('#direction_val').val('arrival');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','none');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#departure_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','inline');
                $('#both-total').css('display','none'); 
                
                $('#other-arr-dropoff').css('display','none');
                $('#arr-pickup-head').html('Address Details');
            }
            else if(val=='air-both' && opt==4) {
                
                $('#direction_val').val('both');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','inline'); 
                
                $('#other-dep-dropoff').css('display','none');
                $('#other-arr-dropoff').css('display','none');
                $('#dep-pickup-head').html('Address Details');
                $('#arr-pickup-head').html('Address Details');
                
            }
            
            else if(val=='air-dep' && opt==5) {
                
                $('#direction_val').val('departure');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','none');
                
                
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#arrival_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','inline');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','none'); 
                
                $('#other-dep-dropoff').css('display','inline');
                $('#dep-pickup-head').html('Pickup Address Details');
                
            }
            else if(val=='air-arr' && opt==5) {
                
                $('#direction_val').val('arrival');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','none');
                
                $('#arr-form-content').css('display','inline');
                
                
                
                $('#arrival_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#departure_contents').css('display','none');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','inline');
                $('#both-total').css('display','none'); 
                
                $('#other-arr-dropoff').css('display','inline');
                $('#arr-pickup-head').html('Drop-off Address Details');
              
            }
            else if(val=='air-both' && opt==5) {
                
                $('#direction_val').val('both');
                
                $('#airport-form-content').css('display','inline');
                
                $('#dep-form-content').css('display','inline');
                
                $('#arr-form-content').css('display','inline');


                
                $('#arrival_contents').css('display','block');
                
                $('#departure_contents').css('display','block');
                
                $('#non-airport-fields').css('display','inline');
                
                $('#non-airport-depfields').css('display','inline');
                
                $('#non-airport-arrfields').css('display','inline');
                
                $('#airport-fields').css('display','none');
                
                $('#airport-depfields').css('display','none');
                
                $('#airport-arrfields').css('display','none');
                
                $('#airport-time-fields').css('display','none');
                
                $('#airport-time-depfields').css('display','none');
                
                $('#airport-dep-flight').css('display','none');
                
                $('#airport-time-arrfields').css('display','none');
                
                $('#airport-arr-flight').css('display','none');
                
                 $('#dep-total').css('display','none');
                $('#arr-total').css('display','none');
                $('#both-total').css('display','inline'); 
                
                $('#other-dep-dropoff').css('display','inline');
                $('#other-arr-dropoff').css('display','inline');
                $('#dep-pickup-head').html('Pickup Address Details');
                $('#arr-pickup-head').html('Drop-off Address Details');
                
            }            
           
           $('#divAttach').html('');
        }
        
    $('#dep-suburb').alpha();
    
    $('#arr-suburb').alpha();
    
    //$('#dep-drop-suburb').alpha();
    
    //$('#arr-drop-suburb').alpha();
    
function numeric(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 32 || charCode > 57 )) {
             //alert('Numbers only allowed');
            return false;
         }
       else  return true;
}
    
    function addValidate() {
        
                        var flag = true;        
                        var cval = document.getElementsByName('countval[]');
    			var bsub = document.getElementsByName('dep_suburb[]');
                        var bdropsub = document.getElementsByName('dep_drop_suburb[]');
                        var filter = /^(\$)([0-9]+)$/;
                        var curbid = '';
                        var depcancelval;
                        var arrcancelval;
                        var regex = new RegExp("^[a-zA-Z ]+$");
                        
                        var book_type = $('#new-book').val();
                        
                        var rddirval = $('#direction_val').val();
                        curbid = $('#book_id').val();
                        
                        if(curbid=='') {
                             depcancelval = false;
                             arrcancelval = false;
                        }
                        else {
                            if(rddirval=='departure') {
                                depcancelval = document.getElementById('depcancel').checked;
                                arrcancelval = true;
                            }
                            else if(rddirval=='arrival') {
                                arrcancelval = document.getElementById('arrcancel').checked;
                                depcancelval = true;
                            }
                            else {
                                if(document.getElementById('depcancel')) depcancelval = document.getElementById('depcancel').checked;
                                if(document.getElementById('arrcancel')) arrcancelval = document.getElementById('arrcancel').checked;
                            }
                        }
                        //alert(depcancelval);
			for(var i = 0; i < cval.length; i++)
                        {
				
        var adateval = '';
        var ddateval = '';
        //var filter = /^([0-9]+):([0-9]+)(am|pm)$/;
        var clival = document.getElementById('client').value;
        var deppickhours = '';
        var deppickmin = '';
        var arrpickhours = '';
        var arrpickmin = '';
        
        
    if(depcancelval==false) {
    if(document.getElementById('departure_contents').style.display=='block')  {
        
        if(document.getElementById('airport-depfields').style.display=='inline') {
          
            var dflval1 = document.getElementsByName('dep_flight[]');
            var dflval = dflval1[i].value;
        }
        
       
       var ddateval1 = document.getElementsByName('dep_date[]');
       var ddateval = ddateval1[i].value;
      
        var deppickhours1 = document.getElementsByName('dep_pickhours[]');
         var deppickhours = deppickhours1[i].value;
        
       
        var deppickmin1 = document.getElementsByName('dep_pickmin[]');
        var deppickmin = deppickmin1[i].value;
        
        if(document.getElementById('airport-time-depfields').style.display=='inline') {
           
          /*  var depyourhours1 = document.getElementsByName('dep_yourhours[]');
            var depyourhours = depyourhours1[i].value;
            
          
            var depyourmin1 = document.getElementsByName('dep_yourmin[]');
            var depyourmin = depyourmin1[i].value; */
          
          
            var depourtime1 = document.getElementsByName('dep_ourtime[]');
            var depourtime = depourtime1[i].value;
            var depsplourtime = depourtime.split(':');
            var depsplourhrs = depsplourtime[0];
            var depsplourmin = depsplourtime[1];
          
        }
        
           var dsuburb = bsub[i].value;
            if(dsuburb=='') {
                bsub[i].style.backgroundColor='yellow';
                flag = false
            }
            else bsub[i].style.backgroundColor='white';
            
            if(book_type!=5) {
                
            if(dsuburb!='') {
                $(document).ready(function() {
                        $.ajax({
                           url: "<?php echo base_url(); ?>ajax.php",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{clisuburbval: "clisuburbvalidate",queryString: ""+dsuburb+""},
                           success: function(data){
                              // alert(data);
                                if(data==0) { 
                                    alert('Departure suburb invalid'); 
                                     bsub[i].style.backgroundColor='yellow';
                                     flag = false;
                                }
                                else bsub[i].style.backgroundColor='white';

                           }
                        });
                });
                
            }
        }
        
            var daddress11 = document.getElementsByName('dep_address1[]');
            var daddress1 = daddress11[i].value;
            if(daddress1=='') {
                daddress11[i].style.backgroundColor='yellow';
                flag = false
            }
            else daddress11[i].style.backgroundColor='white';


            var dmobile1 = document.getElementsByName('dep_mobile[]');
            var dmobile = dmobile1[i].value;
            if(dmobile=='') {
                dmobile1[i].style.backgroundColor='yellow';
                flag = false
            }
            else dmobile1[i].style.backgroundColor='white';


            // Other pickup / dropoff validation
            if(book_type==5) {
           var dropsuburb = bdropsub[i].value;
            if(dropsuburb=='') {
                bdropsub[i].style.backgroundColor='yellow';
                flag = false
            }
            else bdropsub[i].style.backgroundColor='white';
            
            if(dropsuburb!='') {
            
             if(dropsuburb.match(regex)==null) {
                alert('Special Character and Number not allowed');
                bdropsub[i].style.backgroundColor='yellow';
                flag = false;
             }
             else bdropsub[i].style.backgroundColor='white';
            
            /*    $(document).ready(function() {
                        $.ajax({
                           url: "<?php //echo base_url(); ?>ajax.php",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{clisuburbval: "clisuburbvalidate",queryString: ""+dropsuburb+""},
                           success: function(data){
                              // alert(data);
                                if(data==0) { 
                                    alert('Suburb invalid'); 
                                     bdropsub[i].style.backgroundColor='yellow';
                                     flag = false;
                                }
                                else bdropsub[i].style.backgroundColor='white';

                           }
                        });
                }); */
                
            } 

        
            var dropaddress11 = document.getElementsByName('dep_drop_address1[]');
            var dropaddress1 = dropaddress11[i].value;
            if(dropaddress1=='') {
                dropaddress11[i].style.backgroundColor='yellow';
                flag = false
            }
            else dropaddress11[i].style.backgroundColor='white';


            var dropmobile1 = document.getElementsByName('dep_drop_mobile[]');
            var dropmobile = dropmobile1[i].value;
            if(dropmobile=='') {
                dropmobile1[i].style.backgroundColor='yellow';
                flag = false
            }
            else dropmobile1[i].style.backgroundColor='white';
            
            }
            // Other pickup / dropoff validation end

    }
   } // dep cancel if end
    
    if(arrcancelval==false) {
    if(document.getElementById('arrival_contents').style.display=='block')  {
        
        if(document.getElementById('airport-arrfields').style.display=='inline')  {
           // if(document.getElementById('arr-flight')) var aflval = document.getElementById('arr-flight').value;
           var aflval1 = document.getElementsByName('arr_flight[]');
            var aflval = aflval1[i].value;
        }
        
       // if(document.getElementById('arr-date')) adateval = document.getElementById('arr-date').value;
        var adateval1 = document.getElementsByName('arr_date[]');
         var adateval = adateval1[i].value;
        
     //   if(document.getElementById('arr-pickhours')) arrpickhours = document.getElementById('arr-pickhours').value;
        var arrpickhours1 = document.getElementsByName('arr_pickhours[]');
        var arrpickhours = arrpickhours1[i].value;
        
      //  if(document.getElementById('arr-pickmin')) arrpickmin = document.getElementById('arr-pickmin').value;
        var arrpickmin1 = document.getElementsByName('arr_pickmin[]');
        var arrpickmin = arrpickmin1[i].value;
        
        if(document.getElementById('airport-time-arrfields').style.display=='inline')  {
           // if(document.getElementById('arr-yourtime')) var autimeval = document.getElementById('arr-yourtime').value;
         //  if(document.getElementById('arr-yourhours')) var arryourhours = document.getElementById('arr-yourhours').value;
          // var arryourhours1 = document.getElementsByName('arr_yourhours[]');
          // var arryourhours = arryourhours1[i].value;
           
         //  if(document.getElementById('arr-yourmin')) var arryourmin = document.getElementById('arr-yourmin').value;
        //   var arryourmin1 = document.getElementsByName('arr_yourmin[]');
       //    var arryourmin = arryourmin1[i].value;
          // if(document.getElementById('arr-youram')) var arryouram = document.getElementById('arr-youram').value;
          
            var arrourtime1 = document.getElementsByName('arr_ourtime[]');
            var arrourtime = arrourtime1[i].value;
            var arrsplourtime = arrourtime.split(':');
            var arrsplourhrs = arrsplourtime[0];
            var arrsplourmin = arrsplourtime[1];
          
        }
        
            var asuburb1 = document.getElementsByName('arr_suburb[]');
             var asuburb = asuburb1[i].value;
            if(asuburb=='') {
                asuburb1[i].style.backgroundColor='yellow';
                flag = false
            }
            else asuburb1[i].style.backgroundColor='white';
            
            if(book_type!=5) {
            
            if(asuburb!='') {
                $(document).ready(function() {
                        $.ajax({
                           url: "<?php echo base_url(); ?>ajax.php",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{clisuburbval: "clisuburbvalidate",queryString: ""+asuburb+""},
                           success: function(data){
                              // alert(data);
                                if(data==0) { 
                                    alert('Arrival suburb invalid'); 
                                     asuburb1[i].style.backgroundColor='yellow';
                                     flag = false;
                                }
                                else asuburb1[i].style.backgroundColor='white';

                           }
                        });
                });
                
            }
          }
            
            var aaddress11 = document.getElementsByName('arr_address1[]');
            var aaddress1 = aaddress11[i].value;
            if(aaddress1=='') {
                aaddress11[i].style.backgroundColor='yellow';
                flag = false
            }
            else aaddress11[i].style.backgroundColor='white';
      

            var amobile1 = document.getElementsByName('arr_mobile[]');
             var amobile = amobile1[i].value;
            if(amobile=='') {
                amobile1[i].style.backgroundColor='yellow';
                flag = false
            }
            else amobile1[i].style.backgroundColor='white';
       
       // Other pickup address validation
       if(book_type==5) {
            var adropsuburb1 = document.getElementsByName('arr_drop_suburb[]');
             var adropsuburb = adropsuburb1[i].value;
            if(adropsuburb=='') {
                adropsuburb1[i].style.backgroundColor='yellow';
                flag = false
            }
            else adropsuburb1[i].style.backgroundColor='white';
            
            if(adropsuburb!='') {
            
             if(adropsuburb.match(regex)==null) {
                alert('Special Character and Number not allowed');
                adropsuburb1[i].style.backgroundColor='yellow';
                flag = false;
             }
            else adropsuburb1[i].style.backgroundColor='white';
            
           /*     $(document).ready(function() {
                        $.ajax({
                           url: "<?php //echo base_url(); ?>ajax.php",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{clisuburbval: "clisuburbvalidate",queryString: ""+adropsuburb+""},
                           success: function(data){
                              // alert(data);
                                if(data==0) { 
                                    alert('Suburb invalid'); 
                                     adropsuburb1[i].style.backgroundColor='yellow';
                                     flag = false;
                                }
                                else adropsuburb1[i].style.backgroundColor='white';

                           }
                        });
                }); */
                
            } 
            
            var adropaddress11 = document.getElementsByName('arr_drop_address1[]');
            var adropaddress1 = adropaddress11[i].value;
            if(adropaddress1=='') {
                adropaddress11[i].style.backgroundColor='yellow';
                flag = false
            }
            else adropaddress11[i].style.backgroundColor='white';
      

            var adropmobile1 = document.getElementsByName('arr_drop_mobile[]');
             var adropmobile = adropmobile1[i].value;
            if(adropmobile=='') {
                adropmobile1[i].style.backgroundColor='yellow';
                flag = false
            }
            else adropmobile1[i].style.backgroundColor='white';
            }
            //  Other Pickup address validation end

    }
  } // arr cancel if end
  
            if(clival=='') {

                document.getElementById('client').style.backgroundColor='yellow';

                flag = false;
            }

            else document.getElementById('client').style.backgroundColor='white';
            
            // start dep cancel
        if(depcancelval==false) {
        if(document.getElementById('departure_contents').style.display=='block')  {
        
        if(document.getElementById('airport-depfields').style.display=='inline')  {    

      /*  if(document.getElementsByName('dep_flight[]')) {
            
            if(dflval=='') {

                dflval1[i].style.backgroundColor='yellow';

                flag = false;
            }

            else dflval1[i].style.backgroundColor='white';
            
            var depferr = $('#dep-origin').val();
            if(depferr=='' || depferr=='<span class=ferror>Flight not found</span>' || depferr=='<span class=ferror>This is an Arrival flight</span>') {
                //alert('ys');
                dflval1[i].style.backgroundColor='yellow';
                flag = false;
            }
            
            } */
                        

                        if(($("#dep-dom:checked").length==0) && ($("#dep-int:checked").length==0)) {
                            $('#dep_bothterm').css('backgroundColor','yellow');
                            flag = false;
                        }
                        else $('#dep_bothterm').css('backgroundColor','white');
                        
                        
        }
        if(document.getElementsByName('dep_date[]')) {
            if(ddateval=='') {

                ddateval1[i].style.backgroundColor='yellow';

                flag = false;
            }

            else ddateval1[i].style.backgroundColor='white';
            
        /*    if(ddateval!='') {
                
      $(document).ready(function() {
             $.ajax({
                url: "<?php //echo base_url(); ?>ajax.php",
                type:"POST",
                cache: false,
                async:false,
                data:{departuredate: 'newbook',depdate: ""+ddateval+"",mode: 'app'},
                success: function(data){
                 // alert(data);
                  if(data==false) {
                      alert('Departure Date should be today date or greater than today date');
                      ddateval1[i].style.backgroundColor='yellow';
                      flag = false;
                  }
                  else {
                      ddateval1[i].style.backgroundColor='white';
                  }
                    
                }
                });
               }); 
                
            } */

        }
        
        if(document.getElementsByName('dep_pickhours[]')) {
        
            if(deppickhours=='0') {
                deppickhours1[i].style.backgroundColor='yellow';
                flag = false;
            }
            else deppickhours1[i].style.backgroundColor='white';
            
            if(deppickmin=='0') {
                deppickmin1[i].style.backgroundColor='yellow';
                flag = false;
            }
            else deppickmin1[i].style.backgroundColor='white';
            
        }
        
        if(document.getElementById('airport-time-depfields').style.display=='inline')  {    
    
     /*   if(depyourhours!='0' && depyourmin!='0') {
            var udepourtime = Date.UTC(0,0,0,depsplourhrs,depsplourmin,0,0);
            var udepyourtime = Date.UTC(0,0,0,depyourhours,depyourmin,0,0);
            if(udepourtime<udepyourtime) {
                alert('Departure itinerary time should be less than flight time');
                depyourhours1[i].style.backgroundColor='yellow';
                depyourmin1[i].style.backgroundColor='yellow';
                flag = false;
            }
            else {
                depyourhours1[i].style.backgroundColor='white';
                depyourmin1[i].style.backgroundColor='white';
            }
        } */
        
        if(deppickhours!='0' && deppickmin!='0') {
            
       //     var utdepyourtime = Date.UTC(0,0,0,depyourhours,depyourmin,0,0);
            var udeppicktime = Date.UTC(0,0,0,deppickhours,deppickmin,0,0);
            var udepourtime = Date.UTC(0,0,0,depsplourhrs,depsplourmin,0,0);
            
                if(udepourtime<udeppicktime) {
                    alert('Departure pick-up time should be less than flight time');
                    deppickhours1[i].style.backgroundColor='yellow';
                    deppickmin1[i].style.backgroundColor='yellow';
                    flag = false;
                }
                else {
                    deppickhours1[i].style.backgroundColor='white';
                    deppickmin1[i].style.backgroundColor='white';
                } 
            
        }
        
        }
        
            if(document.getElementsByName('dep_estfare[]')) {
              //  var depestfare = document.getElementById('dep-estfare').value;
                var depestfare1 = document.getElementsByName('dep_estfare[]');
                 var depestfare = depestfare1[i].value;
                
                if(depestfare=='' || depestfare=='$') {
                    depestfare1[i].style.backgroundColor='yellow';
                    flag = false;
                }
                else depestfare1[i].style.backgroundColor='white';
                
            }

        
    }
    
    } // dep cancel end
    
    // start arr cancel
    if(arrcancelval==false) {
      if(document.getElementById('arrival_contents').style.display=='block')  {
        
       if(document.getElementById('airport-arrfields').style.display=='inline')  { 
     /*   if(document.getElementsByName('arr_flight[]')) {
            if(aflval=='') {

                aflval1[i].style.backgroundColor='yellow';

                flag = false;
            }

            else aflval1[i].style.backgroundColor='white';
            
            var arrferr = $('#arr-origin').val();
            if(arrferr=='' || arrferr=='<span class=ferror>Flight not found</span>' || arrferr=='<span class=ferror>This is an Departure flight</span>') {
                //alert('ys');
                aflval1[i].style.backgroundColor='yellow';
                flag = false;
            }
            
        } */
                        if(($("#arr-dom:checked").length==0) && ($("#arr-int:checked").length==0)) {
                            $('#arr_bothterm').css('backgroundColor','yellow');
                            flag = false;
                        }
                        else $('#arr_bothterm').css('backgroundColor','');
                        
      }

        if(document.getElementsByName('arr_date[]')) {
            if(adateval=='') {

                adateval1[i].style.backgroundColor='yellow';

                flag = false;
            }

            else adateval1[i].style.backgroundColor='white';
            
       /*     if(adateval!='') {
             
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php //echo base_url(); ?>ajax.php",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{arrivaldate: 'newbook',arrdate: ""+adateval+"",mode: 'app'},
                       success: function(data){
                            if(data==false) {
                                alert('Arrival Date should be today date or greater than today date');
                                adateval1[i].style.backgroundColor='yellow';
                                flag = false;
                            }
                            else adateval1[i].style.backgroundColor='white';

                       }
                    });
            });
            
              
            } */
        }

        if(document.getElementsByName('arr_pickhours[]')) {
        
            if(arrpickhours=='0') {
                arrpickhours1[i].style.backgroundColor='yellow';
                flag = false;
            }
            else arrpickhours1[i].style.backgroundColor='white';
            
            if(arrpickmin=='0') {
                arrpickmin1[i].style.backgroundColor='yellow';
                flag = false;
            }
            else arrpickmin1[i].style.backgroundColor='white';
            
        }

        if(document.getElementById('airport-time-arrfields').style.display=='inline')  {
      
     /*   if(arryourhours!='0' && arryourmin!='0') {
            var uarrourtime = Date.UTC(0,0,0,arrsplourhrs,arrsplourmin,0,0);
            var uarryourtime = Date.UTC(0,0,0,arryourhours,arryourmin,0,0);
            if(uarrourtime>uarryourtime) {
                alert('Arrival itinerary time should be greater than flight time');
                arryourhours1[i].style.backgroundColor='yellow';
                arryourmin1[i].style.backgroundColor='yellow';
                flag = false;
            }
            else {
                arryourhours1[i].style.backgroundColor='white';
                arryourmin1[i].style.backgroundColor='white';
            }
        } */
        if(arrpickhours!='0' && arrpickmin!='0') {
           // var utarryourtime = Date.UTC(0,0,0,arryourhours,arryourmin,0,0);
            var uarrpicktime = Date.UTC(0,0,0,arrpickhours,arrpickmin,0,0);
            var uarrourtime = Date.UTC(0,0,0,arrsplourhrs,arrsplourmin,0,0);
            
            if(uarrourtime>uarrpicktime) {
                alert('Arrival pick-up time should be greater than flight time');
                arrpickhours1[i].style.backgroundColor='yellow';
                arrpickmin1[i].style.backgroundColor='yellow';
                flag = false;
            }
            else {
                arrpickhours1[i].style.backgroundColor='white';
                arrpickmin1[i].style.backgroundColor='white';
            }
            
        }
        
        
      }
      
      
            if(document.getElementsByName('arr_estfare[]')) {
               // var arrestfare = document.getElementById('arr-estfare').value;
                var arrestfare1 = document.getElementsByName('arr_estfare[]');
                 var arrestfare = arrestfare1[i].value;
                
                if(arrestfare=='' || arrestfare=='$') {
                    arrestfare1[i].style.backgroundColor='yellow';
                    flag = false;
                }
                else arrestfare1[i].style.backgroundColor='white';
                
            }
           
      
      }
      
      } // arr cancel end
//alert(depcancelval);
//alert(arrcancelval);

      if(arrcancelval==false && depcancelval==false) {
            if(document.getElementsByName('total[]')) {
                var btot = document.getElementsByName('total[]');
                 var bothtotal = btot[i].value;
                
                if(bothtotal=='' || bothtotal=='$') {
                    btot[i].style.backgroundColor='yellow';
                    flag = false;
                }
                else btot[i].style.backgroundColor='white';
                
            }
        }
}

        if(flag==true) {
        
                    if(curbid=='') {
                        if(rddirval=='departure') alert('Your booking Departure date is '+ddateval+' and no is <?php echo $this->session->userdata('dynamicbookid'); ?>');
                        else if(rddirval=='arrival') alert('Your booking Arrival date is '+adateval+' and no is <?php echo $this->session->userdata('dynamicbookid'); ?>');
                        else alert('Your booking Departure date is '+ddateval+' \n Arrival date is '+adateval+' \n and no is <?php echo $this->session->userdata('dynamicbookid'); ?>');
                    }
        
                        var mailconfirm = confirm('Do you want to send email confirmation?');
                        if(mailconfirm==true) {
                            $('#mailconfirm').val('send');
                        }
                        else {
                            $('#mailconfirm').val('noneed');
                        }
            
                        return true;
        }
        
        else {
            alert('Please fill all Required fields');
            return false;
        }
        
    
   }
    function getTotalestimate() {
    
        var depest = $('#dep-estfare').val();
        var arrest = $('#arr-estfare').val();

        if(depest=='') $('#dep-estfare').val('$');
        if(arrest=='') $('#arr-estfare').val('$');
        
        var depestval = 0;
        var arrestval = 0;

        if(depest.indexOf('$')!=-1) {
        var dpsplt = depest.split('$')
        depestval = dpsplt[1];
        }
        
        if(arrest.indexOf('$')!=-1) {
        var arrsplt = arrest.split('$')
        arrestval = arrsplt[1];
        }
        
        if(depestval=='') depestval = 0;
        if(arrestval=='') arrestval = 0;
        
        var totalest = parseFloat(depestval)+parseFloat(arrestval);
        totalest = totalest.toFixed(2);
       // alert(totalest);
        $('#fare-total').val('$'+totalest);
        $('#dep-totalval').val(depest);
        $('#arr-totalval').val(arrest);
    }
    
    function depEstcharge(val) {
        
        var bktype = $('#new-book').val();
        
        if(bktype!=5) {
            
        var deppassval = $('#dep-passengers').val();
    
            getPassengers(deppassval,0);
            
        /*
        var deptot = $('#depautoest').val();
        var dptotsplt = deptot.split('$')
        var depestlive = dptotsplt[1];
       // alert(deptot);
        var totalestfare = '';
        
        if(val<05) {
            var charg1 = 20;
            totalestfare = parseInt(depestlive)+parseInt(charg1);
        }
        else if(val==05) {
            var charg2 = 10;
            totalestfare = parseInt(depestlive)+parseInt(charg2);
        }
        else totalestfare = depestlive;
        
       // alert(totalestfare);
        $('#dep-estfare').val('$'+totalestfare);
        $('#dep-totalval').val('$'+totalestfare);
        
        var depest = $('#dep-estfare').val();
        var dpsplt = depest.split('$')
        var depestval = dpsplt[1];
        
        var arrest = $('#arr-estfare').val();
        var arrsplt = arrest.split('$')
        var arrestval = arrsplt[1];

        if(depestval=='') depestval = 0;
        if(arrestval=='') arrestval = 0;
        
        var totalfare = parseInt(depestval)+parseInt(arrestval);
        $('#fare-total').val('$'+totalfare);
        */
        }
    }
    
    function arrEstcharge() {

        var bktype = $('#new-book').val();
        
        if(bktype!=5) {

        var arrpassval = $('#arr-passengers').val();
    
            getPassengers(arrpassval,1);

/*
        var val = $('#arr-pickhours').val();
        var deppickmin = $('#arr-pickmin').val();
        var deptot = $('#arrautoest').val();
        var dptotsplt = deptot.split('$')
        var depestlive = dptotsplt[1];
        var totalestfare = '';
        
        if(val==19) {
            var charg1 = 20;
            totalestfare = parseInt(depestlive)+parseInt(charg1);
        }
        else if(val==20) {
            var charg2 = 30;
            totalestfare = parseInt(depestlive)+parseInt(charg2);
        }
        else if(val==21 || (val==22 && deppickmin<06)) {
          
            var charg2 = 50;
            totalestfare = parseInt(depestlive)+parseInt(charg2);
        }
        else totalestfare = depestlive;
        
       // alert(totalestfare);
        $('#arr-estfare').val('$'+totalestfare);
        $('#arr-totalval').val('$'+totalestfare);
        
        var depest = $('#dep-estfare').val();
        var dpsplt = depest.split('$')
        var depestval = dpsplt[1];
        
        var arrest = $('#arr-estfare').val();
        var arrsplt = arrest.split('$')
        var arrestval = arrsplt[1];

        if(depestval=='') depestval = 0;
        if(arrestval=='') arrestval = 0;
        
        var totalfare = parseInt(depestval)+parseInt(arrestval);
        $('#fare-total').val('$'+totalfare);
        */
        
        } 
        
    }
    
    // more booking
        function getmoreSuburb(inputString,dir,id){
		//alert(inputString);
                if(inputString.length == 0) {
			if(dir==1) $('#suggestions-arrsub_'+id+'').fadeOut();
                        else $('#suggestions-sub_'+id+'').fadeOut();
		} else {
		
			$.post("<?php echo base_url(); ?>ajax.php", {moresuburb: ""+inputString+"",dir: ""+dir+"",auto: ""+id+""}, function(data){
				if(data.length >0) {
					if(dir==1) {
                                            if(data.length >0) {
                                                $('#suggestions-arrsub_'+id+'').fadeIn();
                                                $('#suggestionsList-arrsub_'+id+'').html(data);
                                                $('#arr-suburb_'+id+'').removeClass('load');
                                            }
                                        }
                                        if(dir==0) {
                                            if(data.length >0) {
                                                $('#suggestions-sub_'+id+'').fadeIn();
                                                $('#suggestionsList-sub_'+id+'').html(data);
                                                $('#dep-suburb_'+id+'').removeClass('load');
                                            }
                                        }
				}
			});
		} 
	}
    
	function fillmoreSuburb(thisValue,dir,id) {
		//alert(dir);
                if(dir==1) $('#arr-suburb_'+id+'').val(thisValue);
                if(dir==0) $('#dep-suburb_'+id+'').val(thisValue);
                
		if(dir==1) setTimeout("$('#suggestions-arrsub_"+id+"').fadeOut();", 600);
                if(dir==0) setTimeout("$('#suggestions-sub_"+id+"').fadeOut();", 600);
                
                if(thisValue) {
                    var s0 = '';
                    var p0 = '';
                    var b0 = '';
                    var a0 = '';
                    var s1 = '';
                    var p1 = '';
                    var b1 = '';
                    var a1 = 1;
                    
                    var deppickhours = 0;
                    var arrpickhours = 0;
                    var arrpickmin = 0;
                    var bktype = $('#new-book').val();
                        
                    if(document.getElementById('dep-suburb_'+id+'')) s0 = $('#dep-suburb_'+id+'').val();
                    if(document.getElementById('dep-passengers_'+id+'')) p0 = $('#dep-passengers_'+id+'').val();
                    if(document.getElementById('dep-babyseats_'+id+'')) b0 = $('#dep-babyseats_'+id+'').val();
                    if(document.getElementById('arr-suburb_'+id+'')) s1 = $('#arr-suburb_'+id+'').val();
                    if(document.getElementById('arr-passengers_'+id+'')) p1 = $('#arr-passengers_'+id+'').val();
                    if(document.getElementById('arr-babyseats_'+id+'')) b1 = $('#arr-babyseats_'+id+'').val();
                    
                    if(document.getElementById('dep-pickhours_'+id+'')) deppickhours = $('#dep-pickhours_'+id+'').val();
                    if(document.getElementById('arr-pickhours_'+id+'')) arrpickhours = $('#arr-pickhours_'+id+'').val();
                    if(document.getElementById('arr-pickmin_'+id+'')) arrpickmin = $('#arr-pickmin_'+id+'').val();
                    
                    
			$.post("<?php echo base_url(); ?>ajax.php", {fee: "y",s0: ""+s0+"",p0: ""+p0+"",b0: ""+b0+"",a0: ""+a0+"",s1: ""+s1+"",p1: ""+p1+"",b1: ""+b1+"",a1: ""+a1+"",dhours: ""+deppickhours+"",ahours: ""+arrpickhours+"",amin: ""+arrpickmin+"",bktype: ""+bktype+""}, function(data){
                               // alert(data);
                                var dat = eval('(' + data + ')');
                              //  alert(dat.fee0);
                                $('#dep-estfare_'+id+'').val(dat.fee0);
                                $('#arr-estfare_'+id+'').val(dat.fee1);
                                $('#fare-total_'+id+'').val(dat.fee);
                                
                                $('#dep-totalval_'+id+'').val(dat.fee0);
                                $('#arr-totalval_'+id+'').val(dat.fee1);
                                // hidden val
                                $('#depautoest_'+id+'').val(dat.fee0);
                                $('#arrautoest_'+id+'').val(dat.fee1);
                                
			});
                    
                }
	}
    
        function getmorePassengers(val,dir,id) {
                                if(val) {
                                        var s0 = '';
                                        var p0 = '';
                                        var b0 = '';
                                        var a0 = '';
                                        var s1 = '';
                                        var p1 = '';
                                        var b1 = '';
                                        var a1 = 1;

                                        var deppickhours = 0;
                                        var arrpickhours = 0;
                                        var arrpickmin = 0;
                                        var bktype = $('#new-book').val();

                                        if(document.getElementById('dep-suburb_'+id+'')) s0 = $('#dep-suburb_'+id+'').val();
                                        if(dir==0) p0 = val;
                                        else p0 = $('#dep-passengers_'+id+'').val();
                                        if(document.getElementById('dep-babyseats_'+id+'')) b0 = $('#dep-babyseats_'+id+'').val();
                                        if(document.getElementById('arr-suburb_'+id+'')) s1 = $('#arr-suburb_'+id+'').val();
                                        if(dir==1) p1 = val;
                                        else p1 = $('#arr-passengers_'+id+'').val();
                                        if(document.getElementById('arr-babyseats_'+id+'')) b1 = $('#arr-babyseats_'+id+'').val();


                                        if(document.getElementById('dep-pickhours_'+id+'')) deppickhours = $('#dep-pickhours_'+id+'').val();
                                        if(document.getElementById('arr-pickhours_'+id+'')) arrpickhours = $('#arr-pickhours_'+id+'').val();
                                        if(document.getElementById('arr-pickmin_'+id+'')) arrpickmin = $('#arr-pickmin_'+id+'').val();

                                            $.post("<?php echo base_url(); ?>ajax.php", {fee: "y",s0: ""+s0+"",p0: ""+p0+"",b0: ""+b0+"",a0: ""+a0+"",s1: ""+s1+"",p1: ""+p1+"",b1: ""+b1+"",a1: ""+a1+"",dhours: ""+deppickhours+"",ahours: ""+arrpickhours+"",amin: ""+arrpickmin+"",bktype: ""+bktype+""}, function(data){

                                                    var dat = eval('(' + data + ')');
                                                    $('#dep-estfare_'+id+'').val(dat.fee0);
                                                    $('#arr-estfare_'+id+'').val(dat.fee1);
                                                    $('#fare-total_'+id+'').val(dat.fee);
                                                    
                                                    $('#dep-totalval_'+id+'').val(dat.fee0);
                                                    $('#arr-totalval_'+id+'').val(dat.fee1);
                                                    // hidden val
                                                    $('#depautoest_'+id+'').val(dat.fee0);
                                                    $('#arrautoest_'+id+'').val(dat.fee1);
                                                    
                                            });
                                    
                                }
        
        }

        function getmoreBaby(val,dir,id) {
                                if(val) {
                                        var s0 = '';
                                        var p0 = '';
                                        var b0 = '';
                                        var a0 = '';
                                        var s1 = '';
                                        var p1 = '';
                                        var b1 = '';
                                        var a1 = 1;

                                        var deppickhours = 0;
                                        var arrpickhours = 0;
                                        var arrpickmin = 0;
                                        var bktype = $('#new-book').val();

                                        if(document.getElementById('dep-suburb_'+id+'')) s0 = $('#dep-suburb_'+id+'').val();
                                        if(document.getElementById('dep-passengers_'+id+'')) p0 = $('#dep-passengers_'+id+'').val();
                                        if(dir==0) b0 = val;
                                        else b0 = $('#dep-babyseats_'+id+'').val();
                                        if(document.getElementById('arr-suburb_'+id+'')) s1 = $('#arr-suburb_'+id+'').val();
                                        if(document.getElementById('arr-passengers_'+id+'')) p1 = $('#arr-passengers_'+id+'').val();
                                        if(dir==1) b1 = val;
                                        else b1 = $('#arr-babyseats_'+id+'').val();

                                        if(document.getElementById('dep-pickhours_'+id+'')) deppickhours = $('#dep-pickhours_'+id+'').val();
                                        if(document.getElementById('arr-pickhours_'+id+'')) arrpickhours = $('#arr-pickhours_'+id+'').val();
                                        if(document.getElementById('arr-pickmin_'+id+'')) arrpickmin = $('#arr-pickmin_'+id+'').val();


                                            $.post("<?php echo base_url(); ?>ajax.php", {fee: "y",s0: ""+s0+"",p0: ""+p0+"",b0: ""+b0+"",a0: ""+a0+"",s1: ""+s1+"",p1: ""+p1+"",b1: ""+b1+"",a1: ""+a1+"",dhours: ""+deppickhours+"",ahours: ""+arrpickhours+"",amin: ""+arrpickmin+"",bktype: ""+bktype+""}, function(data){

                                                    var dat = eval('(' + data + ')');
                                                    $('#dep-estfare_'+id+'').val(dat.fee0);
                                                    $('#arr-estfare_'+id+'').val(dat.fee1);
                                                    $('#fare-total_'+id+'').val(dat.fee);
                                                    
                                                    $('#dep-totalval_'+id+'').val(dat.fee0);
                                                    $('#arr-totalval_'+id+'').val(dat.fee1);
                                                    // hidden val
                                                    $('#depautoest_'+id+'').val(dat.fee0);
                                                    $('#arrautoest_'+id+'').val(dat.fee1);
                                                    
                                            });
                                    
                                }
        
        }
    
        function getmoreFlight(inputString,dir,id){
        
        inputString = inputString.toUpperCase();
        
		if(dir==1) {
                    var dateval = $('#arr-date_'+id+'').val();
                    var direct = 'A';
                }
                else {
                    var dateval = $('#dep-date_'+id+'').val();
                    var direct = 'D';
                }
                //alert(dateval);
			$.post("<?php echo base_url(); ?>ajax.php", {flight: ""+inputString+"",date: ""+dateval+"",dir: ""+direct+""}, function(data){
    				//alert(data);
                                var dat = eval('(' + data + ')');
                             //   alert(dat.time);
                              if(dat.time!='' && dat.time!='Date not specified') {
                                var ftimeval = dat.time;
                                var timesplt = ftimeval.split(':');
                                var timehrs = timesplt[0];
                                var pmam = 'pm';
                                var flttime = '';
                                var timeform = 12;
                                var timepmsplt = '';
                                
                                if(timesplt[1].indexOf(pmam)!=-1) {
                                    
                                 if(timesplt[1]) { var timepm = timesplt[1].split('pm');
                                  timepmsplt = timepm[0]; } 
                                    var sumtim = parseInt(timehrs)+parseInt(timeform);
                                    if(sumtim==24) sumtim = '00';
                                    else sumtim = sumtim;
                                    flttime = sumtim+':'+timepmsplt;
                                    
                                }
                                else {
                                 if(timesplt[1]) { var timepm = timesplt[1].split('am');
                                  timepmsplt = timepm[0]; } 
                                  flttime = timehrs+':'+timepmsplt;  
                                  
                                }
                            
                              } 
                                  
                                if(dir==1) {
                                  /*  if(dat.dest=='<span class=ferror>Flight not found</span>' || dat.dest=='<span class=ferror>This is an Departure flight</span>') { $('#bookbtn').attr('disabled', true); }
                                    else $('#bookbtn').attr('disabled', false); */
                                    
                                    $('#arrorigin-val_'+id+'').html(dat.dest);
                                    $('#arr-origin_'+id+'').val(dat.dest);
                                    $('#arr-airline_'+id+'').val(dat.airline);
                                    if(flttime) $('#arr-ourtime_'+id+'').val(flttime);
                                    if(dat.terminal=='I') {
                                        $('#arr-dom_'+id+'').attr("checked", false);
                                        $('#arr-int_'+id+'').attr("checked", true);
                                    }
                                    else {
                                        $('#arr-dom_'+id+'').attr("checked", true);
                                        $('#arr-int_'+id+'').attr("checked", false);
                                    }
                                }
                                else {
                                  //  alert(dat.dest);
                                /*    if(dat.dest=='<span class=ferror>Flight not found</span>' || dat.dest=='<span class=ferror>This is an Arrival flight</span>') { $('#bookbtn').attr('disabled', true); }
                                    else $('#bookbtn').attr('disabled', false); */
                                        
                                    $('#deporigin-val_'+id+'').html(dat.dest);
                                    $('#dep-origin_'+id+'').val(dat.dest);
                                    $('#dep-airline_'+id+'').val(dat.airline);
                                    if(flttime) $('#dep-ourtime_'+id+'').val(flttime);
                                    if(dat.terminal=='I') {
                                        $('#dep-dom_'+id+'').attr("checked", false);
                                        $('#dep-int_'+id+'').attr("checked", true);
                                    }
                                    else {
                                        $('#dep-dom_'+id+'').attr("checked", true);;
                                        $('#dep-int_'+id+'').attr("checked", false);
                                    }
                                    
                                }
			});
		//} 
	}
    
    function getmoreTotalestimate(id) {
    
        var dirval = $('#direction_val').val();
      if(dirval=='both') {
        var depest = $('#dep-estfare_'+id+'').val();
        var arrest = $('#arr-estfare_'+id+'').val();
        
        if(depest=='') $('#dep-estfare_'+id+'').val('$');
        if(arrest=='') $('#arr-estfare_'+id+'').val('$');
        
        var depestval = 0;
        var arrestval = 0;

        if(depest.indexOf('$')!=-1) {
        var dpsplt = depest.split('$')
        depestval = dpsplt[1];
        }
        
        if(arrest.indexOf('$')!=-1) {
        var arrsplt = arrest.split('$')
        arrestval = arrsplt[1];
        }
        
        if(depestval=='') depestval = 0;
        if(arrestval=='') arrestval = 0;
        
        var totalest = parseFloat(depestval)+parseFloat(arrestval);
        totalest = totalest.toFixed(2);
       // alert(totalest);
        $('#fare-total_'+id+'').val('$'+totalest);
      }
      else if(dirval=='departure') {
          var depest = $('#dep-estfare_'+id+'').val();
          if(depest=='') $('#dep-estfare_'+id+'').val('$');
          $('#dep-totalval_'+id+'').val(depest);
      }
      else if(dirval=='arrival') {
          var arrest = $('#arr-estfare_'+id+'').val();
          if(arrest=='') $('#arr-estfare_'+id+'').val('$');
          $('#arr-totalval_'+id+'').val(arrest);
      }
        
    }
    
    function depmoreEstcharge(val,id) {
        
        var deptot = $('#depautoest_'+id+'').val();
        var dptotsplt = deptot.split('$')
        var depestlive = dptotsplt[1];
       // alert(deptot);
        var totalestfare = '';
        
        if(val<05) {
            var charg1 = 20;
            totalestfare = parseFloat(depestlive)+parseInt(charg1);
        }
        else if(val==05) {
            var charg2 = 10;
            totalestfare = parseFloat(depestlive)+parseInt(charg2);
        }
        else totalestfare = depestlive;
        
        totalestfare = totalestfare.toFixed(2);
       // alert(totalestfare);
        $('#dep-estfare_'+id+'').val('$'+totalestfare);
        $('#dep-totalval_'+id+'').val('$'+totalestfare);
        
        var depest = $('#dep-estfare_'+id+'').val();
        var dpsplt = depest.split('$')
        var depestval = dpsplt[1];
        
        var arrest = $('#arr-estfare_'+id+'').val();
        var arrsplt = arrest.split('$')
        var arrestval = arrsplt[1];

        if(depestval=='') depestval = 0;
        if(arrestval=='') arrestval = 0;
        
        var totalfare = parseFloat(depestval)+parseFloat(arrestval);
        totalfare = totalfare.toFixed(2);
        
        $('#fare-total_'+id+'').val('$'+totalfare);
    }
    
    function arrmoreEstcharge(id) {
        var val = $('#arr-pickhours_'+id+'').val();
        var deppickmin = $('#arr-pickmin_'+id+'').val();
        var deptot = $('#arrautoest_'+id+'').val();
        var dptotsplt = deptot.split('$')
        var depestlive = dptotsplt[1];
        var totalestfare = '';
       // alert(deppickmin);
        if(val==19) {
            var charg1 = 20;
            totalestfare = parseFloat(depestlive)+parseInt(charg1);
        }
        else if(val==20) {
            var charg2 = 30;
            totalestfare = parseFloat(depestlive)+parseInt(charg2);
        }

	    else if(val==21 && deppickmin<31) {
           // alert('mm');
            var charg3 = 50;
            totalestfare = parseFloat(depestlive)+parseInt(charg3);
        } 
        else totalestfare = depestlive;
        
        totalestfare = totalestfare.toFixed(2);
       // alert(totalestfare);
        $('#arr-estfare_'+id+'').val('$'+totalestfare);
        $('#arr-totalval_'+id+'').val('$'+totalestfare);
        
        var depest = $('#dep-estfare_'+id+'').val();
        var dpsplt = depest.split('$')
        var depestval = dpsplt[1];
        
        var arrest = $('#arr-estfare_'+id+'').val();
        var arrsplt = arrest.split('$')
        var arrestval = arrsplt[1];

        if(depestval=='') depestval = 0;
        if(arrestval=='') arrestval = 0;
        
        var totalfare = parseFloat(depestval)+parseFloat(arrestval);
        totalfare = totalfare.toFixed(2);
        
        $('#fare-total_'+id+'').val('$'+totalfare);
    }
    
        function datemoreDirec(val) {
            $('#get-direction').val(val);
            $('#modeval').val('more');
        }
        
        function getmoreDateval(id) {
          //  alert(id);
          var gd = $('#get-direction').val();
          var fval = '';
          var fdir = '';
           if(gd=='D') {
               fval = $('#dep-flight_'+id+'').val();
               fdir = 0;
           }
           else {
               fval = $('#arr-flight_'+id+'').val();
               fdir = 1;
           }
           
           if(document.getElementById('airport-depfields').style.display=='inline' || document.getElementById('airport-arrfields').style.display=='inline')  {   
            if(document.getElementById('dep-flight_'+id+'') || document.getElementById('arr-flight_'+id+'')) getmoreFlight(''+fval+'',''+fdir+'',''+id+'');
           }
        }
    
    // more booking end
    
    function depestDollar() {
        
        //var bktype = $('#new-book').val();
        var depest = $('#dep-estfare').val();
        
        if(depest=='') $('#dep-estfare').val('$');
    }
    
    function arrestDollar() {
        
        var arrest = $('#arr-estfare').val();
        
       if(arrest=='') $('#arr-estfare').val('$');
    }
    
    function pageLeft(book,mode) {
        
        if(mode=='add') {
            var k = confirm('Cancelling will affect multiple pickup/ drop-off bookings if any. Are you sure to cancel?');
            if(k==true) window.location.href = '<?php echo base_url(); ?>booking/cancel/'+book+'';
        }
        else window.location.href = '<?php echo base_url(); ?>booking';
    }
    
            function hideClientform(val) {
                
                if(val=='') $('#client-content').css('display','none');                
            }
    
</script>


<?php 
    if($book_row[0]['type']=='AP' && $book_row[0]['direction']=='departure') echo '<script>viewForm(\'air-dep\',1)</script>'; 
    
    else if($book_row[0]['type']=='AP' && $book_row[0]['direction']=='arrival') echo '<script>viewForm(\'air-arr\',1)</script>'; 
    
    else if($book_row[0]['type']=='AP' && $book_row[0]['direction']=='both') echo '<script>viewForm(\'air-both\',1)</script>'; 
    
    else if($book_row[0]['type']=='DH' && $book_row[0]['direction']=='departure') echo '<script>viewForm(\'air-dep\',2)</script>'; 
    
    else if($book_row[0]['type']=='DH' && $book_row[0]['direction']=='arrival') echo '<script>viewForm(\'air-arr\',2)</script>'; 
    
    else if($book_row[0]['type']=='DH' && $book_row[0]['direction']=='both') echo '<script>viewForm(\'air-both\',2)</script>'; 
    
    else if($book_row[0]['type']=='CQ' && $book_row[0]['direction']=='departure') echo '<script>viewForm(\'air-dep\',3)</script>'; 
    
    else if($book_row[0]['type']=='CQ' && $book_row[0]['direction']=='arrival') echo '<script>viewForm(\'air-arr\',3)</script>'; 
    
    else if($book_row[0]['type']=='CQ' && $book_row[0]['direction']=='both') echo '<script>viewForm(\'air-both\',3)</script>'; 
    
    else if($book_row[0]['type']=='CS' && $book_row[0]['direction']=='departure') echo '<script>viewForm(\'air-dep\',4)</script>'; 
    
    else if($book_row[0]['type']=='CS' && $book_row[0]['direction']=='arrival') echo '<script>viewForm(\'air-arr\',4)</script>'; 
    
    else if($book_row[0]['type']=='CS' && $book_row[0]['direction']=='both') echo '<script>viewForm(\'air-both\',4)</script>'; 
    
    else if($book_row[0]['type']=='Other' && $book_row[0]['direction']=='departure') echo '<script>viewForm(\'air-dep\',5)</script>'; 
    
    else if($book_row[0]['type']=='Other' && $book_row[0]['direction']=='arrival') echo '<script>viewForm(\'air-arr\',5)</script>'; 
    
    else if($book_row[0]['type']=='Other' && $book_row[0]['direction']=='both') echo '<script>viewForm(\'air-both\',5)</script>'; 
    
    // after update client module code
  /*  if(isset($_GET['cid']) && $_GET['cid']!='') {
        ?>
            <script>
			$.post("<?php echo base_url(); ?>common/cliname", {cid: "<?php echo $_GET['cid']; ?>"}, function(data){
				//alert(data);
                                if(data) {
                                    $('#client').val(data);
                                    $('#client_val').val('<?php echo $_GET['cid']; ?>'); 
                                    
                                    fill("<?php echo $_GET['cid']; ?>");
                                }
			});

            </script>
<?php
    } */
    
    if($cancel_book==1) {
        echo "<script>depDisable('$book_dir')</script>";
    }
    else if($cancel_book==2) {
        echo "<script>arrDisable('$book_dir')</script>";
    }
    else if($cancel_book==3) {
        echo "<script>bothDisable(3)</script>";
    }
    
    // add client section
    if(!empty($book_row[0]['id'])) {
        $cli_id = $book_row[0]['client'];
        echo "<script>addNewclient('edit',$cli_id,'editform')</script>";
    }
    
    if(isset($_GET['cid']) && $_GET['cid']!='') {
        $cid = $_GET['cid'];
        echo "<script>getClientcontent($cid,'')</script>";
    }
?>