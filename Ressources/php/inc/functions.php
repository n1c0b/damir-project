<?php
/* -------------------------------------------- FONCTION DEBUG -------------------------------------------- */
    function debug($variable){
        echo '<pre>' . print_r($variable, true) . '</pre>';
    }


/* -------------------------------------------- FONCTION LOGGED_ONLY -------------------------------------------- */
    function logged_only(){
        //Si les sessions sont activées mais qu'aucune n'existe :
        if(session_status() == PHP_SESSION_NONE){
            //On fais un session_start.
            session_start(); 
        }
        //Si la superglobale $_SESSION avec la valeur "auth" n'existe pas :
        if(!isset($_SESSION['auth'])){
            //On affiche un message d'erreur.
            $_SESSION['flash']['danger'] = "Veuillez vous connecter pour accéder à cette page";
            //On redirige vers l'index.
            header('Location: /damir-project-git/index.php');
            //Et on arrête l'execution du script.
            exit();
        }
    }


/* -------------------------------------------- FONCTION RECONNECT COOKIE -------------------------------------------- */
    function reconnect_cookie(){
        //Si les sessions sont activées mais qu'aucune existe :
        if(session_status() == PHP_SESSION_NONE){
            //On fais un session_starts.
           session_start();
        }
        //Si la superglobale $_COOKIE avec la valeur 'remember' existe et que la superglobale $_SESSION avec la valeur "auth" n'existe pas :
        if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
            //On appel le fichier db.php afin d'avoir accès à la base de données.            
            require_once 'db.php';
            //Si la variable "$pdo" n'existe pas :
            if(!isset($pdo)){
                //On rend la variable $pdo globale.
                global $pdo;
            }
            //On stock dans la variable "$remember_token" le cookie "remember".
            $remember_token = $_COOKIE['remember'];
            //On stock dans la variable "$parts" la variable "$remember_token" scindée en tableau.
            $parts = explode('==', $remember_token);
            //On stock dans la variable "$user_id" la case 0 de "$parts".
            $user_id = $parts[0];
            //Connexion à la base de données.
            $pdo = Database::connect();
            //On fait une requête préparée qui :
            //Selectionne dans la table users la valeur de la colonne ID qui correspond à "$user_id".
            $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $req->execute([$user_id]);
            /*On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée.
                - (Si aucune informations n'ont été obtenue la variable sera vide). */
            $user = $req->fetch();
            //Deconnexion de la base de données
            Database::disconnect();
            //Si des informations sont stockées dans la variable "$user" :
            if($user){
                //On stock dans la variable "$expected" les valeurs suivantes (sans oublié de crypté l'ID de l'utilisateur ) : 
                $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'tobiestungentilchat');
                //Si "$expected" est égal à "$remember_token" :
                if($expected == $remember_token){
                    //On enlève les messages d'erreurs.
                    unset($_SESSION['flash']);
                    //Déclaration de la variable "$user" dans laquelle on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
                    $_SESSION['auth'] = $user;
                    //On recréé le cookie "remember".
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7, "/", NULL); //Le champs "NULL" est pour régler le problème de création de cookie en localhost sous Google Chrome
                //Si "$expected" n'est pas égal à "$remember_token" :
                } else {
                    //On supprime le cookie "remember".
                    setcookie('remember', null, -1);
                }
            //Si aucune information ne sont stockées dans la variable "$user" :
            } else {
                //On supprime le cookie "remember".                
                setcookie('remember', null, -1);
            }
        }
    }


/* -------------------------------------------- FONCTION VERIFY INPUT -------------------------------------------- */
    function verifyInput($var){
        //Suppression des espaces en début et en fin de la chaîne de caractères.
        $var = trim($var);
        //Suppression des antislash présents dans la chaîne de caractères.
        $var = stripslashes($var);
        //Remplacement des caractères spéciaux de la chaîne de caractères par des entités HTMl.
        $var = htmlspecialchars($var);
        //On retourne la varaible traitée
        return $var;
}


/* -------------------------------------------- FONCTION VERIFY INPUT -------------------------------------------- */
function admin_only(){
    $user = $_SESSION['auth'];
    if($user->isadmin == 0){
        header('Location: /damir-project-git/index.php');
    }
}