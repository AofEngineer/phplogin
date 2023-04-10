<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

function mailsend($email, $subject, $comments, $name)
{
    $mail = new PHPMailer(true);

    // SMTP Settings
    $mail->isSMTP();
    $mail->CharSet = "utf-8"; //รับข้อมูลภาษาไทย
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "GuruitsolutionTH@gmail.com"; // enter your email address
    $mail->Password = "umfnjigexzzfdduy"; // enter your password
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    $mail->SMTPDebug = false;

    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress("$email"); // Send to mail
    $mail->Subject = $subject;
    $mail->Body = "Name(ชื่อ) : $name <br> Email(อีเมล์) : $email <br> Subject(หัวข้อ) : $subject <br> Message(ข้อความ) : $comments";

    if ($mail->send()) {
        $status = "success";
        $response = "Email is sent";
    } else {
        $status = "failed";
        $response = "Something is wrong" . $mail->ErrorInfo;
    }

    exit(json_encode(array("status" => $status, "response" => $response)));
    
}









    

    


?>
