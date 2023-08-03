<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/new-user.png" /><span class="page-headlbl"><?php if($user_row[0]['id']) echo 'EDIT USER'; else echo 'ADD USER'; ?></span></div>
        
        <span>
            <b>Password Policy:</b>
            <ul style="list-style: circle; margin-left: 14px; font-size: 12px;">
            <li>Passwords are required to be a minimum of  6 characters in length.</li>
            <li>Does not contain: user name, or first name, or last name</li>
            <li>Not case sensitive</li>
            <li>Numeric and alphanumeric</li>
            </ul>
        </span>
        <br/>
        <form name="login_form" method="post" action="add" onSubmit="return addValidate()">
            
            <table class="table-forms" align="center">
                
                <tr>
                    
                    <td class="field-left">First Name: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_row[0]['id']; ?>" />
                        
                        <input type="text" name="userinfo[first_name]" id="first_name" value="<?php echo $user_row[0]['first_name']; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Last Name: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="userinfo[last_name]" id="last_name" value="<?php echo $user_row[0]['last_name']; ?>"/>
                    
                    </td>
                
                </tr>
                
                <tr>
                    
                    <td class="field-left">User Name: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="userinfo[username]" id="username" value="<?php echo $user_row[0]['username']; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Password: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="password" name="userinfo[password]" id="password" value="<?php echo $user_row[0]['password']; ?>"/>
                    
                    </td>
                
                </tr>
                
                <tr>
                    
                    <td class="field-left">Retype Password: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="password" name="re-password" id="re-password" value="<?php echo $user_row[0]['password']; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">User Type: <span class="red-star">*</span></td>
                    
                    <td>
                        <?php
                            if($user_row[0]['type']==1) $selected1 = 'selected'; else $selected1 = '';

                            if($user_row[0]['type']==2) $selected2 = 'selected'; else $selected2 = '';
                        ?>
                        
                        <select name="userinfo[type]" id="user_type">
                            
                            <option value="0">Select</option>
                            
                            <option value="1" <?php echo $selected1; ?>>Admin</option>
                            
                            <option value="2" <?php echo $selected2; ?>>User</option>
                        
                        </select>
                    
                    </td>
                
                </tr>
                
                <tr>
                    
                    <td class="field-left">Active: <span class="red-star">&nbsp;</span></td>
                    
                    <td>
                        <?php
                            if($user_row[0]['status']==1) $cheched = 'checked';

                            else $cheched = '';
                        ?>

                        <input type="checkbox" name="userinfo[status]" <?php echo $cheched; ?>/>
                    
                    </td>
                
                </tr>
            <?php 
                if($user_row[0]['id']) {
                        $created = '';
                        $updated = '';
                        
                        if($user_row[0]['created_date']!='0000-00-00 00:00:00') $created = date('d/M/Y',strtotime($user_row[0]['created_date']));
                        
                        if($user_row[0]['updated_date']!='0000-00-00 00:00:00') $updated = date('d/M/Y',strtotime($user_row[0]['updated_date']));
                
                ?>
                <tr>
                
                    <td class="field-left">Created by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $user_row[0]['created_by']; ?></td>
                    
                    <td class="field-left">Created date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $created; ?></td>

                </tr>
                
                <tr>
                
                    <td class="field-left">Updated by: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $user_row[0]['updated_by']; ?></td>

                    <td class="field-left">Updated date: <span class="red-star">&nbsp;</span></td>
                    
                    <td><?php echo $updated; ?></td>
                    
                </tr>
                
                <?php } ?>
            </table>
            <br/>
            
            <div align="center"><input type="submit" name="client" value="Save" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'users"><span class="bgbtn">Cancel</span></a>'; ?>
    </form>
    
   </div>
    <!-- Form content end -->
</div>


<script type="text/javascript">
    
    function addValidate() {
       
        var alphanumRegex = /^[a-z0-9]+$/i

        var flag = true;
        
        var fval = document.getElementById('first_name').value;
        
        var lval = document.getElementById('last_name').value;
        
        var userval = document.getElementById('username').value;
        
        var passval = document.getElementById('password').value;
        
        var repassval = document.getElementById('re-password').value;
        
        var tval = document.getElementById('user_type').value;
        
        var ccid = document.getElementById('user_id').value;
        
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
        
        if(userval=='') {
            
            document.getElementById('username').style.backgroundColor='yellow';
            
            flag = false;
        }
        
        else document.getElementById('username').style.backgroundColor='white';
        
        if(passval=='') {
            
            document.getElementById('password').style.backgroundColor='yellow';
            
            flag = false;
        }
        
        else document.getElementById('password').style.backgroundColor='white';
        
        if(passval!='') {
            if (passval.length < 6) {
                alert("Password must be minimum of  6 characters");
                document.getElementById('password').style.backgroundColor='yellow';
                flag = false;
            } 
            else if(!passval.match(alphanumRegex)) {
                alert("Password must be alphanumeric");
                document.getElementById('password').style.backgroundColor='yellow';
                flag = false;
            }
          /*  else if(passval==fval || passval==lval || passval==userval) {
                alert('Password should not contain First name or Last name or User name');
                document.getElementById('password').style.backgroundColor='yellow';
                flag = false;
            } */
            else if(passval.toLowerCase().indexOf(fval.toLowerCase())!=-1 || passval.toLowerCase().indexOf(lval.toLowerCase())!=-1 || passval.toLowerCase().indexOf(userval.toLowerCase())!=-1) {
                alert('Password should not contain First name or Last name or User name');
                document.getElementById('password').style.backgroundColor='yellow';
                flag = false;
            }
        }
        
        if(passval!=repassval) {
            
            document.getElementById('re-password').style.backgroundColor='yellow';
            
            flag = false;
        }
        
        else document.getElementById('re-password').style.backgroundColor='white';
        
        if(tval=='0') {
            
            document.getElementById('user_type').style.backgroundColor='yellow';
            
            flag = false;
        }
        
        else document.getElementById('user_type').style.backgroundColor='white';
        
        if(fval!='' && lval!='') {
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php echo base_url(); ?>common/userduplicate",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{fval: ""+fval+"",lval: ""+lval+"",ccid: ""+ccid+""},
                       success: function(data){
                         //  alert(data); 
                            if(data!=0) { 
                                alert('User already exist. Please try another one.'); 
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
        
        if(flag==true) return true;
        
        else return false;
    }
</script>