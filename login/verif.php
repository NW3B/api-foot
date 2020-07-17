<?php
session_start();
include("includes/identifiants.php");

    $message='';
    if (empty($_POST['pseudo']) || empty($_POST['mdp']) ) //Oublie d'un champ
    {
        header('Location: connexion.php?erreur=2'); // utilisateur ou mot de passe vide
    }
    else //On check le mot de passe
    {
        $query=$db->prepare('SELECT id, pseudo, `password`
        FROM administrateur WHERE pseudo = :pseudo');
        $query->bindValue(':pseudo',$_POST['pseudo'], PDO::PARAM_STR);
        $query->execute();
        $data=$query->fetch();
        $passwordCorrect = password_verify($_POST['mdp'], $data['password']); /// booléen

        if ($passwordCorrect) // Acces OK !    
        {
            $_SESSION['pseudo'] = $data['pseudo'];
            $_SESSION['id'] = $data['id'];
            header('Location: ../gestion.php');
        }

        else // Acces pas OK !
        {
            header('Location: connexion.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    $query->CloseCursor();
    }
?>