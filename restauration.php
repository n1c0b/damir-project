<?php
    $page = 'restauration';
    require_once 'Ressources/php/inc/db.php';
    require_once 'Ressources/php/inc/functions.php';
    require_once 'Ressources/php/inc/header.php';
    require_once 'Ressources/php/panier/_headerPanier.php';
    
    
    if (!empty($_POST['id'])){
        $id = verifyInput($_POST['id']);
    }
     
    $jours = array ("lundi","mardi","mercredi","jeudi","vendredi");
    
    function afficher($jour){
        $pdo = Database::connect();
        $reeq = $pdo->query('SELECT * FROM categories');
        while($categorie = $reeq->fetch()){    
            echo   '<fieldset><legend>' . $categorie->name . ' :</legend>'; 
            echo   '<div class="row">';
            $req = $pdo->prepare('SELECT items.id, items.name, items.description, items.prix, items.image, items.lundi, items.mardi, items.mercredi,
            items.jeudi, items.vendredi, categories.name AS categorie
            FROM items LEFT JOIN categories ON items.categorie = categories.id 
            WHERE categories.name = ?');
            $req->execute(array($categorie->name));
            while($produit = $req->fetch()){
                if ($produit->$jour == 1){
                    echo '<div class="col-md-3 cardProd">
                            <div class="shadow card bgr">
                                <div class="carditem">
                                    <div class="text-center"><img class="card-img-top img-fluid imgsize" src="Ressources/img/' . $produit->image . '" alt="..."></div>
                                </div>
                                <div class="prix">' . number_format($produit->prix, 2, '.', '') .  '€</div>
                                <div class="card-body">
                                    <h4>' . $produit->name . '</h4>
                                    <p>' . $produit->description . '</p>
                                    <a href="Ressources/php/panier/addPanier.php?id=' . $produit->id .'" type="submit" class="btn btn-lg addPanier"><i class="fas fa-shopping-cart"></i> Ajouter</a>
                                </div> 
                            </div>
                          </div>'; 
                    }
                }
            echo '</div>
                  </fieldset>';

            }
        }
  
Database::disconnect();
?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| NAVBAR ONGLETS |||||||||||||||||||||||||||||||||||||||||||||| -->

<nav>
    <div class="nav nav-tabs w-100 nav-fill" id="nav-tab" role="tablist">
        <a class="nav-item nav-link onglet <?php if(date('l') =='Monday'){echo 'active';}?>" data-toggle="tab" id="lundiTab" href="#lundi" role="tab">LUNDI</a>
        <a class="nav-item nav-link onglet <?php if(date('l') =='Tuesday'){echo 'active';}?>" data-toggle="tab" id="mardiTab" href="#mardi" role="tab">MARDI</a>
        <a class="nav-item nav-link onglet<?php if(date('l') =='Wednesday'){echo 'active';}?>" data-toggle="tab" id="mercrediTab" href="#mercredi" role="tab">MERCREDI</a>
        <a class="nav-item nav-link onglet <?php if(date('l') =='Thursday'){echo 'active';}?>" data-toggle="tab" id="jeudiTab" href="#jeudi" role="tab">JEUDI</a>
        <a class="nav-item nav-link onglet <?php if(date('l') =='Friday'){echo 'active';}?>"data-toggle="tab" id="vendrediTab" href="#vendredi" role="tab">VENDREDI</a>
    </div>
</nav>

<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION PRODUITSPANIER |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="produitsPanier">
    <div class="container-fluid">
        <div class="row">
            <div id="produits" class="col-lg-9 col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane <?php if(date('l') =='Monday'){echo 'show active';}?>" id="lundi" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php
                            $lundi = $jours[0];
                            afficher($lundi);  
                        ?>
                    </div>
                    
                    <div class="tab-pane fade <?php if(date('l') =='Tuesday'){echo 'show active';}?>" id="mardi" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php  
                            $mardi = $jours[1];
                            afficher($mardi);
                        ?>
                    </div>         
                    <div class="tab-pane fade <?php if(date('l') =='Wednesday'){echo 'show active';}?>" id="mercredi" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php  
                            $mercredi = $jours[2];
                            afficher($mercredi);
                        ?>
                    </div>         
                    <div class="tab-pane <?php if(date('l') =='Thursday'){echo 'show active';}?> fade" id="jeudi" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php  
                            $jeudi = $jours[3];
                            afficher($jeudi);
                        ?>
                    </div>  
                    <div class="tab-pane fade <?php if(date('l') =='Friday'){echo 'show active';}?>" id="vendredi" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php  
                            $vendredi = $jours[4];
                            afficher($vendredi);
                        ?>
                    </div>         
                </div>
            </div>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| DIV PANIER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/viewPanier.php'; ?>

<!-- |||||||||||||||||||||||||||||||||||||||||||||| DIV PANIER MOBILE |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/viewPanierMobile.php'; ?>
    
</section>
<br>
<br>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php'; ?>