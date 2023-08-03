<?php

    $cur_orderby = ($uri_orderby=='ASC')? 'DESC' : 'ASC';
    
?>

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/mailtemp.png" /><span class="page-headlbl">Mail Status</span></div>
        
        <table width="100%" align="left">
            
            <tr>
                
                <td align="right">
                    
                    <form name="search" method="post" action="<?php echo site_url(); ?>mail_log/index/id/DESC">
                        
                        <div>
                            
                            <label><input type="text" name="search_txt" value="<?php echo $this->session->userdata('mail_searchtxt') ?>"/></label>
                            
                            <label>
                                
                                <select name="search_fld">
                                    <option value="to" <?php if($this->session->userdata('mail_searchfld')=='to') echo 'selected'; ?>>To</option>
                                    <option value="subject" <?php if($this->session->userdata('mail_searchfld')=='subject') echo 'selected'; ?>>Subject</option>
                                    <option value="status" <?php if($this->session->userdata('mail_searchfld')=='status') echo 'selected'; ?>>Status</option>
                                    <option value="sent_date" <?php if($this->session->userdata('mail_searchfld')=='sent_date') echo 'selected'; ?>>Sent date</option>
                                    
                                </select>
                                
                                <input type="submit" value="Filter" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'mail_log/index/updated_date/DESC/1/reset"><span class="bgbtn">Reset</span></a>'; ?>
                                
                            </label>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <br/>
        
        <table class="table-contents" bgcolor="#f2f2f2" width="100%" style="table-layout: fixed;">
            
            <tr>
                
                <th width="5%" class="table-subhead">Id</th>
                
                <th width="15%" class="table-subhead">To</th>
                
                <th width="15%" class="table-subhead">Subject</th>
                
                <th width="40%" class="table-subhead">Message</th>
                
                <th width="5%" class="table-subhead">Status</th>
                
                <th width="10%" class="table-subhead">Sent date</th>
                
                <th width="10%" class="table-subhead">Created date</th>
                
            </tr>
            
            <?php
                if(count($mail_data)>0) {
                    
                    $i = 1;
                    
                    foreach ($mail_data as $row) {
                        if($row['status']==1) $status = '<img src="'.base_url().'images/active.png" />';
                        
                        else $status = '<img src="'.base_url().'images/dactive.png" />';
                        
            ?>
            
                <tr>
                    
                    <td><?php echo $row['id']; ?></td>
                    
                    <td><?php echo $row['to']; ?></td>
                    
                    <td><?php echo $row['subject']; ?></td>
                    
                    <td><div style="max-width: 450px; max-height: 200px; overflow: auto;"><?php echo $row['message']; ?></div></td>
                    
                    <td align="center"><?php echo $status; ?></td>
                    
                    <td><?php if($row['sent_date']!='0000-00-00 00:00:00') echo date('d/m/Y',strtotime($row['sent_date'])); ?></td>
                    
                    <td><?php if($row['created_date']!='0000-00-00 00:00:00') echo date('d/m/Y',strtotime($row['created_date'])); ?></td>
                    
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
