<?php
session_start();
setcookie('remember', NULL, -1);
unset($_SESSION['auth']);
header('Location: index.php');