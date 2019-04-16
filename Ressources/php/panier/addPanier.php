<?php
require_once '_headerPanier.php';
require_once '../inc/db.php';
//Variable destinée à etre renvoyée à panier.js ($ajax).
$json = array('error' => true);


if(isset($_GET['id']))
{
    Database::connect();
    $product = Database::query('SELECT id FROM items WHERE id=:id', array('id'=> $_GET['id']));
    Database::disconnect();
    if (empty($product)) {
        $json['message'] = "Ce produit n'esxiste pas. ";
    }
    $panier->add($product[0]->id);
    $json['error'] = false;
    $json['total'] = number_format($panier->total(), 2, '.', '');
    $json['count'] = $panier->count();
    $json['message'] = 'Le produit à bien été ajouté à votre panier. ';
    // $json['name'] = $product->name;
    // $json['prix'] = number_format($product->prix, 2, '.', '');
    // $json['number'] = $_SESSION['panier'][$product->id];
}
else
{
    $json['message'] = "Vous n'avez pas selectionné de produit à ajouter. ";
}
echo json_encode($json);