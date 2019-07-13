$(function(){

/* |||||||||||||||||||||||||||||||||||||||||||||| NOUVEAU MDP |||||||||||||||||||||||||||||||||||||||||||||| */
//Lorsque le formulaire avec l'ID "#changePWD" est envoyé :
$("#changePWD").submit(function(e){
	//On stop l'action par défaut du formulaire.
	e.preventDefault();
	//On vide les messages d'erreurs au cas ou il y en as.
	$(".msgErrNewPWD").empty();
	//On vide les messages de succès au cas ou il y en as.
	$(".msgSuccessNewPWD").empty();
    //On stock dans la variable postdata les valeurs des champs du formulaire.
	var postdata = $("#changePWD").serialize();
    //On ouvre une requête AJAX et on lui donne ses paramètres pour qu'il puisse envoyés les données au script php et lire les données que PHP renvois.
	$.ajax({
		type: "POST",
		url: "Ressources/php/compte/changepwd.php",
		data: postdata,
		dataType: 'json',
        //Si PHP renvois des données valide :
		success: function(json){
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "true" :
			if(json.isSuccess){
				//On réinitialise le formulaire.
				$("#changePWD")[0].reset();
				//On affiche un message de succès.
				$('.msgSuccessNewPWD').html('<i class="fas fa-check"></i> Votre mot de passe à bien été modifié.')
            //Si dans les données envoyées par PHP la case "isSuccess" du array n'est pas égal à "true" :
			} else {
				//On affiche un message d'erreur.
				$(".msgErrNewPWD").html('Les mots de passe ne correspondent pas');
			}
		}
	});
});


/* |||||||||||||||||||||||||||||||||||||||||||||| NOUVEAU NOM |||||||||||||||||||||||||||||||||||||||||||||| */
//Lorsque le formulaire avec l'ID "#changeLastName" est envoyé :
$("#changeLastName").submit(function(e){
	//On stop l'action par défaut du formulaire.
	e.preventDefault();
	//On vide les messages d'erreurs au cas ou il y en as.
	$(".msgErrLastName").empty();
    //On stock dans la variable postdata les valeurs des champs du formulaire.
	var postdata = $("#changeLastName").serialize();
    //On ouvre une requête AJAX et on lui donne ses paramètres pour qu'il puisse envoyés les données au script php et lire les données que PHP renvois.
	$.ajax({
		type: "POST",
		url: "Ressources/php/compte/lastname.php",
		data: postdata,
		dataType: 'json',
        //Si PHP renvois des données valide :
		success: function(json){
            //Si dans les données envoyées par PHP la case "isSuccess" du array est égal à "true" :
			if(json.isSuccess){
				//On insère dans l'élément qui a l'ID "#theLastName", la valeur de la case "inputLastName" du array.
				$('#theLastName').html(json.inputLastName)
				//On cache l'élément qui a l'ID "#btnsLastNameEdit".
				$('#btnsLastNameEdit').hide();
				//On affiche l'élément qui a l'ID "#editLastName".
				$('#editLastName').show();
				//On insère dans l'élément qui a l'ID "#inputLastName" la valeur de la case "inputLastName" du array.
				$('#inputLastName').html(json.inputLastName);
			    //Si dans les données envoyées par PHP la case "isSuccess" du array n'est pas égal à "true" :
			} else {
				//On affiche un message d'erreur.
				$(".msgErrLastName").html("Votre nom de famille n'est pas correct.");
			}
		}
	});
});


/* |||||||||||||||||||||||||||||||||||||||||||||| NOUVEAU PRENOM |||||||||||||||||||||||||||||||||||||||||||||| */
//Mêmes opérations que plus haut mais cette fois-ci pour le prénom.
$("#changeFirstName").submit(function(e){
	e.preventDefault();
	$(".msgErrFirstName").empty();
	var postdata = $("#changeFirstName").serialize();
	$.ajax({
		type: "POST",
		url: "Ressources/php/compte/firstname.php",
		data: postdata,
		dataType: 'json',
		success: function(json){
			if(json.isSuccess){
				$('#theFirstName').html(json.inputFirstName)
				$('#btnsFirstNameEdit').hide();
				$('#editFirstName').show();
				$('#inputFirstName').html(json.inputFirstName);
			} else {
				$(".msgErrFirstName").html("Votre prénom n'est pas correct.");
			}
		}
	});
});


/* |||||||||||||||||||||||||||||||||||||||||||||| NOUVEL EMAIL |||||||||||||||||||||||||||||||||||||||||||||| */
/* Mêmes opérations que plus haut mais cette fois-ci pour l'e-mail 
A l'execption que le message d'erreur sera remplis avec la case "emaiLError" du array, car il y des messages d'erreur différent pour l'email. */
$("#changeEmail").submit(function(e){
	e.preventDefault();
	$(".msgErrEmail").empty();
	var postdata = $("#changeEmail").serialize();
	$.ajax({
		type: "POST",
		url: "Ressources/php/compte/email.php",
		data: postdata,
		dataType: 'json',
		success: function(json){
			if(json.isSuccess){
				$('#theEmail').html(json.inputEmail)
				$('#btnsEmailEdit').hide();
				$('#editEmail').show();
				$('#inputEmail').html(json.inputEmail);
			} else {
				$(".msgErrEmail").html(json.emailError);
			}
		}
	});
});


/* |||||||||||||||||||||||||||||||||||||||||||||| BOUTON EDIT |||||||||||||||||||||||||||||||||||||||||||||| */
	//Bouton éditer nom :
	//Lorsqu'un clique à lieu sur l'élément qui à l'ID "#editLastName" :
	$(document).on('click', '#editLastName', function(){
		//On cache cet élément.
		$('#editLastName').hide();
		//On affiche l'élément qui a l'ID "#btnsLastNameEdit".
		$('#btnsLastNameEdit').show();
		//On fais un focus sur l'élément qui a l'ID "#inputLastName".
		$('#inputLastName').focus();
	});
	//Bouton éditer prénom :
	//Même opérations mais pour les éléments correspondants au prénom.
	$(document).on('click', '#editFirstName', function(){
		$('#editFirstName').hide();
		$('#btnsFirstNameEdit').show();
		$('#inputFirstName').focus();
	});
	////Bouton éditer e-mail :
	//Même opérations mais pour les éléments correspondants a l'e-mail.
	$(document).on('click', '#editEmail', function(){
		$('#editEmail').hide();
		$('#btnsEmailEdit').show();
		$('#inputEmail').focus();
	});


/* |||||||||||||||||||||||||||||||||||||||||||||| BOUTON ANNULER |||||||||||||||||||||||||||||||||||||||||||||| */
	//Bouton annuler édition nom :
	//Lorsqu'un clique à lieu sur l'élément qui à l'ID "#btnCancelLastName" :
	$(document).on('click', '#btnCancelLastName', function(){
		//On vide les messages d'erreurs au cas ou il y en a.
		$(".msgErrLastName").empty();
		//On stock dans la variable "lastN" le contenu HTML de l'élément qui a l'ID "#theLastName".
		var lastN = $('#theLastName').html();
		//On défini la value de l'élément qui a l'ID "#inputLastName" avec la valeur de la variable "lastN".
		$('#inputLastName').val(lastN);
		//On affiche l'élément qui a l'ID "#editLastName".
		$('#editLastName').show();
		//On cache l'élément qui a l'ID "#btnsLastNameEdit".
		$('#btnsLastNameEdit').hide();
	});

	//Bouton annuler édition prénom :
	//Même opérations mais pour les éléments correspondants au prénom.
	$(document).on('click', '#btnCancelFirstName', function(){
		$(".msgErrFirstName").empty();
		var FirstN = $('#theFirstName').html();
		$('#inputFirstName').val(FirstN);
		$('#editFirstName').show();
		$('#btnsFirstNameEdit').hide();
	});

	//Bouton annuler édition e-mail :
	//Même opérations mais pour les éléments correspondants a l'e-mail.
	$(document).on('click', '#btnCancelEmail', function(){
		$(".msgErrEmail").empty();
		var EmailN = $('#theEmail').html();
		$('#inputEmail').val(EmailN);
		$('#editEmail').show();
		$('#btnsEmailEdit').hide();
	});

});