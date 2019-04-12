$(document).ready(function () {
    $('.addPanier').click(function(e){
        e.preventDefault();
        $.get($(this).attr('href'),{},function(data){
            if (data.error) {
                alert(data.message);
            }
            else
            {
                $('#total').empty().append(data.total);
                $('#count').empty().append(data.count);
            }
            console.log(data);
        },'json')
        return false
    });
});