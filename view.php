<?php
$page ='admin';
require_once 'Ressources/php/inc/header.php';
require_once 'Ressources/php//inc/db.php';
require_once 'Ressources/php//inc/functions.php';

if(!empty($_GET['id'])){
    $id = verifyInput($_GET['id']);
}

if(!empty($_POST)){
    
    if (!empty($_POST['id'])){
        $idd = verifyInput($_POST['id']);
    }
    
    $pdo = Database::connect();
    $req = $pdo->prepare("UPDATE items SET lundi = ?, mardi = ?, mercredi = ?,  jeudi = ?, vendredi = ? WHERE id = ?");
    $req->execute(array(null,null,null,null,null,$idd));

    if (!empty($_POST['jour'])){
        foreach($_POST['jour'] as $valeur){
                $req = $pdo->prepare("UPDATE items SET $valeur = ? WHERE id = ?");
                $req->execute(array(1,$idd));    
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
$_SESSION['flash']['success'] = "Les jours de disponibilité ont bien été modifiés. <i class='fas fa-check'></i>";
?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION TITREVIEW |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="titreView">
    <h1 class="titreAdmin">Voir un article</h1>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION FORMVIEW |||||||||||||||||||||||||||||||||||||||||||||| -->
</section id="formView">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ctrg"><br>
        
            <form action='view.php?id=<?= $id ?>' id="bott"   class="bgr" method="post">
            
            <h3 class="jds">Jours de disponibilité</h3>
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
                <input type="checkbox" class="form-check-input" name="jour[]" <?php if ($item->mercredi == 1) { echo 'checked'; } ?>  value="mercredi"  id="mercredi">
                <label class="form-check-label gras" for="mercredi">Mercredi</label>
                </div>
                <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="jour[]" <?php if ($item->jeudi == 1) { echo 'checked'; } ?>  value="jeudi" id="jeudi">
                <label class="form-check-label gras" for="jeudi">Jeudi</label>
                </div>
                <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="jour[]" <?php if ($item->vendredi == 1) { echo 'checked'; } ?>  value="vendredi"  id="vendredi">
                <label class="form-check-label gras" for="vendredi">Vendredi</label>
                </div>
                <button type="submit" class="btn btn-success btn-lg wr" id="marg"><i class="fas fa-check"></i> Valider</a>
            </form>

            </div>
            <div class="col-md-6">
                <div class="card bgr">
                    <div class='carditem'>
                        <div class="text-center"><img class="card-img-top imgsize" src="<?php echo 'Ressources/img/' . $item->image  ; ?>" alt="..."></div><br>
                    </div>
                    <br>
                    <div class="card-body">
                        <h5 id='prix'><?php echo  number_format((float)$item->prix,2,'.','') . ' €'; ?></h5>
                        <h4><?php echo  $item->name; ?></h4>
                        <p><?php echo  $item->description; ?></p>
                        <a href="admin.php" class="btn btn-primary btn-lg wr"><i class="fas fa-arrow-left"></i> Retour</a>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>
<br>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php'; ?>