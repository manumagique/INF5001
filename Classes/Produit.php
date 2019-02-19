<?php

/**
 * Author: Valentina Lozneanu
 * Date: Winter 2019
 */


class Produit {
    
    /* proprietes */
    
    private $_nomProduit;
    private $_prix;
    private $_description;
    private $_origine;
    private $_code;
    private $_format;
    private $_logo;
    
    /* constructeur */
    
    public function __construct($nomProduit, $prix, $description, $origine, $code, $format, $logo) {
        
        $this->set_nom($nomProduit);
        $this->set_prix($prix);
        $this->set_description($description);
        $this->set_origine($origine);
        $this->set_code($code);
        $this->set_format($format);
        $this->set_logo($logo);
        
    }
    
    /* getters */
    
    public function get_nom() {
        
        return $this->_nomProduit;
    }
    
    public function get_prix() {
        
        return $this->_prix;
    }
    
    public function get_description() {
        
        return $this->_description;
    }
    
    public function get_origine() {
        
        return $this->_origine;
    }
    
    public function get_code() {
        
        return $this->_code;
    }
    
    public function get_format() {
        
        return $this->_format;
    }
    
    public function get_logo() {
        
        return $this->_logo;
    }
    
    /* setters */
    
    public function set_nom($nom_produit) {
        
        if(is_string($nom_produit)){
            $this->_nomProduit = $nom_produit;
            
        } else {
            throw new Exception("Le nom du produit saisi n'est pas valide.");
        }
        
    }
    
    public function set_prix($prix) {
        
        if (is_numeric($prix) && (double)$prix > 0) {
            
            if (is_int($prix)) {
                $prix = number_format($prix, 2);
            }
            
            $this->_prix = $prix;
            
        } else {
            throw new Exception("Le prix saisi n'est pas valide.");
        }
        
    }
    
    public function set_description($description) {
        
        if(is_string($description)){
            $this->_description = $description;
            
        } else {
            throw new Exception("La description saisie n'est pas valide.");
        }
        
    }
    
    public function set_origine($origine) {
        
        if(origine_valide()) {
            $this->_origine = $origine;
            
        } else {
            throw new Exception("L'origine saisie n'est pas valide.");
        }
        
    }
    
    public function set_code($code) {
        
        if (!preg_match('/[^A-Za-z0-9]/', $code)) {
            $this->_code = $code;
            
        } else {
            throw new Exception("Les codes saisis ne sont pas valides.");
        }
        
    }
    
    public function set_format($format) {
        
        if(format_valide()) {
            $this->_format = $format;
            
        } else {
            throw new Exception("Le format saisi n'est pas valide.");
        }
        
    }
    
    public function set_logo($logo){
        
        if(isset($logo)) {
            $this->_logo = $logo;
            
        } else {
            throw new Exception("Le logo saisi n'est pas valide.");
        }
        
    }
    
    /* methodes de validation */
    
    public function origine_valide() {
        //TODO
    }
    
    public function format_valide() {
        //TODO
    }
    
    /* fonctions de traitement */

    public function create($fields = array())
    {
        if (!$this->_db->insert('Produit', $fields))
        {
            throw new Exception("Il y a eu un probleme empêchant de créer le produit");
        }
    }
    
    public function delete($fields = array())
    {
        if (!$this->_db->delete('Produit', $fields))
        {
            throw new Exception("Il y a eu un probleme empêchant de créer le produit");
        }
    }
    
    public function update($fields = array())
    {
        if (!$this->_db->update('Produit', $fields))
        {
            throw new Exception("Il y a eu un probleme empêchant de créer le produit");
        }
    }
    
}

?>
