<?php
/* -------------------------------------------- CREATION D'UN ARRAY DU FORMULAIRE POUR AJAX -------------------------------------------- */
    $array = array("isSuccess" => false);

/* -------------------------------------------- VERIFICATION DES CHAMPS -------------------------------------------- */
        require_once '../inc/functions.php';
        $emailco = verifyInput($_POST["emailco"]);
        $passwordco = verifyInput($_POST["passwordco"]);

        require_once '../inc/db.php';
        $pdo = Database::connect();
        $req = $pdo->prepare('SELECT * FROM users WHERE (email = :email) AND confirmed_at IS NOT NULL');
        $req->execute(['email'=> $emailco]);
        $user = $req->fetch();


/* -------------------------------------------- CONNEXION -------------------------------------------- */
        if(!empty($user) && password_verify($passwordco, $user->password)){
            $array["isSuccess"] = true;
            session_start();
            $_SESSION['auth'] = $user;
/* -------------------------------------------- RESTER CONNECTE -------------------------------------------- */
            if(!empty($_POST['remember'])){
                $remember_token = bin2hex(random_bytes(80));
                $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
                setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . "tobiestungentilchat"), time() + 60 * 60 * 24 * 7, "/", NULL); //Le champs "NULL" est pour régler le problème de création de cookie en localhost sous Google Chrome
                Database::disconnect();
            }
        }

/* -------------------------------------------- ENVOIS DU ARRAY A AJAX -------------------------------------------- */
    echo json_encode($array);
?>