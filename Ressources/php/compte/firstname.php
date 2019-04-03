<?php 
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require_once '../inc/functions.php';
    //Initialisation de la fonction "logged_only()" pour que seul les utilisateurs connectés puissent avoir accés à cette page.
    logged_only();
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true" et une case "inputFirstName" vide.
    $array = array("inputFirstName" => "", "isSuccess" => true);
    //Déclaration de la variable "$user" dans laquel on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
    $user = $_SESSION['auth'];
    //On stock dans la case du tableau "inputFirstName" la valeur du champs du formulaire "inputFirstName" et on effectue la fonction "verifyInput()" dessus afin de contrer les failles XSS.
    $array["inputFirstName"] = verifyInput($_POST["inputFirstName"]);

    //Si la case "inputFirstName" ne correspond pas à l'expression réuglière précisée :
    if(!preg_match('/^[a-zA-Z-]+$/', $array['inputFirstName'])){
        //On passe la case "isSucess" sur false.
        $array["isSuccess"] = false;
    //Si la case "inputFirstName" correspond à l'expression réuglière précisée :
    } else {
        //On stock dans la variable "$user_id", l'id de l'utilisateur connecté.
        $user_id = $_SESSION['auth']->id;
        //On stock dans la variable "$firstname" la valeur de la case "inputFirstName".
        $firstname = $array["inputFirstName"];
        //On appel le fichier db.php afin d'avoir accès à la base de données.
        require_once '../inc/db.php';
        //Connexion à la base de données.
        $pdo = Database::connect();
        //On fais une requête préparée qui :
        //Change la valeur de la colonne firstname dans la table users ou l'ID est égal l'ID de l'utilisateur connecté
        //Par le nouveau firstname choisi par l'utilisateur.
        $pdo->prepare('UPDATE users SET firstname = ? WHERE id = ?')->execute([$firstname, $user_id]);
        //Déconnexion de la base de données.
        Database::disconnect();
        //On change la valeur du firstname avec le nouveau firstname dans la variable $user.
        $user->firstname = $firstname;
    }
    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionner.
    echo json_encode($array);
?>