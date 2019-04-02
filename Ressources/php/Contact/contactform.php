<?php 
    $array = array("prenom" => "", "nom" => "", "email" => "", "phone" => "", "message" => "", "prenomError" => "", "nomError" => "", 
    "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);
    $emailTo = "petrovic.david@outlook.fr";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once '../inc/functions.php';
        $array["prenom"] = verifyInput($_POST["prenom"]);
        $array["nom"] = verifyInput($_POST["nom"]);
        $array["email"] = verifyInput($_POST["email"]);
        $array["phone"] = verifyInput($_POST["phone"]);
        $array["message"] = verifyInput($_POST["message"]);
        $array["isSuccess"] = true;
        $emailText = "";

        if(empty($array["prenom"])){
            $array["prenomError"] = "Merci de renseigner votre prénom.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Prénom : {$array["prenom"]}\n";
        }

        if(empty($array["nom"])){
            $array["nomError"] = "Merci de renseigner votre nom.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Nom :{$array["nom"]}\n";
        }

        if(!filter_var($array["email"], FILTER_VALIDATE_EMAIL)){
            $array["emailError"] = "L'adresse e-mail n'est pas correcte.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Email : {$array["email"]}\n";
        }

        if(!preg_match("/^[0-9 ]*$/", $array["phone"])){
            $array["phoneError"] = "Le numéro doit être composé uniquement de chiffres.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Numéro de téléphone : {$array["phone"]}\n";
        }

        if(empty($array["message"])){
            $array["messageError"] = "Merci de compléter le corps de votre message.";
            $array["isSuccess"] = false;
        } else {
            $emailText .= "Message : {$array["message"]}\n";
        }

        if($array["isSuccess"]){
            $headers= "From: {$array["prenom"]} {$array["nom"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
            mail($emailTo, "Nouveau message Damir Restauration", $emailText, $headers);
        }
        echo json_encode($array);
    }
?>