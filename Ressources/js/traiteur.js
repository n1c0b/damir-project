$(function(){


    var open = false;
    $('#animationsIMG').click(function(){
        if(open == false){
            open = true;
            $('#animation').show();
            $(this).animate({right: '100%'});
            $('#forfaitIMG').animate({left: '90%'});
        } else {
            $('#animation').show();
            $('#forfait').hide();
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
            $('#forfait').show();
            $('#animation').hide();
            $(this).animate({left: '100%'});
            $('#animationsIMG').animate({right: '90%'});
        }
    });

});