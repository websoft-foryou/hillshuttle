<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
    
?>

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/drivers.png" /><span class="page-headlbl">DRIVERS</span></div>
        
        <table width="100%" align="left">
            
            <tr>
                
                <td align="left"><?php echo anchor('/drivers/add','<img src="'.base_url().'images/add.png" title="add"/><span class="add-headlbl">Add Record</span>'); ?></td>
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>drivers/index/updated_date/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" value="<?php echo $this->session->userdata('driv_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld">
                                    
                                    <option value="first_name" <?php if($this->session->userdata('driv_searchfld')=='first_name') echo 'selected'; ?>>First Name</option>
                                    
                                    <option value="last_name" <?php if($this->session->userdata('driv_searchfld')=='last_name') echo 'selected'; ?>>Last Name</option>
                                    
                                    <option value="email" <?php if($this->session->userdata('driv_searchfld')=='email') echo 'selected'; ?>>Email</option>
                                    
                                    <!-- <option value="state" <?php //if($this->session->userdata('driv_searchfld')=='state') echo 'selected'; ?>>State</option> -->
                                
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'drivers/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                            
                            </label>
                        
                        </div>
                    
                    </form>
                
                </td>
            
            </tr>
        
        </table>
        <br/>
        
        <table class="table-contents">
            
            <tr>
                
                <th class="table-subhead">Driver Id</th>
                
                <th class="table-subhead">First Name</th>
                
                <th class="table-subhead">Last Name</th>
                
                <th class="table-subhead">Email</th>
                
                <!-- <th class="table-subhead">State</th> -->
                
                <th class="table-subhead">Mobile</th>
                
                <th class="table-subhead">Active</th>
                
                <th colspan="2" class="table-subhead">Action</th>
            
            </tr>
            <?php
                
            if(count($drivers_data)>0) {
                    
                    $i = 1;
                    
                    foreach ($drivers_data as $row) {
                    
                        switch ($row['state']) {
                            
                            case '1':
                                $str_state = 'ACT';
                                break;

                            case '2':
                                $str_state = 'NSW';
                                break;

                            case '3':
                                $str_state = 'NT';
                                break;

                            case '4':
                                $str_state = 'QLD';
                                break;

                            case '5':
                                $str_state = 'SA';
                                break;

                            case '6':
                                $str_state = 'TAS';
                                break;

                            case '7':
                                $str_state = 'VIC';
                                break;

                            case '8':
                                $str_state = 'WA';
                                break;
                            
                            default :
                                $str_state = '';
                        }
                        
                        if($row['status']==1) $status = '<img src="'.base_url().'images/active.png" />';
                        
                        else $status = '<img src="'.base_url().'images/dactive.png" />';
                        
            ?>
                <tr>
                    
                    <td><?php echo $row['id']; ?></td>
                    
                    <td><?php echo $row['first_name']; ?></td>
                    
                    <td><?php echo $row['last_name']; ?></td>
                    
                    <td><?php echo $row['email']; ?></td>
                    
                    <!-- <td><?php //echo $str_state; ?></td> -->
                    
                    <td><?php echo $row['mobile']; ?></td>
                    
                    <td align="center"><?php echo $status; ?></td>
                    
                    <td align="center"><?php echo anchor('/drivers/edit/'.$row["id"],'<img src="'.base_url().'images/edit.png" title="edit"/>'); ?></td>
                    
                    <td align="center">
                        
                    <?php $url = base_url().'index.php/drivers/delete/'.$row['id']; ?>
                        
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
                    
                    <td colspan="9" align="center">No record found</td>
                
                </tr>
            <?php
            
                }
                
                if($page_links) {
            ?>
                <tr>
                    
                    <td colspan="9" align="right"><?php echo $page_links; ?></td>
                
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