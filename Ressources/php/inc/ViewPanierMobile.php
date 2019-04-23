<?php
    //Retourne toutes les clés contenues dans $SESSION['panier'] sous forme de array
    $ids = array_keys($_SESSION['panier']);
    //Si $SESSION['panier'] est vide
    if (empty($ids)){
        //Alors on vide $products
        $products = array();
            // sinon on demande à la bdd les id contenues dans $SESSION['panier']
    } else {
        Database::connect();
        $products = Database::query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
        Database::disconnect();
    }
?>


<div id="panierMobile">
    <div class="row">
        <div class="col-8 listProdM">
            <!-- Div a afficher en php -->
            <div class="text-center prodprix">
                <div class="panierResult">
                    <?php if(empty($_SESSION['panier'])): ?>
                        <div class="divider"></div>
                        <p class="panierEmpty">Votre panier est vide !</p>
                    <?php else: ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="divider"></div>
                            <!-- NOM -->
                            <span class="productName"><?= $product->name; ?></span>
                            <br>
                            <!-- PRIX -->
                            <span class="price"><?= number_format($product->prix, 2, '.', '') ?> €</span>
                            <!-- NOMBRE DE PRODUITS -->
                            <span class="quantity"> X <?= $_SESSION['panier'][$product->id]; ?></span>
                            <!-- Se bouton renvoie un $GET['del'] à la page elle même qui sera traité en haut -->
                            <br>
                            <a title="Supprimer l'article" class="btn btn-danger rounded-circle" href="restauration.php?del=<?= $product->id ?>">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
                <div class="divider"></div>
            </div>
        </div>
                <!-- Fin de la div a afficher en php -->
            <div class="col-4">
                <div class="text-right prodprix">
                    <h3>Total : <span class="total"><?= number_format($panier->total(), 2, ',', ' ') ?></span></h3>
                    <h3>Nombre d'articles:</h3> <span class="count"><?= $panier->count(); ?></span>
                </div>
            </div>
        </div>
        <a href="panier.php" class="btn btn-lg bookM">R&eacute;server</a>
    </div>