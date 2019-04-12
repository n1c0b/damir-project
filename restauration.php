<?php
    $page = 'restauration';
    require_once 'Ressources/php/inc/db.php';
    require_once 'Ressources/php/inc/functions.php';
    require_once 'Ressources/php/inc/header.php';
    
    
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
            $req = $pdo->prepare('SELECT items.name, items.description, items.prix, items.image, items.lundi, items.mardi, items.mercredi,
            items.jeudi, items.vendredi, categories.name AS categorie
            FROM items LEFT JOIN categories ON items.categorie = categories.id 
            WHERE categories.name = ?');
            $req->execute(array($categorie->name));
            while($produit = $req->fetch()){
                if ($produit->$jour == 1){
                    echo '<div class="col-md-4 prod">
                            <div class="shadow card bgr">
                                <div class="carditem">
                                    <div class="text-center"><img class="card-img-top img-fluid imgsize" src="Ressources/img/' . $produit->image . '" alt="..."></div>
                                </div>
                                <div class="prix">' . number_format($produit->prix, 2, '.', '') .  '€</div>
                                <div class="card-body">
                                    <h4>' . $produit->name . '</h4>
                                    <p>' . $produit->description . '</p>
                                    <button type="submit" class="btn btn-lg"><i class="fas fa-shopping-cart"></i> Ajouter</button>
                                </div> 
                            </div>
                          </div>'; 
                    }
                }
            echo '</div>
                  </fieldset>';

        }
    }
?>
<!-- |||||||||||||||||||||||||||||||||||||||||||||| NAVBAR ONGLETS |||||||||||||||||||||||||||||||||||||||||||||| -->
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#lundi" role="tab" aria-controls="nav-home" aria-selected="true">LUNDI</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#mardi" role="tab" aria-controls="nav-profile" aria-selected="false">MARDI</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#mercredi" role="tab" aria-controls="nav-contact" aria-selected="false">MERCREDI</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#jeudi" role="tab" aria-controls="nav-contact" aria-selected="false">JEUDI</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#vendredi" role="tab" aria-controls="nav-contact" aria-selected="false">VENDREDI</a>
    </div>
</nav>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION PRODUITSPANIER |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="produitsPanier">
    <div class="container-fluid">
        <div class="row">
            <div id="produits" class="col-lg-9">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active " id="lundi" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php  
                            $lundi = $jours[0];
                            afficher($lundi);
                        ?>                 
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
            </div>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| DIV PANIER |||||||||||||||||||||||||||||||||||||||||||||| -->
            <div id="panier" class="col-lg-3 shadow">
                <div class="text-center prod listProd">
                <!-- Div a afficher en php -->
                    <div class="divider"></div>
                    <span class="nomProduit">Votre panier est vide</span>
                <!-- Fin de la div a afficher en php -->                
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-md">
                        <h3>Total :</h3>
                        <br>
                    </div>
                    <div class="col-md text-right">
                        <span id="prixTotal" class="prix">0.00€</span>
                    </div>
                </div>
                <button class="btn btn-lg book">R&eacute;server</button>
            </div>
        </div>
    </div>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| DIV PANIER MOBILE |||||||||||||||||||||||||||||||||||||||||||||| -->
    <div id="panierMobile" class="shadow">
        <div class="row">
            <div class="col-8 listProdM">
                <!-- Div a afficher en php -->
                <div class="text-center prodprix">
                <div class="divider"></div>
                    <span class="nomProduit">Votre panier est vide</span>
                </div>
                <!-- Fin de la div a afficher en php -->
            </div>
            <div class="col-4">
                <div class="text-right prodprix">
                    <h3>Total : <span id="prixTotal" class="prix">0.00€</span></h3>
                </div>
            </div>
        </div>
        <button class="btn btn-lg bookM">R&eacute;server</button>
    </div>
</section>
<br>
<br>
<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php' ?>