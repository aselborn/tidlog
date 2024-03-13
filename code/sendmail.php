<?php

    if (!isset($_SESSION)) { session_start(); }
      require "managesession.php";
      include_once "config.php";
      include_once "objHyra.php";
      include_once "objEmail.php";
      include_once "dbmanager.php";
      
      require '../vendor/autoload.php';
      

    if (!isset($_POST['faktura'])){
        echo "<h1><i>Faktura ej angivet, epost kan inte skickas</i></h1>";
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer as PHPMailerPHPMailer;

    $fakturaId = $_POST['faktura'];
    
    $epostMeddelande = new EpostMeddelande($fakturaId);
    
    $mail = new PHPMailerPHPMailer(true);

    try {
      
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'send.one.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    //$mail->Username   = 'tryckaren7@selborn.se';                     //SMTP username
    $mail->Username   = $epostMeddelande->epost;                     //SMTP username
    $mail->Password   = 'lytill53ZYX!';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('tryckaren7@selborn.se', $epostMeddelande->fastighetNamn);
    $mail->addAddress('anders@selborn.se', 'Anders Selborn');     //Add a recipient
    //$mail->addAddress('alexandra.selborn@fmfastigheter.se', 'Anders Selborn');     //Add a recipient
    
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo($epostMeddelande->epost, 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    $fakturaData = $epostMeddelande->faktura;
    $faktura = stripslashes($fakturaData);
    $fakturaFil = "spec.pdf";

    file_put_contents($fakturaFil, $faktura);
    //Attachments
    $mail->addAttachment($fakturaFil);         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    $bodyText = '<H2><strong>Hej ' .$epostMeddelande->fullname .  ' </strong></h2>';
    $bodyText .= '<br /> <br />';
    $bodyText .= 'Här kommer din hyresavi för <b>' .$epostMeddelande->specifikation . '</b>';

    
    $mail->CharSet = "UTF-8";

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Hyresavi Tryckaren 7, ' . $epostMeddelande->specifikation;
    $mail->Body = $bodyText;
    
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    
    echo json_encode(['skapa_fakturor' => 'true']);

    } catch (Exception $e) {
        echo json_encode(['skapa_fakturor' => 'false', 'orsak' => $th->getMessage()]);
    }
    
?>