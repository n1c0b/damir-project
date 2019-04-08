<?php
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true".
    $array = array("isSuccess" => false);

    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require '../inc/functions.php';
    //Appel du fichier db.php pour avoir accès aux données de la base de données.
    require '../inc/db.php';

    //Connexion à la base de données.
    $pdo = Database::connect();
    /* On fais une requête préparée qui :
        - Selectionne dans la table "users" :
            - L'utilisateur qui à l'ID correspondant à l'ID posté,
            - Qui à le token correspondant au token posté,
            - Qui a dans la colonne reset_at une date qui n'est pas dépassée depuis plus de 24 heures. */
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)');
    $req->execute([$_POST['id'], $_POST['token']]);

    /*On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée.
    - (Si aucune informations n'ont été obtenue la variable sera vide). */
    $user = $req->fetch();
    //Si des informations sont stockées dans la variable "$user" :
    if($user){
        //Si le champs password n'est pas vide qu'il correspond au champs "password_confirm" :
        if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
            //Et on passe la case "isSucess" sur true.
            $array['isSuccess'] = true;
            //On stock dans "$password", le mot de passe crypté.
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            //On fais une requête préparée qui :
            //Change le mot de passe de l'utilisateur concerné dans la base de données.
            $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
            //Déconnexion de la base de données.
            Database::disconnect();
            //On fais un "session_start()" pour avois accès à la superglobale "$_SESSION".
            session_start();
            //Déclaration de la variable "$user" dans laquelle on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
            $_SESSION['auth'] = $user;
        }
    }

    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionner.
    echo json_encode($array);

?>