<?php
 include_once "../lib/swift_required.php";
 /*
  * Create the body of the message (a plain-text and an HTML version).
  * $text is your plain-text email
  * $html is your html version of the email
  * If the reciever is able to view html emails then only the html
  * email will be displayed
  */ 
  
  
 $text = "Hi!\nHow are you?\n";
 
 $html = "
       <html>
       <head></head>
       <body>
           <p>Hi!<br>
               How are you? Test Message<br>
           </p>
       </body>
       </html>";

 // This is your From email address
 $from = array('george@eesap.com.auu' => 'George');
 // Email recipients
 $to = array(
       'murugesan.muthusamy@intergy.com.au'=>'Srinivasan'
 );
 // Email subject
 $subject = 'Example PHP Email';

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

 // send message 
 if($recipients = $swift->send($message, $failures))
 {
     // This will let us know how many users received this message
     echo 'Message sent out to '.$recipients.' users';
 }
 // something went wrong =(
 else
 {
     echo "Something went wrong - ";
     print_r($failures);
 }
 

 
 
 ?>
 