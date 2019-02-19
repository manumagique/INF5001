<?php
/**Jade Pomerleau Gauthier*/

// Essaie lecture Json
//$json = file_get_contents("clientList.json");
//$parsed_json = json_decode($json);
//
//$_nom = $parsed_json->{'name'};
//$_compagnie = $parsed_json->{'compagny'};
//$_courriel = $parsed_json->{'email'};
//$_condition_achat = $parsed_json->{'buy_condition'};
//$_adresse_facturation = $parsed_json->{'rec_adress'};
//$_adresse_livraison = $parsed_json->{'ship_adress'};
//$_logo = $parsed_json->{'logo'};
//$_nb_commande = $parsed_json->{'nb_commande'};


class Client
{
    private $_nom;
    private $_compagnie;
    private $_courriel;
    private $_condition_achat;
    private $_adresse_facturation;
    private $_adresse_livraison;
    private $_logo;
    private $_nb_commande;

    public function __construct()
    {
    }

    public function nouveau_client($nom, $compagnie, $courriel, $condition_achat, $adresse_facturation, $adresse_livraison, $logo, $nb_commande){
        $this->setNom($nom);
        $this->setCompagnie($compagnie);
        $this->setCourriel($courriel);
        $this->setConditionAchat($condition_achat);
        $this->setAdresseFacturation($adresse_facturation);
        $this->setAdresseLivraison($adresse_livraison);
        $this->setLogo($logo);
        $this->setNbCommande($nb_commande);
    }
// getters
    public function getNom(){
        return $this->_nom;
    }
    public function getCompagnie(){
        return $this->_compagnie;
    }
    public function getCourriel(){
        return $this->_courriel;
    }
    public function getConditionAchat(){
        return $this->_condition_achat;
    }
    public function getAdresseFacturation(){
        return $this->_adresse_facturation;
    }
    public function getAdresseLivraison(){
        return $this->_adresse_livraison;
    }
    public function getLogo(){
        return $this->_logo;
    }
    public function getNbCommande(){
        return $this->_nb_commande;
    }
// setters

    public function setNom($nom){
     if(isset($nom) && is_string($nom)){
        $this->_nom= $nom;
     } else {
        throw new Exception("Le nom du client saisi n'est pas valide.");
     }
    }
    public function setCompagnie($compagnie){
        if(isset($compagnie) && is_string($compagnie) ){
            $this->_compagnie= $compagnie;
        } else {
            throw new Exception("Le nom de compagnie saisi n'est pas valide.");
        }
    }
    public function setCourriel($courriel){
        if(filtrer_var($courriel, FILTER_VALIDATE_EMAIL)) {
            $this->_courriel = $courriel;
        } else {
            throw new Exception("Le courriel saisi n'est pas valide.");
        }
    }
    public function setConditionAchat($condition_achat){

        $this->_condition_achat = $condition_achat;
    }
    public function setAdresseFacturation($adresse_facturation){
        if(adresse_valide()) {
            $this->_adresse_facturation = $adresse_facturation;
        } else {
            throw new Exception("L'adresse de facturation saisi n'est pas valide.");
        }
    }
    public function setAdresseLivraison($adresse_livraison){
        if(adresse_valide()) {
            $this->_adresse_livraison = $adresse_livraison;
        }else {
            throw new Exception("L'adresse de livraison saisi n'est pas valide.");
        }
    }

    public function setLogo($logo){
        if(isset($logo)) {
            $this->_logo = $logo;
        } else {
            throw new Exception("Le logo n'est pas valide.");
        }
    }

    public function setNbCommande($nb_commande){
        if(is_int($nb_commande)) {
            $this->_nb_commande = $nb_commande;
        } else {
            throw new Exception("Le nombre de commande n'est pas valide.");
        }
    }
    public function adresse_valide(){

    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('Client', $fields))
        {
            throw new Exception("Il y a eu un probleme empêchant de créer le client");
        }
    }

    public function delete($fields = array())
    {
        if (!$this->_db->delete('Client', $fields))
        {
            throw new Exception("Il y a eu un probleme empêchant de créer le client");
        }
    }

    public function update($fields = array())
    {
        if (!$this->_db->update('Client', $fields))
        {
            throw new Exception("Il y a eu un probleme empêchant de créer le client");
        }
    }



}