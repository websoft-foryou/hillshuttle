<?php
                            $decimal_pointer = $this->config->item('decimal_point');
                            $dec_point = $decimal_pointer['point'];
                            $prg = $decimal_pointer['prr'];
                            $dollar = $decimal_pointer['dollar'];

?>
<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <div id="airport-form-content" style="display: inline;">
            
            <table class="table-forms" style="width: 100%">
        
                <tr>
                    <td>
                        <input type="hidden" name="countval[]" id="countval" />
                        <input type="hidden" name="moreautoval" id="moreautoval" value="<?php echo $mid; ?>" />
                        <div align="right" style="margin-top:-20px; width: 220px;">
                            <table>
                                            <tr>
                                                <td><input type="text" value="Suburb" class="lable-text-box" readonly/> <span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -100px;">*</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Address1" class="lable-text-box" readonly/> <span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -85px;">*</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Address2" class="lable-text-box" readonly/> </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Contact Number1" class="lable-text-box" readonly/> <span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -40px;">*</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Contact Number2" class="lable-text-box" readonly/> </td>
                                            </tr>
                                
                            </table>
                            <?php if($formval=='1' && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>   
                                    <div id="airport-fields">
                                        <table>
                                            <tr>
                                                <td><input type="text" value="Flight" class="lable-text-box" readonly /> <span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -100px;">*</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Origin / Dest" class="lable-text-box" readonly/> </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Airline" class="lable-text-box" readonly/> </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Terminal" class="lable-text-box" readonly/> </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    <table>
                                            <tr>
                                                <td><input type="text" value="Date" class="lable-text-box" readonly /> <span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -100px;">*</span></td>
                                            </tr>
                                    </table>
                            
                            <?php if(($formval=='2' || $formval=='3' || $formval=='4') && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>   
                                    <div id="non-airport-fields">
                                        <table>
                                            <tr>
                                                <td><input type="text" value="Time" class="lable-text-box" readonly style="width: 155px;"/></td>
                                            </tr>
                                        </table>
                                    </div>
                            <?php } ?>
                            <?php if($formval=='1' && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>   
                                    <div id="airport-time-fields">
                                        <table>
                                            <tr>
                                                <td><input type="text" value="Flight Time" class="lable-text-box" readonly/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" value="Itinerary Time" class="lable-text-box" readonly /> <span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -50px;">*</span></td>
                                            </tr>
                                        </table>
                                    </div>
                            <?php } ?>
                            <div style="position: relative; left: -5px;">
                                    <table>
                                        <tr>
                                            <td><input type="text" value="Pickup Time" class="lable-text-box" readonly/><span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -50px;">*</span></td>
                                        </tr>
                                    </table>
                            
                                    <table>
                                        <tr>
                                            <td><input type="text" value="Passengers" class="lable-text-box" readonly/></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" value="Baby Seats" class="lable-text-box" readonly/></td>
                                        </tr>
                                        <tr>
                                            <td><span style="position:relative; top: 20px;"><input type="text" value="Comments" class="lable-text-box" readonly/></span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="position:relative; top: 45px;"><input type="text" value="Estimated Fare" class="lable-text-box" readonly/><span style="color: red; font-weight: bold; font-size: 17px; color: #BD0F3A; position: relative; left: -50px;">*</span></span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="position:relative; top: 45px;"><input type="text" value="Driver" class="lable-text-box" readonly/></span></td>
                                        </tr>

                                    </table>
                            </div>
                        </div>
                    </td>
                    
               <?php if($type=='departure' || $type=='both') { ?>
                    <td>
                        
                        <div id="departure_contents" style="display: inline; width: 250px;">
                        <table>
                            <tr>
                                <th style="color: #0D7FBC;">Departure</th>
                            </tr>
                        </table>
                                    <table>
                                            <tr>
                                                <td>
                                                    <input type="text" name="dep_suburb[]" id="dep-suburb_<?php echo $mid; ?>" autocomplete="off" value="<?php echo $book_row[0]['dep_suburb']; ?>" onkeyup="getmoreSuburb(this.value,0,'<?php echo $mid; ?>');" />
                                                    <div class="suggestionsBox-sub" id="suggestions-sub_<?php echo $mid; ?>" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                                                        <div class="suggestionList" id="suggestionsList-sub_<?php echo $mid; ?>"> &nbsp; </div>
                                                      </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="dep_address1[]" id="dep-address1_<?php echo $mid; ?>" value="<?php echo $book_row[0]['dep_address1']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="dep_address2[]" id="dep-address2_<?php echo $mid; ?>" value="<?php echo $book_row[0]['dep_address2']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="dep_mobile[]" id="dep-mobile_<?php echo $mid; ?>" value="<?php if($book_row[0]['dep_mobile']!='0') echo $book_row[0]['dep_mobile']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="dep_phone[]" id="dep-phone_<?php echo $mid; ?>" value="<?php if($book_row[0]['dep_phone']!='0') echo $book_row[0]['dep_phone']; ?>" /></td>
                                            </tr>
                                
                                    </table>
                                    <?php if($formval=='1' && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>
                                    <div id="airport-depfields">
                                        <table>
                                            <tr>
                                                <td><input type="text" name="dep_flight[]" id="dep-flight_<?php echo $mid; ?>" value="<?php echo $book_row[0]['dep_flight']; ?>" onkeyup="getmoreFlight(this.value,0,'<?php echo $mid; ?>');" autocomplete="off" style="text-transform: uppercase;"/></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div id="deporigin-val_<?php echo $mid; ?>"><?php if($book_row[0]['dep_origin']!='<span>flight not found</span>' && $book_row[0]['dep_origin']!='') echo $book_row[0]['dep_origin']; else { ?><span class="ferror">Flight not found</span><?php } ?></div>
                                                    <input type="hidden" name="dep_origin[]" id="dep-origin_<?php echo $mid; ?>" value="<?php echo $book_row[0]['dep_origin']; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="dep_airline[]" id="dep-airline_<?php echo $mid; ?>" value="<?php echo $book_row[0]['dep_airline']; ?>"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="radio" name="dep_terminal[<?php echo $mid; ?>]" value="Dom" id="dep-dom_<?php echo $mid; ?>" <?php if($book_row[0]['dep_terminal']=='Dom') echo 'checked'; ?>/>Domestic<input type="radio" name="dep_terminal[<?php echo $mid; ?>]" value="Int" id="dep-int_<?php echo $mid; ?>" <?php if($book_row[0]['dep_terminal']=='Int') echo 'checked'; ?>/>International</td>
                                            </tr>
                                        </table>
                                    </div>
                            <?php } ?>
                                    <table>
                                            <tr>
                                                <td><input type="text" name="dep_date[]" id="dep-date_<?php echo $mid; ?>" value="<?php if($book_row[0]['dep_date']) echo date('d/m/Y',strtotime($book_row[0]['dep_date'])); ?>" onclick="datemoreDirec('D')"/></td>
                                            </tr>
                                    </table>
                        <?php if(($formval=='2' || $formval=='3' || $formval=='4') && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>
                        <div id="non-airport-depfields">
                            <table>
                                <tr>
                                    <td>
                                        <!-- <input type="text" name="bookinfo[dep_time]" id="dep-time" value="<?php //echo $book_row[0]['dep_time']; ?>"/> -->
                                        <?php
                                        $thours = '';
                                        $tmin = '';
                                        $tam = '';
                                        
                                            if($book_row[0]['dep_time']!='') {
                                                $exp_time = explode(':',$book_row[0]['dep_time']);
                                                $thours = $exp_time[0];
                                                //$tmin = substr($exp_time[1],0,-2);
                                                $tmin = $exp_time[1];
                                                if($tmin==0) $tmin = '00';
                                                $tam = substr($exp_time[1],2);
                                             //   print_r($yourmin);
                                            }
                                        ?>
                                        
                                        <select name="dep_time[]" id="dep-time_<?php echo $mid; ?>">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($thours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="dep_tmin[]" id="dep-tmin_<?php echo $mid; ?>">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=0;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($tmin) && $tmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                       <!-- <select name="dep_tam" id="dep-tam">
                                            <option value="0">Select</option>
                                            <option value="am" <?php if($tam=='am') echo 'selected'; ?>>am</option>
                                            <option value="pm" <?php if($tam=='pm') echo 'selected'; ?>>pm</option>
                                        </select> -->
                                        
                                    </td>
                                </tr>
                            </table>
                        </div>
                            <?php } ?>
                            
                        <?php if($formval=='1' && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>    
                        <div id="airport-time-depfields">
                            <table>
                                <tr>
                                    <td><input type="text" name="dep_ourtime[]" id="dep-ourtime_<?php echo $mid; ?>" readonly value="<?php echo $book_row[0]['dep_ourtime']; ?>"/></td>
                                </tr>
                                <tr>
                                    <td>
                                        <!-- <input type="text" name="bookinfo[dep_yourtime]" id="dep-yourtime" value="<?php //echo $book_row[0]['dep_yourtime']; ?>"/> -->
                                        <?php
                                        $yourhours = '';
                                        $yourmin = '';
                                        $youram = '';
                                        
                                            if($book_row[0]['dep_yourtime']!='') {
                                                $exp_yourtime = explode(':',$book_row[0]['dep_yourtime']);
                                                $yourhours = $exp_yourtime[0];
                                                //$yourmin = substr($exp_yourtime[1],0,-2);
                                                $yourmin = $exp_yourtime[1];
                                                if($yourmin==0) $yourmin = '00';
                                                $youram = substr($exp_yourtime[1],2);
                                             //   print_r($yourmin);
                                            }
                                        ?>
                                        <select name="dep_yourhours[]" id="dep-yourhours_<?php echo $mid; ?>">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($yourhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="dep_yourmin[]" id="dep-yourmin_<?php echo $mid; ?>">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=0;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($yourmin) && $yourmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                      <!--  <select name="dep_youram" id="dep-youram">
                                            <option value="0">Select</option>
                                            <option value="am" <?php if($youram=='am') echo 'selected'; ?>>am</option>
                                            <option value="pm" <?php if($youram=='pm') echo 'selected'; ?>>pm</option>
                                        </select> -->
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php } ?>
                            
                            <table>
                                <tr>
                                    <td>
                                        <!-- <input type="text" name="bookinfo[dep_pickuptime]" id="dep_pickuptime" value="<?php //if($book_row[0]['dep_pickuptime']) echo $book_row[0]['dep_pickuptime']; ?>"/> -->
                                        <?php
                                        $pickhours = '';
                                        $pickmin = '';
                                        $pickam = '';
                                        
                                            if($book_row[0]['dep_pickuptime']!='') {
                                                $exp_picktime = explode(':',$book_row[0]['dep_pickuptime']);
                                                $pickhours = $exp_picktime[0];
                                                //$pickmin = substr($exp_picktime[1],0,-2);
                                                $pickmin = $exp_picktime[1];
                                                if($pickmin==0) $pickmin = '00';
                                                $pickam = substr($exp_picktime[1],2);
                                             //   print_r($yourmin);
                                            }
                                        ?>
                                        
                                        <select name="dep_pickhours[]" id="dep-pickhours_<?php echo $mid; ?>" onchange="depmoreEstcharge(this.value,'<?php echo $mid; ?>')">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($pickhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="dep_pickmin[]" id="dep-pickmin_<?php echo $mid; ?>">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=0;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if(!empty($pickmin) && $pickmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                      <!--  <select name="dep_pickam" id="dep-pickam">
                                            <option value="0">Select</option>
                                            <option value="am" <?php if($pickam=='am') echo 'selected'; ?>>am</option>
                                            <option value="pm" <?php if($pickam=='pm') echo 'selected'; ?>>pm</option>
                                        </select> -->
                                        
                                    </td>
                                </tr>
                            </table>
                            
                            <table>
                                <tr>
                                    <td>
                                        <select name="dep_passengers[]" id="dep-passengers_<?php echo $mid; ?>" onchange="getmorePassengers(this.value,0,'<?php echo $mid; ?>')">
                                            <option value="0">Select</option>
                                            <?php
                                                for($i=1;$i<11;$i++) {
                                            ?>
                                                <option value="<?php echo $i; ?>" <?php if($book_row[0]['dep_passengers']==$i || $i==1) echo 'selected'; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="dep_babyseats[]" id="dep-babyseats_<?php echo $mid; ?>" onchange="getmoreBaby(this.value,0,'<?php echo $mid; ?>')">
                                            <option value="0">Select</option>
                                            <?php
                                                for($i=1;$i<4;$i++) {
                                            ?>
                                                <option value="<?php echo $i; ?>" <?php if($book_row[0]['dep_babyseats']==$i) echo 'selected'; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><textarea name="dep_comments[]" id="dep-comments_<?php echo $mid; ?>" cols="20" rows="3"><?php echo $book_row[0]['dep_comments']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="dep_estfare[]" id="dep-estfare_<?php echo $mid; ?>" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', ''); ?>" onkeyup="getmoreTotalestimate('<?php echo $mid; ?>')"/>
                                        <input type="hidden" name="depautoest[]" id="depautoest_<?php echo $mid; ?>" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', ''); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                                                          <?php
                                                                                        $options = $getdriverval;
                                                                                        $opt = 'id="dep_driver"';
                                                                                        $optval = $book_row[0]['dep_driver'];
                                                                                        $nameopt = 'dep_driver[]';
                                                                                         echo form_dropdown($nameopt, $options,$optval,$opt);
                                                                          ?>
                                    
                                </td>
                                </tr>

                        </table>
                        </div>
                    </td>
              <?php } ?>
              
              <?php if($type=='arrival' || $type=='both') { ?>
                    <td>
                        <div id="arrival_contents" style="display: inline; width: 250px;">
                        <table style="margin-top: 16px;">
                            <tr>
                                <th style="color: #0D7FBC;">Arrival</th>
                            </tr>
                        </table>
                                    <table>
                                            <tr>
                                                <td>
                                                    <input type="text" name="arr_suburb[]" id="arr-suburb_<?php echo $mid; ?>" autocomplete="off" value="<?php echo $book_row[0]['arr_suburb']; ?>" onkeyup="getmoreSuburb(this.value,1,'<?php echo $mid; ?>');" />
                                                    <div class="suggestionsBox-sub" id="suggestions-arrsub_<?php echo $mid; ?>" style="display: none;"> <img src="<?php echo base_url();?>images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                                                        <div class="suggestionList" id="suggestionsList-arrsub_<?php echo $mid; ?>"> &nbsp; </div>
                                                      </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="arr_address1[]" id="arr-address1_<?php echo $mid; ?>" value="<?php echo $book_row[0]['arr_address1']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="arr_address2[]" id="arr-address2_<?php echo $mid; ?>" value="<?php echo $book_row[0]['arr_address2']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="arr_mobile[]" id="arr-mobile_<?php echo $mid; ?>" value="<?php if($book_row[0]['arr_mobile']!='0') echo $book_row[0]['arr_mobile']; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="arr_phone[]" id="arr-phone_<?php echo $mid; ?>" value="<?php if($book_row[0]['arr_phone']!='0') echo $book_row[0]['arr_phone']; ?>" /></td>
                                            </tr>
                                
                                    </table>
                            <?php if($formval=='1' && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>
                                    <div id="airport-arrfields">
                                        <table>
                                            
                                            <tr>
                                                <td><input type="text" name="arr_flight[]" id="arr-flight_<?php echo $mid; ?>" value="<?php echo $book_row[0]['arr_flight']; ?>" onkeyup="getmoreFlight(this.value,1,'<?php echo $mid; ?>');" autocomplete="off" style="text-transform: uppercase;"/></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div id="arrorigin-val_<?php echo $mid; ?>"><?php if($book_row[0]['arr_origin']!='<span>flight not found</span>' && $book_row[0]['arr_origin']!='') echo $book_row[0]['arr_origin']; else { ?><span class="ferror">Flight not found</span><?php } ?></div>
                                                    <input type="hidden" name="arr_origin[]" id="arr-origin_<?php echo $mid; ?>" value="<?php echo $book_row[0]['arr_origin']; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="arr_airline[]" id="arr-airline_<?php echo $mid; ?>" value="<?php echo $book_row[0]['arr_airline']; ?>"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="radio" name="arr_terminal[<?php echo $mid; ?>]" value="Dom" id="arr-dom_<?php echo $mid; ?>" <?php if($book_row[0]['arr_terminal']=='Dom') echo 'checked'; ?>/>Domestic<input type="radio" name="arr_terminal[<?php echo $mid; ?>]" value="Int" id="arr-int_<?php echo $mid; ?>" <?php if($book_row[0]['arr_terminal']=='Int') echo 'checked'; ?>/>International</td>
                                            </tr>
                                            
                                        </table>
                                    </div>
                            <?php } ?>
                                <table>
                                            <tr>
                                                <td><input type="text" name="arr_date[]" id="arr-date_<?php echo $mid; ?>" value="<?php if($book_row[0]['arr_date']) echo date('d/m/Y',strtotime($book_row[0]['arr_date'])); ?>" onclick="datemoreDirec('A')"/></td>
                                            </tr>
                                
                                </table>
                            
                        <?php if(($formval=='2' || $formval=='3' || $formval=='4') && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>    
                        <div id="non-airport-arrfields">
                            <table>
                                <tr>
                                    <td>
                                        <!-- <input type="text" name="bookinfo[arr_time]" id="arr-time" value="<?php //echo $book_row[0]['arr_time']; ?>"/> -->
                                        <?php
                                        $arrthours = '';
                                        $arrtmin = '';
                                        $arrtam = '';
                                        
                                            if($book_row[0]['arr_time']!='') {
                                                $arrexp_time = explode(':',$book_row[0]['arr_time']);
                                                $arrthours = $arrexp_time[0];
                                                //$arrtmin = substr($arrexp_time[1],0,-2);
                                                $arrtmin = $arrexp_time[1];
                                                $arrtam = substr($arrexp_time[1],2);
                                             //   print_r($yourmin);
                                            }
                                        ?>
                                        
                                        <select name="arr_time[]" id="arr-time_<?php echo $mid; ?>">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arrthours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="arr_tmin[]" id="arr-tmin_<?php echo $mid; ?>">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=01;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arrtmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                   <!--     <select name="arr_tam" id="arr-tam">
                                            <option value="0">Select</option>
                                            <option value="am" <?php if($arrtam=='am') echo 'selected'; ?>>am</option>
                                            <option value="pm" <?php if($arrtam=='pm') echo 'selected'; ?>>pm</option>
                                        </select> -->
                                        
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php } ?>
                        <?php if($formval=='1' && ($type=='departure' || $type=='arrival' || $type=='both')) { ?>    
                        <div id="airport-time-arrfields">
                            <table>
                                <tr>
                                    <td><input type="text" name="arr_ourtime[]" id="arr-ourtime_<?php echo $mid; ?>" readonly value="<?php echo $book_row[0]['arr_ourtime'] ?>"/></td>
                                </tr>
                                <tr>
                                    <td>
                                        <!-- <input type="text" name="bookinfo[arr_yourtime]" id="arr-yourtime" value="<?php //echo $book_row[0]['arr_yourtime'] ?>"/> -->
                                        <?php
                                        $arryourhours = '';
                                        $arryourmin = '';
                                        $arryouram = '';
                                        
                                            if($book_row[0]['arr_yourtime']!='') {
                                                $exp_yourtime = explode(':',$book_row[0]['arr_yourtime']);
                                                $arryourhours = $exp_yourtime[0];
                                               // $arryourmin = substr($exp_yourtime[1],0,-2);
                                                 $arryourmin = $exp_yourtime[1];
                                                $arryouram = substr($exp_yourtime[1],2);
                                             //   print_r($yourmin);
                                            }
                                        ?>
                                        <select name="arr_yourhours[]" id="arr-yourhours_<?php echo $mid; ?>">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arryourhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="arr_yourmin[]" id="arr-yourmin_<?php echo $mid; ?>">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=1;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arryourmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                     <!--   <select name="arr_youram" id="arr-youram">
                                            <option value="0">Select</option>
                                            <option value="am" <?php if($arryouram=='am') echo 'selected'; ?>>am</option>
                                            <option value="pm" <?php if($arryouram=='pm') echo 'selected'; ?>>pm</option>
                                        </select> -->
                                        
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php } ?>    
                            <table>
                                <tr>
                                    <td>
                                        <!-- <input type="text" name="bookinfo[arr_pickuptime]" id="arr_pickuptime" value="<?php //if($book_row[0]['arr_pickuptime']) echo $book_row[0]['arr_pickuptime']; ?>"/> -->
                                        <?php
                                        $arrpickhours = '';
                                        $arrpickmin = '';
                                        $arrpickam = '';
                                        
                                            if($book_row[0]['arr_pickuptime']!='') {
                                                $exp_picktime = explode(':',$book_row[0]['arr_pickuptime']);
                                                $arrpickhours = $exp_picktime[0];
                                               // $arrpickmin = substr($exp_picktime[1],0,-2);
                                                $arrpickmin = $exp_picktime[1];
                                                $arrpickam = substr($exp_picktime[1],2);
                                               // print_r($exp_picktime);
                                            }
                                        ?>
                                        
                                        <select name="arr_pickhours[]" id="arr-pickhours_<?php echo $mid; ?>" onchange="arrmoreEstcharge('<?php echo $mid; ?>')">
                                            <option value="0">Hours</option>
                                            <?php
                                            for($i=1;$i<24;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arrpickhours==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                        <select name="arr_pickmin[]" id="arr-pickmin_<?php echo $mid; ?>" onchange="arrmoreEstcharge('<?php echo $mid; ?>')">
                                            <option value="0">Minutes</option>
                                            <?php
                                            for($i=01;$i<60;$i++) {
                                                ?>
                                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($arrpickmin==$i) echo 'selected'; else echo ''; ?>><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        
                                      <!--  <select name="arr_pickam" id="arr-pickam">
                                            <option value="0">Select</option>
                                            <option value="am" <?php if($arrpickam=='am') echo 'selected'; ?>>am</option>
                                            <option value="pm" <?php if($arrpickam=='pm') echo 'selected'; ?>>pm</option>
                                        </select> -->
                                        
                                    </td>
                                </tr>
                            </table>
                            
                            <table>
                                <tr>
                                    <td>
                                        <select name="arr_passengers[]" id="arr-passengers_<?php echo $mid; ?>" onchange="getmorePassengers(this.value,1,'<?php echo $mid; ?>')">
                                            <option value="0">Select</option>
                                            <?php
                                                for($i=1;$i<11;$i++) {
                                            ?>
                                                <option value="<?php echo $i; ?>" <?php if($book_row[0]['arr_passengers']==$i  || $i==1) echo 'selected'; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="arr_babyseats[]" id="arr-babyseats_<?php echo $mid; ?>" onchange="getmoreBaby(this.value,1,'<?php echo $mid; ?>')">
                                            <option value="0">Select</option>
                                            <?php
                                                for($i=1;$i<4;$i++) {
                                            ?>
                                                <option value="<?php echo $i; ?>" <?php if($book_row[0]['arr_babyseats']==$i) echo 'selected'; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><textarea name="arr_comments[]" id="arr-comments_<?php echo $mid; ?>" cols="20" rows="3"><?php echo $book_row[0]['arr_comments']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="arr_estfare[]" id="arr-estfare_<?php echo $mid; ?>" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', ''); ?>" onkeyup="getmoreTotalestimate('<?php echo $mid; ?>')"/>
                                        <input type="hidden" name="arrautoest[]" id="arrautoest_<?php echo $mid; ?>" value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', ''); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                                                          <?php
                                                                                        $options = $getdriverval;
                                                                                        $opt = 'id="arr_driver"';
                                                                                        $optval = $book_row[0]['arr_driver'];
                                                                                        $nameopt = 'arr_driver[]';
                                                                                         echo form_dropdown($nameopt, $options,$optval,$opt);
                                                                          ?>
                                    
                                </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>

                        </table>
                        </div>
                    </td>
                <?php } ?>
                </tr>
                
            </table>
        </div>
                        <hr/>
                        <div class="other-head">Fare Details</div>
                            
                        <div>
                            <table style="margin-left: 105px;">
                                <tr>
                                    <td class="field-left">Total Estimated Fare: </td>
                                    <td class="field-right">
                                        
                                        <?php if($type=='both') { ?><div id="both-total"><input type="text" name="total[]" id="fare-total_<?php echo $mid; ?>" readonly value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['total']), $dec_point, '.', ''); ?>" style="position:relative; left: 7px;"/></div><?php } ?>
                                        
                                        <?php if($type=='departure') { ?><div id="dep-total"><input type="text" name="dep-totalval" id="dep-totalval_<?php echo $mid; ?>" readonly value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['dep_estfare']), $dec_point, '.', ''); ?>" style="position:relative; left: 7px;"/></div><?php } ?>
                                        
                                        <?php if($type=='arrival') { ?><div id="arr-total"><input type="text" name="arr-totalval" id="arr-totalval_<?php echo $mid; ?>" readonly value="<?php echo $dollar.number_format(preg_replace($prg, '', $book_row[0]['arr_estfare']), $dec_point, '.', ''); ?>" style="position:relative; left: 7px;"/></div><?php } ?>
                                        
                                    </td>
                                </tr>
                                
                                <tr>
                                    
                                    <td class="field-left">Payment Method: </td>
                                    
                                    <td class="field-right">
                                        <select name="payment_method[]" id="payment-method_<?php echo $mid; ?>" style="position:relative; left: 7px;">
                                            <option value="0"></option>
                                            <option value="cash" <?php if($book_row[0]['payment_method']=='cash') echo 'selected'; ?>>Cash</option>
                                            <option value="cheque" <?php if($book_row[0]['payment_method']=='cheque') echo 'selected'; ?>>Cheque</option>
                                            <option value="cheque" <?php if($book_row[0]['payment_method']=='direct debit') echo 'selected'; //ACorr ?>>Direct Debit</option>
                                            <option value="account" <?php if($book_row[0]['payment_method']=='account') echo 'selected'; ?>>Account</option>
                                            <option value="other" <?php if($book_row[0]['payment_method']=='other') echo 'selected'; ?>>Other</option>
                                        </select>
                                    </td>
                                    
                                </tr>
                                
                            </table>
                        </div>
        </div>
        
    </div>
    <!-- Form content end -->

    <script type="text/javascript">
    
    $('#dep-date_<?php echo $mid; ?>').datepick();
    
    $('#arr-date_<?php echo $mid; ?>').datepick();

    $('#dep-mobile_<?php echo $mid; ?>').numeric();
    
    $('#arr-mobile_<?php echo $mid; ?>').numeric();

    $('#dep-phone_<?php echo $mid; ?>').numeric();
    
    $('#arr-phone_<?php echo $mid; ?>').numeric();

    $('#dep-estfare_<?php echo $mid; ?>').numeric();
    
    $('#arr-estfare_<?php echo $mid; ?>').numeric();

    </script>
