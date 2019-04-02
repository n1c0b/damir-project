<?php
    require '../inc/functions.php';
    logged_only();
    $array = array("isSuccess" => true);
    verifyInput($_POST["newPWD"]);
    verifyInput($_POST["newPWDOK"]);

    if(empty($_POST['newPWD']) || $_POST['newPWD'] != $_POST['newPWDOK']){
        $array["isSuccess"] = false;
    } else {
        $user_id = $_SESSION['auth']->id;
        $password= password_hash($_POST['newPWD'], PASSWORD_BCRYPT);
        require_once '../inc/db.php';
        $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password, $user_id]);
    }
    echo json_encode($array);
?>