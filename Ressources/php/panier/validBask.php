<?php

    if(!isset($_POST)){
        header('Location: ../../../index.php');
    } else {
        $page = 'panier';
        require_once '../inc/db.php';
        require_once '_headerPanier.php'; 
        $user = $_SESSION['auth'];
    
        $ids = array_keys($_SESSION['panier']);
        if(empty($ids)){
                $products = array();
        } else {
            Database::connect();
            $products = Database::query('SELECT * FROM items WHERE id IN (' . implode(',', $ids) . ')');
            Database::disconnect();
        }
    
        $mailCommand = '<h1>Nouvelle Commande Damir Restauration :</h1><br><br>
                        <h3>Date de la commande : Le ' . date("d/m/Y à H:i:s") . '</h3>
                        <h3>Commandé par : ' . $user->firstname . ' ' . $user->lastname .'</h3>
                        <h3>E-mail : ' . $user->email . '</h3>
                        <h3>Numéro client : ' . $user->id . '</h3><br>';
    
        foreach ($products as $product){
            $mailCommand .= '<b>Produit : ' . $product->name . '<br>
                             Quantité : ' . $_SESSION['panier'][$product->id] . '
                             Prix unitaire : ' . number_format($product->prix, 2, '.', '') . ' €</b><br><br>';      
        }
        $mailCommand .= "<h2>Nombre total d'article : " . $panier->count() . "<br>
                         Prix total : " . number_format($panier->total(), 2, ',', ' ') . " €</h2>";
        $headers = "From: {$user->firstname} {$user->lastname} <{$user->email}>\r\nReply-To: {$user->email}";
        mail('mailDeDamir@afpa.fr', "Nouvelle commande Damir Restauration", $mailCommand, $headers);
        $_SESSION['flash']['success'] = 'Votre commande à bien été prise en compte';
        unset($_SESSION['panier']);
        header('Location: ../../../index.php');
    }

?>