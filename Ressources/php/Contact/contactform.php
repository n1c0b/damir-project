<?php 
    require_once '../inc/functions.php';
    $array = array("prenomError" => "", "nomError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => true);
    $emailTo = "maildedamir@afpa.fr";

        $prenom = verifyInput($_POST["prenom"]);
        $nom = verifyInput($_POST["nom"]);
        $email = verifyInput($_POST["email"]);
        $phone = verifyInput($_POST["phone"]);
        $message = verifyInput($_POST["message"]);
        $emailText = "";

        if(empty($prenom)){
            $array["prenomError"] = "Merci de renseigner votre prénom.";
            $array["isSuccess"] = false;
        } else {
            if(!preg_match('/^[a-zA-Z- ]+$/', $prenom)) {
                $array["prenomError"] = "Votre prénom doit être composé de lettres.";
                $array["isSuccess"] = false;
            }
            $emailText .= "Prénom : {$prenom}\n";
        }
        
        if(empty($nom)){
            $array["nomError"] = "Merci de renseigner votre nom.";
            $array["isSuccess"] = false;
        }  else {
            if(!preg_match('/^[a-zA-Z- ]+$/', $nom)) {
                $array["nomError"] = "Votre nom doit être composé de lettres.";
                $array["isSuccess"] = false;
            }
            $emailText .= "Nom : {$nom}\n";
        }    

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $array["emailError"] = "L'adresse e-mail n'est pas correcte.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Email : {$email}\n";
        }

        if(!preg_match("/^[0-9 .]*$/", $phone)){
            $array["phoneError"] = "Le numéro doit être composé de chiffres.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Numéro de téléphone : {$phone}\n";
        }

        if(empty($message)){
            $array["messageError"] = "Merci de compléter le corps de votre message.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Message : {$message}\n";
        }

        if($array["isSuccess"]){
            $headers= "From: {$prenom} {$nom} <{$email}>\r\nReply-To: {$email}";
            mail($emailTo, "Nouveau message Damir Restauration", $emailText, $headers);
        }
        echo json_encode($array);
?>