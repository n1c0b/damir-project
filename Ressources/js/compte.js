$(function(){
    

//Nouveau MDP
$("#changePWD").submit(function(e){
	e.preventDefault();
	$(".msgErrNewPWD").empty();
	$(".msgSuccessNewPWD").empty();
	var postdata = $("#changePWD").serialize();
	$.ajax({
		type: "POST",
		url: "Ressources/php/compte/changepwd.php",
		data: postdata,
		dataType: 'json',
		success: function(json){
			if(json.isSuccess){
				$("#changePWD")[0].reset();
				$('.msgSuccessNewPWD').html('<i class="fas fa-check"></i> Votre mot de passe à bien été modifié.')
			} else {
				$(".msgErrNewPWD").html('Les mots de passe ne correspondent pas');
			}
		}
	});
});


//Change lastname
$("#changeLastName").submit(function(e){
	e.preventDefault();
	$(".msgErrLastName").empty();
	var postdata = $("#changeLastName").serialize();
	$.ajax({
		type: "POST",
		url: "Ressources/php/compte/lastname.php",
		data: postdata,
		dataType: 'json',
		success: function(json){
			if(json.isSuccess){
				$('#theLastName').html(json.inputLastName)
				$('#btnsLastNameEdit').hide();
				$('#editLastName').show();
				$('#inputLastName').html(json.inputLastName);
			} else {
				$(".msgErrLastName").html("Votre nom de famille n'est pas correct.");
			}
		}
	});
});


//Change fisrtname
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
				// $('.msgErrFirstName').show();
			}
		}
	});
});


//Change email
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
				// $('.msgErrEmail').show();
			}
		}
	});
});


//On click edit account
	$("#editLastName").click(function(){
		$('#editLastName').hide();
		$('#btnsLastNameEdit').show();
		$('#inputLastName').focus();
	});
	$("#editFirstName").click(function(){
		$('#editFirstName').hide();
		$('#btnsFirstNameEdit').show();
		$('#inputFirstName').focus();
	});
	$("#editEmail").click(function(){
		$('#editEmail').hide();
		$('#btnsEmailEdit').show();
		$('#inputEmail').focus();
	});

//btnCancel
	$("#btnCancelLastName").click(function(){
		$(".msgErrLastName").empty();
		var lastN = $('#theLastName').html();
		$('#inputLastName').val(lastN);
		$('#editLastName').show();
		$('#btnsLastNameEdit').hide();
		$('.msgErrname').hide();
	});
	$("#btnCancelFirstName").click(function(){
		$(".msgErrFirstName").empty();
		var FirstN = $('#theFirstName').html();
		$('#inputFirstName').val(FirstN);
		$('#editFirstName').show();
		$('#btnsFirstNameEdit').hide();
		$('.msgErrfirstname').hide();
	});
	$("#btnCancelEmail").click(function(){
		$(".msgErrEmail").empty();
		var EmailN = $('#theEmail').html();
		$('#inputEmail').val(EmailN);
		$('#editEmail').show();
		$('#btnsEmailEdit').hide();
		$('.msgErrEmail').hide();
	});

});