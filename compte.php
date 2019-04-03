<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FUNCTIONS ET HEADER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php
    //Déclaration de la variable "$page" pour que le header.php sache quel fichier CSS utiliser.
    $page='compte';
    //Appel du fichier "functions.php" afin de pouvoir utiliser les fonctions stockées dedans.
    require 'Ressources/php/inc/functions.php';
    //Initialisation de la fonction "logged_only()" pour que seul les utilisateurs connectés puissent avoir accés à cette page.
    logged_only();
    //Initialisation de la fonction "reconnect_cookie()" pour que l'utilisateur reste connecté si il a coché la case "Rester connecté" lors de sa connexion.
    reconnect_cookie();
    //Appel du header.php.
    require_once 'Ressources/php/inc/header.php';
    //Déclaration de la variable "$user" dans laquel on stock les données de "$_SESSION['auth']" (Soit les données de l'utilisateur connecté).
    $user = $_SESSION['auth'];
?>


<!-- ||||||||||||||||||||||||||||||||||||||||||||| SECTION COMPTE |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="compte">
    <div class=container>
        <br>
        <h1 class="text-center">G&eacute;rer mon compte<h1>
        <div class="dark-divider"></div>
        <br>
        <div class="row">

            <!-- |||||||||||||||||||||||||||||||||||||||||||||| DIV INFORMATIONS PERSONELLES |||||||||||||||||||||||||||||||||||||||||||||| -->
            <div id="InfoPerso" class="col-md">
                <fieldset>
                    <legend><h4>Informations personnelles :</h4></legend>
                    <div id="LastnameInfo"> 
                        <form class="form-inline" action="#" id="changeLastName">
                            <label for="inputLastName">Nom :</label> 
                            <span id="editLastName">
                                <span id="theLastName"><?php echo ($user->lastname); ?></span>
                                <button data-toggle="tooltip" title="Modifier mon nom" type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </span>
                            <span class="hide" id="btnsLastNameEdit">
                                <input type="text" id="inputLastName" name="inputLastName" value="<?php echo ($user->lastname); ?>">
                                <button type="submit" id="btnOkLastName" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                <button type="button" id="btnCancelLastName" class="btn btn-danger btn-sm btnCancel"><i class="fas fa-times"></i></button>
                            </span>
                            <br>
                            <br>
                            <br>
                            <p class="msgErrLastName"></p>
                        </form>
                    </div>
                    <div id="FirstNameInfo"> 
                        <form class="form-inline"  action="#" id="changeFirstName">
                            <label for="inputFirstName">Pr&eacute;nom :</label> 
                            <span id="editFirstName">
                            <span id="theFirstName"><?php echo ($user->firstname); ?></span>
                                <button data-toggle="tooltip" title="Modifier mon prénom" type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </span>
                            <span class="hide" id="btnsFirstNameEdit">
                                <input type="text" id="inputFirstName" name="inputFirstName" value="<?php echo ($user->firstname); ?>">
                                <button type="submit" id="btnOkFirstName" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                <button type="button" id="btnCancelFirstName" class="btn btn-danger btn-sm btnCancel"><i class="fas fa-times"></i></button>
                            </span>
                            <br>
                            <br>
                            <br>
                            <p class="msgErrFirstName"></p>
                        </form>
                    </div>
                    <div id="EmailInfo"> 
                        <form class="form-inline"  action="#" id="changeEmail">
                            <label for="inputEmail">E-mail :</label> 
                            <span id="editEmail">
                                <span id="theEmail"><?php echo ($user->email); ?></span>
                                <button data-toggle="tooltip" title="Modifier mon e-mail" type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </span>
                            <span class="hide" id="btnsEmailEdit">
                                <input type="text" id="inputEmail" name="inputEmail" value="<?php echo ($user->email); ?>">
                                <button type="submit" id="btnOkEmail" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                <button type="button" id="btnCancelEmail" class="btn btn-danger btn-sm btnCancel"><i class="fas fa-times"></i></button>
                            </span>
                            <br>
                            <br>
                            <br>
                            <p class="msgErrEmail"></p>
                        </form>
                        <br>
                        <br>
                    </div>
                    <h5>Date d'inscription : <?php  $date = date('d/m/Y', time()); //Conversion de la date d'inscription au format français.
                                                    $user->confirmed_at = $date;
                                                    echo $user->confirmed_at; ?></h5>
                    <h5>Identifiant client : <?php echo ($user->id); ?></h5>
                </fieldset>
            </div>
            
            <!-- |||||||||||||||||||||||||||||||||||||||||||||| DIV MODIFIER MON MOT DE PASSE |||||||||||||||||||||||||||||||||||||||||||||| -->
            <div id="mdpModify" class="col-md">
                <fieldset>
                    <legend><h4>Modifier mon mot de passe :</h4></legend>
                    <form action="" method="POST" id="changePWD">
                            <div class="form-group">
                                <input type="password" name="newPWD" id="newPWD" class="form-control" placeholder="Nouveau mot de passe">
                            </div>
                            <div class="form-group">
                                <input type="password" name="newPWDOK" id="newPWDOK" class="form-control" placeholder="Confirmation du nouveau mot de passe">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="newPWDbtn" id="newPWDbtn" class="text-center btn btn-success btn-lg">Modifier mon mot de passe</button>
                            </div>
                            <br>
                            <p class="msgErrNewPWD"></p>
                            <p class="msgSuccessNewPWD"></p>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php' //Appel du fichier "footer.php"?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SCRIPTS |||||||||||||||||||||||||||||||||||||||||||||| -->
<script src="Ressources/js/compte.js"></script>