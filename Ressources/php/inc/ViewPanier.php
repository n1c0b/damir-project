<div id="panier" class="col-lg-3 shadow">
    <div class="text-center prod listProd">
        <!-- Div a afficher en php -->
        <li>Nombre d'articles: <span class="count"><?= $panier->count(); ?></span></li>
        <div class="divider"></div>
        <?php
        //Si on reçoit un $GET['del] en cliquant sur le lien supprimer, alors on suprime 
        // if (isset($_GET['del'])) {
        //     $panier->del($_GET['del']);
        // }

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
        <div class="container">            
                <div class="row panierResult" style='border: 1px solid black;'>     
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
                </div>
        </div>
        <div class="divider"></div>
        <div class="row">
            <div class="col-md">
                <h3>Total :</h3>
                <br>
            </div>
            <div class="col-md text-right">
                <span class="total"><?= number_format($panier->total(), 2, ',', ' ') ?></span>
            </div>
        </div>
        <a href="panier.php" class="btn btn-lg book">R&eacute;server</a>
    </div>
</div>
</div>
