$(document).ready(function () {
    $('.addPanier').click(function (e) {
        e.preventDefault();
        $.get($(this).attr('href'), {}, function (data) {
            if (data.error) {
                console.log(data.message);
            }
            else {
                $('.total').empty().append(data.total);
                $('.count').empty().append(data.count);

                var prod = data.prod;
                var panierIdNombre = data.panierIdNombre;

                //On imbrique 2 boucles afin de lier prod et panierIdNombre !!!!!!!
                prod.forEach(element => {
                    $.each(panierIdNombre, function (key, valued) {
                        if (key == element.id) {
                            Object.defineProperty(element, 'countItem', {
                                value: valued,
                                writable: false
                            });
                        }
                    });
                });
                console.log(prod);
                //Il n'y a plus qu'à afficher le panier :)
                $('.panierResult').empty()
                prod.forEach(item => {
                    $('.panierResult').append(`
                    <div id="${item.id}">
                            <p>${item.name}
                                <!-- PRIX -->
                                <span style="background-color: black; color: white;">
                                    ${item.prix} € </span>
                                <!-- NOMBRE DE PRODUITS -->
                                <span> X ${item.countItem}</span>
                            </p>
                            <p>
                                <a class="del" type="submit"  href="delpanier.php?del=${item.id}"> supprimer </a>
                            </p>
                    </div>
                    `);
                });
            }
        }, 'json')
        return false
    });

});