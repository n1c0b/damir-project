<?php
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require '../inc/functions.php';
    //Initialisation de la fonction "logged_only()" pour que seul les utilisateurs connectés puissent avoir accés à cette page.
    logged_only();
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true" et une case "inputLastName" vide.
    $array = array("inputLastName" => "", "isSuccess" => true);
    //Déclaration de la variable "$user" dans laquel on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
    $user = $_SESSION['auth'];
    //On stock dans la case du tableau "inputLastName" la valeur du champs du formulaire "inputLastName" et on effectue la fonction "verifyInput()" dessus afin de contrer les failles XSS.
    $array["inputLastName"] = verifyInput($_POST["inputLastName"]);

    //Si la case "inputLastName" ne correspond pas à l'expression réuglière précisée :
    if(!preg_match('/^[a-zA-Z-]+$/', $array['inputLastName'])){
        //On passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si la case "inputLastName" correspond à l'expression réuglière précisée :
    } else {
        //On stock dans la variable "$user_id", l'id de l'utilisateur connecté.
        $user_id = $_SESSION['auth']->id;
        //On stock dans la variable "$lastname" la valeur de la case "inputLastName".
        $lastname = $array["inputLastName"];
        //On appel le fichier db.php afin d'avoir accès à la base de données.
        require_once '../inc/db.php';
        //Connexion à la base de données.
        $pdo = Database::connect();
        //On fais une requête préparée qui :
        //Change la valeur de la colonne lastname dans la table users ou l'ID est égal l'ID de l'utilisateur connecté
        //Par le nouveau lastname choisi par l'utilisateur.
        $pdo->prepare('UPDATE users SET lastname = ? WHERE id = ?')->execute([$lastname, $user_id]);
        //Déconnexion de la base de données.
        Database::disconnect();
        //On change la valeur du lastname avec le nouveau lastname dans la variable $user;
        $user->lastname = $lastname;
    }
    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionner.
    echo json_encode($array);
?>