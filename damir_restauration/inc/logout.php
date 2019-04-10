<?php 
    session_start();
    setcookie('remember', NULL, -1);
    unset($_SESSION['auth']);
    $_SESSION['flash']['success'] = 'Vous étes maintenant déconnecté';
    header('Location: index.php');
?>