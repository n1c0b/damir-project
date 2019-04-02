<?php
    $array = array("emailfo" => "", "isSuccess" => true);
if(!empty($_POST)){
    require_once '../inc/functions.php';
    $array["emailfo"] = verifyInput($_POST["emailfo"]);
    require_once '../inc/db.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['emailfo']]);
    $user = $req->fetch();
    if($user){
        session_start();
        $length = 60;
        $reset_token = bin2hex(random_bytes($length));
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        mail($_POST['emailfo'], 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost/damir%20project/resetmdp.php?id={$user->id}&token=$reset_token");
    } else {
        $array['isSuccess'] = false;
    }
    echo json_encode($array);
}

?>