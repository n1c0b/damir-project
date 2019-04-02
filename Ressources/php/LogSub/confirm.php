<?php

    $user_id = $_GET['id'];
    $token = $_GET['token'];
    require '../inc/db.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $req->execute([$user_id]);
    $user = $req->fetch();
    session_start();
    
    if($user && $user->confirmation_token == $token){
        $req = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
        $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
        $_SESSION['auth'] = $user;
        header('Location: /damir-project-git/index.php');
    } else {
        session_start();
        $_SESSION['flash']['danger'] = "Ce compte a déjà été activé";
        header('Location: /damir-project-git/index.php');
        }

?>