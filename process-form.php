<?php
  
if($_POST) {
    $visitor_name = "";
    $visitor_email = "";
    $email_title = "";
    $concerned_department = "";
    $visitor_message = "";
    $email_body = "<div>";
      
    if(isset($_POST['visitor_name'])) {
        $visitor_name = filter_var($_POST['visitor_name'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Visitor Name:</b></label>&nbsp;<span>".$visitor_name."</span>
                        </div>";
    }
 
    if(isset($_POST['visitor_email'])) {
        $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['visitor_email']);
        $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
        $email_body .= "<div>
                           <label><b>Visitor Email:</b></label>&nbsp;<span>".$visitor_email."</span>
                        </div>";
    }
      
    if(isset($_POST['email_title'])) {
        $email_title = filter_var($_POST['email_title'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Reason For Contacting Us:</b></label>&nbsp;<span>".$email_title."</span>
                        </div>";
    }
      
    
      
    if(isset($_POST['visitor_message'])) {
        $visitor_message = filter_var($_POST['visitor_message'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Visitor Message:</b></label>
                           <div>".$visitor_message."</div>
                        </div>";
    }
    // PROCESS STATUS
    $error = "";
    //reCAPTCHA validation	
    $secret = "6LfrUtIeAAAAAAXu9gHo1-J7rtFgXpdOwGtBPtna"; 
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=".$_POST["g-recaptcha-response"];
    $verify = json_decode(file_get_contents($url));
    if (!$verify->success) { $error = "Invalid captcha"; }
	

////////////////   EMAIL RECIPIENT  /////////////////////
/////////////////////////////////////////////////////////
        $recipient = "info@adamwhite.tech";
    
      
    $email_body .= "</div>";
 
    $headers  = 'MIME-Version: 1.0' . "\r\n"
    .'Content-type: text/html; charset=utf-8' . "\r\n"
    .'From: ' . $visitor_email . "\r\n";
      
    if(!$error && mail($recipient, $email_title, $email_body, $headers)) {
        echo "<div style='font-family: Arial; width: 90vw;height:90vh;margin:auto;display:flex;flex-direction:column;justify-content:center;align-items:center;'><p>Thank you for contacting us, $visitor_name. We will get back in touch as quick as we can.</p>
        <p style='font-style: italic; font-weight: bold;margin-top:0;'>Adam White</p></div>";
    } else {
        echo "<div style='font-family: Arial; width: 90vw;height:90vh;margin:auto;display:flex;flex-direction:column;justify-content:center;align-items:center;'><p>We are sorry but the email did not go through. Please try again and remember to verify you are human.</p></div>";
    }
      
} else {
    echo '<p>Something went wrong</p>';
}
?>