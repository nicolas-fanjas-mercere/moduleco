<?php

session_start();//demarage de la session

$bdd = new PDO('mysql:host=127.0.0.1;dbname=moduleconnexion', 'root', '');//connexion a la base de donner

if(isset($_POST['connect'])){//si $_POST['connect']
    
    $login = htmlspecialchars($_POST['login']);//creation d'un variable permettant d'eviter les injection sql
    $password = sha1($_POST['password']);//enrypte le mot de passe
    
    if(!empty($login) && !empty($password)){//si l'input login et password ne sont pas vide
    
        $request = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? && password = ?");//requete prepare qui permet de selectionner l'utilisateur du id correspendant
        $request->execute(array($login, $password));//execusion de la requete prepare qui cherche le mode de passe et le password correspendant
        $userexist = $request->rowCount();//return le nombre de ligne de la base de donner qui correspont a la requete
    
            if($userexist == 1){//si l'utilisateur existe
                $userinfo = $request->fetch();//declaration d'une varibale qui contient les donné
                $_SESSION['id'] = $userinfo['id'];//creattion d'une variable de session 
                $_SESSION['login'] = $userinfo['login'];//creattion d'une variable de session 
                header("Location: profil.php?id=".$_SESSION['id']);//redirige vers la page profile.php
            }
                if($_POST['login'] == 'admin' && $_POST['password'] == 'admin'){//si les input sont égale
                    $_SESSION['admin'] = 1 ;//création du variable de session pour l'admin
                    header("Location: admin.php");//redirige vers la page admin.php
                }

            else{
                $erreur = '<font color="red">Login inexsistant ou Password incorrect !</font>';//indque quel erreur enpeche la connexion
            }
        }
        else{
            $erreur = '<font color="red"> Il manque des champs !</font>';//indque quel erreur enpeche la connexion
        }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/css.css">
    <title>Connexion</title>
</head>
<body>
    <header>
        <img class="logo" src="image/devsgame.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="connexion.php">Connexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <fieldset class="connexion">
            <legend>Connexion</legend><br>
            <form action="" method="POST">
                <label>login</label> <input name="login" type="text" placeholder="Votre Login">
                <label>password</label> <input name="password" type="password" placeholder="Votre Password">
                <input class="input" type="submit" name="connect" value="Se connecter">
                <?php if(isset($erreur)){echo "$erreur"."<br>";}?><!--Affiche la varibale qui contient l'erreur-->
            </form>
        </fieldset>
    </main>
    <footer>
        <div class="resaux">
            <ul class="social-icons">
            <ul>
        </div>
    </footer>
</body>
</html>

