
            <script type='text/javascript' src='<?php echo base_url();?>js/jquery.autocomplete.js'></script>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
            
<div id="wrapper">
    
    <!-- Form content -->
    <div class="div-content">
        
        <div class="page-head"><img src="<?php echo base_url();?>images/new-client.png" /><span class="page-headlbl">CLIENT</span></div>
        
    
            <table class="table-forms" align="center">
        
                <tr>
            
                    <td class="field-left">Client: </td>
            
                    <td>
                
                        <input type="text" name="client" id="client" autocomplete="off" value="" onkeyup="return clientId(this.value)" style="width: 285px; padding: 5px;"/>
                        <a href="<?php echo base_url();?>clients/add" class="newclient-title">Add New Client</a>
                        <br/><span style="font-size: 10px; color: gray;">Start typing to view existing clients</span>            
                        
                    </td>
            
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <br/>
                            
                    </td>
                </tr>
        
            </table>
            
    <div id="client-data" style="display: none;">
        
        <table align="center" cellspacing="5" cellpadding="5" width="60%">
            
            <tr>
                
                <td>First Name: </td>
                
                <td><div id="first-name"></div></td>

                <td>Surname: </td>
                
                <td><div id="sur-name"></div></td>
                
            </tr>

            <tr>
                
                <td>Gender: </td>
                
                <td><div id="gender"></div></td>

                <td>Address1: </td>
                
                <td><div id="address1"></div></td>
                
            </tr>
            
            <tr>
                
                <td>Address2: </td>
                
                <td><div id="address2"></div></td>

                <td>Suburb: </td>
                
                <td><div id="suburb"></div></td>
                
            </tr>

            <tr>
                
                <td>Contact Number1: </td>
                
                <td><div id="connum1"></div></td>

                <td>Contact Number2: </td>
                
                <td><div id="connum2"></div></td>
                
            </tr>
            
            <tr>
                
                <td>Email: </td>
                
                <td><div id="email"></div></td>

                <td>Comments: </td>
                
                <td><div id="comments"></div></td>
                
            </tr>
            
                <tr>
                    <td colspan="4">
                        <br/><span id="book-link"></span>&nbsp;&nbsp;&nbsp; <span id="editclient-link"></span>
                            
                    </td>
                </tr>
            
        </table>
        
    </div>
        
    </div>
    <!-- Form content end -->

</div>

            <script>
$().ready(function() {   
    
$.post("<?php echo base_url(); ?>common/client", {queryString: "client"}, function(data){
                                
                                var dataval = [];
                                
                                var mmval = eval('(' + data + ')');
                                
                                var cname = mmval.name;
                                var splname = cname.split('~~');
                              //  alert(splname.length);
                                var cval = mmval.to;
                                var splto = cval.split('~~');
                                var clicount = splname.length;
                                
                                for(var k=0; k<clicount; k++) {
                                  dataval[k] = { name: ""+splname[k]+"", to: ""+splto[k]+"" }
                                } 
                                
                              
                                $("#client").autocomplete(dataval, {
                                                minChars: 0,
                                                width: 310,
                                                autoFill: false,
                                                formatItem: function(row, i, max) {
                                                        return row.name;
                                                }
                                        });    

                                $("#client").result(log).next().click(function() {
                                                            $(this).prev().search();

                                                    });
                                                    
                                function log(event, data, formatted) {
                                        
                                        getClientdata(data.to);
                                        
                                        if(data.to) {
                                            
                                            $('#book-link').html('<a href="<?php echo base_url();?>booking/add/?cid='+data.to+'" class="newclient-title">Add Booking</a>')
                                            $('#editclient-link').html('<a href="<?php echo base_url();?>clients/edit/'+data.to+'" class="newclient-title">Edit Client</a>')
                                            
                                        }
                                        else {
                                            $('#book-link').html('');
                                            
                                            $('#editclient-link').html('');
                                        }
                                }
                              
			});
                        
                        
                        });
            
            function clientId(val) {
                if(val=='') {
                    
                    $('#book-link').html('');
                    
                    $('#editclient-link').html('');
                    
                    $('#client-data').css('display','none');
                }
                
            }
            
            function getClientdata(id) {

            if(id) {
                
                $('#client-data').css('display','inline');
                
                $(document).ready(function() {
                        $.ajax({
                           url: "<?php echo base_url(); ?>clients/getclient",
                           type:"POST",
                           cache: false,
                           async:false,
                           data:{id: ""+id+""},
                           success: function(data){
                              // alert(data);
                               if(data) {
                                  var client = eval('(' + data + ')');

                                         var fval = client.fname;
                                         var lval = client.lname;
                                         var streetval = client.address1;
                                         var address2 = client.address2;
                                         var mobileval = client.mobile;
                                         var phoneval = client.phone;
                                         var emailval = client.email;
                                         var suburbval = client.suburb;
                                         var cligender = client.gender;
                                         var cmtval = client.comments;
                                         var cid = id;
                                         
                                         if(cligender=='M') var gendval = 'Male';
                                         else if(cligender=='F') var gendval = 'Female';
                                             
                                         $('#first-name').html(fval);
                                         
                                         $('#sur-name').html(lval);
                                         
                                         $('#gender').html(gendval);
                                         
                                         $('#address1').html(streetval);
                                         
                                         $('#address2').html(address2);
                                         
                                         $('#suburb').html(suburbval);
                                         
                                         $('#connum1').html(mobileval);
                                         
                                         $('#connum2').html(phoneval);
                                         
                                         $('#email').html(emailval);
                                         
                                         $('#comments').html(cmtval);
                               }

                           }
                       });
                 });
                 
                }

            }
        </script>            