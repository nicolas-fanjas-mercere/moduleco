<?php
session_start();//demarrage de la session
$_SESSION = array();//declaration de la variable
session_destroy();//destruction de la session
header("Location: connexion.php")//redirection vers la page connexion.php
?>