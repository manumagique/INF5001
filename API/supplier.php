<?php
/**Jade**/

/**L'URL est de type http....com/API/Fournisseur/1
 * 1 est l'idSupplier
 *
 */

/**GET pour aller chercher sur la base de données**/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idSupplier = $_GET['idSupplier'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Supplier();

    /**L'URL est de type http....com/API/Fournisseur/1/about/idabout
     *
     */
    if($about == "client") {

        /**L'URL est de type http....com/API/Fournisseur/1/Client/
         * Si on n'a pas le idabout, cela veut dire qu'on veut avoir la liste de
         * tous les clients du fournisseur 1.
         */
        if(empty($idAbout)){
            echo $res->getClientList();

        /**L'URL est de type http....com/API/Fournisseur/1/Client/idabout
         * Si on a le idabout, cela veut dire qu'on veut avoir la liste du
         *  client ayant l'id égale à la variable id about .
         */
        } else {
            echo $res->getClient($idAbout);
        }

    } else if($about == "product") {
        /**L'URL est de type http....com/API/Fournisseur/1/Produit/
         * Si on n'a pas le idabout, cela veut dire qu'on veut avoir la liste de
         * tous les produits du fournisseur 1.
         */
        if(empty($idAbout)) {
            echo $res->getProductList();

            /**L'URL est de type http....com/API/Fournisseur/1/Produit/1
             * idabout = 1, signifie qu'on veut avoir le descriptif du
             * produit 1 du fournisseur 1.
             */
        } else {
            echo $res->loadFromDB($idAbout);
        }

    } else if($about == "user") {
        /**L'URL est de type http....com/API/Fournisseur/1/User/
         * Si on n'a pas le idabout, cela veut dire qu'on veut avoir la liste de
         * tous les utilisateurs du fournisseur 1.
         */
        if(empty($idAbout)) {
            echo $res->getUserList();

            /**L'URL est de type http....com/API/Fournisseur/1/User/1
             * idabout = 1, signifie qu'on veut avoir le descriptif de
             * l'utilisateur 1 du fournisseur 1.
             */
        } else {
            echo $res->getUser($idAbout);
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            echo $res->getOrderList();
        } else {
            echo $res->getOrder($idAbout);
        }
    }

//fin de GET





    /**Ajouter**/
} else  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idSupplier = $_POST['idSupplier'];
    $about = $_POST['about'];
    $idAbout = $_POST['idAbout'];

    if($about == "client") {

        /**L'URL est de type http....com/API/Fournisseur/1/Client/
         * Si on n'a pas le idabout, erreur
         */
        if(empty($idAbout)){
            echo "erreur";
        } else {

            $res = new Client();
            $res->addClient($idSupplier);

        }

    } else if($about == "product") {

        if(empty($idAbout)) {
            echo "erreur";
        } else {
            $res = new Product();
            $res->addProduct($idSupplier);
        }

    } else if($about == "user") {

        if(empty($idAbout)) {
            echo "erreur";
        } else {
            $res = new User();
            $res->addUser($idSupplier);
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            echo "erreur";
        } else {
            $res = new Order();
            $res->addOrder($idSupplier);
        }
    }


/**Modifier la base de données**/
/**Fonction update de la database **/
} else  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $idSupplier = $_PUT['idSupplier'];
    $about = $_PUT['about'];
    $idAbout = $_PUT['idAbout'];

    if($about == "client") {

        /**L'URL est de type http....com/API/Fournisseur/1/Client/
         * Si on n'a pas le idabout, c'est un erreur car on ne veut pas
         * modifier tous les clients en même temps
         */
        if(empty($idAbout)){
            echo "erreur, impossible de modifier tous les clients en même temps";
            /**L'URL est de type http....com/API/Fournisseur/1/Client/idabout
             * Si on a le idabout, cela veut dire qu'on modifier les informations
             * d'un client
             */
        } else {
            //On doit recevoir de nouveau array client
            // le valider
            //Le remplacer dans la base de données à la place du $idabout

        }

    } else if($about == "product") {
        /**L'URL est de type http....com/API/Fournisseur/1/Produit/
         * Si on n'a pas le idabout, cela veut dire qu'on veut modifier la liste de
         * tous les produits du fournisseur 1.
         */
        if(empty($idAbout)) {
            echo "erreur, impossible de modifier tous les produits en même temps";

            /**L'URL est de type http....com/API/Fournisseur/1/Produit/1
             * idabout = 1, signifie qu'on veut modifier le descriptif du
             * produit 1 du fournisseur 1.
             */
        } else {
            //On doit recevoir de nouveau array product
            // le valider
            //Le remplacer dans la base de données à la place du $idabout
        }

    } else if($about == "user") {
        /**L'URL est de type http....com/API/Fournisseur/1/User/
         * Si on n'a pas le idabout, cela veut dire qu'on veut modifier la liste de
         * tous les utilisateurs du fournisseur 1.
         */
        if(empty($idAbout)) {
            echo "erreur, impossible de modifier tous les utilisateurs en même temps";

            /**L'URL est de type http....com/API/Fournisseur/1/User/1
             * idabout = 1, signifie qu'on veut modifier le descriptif de
             * l'utilisateur 1 du fournisseur 1.
             */
        } else {
            //On doit recevoir de nouveau array user
            // le valider
            //Le remplacer dans la base de données à la place du $idabout
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            echo "erreur, impossible de modifier toutes les commandes en même temps";
        } else {
            //On doit recevoir de nouveau array user
            // le valider
            //Le remplacer dans la base de données à la place du $idabout
        }
    }


    /**Supprimer**/
    /**Fonction 'delete' de la database**/
}else  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $idSupplier = $_DELETE['idSupplier'];
    $about = $_DELETE['about'];
    $idAbout = $_DELETE['idAbout'];

    if($about == "client") {

        /**L'URL est de type http....com/API/Fournisseur/1/Client/
         * Si on n'a pas le idabout, on veut supprimer tous les clients du fournisseur
         */
        if(empty($idAbout)){
            $res = new Supplier();
            $res->deleteAllClient();
            //Supprimer tous les clients d'un fournisseur
        } else {
            $res = new Supplier();
            $res->deleteClient($idAbout);
            //Supprimer le client $idabout du fournisseur

        }

    } else if($about == "product") {

        if(empty($idAbout)) {
            //Supprimer tous les produits du fournisseur
        } else {
            //Supprimer un produit
        }

    } else if($about == "user") {

        if(empty($idAbout)) {
           //Supprimer tous les utilisateur du fournisseur
        } else {
            //Supprimer l'utilisateur X du fournisseur
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            //Supprimer toutes les commandes du fournisseur
        } else {
            //Supprimer la commande X du fournisseur
        }
    }
}

