<?php 
    require_once '../inc/functions.php';
    forbidden();
    logged_only();
    $array = array("inputEmail" => "", "emailError" => "", "isSuccess" => true);
    $user = $_SESSION['auth'];
    $array["inputEmail"] = verifyInput($_POST["inputEmail"]);

    if(!filter_var($array['inputEmail'], FILTER_VALIDATE_EMAIL)){
        $array["emailError"] = "Votre adresse e-mail n'est pas pas valide";
        $array["isSuccess"] = false;
    } else {
        require_once '../inc/db.php';
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$array['inputEmail']]);
        $user = $req->fetch();
        if($user){
            $array["emailError"] = "L'adresse e-mail est déjà prise.";
            $array["isSuccess"] = false;
        } else {
        $user_id = $_SESSION['auth']->id;
        $email = $array["inputEmail"];
        $pdo->prepare('UPDATE users SET email = ? WHERE id = ?')->execute([$email, $user_id]);
        $user = new stdClass();
        $user = $_SESSION['auth'];
        $user->email = $email;
        }
    }
    echo json_encode($array);
?> 