<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'includes/session.php';

if (isset($_POST['reset'])) {
    $email = $_POST['email'];

    $conn = $pdo->open();

    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email=:email");
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch();

    if ($row['numrows'] > 0) {
        //generate code
        $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($set), 0, 15);
        try {
            $stmt = $conn->prepare("UPDATE users SET reset_code=:code WHERE id=:id");
            $stmt->execute(['code' => $code, 'id' => $row['id']]);

            $message = "
					<h2>Password Reset</h2>
					<p>Your Account:</p>
					<p>Email: " . $email . "</p>
					<p>Please click the link below to reset your password.</p>
					<a href='http://localhost/furniture_shop/password_reset.php?code=" . $code . "&user=" . $row['id'] . "'>Reset Password</a>
				";

            //Load phpmailer
            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'housefurniture786@gmail.com';
                $mail->Password = 'ppsswwrrdd@17';
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('housefurniture786@gmail.com','Furniture House');

                //Recipients
                $mail->addAddress($email);
                $mail->addReplyTo('housefurniture786@gmail.com','Furniture House');

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Furniture House Site Password Reset';
                $mail->Body = $message;

                $mail->send();

                $_SESSION['success'] = 'Password reset link sent';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    } else {
        $_SESSION['error'] = 'Email not found';
    }

    $pdo->close();
} else {
    $_SESSION['error'] = 'Input email associated with account';
}

header('location: password_forgot.php');
?>