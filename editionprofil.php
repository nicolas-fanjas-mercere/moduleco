<?php

session_start();//demarage de la session

$bdd = new PDO('mysql:host=127.0.0.1;dbname=moduleconnexion', 'root', '');//connexion a la base de donner


if(isset($_SESSION['id'])){//condition qui permet de voir si une variable de session de id a été crée sinon une redirection automatique vers la page de connexion
    $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');//requete prepare qui permet de selectionner l'utilisateur du id correspendant
    $requser->execute(array($_SESSION['id']));//execusion de la requete prepare qui cherche le id correspendant
    $userinfo = $requser->fetch();//requete qui contient les info de l'utilisateur

    if(isset($_POST['newlogin']) && !empty($_POST['newlogin']) && $_POST['newlogin'] != $userinfo['login']){//verifie si l'input new login existe, si il n'est pas vide ansi que si il est contraire a au login précedant
        
        $newpseudo = htmlspecialchars($_POST['newlogin']);//creation d'un variable permettant d'eviter les injection sql
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");//requete prepare qui permet de mettre a jour l'utilisateur pa rapport a l'id correspendant 
        $insertlogin->execute(array($newpseudo, $_SESSION['id']));//excute la requete mets a jour le login par le newpseudo et par rapport a l'id correspondant
        header('Location: profil.php?id='.$_SESSION['id']);//redirection vers la page profil.php
    }
    if(isset($_POST['newnom']) && !empty($_POST['newnom']) && $_POST['newnom'] != $userinfo['nom']){//meme concepte pour le new
        
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET nom = ? WHERE id = ?");
        $insertlogin->execute(array($newnom, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']); 
    }
    if(isset($_POST['newprenom']) && !empty($_POST['newprenom']) && $_POST['newnom'] != $userinfo['prenom']){//meme concepte pour le new login
        
        $newprenom = htmlspecialchars($_POST['newnom']);
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET prenom = ? WHERE id = ?");
        $insertlogin->execute(array($newprenom, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }
    if(isset($_POST['newpassword']) && !empty($_POST['newpassword']) && isset($_POST['newpassword2']) && !empty($_POST['newpassword2'])){//verifie si l'input newpassword existe, si il n'est pas vide ansi que si il est contraire a au password précedant
        
        $newpassword = sha1($_POST['newpassword']);
        $newpassword2 = sha1($_POST['newpassword2']);
        
        if($newpassword == $newpassword2){//verifie si le password et egale a la confirmation
            
            $insertlogin = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");//meme concepte pour le new login
            $insertlogin->execute(array($newpassword, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        else{
            $fail = '<font color="red">les passwords ne concorde pas !!!</font>';//fait en que la varianle sois egal a l'erreur
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
    <title>Edition Profil</title>
</head>
<body>
    <header>
        <img class="logo" src="image/devsgame.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <fieldset class="editprofil">
            <legend>Profil de <?php echo $userinfo['login'];  ?> </legend><br>
            <form action="" method="POST">
                <p>Login</p> <input type="texte" name="newlogin" placeholder="Nouveau Login" value=<?php echo $userinfo['login']; ?> /></br>
                <p>Nom</p> <input type="texte" name="newnom" placeholder="Nouveau Login" value=<?php echo $userinfo['nom']; ?> /></br>
                <p>Prenom</p> <input type="texte" name="newprenom" placeholder="Nouveau Login" value=<?php echo $userinfo['prenom']; ?> /></br>
                <p>Password</p> <input type="password" name="newpassword" placeholder="Nouveau Password" /></br>
                <p>Confirmation</p> <input type="password" name="newpassword2" placeholder="Confirmer"  /></br>
                <input type="submit" value="Modifier votre profil" /></br>
                <a class="button" href="profil.php">profil</a></br>
                <a class="button" href="deconnexion.php">déconnexion</a></br>
                <?php if(isset($fail)){echo "$fail"."<br>";}?><!--Affiche la varibale qui contient l'erreur-->
            </form>
        </fieldset>
    </main>
    <footer>
    <div class="resaux">
            <ul class="social-icons">
                </a>
            <ul>
        </div>
    </footer>
</body>
</html>
<?php
}
else{//sinon
    header("Location: connexion.php");//redirige vers la page de connexion
}
?>