<?php
if(session_status() == PHP_SESSION_NONE){

    session_start();

}
?>

<!DOCTYPE html>
<html>
  <head>
        <title>Damir Restauration</title>
        <meta name="theme-color" content="#7DB43A">
        <link rel="icon" href="images/fh-icon.png"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="../js/script.js"></script>
        <link rel="stylesheet" href="../css/app.css">
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  </head>
  <body>
		<div id="content">

	
      <nav class="navbar navbar-expand-md sticky-top" id="MaNavBar">
      <a class="navbar-brand logo" href="#accueil"><img src="../images/afpa.png" alt="afpa" class="afpa-image">DAMIR RESTAURATION</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar">
                <i class="fas fa-bars fa-lg"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav nav-fill w-100   navbar-nav">
                        <li class="nav-item"><a class="nav-link active" href="#accueil">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="#restauration">Restauration</a></li>
                        <li class="nav-item"><a class="nav-link" href="#traiteur">Traiteur</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                     <?php if(isset($_SESSION['auth'])): ?>
                        <li class="nav-item"><a class="nav-link" id="deconnexion" href="logout.php">Se déconnecter</a></li>
                     <?php else: ?>
                        <li class="nav-item"><a class="nav-link" id="connexion" href="#" data-toggle="modal" data-target="#mymodal">Se connecter/S'inscrire</a></li>

                     <?php endif; ?>
               
            </ul>
        </div>
       </nav>
      <div class="container">
      
        <?php 
          if(isset($_SESSION['flash'])){
            foreach($_SESSION['flash'] as $type => $message){
                echo "<br><br><br>
				<div class=\"alert alert-$type alert-dismissible show role='alert'\">
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><i aria-hidden='true'>&times;</i></button>
					$message
				</div>";
            }
            unset($_SESSION['flash']);
          }
         ?>
      </div>
    
<!-- modal -->
      
<section id="LOGSUB">
	<div class="modal fade" id="mymodal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header logsubnav bg-info">
					<nav class="navbar logsubnav">
						<ul class="navbar logsubnav px-0 py-0 nav nav-fill w-100">
							<li class="nav-item"><a class="nav-link active con" href="#tabconnexion" data-toggle="tab">Connexion</a></li>
							<li class="nav-item"><a class="nav-link" href="#tabinscription" data-toggle="tab">Inscription</a></li>
							<li id="hiddenItem"><a id="tabfolink" class="invisible" href="#tabforget" data-toggle="tab"></a></li>
							<!-- <li class="nav-item"><a class="nav-link bg-danger" id="closeTabSubLog" href="#" data-dismiss="modal"><i class="fas fa-times fa-2x"></i></a> -->
						</ul>
					</nav>
				</div>

				<div class="modal-body">
					<div class="tab-content">

						<!-- TAB CONNEXION -->
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
										<input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">Rester
										connect&eacute;
								</div>
								<button name="submitco" type="submit" class="btn btn-info">Se connecter</button>
								<button type="reset" class="btn btn-danger" data-dismiss="modal">Annuler</button>
								<p class="msgErreurco"></p>

							</form>
						</div>

						<!-- TAB INSCRIPTION -->
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
								<button name="submitsub" type="submit" class="btn btn-info">S'inscrire</button>
								<button type="reset" class="btn btn-danger" data-dismiss="modal">Annuler</button>
							</form>
						</div>

						<!-- TAB MOT DE PASSE OUBLIE -->
						<div class="tab-pane fade" id="tabforget">
							<form id="forget-form" action="" method="POST">
								<div class="form-group">
									<label for="emailfo">Veuillez renseigner l'adresse e-mail de votre compte :</label>
									<input class="form-control" type="text" id="emailfo" name="emailfo" class="form-control">
								</div>
								<a class="btn btn-danger" id="returnco"><i class="fas fa-arrow-left"></i> Retour</a>
								<button name="submitfo" type="submit" class="btn btn-info">Valider</button>
								<p class="msgErreurFo"></p>
							</form>
						</div>

					</div>
				</div>

			</div>

		</div>
	</div>


	<!-- MODAL MAIL CONFIRM -->
	<div class="modal fade" id="popup_mail_confirm">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-body bg-info MMailConfirm">
					<button type="button" class="close btn-lg" data-dismiss="modal"><i class="fas fa-times"></i></button>
					<h4><i class=" btn-success fas fa-check-circle"></i> Votre compte &agrave; bien &eacute;t&eacute;
						cr&eacute;&eacute;</h4>
					Un mail de confirmation vous &agrave; &eacute;t&eacute; envoy&eacute;.
				</div>
			</div>

		</div>
	</div>

	<!-- MODAL MDP OUBLIE MAIL RESET -->
	<div class="modal fade" id="popup_pwd_reset">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-body bg-info MMailConfirm">
					<button type="button" class="close btn-lg" data-dismiss="modal"><i class="fas fa-times"></i></button>
					<h4><i class=" btn-success fas fa-check-circle"></i> Un e-mail de r&eacute;initialisation de mot de passe vous
						&agrave; &eacute;t&eacute; envoy&eacute;.</h4>
				</div>
			</div>

		</div>
	</div>
</section>


      
    