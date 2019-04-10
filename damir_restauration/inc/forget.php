
<?php 
 if (!empty($_POST) && !empty($_POST['email'])){
     require_once'db.php';
     require_once'function.php';
     
     $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL') ;
     $req->execute([$_POST['email']]);
     $user = $req->fetch();
     session_start();
     if($user){
        
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        
         $_SESSION['flash']['success'] = 'les instruction du rappel de mot de passe vous ont été envoyées par email';
         mail($_POST['email'], 'Réinitialisation de votre cmot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost:8090/connexion/inc/reset.php?id={$user->id}&token=$reset_token");   

         header('Location: login.php');
         exit();
     }else{
         $_SESSION['flash']['danger'] = 'Aucun compte ne correspond a cette adresse email !!!';
     }
    
    }

?>

<?php require 'header.php'; ?>

<h1>Mot de passe oublier</h1>

<form action="" method="POST">
      
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control"/>
        
        </div>
    
        <button type="submit" class="btn btn-primary">Se connecter</button>
                

    
        
    </form>


<?php require 'footer.php'; ?>
