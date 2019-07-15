<?php
$page = 'restauration';
require_once 'Ressources/php/inc/header.php';
require_once 'Ressources/php/inc/db.php';
require_once 'Ressources/php/panier/_headerPanier.php'; //

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
var_dump($ids); ?>
<div class="container">
    <div class="row">
        <form action="panier.php" method="post">
            <!-- Puis on affiche l'etat actuel du panier avec les id récuperés dans $SESSION['panier'] couplés aux infos de la bdd -->
            <?php foreach ($products as $product) : ?>
                <div class="col-md-4 cardProd">
                    <div class="card shadow bgr">
                        <div class="carditem">
                            <div class="text-center">
                                <img class="card img-top img-fluid imgsize" src="Ressources/img/<?= $product->image ?>" alt="">
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="quantity">Nombre d'articles:<input type="text" name="panier[quantity][<?= $product->id; ?>]" value="<?= $_SESSION['panier'][$product->id]; ?>"> </span>
                            <p><?= $product->name; ?> </p>
                            <p><?= number_format($product->prix, 2, '.', '') ?> € </p>
                            <p>
                                <!-- Se bouton renvoie un $GET['del'] à la page elle même qui sera traité en haut -->
                                <a href="panier.php?del=<?= $product->id ?>"> Supprimer </a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <p>Total: <?= number_format($panier->total(), 2, ',', ' ') ?></p>
            <input type="submit" value="recalculer">
        </form>
    </div>
</div>
<?php
require_once 'Ressources/php/inc/footer.php';
?>