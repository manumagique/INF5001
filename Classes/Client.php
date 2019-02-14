<?php
/**Jade Pomerleau Gauthier*/

class Client
{
    private $_nom;
    private $_courriel;
    private $_condition_achat;
    private $_adresse_facturation;
    private $_adresse_livraison;

    public function nouveau_client($nom, $courriel, $condition_achat, $adresse_facturation, $adresse_livraison ){
        $this->setNom($nom);
        $this->setCourriel($courriel);
        $this->setConditionAchat($condition_achat);
        $this->setAdresseFacturation($adresse_facturation);
        $this->setAdresseLivraison($adresse_livraison);
    }
// getters
    public function getNom(){
        return $this->_nom;
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
// setters

    public function setNom($nom){
        if(is_string($nom)){
            $this->_nom= $nom;
        }
    }
    public function setCourriel($courriel){
        if(filtrer_var($courriel, FILTER_VALIDATE_EMAIL)) {
            $this->_courriel = $courriel;
        }
    }
    public function setConditionAchat($condition_achat){

        $this->_condition_achat = $condition_achat;
    }
    public function setAdresseFacturation($adresse_facturation){
        if(adresse_valide()) {
            $this->_adresse_facturation = $adresse_facturation;
        }
    }
    public function setAdresseLivraison($adresse_livraison){
        if(adresse_valide()) {
            $this->_adresse_livraison = $adresse_livraison;
        }
    }

    public function adresse_valide(){

    }

}