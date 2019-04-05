<?php
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true".
    $array = array("isSuccess" => false);
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require_once '../inc/functions.php';
    //On stock dans la variable "$emailco" la valeur du champs du formulaire "emailco" et on effectue la fonction "verifyInput()" dessus afin de contrer les failles XSS.
    $emailco = verifyInput($_POST["emailco"]);
    //On stock dans la variable "$passwordco" la valeur du champs du formulaire "passwordco" et on effectue la fonction "verifyInput()" dessus afin de contrer les failles XSS.
    $passwordco = verifyInput($_POST["passwordco"]);
    //On appel le fichier db.php afin d'avoir accès à la base de données.
    require_once '../inc/db.php';
    //Connexion à la base de donnée.
    $pdo = Database::connect();
    //On fais une requête préparée qui :
    //Selectionne l'utilisateur qui a l'email qui correspond à "$emailco" et qui as une valeur dans la colonne "confirmed_at".
    $req = $pdo->prepare('SELECT * FROM users WHERE (email = :email) AND confirmed_at IS NOT NULL');
    $req->execute(['email'=> $emailco]);
    //On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée. (Si aucune informations n'ont été obtenue la variable sera vide)
    $user = $req->fetch();
    //Si des informations sont stockées dans la variable "$user", et que le password est égal à la valeur de $passwordco :
    if($user && password_verify($passwordco, $user->password)){
        //On passe la case "isSuccess" sur "true".
        $array["isSuccess"] = true;
        //On fais un "session_start()" pour avois accès à la superglobale "$_SESSION".
        session_start();
        //Déclaration de la variable "$user" dans laquel on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
        $_SESSION['auth'] = $user;
        //Si la cache remember est cochée :
        if(!empty($_POST['remember'])){
            //On stock dans la variable "$remember_token" une chaîne de caractères aléatoires.
            $remember_token = bin2hex(random_bytes(80));
            //On fais une requête préparée qui :
            //Donne la valeur de "$remember_token" à la colone remember_token ou l'ID est égal à l'id de "$user".
            $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
            //On Créé un cookie 'remember' avec comme valeur "$remember_token" crypté.
            setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . "tobiestungentilchat"), time() + 60 * 60 * 24 * 7, "/", NULL); //Le champs "NULL" est pour régler le problème de création de cookie en localhost sous Google Chrome
            //Déconnexion de la base de données.
            Database::disconnect();
        }
    }
    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionner.
    echo json_encode($array);
?>