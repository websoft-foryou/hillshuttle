<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
?>

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/book_blue.png" /><span class="page-headlbl">SUBURB</span></div>
        
        <table width="100%" align="left">
            
            <tr>
                
                <td align="left"><?php echo anchor('/suburb/add','<img src="'.base_url().'images/add.png" title="add"/><span class="add-headlbl">Add Record</span>'); ?></td>
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>suburb/index/updated_date/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" value="<?php echo $this->session->userdata('sub_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld">
                                    <!-- <option value="id" <?php // if($this->session->userdata('sub_searchfld')=='id') echo 'selected'; ?>>Suburb Id</option> -->
                                    <option value="postcode" <?php if($this->session->userdata('sub_searchfld')=='postcode') echo 'selected'; ?>>Post Code</option>
                                    <option value="suburb" <?php if($this->session->userdata('sub_searchfld')=='suburb') echo 'selected'; ?>>Suburb</option>
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'suburb/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                                
                            </label>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <br/>
        
        <table class="table-contents" style="table-layout:fixed;">
            
            <tr>
                
                <!-- <th class="table-subhead" style="width: 35px;">Suburb Id</th> -->
                
                <th class="table-subhead">Post code</th>
                
                <th class="table-subhead" style="width: 150px;">Suburb</th>
                
                <th class="table-subhead">1</th>
                
                <th class="table-subhead">2</th>

                <th class="table-subhead">3</th>

                <th class="table-subhead">4</th>
                
                <th class="table-subhead">5</th>
                
                <th class="table-subhead">6</th>
                
                <th class="table-subhead">7</th>
                
                <th class="table-subhead">8</th>
                
                <th class="table-subhead">9</th>
                
                <th class="table-subhead">10</th>
                
                <th class="table-subhead" style="width: 37px;">Charter</th>
                
                <th colspan="2" class="table-subhead" style="width: 70px;">Action</th>
                
            </tr>
            
            <?php
                if(count($users_data)>0) {
                    
                    $i = 1;
                    
                    foreach ($users_data as $row) {
                    
            ?>
            
                <tr>
                    
                    <!-- <td><?php //echo $row->id; ?></td> -->
                    
                    <td><?php echo $row->postcode; ?></td>
                    
                    <td align="left"><?php echo $row->suburb; ?></td>
                    
                        <?php
                        foreach ($row->A_fee as $fee) {
                            if($fee!='') {
                        ?>
                                <td><?php echo $fee; ?></td>
                        <?php
                            } 
                        }
                        ?>
                    
                    <td align="center"><?php echo anchor('/suburb/edit/'.$row->id,'<img src="'.base_url().'images/edit.png" title="edit"/>'); ?></td>
                    
                    <td align="center">
                        <?php $url = base_url().'index.php/suburb/delete/'.$row->id; ?>
                        
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
                    
                    <td colspan="15" align="center">No record found</td>
                    
                </tr>
                
            <?php
                }
                
                if($page_links) {
            ?>
                
                <tr>
                    
                    <td colspan="15" align="right"><?php echo $page_links; ?></td>
                    
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