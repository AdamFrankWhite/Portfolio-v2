<?php
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
  
require 'vendor/autoload.php';
$visitor_name = filter_var($_POST['visitor_name'], FILTER_SANITIZE_STRING);
$visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['visitor_email']);
$visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
$email_title = filter_var($_POST['email_title'], FILTER_SANITIZE_STRING);
$visitor_message = filter_var($_POST['visitor_message'], FILTER_SANITIZE_STRING);
$mail = new PHPMailer(true);
  
try {
     //Server settings
     $mail->SMTPDebug = 0;                      //Enable verbose debug output
     $mail->isSMTP();                                            //Send using SMTP
    //  $mail->Host       = 'gator3015.hostgator.com';                     //Set the SMTP server to send through
    $mail->Host       = 'mail.adamwhite.tech';
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'mailer@adamwhite.tech';                     //SMTP username
     $mail->Password   = 'PASSWORD';                               //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 
     //Recipients
     $mail->setFrom('mailer@adamwhite.tech', $visitor_name); // Mailer
     $mail->addAddress('info@adamwhite.tech', 'Adam White');     //Add a recipient
     $mail->addReplyTo($visitor_email, $visitor_name);
 
 
     //Content
     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = $email_title;
     $mail->From = "mailer@adamwhite.tech";
     $mail->Body    = $visitor_message;
     $mail->AltBody = $visitor_message;


     // PROCESS STATUS
     $error = "";
     //reCAPTCHA validation	
     $secret = "6LchePAeAAAAAC78wkbHp7B-CFm0UR26aNNk5jFn"; 
     $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=".$_POST["g-recaptcha-response"];
     $verify = json_decode(file_get_contents($url));
     if (!$verify->success) { $error = "Invalid captcha"; }

     if(!$error && $mail->send()) {
        echo "<div style='font-family: Arial; width: 90vw;height:90vh;margin:auto;display:flex;flex-direction:column;justify-content:center;align-items:center;'><p>Thank you for contacting us, $visitor_name. We will get back in touch as quick as we can.</p>
        <p style='font-style: italic; font-weight: bold;margin-top:0;'>Adam White</p></div>";
    } else {
        echo "<div style='font-family: Arial; width: 90vw;height:90vh;margin:auto;display:flex;flex-direction:column;justify-content:center;align-items:center;'><p>We are sorry but the email did not go through. Please try again and remember to verify you are human.</p></div>";
    }
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
  
?>