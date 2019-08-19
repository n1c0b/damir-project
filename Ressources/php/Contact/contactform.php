<?php 
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require_once '../inc/functions.php';
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true" et cinq cases vide ayant chacune leur nom.
    $array = array("prenomError" => "", "nomError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => true);
    //On stock dans la variable "$emailto" l'adresse e-mail ou sera receptionné le message.
    $emailTo = "fekraouihamza@yahoo.fr";

    //On créé cinq variables, une pour chaque case vide du tableau et on les passe à la fonction "verifyinput()" afin de contrer les failles XSS.
    $prenom = verifyInput($_POST["prenom"]);
    $nom = verifyInput($_POST["nom"]);
    $email = verifyInput($_POST["emailcont"]);
    $phone = verifyInput($_POST["phone"]);
    $message = verifyInput($_POST["message"]);
    //On déclare un variable "$emailText" en chaine de caractères vide.
    $emailText = "";

    //Si "$prenom" est vide :
    if(empty($prenom)){
        //On remplis la case "prenomError" avec un message d'erreur.
        $array["prenomError"] = "Merci de renseigner votre prénom.";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si "$prenom" n'est pas vide :
    } else {
        //Si $prenom ne correspond pas l'expression régulière suivante :
        if(!preg_match('/^[a-zA-Z- ]+$/', $prenom)){
            //On remplis la case "prenomError" avec un message d'erreur.
            $array["prenomError"] = "Votre prénom doit être composé de lettres.";
            //Et on passe la case "isSucess" sur false.
            $array["isSuccess"] = false;
        }
        //On ajoute à "$emailText" las valeurs suivantes :
        $emailText .= "Prénom : {$prenom}\n";
    }
    
    //On répète les même opérations que plus haut mais cette fois-ci pour "$nom".
    if(empty($nom)){
        $array["nomError"] = "Merci de renseigner votre nom.";
        $array["isSuccess"] = false;
    }  else {
        if(!preg_match('/^[a-zA-Z- ]+$/', $nom)){
            $array["nomError"] = "Votre nom doit être composé de lettres.";
            $array["isSuccess"] = false;
        }
        $emailText .= "Nom : {$nom}\n";
    }    

    //Si "$email" ne correspond pas au format d'une adresse e-mail :
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //On remplis la case "emailError" avec un message d'erreur.
        $array["emailError"] = "L'adresse e-mail n'est pas correcte.";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si "$email" correspond au format d'une adresse e-mail :
    } else {
        //On ajoute à "$emailText" las valeurs suivantes :
        $emailText .= "Email : {$email}\n";
    }

    //Si $phone ne correspond pas l'expression régulière suivante :
    if(!preg_match("/^[0-9 .]*$/", $phone)){
        //On remplis la case "phoneError" avec un message d'erreur.
        $array["phoneError"] = "Le numéro doit être composé de chiffres.";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si $phone correspond l'expression régulière suivante :
    } else {
        //On ajoute à "$emailText" las valeurs suivantes :
        $emailText .= "Numéro de téléphone : {$phone}\n";
    }

    //Si "$message" est vide :
    if(empty($message)){
        //On remplis la case "messageError" avec un message d'erreur.
        $array["messageError"] = "Merci de compléter le corps de votre message.";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si "$message" n'est pas vide :
    } else {
        //On ajoute à "$emailText" las valeurs suivantes :
        $emailText .= "Message : {$message}\n";
    }

    //Si la case "isSuccess" est égal à "true" :
    if($array["isSuccess"]){
        //On stock dans la variable "$headers" les valeurs suivantes :
        $headers= "From: {$prenom} {$nom} <{$email}>\r\nReply-To: {$email}";
        //Et on envois un mail avec les paramètres suivant :
        mail($emailTo, "Nouveau message Damir Restauration", $emailText, $headers);
    }

    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionner.
    echo json_encode($array);
?>