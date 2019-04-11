<?php
$page= 'admin';
require_once 'Ressources/php/inc/db.php';
require_once 'Ressources/php/inc/functions.php';

if(!empty($_GET['id'])){
    $id = verifyInput($_GET['id']);
}

if(!empty($_POST)){
    $id = verifyInput($_POST['id']);
    $pdo = Database::connect();
    $req = $pdo->prepare("DELETE FROM items WHERE id= ?");
    $req->execute(array($id));
    Database::disconnect();
    header("Location: admin.php");
}
 
require_once 'Ressources/php/inc/header.php';
?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION TITREDELETE |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="titreDelete">
    <h1 class="titreAdmin">Supprimer un article</h1>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION SECDELETE |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="secDelete">
    <div class="container">
        <form class="form bgr text-center" role="form" action="delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" >
            <p class="alert alert-warning">&Ecirc;tes-vous s&ucirc;r de vouloir supprimer cet article ?</p>    
            <button type="submit" class="btn btn-success btn-lg wrg"><i class="fas fa-trash-alt"></i> Oui</button>
            <a href="admin.php" class="btn btn-danger btn-lg wrg" role="button"><i class="fas fa-ban"></i> Non</a>
        </form>
    </div>
</section>
<br>
<br>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php' ?>
