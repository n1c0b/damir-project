<?php
$page = 'panier';
require_once 'Ressources/php/inc/header.php';
require_once 'Ressources/php/inc/db.php';
require_once 'Ressources/php/panier/_headerPanier.php'; //

//Si on reçoit un $GET['del] en cliquant sur le lien supprimer, alors on suprime 
if(isset($_GET['del'])){
        $panier->del($_GET['del']);
    }

//Retourne toutes les clés contenues dans $SESSION['panier'] sous forme de array
$ids = array_keys($_SESSION['panier']);
//Si $SESSION['panier'] est vide
if(empty($ids)){
        //Alors on vide $products
        $products = array();
    }
// sinon on demande à la bdd les id contenues dans $SESSION['panier']
else {
        Database::connect();
        $products = Database::query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
        Database::disconnect();
    }
// var_dump($ids); ?>
<div class="text-center">
    <h1>R&eacute;capitulatif de votre commande</h1>
</div>
<div class="container">
        <form action="panier.php" method="post">
            <div class="row">
            <!-- Puis on affiche l'etat actuel du panier avec les id récuperés dans $SESSION['panier'] couplés aux infos de la bdd -->
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="Ressources/img/<?= $product->image ?>" alt="">
                            <div class="card-body">
                                <div class="card-title">
                                    <span class="quantity">Nombre d'articles:
                                        <input type="number" class="form-control" step="1" name="panier[quantity][<?= $product->id; ?>]" value="<?= $_SESSION['panier'][$product->id]; ?>">
                                    </span>
                                </div>
                                <div class="card-text">
                                    <span class="nomProd"> <?= $product->name; ?></span>
                                    <?= number_format($product->prix, 2, '.', '') ?> €
                                    <!-- Se bouton renvoie un $GET['del'] à la page elle même qui sera traité en haut -->
                                    <span class="suppr">
                                        <a class="btn btn-danger rounded-circle" href="panier.php?del=<?= $product->id ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            Total: <?= number_format($panier->total(), 2, ',', ' ') ?>
            <input type="submit" value="recalculer">
        </form>
        <form action="Ressources/php/panier/validBask.php" method="post">
            <button class="validCommand">Valider ma commande</button>
        </form>
</div>


<?php require_once 'Ressources/php/inc/footer.php'; ?>