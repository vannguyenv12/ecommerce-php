<?php require_once './config/email.php';

function sendMail($token)
{
    global $mail;
    $mail->setFrom('confirmation@registered-domain', 'Shopping');
    $mail->addAddress('receiver@gmail.com', 'Me');
    $mail->Subject = 'Reset Password';
    // Set HTML 
    $mail->isHTML(TRUE);
    $message = "Dear User,\n\nPlease click on the following link to reset your password:\n\n<a href='http://shop.test/reset-password.php?token=$token'>Rest Link</a>\n\nThank you.";
    $mail->Body = $message;

    // send the message
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}
