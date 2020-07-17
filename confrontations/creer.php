<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json ; charset=UTF-8");   // text/plain
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Confrontations.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les matchs
    $match = new Confrontations($db);

    // On récupère les informations envoyées
    //$donnees = json_decode(file_get_contents("php://input"));  (revevoir fichier json)
   
    if (  (   !empty($_POST['libelle_equipe1']) and !empty($_POST['libelle_equipe2'])    )  or 
    (  !empty($_POST['id_equipe1']) and  !empty($_POST['id_equipe2'])   )   
    and (  !empty($_POST['cote1']) and   !empty($_POST['coteN']) and  !empty($_POST['cote2']) 
    and  !empty($_POST['date']) and  !empty($_POST['heure'])  ) ){
        // Ici on a reçu les données
        // On hydrate notre objet
        
        if ( !empty($_POST['id_equipe1']) and  !empty($_POST['id_equipe2'])){
            $match->id_equipe1 = $_POST['id_equipe1'];
            $match->id_equipe2 = $_POST['id_equipe2'];
        }

        else if ( !empty($_POST['libelle_equipe1']) and  !empty($_POST['libelle_equipe2'])){
            $match->libelle_equipe1 = $_POST['libelle_equipe1'];
            $match->libelle_equipe2 = $_POST['libelle_equipe2'];
            try{
                $match->appliqueIdEquipe();
                }
            catch(Exception $e){
                // On envoie un code 400 (bad request)
                http_response_code(400);
                echo json_encode(["message" => $e->getMessage()],JSON_UNESCAPED_UNICODE);
                return;
                }
        }
        //$match->id_match = $donnees->id_match; // prototype lié au fichier upload json
        $match->cote1 = floatval($_POST['cote1']);
        $match->coteN = floatval($_POST['coteN']);
        $match->cote2 = floatval($_POST['cote2']);
        $match->date = $_POST['date'];
        $match->heure = $_POST['heure'];
        try{
            $match->creer();
        }
        catch (Exception $e){
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()],JSON_UNESCAPED_UNICODE);
            return;    
        }

        if($match->creer()){
            // Ici la création a fonctionné
            // On envoie un code 201 (created)
            http_response_code(201);
            echo json_encode (["message" => "L'ajout a été effectué"],JSON_UNESCAPED_UNICODE);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503 (service unavailable)
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué"],JSON_UNESCAPED_UNICODE);         
        }
    }else{
        // On envoie un code 409 (conflict)
        http_response_code(409);
        echo json_encode(["message" => "Les paramètres sont incorrect ou incomplet, Veuillez vous référer à la documentation"],JSON_UNESCAPED_UNICODE);    
    }
}else{
    // On gère l'erreur 405 (method not allowed)
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"],JSON_UNESCAPED_UNICODE);
}

