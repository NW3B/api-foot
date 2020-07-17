<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain; charset=UTF-8");
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
    //$donnees = json_decode(file_get_contents("php://input"));
    
    if( !empty($_POST['id_match']) && !empty($_POST['resultat']) ){
        // Ici on a reçu les données
        // On hydrate notre objet
        $match->id_match = intval($_POST['id_match']);
        $match->resultat = substr($_POST['resultat'],0,1);

        if($match->modifier()){
            // Ici la modification a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La modification a été effectuée"],JSON_UNESCAPED_UNICODE);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La modification n'a pas été effectuée"],JSON_UNESCAPED_UNICODE);         
        }
    }else{
        // On envoie un code 409 (conflict)
        http_response_code(409);
        echo json_encode(["message" => "Les paramètres sont incorrect ou incomplet, Veuillez vous référer à la documentation"],JSON_UNESCAPED_UNICODE);    
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"],JSON_UNESCAPED_UNICODE);
}