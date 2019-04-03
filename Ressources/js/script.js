$(function(){


//Fermer la navbar collapse et les alerte flash on click
$(document).on('click',function(){
	$('.collapse').collapse('hide');
	$('#alertflash').hide();
})


//Activation du ToolTip
$('[data-toggle="tooltip"]').tooltip()


//Tab Navigation link
$('#forgetpwd').click(function(){
	$('#tabfolink').click();
});

$('#returnco').click(function(){
	$('#tabco').click();
});


// Inscription 
$("#sub-form").submit(function(e){
    e.preventDefault();
    $(".msgErreur").empty();
    var postdata = $("#sub-form").serialize();
    $.ajax({
        type: "POST",
        url: "Ressources/php/LogSub/register.php",
        data: postdata,
        dataType: 'json',
        success: function(json){
            if(json.isSuccess){
                $("#sub-form")[0].reset();
                $('#popup_logsub').modal('toggle');
                $('#popup_mail_confirm').modal('toggle');
            } else {
                $("#firstname + .msgErreur").html(json.firstnameError);
                $("#lastname + .msgErreur").html(json.lastnameError);
                $("#email + .msgErreur").html(json.emailError);
                $("#password + .msgErreur").html(json.passwordError);
                $("#password_confirm + .msgErreur").html(json.password_confirmError);
            }

            
        }
    });
});


//Connexion
$("#co-form").submit(function(e){
    e.preventDefault();
    $(".msgErreurco").empty();
    var postdata = $("#co-form").serialize();
    $.ajax({
        type: "POST",
        url: "Ressources/php/LogSub/login.php",
        data: postdata,
        dataType: 'json',
        success: function(json){
            if(json.isSuccess){
                $("#co-form")[0].reset();
                $('#popup_logsub').modal('toggle');
                window.location.replace('index.php');
            } else {
                $(".msgErreurco").html('E-mail ou mot de passe incorrect');
            }

        }
    });
});


//Mot de passe oublié
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