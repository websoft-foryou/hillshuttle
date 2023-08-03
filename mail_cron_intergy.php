<?php
error_reporting(0);
    include_once "../lib/swift_required.php";

    include('db_connect.php');
    
    $query = "SELECT * FROM mail_trigger WHERE status=0 LIMIT 0,50 ";
    $result = mysql_query($query);
    while($data = mysql_fetch_array($result)) {
        $auto = $data['id'];
        
        $from = $data['from'];
        
        $to = $data['to'];
        
        $subject = $data['subject'];
        
        $message_body = $data['message'];
        if($to!='') {
        //$headers = mailHeader($from);
        $text = '';
        //   $mstatus = mail($to, $subject, $message, $headers);
        // This is your From email address
        $from = $from;
        // Email recipients
        $tomail = explode(',',$to);
        if(count($tomail)>0) $to = $tomail;
        else $to = $to;
        // Email subject
        $subject = $subject;
        // Mail content
        $html = $message_body;
        
        // Login credentials
        $username = 'intergy';
        $password = 'intergy123';

        // Setup Swift mailer parameters
        $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
        $transport->setUsername($username);
        $transport->setPassword($password);
        $swift = Swift_Mailer::newInstance($transport);


        // Create a message (subject)
        $message = new Swift_Message($subject);




        // attach the body of the email
        $message->setFrom($from);
        $message->setBody($html, 'text/html');
        $message->setTo($to);
        $message->addPart($text, 'text/plain');
        $error_val = '';
        // send message 
        if($recipients = $swift->send($message, $failures))
        {
            // This will let us know how many users received this message
            echo 'Mail sent to '.$recipients.' users';
        }
        // something went wrong =(
        else
        {
            $error_val = base64_encode($failures);
        }        
            $curdate = date('Y-m-d H:i:s');
            $uquery = "UPDATE mail_trigger SET status=1,error_content='".$error_val."',sent_date='".$curdate."' WHERE id='".$auto."'";
            mysql_query($uquery);
        
	}
    }
    
?>