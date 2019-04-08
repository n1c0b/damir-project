$(function(){

/* |||||||||||||||||||||||||||||||||||||||||||||| FORMULAIRE DE CONTACT |||||||||||||||||||||||||||||||||||||||||||||| */
//Lorsque le formulaire avec l'ID "#contact-form" est envoyé :
$("#contact-form").submit(function(e){
	//On stop l'action par défaut du formulaire.
    e.preventDefault();
	//On vide les messages d'erreurs au cas ou il y en as.
    $(".msgErreur").empty();
    //On stock dans la variable postdata les valeurs des champs du formulaire.
    var postdata = $("#contact-form").serialize();
    //On ouvre une requête AJAX et on lui donne ses paramètres pour qu'il puisse envoyés les données au script php et lire les données que PHP renvois.
    $.ajax({
        type: "POST",
        url: "Ressources/php/Contact/contactform.php",
        data: postdata,
        dataType: "json",
        //Si PHP renvois des données valide :
        success: function(json){
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "true" :
            if(json.isSuccess){
                //On affiche un message de succès.
                $(".msgSend").css("visibility", "visible");
                //Et in réinitialise le formulaire.
                $("#contact-form")[0].reset();
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "false" :
            } else {
                //On affiche les messages d'erreur sous les champs du formulaire.
                $("#prenom + .msgErreur").html(json.prenomError);
                $("#nom + .msgErreur").html(json.nomError);
                $("#emailcont + .msgErreur").html(json.emailError);
                $("#phone + .msgErreur").html(json.phoneError);
                $("#message + .msgErreur").html(json.messageError);
            }

        }
    });
});

});