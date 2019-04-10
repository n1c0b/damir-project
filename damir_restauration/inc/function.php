<?php 
    
    function str_random($lenght){
        $alphabet = "0123456789azertyuiopmlkjhgfdsqwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $lenght)), 0, $lenght);    
    }
    
   function debug($variable){
       echo '<pre>' . print_r($variable, true) . '</pre>';
   }

   function logged_only(){
   
    if(session_status() == PHP_SESSION_NONE){

    session_start();

    }

    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page !!!";
        header('Location: login.php');
        exit();
    }

   }

   function reconnect_from_cookie(){
    if(session_status() == PHP_SESSION_NONE){

        session_start();
    
        }
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        require_once'db.php';
        if(!isset($pdo)){
            global $pdo;
        }

        
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
         $req = $pdo->prepare('SELECT * FROM users WHERE id= ?');
         $req->execute([$user_id]);
         $user = $req->fetch();
         if($user){
             $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'salutcoucou');
             if($expected == $remember_token){
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() +  60 * 60 * 24 * 7);

             }else{
                setcookie('remember', null, -1);
            }
       
         }else{
             setcookie('remember', null, -1);
         }
    
     }
   }

   function verifyInput($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
    }