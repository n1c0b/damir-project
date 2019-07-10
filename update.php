<?php
    $page ='admin';
    require_once 'Ressources/php/inc/db.php';
    require_once 'Ressources/php/inc/functions.php';

    if (!empty($_GET['id'])) {
        $id = verifyInput($_GET['id']);
    }

    $nameError =  $descriptionError = $prixError = $categorieError = $imageError = $name = $description = $prix = $categoie = $image = "";

    if(!empty($_POST))
    {
        $name           = verifyInput($_POST['name']);
        $description    = verifyInput($_POST['description']);
        $prix           = verifyInput($_POST['prix']);
        $categorie      = verifyInput($_POST['categorie']);
        $image          = verifyInput($_FILES['image']['name']);
        $imagePath      = '../images/' . basename($image);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess      = true;

    if(empty($name))
    {
        $nameError = 'Ce champ est obligatoire !!';
        $isSuccess = false;
    }
    if(empty($description))
    {
        $descriptionError = 'Ce champ est obligatoire !!';
        $isSuccess = false;
    }
    if(empty($prix))
    {
        $prixError = 'Ce champ est obligatoire !!';
        $isSuccess = false;
    }
    if(empty($categorie))
    {
        $categorieError = 'Ce champ est obligatoire !!';
        $isSuccess = false;
    }
    
    if(empty($image))
    {
        $isImageUpdated = false;
    }else 
    
    {
        $isImageUpdated = true;
        $isUploadSuccess = true;
        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
        {
            $imageError = 'les images autorises sont : .jpeg, .jpg, .png, .gif';
            $isUploadSuccess = false;
        }
        if(file_exists($imagePath))
        {
            $imageError = "l'image existe deja";
            $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 600000)
        {
            $imageError = "la taille de l'image ne doit pas depasser les 500KB";
            $isUploadSuccess = false;
        }
        if($isUploadSuccess)
        {
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
            {
                $imageError = "il y a une erreur lors de l'upload";
                $isUploadSuccess= false;
            }

        }   

    }

    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
        $pdo = Database::connect();
        if($isImageUpdated)
        {
            $req = $pdo->prepare("UPDATE items SET name = ?, description = ?, prix = ?, categorie = ?, image = ? WHERE id = ?");
            $req->execute(array($name,$description,$prix,$categorie,$image,$id));
        }
        else {
            $req = $pdo->prepare("UPDATE items SET name = ?, description = ?, prix = ?, categorie = ? WHERE id = ?");
            $req->execute(array($name,$description,$prix,$categorie,$id));
        }

        
        Database::disconnect();
        header("Location: admin.php");

    }if($isImageUpdated && !$isUploadSuccess)
    {
        $pdo = Database::connect();
        $req = $pdo->prepare("SELECT image FROM items WHERE id= ?");
        $req->execute(array($id));
        $item = $req->fetch();
 
        $image = $item['image'];
        Database::disconnect();    

    }
    


    } else {

        $pdo = Database::connect();
        $req = $pdo->prepare("SELECT * FROM items WHERE id= ?");
        $req->execute(array($id));
        $item = $req->fetch();

        $name = $item->name;    
        $description = $item->description;    
        $prix = $item->prix;    
        $categorie = $item->categorie;    
        $image = $item->image;    

        Database::disconnect();
    }

 require_once 'Ressources/php/inc/header.php';

?>

<h1 id="voirItem">Modifier un item</h1>
<div class="container">
    <div class="row">
        <div class="col-md shadow card bgr">
            <form class="form" action="<?php echo 'update.php?id=' . $id; ?> " method="post"
                enctype="multipart/form-data">
                <div class="form-group">
                    <strong><label for="name">Nom : </label></strong>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name ?>">
                    <span class='msgErr'><?php echo $nameError; ?></span>
                </div>
                <div class="form-group">
                    <strong><label for="description">Description : </label></strong>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description ?>">
                    <span class='msgErr'><?php echo $descriptionError; ?></span>
                </div>
                <div class="form-group">
                    <strong><label for="prix">Prix : </label></strong>
                    <input type="number" step="0.10" class="form-control" id="prix" name="prix" placeholder="Prix" value="<?php echo $prix; ?>">
                    <span class='msgErr'><?php echo $prixError; ?></span>
                </div>
                <div class="form-group">
                    <strong><label for="categorie">Catégorie : </label></strong>
                    <select class="form-control" name="categorie" id="categorie">
                        <?php 
                         $pdo = Database::connect();
                         foreach($pdo->query('SELECT * FROM categories') as $row)
                            {
                                if($row->id == $categorie)
                                {
                                    echo '<option selected="selected" value="' . $row->id .  '">' . $row->name . '</option>';
                                }else {
                                    echo '<option value="' . $row->id .  '">' . $row->name . '</option>';
                                }
                            }
                        
                          Database::disconnect();   
                        ?>

                    </select>
                    <span class='msgErr'><?php echo $categorieError; ?></span>
                </div>
                <div class="form-group mb-0">
                    <strong><label for="">Image :</label></strong>
                    <p><?php echo $image; ?></p>
                    <strong><label for='image'>Selectionner une Image : </label></strong>
                    <input type="file" id="image" name="image"><br>
                    <span class='msgErr'><?php echo $imageError; ?></span><br><br>
                </div>
                <button type="submit" class="btn btn-warning btn-lg wr mt-0 mb-4" id="marg"><i class="fas fa-pencil-alt"></i>  Modofier</a>
               
            </form>
        </div>
        <div class="col-md">
            <div class="card shadow cardProd bgr">
                <div class="text-center carditem">
                    <img class="card-img-top imgsize" src="<?php echo 'Ressources/img/' . $image  ; ?>" alt="...">
                </div>
                <div class="prix"><?php echo  number_format((float)$prix,2,'.','') . ' €'; ?></div>
                <div class="card-body">
                    <h4><?php echo  $name; ?></h4>
                    <p><?php echo  $description; ?></p>
                    <a href="admin.php" class="btn btn-primary btn-lg wr w-100" role="button"><i class="fas fa-arrow-left"></i> Retour</a>
                </div>
            </div>

        </div>


    </div>

</div>

<?php require_once 'Ressources/php/inc/footer.php'; ?>