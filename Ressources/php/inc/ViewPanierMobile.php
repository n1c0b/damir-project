<div id="panierMobile" class="shadow">
        <div class="row">
            <div class="col-8 listProdM">
                <!-- Div a afficher en php -->
                <div class="text-center prodprix">
                <div class="divider"></div>
                    <span class="nomProduit">Votre panier est vide</span>
                    <?php
                    //Si on reçoit un $GET['del] en cliquant sur le lien supprimer, alors on suprime 
                    if (isset($_GET['del'])) {
                        $panier->del($_GET['del']);
                    }

                    //Retourne toutes les clés contenues dans $SESSION['panier'] sous forme de array
                    $ids = array_keys($_SESSION['panier']);
                    //Si $SESSION['panier'] est vide
                    if (empty($ids)) {
                        //Alors on vide $products
                        $products = array();
                    }
                    // sinon on demande à la bdd les id contenues dans $SESSION['panier']
                    else {
                        Database::connect();
                        $products = Database::query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
                        Database::disconnect();
                    }
                ?>
                </div>
                <?php foreach ($products as $product) : ?>
                        <div class="row" style='border: 1px solid black;'>
                            <div>
                                <!-- NOM -->
                                <p><?= $product->name; ?>
                                    <!-- PRIX -->
                                    <span style="background-color: black; color: white;">
                                        <?= number_format($product->prix, 2, '.', '') ?> € </span>
                                    <!-- NOMBRE DE PRODUITS -->
                                    <span> X <?= $_SESSION['panier'][$product->id]; ?></span>
                                </p>
                                <p>
                                    <!-- Se bouton renvoie un $GET['del'] à la page elle même qui sera traité en haut -->
                                    <a href="restauration.php?del=<?= $product->id ?>"> supprimer </a>
                                </p>
                            </div>
                        </div>
                    <?php endforeach ?>
                <!-- Fin de la div a afficher en php -->
            </div>
            <div class="col-4">
                <div class="text-right prodprix">
                    <h3>Total : <span class="total"><?= number_format($panier->total(), 2, ',', ' ') ?></span></h3>
                    <h3>Nombre d'articles:</h3> <span class="count"><?= $panier->count(); ?></span>
                </div>
            </div>
        </div>
        <a href="panier.php" class="btn btn-lg bookM">R&eacute;server</a>
    </div>