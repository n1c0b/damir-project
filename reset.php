<?php
if(isset($_GET['id']) && isset($_GET['token'])){
    require 'Ressources/php/inc/db.php';
    require 'Ressources/php/inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM arborea.users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();
    if($user){
        if(!empty($_POST)){
            if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
                $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas."; 
            }
            if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE arborea.users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = "<i class='fas fa-check-circle'></i> Votre mot de passe a bien été modifié";
                $_SESSION['auth'] = $user;
                header('Location: index.php');
                exit();
            }
        }
    } else {
        session_start();
        $_SESSION['flash']['danger'] = "<i class='fas fa-times-circle'></i> La clé de réinitialisation n'est plus valide";
        header('Location: index.php');
        exit();

    }
} else {
    header('Location: index.php');
    exit();
}

?>


<?php require_once 'Ressources/php/inc/header.php' ?>

<div id="resetContainer" class="container">
    <br>
    <h1>R&eacute;initialisation de votre mot de passe</h1>
    <br>

	<form action="" method="POST">

		<div class="form-group">
			<label for="password">Mot de passe</label>
			<input class="form-control" type="password" name="password" />
		</div>

		<div class="form-group">
			<label for="password_confirm">Confirmation du mot de passe</label>
			<input class="form-control" type="password" name="password_confirm" />
		</div>

		<button type="submit" class="btn logsubnavBtn">Modifier mon mot de passe</button>

	</form>
</div>

<?php require_once 'Ressources/php/inc/scripts.php'; ?>
