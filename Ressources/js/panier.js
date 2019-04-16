$(document).ready(function () {
    $('.addPanier').click(function(e){
        e.preventDefault();
        $.get($(this).attr('href'),{},function(data){
            console.log('ok');
            if (data.error) {
                alert(data.message);
            }
            else
            {
                $('.total').empty().append(data.total);
                $('.count').empty().append(data.count);
                $('.test').append(data.name);
                console.log('cc');
            }
        },'json')
        return false
    });
});