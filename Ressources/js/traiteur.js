$(function(){


    var open = false;
    $('#animationsIMG').click(function(){
        if(open == false){
            open = true;
            $('#animation').show();
            $(this).animate({right: '100%'});
            $('#forfaitIMG').animate({left: '90%'});
            $('#h2For').animate({right: '112%'}).css({'transform' : 'rotate(90deg)'});
            $('#h2Ani').animate({left: '112%'}).css({'transform' : 'rotate(-90deg)'});
        } else {
            $('#animation').fadeIn();
            $('#forfait').fadeOut();
            $(this).animate({right: '100%'});
            $('#forfaitIMG').animate({left: '90%'});
        }
    });

    $('#animationsIMG').hover(function(){
        if(open == true){
            $('#h2Ani').css({'transform' : 'scale(1.1) rotate(-90deg)'});
        }
    }, function(){
        if(open == true){
            $("#h2Ani").css({'transform' : 'scale(1.0) rotate(-90deg)'});
        }
    });


    $('#forfaitIMG').click(function(){
        if(open == false){
            open = true;
            $('#forfait').show();
            $(this).animate({left: '100%'});
            $('#animationsIMG').animate({right: '90%'});
            $('#h2For').animate({right: '112%'}).css({'transform' : 'rotate(90deg)'});
            $('#h2Ani').animate({left: '112%'}).css({'transform' : 'rotate(-90deg)'});
        } else {
            $('#forfait').fadeIn();
            $('#animation').fadeOut();
            $(this).animate({left: '100%'});
            $('#animationsIMG').animate({right: '90%'});
        }
    });

    $('#forfaitIMG').hover(function(){
        if(open == true){
            $('#h2For').css({'transform' : 'scale(1.1) rotate(90deg)'});
        }
    }, function(){
        if(open == true){
            $("#h2For").css({'transform' : 'scale(1.0) rotate(90deg)'});
        }
    });


});