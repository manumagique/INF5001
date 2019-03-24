<?php
/**Jade Pomerleau Gauthier*/

/**
 * Author: Valentina
 * Date: Winter 2019
 */

class Client
{
    private $_id;

    public function __construct($id)
    {
        $this->_id = $id;
    }

    /* méthodes pour GET */

    public function getClientDetails() {

        $db = Database::getInstance();
        $db->query("SELECT * FROM Client WHERE idClient = ?", array($this->_id));
        return $db->resultsToJson();

    }

    public function getProductsList() {

        $db = Database::getInstance();
        $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));

        $_data = $db->results();
        foreach ($_data as $row)
        {
            $clientSupplier = $row->fkidSupplier;
        }

        $db->query("SELECT * FROM Product WHERE fkidSupplier = ?", array($clientSupplier));

        return $db->resultsToJson();

    }

    public function getProductDetails($idAbout) {

        $db = Database::getInstance();
        $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));

        $_data = $db->results();
        foreach ($_data as $row)
        {
            $clientSupplier = $row->fkidSupplier;
        }

        $db->query("SELECT * FROM Product WHERE fkidSupplier = ? AND idProduct = ?", array($clientSupplier, $idAbout));
        return $db->resultsToJson();

    }

    public function getUsersList() {

        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidClient = ?", array($this->_id));
        return $db->resultsToJson();

    }

    public function getUser($idAbout) {

        $db = Database::getInstance();
        $db->query("SELECT username FROM User WHERE fkidClient = ? AND id = ?", array($this->_id, $idAbout));
        return $db->resultsToJson();

    }

    public function getOrdersList() {

        $db = Database::getInstance();
        $db->query("SELECT * FROM ClientOrder WHERE fkidClient = ? ", array($this->_id));
        return $db->resultsToJson();

    }

    public function getOrder($idAbout) {

        $db = Database::getInstance();
        $db->query("SELECT * FROM ClientOrder WHERE fkidClient = ? AND id = ?", array($this->_id, $idAbout));
        return $db->resultsToJson();

    }

    /* méthodes pour POST */

    public function addProduct($data) {     //pertinence

        $db = Database::getInstance();

        $fields = array(
            'nom' => $data->name,
            'prix' => $data->price,
            'description' => $data->description,
            'origine' => $data->origine,
            'code' => $data->code,
            'format' => $data->format,
            'fkidSupplier' => $data->fkidSuppier,
            'logo' => $data ->logo
        );

        $db->insert(Product, $fields);

    }

    public function addUser($data) {

        $db = Database::getInstance();

        $fields = array(
            'username' => $data->username,
            'password' => $data ->password,
            'userCat' => $data->userCat,
            'fkidClient' => $this->_id,
            'fkidSupplier' => $data->fkidSupplier
        );

        $db->insert(User, $fields);

    }

    public function addOrder($data) {

        $db = Database::getInstance();

        $fields = array(
            'date' => $data->date,
            'user' => $data ->user,
            'commentaire' => $data ->commentaire,
            'status' => $data ->status,
            'fkidClient' => $this->_id,
            'fkidSupplier' => $data ->fkidSupplier
        );

        $db->insert(ClientOrder, $fields);

    }

    /* méthodes pour PUT */

    public function updateProduct($data, $idAbout) {    //pertinence

        $db = Database::getInstance();

        $fields = array(
            'nom' => $data->name,
            'prix' => $data->price,
            'description' => $data->description,
            'origine' => $data->origine,
            'code' => $data->code,
            'format' => $data->format,
            'fkidSupplier' => $data->fkidSuppier,
            'logo' => $data ->logo
        );

        $db->query("UPDATE Product SET $fields WHERE idProduct = ?", array($idAbout));

    }

    public function updateUser($data, $idAbout) {

        $db = Database::getInstance();

        $fields = array(
            'username' => $data->username,
            'password' => $data ->password,
            'userCat' => $data->userCat,
            'fkidClient' => $this->_id,
            'fkidSupplier' => $data->fkidSupplier
        );

        $db->query("UPDATE User SET $fields WHERE id = ?", array($idAbout));

    }

    public function updateOrder($data, $idAbout) {

        $db = Database::getInstance();

        $fields = array(
            'date' => $data->date,
            'user' => $data ->user,
            'commentaire' => $data ->commentaire,
            'status' => $data ->status,
            'fkidClient' => $this->_id,
            'fkidSupplier' => $data ->fkidSupplier
        );

        $db->query("UPDATE ClientOrder SET $fields WHERE id = ?", array($idAbout));

    }


    /* méthodes pour DELETE */

    public function deleteAllProducts() {

        $db = Database::getInstance();

        $clientSupplier = $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));
        $db->query("DELETE FROM Product WHERE fkidSupplier = ? ", array($clientSupplier));

    }

    public function deleteProduct($idAbout) {

        $db = Database::getInstance();
        $clientSupplier = $db->query("SELECT fkidSupplier FROM Client WHERE idClient = ?", array($this->_id));
        $db->query("DELETE FROM Product WHERE fkidSupplier = ? AND idProduct = ?", array($clientSupplier, $idAbout));

    }

    public function deleteAllUsers() {

        $db = Database::getInstance();
        $db->query("DELETE FROM User WHERE fkidClient = ? ", array($this->_id));

    }

    public function deleteUser($idAbout) {

        $db = Database::getInstance();
        $db->query("DELETE FROM User WHERE fkidClient = ? AND id = ? ", array($this->_id, $idAbout));

    }

    public function deleteAllOrders() {

        $db = Database::getInstance();
        $db->query("DELETE FROM ClientOrder WHERE fkidClient = ? ", array($this->_id));

    }

    public function deleteOrder($idAbout) {

        $db = Database::getInstance();
        $db->query("DELETE FROM ClientOrder WHERE fkidClient = ? AND id = ? ", array($this->_id, $idAbout));

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

