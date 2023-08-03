<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/mailtemp.png" /><span class="page-headlbl"><?php if($user_row[0]['id']) echo 'Edit Email Template'; else echo 'Add Email Template'; ?></span></div>
        
        <form name="login_form" method="post" action="add" onsubmit="return addValidate()">
            
            <table class="table-forms" align="center">
                
                <tr>
                    
                    <td class="field-left" nowrap>Booking Type:</td>
                    
                    <td>
                        
                        <input type="hidden" name="user_id" value="<?php echo $user_row[0]['id']; ?>" />
                        <label><?php echo $user_row[0]['type']; ?></label>
                        <!-- <input type="text" name="userinfo[type]" id="type" value="<?php //echo $user_row[0]['type']; ?>"/> -->
                    
                    </td>
                    
                    <td class="field-left">Direction:</td>
                    
                    <td>
                        <label><?php echo $user_row[0]['direction']; ?></label>
                        <!-- <input type="text" name="userinfo[direction]" id="direction" value="<?php //echo $user_row[0]['direction']; ?>"/> -->
                    
                    </td>
                
                </tr>
                
                <tr>

                    <td class="field-left">Subject: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="userinfo[subject]" id="subject" value="<?php echo $user_row[0]['subject']; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Email:</td>
                    
                    <td>
                        
                        <input type="text" name="userinfo[email]" id="email" value="<?php echo $user_row[0]['email']; ?>"/>
                    
                    </td>
                    
                </tr>
                
                <tr>
                    
                    <td class="field-left">Template: <span class="red-star">*</span></td>
                    
                    <td colspan="3">
                        
                        <textarea name="etemp" id="etemp" ><?php echo $user_row[0]['content']; ?></textarea><?php echo $view_ckeditor; ?></pre>                    
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
                
                    <td class="field-left">Created by: </td>
                    
                    <td><?php echo $user_row[0]['created_by']; ?></td>
                    
                    <td class="field-left">Created date: </td>
                    
                    <td><?php echo $created; ?></td>

                </tr>
                
                <tr>
                
                    <td class="field-left">Updated by: </td>
                    
                    <td><?php echo $user_row[0]['updated_by']; ?></td>

                    <td class="field-left">Updated date: </td>
                    
                    <td><?php echo $updated; ?></td>
                    
                </tr>
                
                <?php } ?>    
                
            </table>
            <br/>
            
            <div align="center"><input type="submit" name="client" value="Save" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'emailtemp"><span class="bgbtn">Cancel</span></a>'; ?></div>
    </form>
    
   </div>
    <!-- Form content end -->
</div>


<script type="text/javascript">
    
    function addValidate() {
       
        var flag = true;
        
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        
        var sval = document.getElementById('subject').value;
        
        var emailval = document.getElementById('email').value;
        
        var tval = CKEDITOR.instances['etemp'].getData().replace(/<[^>]*>/gi, '');

        if(sval=='') {
            
            document.getElementById('subject').style.backgroundColor='yellow';
            
            flag = false;
        }
        
        else document.getElementById('subject').style.backgroundColor='white';
        
        if(tval=='') {
            alert('Enter template content');
            flag = false; 
        }
          
        if(emailval!='') {
        if(filter.test(emailval)==false) {
            
            document.getElementById('email').style.backgroundColor='yellow';
            
            flag = false;
            
        }
        }
        
        if(flag==true) return true;
        
        else return false;
    }
</script>

<?php // echo display_ckeditor($ckeditor); ?>