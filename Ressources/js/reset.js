/* |||||||||||||||||||||||||||||||||||||||||||||| REINITIALISATION DU MOT DE PASSE |||||||||||||||||||||||||||||||||||||||||||||| */
//Lorsque le formulaire avec l'ID "#reset-form" est envoyé :
$("#reset-form").submit(function(e){
	//On stop l'action par défaut du formulaire.
    e.preventDefault();
	//On vide les messages d'erreurs au cas ou il y en as.
    $(".msgErr").empty();
    //On stock dans la variable postdata les valeurs des champs du formulaire.
    var postdata = $("#reset-form").serialize();
    //On ouvre une requête AJAX et on lui donne ses paramètres pour qu'il puisse envoyés les données au script php et lire les données que PHP renvois.
    $.ajax({
        type: "POST",
        url: "Ressources/php/LogSub/reset.php",
        data: postdata,
        dataType: 'json',
        //Si PHP renvois des données valide :
        success: function(json){
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "true" :
            if(json.isSuccess){
                //On réinitialise le formulaire.
                $("#reset-form")[0].reset();
                //On ouvre le modal de confirmation.
                $('#popup_resetmdp_confirm').modal('toggle');
                //On redirige vers l'index après trois secondes.
                setTimeout(function(){ window.location.replace('index.php'); }, 3000);
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "false" :
            } else {
                //on affiche un message d'erreur.
                $(".msgErrReset").html('Les mots de passe ne correspondent pas');
            }

        }
    });
});