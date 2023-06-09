<?php

session_start();//demarage de la session

$bdd = new PDO('mysql:host=127.0.0.1;dbname=moduleconnexion', 'root', '');//connexion a la base de donner


if(isset($_SESSION['id'])){//si la variable de session id existe 
    if(isset($_GET['id']) && $_GET['id'] > 0){//si $_GET[ID] existe et si il est suppérieur a 0
    
        $getid = intval($_GET['id']);//variable qui permet de dire que $_GET['id'] est un entier
        $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');//prepare la requete qui permet de selectionner l'utilisateur correspondant a l'id 
        $requser->execute(array($getid));//execusion de la requete prepare qui cherche le l'id correspendant
        $userinfo = $requser->fetch();//variable qui contient les donner 
        
    
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/css.css">
    <title>Profil</title>
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
        <fieldset class="profil">
            <legend>Profil de <?php echo $_SESSION['login'];  ?> </legend><br>
            <form action="" method="POST">
                <p>login : <?php echo $userinfo['login']; ?></p></br>
                <?php
                if(isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']){
                ?>
                <a class="button" href="deconnexion.php">deconnexion</a></br>
                <a class="button" href="editionprofil.php">Edition du profil</a></br>
                <?php
                }
                ?>
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
    header("Location: connexion.php");//redirerection vers la page connexion.php
}
?>