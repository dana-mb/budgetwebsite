<?php

    class Mailer {

        

    public function send_smtp_mail($subject, $body, $from, $to) {
        
        $mail = new PHPMailer(true); 
        
        try{
            //Server settings
            $mail->SMTPDebug = 1;                                       // 1 to enables SMTP debug (for testing), 0 to disable debug (for production)
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'email-smtp.eu-central-1.amazonaws.com';// Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'AKIAYQJ3TIINQNSW22QI';                 // SMTP username
            $mail->Password   = 'BJ8HFWgRD0eIFYgohEZoBaeD3ARU/QFnSTYlrSqCHd7r';  // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged ---'tls' for amazon service SES
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->SetFrom($from); // was ($from, $from_name)
            // $mail->AddReplyTo($reply_to); //unecessary for now
            $mail->AddAddress($to); //was ($to, $to_name)
            $mail->Subject    = $subject;
            $mail->MsgHTML($body);
    
            $mail->Send();
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