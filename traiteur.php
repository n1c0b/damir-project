<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FUNCTIONS ET HEADER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php
    //Déclaration de la variable "$page" pour que le header.php sache quel fichier CSS utiliser.
	$page = 'traiteur';
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
	require_once 'Ressources/php/inc/functions.php';
    //Initialisation de la fonction "reconnect_cookie()" pour que l'utilisateur reste connecté si il a coché la case "Rester connecté" lors de sa connexion.
	reconnect_cookie();
    //Appel du header.php.
	require_once 'Ressources/php/inc/header.php';
?>



<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php' //Appel du fichier "footer.php"?>