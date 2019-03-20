<?php
/**Jade Pomerleau Gauthier*/

/**
 * Author: Valentina
 * Date: Winter 2019
 */

class Client
{
    private $_id; //3
    private $data;


    public function __construct($id)
    {
        $this->_id = $id;
    }

    /** Retourne l'information d'un client**/
    public function loadFromDB()
    {
        //$db = Database::getInstance();
        //$db->query("SELECT * FROM Client WHERE id = ?", ['id', $this->_id]);

        $sql = "SELECT * FROM Client WHERE id = $this->_id";
        $req = mysqli_query($sql) or die('Erreur.'.mysqli_error());
        $this->data = mysqli_fetch_array($req);

        /*$this->_nom = $this->data['nom'];
        $this->_courriel = $this->data['courriel'];
        $this->_condition_achat = $this->data['condition_achat'];
        $this->_adresseFacturation = $this->data['adresseFacturation'];
        $this->_adresseLivraison = $this->data['adresseLivraison'];
        $this->_fkidSupplier = $this->data['fkidSupplier'];*/

        /*
        Nom : <?php echo $data['nom'] ?>.<br />
        Courriel : <?php echo $data['courriel'] ?>.<br />
        Condition d'achat : <?php echo $data['condition_achat'] ?>.<br />
        Adresse de facturation : <?php echo $data['adresseFacturation'] ?>.<br />
        Adresse de livraison : <?php echo $data['adresseLivraison'] ?>.<br />

        Nom : Exemple1
        Courriel : exemple1@exemple.com
        Condition d'achat : null
        Adresse de facturation : 111 exemple
        Adresse de livraison : 112 exemple
        */

    }

    /* méthodes pour GET */

    public function getClientDetails() {
        $this->loadFromDB();
        return json_encode($this->data);

        /*$this->_nom = $this->data['nom'];
        $this->_courriel = $this->data['courriel'];
        $this->_condition_achat = $this->data['condition_achat'];
        $this->_adresseFacturation = $this->data['adresseFacturation'];
        $this->_adresseLivraison = $this->data['adresseLivraison'];
        $this->_fkidSupplier = $this->data['fkidSupplier'];*/

        /*
        $this->_idProduit = $idProduit;
        $this->_data = $this->_db->results()[0];

        $this->_nom = $this->_data->nom ;
        $this->_prix = $this->_data->prix ;
        $this->_description = $this->_data->description ;
        $this->_origine = $this->_data->origine ;
        $this->_code = $this->_data->code ;
        $this->_format = $this->_data->format ;
        $this->_fkidSupplier = $this->_data->fkidSupplier ;
        */

        //$proprietesProduit = array(
        // *              "id" => $_id,
        // *              "name" => $_nomProduit,
        // *              "prix" => $_prix,
        // *              "description" => $_description,
        // *              "origine" => $_origine,
        // *              "code" => $_code,
        // *              "format" => $_format,
        // *              "logo" => $_logo
        // *          );
    }

    public function getProductsList() {
        $this->loadFromDB();
        $sql = "SELECT * FROM Produit WHERE id = $this->data['fkidSupplier']";
        $req = mysqli_query($sql) or die('Erreur.'.mysqli_error());
        $donnee = mysqli_fetch_array($req);
        return json_encode($donnee);

        //$db = Database::getInstance();
        //$var = "SELECT fkidSupplier FROM Client WHERE id = $this->_id";
        //$sql = "SELECT * FROM Produit WHERE id = $var";
    }

    public function getProductDetails($idAbout) {
        $this->loadFromDB();
        $sql = "SELECT $idAbout FROM Produit WHERE id = $this->data['fkidSupplier']";
        $req = mysqli_query($sql) or die('Erreur.'.mysqli_error());
        $donnee = mysqli_fetch_array($req);
        return json_encode($donnee);
    }

    public function getUsersList() {    //?
        $sql = "SELECT * FROM User WHERE id = $this->_id";
        $req = mysqli_query($sql) or die('Erreur.'.mysqli_error());
        $donnee = mysqli_fetch_array($req);
        return json_encode($donnee);
    }

    public function getUser($idAbout) {     //?
        $sql = "SELECT $idAbout FROM User WHERE id = $this->_id";
        $req = mysqli_query($sql) or die('Erreur.'.mysqli_error());
        $donnee = mysqli_fetch_array($req);
        return json_encode($donnee);
    }

    public function getOrdersList() {   //Order datatable manque
        $sql = "SELECT * FROM Order WHERE id = $this->_id";
        $req = mysqli_query($sql) or die('Erreur.'.mysqli_error());
        $donnee = mysqli_fetch_array($req);
        return json_encode($donnee);
    }

    public function getOrder($idAbout) {   //Order datatable manque
        $sql = "SELECT $idAbout FROM Order WHERE id = $this->_id";
        $req = mysqli_query($sql) or die('Erreur.'.mysqli_error());
        $donnee = mysqli_fetch_array($req);
        return json_encode($donnee);
    }

    /* méthodes pour POST */

    public function addProduct($donnees) {     //?

        $db = Database::getInstance();
        $db->insert(Produit, $donnees);
    }

    public function addUser($donnees) {     //?
        $db = Database::getInstance();
        $db->insert(User, $donnees);
    }

    public function addOrder($donnees) {     //?
        $db = Database::getInstance();
        $db->insert(Order, $donnees);
    }


    /* méthodes pour DELETE */

    public function deleteAllProducts() {
        $this->loadFromDB();
        $db = Database::getInstance();
        $db->delete(Produit, $this->data['fkidSupplier']);
    }

    public function deleteProduct($idAbout) {
        $this->loadFromDB();
        $db = Database::getInstance();
        $db->delete(Produit, $idAbout);
    }

    public function deleteAllUsers() {
        $db = Database::getInstance();
        $db->delete(User, $this->_id);
    }

    public function deleteUser($idAbout) {
        $db = Database::getInstance();
        $db->delete(User, $idAbout);
    }

    public function deleteAllOrders() {
        $db = Database::getInstance();
        $db->delete(Order, $this->_id);
    }

    public function deleteOrder($idAbout) {
        $db = Database::getInstance();
        $db->delete(Order, $idAbout);
    }











//    /**Ajouter un client à un fournisseur**/
//    public function addClient($idClient)
//    {
//        $db = Database::insert();
//        //$db->query("SELECT * FROM Supplier WHERE id = ?", ['id', $this->_id]);
//
//    }

//    /* obtenir la liste des utilisateurs client */
//    public function getClientUsersList()
//    {
//        $db = Database::getInstance();
//        $db->query("SELECT * FROM Client");
//
//        $db->resultsToJson();
//    }


//    private $_nom;
//    private $_compagnie;
//    private $_courriel;
//    private $_condition_achat;
//    private $_adresse_facturation;
//    private $_adresse_livraison;
//    private $_logo;
//    private $_nb_commande;
//
//    public function __construct()
//    {
//    }
//
//    public function nouveau_client($nom, $compagnie, $courriel, $condition_achat, $adresse_facturation, $adresse_livraison, $logo, $nb_commande){
//        $this->setNom($nom);
//        $this->setCompagnie($compagnie);
//        $this->setCourriel($courriel);
//        $this->setConditionAchat($condition_achat);
//        $this->setAdresseFacturation($adresse_facturation);
//        $this->setAdresseLivraison($adresse_livraison);
//        $this->setLogo($logo);
//        $this->setNbCommande($nb_commande);
//    }
//// getters
//
//    public function getNom(){
//        return $this->_nom;
//    }
//    public function getCompagnie(){
//        return $this->_compagnie;
//    }
//    public function getCourriel(){
//        return $this->_courriel;
//    }
//    public function getConditionAchat(){
//        return $this->_condition_achat;
//    }
//    public function getAdresseFacturation(){
//        return $this->_adresse_facturation;
//    }
//    public function getAdresseLivraison(){
//        return $this->_adresse_livraison;
//    }
//    public function getLogo(){
//        return $this->_logo;
//    }
//    public function getNbCommande(){
//        return $this->_nb_commande;
//    }
//// setters
//
//    public function setNom($nom){
//     if(isset($nom) && is_string($nom)){
//        $this->_nom= $nom;
//     } else {
//        throw new Exception("Le nom du client saisi n'est pas valide.");
//     }
//    }
//    public function setCompagnie($compagnie){
//        if(isset($compagnie) && is_string($compagnie) ){
//            $this->_compagnie= $compagnie;
//        } else {
//            throw new Exception("Le nom de compagnie saisi n'est pas valide.");
//        }
//    }
//    public function setCourriel($courriel){
//        if(filtrer_var($courriel, FILTER_VALIDATE_EMAIL)) {
//            $this->_courriel = $courriel;
//        } else {
//            throw new Exception("Le courriel saisi n'est pas valide.");
//        }
//    }
//    public function setConditionAchat($condition_achat){
//
//        $this->_condition_achat = $condition_achat;
//    }
//    public function setAdresseFacturation($adresse_facturation){
//        if(adresse_valide()) {
//            $this->_adresse_facturation = $adresse_facturation;
//        } else {
//            throw new Exception("L'adresse de facturation saisi n'est pas valide.");
//        }
//    }
//    public function setAdresseLivraison($adresse_livraison){
//        if(adresse_valide()) {
//            $this->_adresse_livraison = $adresse_livraison;
//        }else {
//            throw new Exception("L'adresse de livraison saisi n'est pas valide.");
//        }
//    }
//
//    public function setLogo($logo){
//        if(isset($logo)) {
//            $this->_logo = $logo;
//        } else {
//            throw new Exception("Le logo n'est pas valide.");
//        }
//    }
//
//    public function setNbCommande($nb_commande){
//        if(is_int($nb_commande)) {
//            $this->_nb_commande = $nb_commande;
//        } else {
//            throw new Exception("Le nombre de commande n'est pas valide.");
//        }
//    }
//    public function adresse_valide(){
//
//    }
//
//    public function create($fields = array())
//    {
//        if (!$this->_db->insert('Client', $fields))
//        {
//            throw new Exception("Il y a eu un probleme empêchant de créer le client");
//        }
//    }
//
//    public function delete($fields = array())
//    {
//        if (!$this->_db->delete('Client', $fields))
//        {
//            throw new Exception("Il y a eu un probleme empêchant de créer le client");
//        }
//    }
//
//    public function update($fields = array())
//    {
//        if (!$this->_db->update('Client', $fields))
//        {
//            throw new Exception("Il y a eu un probleme empêchant de créer le client");
//        }
//    }



}

