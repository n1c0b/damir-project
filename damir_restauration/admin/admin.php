
<?php 
 require_once '../inc/db.php'; 
 require_once '../inc/entete.php'; 
 require_once '../inc/function.php'; 
?>

<h1 id='h1admin'>ADMINISTRATEUR</h1>

<div class="container admin">

    <div class="row">
        <h1><strong>Liste des Produit</strong><a href="insert.php" class= "btn btn-success btn-lg btnajt"><i class="fas fa-plus add"></i>Ajouter</a></h1>
    </div>

    <table class="table table-striped table-bordred">
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
               while ($item = $req->fetch()) 
               {

                  echo '<tr>';
                  echo  '<td>' . $item['name'] . '</td>';
                  echo  '<td>' . $item['description'] . '</td>';
                  echo  '<td>' . number_format((float)$item['prix'],2, '.', '') . '</td>';
                  echo  '<td>' . $item['categorie'] . '</td>';
                  echo'<td id="btngr">';
                          echo '<a href="view.php?id=' . $item['id'] .  '"  class="btn btn-dark"><i class="far fa-eye"></i> Voir</a>';
                          echo ' '; 
                          echo '<a href="update.php?id=' . $item['id'] . '" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></i> Modifier</a>';
                          echo ' '; 
                          echo '<a href="delete.php?id=' . $item['id'] . '" class="btn btn-danger"><i class="far fa-trash-alt"></i></i> Supprimer</a>'; 
                      echo '</td>';
                   echo'</tr>';
                    
               }

               Database::disconnect();
              
              
              ?>  


        </tbody>

    </table>


</div>

<?php
require_once '../inc/footer.php';
?>