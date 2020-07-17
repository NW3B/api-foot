<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Confrontations.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les matchs
    $match = new Confrontations($db);

    //$donnees = json_decode(file_get_contents("php://input")); // (recevoir paramètre en fichier json)
    //$donnees = htmlspecialchars(strip_tags($_GET['id_match']));

    if(isset($_GET['id_match']) ){
        // $match->id_match = $donnees->id_match;  // lié au BUG au dessus
        $match->id_match = htmlspecialchars(strip_tags($_GET['id_match']));
    
        // On récupère le match
        $match->lireUn();
        
        // On vérifie si le match existe
        if($match->libelle_equipe1 != null and $match->libelle_equipe2 != null){
        /*  // Gestion logo equipe optionnel
            $url_img1 =  str_replace(" ","_", $match->libelle_equipe1);
            $url_img1 = "images/". strtolower($url_img1).".png";
            $url_img2 =  str_replace(" ","_", $match->libelle_equipe2);
            $url_img2 = "images/". strtolower($url_img2).".png";
            var_dump($url_img1);
            var_dump($url_img2);  
        */
            $prod = [
                "id_match" => $match->id_match,
                "libelle_ligue" => $match->libelle_ligue,
                "libelle_equipe1" => $match->libelle_equipe1,
                "libelle_equipe2" => $match->libelle_equipe2,
                "id_equipe1" => $match->id_equipe1,
                "id_equipe2" => $match->id_equipe2,
                "cote1" => $match->cote1,
                "coteN" => $match->coteN,
                "cote2" => $match->cote2,
                "date" => $match->date,
                "heure" => $match->heure,
                "semaine" => $match->semaine,
                "resultat" => $match->resultat,
        /*        
                "url_img1" => $url_img1,
                "url_img2" => $url_img2
        */        
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($prod,JSON_UNESCAPED_UNICODE);
        }else{
            // 404 Not found
            http_response_code(404);
            echo json_encode(array("message" => "Le match n'existe pas."),JSON_UNESCAPED_UNICODE);
        }
        
    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "Le paramètres 'id_match' n'est pas correct."],JSON_UNESCAPED_UNICODE);   
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"],JSON_UNESCAPED_UNICODE);
}