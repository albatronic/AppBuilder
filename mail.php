<?php

require_once 'class/class.phpmailer.php';
require_once 'class/class.pop3.php'; // required for POP before SMTP

$pop = new POP3();
$pop->Authorise('mail.albatronic.com', 110, 30, 'info@albatronic.com', 'i1234o', 1);

$mail = new PHPMailer();

$body = file_get_contents('vendocamara.yml');
$body = eregi_replace("[\]", '', $body);

//$mail->IsSMTP();
$mail->IsHTML(true);
$mail->PluginDir = "class/";
$mail->CharSet = "utf-8";
$mail->SMTPDebug = 2;
$mail->Host = 'mail.albatronic.com';

$mail->SetFrom('info@albatronic.com', 'Albatronic');

$mail->AddReplyTo("info@albatronic.com", "Albatronic");

$mail->Subject = "PHPMailer Test Subject via POP before SMTP, basic";

$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);
$mail->AddAddress("sergio.perez@albatronic.com", "Sergio");
$mail->Timeout = 60;
//$mail->AddAttachment("sergio.png");      // attachment
//$mail->AddAttachment("interpral.jpg"); // attachment

if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
