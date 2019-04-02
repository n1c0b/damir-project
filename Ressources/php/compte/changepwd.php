<?php 
    require '../inc/functions.php';
    logged_only();
    $array = array("newPWD" => "", "newPWDOK" => "", "isSuccess" => true);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $array["newPWD"] = verifyInput($_POST["newPWD"]);
        $array["newPWDOK"] = verifyInput($_POST["newPWDOK"]);
    }
    if(empty($array['newPWD']) || $array['newPWD'] != $array['newPWDOK']){
        $array["isSuccess"] = false;
    } else {
        $user_id = $_SESSION['auth']->id;
        $password= password_hash($array['newPWD'], PASSWORD_BCRYPT);
        require_once '../inc/db.php';
        $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password, $user_id]);
    }
    echo json_encode($array);
?>