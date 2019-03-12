<?php

/**
 * Author: Valentina Lozneanu
 * Date: Winter 2019
 */


class Product {

    private $_id;


    public function __construct($id)
    {
        $this->_id = $id;
    }

    /**Retourne l'information d'un produit**/
    public function loadFromDB ()
    {
        $db = Database::getInstance();
        $db->query("SELECT * FROM Product WHERE id = ?", ['id', $this->_id]);
    }

    /**Ajouter un produit à un fournisseur**/
    public function addProduct($idSupplier)
    {
        $db = Database::insert();
        //$db->query("SELECT * FROM Supplier WHERE id = ?", ['id', $this->_id]);

    }

    public function updateProduct($id) {

    }

    public function compareProduct($id) {

    }

    public function deleteProduct($id) {

    }


//    /* proprietes */
//
//    private $_db;
//    private $_data;
//
//    private $_idSupplier;
//    private $_idProduit;
//    private $_nom;
//    private $_prix;
//    private $_description;
//    private $_origine;
//    private $_code;
//    private $_format;
//    private $_logo;
//
//    /* constructeur */
//
//    public function __construct($idProduit = null)
//    {
//        $this->_db = Database::getInstance();
//        if ($idProduit)
//        {
//            $this->loadFromDb($idProduit);
//        }
//    }
//
//    private function loadFromDb($idProduit)
//    {
//
//        if($this->_db->query('SELECT * FROM Produit WHERE idProduit = ?', array($idProduit)))
//        {
//            $this->_idProduit = $idProduit;
//            $this->_data = $this->_db->results()[0];
//
//            $this->_nom = $this->_data->nom ;
//            $this->_prix = $this->_data->prix ;
//            $this->_description = $this->_data->description ;
//            $this->_origine = $this->_data->origine ;
//            $this->_code = $this->_data->code ;
//            $this->_format = $this->_data->format ;
//            $this->_fkidSupplier = $this->_data->fkidSupplier ;
//        }
//    }
//
//    public function save()
//    {
//        if ($this->_idProduit)
//        {
//            $this->_db->update('Produit', $this->_idProduit,
//                array( 'nom' => $this->get_nom().'updated'
//                ));
//        }
//    }
//
//    public function updateCHeck()
//    {
//        $obj =array($this);
//        $keys = array_keys($obj);
//        $changedFIeld = array();
//        foreach ($keys as $key => $field) {
//            if ($this.'->_'.$field != $this->_data.'->$field')
//            {
//                array_push($changedFIeld, $field);
//            }
//        }
//        return $changedFIeld;
//    }
//
//
//    /* getters */
//
//
//    public function get_nom() {
//
//        return $this->_nom;
//    }
//
//    public function get_prix() {
//
//        return $this->_prix;
//    }
//
//    public function get_description() {
//
//        return $this->_description;
//    }
//
//    public function get_origine() {
//
//        return $this->_origine;
//    }
//
//    public function get_code() {
//
//        return $this->_code;
//    }
//
//    public function get_format() {
//
//        return $this->_format;
//    }
//
//    public function get_logo() {
//
//        return $this->_logo;
//    }
//
//    /* setters */
//
//    public function set_nom($nom_produit) {
//
//        if(is_string($nom_produit)){
//            $this->_nom = $nom_produit;
//
//        } else {
//            throw new Exception("Le nom du produit saisi n'est pas valide.");
//        }
//
//    }
//
//    public function set_prix($prix) {
//
//        if (is_numeric($prix) && (double)$prix > 0) {
//
//            if (is_int($prix)) {
//                $prix = number_format($prix, 2);
//            }
//
//            $this->_prix = $prix;
//
//        } else {
//            throw new Exception("Le prix saisi n'est pas valide.");
//        }
//
//    }
//
//    public function set_description($description) {
//
//        if(is_string($description)){
//            $this->_description = $description;
//
//        } else {
//            throw new Exception("La description saisie n'est pas valide.");
//        }
//
//    }
//
//    public function set_origine($origine) {
//
//        if(origine_valide()) {
//            $this->_origine = $origine;
//
//        } else {
//            throw new Exception("L'origine saisie n'est pas valide.");
//        }
//
//    }
//
//    public function set_code($code) {
//
//        if (!preg_match('/[^A-Za-z0-9]/', $code)) {
//            $this->_code = $code;
//
//        } else {
//            throw new Exception("Les codes saisis ne sont pas valides.");
//        }
//
//    }
//
//    public function set_format($format) {
//
//        if(format_valide()) {
//            $this->_format = $format;
//
//        } else {
//            throw new Exception("Le format saisi n'est pas valide.");
//        }
//
//    }
//
//    public function set_logo($logo){
//
//        if(isset($logo)) {
//            $this->_logo = $logo;
//
//        } else {
//            throw new Exception("Le logo saisi n'est pas valide.");
//        }
//
//    }
//
//    public function setIdSupplier($idSupplier)
//    {
//        $this->_idSupplier = $idSupplier;
//    }
//
//    /* methodes de validation */
//
//    public function origine_valide() {
//        //TODO
//    }
//
//    public function format_valide() {
//        //TODO
//    }
//
//    /* fonctions de traitement */
//
//    public function create($fields = array())
//    {
//        if (!$this->_db->insert('Produit', $fields))
//        {
//            throw new Exception("Il y a eu un probleme empêchant de créer le produit");
//        }
//    }
//
//    public function delete($fields = array())
//    {
//        if (!$this->_db->delete('Produit', $fields))
//        {
//            throw new Exception("Il y a eu un probleme empêchant de créer le produit");
//        }
//    }
//
//    public function update($fields = array())
//    {
//        if (!$this->_db->update('Produit', $fields))
//        {
//            throw new Exception("Il y a eu un probleme empêchant de créer le produit");
//        }
//    }

}

?>
