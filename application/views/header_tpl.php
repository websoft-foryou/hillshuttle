<?php 
error_reporting(0); 

ini_set('memory_limit', '-1');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="utf-8"/>
            <title>Hills Airport Shuttle - <?php echo $title; ?></title>
            <link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.2.min.js"></script>

<script type="text/javascript">

$(document).ready(function()
{

$('#menuBar li').click(function()
{
  var url = $(this).find('a').attr('href');
  document.location.href = url;

});

$('#menuBar li').hover(function()
{
   
   //$(this).find('.menuInfo').slideDown();
   $(this).find('.menuInfo').css({visibility: "visible",display: "none"}).show(500);
},
function()
{
  
 // $(this).find('.menuInfo').slideUp();
  $(this).find('.menuInfo').css({visibility: "hidden"});

});

});


</script>
            
    </head>
    <body>
        <div id="header" style="margin-top: -45px;">
                <h1 id="logo"><image src="<?php echo base_url();?>images/logo1.png"/></h1>
        </div> 
        
<!-- top menu start -->
<div id="containermenu"> 
<div id="menuBarHolder">

<ul id="menuBar">
<?php if($this->session->userdata('sess_type')==1) { ?>
<li class="firstchild"><a href="javascript:#">System Setup</a>
    <div class="menuInfo">
        <div class="menu-cont"><?php echo anchor('/users','Users'); ?></div>
        <div class="menu-cont"><?php echo anchor('/drivers','Drivers'); ?></div>
        <div class="menu-cont"><?php echo anchor('/suburb','Maintain Suburbs'); ?></div>
        <div class="menu-cont"><?php echo anchor('/flight','Maintain Flights'); ?></div>
        <div class="menu-cont"><?php echo anchor('/emailtemp','Email Template'); ?></div>
    </div>
</li>
<?php } ?>
<li><a href="javascript:#">Bookings</a>
    <div class="menuInfo">
        <div class="menu-cont"><?php echo anchor('/clients','Clients'); ?></div>
        <div class="menu-cont"><?php echo anchor('/booking','Booking'); ?></div>
        <div class="menu-cont"><?php echo anchor('/daysheet','Daysheet'); ?></div>
    </div>
</li>
<li><a href="javascript:#">Reports</a>
    <div class="menuInfo">
        <div class="menu-cont"><?php echo anchor('/driverreport','Driver Report'); ?></div>
<?php if($this->session->userdata('sess_type')==1) { ?>        
        <div class="menu-cont"><?php echo anchor('/mail_log','Mail Log'); ?></div>
<?php } ?>
    </div>
</li>

</ul>
<span class="loggedin-txt">You are logged in as <?php echo $this->session->userdata('sess_username'); ?> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo base_url();?>index.php/logout" style="color:white; text-decoration: underline;">Logout</a></span>
</div>
</div>

