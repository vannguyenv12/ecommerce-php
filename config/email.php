<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once './vendor/autoload.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
$mail->Username = '55fd40ae3b8660';
$mail->Password = '7470e3fa31f25c';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
