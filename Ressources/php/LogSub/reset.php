<?php
    $array = array("isSuccess" => false);
    require '../inc/db.php';
    require '../inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)');
    $req->execute([$_POST['id'], $_POST['token']]);
    $user = $req->fetch();
    if($user){
        if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
            $array['isSuccess'] = true;
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
            session_start();
            $_SESSION['auth'] = $user;
        }
    }
    echo json_encode($array);

?>