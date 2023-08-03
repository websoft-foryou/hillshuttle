<?php
    include('db_connect.php');
    
$query = "SELECT * FROM mail_trigger WHERE status=0 AND `to` !='' AND `from` !='' AND date(created_date) = '".date('Y-m-d')."' LIMIT 0,50";
//$query = "SELECT * FROM mail_trigger WHERE id=27656 LIMIT 0,50";
    $result = mysql_query($query);
    while($data = mysql_fetch_array($result)) {
        $auto = $data['id'];
        
        $from = $data['from'];
        
        $to = $data['to'];
        
        $subject = $data['subject'];
        
        $message = $data['message'];
        
        $headers = mailHeader($from);

        $mstatus = mail($to, $subject, $message, $headers);
        $curdate = date('Y-m-d H:i:s');
        
        if($mstatus==1) {
            $uquery = "UPDATE mail_trigger SET status=1,error_content='".$mstatus."',sent_date='".$curdate."' WHERE id='".$auto."'";
            mysql_query($uquery);
        }
    }
    
    function mailHeader($mail_address) {
        $headers = '';
                           $eol="\r\n";
                           $headers .= 'From: '.$mail_address.$eol;
                           
                           $headers .= "Return-Path: ".$mail_address." \r\n";
                            
                           $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n";
        return $headers;
    }
    
?>