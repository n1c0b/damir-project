<?php 
    require_once '../inc/functions.php';
    logged_only();
    $array = array("inputFirstName" => "", "isSuccess" => true);
    $user = $_SESSION['auth'];
    $array["inputFirstName"] = verifyInput($_POST["inputFirstName"]);

    if(!preg_match('/^[a-zA-Z-]+$/', $array['inputFirstName'])){
        $array["isSuccess"] = false;
    } else {
        $user_id = $_SESSION['auth']->id;
        $firstname = $array["inputFirstName"];
        require_once '../inc/db.php';
        $pdo->prepare('UPDATE users SET firstname = ? WHERE id = ?')->execute([$firstname, $user_id]);
        $user->firstname = $firstname;
    }
    echo json_encode($array);
?>