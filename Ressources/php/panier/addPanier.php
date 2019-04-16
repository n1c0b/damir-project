<?php
require_once '_headerPanier.php';
require_once '../inc/db.php';
//Variable destinée à etre renvoyée à panier.js ($ajax).
$json = array('error' => true);

if(isset($_GET['id'])){
    Database::connect();
    $product = Database::query('SELECT id FROM items WHERE id=:id', array('id'=> $_GET['id']));
    Database::disconnect();
    $ids = array_keys($_SESSION['panier']);
   //Si $SESSION['panier'] est vide
   if (empty($ids)) {
       //Alors on vide $products
       $products = array();
       $pdo = Database::connect();
       $req = $pdo->query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
       while($products = $req->fetch()){
           $name = $products->name;
       }
   }
   // sinon on demande à la bdd les id contenues dans $SESSION['panier']
//    else {
//        $pdo = Database::connect();
//        $req = $pdo->query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
//        while($products = $req->fetch()){
//            $name = $products->name;
//        }
      
       Database::disconnect();
//    }


    
    if (empty($product)) {
        $json['message'] = "Ce produit n'existe pas. ";
    }
    $panier->add($product[0]->id);
    $json['error'] = false;
    $json['total'] = number_format($panier->total(), 2, '.', '');
    $json['count'] = $panier->count();
    $json['message'] = 'Le produit à bien été ajouté à votre panier. ';
    $json['name'] = $name;
    Database::connect();
    $prod = Database::query('SELECT * FROM items');
} else {
    header('Location: ../../../restauration.php');
}
echo json_encode($json);