<?php
    require_once '../inc/db.php';
    require_once '../inc/function.php';

    if(!empty($_GET['id']))
    {
        $id = verifyInput($_GET['id']);
    }

    if(!empty($_POST))
    {
        $id = verifyInput($_POST['id']);
        $pdo = Database::connect();
        $req = $pdo->prepare("DELETE FROM items WHERE id= ?");
        $req->execute(array($id));
        
        Database::disconnect();

   
        header("Location: admin.php");
    }
 

require_once '../inc/entete.php';

?>


<h1 id="voirItem">Supprimer un item</h1>
<div class="container">
    
       
        <form class="form bgr" role="form" action="delete.php" method="post">

                <input type="hidden" name="id" value="<?php echo $id; ?>" >
                <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>    
               
                <button type="submit" class="btn btn-warning wrg">Oui</button>
                <a href="admin.php" class="btn btn-success wrg" role="button">Non</a>
            </form>


    
    
</div>

<?php
 require_once '../inc/footer.php'
?>
