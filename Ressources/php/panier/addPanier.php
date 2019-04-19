<?php
require_once '_headerPanier.php';
require_once '../inc/db.php';
//Variable destinée à etre renvoyée à panier.js ($ajax).
$json = array('error' => true);

if(isset($_GET['id'])){
    Database::connect();
    //On verifie que le produit existe au cas ou il aurait été rentré dans l'url
    $product = Database::query('SELECT * FROM items WHERE id=:id', array('id'=> $_GET['id']));
    Database::disconnect();
   //Si $SESSION['panier'] est vide
    if (empty($product)) {
        $json['message'] = "Ce produit n'existe pas.";
    }
    $panier->add($product[0]->id);
    $ids = array_keys($_SESSION['panier']);

    Database::connect();
    $products = Database::query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
    Database::disconnect();
    
    $panierIdNombre = $_SESSION['panier'];

    ////////JSON///////
    //Total et compte du panier récuperés depuis l,'instance de $panier
    $json['total'] = number_format($panier->total(), 2, '.', '');
    $json['count'] = $panier->count();

    //messages
    $json['error'] = false;
    $json['message'] = 'Le produit à bien été ajouté à votre panier.';

    $json['prod'] = $products;//Toutes les infosc sur les id presents dans le panier
    $json['panierIdNombre'] = $panierIdNombre;
    $json['ids'] = $ids;

   
    } else {
        header('Location: ../../../restauration.php');
    }
echo json_encode($json);