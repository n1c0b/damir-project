<!DOCTYPE html>

<?php
require_once 'Ressources/php/inc/functions.php'; 
require_once 'Ressources/php/inc/db.php';
require_once 'Ressources/php/panier/panier-class.php';
reconnect_cookie();
if($page == 'compte'){
	logged_only();
}
if($page == 'admin'){
	admin_only();
}
?>

<html lang="fr">

<head>

	<meta charset="UTF-8" /> <!-- Encodage en UTF-8-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" /> <!-- FontAwesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> <!-- Bootstrap -->
	<link rel="icon" href="Ressources/img/logo_afpa.png" /> <!-- Favicon -->
	<link rel="stylesheet" href="Ressources/css/style.css" /> <!-- Style CSS -->
	<!-- On echo le CSS correspondant à la variable $page. -->
	<?php if($page =='index'){echo '<link rel="stylesheet" href="Ressources/css/index.css" />';} /* Index CSS */
		  if($page =='compte'){echo '<link rel="stylesheet" href="Ressources/css/compte.css" />';} /* Compte CSS */
		  if($page =='contact'){echo '<link rel="stylesheet" href="Ressources/css/contact.css" />';} /* Contact CSS */
		  if($page =='reset'){echo '<link rel="stylesheet" href="Ressources/css/reset.css" />';} /* Reset CSS */
		  if($page =='traiteur'){echo '<link rel="stylesheet" href="Ressources/css/traiteur.css" />';} /* Traiteur CSS */
		  if($page =='restauration'){echo '<link rel="stylesheet" href="Ressources/css/restauration.css" />';} /* Restauration CSS */
		  if($page =='404'){echo '<link rel="stylesheet" href="Ressources/css/404.css" />';} /* 404 CSS */
		  if($page =='admin'){echo '<link rel="stylesheet" href="Ressources/css/admin.css" />';} /* Admin CSS */
		  if($page =='panier'){echo '<link rel="stylesheet" href="Ressources/css/panier.css" />';} /* Panier CSS */?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato"> <!-- Google Fonts -->
	<meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Responsive design -->
	<meta name="theme-color" content="#7DB43A" /> <!-- Couleur navigateur Chrome Mobile -->

	<!-- On echo le title et la meta description correspondant à la variable "$page" -->
	<?php if($page =='index'){echo '<title>Damir Restauration</title>';
		  echo "<meta name='description' content='Consultez la carte du restaurant collectif de l'AFPA de Nice et réservez vos plateaux de la semaine'>";}//Title/Desc Index
		  if($page =='compte'){echo '<title>Damir Restauration - Compte</title>';
		  echo "<meta name='description' content='Gérer et paramétrer votre compte Damir Restauration depuis cette page'>";}//Title/Desc Compte
		  if($page =='contact'){echo '<title>Damir Restauration - Contact</title>';
		  echo "<meta name='description' content='Trouver les informations de contact de Damir Restauration'>";}//Title/Desc Contact
		  if($page =='reset'){echo '<title>Damir Restauration - Réinitialisation du mot de passe</title>';
		  echo "<meta name='description' content='Réinitialiser le mot de passe de votre compte Damir Restauration'>";}//Title/Desc Reset
		  if($page =='traiteur'){echo '<title>Damir Restauration - Traiteur</title>';
		  echo "<meta name='description' content='Réservez des prestations pour vos évènements avec Damir Restauration'>";}//Title/Desc Traiteur
		  if($page =='restauration'){echo '<title>Damir Restauration - Restauration </title>';
		  echo "<meta name='description' content='Réservez votre plateau pour la semaine avec Damir Restauration'>";}//Title/Desc Traiteur
		  if($page =='404'){echo '<title>Damir Restauration - Page introuvable </title>';
		  echo "<meta name='description' content='Erreur 404, page introuvable, veuillez ré-essayer utlérieurement'>";}//Title/Desc 404
		  if($page =='admin'){echo '<title>Damir Restauration - Interface Administrateur </title>';}//Title Admin
		  if($page =='panier'){echo '<title>Damir Restauration - Récapitulatif de votre commande </title>';}//Title panier ?>


</head>

<body>

	<!-- |||||||||||||||||||||||||||||||||||||||||||||| NAVBAR |||||||||||||||||||||||||||||||||||||||||||||| -->
	<nav id="menunav" class="navbar navbar-expand-md navbar-dark py-0 px-0 fixed-top">
		<button id="hbg" href="#collapseCross" class="navbar-toggler" data-toggle="collapse" data-target="#HMenu" aria-expanded="false" aria-controls="collapseCross">
			<i class="fas fa-bars fa-lg"></i>
			<i class="fas fa-times fa-lg"></i>
		</button>
		<div class="collapse navbar-collapse" id="HMenu">
			<a class="navbar-brand" title="Damir Restauration" href="index.php">
				<h3><img alt="Logo AFPA" src="Ressources/img/mini_logo_afpa.png">Damir Restauration</h3>
			</a>
			<ul class="navbar-nav ml-auto">
				<!-- On echo la classe active sur l'onglet de la navbar correspondant à la page ou on se trouve -->
				<li class="nav-item <?php if($page =='index'){echo 'active';}?>">
					<a class="nav-link" title="Accueil" href="index.php">Accueil</a>
				</li>
				<!-- On echo la calsse "disabledLoc" si l'utilisateur n'est pas connecté afin qu'il ne puisse pas cliquer sur cet onglet -->
				<li class="nav-item <?php if($page =='restauration'){echo 'active';}?><?php if(!isset($_SESSION['auth'])){ echo'disabledLoc" data-toggle="tooltip" title="Veuillez vous connecter pour accéder à cette page."';} ?>">
					<a class="nav-link <?php if(!isset($_SESSION['auth'])){ echo'disabled';} ?>" title="Restauration" href="restauration.php">Restauration</a>
				</li>
				<li class="nav-item <?php if($page =='traiteur'){echo 'active';}?>">
					<a class="nav-link" title="Traiteur" href="traiteur.php">Traiteur</a>
				</li>
				<li class="nav-item <?php if($page =='contact'){echo 'active';}?>">
					<a class="nav-link" title="Contact" href="contact.php">Contact</a>
				</li>
				<!-- Si l'utilisateur est connecté est qu'il est administrateur on affiche l'onglet "Admin" -->
				<?php if(isset($_SESSION['auth'])): ?>
					<?php $user = $_SESSION['auth'];
						  if($user->isadmin == 1): ?>
						<li class="nav-item <?php if($page =='admin'){echo 'active';} ?>" > 
							<a class="nav-link" title="Admin" href="admin.php">Admin</a>
						</li>
					<?php endif; ?>
		  		<?php endif; ?>
				<!-- Si l'utilisateur est connecté on affiche l'onglet "Mon Compte" -->
				<?php if (isset($_SESSION['auth'])): ?>
					<li class="nav-item <?php if($page =='compte'){echo 'active';}?>">
						<a class="nav-link" title="Mon compte" href="compte.php">Mon compte</a>
					</li>
					<li class="nav-item">
						<a id="Deconnexion" class="nav-link" title="Déconnexion" href="Ressources/php/LogSub/logout.php"><i class="fas fa-sign-out-alt"></i> D&eacute;connexion</a>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<a title="Connexion/Inscription" id="connexion" class="nav-link" href="#" data-toggle="modal" data-target="#popup_logsub">Connexion | Inscription</a>
					</li>
				<?php endif;?>
			</ul>
		</div>
	</nav>

	<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION LOGSUB |||||||||||||||||||||||||||||||||||||||||||||| -->
	<section id="LOGSUB">
		<!-- |||||||||||||||||||||||||||||||||||||||||||||| MODAL CONNEXION/INSCRIPTION |||||||||||||||||||||||||||||||||||||||||||||| -->
		<div class="modal fade" id="popup_logsub">
			<div class="modal-dialog modal-lg">

				<div class="modal-content">

					<div class="modal-header logsubnav">
						<nav class="navbar logsubnav">
							<ul class="navbar logsubnav nav nav-fill w-100 px-0 py-0">
								<li class="nav-item">
									<a class="nav-link active" id="tabco" href="#tabconnexion" data-toggle="tab"><i class="fas fa-sign-in-alt"></i> Connexion</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tabsub" href="#tabinscription" data-toggle="tab"><i class="fas fa-user-edit"></i> Inscription</a>
								</li>
								<li id="hiddenItem"><a id="tabfolink" class="invisible" href="#tabforget" data-toggle="tab"></a></li>
							</ul>
						</nav>
					</div>

					<div class="modal-body">
						<div class="tab-content">

							<!-- |||||||||||||||||||||||||||||||||||||||||||||| TAB CONNEXION |||||||||||||||||||||||||||||||||||||||||||||| -->
							<div class="tab-pane fade show active" id="tabconnexion">
								<form id="co-form" action="" method="POST">

									<div class="form-group">
										<label for="emailco">E-mail :</label>
										<input class="form-control" type="text" id="emailco" name="emailco" class="form-control">
									</div>
									<div class="form-group">
										<label for="passwordco">Mot de passe :</label>
										<input class="form-control" type="password" id="passwordco" name="passwordco" class="form-control">
										<a id="forgetpwd" href="#">Mot de passe oubli&eacute; ?</a>
									</div>

									<div class="form-check"><label>
											<input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">Rester connect&eacute;
									</div>
									<button name="submitco" type="submit" class="btn logsubnavBtn">Se connecter</button>
									<button type="reset" class="btn btn-danger" data-dismiss="modal">Annuler</button>
									<p class="msgErreurco"></p>

								</form>
							</div>

							<!-- |||||||||||||||||||||||||||||||||||||||||||||| TAB INSCRIPTION |||||||||||||||||||||||||||||||||||||||||||||| -->
							<div class="tab-pane fade" id="tabinscription">
								<form id="sub-form" action="" method="POST">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lastname">Nom :</label>
												<input class="form-control" type="text" id="lastname" name="lastname" value="" class="form-control">
												<p class="msgErreur"></p>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="firstname">Pr&eacute;nom :</label>
												<input class="form-control" type="text" id="firstname" name="firstname" value="" class="form-control">
												<p class="msgErreur"></p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="password">Mot de passe :</label>
												<input class="form-control" type="password" id="password" name="password" value="" class="form-control">
												<p class="msgErreur"></p>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="password_confirm">Confirmation du mot de passe :</label>
												<input class="form-control" type="password" id="password_confirm" name="password_confirm" value="" class="form-control">
												<p class="msgErreur"></p>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="email">E-mail :</label>
										<input class="form-control" type="email" id="email" name="email" value="" class="form-control">
										<p class="msgErreur"></p>
									</div>
									<button name="submitsub" type="submit" class="btn logsubnavBtn">S'inscrire</button>
									<button type="reset" class="btn btn-danger" data-dismiss="modal">Annuler</button>
								</form>
							</div>

							<!-- |||||||||||||||||||||||||||||||||||||||||||||| TAB MDP OUBLIE |||||||||||||||||||||||||||||||||||||||||||||| -->
							<div class="tab-pane fade" id="tabforget">
								<form id="forget-form" action="" method="POST">
									<div class="form-group">
										<label for="emailfo">Veuillez renseigner l'adresse e-mail de votre compte :</label>
										<input class="form-control" type="text" id="emailfo" name="emailfo" class="form-control">
									</div>
									<a class="btn btn-danger" id="returnco"><i class="fas fa-arrow-left"></i> Retour</a>
									<button name="submitfo" type="submit" class="btn logsubnavBtn">Valider</button>
									<p class="msgErreurFo"></p>
								</form>
							</div>

						</div>
					</div>

				</div>

			</div>
		</div>


		<!-- |||||||||||||||||||||||||||||||||||||||||||||| MODAL MAIL CONFIRMATION INSCRIPTION |||||||||||||||||||||||||||||||||||||||||||||| -->
		<div class="modal fade" id="popup_mail_confirm">
			<div class="modal-dialog modal-lg">

				<div class="modal-content">
					<div class="modal-body MMailConfirm">
						<button type="button" class="close btn-lg" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<h4><i class="fas fa-check-circle"></i> Votre compte &agrave; bien &eacute;t&eacute; cr&eacute;&eacute;</h4>
						Un mail de confirmation vous &agrave; &eacute;t&eacute; envoy&eacute;.
					</div>
				</div>

			</div>
		</div>

		<!-- |||||||||||||||||||||||||||||||||||||||||||||| MODAL MAIL REINITIALISATION MDP |||||||||||||||||||||||||||||||||||||||||||||| -->
		<div class="modal fade" id="popup_pwd_reset">
			<div class="modal-dialog modal-lg">

				<div class="modal-content">

					<div class="modal-body MMailConfirm">
						<button type="button" class="close btn-lg" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<h4><i class="fas fa-check-circle"></i> Un e-mail de r&eacute;initialisation de mot de passe vous &agrave; &eacute;t&eacute; envoy&eacute;.</h4>
					</div>

				</div>

			</div>
		</div>
	</section>


	<!-- |||||||||||||||||||||||||||||||||||||||||||||| MESSAGES FLASH |||||||||||||||||||||||||||||||||||||||||||||| -->
	<div class="container">
		<?php 
        if(isset($_SESSION['flash'])) {
            foreach($_SESSION['flash'] as $type => $message) {
				echo "<div id='alertflash' class=\"alert alert-$type alert-dismissible position-fixed show role='alert'\">
					 	<button type='button' class='close' data-dismiss='alert' aria-label='Close'><i aria-hidden='true'><i class='fas fa-times'></i></i></button>
					 	$message
					 </div>";
            }
            unset($_SESSION['flash']);
        }
        ?>
	</div>

	<div id="container">
	<div id="push"></div>

	