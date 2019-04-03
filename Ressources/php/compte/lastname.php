<?php 
    require '../inc/functions.php';
    logged_only();
    $array = array("inputLastName" => "", "isSuccess" => true);
    $user = $_SESSION['auth'];
    $array["inputLastName"] = verifyInput($_POST["inputLastName"]);
    if(!preg_match('/^[a-zA-Z-]+$/', $array['inputLastName'])){
        $array["isSuccess"] = false;
    } else {
        $user_id = $_SESSION['auth']->id;
        $lastname = $array["inputLastName"];
        require_once '../inc/db.php';
        $pdo = Database::connect();
        $pdo->prepare('UPDATE users SET lastname = ? WHERE id = ?')->execute([$lastname, $user_id]);
        Database::disconnect();
        $user->lastname = $lastname;
    }
    echo json_encode($array);
?>