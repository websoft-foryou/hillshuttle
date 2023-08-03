<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
    
?>

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/clients.png" /><span class="page-headlbl">CLIENTS</span></div>
        
        <table width="100%" align="left">
            
            <tr>
                
                <td align="left"><?php echo anchor('/clients/check','<img src="'.base_url().'images/add.png" title="add"/><span class="add-headlbl">Add Record</span>'); ?></td>
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>clients/index/updated_date/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" value="<?php echo $this->session->userdata('client_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld">
                                    
                                    <option value="first_name" <?php if($this->session->userdata('client_searchfld')=='first_name') echo 'selected'; ?>>First Name</option>
                                    
                                    <option value="last_name" <?php if($this->session->userdata('client_searchfld')=='last_name') echo 'selected'; ?>>Surname</option>
                                    
                                    <option value="address" <?php if($this->session->userdata('client_searchfld')=='address') echo 'selected'; ?>>Address</option>
                                    
                                    <option value="mobile" <?php if($this->session->userdata('client_searchfld')=='mobile') echo 'selected'; ?>>Contact Number1</option>
                                    
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'clients/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                            
                            </label>
                        
                        </div>
                    
                    </form>
                
                </td>
            
            </tr>
        
        </table>
        <br/>
        
        <table class="table-contents">
            
            <tr>
                
                <th class="table-subhead">Client ID</th>
                
                <th class="table-subhead">First Name</th>
                
                <th class="table-subhead">Surname</th>
                
                <th class="table-subhead">Address</th>
                
                <th class="table-subhead">Contact Number1</th>
                
                <th class="table-subhead">Registration Type</th>
                
                <th colspan="2" class="table-subhead">Action</th>
            
            </tr>
            <?php
                
            if(count($clients_data)>0) {
                    
                    $i = 1;
                    
                    foreach ($clients_data as $row) {
                    
                        if($row['cli_type']=='1') $regtype = 'Online'; else $regtype = 'Phone / Email';
            ?>
                <tr>
                    
                    <td><?php echo $row['id']; ?></td>
                    
                    <td><?php echo $row['first_name']; ?></td>
                    
                    <td><?php echo $row['last_name']; ?></td>
                    
                    <td><?php echo $row['address1']; ?><br/><?php echo $row['suburb']; ?></td>
                    
                    <td><?php if($row['mobile']!='0') echo $row['mobile']; ?></td>
                    
                    <td><?php echo $regtype; ?></td>
                    
                    <td align="center"><?php echo anchor('/clients/edit/'.$row["id"],'<img src="'.base_url().'images/edit.png" title="edit"/>'); ?></td>
                    
                    <td align="center">
                        
                    <?php $url = base_url().'index.php/clients/delete/'.$row['id']; ?>
                        
                        <a href="javascript:;" onClick="return delRec('<?php echo $url; ?>','<?php echo $row['id']; ?>')"><img src="<?php echo base_url();?>images/delete.jpg" title="delete"/></a>
                    
                    </td>
                
                </tr>
            <?php 
                
                $i++;
                    
                    }
                    
                }
                
                else {
            ?>
                
                <tr>
                    
                    <td colspan="8" align="center">No record found</td>
                
                </tr>
            <?php
            
                }
                
                if($page_links) {
            ?>
                <tr>
                    
                    <td colspan="8" align="right"><?php echo $page_links; ?></td>
                
                </tr>
        
                <?php } ?>
        </table>
    
    </div>
    <!-- Form content end -->

</div>


<script type="text/javascript">
    
    function delRec(url,id) {
        
        $.post("<?php echo base_url(); ?>common/clidel", {clival: ""+id+""}, function(data){     
            //alert(data); return false;
            if(data!='0') {
                alert ('you can\'t delete the client as there are few bookings for this client');
                return false;
            }
            else {
                    var q = confirm('Are you sure you want to delete this record?');

                    if(q==true) {

                        window.location=url;

                        return true;
                    }

                    else return false;
                
            }
        });
        
    }
    
</script>