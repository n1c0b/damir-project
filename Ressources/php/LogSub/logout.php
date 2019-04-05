<?php
//On fais un "session_start()" pour avois accès à la superglobale "$_SESSION".
session_start();
//On supprime le cookie 'remember'.
setcookie('remember', NULL, -1, "/", NULL); //Le champs "NULL" est pour régler le problème de création de cookie en localhost sous Google Chrome
//On supprime le 'auth' de la superglobales $_SESSION.
unset($_SESSION['auth']);
//On rédirige vers l'index.
header('Location: ../../../index.php');