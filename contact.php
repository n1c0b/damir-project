<!-------------------------------------------- CALL FUNCTIONS ET HEADER -------------------------------------------->
<?php
    $page='contact';
    require_once 'Ressources/php/inc/functions.php';
    reconnect_cookie();
    require_once 'Ressources/php/inc/header.php';
?>


<!-------------------------------------------- SECTION CONTACT -------------------------------------------->
<section id="Contact">
    <h1>Contact</h1>
    <br>
    <div class="dark-divider"></div>

        <!-------------------------------------------- DIV INFORMATIONS DE CONTACT -------------------------------------------->
        <div class="container">
            <br>
            <a href="https://goo.gl/maps/M4JwTEgmjPH2" title="Adresse AFPA" target="_blank"><i class="fas fa-map-marked-alt"></i> 244 Route de Turin, 06300 Nice</a>
            <br>
            <a href="tel:+33826461414" title="Numéro Damir Restauration"><i class="fas fa-phone"></i> 08 26 46 14 14</a>
            <br>
            <br>
        </div>

    <!-------------------------------------------- DIV MAP ET FORMULAIRE DE CONTACT -------------------------------------------->
    <div class="container divContact">

        <!-------------------------------------------- WIDGET GOOGLE MAP -------------------------------------------->
        <div class="embed-responsive embed-responsive-100x400px">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2883.3724565718367!2d7.288004915779026!3d43.723588955893625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12cdc540fd3bf58b%3A0x10a08cd6d3fee1b7!2sAFPA!5e0!3m2!1sfr!2sfr!4v1545144768573" width="600" height="450" style="border:0" allowfullscreen></iframe>
        </div>
        
        <!-------------------------------------------- FORMULAIRE DE CONTACT -------------------------------------------->
        <div class="col-lg-10 offset-lg-1 text-left">
            <form id="contact-form" method="post" action="" role="form">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="prenom">Prénom <span data-toggle="tooltip" title="Ce champs est obligatoire" class="white-star">*</span></label>
                        <input id="prenom" type="text" name="prenom" class="form-control" placeholder="Votre prénom"
                            value="">
                        <p class="msgErreur"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="nom">Nom <span data-toggle="tooltip" title="Ce champs est obligatoire" class="white-star">*</span></label>
                        <input id="nom" type="text" name="nom" class="form-control" placeholder="Votre nom" value="">
                        <p class="msgErreur"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="email">E-mail <span data-toggle="tooltip" title="Ce champs est obligatoire" class="white-star">*</span></label>
                        <input id="email" type="text" name="email" class="form-control" placeholder="Votre E-mail"
                            value="">
                        <p class="msgErreur"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone">T&eacute;l&eacute;phone</label>
                        <input id="phone" type="tel" name="phone" class="form-control" placeholder="Votre numéro de téléphone"
                            value="">
                        <p class="msgErreur"></p>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="message">Message <span data-toggle="tooltip" title="Ce champs est obligatoire"
                                class="white-star">*</span></label>
                        <textarea id="message" name="message" class="form-control" placeholder="Votre message" rows="4"></textarea>
                        <p class="msgErreur"></p>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="submit" class="btnContact" value="Envoyer">
                    </div>
                </div>
                <p class="msgSend">Votre message a bien été envoy&eacute;. <i class="fas fa-check"></i></p>
            </form>
        </div>
    </div>
</section>


<!-------------------------------------------- CALL FOOTER -------------------------------------------->
<?php require_once 'Ressources/php/inc/footer.php' ?>


<!-------------------------------------------- SCRIPTS -------------------------------------------->
<script src="Ressources/js/contact.js"></script>