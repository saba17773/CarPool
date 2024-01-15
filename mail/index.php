<?php
    require("PHPMailerAutoload.php");

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();
    $mail->Host = 'idc.deestone.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = false;                               // Enable SMTP authentication
    $mail->Username = 'ea_webmaster@deestone.com'; // SMTP username
    $mail->Password = "c,]'4^j";                          // SMTP password
    $mail->CharSet = "utf-8";                           // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 2525;                                    // TCP port to connect to

    $mail->From = 'ea_webmaster@deestone.com';
    $mail->FromName = 'ea_webmaster@deestone.com';
    $mail->addAddress('harit_j@deestone.com');
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'ทดสอบส่ง Email';
    $mail->Body    = 'test test';
    $mail->AltBody = 'test test';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
?> 