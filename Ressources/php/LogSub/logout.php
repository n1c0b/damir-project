<?php
session_start();
/* -------------------------------------------- SUPPRESSION DU COOKIE REMEMBER -------------------------------------------- */
setcookie('remember', NULL, -1, "/", NULL); //Le champs "NULL" est pour régler le problème de création de cookie en localhost sous Google Chrome


/* -------------------------------------------- DECONNEXION -------------------------------------------- */
unset($_SESSION['auth']);


/* -------------------------------------------- REDIRECTION VERS L'INDEX -------------------------------------------- */
header('Location: ../../../index.php');