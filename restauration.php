<?php
    $page = 'restauration';
    require_once 'Ressources/php/inc/db.php';
    require_once 'Ressources/php/inc/functions.php';
    require_once 'Ressources/php/inc/header.php';
    
    
    if (!empty($_POST['id'])) {
        $id = verifyInput($_POST['id']);
    }
     
    $jours = array ("lundi","mardi","mercredi","jeudi","vendredi");
    

    
    function afficher($jour)
    {
        $pdo = Database::connect();
        $reeq = $pdo->query('SELECT * FROM categories');
        while($categorie = $reeq->fetch())
        {
                echo   '<div class="red-divider"></div>';    
                echo   '<div class="voir"><h1>' . $categorie->name . '</h1></div>'; 
                echo   '<div class="row">';
                   $req = $pdo->prepare('SELECT items.name, items.description, items.prix, items.image, items.lundi, items.mardi, items.mercredi,
                   items.jeudi, items.vendredi, categories.name AS categorie
                   FROM items LEFT JOIN categories ON items.categorie = categories.id 
                   WHERE categories.name = ?');
                   $req->execute(array($categorie->name));
                       
                       while($produit = $req->fetch())
                            {
                               
                               if ($produit->$jour == 1) 
                               {
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
                                        <button type="submit" class="btn btn-warning btn-lg wr"><i class="fas fa-shopping-cart"></i>Ajouter</button>
                                    </div>     
                                </div>
                                </div>';
                               
                               }
                               
                               
                            } 
    
                      echo '</div>';      
            }
        
    }

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

<?php require_once 'Ressources/php/inc/footer.php' ?>