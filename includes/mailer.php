<?php

    // The 4 rows below install PHPMailer using Composer, following PHPMailer best practices:
    // https://github.com/PHPMailer/PHPMailer#installation--loading
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require (__DIR__.'/../vendor/autoload.php');
    class Mailer {

        

    public function send_smtp_mail($subject, $body, $from, $to) {
        
        $mail = new PHPMailer(true); 
        
        try{
            // Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;               // to enables SMTP debug (for testing)
            // $mail->SMTPDebug = 1;                                    // 1 to enables SMTP debug (for testing), 0 to disable debug (for production)
            $mail->SMTPDebug = 0;                                       // 0 to disable!!! debug (for production)
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.titan.email';// Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = MAILER_USER_NAME;                       // SMTP username
            $mail->Password   = MAILER_USER_PASSWORD;                   // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged ---'tls' for amazon service SES
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->SetFrom($from); // was ($from, $from_name)
            // $mail->AddReplyTo($reply_to); //unecessary for now
            $mail->AddAddress($to); //was ($to, $to_name)
            $mail->Subject    = $subject;
            $mail->MsgHTML($body);
    
            if($mail->Send()) {
                return true;
            }
        } 
        
        catch (phpmailerException $e) {
            echo $e->errorMessage();  //Pretty error messages from PHPMailer
        } 
        
        catch (Exception $e) {
            echo $e->getMessage();  //Boring error messages from anything else!
        }
    }



}

?>