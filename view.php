<?php
$page ='admin';
require_once 'Ressources/php/inc/header.php';
require_once 'Ressources/php//inc/db.php';
require_once 'Ressources/php//inc/functions.php';

if(!empty($_GET['id']))
{
    $id = verifyInput($_GET['id']);
}

if(!empty($_POST))
{
    
    $pdo = Database::connect();
    $req = $pdo->prepare("UPDATE items SET lundi = ?, mardi = ?, mercredi = ?,  jeudi = ?, vendredi = ? WHERE id = ?");
    $req->execute(array(null,null,null,null,null,$id));

    if (!empty($_POST['jour']))
    {
        foreach($_POST['jour'] as $valeur) {

                $req = $pdo->prepare("UPDATE items SET $valeur = ? WHERE id = ?");
                $req->execute(array(1,$id));    
        }
    }   
    Database::disconnect();
   
}

$pdo = Database::connect();
$req = $pdo->prepare('SELECT items.id, items.name, items.description, items.prix, items.image,items.lundi,items.mardi,items.mercredi,items.jeudi,
                     items.vendredi, categories.name AS categorie
                     FROM items LEFT JOIN categories ON items.categorie = categories.id 
                     WHERE items.id = ?');

$req->execute(array($id));
$item = $req->fetch();   

Database::disconnect();
?>

<h1 id="voirItem">Voir un item</h1>

<div class="container">
    <div class="row">
        <div class="col-md-8 ctrg"><br>
       
        <form action='view.php?id=<?= $id ?>' id="bott"   class="bgr" method="post">
        
        <h3 class="jds">Jours de la semaine </h3>
            <input type="hidden" name="id" value="<?php echo $id; ?>" >
            <div class="form-group form-check">
            <input type="checkbox" class="form-check-input"  name="jour[]" <?php if ($item->lundi == 1) { echo 'checked'; } ?>  value="lundi" id="lundi">
            <label class="form-check-label gras" for="lundi">Lundi</label>
            </div>
            <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="jour[]" <?php if ($item->mardi == 1) { echo 'checked'; } ?>  value="mardi" id="mardi">
            <label class="form-check-label gras" for="mardi">Mardi</label>
            </div>
            <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="jour[]" <?php if ($item->mercredi == 1) { echo 'checked'; } ?>  value="mercredi" id="mercredi">
            <label class="form-check-label gras" for="mercredi">Mercredi</label>
            </div>
            <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="jour[]" <?php if ($item->jeudi == 1) { echo 'checked'; } ?>  value="jeudi" id="jeudi">
            <label class="form-check-label gras" for="jeudi">Jeudi</label>
            </div>
            <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="jour[]" <?php if ($item->vendredi == 1) { echo 'checked'; } ?>  value="vendredi" id="vendredi">
            <label class="form-check-label gras" for="vendredi">Vendredi</label>
            </div>
            <button type="submit" class="btn btn-warning btn-lg wr" id="marg"><i class="fas fa-shopping-cart"></i>Ajouter</a>
           
        </form>
        </div>
        <div class="col-md-4 cardProd mt-4">
            <div class="shadow card bgr">
                <div class="carditem">
                    <div class="text-center"><img class="card-img-top img-fluid imgsize" src="Ressources/img/<?= $item->image ?>" alt="..."></div>
                </div>
                        <div class="prix"><?= number_format($item->prix, 2, '.', '') ?> €</div>
                        <div class="card-body">
                            <h4> <?= $item->name ?></h4>
                            <p><?= $item->description ?></p>
                            <a href="admin.php" class="btn btn-primary btn-lg wr mt-1" id="marg"><i class="fas fa-arrow-left"></i>Retour</a>
                        </div> 
            </div>
        </div>                       
<?php
require_once 'Ressources/php/inc/footer.php';
?>