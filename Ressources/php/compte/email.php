<?php 
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require_once '../inc/functions.php';
    //Initialisation de la fonction "logged_only()" pour que seul les utilisateurs connectés puissent avoir accés à cette page.
    logged_only();
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true", une case "emailError" vide, et une case "inputEmail" vide.
    $array = array("inputEmail" => "", "emailError" => "", "isSuccess" => true);
    //Déclaration de la variable "$user" dans laquel on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
    $user = $_SESSION['auth'];
    //On stock dans la case du tableau "inputEmail" la valeur du champs du formulaire "inputEmail" et on effectue la fonction "verifyInput()" dessus afin de contrer les failles XSS.
    $array["inputEmail"] = verifyInput($_POST["inputEmail"]);

    //Si la case "inputEmail" ne correspond pas au format d'une adresse email :
    if(!filter_var($array['inputEmail'], FILTER_VALIDATE_EMAIL)){
        //On remplis la case "emailError" avec un message d'erreur.
        $array["emailError"] = "Votre adresse e-mail n'est pas pas valide";
        //Et on passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si la case "inputEmail" correspond au format d'une adresse e-mail :
    } else {
        //On appel le fichier db.php afin d'avoir accès à la base de données. 
        require_once '../inc/db.php';
        //On fais une requête préparée qui :
        //Selectionne l'ID de la table users ou l'email est égal à la valeur de la case "inputEmail".
        $pdo = Database::connect();
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$array['inputEmail']]);
        //On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée. (Si aucune informations n'ont été obtenue la variable sera vide)
        $user = $req->fetch();
        //Si des informations sont stockées dans la variable "$user" :
        if($user){
            //On remplis la case "emailError" avec un message d'erreur.
            $array["emailError"] = "L'adresse e-mail est déjà prise.";
            //Et on passe la case "isSucess" sur false.
            $array["isSuccess"] = false;
        //Si aucune information n'est stockée dans la variable "$user" :   
        } else {
        //On stock dans la variable "$user_id", l'id de l'utilisateur connecté.
        $user_id = $_SESSION['auth']->id;
        //On stock dans la variable "$email" la valeur de la case "inputEmail".
        $email = $array["inputEmail"];
        //On fais une requête préparée qui :
        //Change la valeur de la colonne email dans la table users ou l'ID est égal l'ID de l'utilisateur connecté
        //Par la nouvelle adresse email choisi par l'utilisateur.
        $pdo->prepare('UPDATE users SET email = ? WHERE id = ?')->execute([$email, $user_id]);
        Database::disconnect();
        //Afin d'éviter l'erreur : "Trying to get property 'value' of non-object php" :
        $user = new stdClass();
        //Déclaration de la variable "$user" dans laquel on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
        $user = $_SESSION['auth'];
        //On dé
        $user->email = $email;
        }
    }
    echo json_encode($array);
?> 