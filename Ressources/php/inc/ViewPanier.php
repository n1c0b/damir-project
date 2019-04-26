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
    //Si on reçoit un $GET['del] en cliquant sur le lien supprimer, alors on suprime 
    if (isset($_GET['del'])) {
        $panier->del($_GET['del']);
        }
?>


<div id="panier" class="col-lg-3 col-md-0">
    <div class="text-center prod listProd">
        <!-- Div a afficher en php -->
        <div class="container">            
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
        <div class="row">
            <div class="col-md-9">
                <p class="countItem">Nombre d'articles :</p> 
            </div>
            <div class="col-md-3 text-right">
                <span class="count"><?= $panier->count(); ?></span>             
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <h3>Total :</h3>
                <br>
            </div>
            <div class="col-md text-right">
                <span class="total"><?= number_format($panier->total(), 2, ',', ' ') ?></span>              
            </div>
        </div>
        <br>
        <br>
        <a href="panier.php" type="submit" class="btn btn-lg book <?php if(empty($_SESSION['panier'])){ echo 'disabled';} ?>">R&eacute;server</a>
    </div>
</div>

