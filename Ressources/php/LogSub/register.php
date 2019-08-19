<?php 
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true" et cinq cases vide ayant chacune leur nom.
    $array = array("firstnameError" => "", "lastnameError" => "", "emailError" => "", "passwordError" => "", 
    "password_confirmError" => "", "isSuccess" => true);

    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require_once '../inc/functions.php';
    
    //On créé cinq variables, une pour chaque case vide du tableau et on les passe à la fonction "verifyinput()" afin de contrer les failles XSS.
    $firstname = verifyInput($_POST["firstname"]);
    $lastname = verifyInput($_POST["lastname"]);
    $email = verifyInput($_POST["email"]);
    $password = verifyInput($_POST["password"]);
    $password_confirm = verifyInput($_POST["password_confirm"]);

    //Appel du fichier db.php pour avoir accès aux données de la base de données.
	require_once '../inc/db.php';


    //Si "$firstname" est vide :
    if(empty($firstname)){
        //On remplis la case "firstnameError" avec un message d'erreur.
        $array["firstnameError"] = "Merci de renseigner votre prénom.";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si "$firstname" n'est pas vide :
    } else {
        //Si $prenom ne correspond pas l'expression régulière suivante :
        if(!preg_match('/^[a-zA-Z- ]+$/', $firstname)){
            //On remplis la case "prenomError" avec un message d'erreur.
            $array["firstnameError"] = "Votre prénom doit être composé de lettres.";
            //Et on passe la case "isSucess" sur false.
            $array["isSuccess"] = false;
        }
    }
		
    //On répète les même opérations que plus haut mais cette fois-ci pour "$lastname".
    if(empty($lastname)){
        $array["lastnameError"] = "Merci de renseigner votre nom.";
        $array["isSuccess"] = false;
    } else {
        if(!preg_match('/^[a-zA-Z- ]+$/', $lastname)){
            $array["lastnameError"] = "Votre nom doit être composé de lettres.";
            $array["isSuccess"] = false;
        }
    }
        
    //Si "$email" ne correspond pas au format d'une adresse e-mail :    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //On remplis la case "emailError" avec un message d'erreur.
        $array["emailError"] = "L'adresse e-mail n'est pas correcte.";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si "$email" correspond au format d'une adresse e-mail :
    } else {
        //Connexion à la base données.
        $pdo = Database::connect();
        /* On fait une requête préparée qui :
            - Selectionne l'ID de la table users ou l'email est égal à la valeur de l'email rentrée. */
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$email]);

        /*On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée.
            - (Si aucune informations n'ont été obtenue la variable sera vide). */
        $user = $req->fetch();
        //Si des informations sont stockées dans la variable "$user" :
        if($user){
            //On remplis la case "emailError" avec un message d'erreur.
            $array["emailError"] = "Cette adresse e-mail est déjà prise";
            //Et on passe la case "isSucess" sur false.
			$array["isSuccess"] = false;
        }
    }

    //Si "$password" est vide :
    if(empty($password)){
        //On remplis la case "passwordError" avec un message d'erreur.
        $array["passwordError"] = "Votre mot de passe est invalide.";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
	}
    
    //Si "$password_confirm" n'est pas égal à "$password" :
	if($password_confirm != $password){
        //On remplis la case "password_confirmError" avec un message d'erreur.
        $array["password_confirmError"] = "Les mots de passe ne correspondent pas.";
        //Et on passe la case "isSucess" sur false.        
		$array["isSuccess"] = false;
	}

    //Si la case "isSuccess" est égal à true :
    if($array["isSuccess"]){
        /* On fait une requête préparée qui :
            - Qui insert dans la table "users" un nouvel utilisateur */
        $req = $pdo->prepare("INSERT INTO users SET firstname = ?, lastname = ?, password = ?, email = ?, confirmation_token = ?");
        //Avant d'executer la requête on stock dans "$passwordC" le mot de passe crypté pour ne pas insérer ce dernier en clair dans la base de données.
        $passwordC = password_hash($password, PASSWORD_BCRYPT);
        //On génère une chaîne de caractères alétoires que l'on stock dans "$token"
        $token = bin2hex(random_bytes(60));
        //On execute la requête préparée avec les données du formulaire et les données ci-dessus.
        $req->execute([$firstname, $lastname, $passwordC, $email, $token]);
        //On stock dans "$user_id" le dernier ID inséré dans la base de données. 
        $user_id = $pdo->lastInsertId();
        //Déconnexion de la base de données.
        Database::disconnect();

        //On envois un mail de confirmation de compte à l'utilisateur.
		$headers= "From: {'Damir'} {'Restauration'} <{'nepasrepondre@damir.fr'}>";
        mail($email, 'Confirmation de compte Damir Restauration', "L'équipe Damir Restauration vous remercie de votre inscription.\n
        Afin de valider votre compte merci de cliquer sur ce <a href='
        https://www.fekraoui-hamza.fr/damir-project-git/Ressources/php/LogSub/confirm.php?id=$user_id&token=$token'>lien</a>\n\n
        ", $headers);
    }

    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionner.
    echo json_encode($array);
?>