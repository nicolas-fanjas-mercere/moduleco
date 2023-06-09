
<?php
session_start();//demarage de la session
$bdd = new PDO('mysql:host=127.0.0.1;dbname=moduleconnexion', 'root', '');//connexion a la base de donner


if(isset($_POST['submit'])){
    
    $login = htmlspecialchars($_POST['login']);//creation d'un variable permettant d'eviter les injection sql
    $prenom = htmlspecialchars($_POST['prenom']);//creation d'un variable permettant d'eviter les injection sql
    $nom = htmlspecialchars($_POST['nom']);//creation d'un variable permettant d'eviter les injection sql
    $password = sha1($_POST['password']);//création d'une variable qui encrypte le mode de passe 
    $password2 = sha1($_POST['password2']);//création d'une variable qui encrypte le mode de passe 
    
    if(!empty($_POST['login']) && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['password']) && !empty($_POST['password2'])){// si tout les champs ne sont pas vide 
        
        $pasdedoublons = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");//prepare la requete pour selectionner l'utilisateur correspondant a l'id
        $pasdedoublons->execute(array($login));//execution de la requete prepare qui cherche le login correspendant
        $sidoublon = $pasdedoublons->rowCount();//return le nombre de ligne de la base de donner qui correspont a la requete
        
        if($sidoublon == 0) {//si il y'a 0 utilisateur correspondant au login ecrit
            
            $loginlength = strlen($login);//calcul de la taille de la chaine
            if($loginlength <= 255){//si la taille de la chaine est inférieur ou = a 255
                
                $prenomlength = strlen($prenom);//calcul de la taille de la chaine
                if($prenomlength <= 255){//si la taille de la chaine est inférieur ou = a 255
                    
                    $nomlength = strlen($nom);//calcul de la taille de la chaine
                    if($nomlength <= 255){//si la taille de la chaine est inférieur ou = a 255
                        
                        $passwordlength = strlen($password);
                        if($passwordlength <= 255){//si la taille de la chaine est inférieur ou = a 255
                            
                            $password2length = strlen($password2);
                            if($password2length <= 255){//si la taille de la chaine est inférieur ou = a 255
                                
                                if($password2 == $password){//si le password2 est strictemet egale a password
                                    
                                    $insertinto = $bdd->prepare("INSERT INTO utilisateurs(login, prenom, nom, password) VALUES(?, ?, ?, ?)");//requete prepare qui prepare l'insertion de valeur sans la table utilisateur
                                    $insertinto->execute(array($login, $prenom, $nom, $password));//execution de la requete avec les valeurs
                                    $fail = "<font color='green>'Votre Compte est crée !!! <a href=\"connexion.php\">Se connecter !</a></font>";//message qui confirme l'incription
                                }
                                
                                else{
                                    $fail = '<font color="red">les passwords ne concorde pas !!!</font>';//indque quel erreur enpeche l'incripetion
                                }
                            }
                            else{
                                $fail = '<font color="red">Les champs ne doivent pas depasser 255 caractères !</font>';//indque quel erreur enpeche l'incripetion
                            }
                        }
                        else{
                            $fail = '<font color="red">Les champs ne doivent pas depasser 255 caractères !</font>';//indque quel erreur enpeche l'incripetion
                        }
                    }
                    else{
                        $fail = '<font color="red">Les champs ne doivent pas depasser 255 caractères !</font>';//indque quel erreur enpeche l'incripetion
                    }
                }
                else{
                    $fail = '<font color="red">Les champs ne doivent pas depasser 255 caractères !</font>';//indque quel erreur enpeche l'incripetion
                }
            }
            else{
                $fail = '<font color="red">Les champs ne doivent pas depasser 255 caractères !</font>';//indque quel erreur enpeche l'incripetion
            }
        }
        else{
            $fail = '<font color="red">ce login existe déja !<!DOCTYPE html></font>';//indque quel erreur enpeche l'incripetion
        }
    }
    
    else{
        $fail = '<font color="red">Il manque des champs !</font>';//indque quel erreur enpeche l'incripetion
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
    <title>inscription</title>
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
        <fieldset class="inscription">
        <legend>Inscription</legend><br>
            <form method="POST">
                    <label>login</label> <input type="text" name="login" placeholder="Login"  value="<?php if(isset($login)){ echo"$login";} ?>" ></br>
                    
                    <label>prenom</label> <input type="text" name="prenom" placeholder="Prenom" value="<?php if(isset($prenom)){ echo"$prenom";} ?>" ></br>
                    
                    <label>nom</label> <input type="text" name="nom" placeholder="nom" value="<?php if(isset($nom)){ echo"$nom";} ?>" ></br>
                    
                    <label>password</label> <input type="password" name="password" ></br>
                    
                    <label>confirmation</label> <input type="password" name="password2" ></br>
                    
                    <input type="submit" name="submit" value="S'inscire"></br>
                    <?php if(isset($fail)){echo "$fail"."<br>";}?><!--Affiche la varibale qui contient l'erreur-->
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

