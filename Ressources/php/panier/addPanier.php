<?php
require_once '_headerPanier.php';
require_once '../inc/db.php';
//Variable destinée à etre renvoyée à panier.js ($ajax).
$json = array('error' => true);

if(isset($_GET['id'])){
    Database::connect();
    $product = Database::query('SELECT * FROM items WHERE id=:id', array('id'=> $_GET['id']));
    Database::disconnect();
   //Si $SESSION['panier'] est vide
    if (empty($product)) {
        $json['message'] = "Ce produit n'existe pas. ";
    }


    $ids = array_keys($_SESSION['panier']);

    if (empty($ids)) {
        //Alors on vide $products
        $products = array();       
    } else {
        Database::connect();
        $products = Database::query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
        Database::disconnect();
    }
  
    $panier2 = $_SESSION['panier'];

    $panier->add($product[0]->id);
    $name = $product[0]->name;
    $prix = $product[0]->prix;
    $prod = $products;
    $json['error'] = false;
    $json['total'] = number_format($panier->total(), 2, '.', '');
    $json['count'] = $panier->count();
    $json['message'] = 'Le produit à bien été ajouté à votre panier. ';
    $json['name'] = $name;
    $json['prix'] = $prix;
    $json['prod'] = $prod;
    $json['panier2'] = $panier2;

    Database::connect();
    $prod = Database::query('SELECT * FROM items');
    } else {
        header('Location: ../../../restauration.php');
    }
echo json_encode($json);