$(function(){


    var open = false;
    $('#animationsIMG').click(function(){
        if(open == false){
            open = true;
            $('#animation').show();
            $(this).animate({right: '100%'});
            $('#forfaitIMG').animate({left: '90%'});
        } else {
            $('#animation').fadeIn();
            $('#forfait').fadeOut();
            $(this).animate({right: '100%'});
            $('#forfaitIMG').animate({left: '90%'});
        }
        });

    $('#forfaitIMG').click(function(){
        if(open == false){
            open = true;
            $('#forfait').show();
            $(this).animate({left: '100%'});
            $('#animationsIMG').animate({right: '90%'});
        } else {
            $('#forfait').fadeIn();
            $('#animation').fadeOut();
            $(this).animate({left: '100%'});
            $('#animationsIMG').animate({right: '90%'});
        }
    });

});