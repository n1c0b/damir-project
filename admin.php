<?php
$page = 'admin';
 require_once 'Ressources/php/inc/db.php'; 
 require_once 'Ressources/php/inc/header.php'; 
 admin_only();
?>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION TITREADMIN |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="titreAdmin">
    <h1>Interface Administrateur</h1>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md">
                <h2>Liste des Produits</h2>
            </div>
            <div class="col-md">
                <a href="insert.php" class= "btn btn-lg btnajt"><i class="fas fa-plus"></i> Ajouter un produit</a>
            </div>
        </div>
    </div>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| SECTION TABLEAUADMIN |||||||||||||||||||||||||||||||||||||||||||||| -->
<section id="tableauAdmin">
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $pdo = Database::connect(); 
                        $req = $pdo->query('SELECT items.id, items.name, items.description, items.prix, categories.name AS categorie
                                            FROM items LEFT JOIN categories ON items.categorie = categories.id 
                                            ORDER BY items.id DESC');
                        while ($item = $req->fetch()){
                            echo '<tr>
                                    <td>' . $item->name . '</td>
                                    <td>' . $item->description . '</td>
                                    <td>' . number_format((float)$item->prix,2, '.', '') . '</td>
                                    <td>' . $item->categorie . '</td>
                                    <td id="btngr">
                                        <a href="view.php?id=' . $item->id .  '"  class="btn btn-dark"><i class="far fa-eye"></i> Voir</a>
                                        <a href="update.php?id=' . $item->id . '" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></i> Modifier</a>
                                        <a href="delete.php?id=' . $item->id . '" class="btn btn-danger"><i class="far fa-trash-alt"></i></i> Supprimer</a>
                                    </td>
                                </tr>';
                            }
                        Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


<!-- |||||||||||||||||||||||||||||||||||||||||||||| CALL FOOTER |||||||||||||||||||||||||||||||||||||||||||||| -->
<?php require_once 'Ressources/php/inc/footer.php';?>