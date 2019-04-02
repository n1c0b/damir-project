<?php
/* -------------------------------------------- FONCTION DEBUG -------------------------------------------- */
    function debug($variable){
        echo '<pre>' . print_r($variable, true) . '</pre>';
    }


/* -------------------------------------------- FONCTION LOGGED_ONLY -------------------------------------------- */
    function logged_only(){
        if(session_status() == PHP_SESSION_NONE){
            session_start(); 
        }
        if(!isset($_SESSION['auth'])){
            $_SESSION['flash']['danger'] = "Veuillez vous connecter pour accéder à cette page";
            header('Location: /damir-project-git/index.php');
            exit();
        }
    }


/* -------------------------------------------- FONCTION RECONNECT COOKIE -------------------------------------------- */
    function reconnect_cookie(){
        if(session_status() == PHP_SESSION_NONE){
           session_start();
        }
        if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
            require_once 'db.php';
            if(!isset($pdo)){
                global $pdo;
            }
            $remember_token = $_COOKIE['remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $req->execute([$user_id]);
            $user = $req->fetch();
            if($user){
                $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'tobiestungentilchat');
                if($expected == $remember_token){
                    unset($_SESSION['flash']);
                    $_SESSION['auth'] = $user;
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7, "/", NULL); //Le champs "NULL" est pour régler le problème de création de cookie en localhost sous Google Chrome
                } else {
                    setcookie('remember', null, -1);
                }
            } else {
                setcookie('remember', null, -1);
            }
        }
    }


/* -------------------------------------------- FONCTION VERIFY INPUT -------------------------------------------- */
    function verifyInput($var){
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
}