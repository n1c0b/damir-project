$(function(){

    $('#animationsIMG').click(function(){
        $('#animation').show();
        $(this).animate({right: '90%'});
        $('#forfaitIMG').animate({left: '90%'});
    });
    $('#forfaitIMG').click(function(){
        $('#forfait').show();
        $(this).animate({left: '90%'});
        $('#animationsIMG').animate({right: '90%'});
    });

});