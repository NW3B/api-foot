<?php
session_start();
if(!isset($_SESSION['id']) && !isset($_SESSION['pseudo'])){
    header('Location: login/connexion.php');
}
else{
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    #btnDeco{position: absolute; top:1.5rem; left:38rem; }
    #creation{position: absolute; top:5rem; left: 1rem;}
    #maj{position: absolute;top:5rem;left: 16rem;}
    #sup{position: absolute; top:5rem;left: 30rem;}
    #recherche{position: absolute; top:35rem;left: 16rem;}
    #recherche2{position: absolute; top:35rem;left: 30rem; }
    #recherche3{position: absolute; top:41.5rem;left: 30rem; }
    #consoleRecherche{position: absolute; top:14.5rem;left: 16rem; border: 1px solid black;padding: 1rem; background-color: cadetblue; overflow: auto;  height: 18rem;width: 33rem;}
    fieldset{width: 12rem;}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
</head>
<body>
<h2 style="margin-left: 2rem;" >Api Pari Football : Gestion de la table confrontation </h2>

<div id="contener"> 
 <div id="btnDeco"><a href="login/deconnexion.php"> 
     <input type="button" value="Déconnexion"> </a>
</div>
    <div id="recherche">
    <fieldset style="height: 8rem; width:6rem;">
        <legend>Recherche</legend>
        <form id="formRecherche" autocomplete="off">
        
        <span>
        <label for="annee">Année :</label>
        <input type="text" id="annee" placeholder="2020">
        <br>
        <label for="semaine">N° Semaine :</label>
        <input type="text" id="semaine" placeholder="de 1 à 53">
        </span>
       
        <button style="margin-left: 2.5rem; margin-top: 0.5rem; ">Rechercher</button>
        
       
        </form>
    </fieldset>
    </div>

    <div id="recherche2">
    <fieldset style="height: 5rem; width:6rem;">
        <legend>Recherche</legend>
        <form id="formRechercheId" autocomplete="off">
        <span>
        <label for="id_match">Id match :</label>
        <br>
        <input type="text" id="id_match" autocomplete="off">
        </span>
        <button style="margin-left: 2.5rem; margin-top: 0.5rem; ">Rechercher</button>
        </form>
    </fieldset>
    </div>
    
    <div id="recherche3">
        <fieldset style="width: 12rem;">
    <button id="rechercheTous">Rechercher Tous les matchs</button>
    </fieldset>
    </div>
       <div id="creation">

        <form id="formNew" method="POST" autocomplete="off"> 
    
        <fieldset>
            <legend>Création</legend>
            <!--<span>Veuillez renseigner seulement les champs 'Id équipe' <br/> ou seulement les champs 'Nom équipe'<br> L'Id_match est auto incrémenté </span> -->

                <p style="border: 1px solid black; padding:10px; ">
                <label for="id_equipe1">Id équipe 1 : </label> 
                <br>
                <input type="text" name="id_equipe1" id="id_equipe1"/>
                <br>
                <label for="id_equipe2">Id équipe 2 : </label> 
                <br>
                <input type="text" name="id_equipe2" id="id_equipe2"/>
                </p>
                <span>OU</span>
                <p style="border: 1px solid black; padding:10px;">
                <label for="libelle_equipe1">Nom équipe 1 : </label> 
                <br>
                <input type="text" id="libelle_equipe1" name="libelle_equipe1"/> 
                <br>
                <label for="libelle_equipe2">Nom équipe 2 : </label>
                <br>
                <input type="text" name="libelle_equipe2" id="libelle_equipe2"/>
                </p>

            <p>
                <label for="Cote1">Cote 1 (équipe 1 gagnante) : </label>
                <br>
                <input type="text" name="cote1" id="cote1"/>
            </p>
            <p>
                <label for="coteN">Cote N (match nul) : </label>
                <br>
                <input type="text" name="coteN" id="coteN"/>
            </p>
            
            <p>
                <label for="cote2">Cote 2 (équipe 2 gagnante) : </label>
                <br>
                <input type="text" name="cote2" id="cote2"/>
            </p>
            <p>
                <label for="date">Date : </label>
                <br>
                <input type="date" name="date" id="date"/>
            </p>
            <p>
                <label for="heure">Heure : </label>
                <br>
                <input type="time" name="heure" id="heure"/>
            </p>
            <button type="submit" >Ajouter</button>
            <input type="reset" name="annuler" value="Reset"/>
         
        </fieldset>
    </form>
    </div>
    <div id="maj">   
    <form method="POST" id="formMaj" autocomplete="off">
    <fieldset style="height: 8rem; width:6rem; ">
    <legend>MAJ résultat</legend>
    <!-- <div id="resultMaj"></div> --> 
    <span>
        <label for="id_matchX">Id match : </label>
        <br>
        <input type="text" id="id_matchX" name="id_matchX"/>
        <br>
        <label for="resultatX">Résultat (1, N, 2) : </label>
        <br>
        <input type="text" id="resultatX" name="resultatX"/>
    </span>
        <br>
        <button style="margin-left: 2rem; margin-top:0.5rem;" type="submit" >Mettre à jour</button>   
        
    </fieldset> 
    </form>
    </div> 
    <div id="sup">
    <form id="formSup" method="POST" autocomplete="off">
    <fieldset style="height: 8rem;width:6rem;">
    <legend>DELETE</legend>
    <p>
        <label for="id_matchR">Id match : </label>
        <br>
        <input type="text" name="id_matchR" id="id_matchR"/>
    </p>
    <button style="margin-left: 2.5rem; margin-top: 0.5rem; " type="submit" >Supprimer</button>   

    </fieldset>
    
    </form>
    </div>
    <input style="position: absolute; top : 13rem; left : 42.5rem;"; id="btn1" type="button" value="Clear console">
    <div id="consoleRecherche"></div>
    </div>
    
</body>
</html>
<?php
}
?>