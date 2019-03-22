<?php
    $page='compte';
    require 'Ressources/php/inc/functions.php';
    logged_only();
    reconnect_cookie();
    require_once 'Ressources/php/inc/header.php';
    require_once 'Ressources/php/inc/db.php';
    $user = $_SESSION['auth'];
?>


<section id="compte">
    <div class=container>
        <br>
        <h1 class="text-center">G&eacute;rer mon compte<h1>
        <div class="dark-divider"></div>
        <br>
        <div class="row">
            <div class="col-md">
                <fieldset>
                    <legend><h4>Informations personnelles :</h4></legend>
                    <span id="LastnameInfo"> 
                        <form action="" method="POST" id="changeLastname">
                            <label for="inputLastName">Nom :</label> 
                            <span id="editLastName" ><?php echo ($user->lastname); ?></span> <button name="FbtnEditLastname"  id="FbtnEditLastname" data-toggle="tooltip" title="Mdifier mon nom" type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                            <input type="text" id="inputLastName" name="inputLastName" value="<?php echo ($user->lastname); ?>">
                            <button type="submit" id="btnEditLastName" name="btnEditLastName" class="btn btn-success"><i class="fas fa-check"></i></button>
                            <p class="msgErrname"></p>
                        </form>
                    </span>
                    <span id="FirstNameInfo">
                        <form action="" method="POST" id="changeFirstname">
                            <label for="editFirstName">Pr&eacute;nom :</label> 
                            <span id="editFirstName"><?php echo ($user->firstname); ?></span> <button id="FbtnEditFirstname" name="FbtnEditFirstname" data-toggle="tooltip" title="Modifier mon prénom" type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                            <input type="text" id="inputFirstName" name="inputFirstName" value="<?php echo ($user->firstname); ?>">
                            <button type="submit" id="btnEditFirstName" name="btnEditFirstName" class="btn btn-success"><i class="fas fa-check"></i></button>
                            <p class="msgErrfirstname"></p>
                        </form>
                    </span>
                    <span id="EmailInfo">
                        <form action="" method="POST" id="changeEmail">
                            <label for="editEmail">E-mail :</label> 
                            <span id="editEmail"><?php echo ($user->email); ?></span> <button id="FbtnEditEmail" name="FbtnEditEmail" data-toggle="tooltip" title="Cliquez pour modifier votre adresse e-mail" type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                            <input type="text" id="inputEmail" name="inputEmail" value="<?php echo ($user->email); ?>">
                            <button type="submit" id="btnEditEmail" name="btnEditEmail" class="btn btn-success"><i class="fas fa-check"></i></button>
                            <p class="msgErrEmail"></p>
                        </form>
                    </span>
                    <h5>Date d'inscription : <?php if ($user->confirmed_at != null): ?>
                                                <?php echo ($user->confirmed_at); ?></h5>
                                            <?php else: ?>
                                                <?php $date = date('m/d/Y', time()); 
                                                    echo $date; ?></h5>
                                            <?php endif; ?>
                    <h5> Identifiant client : <?php echo ($user->id); ?></h5>
                </fieldset>
            </div>
            <div class="col-md">
                <form action="" method="POST" id="changePWD">
                    <fieldset>
                        <legend><h4>Modifier mon mot de passe :</h4></legend>
                        <div class="form-group">
                            <input type="password" name="newPWD" id="newPWD" class="form-control" placeholder="Nouveau mot de passe">
                        </div>
                        <div class="form-group">
                            <input type="password" name="newPWDOK" id="newPWDOK" class="form-control" placeholder="Confirmation du nouveau mot de passe">
                        </div>
                        <p class="msgErrNewPWD"></p>
                        <p class="msgSuccessNewPWD"></p>
                        <button type="submit" name="newPWDbtn" id="newPWDbtn" class="btn btn-success btn-lg">Modifier mon mot de passe</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- CALL FOOTER -->
<?php require_once 'Ressources/php/inc/footer.php' ?>