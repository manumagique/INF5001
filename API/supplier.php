
<?php
/**Jade**/

require_once '../core/init.php';

/**L'URL est de type http....com/API/Fournisseur/1
 * 1 est l'idSupplier
 *
 */

echo "Teste_supplier";

/**GET pour aller chercher sur la base de données**/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idSupplier = $_GET['idSupplier'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Supplier($idSupplier);

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
            echo $res->getProduct($idAbout);
//            echo $res->loadFromDB($idAbout);
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

    $idSupplier = $_GET['idSupplier'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Supplier($idSupplier);

    $data = json_decode(file_get_contents("php://input"));

    if($about == "client") {

        /**L'URL est de type http....com/API/Fournisseur/1/Client/
         * Si on n'a pas le idabout, erreur
         */


            $res->addClient($data);



    } else if($about == "product") {


            $res->addProduct($data);


    } else if($about == "user") {


            $res->addUser($data);


    }else if($about == "order") {

            $res->addOrder($data);

    }


    /**Modifier la base de données**/
    /**Fonction update de la database **/
} else  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $idSupplier = $_GET['idSupplier'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Supplier($idSupplier);

    $data = json_decode(file_get_contents("php://input"));

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
            $res->editClient($data, $idAbout);

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
            $res->editProduct($data, $idAbout);
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
            $res->editUser($data, $idAbout);
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            echo "erreur, impossible de modifier toutes les commandes en même temps";
        } else {
            $res->editOrder($data, $idAbout);
        }
    }


    /**Supprimer**/
    /**Fonction 'delete' de la database**/
}else  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $idSupplier = $_GET['idSupplier'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Supplier($idSupplier);

    if($about == "client") {

        /**L'URL est de type http....com/API/Fournisseur/1/Client/
         * Si on n'a pas le idabout, on veut supprimer tous les clients du fournisseur
         */
        if(empty($idAbout)){
            $res->deleteAllClient();
            //Supprimer tous les clients d'un fournisseur
        } else {
            $res->deleteClient($idAbout);
            //Supprimer le client $idabout du fournisseur

        }

    } else if($about == "product") {

        if(empty($idAbout)) {
            $res->deleteAllProduct();
        } else {
            $res->deleteProduct($idAbout);
        }

    } else if($about == "user") {

        if(empty($idAbout)) {
            $res->deleteAllUser();
        } else {
            $res->deleteUser($idAbout);
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            $res->deleteAllOrder();
        } else {
            $res->deleteOrder($idAbout);
        }
    }
}

