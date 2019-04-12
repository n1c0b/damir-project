<?php
$page = 'restauration';
require_once 'Ressources/php/inc/db.php';
require_once 'Ressources/php/inc/functions.php';
require_once 'Ressources/php/inc/header.php';
require_once 'Ressources/php/panier/_headerPanier.php';

if (!empty($_POST['id'])) {
    $id = verifyInput($_POST['id']);
}

$jours = array("lundi", "mardi", "mercredi", "jeudi", "vendredi");


// Fonction qui recupere les produits validés par l'admin et les afiche par jour.
function afficher($jour)
{
    $pdo = Database::connect();
    $reeq = $pdo->query('SELECT * FROM categories');
    while ($categorie = $reeq->fetch()) {
        echo   '<div class="red-divider"></div>';
        echo   '<div class="voir"><h1>' . $categorie->name . '</h1></div>';
        echo   '<div class="row">';
        $req = $pdo->prepare('SELECT items.id, items.name, items.description, items.prix, items.image, items.lundi, items.mardi, items.mercredi,
                   items.jeudi, items.vendredi, categories.name AS categorie
                   FROM items LEFT JOIN categories ON items.categorie = categories.id 
                   WHERE categories.name = ?');

        $req->execute(array($categorie->name));

        while ($produit = $req->fetch()) {

            if ($produit->$jour == 1) {
                echo
                    '
                                <div class="col-md-4">
                                <div class="card bgr">
                                    <div class="carditem">
                                    <div class="text-center"><img class="card-img-top imgsize" src="Ressources/img/' . $produit->image . '" alt="..."></div>
                                    </div>
                                    <div class="prix">' . number_format($produit->prix, 2, '.', '') .  '€</div>
                                    <div class="card-body">
                                        <h4>' . $produit->name . '</h4>
                                        <p>' . $produit->description . '</p>
                                        <a href="Ressources/php/panier/addPanier.php?id=' . $produit->id . '" type="submit" class="btn btn-warning btn-lg wr addPanier"><i class="fas fa-shopping-cart"></i> Ajouter</a>
                                    </div>     
                                </div>
                                </div>';
            }
        }

        echo '</div>';
    }
}
Database::disconnect();
?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#lundi" role="tab" aria-controls="nav-home" aria-selected="true">LUNDI</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#mardi" role="tab" aria-controls="nav-profile" aria-selected="false">MARDI</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#mercredi" role="tab" aria-controls="nav-contact" aria-selected="false">MERCREDI</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#jeudi" role="tab" aria-controls="nav-contact" aria-selected="false">JEUDI</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#vendredi" role="tab" aria-controls="nav-contact" aria-selected="false">VENDREDI</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active " id="lundi" role="tabpanel" aria-labelledby="nav-profile-tab">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">

                    <?php

                    $lundi = $jours[0];

                    afficher($lundi);

                    ?>
                </div>

                <!-- 
______  ___  _   _ _____ ___________ 
| ___ \/ _ \| \ | |_   _|  ___| ___ \
| |_/ / /_\ |  \| | | | | |__ | |_/ /
|  __/|  _  | . ` | | | |  __||    / 
| |   | | | | |\  |_| |_| |___| |\ \ 
\_|   \_| |_\_| \_/\___/\____/\_| \_|
                 -->
                <div class="col-md-3">

                    <div class="fixed-div" style="overflow-y: scroll; height: 800px;">
                        <div>

                            <h3>Panier</h3>
                            <ul>
                                <li><a href="panier.php">Voir le panier</a></li>
                                <li>Nombre d'articles: <span id="count"><?= $panier->count(); ?></span></li>
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
                                <div class="container">

                                    <!-- Puis on affiche l'etat actuel du panier avec les id récuperés dans $SESSION['panier'] couplés aux infos de la bdd -->
                                    <?php foreach ($products as $product) : ?>
                                        <div class="row" style='border: 1px solid black;'>
                                            <div>
                                                <!-- NOM -->
                                                <p><?= $product->name; ?>
                                                <!-- PRIX -->
                                                <span style="background-color: black; color: white;"> <?= number_format($product->prix, 2, '.', '') ?> € </span>
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

                                    <div class="row">
                                        <!-- TOTAL DU PANIER -->
                                        <p>Total panier: <span id="total"><?= number_format($panier->total(), 2, ',', ' ') ?></span></p>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- 
 _____ _   _______  ______  ___  _   _ _____ ___________ 
|  ___| \ | |  _  \ | ___ \/ _ \| \ | |_   _|  ___| ___ \
| |__ |  \| | | | | | |_/ / /_\ |  \| | | | | |__ | |_/ /
|  __|| . ` | | | | |  __/|  _  | . ` | | | |  __||    / 
| |___| |\  | |/ /  | |   | | | | |\  |_| |_| |___| |\ \ 
\____/\_| \_|___/   \_|   \_| |_\_| \_/\___/\____/\_| \_|
                 -->
            </div>
        </div>


    </div>
    <div class="tab-pane fade" id="mardi" role="tabpanel" aria-labelledby="nav-profile-tab">


        <?php

        $mardi = $jours[1];
        afficher($mardi);
        ?>


    </div>
    <div class="tab-pane fade" id="mercredi" role="tabpanel" aria-labelledby="nav-profile-tab">


        <?php

        $mercredi = $jours[2];
        afficher($mercredi);
        ?>


    </div>
    <div class="tab-pane fade" id="jeudi" role="tabpanel" aria-labelledby="nav-profile-tab">


        <?php

        $jeudi = $jours[3];
        afficher($jeudi);
        ?>


    </div>
    <div class="tab-pane fade" id="vendredi" role="tabpanel" aria-labelledby="nav-profile-tab">


        <?php

        $vendredi = $jours[4];
        afficher($vendredi);
        ?>


    </div>
</div>

<?php require_once 'Ressources/php/inc/footer.php' ?>