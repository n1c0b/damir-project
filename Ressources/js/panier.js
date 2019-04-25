$(document).ready(function () {
    $('.addPanier').click(function (e) {
        e.preventDefault();
        $.get($(this).attr('href'), {}, function (data) {
            if (data.error) {
                console.log(data.message);
            } else {
                $('.total').empty().append(data.total);
                $('.count').empty().append(data.count);
                $('.book').removeClass('disabled');
                $('.bookM').removeClass('disabled');
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
                //Il n'y a plus qu'à afficher le panier :)
                $('.panierResult').empty()
                prod.forEach(item => {
                    $('.panierResult').append(`
                        <div class="divider"></div>
                        <div id="${item.id}">
                            <!-- NOM -->
                            <span class="productName">${item.name}</span>
                            <br>
                            <!-- PRIX -->
                            <span class="price">${item.prix} €</span>
                            <!-- NOMBRE DE PRODUITS -->
                            <span class="quantity"> X ${item.countItem}</span>
                            <br>
                            <a title="Supprimer l'article" class="btn btn-danger rounded-circle"  href="delpanier.php?del=${item.id}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    `);
                });
            }
        }, 'json')
        return false
    });


    var jourSemaineArray = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
    var jourSemaine = new Date().getDay();
    var jour = jourSemaineArray[jourSemaine-1];
    
    $('.onglet').click(function(){
        var id = $(this).attr('id');
        if(id != jour + 'Tab'){
            $('.addPanier').hide();
        } else {
            $('.addPanier').show();
        }
    });

});
