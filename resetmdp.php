<?php
//Déclaration de la variable "$page" pour que le header.php sache quel fichier CSS utiliser.
$page = 'resetmdp';
//Si il n'y a pas dans l'URL les chaine de caractères "id" et "token" :
if(!isset($_GET['id']) && !isset($_GET['token'])){
    //On redirige vers l'index.
    header('Location: index.php');
    //et on termine l'execution du script.
    exit();
}
//Appel du fichier db.php pour avoir accès aux données de la base de données.
require 'Ressources/php/inc/db.php';
//On fais une requête préparée qui : 
//Selectionne tous les utilisateurs ou l'ID est égal à la valeur de l'ID dans l'URL,
//Le reset_token n'est pas null et est égal à la valeur du token dans l'URL,
//Le reset_at ne date pas de plus de 24 heures.
$pdo= Database::connect();
$req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)');
$req->execute([$_GET['id'], $_GET['token']]);
//On initialise la variable "$user" dans laquelle on stock sous forme de tableau les informations obtenues par la requête préparée. (Si aucune informations n'ont été obtenue la variable sera vide)
$user = $req->fetch();
Database::disconnect();
//Si des informations sont stockées dans la variable "$user" :
if(!$user){
    //On fais un "session_start()" pour avois accès à la superglobale "$_SESSION".
    session_start();
    //On affiche un message d'erreur.
    $_SESSION['flash']['danger'] = "La clé de réinitialisation n'est plus valide";
    //On redirige vers l'index.
    header('Location: index.php');
    //et on termine l'execution du script.
    exit();
}
?>

<head>
	<meta charset="UTF-8" /> <!-- Encodage en UTF-8-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" /> <!-- FontAwesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> <!-- Bootstrap -->
	<link rel="icon" href="Ressources/img/logo_afpa.png" /> <!-- Favicon -->
	<link rel="stylesheet" href="Ressources/css/style.css" /> <!-- Style CSS -->
	<link rel="stylesheet" href="Ressources/css/resetmdp.css" /> <!-- resetmdp CSS -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato"> <!-- Google Fonts -->
	<meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Responsive design -->
	<meta name="theme-color" content="#7DB43A" /> <!-- Couleur navigateur Chrome Mobile -->

	<title>Mot de passe oublié </title>
	<meta name="description" content="Réinitialiser mon mot de passe">
</head>

<body>

<div id="container">

<!-- |||||||||||||||||||||||||||||||||||||||||||||| FORMULAIRE DE REINITIALISATION DU MOT DE PASSE |||||||||||||||||||||||||||||||||||||||||||||| -->
    <div id="titlereset" class="text-center container-fluid">
        <br>
        <h1>Damir Restauration <br><br> R&eacute;initialisation de votre mot de passe</h1>
        <br>
    </div>
    <br>
    <div id="resetContainer" class="container">
        <form id="reset-form" action="#" method="POST">
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input class="form-control" type="password" id="password" name="password" />
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirmation du mot de passe</label>
                <input class="form-control" type="password" id="password_confirm" name="password_confirm" />
            </div>
            <input type="text" id="token" name="token" value=<?php echo $_GET['token'] ?>>
            <input type="text" id="id" name="id" value=<?php echo $_GET['id'] ?>>
            <button type="submit" class="btn logsubnavBtn">Modifier mon mot de passe</button>
            <br>
            <br>
            <p class="msgErrReset"><p>
        </form>
    </div>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| MODAL MDP RESET CONFIRMATION |||||||||||||||||||||||||||||||||||||||||||||| -->
	<div class="modal fade" id="popup_resetmdp_confirm">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-body MDPResetConfirm">
					<h4><i class="fas fa-check-circle"></i> Votre mot de passe &agrave; bien &eacute;t&eacute; modifi&eacute;.</h4>
                    <h5>Vous allez &ecirc;tre redirig&eacute; dans quelques instants...</h5>
				</div>
			</div>

		</div>
	</div>


<?php require_once 'Ressources/php/inc/footer.php'; //Appel du fichier "footer.php"?>