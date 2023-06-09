<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=moduleconnexion;charset=utf8', 'root', '');//connexion a la base de donner

if($_SESSION['admin'] == 1){//si une varaible de sesssion de admin existe
    if(isset($_GET['supprime']) && !empty($_GET['supprime'])){//si get supprime existe et si il n'est pas vide 
        $supprime = (int) $_GET['supprime'];//pour dire que la varibale est un entier 
        $requete = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');// preparation de la commande supreme
        $requete->execute(array($supprime));//execution de la commande
    }

$utilisateurs =$bdd->query("SELECT * FROM utilisateurs ORDER BY id DESC");//variable qui contient les donner et qui les class du plus recent au plus ancien

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/css.css">
    <title>Admin</title>
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
        <fieldset class="admin">
            <legend>Admin</legend><br>
            <ul>
                <?php while($users = $utilisateurs->fetch()){
                            if($users['login'] != 'admin'){?>
                    <li> Id : <?= $users['id']?> Login : <?= $users['login']?> Prenom : <?= $users['prenom']?> Nom : <?= $users['nom']?> </li><a class="buttonadmin" href="admin.php?supprime=<?= $users['id'] ?>">Supprimer</a></br>
                    <?php }
                        else {
                            echo '';
                        }
                    }?>
                    <a class="buttondeux" href="deconnexion.php">deconnexion</a>
            </ul>  
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
else{
    header("Location: connexion.php");
}
?>
