<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FUNCTIONS ET HEADER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php
    //Déclaration de la variable "$page" pour que le header.php sache quel fichier CSS utiliser.
	$page = '404';
    //Appel du header.php.
	require_once 'Ressources/php/inc/header.php';
?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| Section Erreur |||||||||||||||||||||||||||||||||||||||||||||| -->
		<section id="erreur404">
			<div class="container text-center">
				<i class="fas fa-wrench fa-10x"></i>
				<div><h1>&times;404&times;</h1>
					<h2>Cette page est actuellement indisponible</h2>
					<h4>Revenez bient&ocirc;t !</h4>
				</div>
				<a class="btn btn-lg" href="index.php" title="Retourner à l'accueil"><i class="fas fa-arrow-left"></i> Retourner &agrave; l'accueil</a><br><br><br>
			</div>
		</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php' //Appel du fichier "footer.php"?>