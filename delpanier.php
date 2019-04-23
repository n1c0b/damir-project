<?php
require_once 'Ressources/php/panier/_headerPanier.php';

$json = array('success'=> false);

if (isset($_GET['del'])) {
    $panier->del($_GET['del']);
    $json['delId'] = $_GET['del'];
    $json['success'] = true;
    
}
echo json_encode($json);
