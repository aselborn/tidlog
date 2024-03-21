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
    $db = new DbManager();
    
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
    $mail->setFrom($epostMeddelande->epost, $epostMeddelande->fastighetNamn);

    $mail->addAddress('anders@selborn.se', 'Anders Selborn');     //Add a recipient
    //$mail->addAddress($epostMeddelande->epostMottagare, $epostMeddelande->fullname);     //Add a recipient

    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo($epostMeddelande->epost, 'Information');
    //$mail->addCC('cc@example.com');
    $mail->addBCC('fastighet@selborn.se');

    $fakturaData = $epostMeddelande->faktura;
    $faktura = stripslashes($fakturaData);
    $fakturaFil = "spec.pdf";

    file_put_contents($fakturaFil, $faktura);
    //Attachments
    $mail->addAttachment($fakturaFil);         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    $bodyText = '<H2><strong>Hej ' .$epostMeddelande->fullname .  ' </strong></h2>';
    $bodyText .= '<br />';
    $bodyText .= 'Här kommer din hyresavi , <b>' .$epostMeddelande->specifikation ;
    $bodyText .= '<hr />';
    $bodyText .= '<br />';
    $bodyText .= $epostMeddelande->fastighetAddress . " ".  $epostMeddelande->adress . " " . $epostMeddelande->specifikation;
    $bodyText .= '<br />  &emsp;-Hyra bostad : <strong>' . $epostMeddelande->hyra . '</strong>' ;
    if ($epostMeddelande->avgift > 0)
    {
        $bodyText .= '<br /> &emsp;-Avgift parkering : <strong>' . $epostMeddelande->avgift . '</strong>';
    }
    $bodyText .= '<br /> &emsp;Att betala : <strong>' .$epostMeddelande->avgift + $epostMeddelande->hyra . ' kronor </strong>' ;
    $bodyText .= '<br />';
    $bodyText .= '<br />';
    $bodyText .= '&emsp;Bankgiro : ' . $epostMeddelande->bankgiro;
    $bodyText .= '<br />';
    $bodyText .= '<br />';
    $bodyText .= 'Vänliga hälsningar ' . $epostMeddelande->foretagNamn;
    $bodyText .= '<hr />';
    $mail->CharSet = "UTF-8";

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Hyresavi ' . $epostMeddelande->fastighetNamn  . " " .  $epostMeddelande->specifikation;
    $mail->Body = $bodyText;
    
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    
    $db->setEpostSkickad($fakturaId);

    echo json_encode(['skapa_fakturor' => 'true']);

    } catch (Exception $e) {
        echo json_encode(['skapa_fakturor' => 'false', 'orsak' => $th->getMessage()]);
    }
    
?>