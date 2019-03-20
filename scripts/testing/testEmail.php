<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website";
}

require $root.'/scripts/testing/PHPMailer/src/Exception.php';
require $root.'/scripts/testing/PHPMailer/src/PHPMailer.php';
require $root.'/scripts/testing/PHPMailer/src/SMTP.php';

//Load Composer's autoloader
// require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    // $mail->isSMTP();                                      // Set mailer to use SMTP
    // $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    // $mail->SMTPAuth = true;                               // Enable SMTP authentication
    // $mail->Username = 'user@example.com';                 // SMTP username
    // $mail->Password = 'secret';                           // SMTP password
    // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    // $mail->Port = 587;                                    // TCP port to connect to

    // $mail->SMTPAuth = true; // There was a syntax error here (SMPTAuth)
    // $mail->SMTPSecure = 'STARTTLS';
    // $mail->Host = "smtp.sparkpostmail.com";
    // $mail->Mailer = "smtp";
    // $mail->Port = 587;
    // $mail->Username = "SMTP_Injection";
    // $mail->Password = "143d18c65175aa0dc2a4f3096e71ac068099e775";

    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true; // There was a syntax error here (SMPTAuth)
    //$mail->SMTPSecure = 'tls';
    $mail->SMTPSecure = 'ssl';
    //$mail->Host = "smx1.web-hosting.com";
    $mail->Host = "cuhvz.com"; //"server122.web-hosting.com";
    $mail->Mailer = "smtp";
    $mail->Port = 465;
    $mail->Username = "cuhvz@cuhvz.com";
    $mail->Password = "QuI5R.[.5fn7";

    //Recipients
    $mail->setFrom('cuhvz@cuhvz.com', 'cuhvz');
    $mail->addAddress('jobr3255@colorado.edu', 'Joe User');     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    echo "Sending message...  \n";
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>

<?php

// $root = $_SERVER["DOCUMENT_ROOT"];
// if(empty($root)){
//   $root = "/home/josh/cuhvz_website/";
// }
//
// require $root."/classes/phpmailer/mail.php";

// $mail = new Mail();
// $mail->setFrom("test@test.com");
// $mail->addAddress("josh.brown.3255@gmail.com");
// $mail->subject("test email");
// $mail->body("hi I hope this worked");
// $mail->send();


define('GUSER', 'josh.brown.3255@gmail.com'); // GMail username
define('GPWD', 'z7yFj51f2'); // GMail password


//smtpmailer('jobr3255@colorado.edu', 'josh.brown.3255@gmail.com', 'josh', 'test mail message', 'Hello World!');

function smtpmailer($to, $from, $from_name, $subject, $body) {
  global $error;
  try{
    $mail = new PHPMailer();  // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if(!$mail->Send()) {
      $error = 'Mail error: '.$mail->ErrorInfo;
      return false;
    } else {
      $error = 'Message sent!';
      return true;
    }
    // echo "Sending message...  \n";
    // $mail->send();
    // echo 'Message has been sent';
  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  }
}

?>
