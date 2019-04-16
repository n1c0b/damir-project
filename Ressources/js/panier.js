$(document).ready(function () {
    $('.addPanier').click(function(e){
        e.preventDefault();
        $.get($(this).attr('href'),{},function(data){
            if (data.error) {
                alert(data.message);
            }
            else
            {
                $('.total').empty().append(data.total);
                $('.count').empty().append(data.count);
                $('.test').append(data.name);
                $('.test').append(data.prix);
                // console.log(data.panier2);
                console.log(data.prod);
                // $.each(panier2, function(i){

                //     i++
                // });
            }
        },'json')
        return false
    });
});