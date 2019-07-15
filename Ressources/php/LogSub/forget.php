<?php
    //On déclare un tableau avec une case booléenne "isSuccess" paramétrée sur "true".
    $array = array("isSuccess" => true);

    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require_once '../inc/functions.php';

    //On stock dans la variable "$emailfo" la valeur du champs du formulaire "emailfo" et on effectue la fonction "verifyInput()" dessus afin de contrer les failles XSS.
    $emailfo = verifyInput($_POST["emailfo"]);

    //On appel le fichier db.php afin d'avoir accès à la base de données.
    require_once '../inc/db.php';

    //Connexion à la base de données.
    $pdo = Database::connect();
    //On fais une requête préparée qui :
    //Selectionne l'utilisateur dans la table users qui à l'email égal à l'email envoyé,
    //Et qui a la colone confirmed_at qui ne vaut pas null.
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$emailfo]);
    /*On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée.
        - (Si aucune informations n'ont été obtenue la variable sera vide). */
        
    $user = $req->fetch();
    //Si des informations sont stockées dans la variable "$user" :
    if($user){
        //On fais un "session_start()" pour avois accès à la superglobale "$_SESSION".
        session_start();
        //On stock dans la variable $rest_token une chaine de caractères aléatoires.
        $reset_token = bin2hex(random_bytes(60));
        /* On fais une requête préparée qui :
            - Donne la valeur de "$reset_token" à la colonne reset_token ou l'ID correspond la l'ID de "$user",
            - Donne la valeur de la date de maintenant à la colonne rest_at. */
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        //Déconnexion de la base de données.
        Database::disconnect();
        //Envois d'un mail avec le lien de réinitialisation du mot de passe.
        $headers= "From: {'Damir'} {'Restauration'} <{'nepasrepondre@damir.fr'}>";
        mail($emailfo, 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe, merci de cliquer sur ce <a href='
        http://localhost/damir-project-git/resetmdp.php?id={$user->id}&token=$reset_token'>lien</a>\n\n", $hearders);
    //Si aucune information n'est stockée dans la variable "$user" :    
    } else {
        //On passe la case "isSuccess" sur "false".
        $array['isSuccess'] = false;
    }

    //On fais un echo de l'array encodé en json pour que le script AJAX puisse le réceptionner.
    echo json_encode($array);
?>