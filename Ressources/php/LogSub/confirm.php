<?php

    //On stock dans la variable "$user_id" la valeur de l'ID présent dans l'URL.
    $user_id = $_GET['id'];
    //On stock dans la variable "$user_id" la valeur de du Token présent dans l'URL.
    $token = $_GET['token'];
    //Appel du fichier db.php pour avoir accès aux données de la base de données.
    require '../inc/db.php';
    //Connexion à la base données.
    $pdo = Database::connect();
    //On fais un requête préparée qui :
    //Selectionne dans la table users l'ID qui correspond à la valeur de "$user_id".
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $req->execute([$user_id]);
    //On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée. (Si aucune informations n'ont été obtenue la variable sera vide)
    $user = $req->fetch();
    //On fais un "session_start()" pour avois accès à la superglobale "$_SESSION".
    session_start();
    
    //Si des informations sont stockées dans la variable "$user", et que le confirmation_token est égal à la valeur de "$token".
    if($user && $user->confirmation_token == $token){
        //On fais une requête préparée qui :
        //Donne la valeur "null" à la colonne confirmation_token ou l'ID correspond à la valeur de "$user_id".
        //Donne la valeur de la date de maintenant à la colonne confirmed_at ou l'ID correspond à la valeur de "$user_id".
        $req = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
        //Déconnexion de la base de données.
        Database::disconnect();
        //On affiche un message d'informations.
        $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
        //Déclaration de la variable "$user" dans laquel on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
        $_SESSION['auth'] = $user;
        //On redirige vers l'index.
        header('Location: /damir-project-git/index.php');
    //Si aucune information n'est stockée dans la variable "$user" :  
    } else {
        //On affiche un message d'erreur.
        $_SESSION['flash']['danger'] = "Ce compte a déjà été activé";
        //Et on redirige vers l'index.
        header('Location: /damir-project-git/index.php');
        }

?>