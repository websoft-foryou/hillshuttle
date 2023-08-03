            <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validation.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/datepicker.js"></script>
            
            <link href="<?php echo base_url();?>css/datepicker.css" rel="stylesheet" type="text/css" />

<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/new-driver.png" /><span class="page-headlbl"><?php if($driver_row[0]['id']) echo 'EDIT DRIVER'; else echo 'ADD DRIVER'; ?></span></div>
        
        <div id="error-text" align="center" class="error-msg"></div>
        
        <form name="driver_form" method="post" action="add" onSubmit="return addValidate()">
    
            <table class="table-forms" align="center">
        
                <tr>
            
                    <td class="field-left">First Name: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="hidden" name="driver_id" id="driver_id" value="<?php echo $driver_row[0]['id']; ?>" />
                
                        <input type="text" name="driverinfo[first_name]" id="first_name" value="<?php echo $driver_row[0]['first_name']; ?>"/>
            
                    </td>
            
                    <td class="field-left">Last Name: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="text" name="driverinfo[last_name]" id="last_name" value="<?php echo $driver_row[0]['last_name']; ?>"/>
            
                    </td>
        
                </tr>
        
                <tr>
            
                    <td class="field-left">Gender: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                        <?php if(empty($driver_row[0]['gender'])) $radselected='checked'; else  $radselected = ''; ?>
                        <span id="gender_lable"><input type="radio" name="driverinfo[gender]" id="gender" value="M" <?php echo $radselected; ?> <?php if($driver_row[0]['gender']=='M') echo 'checked'; ?>/>&nbsp;&nbsp;Male &nbsp;&nbsp;<input type="radio" name="driverinfo[gender]" id="fgender" value="F" <?php if($driver_row[0]['gender']=='F') echo 'checked'; ?>/>&nbsp;&nbsp;Female</span>
            
                    </td>
            
                    <td class="field-left">Date of birth: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <input type="text" name="driverinfo[dob]" id="dob" value="<?php if($driver_row[0]['dob']!='' && $driver_row[0]['dob']!='0000-00-00') echo date('d/m/Y',strtotime($driver_row[0]['dob'])); else echo ''; ?>" readonly/>
            
                    </td>
        
                </tr>
        
                <tr>
            
                    <td class="field-left">Street: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <input type="text" name="driverinfo[street]" id="street" value="<?php echo $driver_row[0]['street']; ?>"/>
            
                    </td>
            
                    <td class="field-left">Suburb: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <input type="text" name="driverinfo[suburb]" id="suburb" value="<?php echo $driver_row[0]['suburb']; ?>"/>
            
                    </td>
        
                </tr>
        
                <tr>
            
                    <td class="field-left">State: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <select name="driverinfo[state]" id="state">
                    
                            <option value="0">Select State</option>
                    
                            <option value="1" <?php if($driver_row[0]['state']==1) echo 'selected'; ?>>ACT</option>
                    
                            <option value="2" <?php if($driver_row[0]['state']==2) echo 'selected'; ?>>NSW</option>
                    
                            <option value="3" <?php if($driver_row[0]['state']==3) echo 'selected'; ?>>NT</option>
                    
                            <option value="4" <?php if($driver_row[0]['state']==4) echo 'selected'; ?>>QLD</option>
                    
                            <option value="5" <?php if($driver_row[0]['state']==5) echo 'selected'; ?>>SA</option>
                    
                            <option value="6" <?php if($driver_row[0]['state']==6) echo 'selected'; ?>>TAS</option>
                    
                            <option value="7" <?php if($driver_row[0]['state']==7) echo 'selected'; ?>>VIC</option>
                    
                            <option value="8" <?php if($driver_row[0]['state']==8) echo 'selected'; ?>>WA</option>
                
                        </select>
            
                    </td>
            
                    <td class="field-left">Phone: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <input type="text" name="driverinfo[phone]" id="phone" value="<?php echo $driver_row[0]['phone']; ?>" onkeypress="return numeric(event)"/>
                
                        <span id="labl_phone" class="alt-lbl">Enter phone</span>
            
                    </td>
        
                </tr>
        
                <tr>
            
                    <td class="field-left">Mobile: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="text" name="driverinfo[mobile]" id="mobile" value="<?php echo $driver_row[0]['mobile']; ?>" onkeypress="return numeric(event)"/>
            
                    </td>
            
                    <td class="field-left">Email: <span class="red-star">*</span></td>
            
                    <td>
                
                        <input type="text" name="driverinfo[email]" id="email" value="<?php echo $driver_row[0]['email']; ?>"/>
                        
                    </td>
        
                </tr>
                
                <tr>
                    
                    <td class="field-left">Comments: <span class="red-star">&nbsp;</span></td>
            
                    <td>
                
                        <textarea name="driverinfo[comments]" id="comments" rows="3"><?php echo $driver_row[0]['comments']; ?></textarea>
            
                    </td>
                    
                    <td class="field-left">Active: <span class="red-star">&nbsp;</span></td>
                    
                    <td>
                        <?php
                            if($driver_row[0]['status']==1) $cheched = 'checked';

                            else $cheched = '';
                        ?>

                        <input type="checkbox" name="driverinfo[status]" <?php echo $cheched; ?>/>
                    
                    </td>
                    
                </tr>
                
            <?php 
                if($driver_row[0]['id']) {
                        $created = '';
                        $updated = '';
                        
                        if($driver_row[0]['created_date']!='0000-00-00 00:00:00') $created = date('d/M/Y',strtotime($driver_row[0]['created_date']));
                        
                        if($driver_row[0]['updated_date']!='0000-00-00 00:00:00') $updated = date('d/M/Y',strtotime($driver_row[0]['updated_date']));
                
                ?>
                <tr>
                
                    <td class="field-left">Created by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $driver_row[0]['created_by']; ?></td>
                    
                    <td class="field-left">Created date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $created; ?></td>

                </tr>
                
                <tr>
                
                    <td class="field-left">Updated by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $driver_row[0]['updated_by']; ?></td>

                    <td class="field-left">Updated date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $updated; ?></td>
                    
                </tr>
                
                <?php } ?>                
        
                <tr>
            
                    <td colspan="4">&nbsp;</td>
        
                </tr>
    
            </table>
            
            <div align="center"><input type="submit" name="client" value="Save" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'drivers"><span class="bgbtn">Cancel</span></a>'; ?></div>
    
        </form>
    
    </div>
    <!-- Form content end -->

</div>


<script type="text/javascript">
    
    $('#dob').datepick();
    
    //$('#mobile').numeric();
    
    //$('#phone').numeric();
    
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
        
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        
        var fval = document.getElementById('first_name').value;
        
        var lval = document.getElementById('last_name').value;
        
       // var genderval = document.getElementById('gender');
        
       // var fgenderval = document.getElementById('fgender');
        
       // var dobval = document.getElementById('dob').value;
        
       // var streetval = document.getElementById('street').value;
        
       // var suburbval = document.getElementById('suburb').value;
        
       // var stateval = document.getElementById('state').value;
        
        var mobileval = document.getElementById('mobile').value;
        
        var emailval = document.getElementById('email').value;
        
        var ccid = document.getElementById('driver_id').value;
        //alert(emailval);
        
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
        
     /*   if(genderval.checked==false && fgenderval.checked==false) {
            
            document.getElementById('gender_lable').style.backgroundColor='yellow ';
            
            $('#gender_lable').css('padding','5px');
            
            flag = false;
            
        }
        
        else document.getElementById('gender_lable').style.backgroundColor='white';
        
        if(dobval=='') {
            
            document.getElementById('dob').style.backgroundColor='yellow';
            
            flag = false;
        }
        
        else document.getElementById('dob').style.backgroundColor='white';
        
        if(streetval=='') {
            
            document.getElementById('street').style.backgroundColor='yellow';
            
            flag = false;
        
        }
        
        else document.getElementById('street').style.backgroundColor='white';

        if(suburbval=='') {
            
            document.getElementById('suburb').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        
        else document.getElementById('suburb').style.backgroundColor='white';

        if(stateval=='0') {
            
            document.getElementById('state').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        
        else document.getElementById('state').style.backgroundColor='white';
        */
        if(mobileval=='') {
            
            document.getElementById('mobile').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        
        else document.getElementById('mobile').style.backgroundColor='white';

        if(emailval=='' || filter.test(emailval)==false) {
            
            document.getElementById('email').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        
        else document.getElementById('email').style.backgroundColor='white';
        
        if(fval!='' && lval!='') {
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php echo base_url(); ?>common/driverduplicate",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{fval: ""+fval+"",lval: ""+lval+"",ccid: ""+ccid+""},
                       success: function(data){
                         //  alert(data); 
                            if(data!=0) { 
                                alert('Driver already exist. Please try another one.'); 
                                 document.getElementById('first_name').style.backgroundColor='yellow';
                                 document.getElementById('last_name').style.backgroundColor='yellow';
                                 flag = false;
                            }
                            else {
                                document.getElementById('first_name').style.backgroundColor='white';
                                document.getElementById('last_name').style.backgroundColor='white';
                            }
                            
                       }
                    });
            });
        }
        

        if(emailval!='') {
            
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php echo base_url(); ?>common/mail",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{mail: ""+emailval+"",ccid: ""+ccid+""},
                       success: function(data){
                          // alert(data); 
                            if(data>0) {

                                $('#error-text').html('<span>Already registered this mail address. Please use another one.</span>');

                                flag = false;
                            }
                            else {
                                $('#error-text').html('');
                            }
                            
                       }
                    });
            });
            
        }
        
        if(flag==true) return true;
        
        else return false;
        
    }
    
</script>