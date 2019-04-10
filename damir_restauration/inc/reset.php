
<?php 
 if(isset($_GET['id']) && isset($_GET['token'])){
    require_once 'db.php';
    require_once 'function.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();
    if($user){
        if(!empty($_POST)){
            session_start();
            if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
               
                $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
            }
            else{
                if(empty ($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
                    $_SESSION['flash']['danger'] = "les mots de passes ne correspondent pas";
                }
            }

        }
        
    }else{
        session_start();
        $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
        header('Location: login.php');
        exit();
    }

 }else{
     header('Location: login.php');
     exit();
 }

?>

<?php require 'header.php'; ?>

<h1>Réinitialiser mon mot de passe</h1>

<form action="" method="POST">
      
       
        
        <div class="form-group">
            <label for="">Mot de passe</label>
            <input type="password" name="password" class="form-control" />
        
        </div>
        <div class="form-group">
            <label for="">Confirmation du mot de passe</label>
            <input type="password" name="password_confirm" class="form-control" />
        
        </div>
    
    
        <button type="submit" class="btn btn-primary">Réinitialiser votre mot de passe </button>
                

    
        
    </form>


<?php require 'footer.php'; ?>
