<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FUNCTIONS ET HEADER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php
    //Déclaration de la variable "$page" pour que le header.php sache quel fichier CSS utiliser.
	$page = 'index';
    //Appel du header.php.
	require_once 'Ressources/php/inc/header.php';
?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION BANNIERE |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="Banniere">
		<div id="carouselBanniere" class="carousel slide" data-ride="carousel" data-pause="false">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img alt="Damir Restauration" src="Ressources/img/02.jpg">
				</div>
				<div class="carousel-item">
					<img alt="Damir Restauration" src="Ressources/img/191.jpg">
				</div>
				<div class="carousel-item">
					<img alt="Damir Restauration" src="Ressources/img/101.jpg">
				</div>
			</div>
			<div class="text-center">
			<div class="container titre">
				<h2>Bienvenue sur</h2>
				<h1>Damir Restauration</h1>
				<div class="white-divider"></div>
				<p>Consultez la carte du restaurant collectif de l'AFPA de Nice et r&eacute;servez vos plateaux.
					<br>
					D&eacute;couvrez &eacute;galement nos prestations traiteur, animations culinaires &agrave; 
					partir de 35 personnes
				</p>
			</div>
			</div>
		</div>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION RESTO/TRAITEUR |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="RestoTraiteur">
	<div class="container">
		<div class="row">
			<div class="col-md">
				<br>
				<fieldset>
					<legend><h2>Le restaurant</h2></legend>
					<div class="zoom">
						<a title="Accéder à la partie restauration" href="restauration.php">
							<img alt="Restauration" class="img-fluid" src="Ressources/img/092.jpg">
						</a>
					</div>
					<br>
					<p>
						Consultez nos menus, plats et desserts &agrave; la carte, choississez la date, 
						et r&eacute;servez gratuitement vos d&eacute;jeuners !
					</p>
					<a href="restauration.php" title="Accéder à la partie restauration"><button class="btn">R&eacute;servez votre plateau</button></a>
				</fieldset>
			</div>
			<div class="col-md">
				<br>
				<fieldset>
					<legend><h2>Le traiteur</h2></legend>
					<div class="zoom">
						<a title="Accéder à la partie traiteur" href="traiteur.php">
							<img alt="Traiteur" class="img-fluid" src="Ressources/img/14.jpg">
						</a>
					</div>
					<br>
					<p>
						D&eacute;couvrez nos services, "Animations culinaires traiteurs" : les chauds, 
						les froids, les sucr&eacute;s, les boissons, sans oublier les bars ! 
						<span class="note">(&agrave; partir de 35 personnes).</span>
					</p>
					<a href="traiteur.php" title="Accéder à la partie traiteur"><button class="btn">Voir nos offres</button></a>
				</fieldset>
			</div>
		</div>
	</div>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION INSCRIPTION |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php if (!isset($_SESSION['auth'])): ?>
	<section id="Inscription">
		<div class="container">
			<h3>Pas encore inscrit ?</h3>
			<p>Cr&eacute;ez votre compte et r&eacute;servez vos repas !</p>
			<br>
			<a id="btnAccount" href="#tabinscription" data-toggle="modal" data-target="#popup_logsub"><button class="btn">Cr&eacute;er mon compte</button></a>
		</div>
	</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION MON COMPTE |||||||||||||||||||||||||||||||||||||||||||||| -->
	<?php else: ?>
		<section id="moncompte">
			<div class="container text-center">
				<fieldset>
					<legend><h2>Mon compte</h2></legend>
					<div class="row">
						<div class="col-md-4">
						<a href="restauration.php" title="Reserver mon plateau"><button id="book" class="btn btn-success btn-lg"><i class="fas fa-utensils"></i> Reserver mon plateau</button></a>
						</div>
						<div class="col-md-4">
							<a title="Paramétrer mon compte" href="compte.php"><button class="btn btn-light btn-lg"><i class="fas fa-cog"></i> Param&eacute;trer mon compte</button></a>
						</div>
						<?php if ($user->isadmin == 0): ?>
							<div class="col-md-4">
								<a title="Déconnexion" href="Ressources/php/LogSub/logout.php"><button class="btn btn-danger btn-lg"><i class="fas fa-sign-out-alt"></i> Me d&eacute;connecter</button></a>
							</div>
						<?php else: ?>
							<div class="col-md-4">
								<a title="Admin" href="admin.php"><button class="btn btn-danger btn-lg"><i class="fas fa-user-shield"></i> Interface Administrateur</button></a>
							</div>
						<?php endif; ?>
					</div>
				</fieldset>
			</div>
		</section>
<?php endif; ?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php' //Appel du fichier "footer.php"?>