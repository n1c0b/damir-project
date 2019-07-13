<?php
// Cette class est instanciée dans _headerPanier.php, elle même required dans les fichiers qui en ont besoin: panier.php, restauration.php
class panier
{
    //Constructeur de session['panier']
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }
        if (isset($_GET['delpanier'])) {
            $this->del($_GET['delpanier']);
        }
        if (isset($_POST['panier']['quantity'])) {
            $this->recalc();
        }
    }

    // affichage du contenu du panier après chaque modif
    public function recalc()
    {
        foreach ($_SESSION['panier'] as $product_id => $quantity) 
        {
        if (isset($_POST['panier']['quantity'][$product_id])) 
            {
                $_SESSION['panier'][$product_id] = $_POST['panier']['quantity'][$product_id];  
            }
        }
    }

    //Calcul du nombre de produits dans le panier
    public function count()
    {
        return array_sum($_SESSION['panier']);
    }

    //Calcul du total prix
    public function total()
    {
        $total = 0;
        $ids = array_keys($_SESSION['panier']);
       
        if (empty($ids)) 
            {
                $products = array();
            }
        else 
            {
                Database::connect();
                $products = Database::query('SELECT id, prix FROM items WHERE id IN (' . implode(',', $ids) . ')');
                Database::disconnect();
            }
        foreach ($products as $product)
        { 
            $total += $product->prix * $_SESSION['panier'][$product->id];
        }
        return $total;
    }

    //Ajout au panier
    public function add($product_id)
    {   //Si le produit en question est déja initialisé à 1 dans le panier alors on l'incremente
        if (isset($_SESSION['panier'][$product_id])) {
                $_SESSION['panier'][$product_id]++;
            }
            if(!isset($_SESSION['panier'][$product_id])){
                $_SESSION['panier'][$product_id] = 1;
            }
    }

    //Suppresion de l'article du panier
    public function del($product_id)
    {
        unset($_SESSION['panier'][$product_id]);
        if(isset($_GET['del']) && strpos($_SERVER['REQUEST_URI'], 'delpanier') || strpos($_SERVER['REQUEST_URI'], 'restauration')){
            echo '<script>window.location.replace("restauration.php");</script>';
        }
        
    }
   
}
