<?php 
/* -------------------------------------------- CREATION D'UN ARRAY DU FORMULAIRE POUR AJAX -------------------------------------------- */
	$array = array("firstname" => "", "lastname" => "", "email" => "", "password" => "", "password_confirm" => "", "firstnameError" => "", 
    "lastnameError" => "", "emailError" => "", "passwordError" => "", "password_confirmError" => "", "isSuccess" => true);
    

/* -------------------------------------------- VERIFICATION DES CHAMPS -------------------------------------------- */
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once '../inc/functions.php';
        $array["firstname"] = verifyInput($_POST["firstname"]);
        $array["lastname"] = verifyInput($_POST["lastname"]);
        $array["email"] = verifyInput($_POST["email"]);
        $array["password"] = verifyInput($_POST["password"]);
		$array["password_confirm"] = verifyInput($_POST["password_confirm"]);
		require_once '../inc/db.php';

        if(!preg_match('/^[a-zA-Z-]+$/', $array['firstname'])){
            $array["firstnameError"] = "Votre prénom doit être composé de lettres.";
            $array["isSuccess"] = false;
		}
		
        if(!preg_match('/^[a-zA-Z-]+$/', $array['lastname'])){
            $array["lastnameError"] = "Votre nom doit être composé de lettres";
            $array["isSuccess"] = false;
		}
		
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $array["emailError"] = "L'adresse e-mail n'est pas correcte.";
            $array["isSuccess"] = false;
        } else {
            $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $req->execute([$array['email']]);
            $user = $req->fetch();
            if($user){
				$array["emailError"] = "Cette adresse e-mail est déjà prise";
				$array["isSuccess"] = false;
            }
        }

        if(empty($array["password"])){
            $array["passwordError"] = "Votre mot de passe est invalide.";
            $array["isSuccess"] = false;
		}
		
		if($array['password_confirm'] != $array['password']){
			$array["password_confirmError"] = "Les mots de passe ne correspondent pas.";
			$array["isSuccess"] = false;
		}


/* -------------------------------------------- CREATION DU COMPTE DANS LA BASE DE DONNEES ET ENVOI DE L'EMAIL DE CONFIRMATION -------------------------------------------- */
        if($array["isSuccess"]){
            $pdo = Database::connect();
			$req = $pdo->prepare("INSERT INTO users SET firstname = ?, lastname = ?, password = ?, email = ?, confirmation_token = ?");
            $password = password_hash($array['password'], PASSWORD_BCRYPT);
            $token = bin2hex(random_bytes(60));
            $req->execute([$array['firstname'], $array['lastname'], $password, $array['email'], $token]);
            $user_id = $pdo->lastInsertId();
            Database::disconnect();
			$headers= "From: {'Damir'} {'Restauration'} <{'nepasrepondre@damir.fr'}>";
            mail($array['email'], 'Confirmation de compte Damir Restauration', "L'équipe Damir Restauration vous remercie de votre inscription.\n Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/damir-project-git/Ressources/php/LogSub/confirm.php?id=$user_id&token=$token");
        }

        
/* -------------------------------------------- ENVOIS DU ARRAY A AJAX -------------------------------------------- */
        echo json_encode($array);
	}
?>