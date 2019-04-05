<?php 
/* -------------------------------------------- CREATION D'UN ARRAY DU FORMULAIRE POUR AJAX -------------------------------------------- */
    $array = array("firstnameError" => "", "lastnameError" => "", "emailError" => "", "passwordError" => "", 
    "password_confirmError" => "", "isSuccess" => true);
    

/* -------------------------------------------- VERIFICATION DES CHAMPS -------------------------------------------- */
        require_once '../inc/functions.php';
        $firstname = verifyInput($_POST["firstname"]);
        $lastname = verifyInput($_POST["lastname"]);
        $email = verifyInput($_POST["email"]);
        $password = verifyInput($_POST["password"]);
		$password_confirm = verifyInput($_POST["password_confirm"]);
		require_once '../inc/db.php';

        if(!preg_match('/^[a-zA-Z-]+$/', $firstname)){
            $array["firstnameError"] = "Votre prénom doit être composé de lettres.";
            $array["isSuccess"] = false;
		}
		
        if(!preg_match('/^[a-zA-Z-]+$/', $lastname)){
            $array["lastnameError"] = "Votre nom doit être composé de lettres";
            $array["isSuccess"] = false;
		}
		
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $array["emailError"] = "L'adresse e-mail n'est pas correcte.";
            $array["isSuccess"] = false;
        } else {
            $pdo = Database::connect();
            $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $req->execute([$email]);
            $user = $req->fetch();
            if($user){
				$array["emailError"] = "Cette adresse e-mail est déjà prise";
				$array["isSuccess"] = false;
            }
        }

        if(empty($password)){
            $array["passwordError"] = "Votre mot de passe est invalide.";
            $array["isSuccess"] = false;
		}
		
		if($password_confirm != $password){
			$array["password_confirmError"] = "Les mots de passe ne correspondent pas.";
			$array["isSuccess"] = false;
		}


/* -------------------------------------------- CREATION DU COMPTE DANS LA BASE DE DONNEES ET ENVOI DE L'EMAIL DE CONFIRMATION -------------------------------------------- */
        if($array["isSuccess"]){
			$req = $pdo->prepare("INSERT INTO users SET firstname = ?, lastname = ?, password = ?, email = ?, confirmation_token = ?");
            $passwordC = password_hash($password, PASSWORD_BCRYPT);
            $token = bin2hex(random_bytes(60));
            $req->execute([$firstname, $lastname, $passwordC, $email, $token]);
            $user_id = $pdo->lastInsertId();
            Database::disconnect();
			$headers= "From: {'Damir'} {'Restauration'} <{'nepasrepondre@damir.fr'}>";
            mail($email, 'Confirmation de compte Damir Restauration', "L'équipe Damir Restauration vous remercie de votre inscription.\n Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/damir-project-git/Ressources/php/LogSub/confirm.php?id=$user_id&token=$token");
        }

        
/* -------------------------------------------- ENVOIS DU ARRAY A AJAX -------------------------------------------- */
        echo json_encode($array);
?>