<?php
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) 
{
    erreur(ERR_IS_NOT_CO);
}
else{
    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy();

    $titre="Déconnexion";
    header('Location: connexion.php');
}
?>


