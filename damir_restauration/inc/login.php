
<?php 
 require_once 'function.php';
 $array = array("emailco" => "", "passwordco" => "", "isSuccess" => false);
    
 if($_SERVER["REQUEST_METHOD"] == "POST"){
     $array["emailco"] = verifyInput($_POST["emailco"]);
     $array["passwordco"] = verifyInput($_POST["passwordco"]);

     require_once 'db.php';
     $req = $pdo->prepare('SELECT * FROM users WHERE (email = :email) AND confirmed_at IS NOT NULL');
     $req->execute(['email'=> $array['emailco']]);
     $user = $req->fetch();
     if(!empty($user) && password_verify($array['passwordco'], $user->password)){
         $array["isSuccess"] = true;
         session_start();
         $_SESSION['auth'] = $user;
         if(!empty($_POST['remember'])){
             $length = 80;
             $remember_token = bin2hex(random_bytes($length));
             $pdo->prepare('UPDATE arborea.users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
             setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'tobiestungentilchat'), time() + 60 * 60 * 24 * 7);
         }
     }
 echo json_encode($array);
}

?>
