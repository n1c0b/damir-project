$(function(){

//Formulaire de contact
$("#contact-form").submit(function(e){
    e.preventDefault();
    $(".msgErreur").empty();
    var postdata = $("#contact-form").serialize();
    $.ajax({
        type: "POST",
        url: "Ressources/php/Contact/contactform.php",
        data: postdata,
        dataType: "json",
        success: function(json){
            if(json.isSuccess){
                $(".msgSend").css("visibility", "visible");
                $("#contact-form")[0].reset();
            } else {
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