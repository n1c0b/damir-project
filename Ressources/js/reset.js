// //Reinitialisation du Mot de passe
$("#reset-form").submit(function(e){
    e.preventDefault();
    $(".msgErr").empty();
    var postdata = $("#reset-form").serialize();
    $.ajax({
        type: "POST",
        url: "Ressources/php/LogSub/reset.php",
        data: postdata,
        dataType: 'json',
        success: function(json){
            if(json.isSuccess){
                $("#reset-form")[0].reset();
                $('#popup_resetmdp_confirm').modal('toggle');
                setTimeout(function(){ window.location.replace('index.php'); }, 3000);
            } else {
                $(".msgErrReset").html('Les mots de passe ne correspondent pas');
            }

        }
    });
});