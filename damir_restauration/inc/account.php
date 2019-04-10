<?php 

    require_once 'function.php';
    logged_only();
    // session_start();
    if(!empty($_POST)){
        if(empty ($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
            $_SESSION['flash']['danger'] = "les mots de passes ne correspondent pas";
        }else{
            $user_id = $_SESSION['auth']->id;
            $password= password_hash($_POST['password'], PASSWORD_BCRYPT);
            require_once 'db.php';
           $req = $pdo->prepare('UPDATE users SET password = ?');
           $req->execute([$password]); 
           $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis a jour";
        }

    }

    require 'header.php'; 
    ?>

<h1>Bonjour <?= $_SESSION['auth']->username;  ?></h1>
<form action="" method="post">
<div class="form-group">
    <input class="form-control" type="password" name="password" placeholder="changer votre mot de passe"/>
</div>
<div class="form-group">
    <input class="form-control" type="password" name="password_confirm" placeholder="Confirmation du mot de passe "/>
</div>
<button class="btn btn-primary">Changer votre mot de passe</button>

</form>



<?php require 'footer.php'; ?>