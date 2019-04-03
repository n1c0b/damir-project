<?php
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require '../inc/functions.php';
    //Initialisation de la fonction "logged_only()" pour que seul les utilisateurs connectés puissent avoir accés à cette page.
    logged_only();
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true".
    $array = array("isSuccess" => true);
    //On effectue la fonction "verifyInput()" afin de contrer les failles XSS.
    verifyInput($_POST["newPWD"]);
    verifyInput($_POST["newPWDOK"]);

    //Si le champs du formulaire "newPWD" est vide ou si le champs du formulaire "newPWD" n'est pas égal au champs du formulaire "newPWDOK" :
    if(empty($_POST['newPWD']) || $_POST['newPWD'] != $_POST['newPWDOK']){
        //On passe la case du tableau isSucess sur false.
        $array["isSuccess"] = false;
    //Si le champs du formulaire "newPWD" n'est pas vide ou si le champs du formulaire "newPWD" est égal au champs du formulaire "newPWDOK" :
    } else {
        //On stock dans la variable "$user_id", l'id de l'utilisateur connecté.
        $user_id = $_SESSION['auth']->id;
        //On sécurise le nouveau mot de passe choisi en le cryptant.
        $password= password_hash($_POST['newPWD'], PASSWORD_BCRYPT);
        //Appel du fichier db.php afin d'avoir accès à la base de données.
        require_once '../inc/db.php';
        //On fais une requête préparée qui :
        //Change la valeur de la colonne password dans la table users ou l'ID est égal à l'ID de l'utilisateur connecté,
        //Par le nouveau mot de passe choisi par l'utilisateur.
        $pdo = Database::connect();
        $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password, $user_id]);
        Database::disconnect();
    }
    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionné.
    echo json_encode($array);
?>