<?php
$urledit = $this->uri->segment('2');
if($urledit=='add') {
    $flight_row = array();
    $flight_row[] = $sub_row;
}
?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validation.js"></script>

<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/flighticon.png" /><span class="page-headlbl"><?php if($flight_row[0]->id) echo 'EDIT FLIGHT'; else echo 'ADD FLIGHT'; ?></span></div>
        
        <br/>
        <form name="login_form" method="post" action="add" onSubmit="return addValidate()">
            
            <table class="table-forms" align="center">
                
                <tr>
                    
                    <td class="field-left">Flight: <span class="red-star">*</span></td>
                    
                    <td>
                        <input type="hidden" name="exflight" id="exflight" value="<?php echo $flight_row[0]->id; ?>" />
                        <input type="text" name="flight" id="flight" value="<?php echo $flight_row[0]->id; ?>" />
                    
                    </td>
                    
                    <td class="field-left">Airline: <span class="red-star">*</span></td>
                    
                    <td>
                        <input type="text" name="airline" id="airline" value="<?php echo $flight_row[0]->airline; ?>"/>
                    
                    </td>
                
                </tr>
                
                <tr>
                    
                    <td class="field-left">Terminal:</td>
                    
                    <td>
                        <input type="radio" name="term" value="D" <?php if($flight_row[0]->terminal=='D') echo 'checked=checked'; ?>/><label>Domestic</label>
                        <input type="radio" name="term" value="I" <?php if($flight_row[0]->terminal=='I') echo 'checked=checked'; ?>/><label>International</label>
                    
                    </td>
                    
                    <td class="field-left">Direction:</td>
                    
                    <td>
                        <input type="radio" name="dir" value="D" <?php if($flight_row[0]->direction=='D') echo 'checked=checked'; ?>/><label>Departure</label>
                        <input type="radio" name="dir" value="A" <?php if($flight_row[0]->direction=='A') echo 'checked=checked'; ?>/><label>Arrival</label>
                    
                    </td>
                
                </tr>

                <tr>
                    
                    <td class="field-left">Origin: <span class="red-star">*</span></td>
                    
                    <td>
                        
                        <input type="text" name="origin" id="origin" value="<?php echo $flight_row[0]->dest0; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Sunday: </td>
                    
                    <td>
                        
                        <input type="text" name="sun" id="sun" value="<?php echo $flight_row[0]->A_time[0]; ?>"/>
                    
                    </td>
                
                </tr>
                <tr>
                    
                    <td class="field-left">Monday: </td>
                    
                    <td>
                        
                        <input type="text" name="mon" id="mon" value="<?php echo $flight_row[0]->A_time[1]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Tuesday: </td>
                    
                    <td>
                        
                        <input type="text" name="tue" id="tue" value="<?php echo $flight_row[0]->A_time[2]; ?>"/>
                    
                    </td>
                
                </tr>
                <tr>
                    
                    <td class="field-left">Wednesday: </td>
                    
                    <td>
                        
                        <input type="text" name="wed" id="wed" value="<?php echo $flight_row[0]->A_time[3]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Thursday: </td>
                    
                    <td>
                        
                        <input type="text" name="thu" id="thu" value="<?php echo $flight_row[0]->A_time[4]; ?>"/>
                    
                    </td>
                
                </tr>

                <tr>
                    
                    <td class="field-left">Friday: </td>
                    
                    <td>
                        
                        <input type="text" name="fri" id="fri" value="<?php echo $flight_row[0]->A_time[5]; ?>"/>
                    
                    </td>
                    
                    <td class="field-left">Saturday: </td>
                    
                    <td>
                        
                        <input type="text" name="sat" id="sat" value="<?php echo $flight_row[0]->A_time[6]; ?>"/>
                    
                    </td>
                
                </tr>
                
            </table>
            <br/>
            
            <div align="center"><input type="submit" name="client" value="Save" class="bgbtn"/>&nbsp;&nbsp;&nbsp;<?php echo '<a href="'.base_url().'flight"><span class="bgbtn">Cancel</span></a>'; ?></div>
    </form>
    
   </div>
    <!-- Form content end -->
</div>


<script type="text/javascript">
    $('#flight').alphanumeric();
        
    function addValidate() {
       
        var flag = true;
        var numcheck = /^([0-9]+):([0-9])([0-9])(am|pm)$/;
        
        var flval = $('#flight').val();
        var airval = $('#airline').val();
        var orval = $('#origin').val();
        var exflightval = $('#exflight').val();
        var sun = $('#sun').val();
        var mon = $('#mon').val();
        var tue = $('#tue').val();
        var wed = $('#wed').val();
        var thu = $('#thu').val();
        var fri = $('#fri').val();
        var sat = $('#sat').val();
        
        if(flval=='') {
            document.getElementById('flight').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('flight').style.backgroundColor='white';
        
        if(airval=='') {
            document.getElementById('airline').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('airline').style.backgroundColor='white';

        if(orval=='') {
            document.getElementById('origin').style.backgroundColor='yellow';
            flag = false;
        }
        else document.getElementById('origin').style.backgroundColor='white';


        if(flval!='') {
            $(document).ready(function() {
                    $.ajax({
                       url: "<?php echo base_url(); ?>ajax.php",
                       type:"POST",
                       cache: false,
                       async:false,
                       data:{flightval: "flightvalidate",queryString: ""+flval+"",exflight: ""+exflightval+""},
                       success: function(data){
                         //  alert(data);
                            if(data!=0) { 
                                alert('Flight already exist. Please use another one.'); 
                                 document.getElementById('flight').style.backgroundColor='yellow';
                                 flag = false;
                            }
                            else document.getElementById('flight').style.backgroundColor='white';

                       }
                    });
            });
            
        }
// sunday
        if(sun!='') {
            if(numcheck.test(sun)==false) {
                alert('Invalid time. It should be like 11:10am or 04:00pm. Please ensure that you use a colon : between the hours and the minutes');
                $('#sun').css('background','yellow');
                flag = false;
            }
            else {
            $('#sun').css('background','white');
                var splsun = sun.split(':');
                if(splsun[0]>12) {
                    alert('Hours should be 12 or less than 12');
                    $('#sun').css('background','yellow');
                    flag = false;
                }
                
                var splsec = splsun[1].split('pm');
                if(splsec.length==2) {
                    if(splsec[0]>59) {
                        alert('Minutes should be less than 60');
                        $('#sun').css('background','yellow');
                        flag = false;
                    }    
                }
                else {
                    var splsec = splsun[1].split('am');
                    if(splsec.length==2) {
                        if(splsec[0]>59) {
                            alert('Minutes should be less than 60');
                            $('#sun').css('background','yellow');
                            flag = false;
                        }    
                    }    
                }
                
            }
        }
// monday
        if(mon!='') {
            if(numcheck.test(mon)==false) {
                alert('Invalid time. It should be like 11:10am or 04:00pm. Please ensure that you use a colon : between the hours and the minutes');
                $('#mon').css('background','yellow');
                flag = false;
            }
            else {
            $('#mon').css('background','white');
                var splmon = mon.split(':');
                if(splmon[0]>12) {
                    alert('Hours should be 12 or less than 12');
                    $('#mon').css('background','yellow');
                    flag = false;
                }
                
                var monsplsec = splmon[1].split('pm');
                if(monsplsec.length==2) {
                    if(monsplsec[0]>59) {
                        alert('Minutes should be less than 60');
                        $('#mon').css('background','yellow');
                        flag = false;
                    }    
                }
                else {
                    var monsplsec = splmon[1].split('am');
                    if(monsplsec.length==2) {
                        if(monsplsec[0]>59) {
                            alert('Minutes should be less than 60');
                            $('#mon').css('background','yellow');
                            flag = false;
                        }    
                    }    
                }
                
            }
        }

// tuesday
        if(tue!='') {
            if(numcheck.test(tue)==false) {
                alert('Invalid time. It should be like 11:10am or 04:00pm. Please ensure that you use a colon : between the hours and the minutes');
                $('#tue').css('background','yellow');
                flag = false;
            }
            else {
            $('#tue').css('background','white');
                var spltue = tue.split(':');
                if(spltue[0]>12) {
                    alert('Hours should be 12 or less than 12');
                    $('#tue').css('background','yellow');
                    flag = false;
                }
                
                var tuesplsec = spltue[1].split('pm');
                if(tuesplsec.length==2) {
                    if(tuesplsec[0]>59) {
                        alert('Minutes should be less than 60');
                        $('#tue').css('background','yellow');
                        flag = false;
                    }    
                }
                else {
                    var tuesplsec = spltue[1].split('am');
                    if(tuesplsec.length==2) {
                        if(tuesplsec[0]>59) {
                            alert('Minutes should be less than 60');
                            $('#tue').css('background','yellow');
                            flag = false;
                        }    
                    }    
                }
                
            }
        }

// wednesday
        if(wed!='') {
            if(numcheck.test(wed)==false) {
                alert('Invalid time. It should be like 11:10am or 04:00pm. Please ensure that you use a colon : between the hours and the minutes');
                $('#wed').css('background','yellow');
                flag = false;
            }
            else {
            $('#wed').css('background','white');
                var splwed = wed.split(':');
                if(splwed[0]>12) {
                    alert('Hours should be 12 or less than 12');
                    $('#wed').css('background','yellow');
                    flag = false;
                }
                
                var wedsplsec = splwed[1].split('pm');
                if(wedsplsec.length==2) {
                    if(wedsplsec[0]>59) {
                        alert('Minutes should be less than 60');
                        $('#wed').css('background','yellow');
                        flag = false;
                    }    
                }
                else {
                    var wedsplsec = splwed[1].split('am');
                    if(wedsplsec.length==2) {
                        if(wedsplsec[0]>59) {
                            alert('Minutes should be less than 60');
                            $('#wed').css('background','yellow');
                            flag = false;
                        }    
                    }    
                }
                
            }
        }

// Thursday
        if(thu!='') {
            if(numcheck.test(thu)==false) {
                alert('Invalid time. It should be like 11:10am or 04:00pm. Please ensure that you use a colon : between the hours and the minutes');
                $('#thu').css('background','yellow');
                flag = false;
            }
            else {
            $('#thu').css('background','white');
                var splthu = thu.split(':');
                if(splthu[0]>12) {
                    alert('Hours should be 12 or less than 12');
                    $('#thu').css('background','yellow');
                    flag = false;
                }
                
                var thusplsec = splthu[1].split('pm');
                if(thusplsec.length==2) {
                    if(thusplsec[0]>59) {
                        alert('Minutes should be less than 60');
                        $('#thu').css('background','yellow');
                        flag = false;
                    }    
                }
                else {
                    var thusplsec = splthu[1].split('am');
                    if(thusplsec.length==2) {
                        if(thusplsec[0]>59) {
                            alert('Minutes should be less than 60');
                            $('#thu').css('background','yellow');
                            flag = false;
                        }    
                    }    
                }
                
            }
        }

// Friday
        if(fri!='') {
            if(numcheck.test(fri)==false) {
                alert('Invalid time. It should be like 11:10am or 04:00pm. Please ensure that you use a colon : between the hours and the minutes');
                $('#fri').css('background','yellow');
                flag = false;
            }
            else {
            $('#fri').css('background','white');
                var splfri = fri.split(':');
                if(splfri[0]>12) {
                    alert('Hours should be 12 or less than 12');
                    $('#fri').css('background','yellow');
                    flag = false;
                }
                
                var frisplsec = splfri[1].split('pm');
                if(frisplsec.length==2) {
                    if(frisplsec[0]>59) {
                        alert('Minutes should be less than 60');
                        $('#fri').css('background','yellow');
                        flag = false;
                    }    
                }
                else {
                    var frisplsec = splfri[1].split('am');
                    if(frisplsec.length==2) {
                        if(frisplsec[0]>59) {
                            alert('Minutes should be less than 60');
                            $('#fri').css('background','yellow');
                            flag = false;
                        }    
                    }    
                }
                
            }
        }

// Saturday
        if(sat!='') {
            if(numcheck.test(sat)==false) {
                alert('Invalid time. It should be like 11:10am or 04:00pm. Please ensure that you use a colon : between the hours and the minutes');
                $('#sat').css('background','yellow');
                flag = false;
            }
            else {
            $('#sat').css('background','white');
                var splsat = sat.split(':');
                if(splsat[0]>12) {
                    alert('Hours should be 12 or less than 12');
                    $('#sat').css('background','yellow');
                    flag = false;
                }
                
                var satsplsec = splsat[1].split('pm');
                if(satsplsec.length==2) {
                    if(satsplsec[0]>59) {
                        alert('Minutes should be less than 60');
                        $('#sat').css('background','yellow');
                        flag = false;
                    }    
                }
                else {
                    var satsplsec = splsat[1].split('am');
                    if(satsplsec.length==2) {
                        if(satsplsec[0]>59) {
                            alert('Minutes should be less than 60');
                            $('#sat').css('background','yellow');
                            flag = false;
                        }    
                    }    
                }
                
            }
        }


        if(flag) return true;
        else return false;
    }
</script>