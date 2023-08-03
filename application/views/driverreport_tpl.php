<?php
//print_r($export_data);

?>
            <link href="<?php echo base_url();?>css/jquery-ui-1.7.2/themes/base/ui.all.css" rel="stylesheet" type="text/css" />
            
            <link href="<?php echo base_url();?>css/ui.multiselect.css" rel="stylesheet" type="text/css" />
            
            <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validation.js"></script>
            
            
            
            <script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.4.2.min.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8.custom.min.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/ui.multiselect.js"></script>
            
            <script type="text/javascript" src="<?php echo base_url();?>js/datepicker.js"></script> 
            
            <link href="<?php echo base_url();?>css/datepicker.css" rel="stylesheet" type="text/css" />
            

<div id="wrapper">
    
    <!-- Form content -->
    <div align="center" class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/drivers.png" /><span class="page-headlbl">DRIVER REPORT</span></div>
        <form name="driverreport-form" method="post" action="<?php echo site_url(); ?>driverreport/search" onsubmit="return frmValidate()">
        <table width="60%">
            
            <tr>
                
                <td align="left">From Date</td>
                
                <td align="left">
                    <input type="text" name="fdate" id="fdate" value="<?php echo $this->session->userdata('fdate'); ?>"/>
                </td>

                <td align="left">To Date</td>
                
                <td align="left">
                    <input type="text" name="todate" id="todate" value="<?php echo $this->session->userdata('todate'); ?>"/>
                </td>
                
            </tr>
            
            <tr><td colspan="4">&nbsp;</td></tr>
            
            <tr>
                
                <td align="left">Driver</td>
                
                <td align="left">
                                                                          <?php
                                                                                        $options = $getdriverval;
                                                                                        $opt = 'id="driver"';
                                                                                        $optval = $this->session->userdata('driver');
                                                                                         echo form_dropdown('driver_val', $options,$optval,$opt);
                                                                          ?>
                    
                    <input type="hidden" name="alldrivers_val" id="alldrivers-val" value="<?php echo $this->session->userdata('alldriversval'); ?>"/>
                    
                    <br/><input type="checkbox" name="all_drivers" id="all-drivers" onclick="driverunAssign(this.checked,'all')" <?php if($this->session->userdata('alldrivers')=='on') echo 'checked'; else ''; ?>/>
                     <label>All drivers</label>
                     <span id="driv_load_img"></span>
                    
                    <br/><input type="checkbox" name="driv_assign" id="driv-assign" onclick="driverunAssign(this.checked,'ass')" <?php if($this->session->userdata('drivassign')=='on') echo 'checked'; else ''; ?>/>
                     <label>Un-assign drivers</label>
                     
                </td>

                <td style="display: none;">Terminal</td>
                
                <td style="display: none;">
                    
                    <select name="terminal" id="terminal" style="width: 150px;">
                        <option value="0">Select</option>
                        <option value="Dom" <?php if($this->session->userdata('terminal')=='Dom') echo 'selected'; ?>>Domestic</option>
                        <option value="Int" <?php if($this->session->userdata('terminal')=='Int') echo 'selected'; ?>>International</option>
                    </select>
                    
                </td>
                
            </tr>

            <tr><td colspan="4">&nbsp;</td></tr>
            
            <tr style="display: none;">
                <td>Direction</td>
                
                <td>

                    <select name="direction" id="direction" style="width: 150px;">
                        <option value="both" <?php if($this->session->userdata('direction')=='both') echo 'selected'; ?>>Both</option>
                        <option value="arrival" <?php if($this->session->userdata('direction')=='arrival') echo 'selected'; ?>>Arrival</option>
                        <option value="departure" <?php if($this->session->userdata('direction')=='departure') echo 'selected'; ?>>Departure</option>
                    </select>
                    
                </td>
                
            </tr>
            
            <tr style="display: none;"><td colspan="4">&nbsp;</td></tr>
            
            <tr style="display: none;">
                
                <td>Suburb</td>
                
                <td colspan="3">
                    <?php

                    $this->hsdb->hs_open();
                    $rows = $this->hsdb->hs_read_rows_sql("SELECT id,suburb from suburb order by suburb");
                   // print_r($rows);
                                                        $no = 0;    
                                                        $sales_cont = '';

                                                        $output_array = array();
                                                      foreach ($rows as $row)
                                                      {
                                                            @$output_array[$no]->id = $row->id;
                                                            $output_array[$no]->suburb = $row->suburb;
                                                            $no++;
                                                      }
                                                      for($j=0;$j<count($output_array);$j++)
                                                      {
                                                         $id = $output_array[$j]->id;
                                                         $display = $output_array[$j]->suburb;
                                                         
                                                            $selected = $this->driverreport_model->multiServiceSelect($id,$this->session->userdata('suburbval'));
                                                                $sales_cont .= "<option value='$display' $selected>".$display. "</option>";
                                                      } 
                                                      
                    
                    ?>
                                                        <select name="suburb[]" id="suburb" class="multiservice" multiple="multiple" >
                                                            <?php
                                                                echo $sales_cont; 
                                                            ?>
                                                        </select> 
                    
                </td>

            </tr>
            
        </table>
        
        <br/><br/>
        <div align="center"><input type="submit" name="sub-btn" id="sub-btn" class="bgbtn" value="Submit" /></div>
    </form>
        
        <br/><br/>
        <div id="excel-link"></div>

        <!-- </table> -->
    
    </div>
    <!-- Form content end -->

</div>

            
<script>

        // multi suburb
                $(function(){
			$(".multiservice").multiselect();
		});
		function multi_selection()
		{
			$(".multiservice").multiselect();
		}
// multi suburb end

    $('#fdate').datepick();
    
    $('#todate').datepick();

    function frmValidate() {
        var fval = $('#fdate').val();
        if(fval=='') {
            alert('Enter from date');
            $('#fdate').focus();
            return false;
        }
        else return true;
    }
    
        function suggestDriver(inputString){
		if(inputString.length == 0) {
			$('#suggestions-dr').fadeOut();
		} else {
		$('#driver').addClass('load');
			$.post("<?php echo base_url(); ?>common/driver", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions-dr').fadeIn();
					$('#suggestionsList-dr').html(data);
					$('#driver').removeClass('load');
				}
                                else {
					$('#suggestions-dr').fadeIn();
					$('#suggestionsList-dr').html('<ul><li>No record found</li></ul>');
					$('#driver').removeClass('load');
                                    
                                }
			});
		} 

	}

	function fillDriver(thisValue,name) {
		//alert(thisValue);
                $('#driver').val(name);
                $('#driver_val').val(thisValue);
		setTimeout("$('#suggestions-dr').fadeOut();", 600);
        }
        
        function driverunAssign(val,type) {
            //alert(val);
            if(type=='ass') {
                if(val==true) {
                    $('#driver').val('0');

                    $('#driver').attr('disabled',true);
                    $('#all-drivers').attr('disabled',true);

                }
                else {

                    $('#driver').val('');

                    $('#driver').attr('disabled',false);
                    $('#all-drivers').attr('disabled',false);

                }
            }
            if(type=='all') {
                
                
                if(val==true) {

                $('#sub-btn').attr('disabled',true);
                $('#driv_load_img').html('<img src="<?php echo base_url(); ?>images/loader.gif" />');

                    $('#driver').attr('disabled',true);
                    $('#driv-assign').attr('disabled',true);
                    
                    $.post("<?php echo base_url(); ?>common/alldrivers", {dataval: ''}, function(data){
                        //alert(data);
                        if(data) {
                            $('#alldrivers-val').val(data);
                            $('#sub-btn').attr('disabled',false);
                            $('#driv_load_img').html('');
                        }
                        else {
                            alert('No driver found');
                            $('#sub-btn').attr('disabled',false);
                            $('#driv_load_img').html('');
                        }
                    });

                }
                else {

                    $('#driver').attr('disabled',false);
                    $('#driv-assign').attr('disabled',false);
                    $('#alldrivers-val').val('');
                    $('#sub-btn').attr('disabled',false);
                    $('#driv_load_img').html('');
                }
            }
            
        } 

        function exportExcel() {
           
                    $('#excel-link').html('<img src="<?php echo base_url(); ?>images/loader.gif" />');
			$.post("<?php echo base_url(); ?>report_excel.php", {dataval: <?php echo json_encode($result_data); ?>}, function(data){
                           // alert(data);
                           if(data=='empty') $('#excel-link').html('No record found');
                           else $('#excel-link').html('<a style="color: #047ea7; text-decoration: underline;" href="<?php echo base_url(); ?>excel_open.php?type=excel&filename='+data+'&mode=driver">Click here to download</a>');
                        });
            
        }
        
        // this function called on date picker plugin
        function getDateval() {
            
        }
        
</script>     

<?php
    if($this->session->userdata('drivassign')=='on') echo '<script>driverunAssign(true,\'ass\');</script>';
    if($this->session->userdata('alldrivers')=='on') echo '<script>driverunAssign(true,\'all\');</script>';
    
    if(isset($_POST['sub-btn'])) {
        if(count($result_data)>0) {
            echo "<script>exportExcel()</script>";
        
        }
        else {
            echo "<script>alert('No record found');</script>";
        } 
    }
?>