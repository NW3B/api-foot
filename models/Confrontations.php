<?php
class Confrontations{
    // Connexion
    private $connexion;
    private $table = "confrontation";

    // object properties
    public $id_match;
    public $libelle_ligue;
    public $id_equipe1;
    public $id_equipe2;
    public $libelle_equipe1;
    public $libelle_equipe2;
    public $cote1;
    public $coteN;
    public $cote2;
    public $date;
    public $heure;
    public $semaine;
    public $annee;
    public $resultat;
    
    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture de tous les matchs selon année et semaine  ou  tous les matchs
     *
     * @return void
     */
    public function lire(){
        
        if (!empty($this->annee) and !empty($this->semaine)){
            $sql = "select id_match, id_equipe1, id_equipe2, l.libelle_ligue, e.libelle_equipe as libelle_equipe1, 
            e2.libelle_equipe as libelle_equipe2,
            cote1, coteN, cote2, date, heure, resultat from ".$this->table .
            " left join equipes e on id_equipe1 = e.id_equipe
            left join ligues l on e.id_league = l.id_league
            left join equipes e2 on id_equipe2 = e2.id_equipe
            left join ligues l2 on e2.id_league = l2.id_league
            WHERE YEAR(date) = :annee and WEEKOFYEAR(date) = :semaine
            order by date asc";
            // On prépare la requête
            $query = $this->connexion->prepare( $sql );
            // On attache l'id
            $query->bindValue(":annee", $this->annee, PDO::PARAM_INT);
            $query->bindValue(":semaine", $this->semaine, PDO::PARAM_INT);   
        }
        else{                                               
            // On écrit la requête
            $sql = "select id_match, id_equipe1, id_equipe2, l.libelle_ligue, e.libelle_equipe as libelle_equipe1, 
            e2.libelle_equipe as libelle_equipe2,
            cote1, coteN, cote2, date, heure, resultat from ".$this->table .
            " left join equipes e on id_equipe1 = e.id_equipe
            left join ligues l on e.id_league = l.id_league
            left join equipes e2 on id_equipe2 = e2.id_equipe
            left join ligues l2 on e2.id_league = l2.id_league
            order by id_match asc";
            // On prépare la requête
            $query = $this->connexion->prepare($sql);
        }    
        
        // On exécute la requête
        $query->execute();
        
        // On retourne le résultat  
        return $query;
    }

    /**
     * Créer un produit
     *
     * @return void
     */
    public function creer(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . "( id_equipe1, id_equipe2, cote1, coteN, 
        cote2, date, heure) VALUES 
        (:id_equipe1, :id_equipe2, :cote1, :coteN, :cote2, :date, :heure)";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);
        
        // Protection contre les injections
        $this->id_equipe1=htmlspecialchars(strip_tags($this->id_equipe1));
        $this->id_equipe2=htmlspecialchars(strip_tags($this->id_equipe2));
        $this->cote1=htmlspecialchars(strip_tags($this->cote1));
        $this->coteN=htmlspecialchars(strip_tags($this->coteN));
        $this->cote2=htmlspecialchars(strip_tags($this->cote2));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->heure=htmlspecialchars(strip_tags($this->heure));

        // Ajout des données protégées
        //$query->bindParam(":id_match", $this->id_match);
        $query->bindParam(":id_equipe1", intval($this->id_equipe1));
        $query->bindParam(":id_equipe2", intval($this->id_equipe2));
        $query->bindParam(":cote1", $this->cote1);
        $query->bindParam(":coteN", $this->coteN);
        $query->bindParam(":cote2", $this->cote2);
        $query->bindParam(":date", $this->date);
        $query->bindParam(":heure", $this->heure);
        // Exécution de la requête   
        $data = $query->execute();

        if( !$data ){
            throw new Exception ("l'id d'une des 2 équipes n'est pas retrouvée 
            ou les données ne sont pas correctes, se référer à la documentation");
            return false;
        }
        return true;
    
    }

    /**
     * Lire un match avec son Id
     *
     * @return void
     */
    public function lireUn(){

        // On écrit la requête
        $sql = "select id_match, id_equipe1, id_equipe2, l.libelle_ligue, e.libelle_equipe as libelle_equipe1, 
        e2.libelle_equipe as libelle_equipe2,
        cote1, coteN, cote2, date, heure, resultat from ".$this->table .
        " left join equipes e on id_equipe1 = e.id_equipe
        left join ligues l on e.id_league = l.id_league
        left join equipes e2 on id_equipe2 = e2.id_equipe
        left join ligues l2 on e2.id_league = l2.id_league
        WHERE id_match = :id_match";
        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindValue(":id_match", $this->id_match, PDO::PARAM_INT);
           
        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // On hydrate l'objet
        $this->id_match = $row['id_match'];
        $this->libelle_ligue = $row['libelle_ligue'];
        $this->libelle_equipe1 = $row['libelle_equipe1'];
        $this->libelle_equipe2 = $row['libelle_equipe2'];
        $this->id_equipe1 = $row['id_equipe1'];
        $this->id_equipe2 = $row['id_equipe2'];
        $this->cote1 = $row['cote1'];
        $this->coteN = $row['coteN'];
        $this->cote2 = $row['cote2'];
        $this->date = $row['date'];
        $this->heure = $row['heure'];
        $this->semaine = date('W',strtotime ($row['date']));
        $this->resultat = $row['resultat'];
    }

    /**
     * Supprimer un produit
     *
     * @return void
     */
    public function supprimer(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id_match = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id=htmlspecialchars(strip_tags($this->id_match));

        // On attache l'id
        $query->bindParam(1, $this->id_match);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Mettre à jour un produit
     *
     * @return void
     */
    public function modifier(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET resultat = :resultat
        WHERE id_match = :id_match";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->id_match=htmlspecialchars(strip_tags($this->id_match));
        $this->resultat=htmlspecialchars(strip_tags($this->resultat));
        
        // On attache les variables
        $query->bindParam(':id_match', $this->id_match);
        $query->bindParam(':resultat', $this->resultat);

        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * attribut les 'id_equipe' des 'libelle_equipe'
     *
     * @return void
     */
    public function appliqueIdEquipe(){
        // On écrit la requête
        $sql = "select id_equipe from equipes
        where libelle_equipe = :libelle_equipe1
        union
        select id_equipe from equipes
        where libelle_equipe = :libelle_equipe2
        ";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);
        
        // Ajout des données protégées
        $query->bindParam(":libelle_equipe1", $this->libelle_equipe1);
        $query->bindParam(":libelle_equipe2", $this->libelle_equipe2);

        // On exécute la requête
        $query->execute();

        // on récupère les lignes et on hydrate l'objet
        $this->id_equipe1 = $query->fetchColumn();
        $this->id_equipe2 = $query->fetchColumn();

        //Gestion des erreurs de saisi des noms d'équipes
        if( empty( $this->id_equipe1) or empty($this->id_equipe2) ){
            throw new Exception ("Une équipe n'a pas été retrouvée, Vérifier l'ortographe");
        }
        
    }   

}
?>
