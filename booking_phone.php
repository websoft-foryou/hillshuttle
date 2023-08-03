<?php



//error_reporting(0);

include('db_connect.php');

/*
$query = "select id,dep_phone,dep_mobile,arr_phone,arr_mobile from booking";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
    
    $book = $row['id'];
    
    $depphone = trim($row['dep_phone']);
    $depmobile = trim($row['dep_mobile']);
    $arrphone = trim($row['arr_phone']);
    $arrmobile = trim($row['arr_mobile']);

    if((substr($depphone,0,1)=='4') && (strlen($depphone)=='9')) {
        $depphone = '0'.$depphone;
    }
    
    if((substr($depmobile,0,1)=='4') && (strlen($depmobile)=='9')) {
        $depmobile = '0'.$depmobile;
    }
    
    if((substr($arrphone,0,1)=='4') && (strlen($arrphone)=='9')) {
        $arrphone = '0'.$arrphone;
    }

    if((substr($arrmobile,0,1)=='4') && (strlen($arrmobile)=='9')) {
        $arrmobile = '0'.$arrmobile;
    }
    
    $upquery = "update booking set dep_phone='".$depphone."',dep_mobile='".$depmobile."',arr_phone='".$arrphone."',arr_mobile='".$arrmobile."' where id='".$book."'";
    mysql_query($upquery);
} 
*/


$query = "select id,dep_phone,dep_mobile,arr_phone,arr_mobile from multipickup_booking";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
    
    $book = $row['id'];
    
    $depphone = trim($row['dep_phone']);
    $depmobile = trim($row['dep_mobile']);
    $arrphone = trim($row['arr_phone']);
    $arrmobile = trim($row['arr_mobile']);

    if((substr($depphone,0,1)=='4') && (strlen($depphone)=='9')) {
        $depphone = '0'.$depphone;
    }
    
    if((substr($depmobile,0,1)=='4') && (strlen($depmobile)=='9')) {
        $depmobile = '0'.$depmobile;
    }
    
    if((substr($arrphone,0,1)=='4') && (strlen($arrphone)=='9')) {
        $arrphone = '0'.$arrphone;
    }

    if((substr($arrmobile,0,1)=='4') && (strlen($arrmobile)=='9')) {
        $arrmobile = '0'.$arrmobile;
    }
    
    $upquery = "update multipickup_booking set dep_phone='".$depphone."',dep_mobile='".$depmobile."',arr_phone='".$arrphone."',arr_mobile='".$arrmobile."' where id='".$book."'";
    mysql_query($upquery);
} 

?>