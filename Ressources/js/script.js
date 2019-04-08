$(function(){


//Fermer la navbar ou messages d'alert quand un clique à lieu :
//Quand un clique à lieu n'importe ou sur la page web :
$(document).on('click',function(){
    //On cache l'élément qui à la classe ".collapse".
    $('.collapse').collapse('hide');
    //On cahce l'élément qui à l'ID "#alertflash".
	$('#alertflash').hide();
})


//Activation du ToolTip :
$('[data-toggle="tooltip"]').tooltip()


//Mot de passe oublié :
//Lorsqu'un clique à lieu sur l'élément qui l'ID "#forgetpwd" :
$('#forgetpwd').click(function(){
    //On dit à jQuery d'effectuer un clique sur l'onglet caché qui a l'ID "#tabfolink".
	$('#tabfolink').click();
});


//Bouton retour de mot de passe oublié :
//Lorsqu'un clique à lieu sur l'élément qui l'ID "#returnco" :
$('#returnco').click(function(){
    //On dit à jQuery d'effectuer un clique sur l'onglet qui à l'ID "#tabco".
	$('#tabco').click();
});



//Inscription :
//Lorsque le formulaire avec l'ID "#sub-form" est envoyé :
$("#sub-form").submit(function(e){
	//On stop l'action par défaut du formulaire.
    e.preventDefault();
	//On vide les messages d'erreurs au cas ou il y en as.
    $(".msgErreur").empty();
    //On stock dans la variable postdata les valeurs des champs du formulaire.
    var postdata = $("#sub-form").serialize();
    //On ouvre une requête AJAX et on lui donne ses paramètres pour qu'il puisse envoyés les données au script php et lire les données que PHP renvois.
    $.ajax({
        type: "POST",
        url: "Ressources/php/LogSub/register.php",
        data: postdata,
        dataType: 'json',
        //Si PHP renvois des données valide :
        success: function(json){
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "true" :
            if(json.isSuccess){
				//On réinitialise le formulaire.
                $("#sub-form")[0].reset();
                //On cache l'élément qui â l'ID "#popup_logsub".
                $('#popup_logsub').modal('toggle');
                //On affiche l'élément qui a l'ID  "#popup_mail_confirm".
                $('#popup_mail_confirm').modal('toggle');
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "false" :
            } else {
                //On affiche des messages d'erreurs sous les champs.
                $("#firstname + .msgErreur").html(json.firstnameError);
                $("#lastname + .msgErreur").html(json.lastnameError);
                $("#email + .msgErreur").html(json.emailError);
                $("#password + .msgErreur").html(json.passwordError);
                $("#password_confirm + .msgErreur").html(json.password_confirmError);
            }

            
        }
    });
});


//Connexion :
//Lorsque le formulaire avec l'ID "#co-form" est envoyé :
$("#co-form").submit(function(e){
	//On stop l'action par défaut du formulaire.
    e.preventDefault();
	//On vide les messages d'erreurs au cas ou il y en as.
    $(".msgErreurco").empty();
    //On stock dans la variable postdata les valeurs des champs du formulaire.
    var postdata = $("#co-form").serialize();
    //On ouvre une requête AJAX et on lui donne ses paramètres pour qu'il puisse envoyés les données au script php et lire les données que PHP renvois.
    $.ajax({
        type: "POST",
        url: "Ressources/php/LogSub/login.php",
        data: postdata,
        dataType: 'json',
        //Si PHP renvois des données valide :
        success: function(json){
        //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "true" :
            if(json.isSuccess){
				//On réinitialise le formulaire.
                $("#co-form")[0].reset();
                //On cache l'élément qui â l'ID "#popup_logsub".
                $('#popup_logsub').modal('toggle');
                //On redirige vers l'index.
                window.location.replace('index.php');
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "false" :
            } else {
                //On affiche un message d'erreur.
                $(".msgErreurco").html('E-mail ou mot de passe incorrect');
            }

        }
    });
});


//Mot de passe oublié :
//Même opérations que si ci-dessus mais pour le mot de passe oublié.
$("#forget-form").submit(function(e){
    e.preventDefault();
    $(".msgErreurFo").empty();
    var postdata = $("#forget-form").serialize();
    $.ajax({
        type: "POST",
        url: "Ressources/php/LogSub/forget.php",
        data: postdata,
        dataType: 'json',
        success: function(json){
            if(json.isSuccess){
                $("#forget-form")[0].reset();
                $('#popup_logsub').modal('toggle');
                $('#popup_pwd_reset').modal('toggle');
            } else {
                $(".msgErreurFo").html("Aucun utilisateur n'est enregistré avec cette adresse e-mail.");
            }

        }
    });
});


});