<?php

/**
 * Author: Valentina Lozneanu
 * Date: Winter 2019
 */

class Produit {
    
    private $_nomProduit;
    private $_prix;
    private $_description;
    private $_origine;
    private $_code;
    private $_format;
    
    
    public function __construct($nomProduit, $prix, $description, $origine, $codes, $format) {
        
        $this->set_nom($nomProduit);
        $this->set_prix($prix);
        $this->set_description($description);
        $this->set_origine($origine);
        $this->set_code($codes);
        $this->set_format($format);
        
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
    
    public function set_code($codes) {
        
        if (preg_match('~^[01]+$~', $codes)) {
            $this->_code = $codes;
            
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
    
    /* methodes de validation */
    
    public function origine_valide() {
        //TODO
    }
    
    public function format_valide() {
        //TODO
    }
    
}

?>
