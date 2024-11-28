<?php

require "PHPMailerAutoload.php";// it will be in PHPMailer
require "class.smtp.php";// it will be in PHPMailer
require "class.phpmailer.php";// it will be in PHPMailer


$response = array();
$email = "ak.rathod0603@gmail.com";
$messageBody="Test Mail";
$subject = "Test ";

if(!empty($email)){

    
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // authentication enabled
        $mail->IsHTML(true); 
        $mail->SMTPSecure = 'tls';//turn on to send html email
        // $mail->Host = "ssl://smtp.zoho.com";
        $mail->Host = "smtp.gmail.com";//you can use gmail 
        $mail->Port = 587;
        $mail->Username = "ak.rathod0603@gmail.com";
        $mail->Password = "ashish@interface11";
        $mail->SetFrom("ak.rathod0603@gmail.com", "Any demo alert");
        $mail->Subject = $subject;

        $mail->Body = $messageBody;
        $mail->AddAddress("ak.rathod0603@gmail.com");
        echo "yes";

        if(!$mail->send()) {
           echo "Mailer Error: " . $mail->ErrorInfo;
       } 
       else {
           echo "Message has been sent successfully";
      }
    }


else{
    $response["valid"] = false;
    $response["message"] = "Required field(s) missing";
    echo json_encode($response);
}


?>