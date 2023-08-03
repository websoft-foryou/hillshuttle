<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
    
?>

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/mailtemp.png" /><span class="page-headlbl">Email Templates</span></div>
        
        <table width="100%" align="left">
            
            <tr>
                
                <!-- <td align="left"><?php //echo anchor('/emailtemp/add','<img src="'.base_url().'images/add.png" title="add"/><span class="add-headlbl">Add Record</span>'); ?></td> -->
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>emailtemp/index/updated_date/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" value="<?php echo $this->session->userdata('email_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld">
                                    <option value="subject" <?php if($this->session->userdata('email_searchfld')=='subject') echo 'selected'; ?>>Subject</option>
                                    
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'emailtemp/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                                
                            </label>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <br/>
        
        <table class="table-contents">
            
            <tr>
                
                <th class="table-subhead">Temp Id</th>
                
                <th class="table-subhead">Type</th>
                
                <th class="table-subhead">Direction</th>
                
                <th class="table-subhead">Subject</th>
                
                <th class="table-subhead">Email</th>
                
                <th colspan="2" class="table-subhead">Action</th>
                
            </tr>
            
            <?php
                if(count($users_data)>0) {
                    
                    $i = 1;
                    
                    foreach ($users_data as $row) {
                    
                        $created = '';
                        $updated = '';
                        
            ?>
            
                <tr>
                    
                    <td><?php echo $row['id']; ?></td>
                    
                    <td><?php echo $row['type']; ?></td>
                    
                    <td><?php echo $row['direction']; ?></td>
                    
                    <td><?php echo $row['subject']; ?></td>
                    
                    <td><?php echo $row['email']; ?></td>
                    
                    <td align="center"><?php echo anchor('/emailtemp/edit/'.$row["id"],'<img src="'.base_url().'images/edit.png" title="edit"/>'); ?></td>
                    
                    <td align="center">
                        <?php $url = base_url().'index.php/emailtemp/delete/'.$row['id']; ?>
                        
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