<?php
    $page = 'admin';
    require_once 'Ressources/php/inc/db.php';
    require_once 'Ressources/php/inc/functions.php';
    $nameError =  $descriptionError = $prixError = $categorieError = $imageError = $name = $description = $prix = $categoie = $image = "";

    if(!empty($_POST)){
        $name           = verifyInput($_POST['name']);
        $description    = verifyInput($_POST['description']);
        $prix           = verifyInput($_POST['prix']);
        $categorie      = verifyInput($_POST['categorie']);
        $image          = verifyInput($_FILES['image']['name']);
        $imagePath      = '../images/' . basename($image);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess      = true;
        $isUploadSuccess = false;
   
    if(empty($name)){
        $nameError = 'Ce champs ne peut pas être vide.';
        $isSuccess = false;
    }
    if(empty($description)){
        $descriptionError = 'Ce champs ne peut pas être vide.';
        $isSuccess = false;
    }
    if(empty($prix)){
        $prixError = 'Ce champs ne peut pas être vide.';
        $isSuccess = false;
    }
    if(empty($categorie)){
        $categorieError = 'Ce champs ne peut pas être vide.';
        $isSuccess = false;
    }
    
    if(empty($image)){
        $imageError = 'Ce champs ne peut pas être vide.';
        $isSuccess = false;
    } else {
        $isUploadSuccess = true;
        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif"){
            $imageError = "Les formats d'images autorisés sont : .jpeg, .jpg, .png, .gif";
            $isUploadSuccess = false;
        }
        if(file_exists($imagePath)){
            $imageError = "L'image existe deja";
            $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 600000){
            $imageError = "La taille de l'image ne doit pas depasser les 500KB";
            $isUploadSuccess = false;
        }
        if($isUploadSuccess){
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)){
                $imageError = "Erreur lors de le l'importation de l'image.";
                $isUploadSuccess= false;
            }
        }   
    }

    if($isSuccess && $isUploadSuccess){
        $pdo = Database::connect();
        $req = $pdo->prepare("INSERT INTO items (name,description,prix,categorie,image) VALUES(?, ?, ?, ?, ?)");
        $req->execute(array($name,$description,$prix,$categorie,$image));
        Database::disconnect();
        header("Location: admin.php");
    }
    
}
require_once 'Ressources/php/inc/header.php';
?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION TITREINSERT |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="titreInsert">
    <h1 class="titreAdmin">Ajouter un item</h1>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION FORMINSERT |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="formInsert">
    <div class="container">
        <br>
        <form class="form bgr" role="form" action="insert.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <b><label for="name">Nom : </label></b>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name ?>">
                <span class='msgErr'><?php echo $nameError; ?></span>
            </div>
            <div class="form-group">
                <b><label for="description">Description : </label></b>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description ?>">
                <span class='msgErr'><?php echo $descriptionError; ?></span>
            </div>
            <div class="form-group">
                <b><label for="prix">Prix : </label></b>
                <input type="number" step="0.10" class="form-control" id="prix" name="prix" placeholder="Prix" value="<?php echo $prix; ?>">
                <span class='msgErr'><?php echo $prixError; ?></span>
            </div>
            <div class="form-group">
                <b><label for="categorie">Catégorie : </label></b>
                <select class="form-control" name="categorie" id="categorie">
                    <?php 
                    $pdo = Database::connect();
                    foreach($pdo->query('SELECT * FROM categories') as $row){
                            echo '<option value="' . $row->id .  '">' . $row->name . '</option>';
                        }
                        Database::disconnect();   
                    ?>

                </select>
                <span class='msgErr'><?php echo $categorieError; ?></span>
            </div>
            <div class="form-group">
                <strong><label for='image'>Selectionner une Image: </label></strong>
                <input type="file" id="image" name="image">
                <br>
                <span class='msgErr'><?php echo $imageError; ?></span><br><br>
            </div>
                    
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Ajouter</button>
            <a href="admin.php" class="btn btn-primary" role="button"><i class="fas fa-arrow-left"></i> Retour</a>
        </form>
    </div>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php'; ?>