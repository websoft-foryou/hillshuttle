<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
    
?>

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/users.png" /><span class="page-headlbl">USERS</span></div>
        
        <table width="100%" align="right">
            
            <tr>
                
                <td align="left"><?php echo anchor('/users/add','<img src="'.base_url().'images/add.png" title="add"/><span class="add-headlbl">Add Record</span>'); ?></td>
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>users/index/updated_date/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" value="<?php echo $this->session->userdata('user_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld">
                                    <option value="first_name" <?php if($this->session->userdata('user_searchfld')=='first_name') echo 'selected'; ?>>First Name</option>
                                    
                                    <option value="last_name" <?php if($this->session->userdata('user_searchfld')=='last_name') echo 'selected'; ?>>Last Name</option>
                                    
                                    <option value="type" <?php if($this->session->userdata('user_searchfld')=='type') echo 'selected'; ?>>User Type</option>
                                    
                                    <!--<option value="status" <?php if($this->session->userdata('user_searchfld')=='status') echo 'selected'; ?>>Status</option>-->
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'users/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                                
                            </label>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <br/>
        
        <table class="table-contents">
            
            <tr>
                
                <th class="table-subhead">User Id</th>
                
                <th class="table-subhead">First Name</th>
                
                <th class="table-subhead">Last Name</th>
                
                <th class="table-subhead">User Type</th>
                
                <th class="table-subhead">Active</th>
                
                <th colspan="2" class="table-subhead">Action</th>
                
            </tr>
            
            <?php
                if(count($users_data)>0) {
                    
                    $i = 1;
                    
                    foreach ($users_data as $row) {
                    
                        $created = '';
                        $updated = '';
                        
                        if($row['type']==1) $type = 'Administrator';
                        
                        else $type = 'User';
                        
                        if($row['status']==1) $status = '<img src="'.base_url().'images/active.png" />';
                        
                        else $status = '<img src="'.base_url().'images/dactive.png" />';
                        
            ?>
            
                <tr>
                    
                    <td><?php echo $row['id']; ?></td>
                    
                    <td><?php echo $row['first_name']; ?></td>
                    
                    <td><?php echo $row['last_name']; ?></td>
                    
                    <td><?php echo $type; ?></td>
                    
                    <td align="center"><?php echo $status; ?></td>
                    
                    <td align="center"><?php echo anchor('/users/edit/'.$row["id"],'<img src="'.base_url().'images/edit.png" title="edit"/>'); ?></td>
                    
                    <td align="center">
                        <?php $url = base_url().'index.php/users/delete/'.$row['id']; ?>
                        
                        <a href="javascript:;" onClick="return delRec('<?php echo $url; ?>')"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a>
                        
                    </td>
                    
                </tr>
                
            <?php 
            
                $i++;
                    }
                }
                
                else {
            ?>
                
                <tr>
                    
                    <td colspan="7" align="center">No record found</td>
                    
                </tr>
                
            <?php
                }
                
                if($page_links) {
            ?>
                
                <tr>
                    
                    <td colspan="7" align="right"><?php echo $page_links; ?></td>
                    
                </tr>
                
                <?php } ?>
        </table>
        
    </div>
    
    <!-- Form content end -->
</div>


<script type="text/javascript">
    
    function delRec(url) {
        
        var q = confirm('Are you sure you want to delete this record?');
        
        if(q==true) {
            
            window.location=url;
            
            return true;
            
        }
        
        else return false;
        
    }
</script>