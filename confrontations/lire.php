<?php
// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");
// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");
// Méthode autorisée
header("Access-Control-Allow-Methods: GET");
// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");
// Entêtes autorisées
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

    if(isset($_GET['annee']) and isset($_GET['semaine']) ){
        $match->annee = htmlspecialchars(strip_tags($_GET['annee']));
        $match->semaine = htmlspecialchars(strip_tags($_GET['semaine']));
    }
    // On récupère les données
    $stmt = $match->lire();
    
    // On vérifie si on a au moins 1 match
    if($stmt->rowCount() > 0){
        // On initialise un tableau associatif
        $tableauMatchs = [];
        $tableauMatchs['match'] = [];
        
        // On parcourt les matchs
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $prod = [
                "id_match" => $id_match,
                "libelle_ligue" => $libelle_ligue,
                "libelle_equipe1" => $libelle_equipe1,
                "id_equipe1" => $id_equipe1,
                "libelle_equipe2" => $libelle_equipe2,
                "id_equipe2" => $id_equipe2,
                "cote1" => $cote1,
                "coteN" => $coteN,
                "cote2" => $cote2,
                "date" => $date,
                "heure" => $heure,
                "semaine" => date('W',strtotime ($row['date'])),
                "resultat" => $resultat

            ];

            $tableauMatchs['match'][] = $prod;
            
        }
        // On envoie le code réponse 200 OK
        http_response_code(200);

        // On encode en json et on envoie
        echo json_encode($tableauMatchs);
    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "Aucun match pour ces paramètres"],JSON_UNESCAPED_UNICODE);    
    }

}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"],JSON_UNESCAPED_UNICODE);
}
