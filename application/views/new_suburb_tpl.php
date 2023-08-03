<?php
$urledit = $this->uri->segment('2');
if($urledit=='add') {
    $suburb_row = array();
    $suburb_row[] = $sub_row;
}
?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validation.js"></script>

<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/book_blue.png" /><span class="page-headlbl"><?php if($suburb_row[0]->id) echo 'EDIT SUBURB'; else echo 'ADD SUBURB'; ?></span></div>
        
        <br/>
        <form name="login_form" method="post" action="add" onSubmit="return addValidate()">
            
            <table class="table-forms" align="center">
                
                <tr>
                    
                    <td class="field-left">Post code: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="hidden" name="suburb_id" value="<?php echo $suburb_row[0]->id; ?>" />
                        
                        <input type="text" name="postcode" id="postcode" value="<?php echo $suburb_row[0]->postcode; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Suburb: <span class="red-star">*</span></td>
                    
                    <td>
                        <input type="hidden" name="suburb_val" id="suburb_val" value="<?php echo $suburb_row[0]->suburb; ?>" />
                        <input type="text" name="suburb" id="suburb" value="<?php echo $suburb_row[0]->suburb; ?>"/>
                    
                    </td>
                
                </tr>
                
                <tr>
                    
                    <td class="field-left">1: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f0" id="f0" value="<?php echo $suburb_row[0]->A_fee[0]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">2: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f1" id="f1" value="<?php echo $suburb_row[0]->A_fee[1]; ?>"/>
                    
                    </td>
                
                </tr>

                <tr>
                    
                    <td class="field-left">3: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f2" id="f2" value="<?php echo $suburb_row[0]->A_fee[2]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">4: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f3" id="f3" value="<?php echo $suburb_row[0]->A_fee[3]; ?>"/>
                    
                    </td>
                
                </tr>
                <tr>
                    
                    <td class="field-left">5: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f4" id="f4" value="<?php echo $suburb_row[0]->A_fee[4]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">6: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f5" id="f5" value="<?php echo $suburb_row[0]->A_fee[5]; ?>"/>
                    
                    </td>
                
                </tr>
                <tr>
                    
                    <td class="field-left">7: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f6" id="f6" value="<?php echo $suburb_row[0]->A_fee[6]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">8: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f7" id="f7" value="<?php echo $suburb_row[0]->A_fee[7]; ?>"/>
                    
                    </td>
                
                </tr>
                <tr>
                    
                    <td class="field-left">9: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f8" id="f8" value="<?php echo $suburb_row[0]->A_fee[8]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">10: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f9" id="f9" value="<?php echo $suburb_row[0]->A_fee[9]; ?>"/>
                    
                    </td>
                
                </tr>

                <tr>
                    
                    <td class="field-left">Charter: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="f10" id="f10" value="<?php echo $suburb_row[0]->A_fee[10]; ?>"/>
                    
                    </td>
                
                </tr>
                
            </table>
            <br/>
            
            <div align="center"><input type="submit" name="client" value="Save" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'suburb"><span class="bgbtn">Cancel</span></a>'; ?></div>
    </form>
    
   </div>
    <!-- Form content end -->
</div>


<script type="text/javascript">
    $('#postcode').numeric();
        $('#f0').numeric();
        $('#f1').numeric();
        $('#f2').numeric();
        $('#f3').numeric();
        $('#f4').numeric();
        $('#f5').numeric();
        $('#f6').numeric();
        $('#f7').numeric();
        $('#f8').numeric();
        $('#f9').numeric();
        $('#f10').numeric();
     //   $('#suburb').alpha();
        
    function addValidate() {
       
        var flag = true;
        
        var postcode = $('#postcode').val();
        var suburb = $('#suburb').val();
        var exsuburbval = $('#suburb_val').val();
        var f0 = $('#f0').val();
        var f1 = $('#f1').val();
        var f2 = $('#f2').val();
        var f3 = $('#f3').val();
        var f4 = $('#f4').val();
        var f5 = $('#f5').val();
        var f6 = $('#f6').val();
        var f7 = $('#f7').val();
        var f8 = $('#f8').val();
        var f9 = $('#f9').val();
        var f10 = $('#f10').val();
        
        if(postcode=='') {
            document.getElementById('postcode').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('postcode').style.backgroundColor='white';
        
        if(suburb=='') {
            document.getElementById('suburb').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('suburb').style.backgroundColor='white';
        
        if(suburb!='') {
            
             var regex = new RegExp("^[a-zA-Z ]+$");
             if(suburb.match(regex)==null) {
                alert('Special Character and Number not allowed');
                document.getElementById('suburb').focus();
                flag = false;
             }
                 
            if((suburb.length)<3) {
                alert('Suburb should be minimum of 3 characters in length');
                document.getElementById('suburb').focus();
                flag = false;            
            }
        }
        
        if(f0=='') {
            document.getElementById('f0').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f0').style.backgroundColor='white';

        if(f1=='') {
            document.getElementById('f1').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f1').style.backgroundColor='white';

        if(f2=='') {
            document.getElementById('f2').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f2').style.backgroundColor='white';

        if(f3=='') {
            document.getElementById('f3').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f3').style.backgroundColor='white';

        if(f4=='') {
            document.getElementById('f4').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f4').style.backgroundColor='white';

        if(f5=='') {
            document.getElementById('f5').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f5').style.backgroundColor='white';

        if(f6=='') {
            document.getElementById('f6').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f6').style.backgroundColor='white';

        if(f7=='') {
            document.getElementById('f7').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f7').style.backgroundColor='white';

        if(f8=='') {
            document.getElementById('f8').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f8').style.backgroundColor='white';

        if(f9=='') {
            document.getElementById('f9').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f9').style.backgroundColor='white';

        if(f10=='') {
            document.getElementById('f10').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('f10').style.backgroundColor='white';

        if(suburb!='') {
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php echo base_url(); ?>ajax.php",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{suburbval: "suburbvalidate",queryString: ""+suburb+"",exsuburb: ""+exsuburbval+""},
                       success: function(data){
                         //  alert(data);
                            if(data!=0) { 
                                alert('Suburb already exist. Please use another one.'); 
                                 document.getElementById('suburb').style.backgroundColor='yellow';
                                 flag = false;
                            }
                            else document.getElementById('suburb').style.backgroundColor='white';

                       }
                    });
            });
            
        }

        if(flag) return true;
        else return false;
    }
</script>