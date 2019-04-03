<?php
    $array = array("isSuccess" => true);
    require_once '../inc/functions.php';
    $emailfo = verifyInput($_POST["emailfo"]);
    require_once '../inc/db.php';
    $pdo = Database::connect();
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$emailfo]);
    $user = $req->fetch();
    if($user){
        session_start();
        $length = 60;
        $reset_token = bin2hex(random_bytes($length));
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        Database::disconnect();
        mail($emailfo, 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost/damir-project-git/resetmdp.php?id={$user->id}&token=$reset_token");
    } else {
        $array['isSuccess'] = false;
    }
    echo json_encode($array);
?>