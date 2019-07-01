$(function(){


    var open = false;
    $('#animationsIMG').click(function(){
        if(open == false){
            open = true;
            $('#animation').show();
            $(this).animate({bottom: '600px'});
            $('#forfaitIMG').animate({bottom: '600px'});
            $('#h2For').animate({top: '330px'});
            $('#forfaitIMG').removeClass('openCardActive');
            $('#h2Ani').animate({top: '330px'});
            $(this).addClass('openCardActive');

        } else {
            $('#forfaitIMG').removeClass('openCardActive');
            $(this).addClass('openCardActive');
            $('#animation').fadeIn();
            $('#forfait').fadeOut();
        }
    });


    $('#forfaitIMG').click(function(){
        if(open == false){
            open = true;
            $('#forfait').show();
            $(this).animate({bottom: '600px'});
            $('#animationsIMG').animate({bottom: '600px'});
            $('#h2For').animate({top: '330px'});
            $(this).addClass('openCardActive');
            $('#h2Ani').animate({top: '330px'});
        } else {
            $('#animationsIMG').removeClass('openCardActive');
            $(this).addClass('openCardActive');
            $('#forfait').fadeIn();
            $('#animation').fadeOut();
        }
    });


});