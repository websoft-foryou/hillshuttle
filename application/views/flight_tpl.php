<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
?>

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/flighticon.png" /><span class="page-headlbl">FLIGHT</span></div>
        
        <table width="100%" align="left">
            
            <tr>
                
                <td align="left"><?php echo anchor('/flight/add','<img src="'.base_url().'images/add.png" title="add"/><span class="add-headlbl">Add Record</span>'); ?></td>
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>flight/index/updated_date/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" value="<?php echo $this->session->userdata('flight_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld">
                                    <option value="id" <?php if($this->session->userdata('flight_searchfld')=='id') echo 'selected'; ?>>Flight</option>
                                    <option value="airline" <?php if($this->session->userdata('flight_searchfld')=='airline') echo 'selected'; ?>>Airline</option>
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'flight/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                                
                            </label>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <br/>
        
        <table class="table-contents" style="table-layout:fixed;">
            
            <tr>
                
                <th class="table-subhead" style="width: 150px;">Flight</th>
                
                <th class="table-subhead" style="width: 150px;">Airline</th>
                
                <th class="table-subhead">Term</th>
                
                <th class="table-subhead">Dir</th>

                <th class="table-subhead" style="width: 80px;">Origin</th>

                <th class="table-subhead" style="width: 55px;">Sun</th>
                
                <th class="table-subhead" style="width: 55px;">Mon</th>
                
                <th class="table-subhead" style="width: 55px;">Tue</th>
                
                <th class="table-subhead" style="width: 55px;">Wed</th>
                
                <th class="table-subhead" style="width: 55px;">Thu</th>
                
                <th class="table-subhead" style="width: 55px;">Fri</th>
                
                <th class="table-subhead" style="width: 55px;">Sat</th>
                
                <th colspan="2" class="table-subhead" style="width: 70px;">Action</th>
                
            </tr>
            
            <?php
                if(count($users_data)>0) {
                    
                    $i = 1;
                    
                    foreach ($users_data as $row) {
                    
            ?>
            
                <tr>
                    
                    <td><?php echo $row->id; ?></td>
                    
                    <td><?php echo $row->airline; ?></td>
                    
                    <td><?php if($row->terminal=='I') echo 'Int'; else echo 'Dom'; ?></td>
                    
                    <td><?php if($row->direction=='A') echo 'Arr'; else echo 'Dep'; ?></td>
                    
                    <td><?php if($row->dest1!='') echo $row->dest0.', '.$row->dest1; else echo $row->dest0; ?></td>
                    
                    <td><?php echo $row->A_time[0]; ?></td>
                    
                    <td><?php echo $row->A_time[1]; ?></td>
                    
                    <td><?php echo $row->A_time[2]; ?></td>
                    
                    <td><?php echo $row->A_time[3]; ?></td>
                    
                    <td><?php echo $row->A_time[4]; ?></td>
                    
                    <td><?php echo $row->A_time[5]; ?></td>
                    
                    <td><?php echo $row->A_time[6]; ?></td>
                    
                    <td align="center"><?php echo anchor('/flight/edit/'.$row->id,'<img src="'.base_url().'images/edit.png" title="edit"/>'); ?></td>
                    
                    <td align="center">
                        <?php $url = base_url().'index.php/flight/delete/'.$row->id; ?>
                        
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
                    
                    <td colspan="14" align="right"><?php echo $page_links; ?></td>
                    
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