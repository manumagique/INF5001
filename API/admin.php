
<?php
/**Jade**/

require_once '../core/init.php';
header('Content-Type: application/json');

/**L'URL est de type http....com/API/admin/1
 * 1 est l'idSupplier
 *
 */



/**GET pour aller chercher sur la base de données**/
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $idAdmin = $_GET['idAdmin'];
    $about = $_GET['about'];
    $idAbout = $_GET['idAbout'];
    $res = new Admin($idAdmin);

    /**L'URL est de type http....com/API/admin/1/about/idabout
     *
     */
    if($about == "client") {

        /**L'URL est de type http....com/API/admin/1/Client/
         * Si on n'a pas le idabout, cela veut dire qu'on veut avoir la liste de
         * tous les clients .
         */
        if (empty($idAbout)) {
            echo $res->getClientList();

            /**L'URL est de type http....com/API/admin/1/Client/idabout
             * Si on a le idabout, cela veut dire qu'on veut avoir la liste du
             *  client ayant l'id égale à la variable id about .
             */
        } else {
            echo $res->getClient($idAbout);
        }

    } else if($about == "supplier") {
            /**L'URL est de type http....com/API/admin/1/supplier/
             * Si on n'a pas le idabout, cela veut dire qu'on veut avoir la liste de
             * tous les produits du fournisseur 1.
             */
            if(empty($idAbout)) {
                echo $res->getSupplierList();

                /**L'URL est de type http....com/API/admin/1/supplier/1
                 * idabout = 1, signifie qu'on veut avoir le descriptif du
                 * produit 1 du fournisseur 1.
                 */
            } else {
                echo $res->getSupplier($idAbout);
            }
    } else if($about == "product") {
        /**L'URL est de type http....com/API/admin/1/Produit/
         * Si on n'a pas le idabout, cela veut dire qu'on veut avoir la liste de
         * tous les produits.
         */
        if(empty($idAbout)) {
            echo $res->getProductList();

            /**L'URL est de type http....com/API/admin/1/Produit/1
             * idabout = 1, signifie qu'on veut avoir le descriptif du
             * produit 1 du fournisseur 1.
             */
        } else {
            echo $res->getProduct($idAbout);
//            echo $res->loadFromDB($idAbout);
        }

    } else if($about == "user") {
        /**L'URL est de type http....com/API/admin/1/User/
         * Si on n'a pas le idabout, cela veut dire qu'on veut avoir la liste de
         * tous les utilisateurs.
         */
        if(empty($idAbout)) {
            echo $res->getUserList();

            /**L'URL est de type http....com/API/admin/1/User/1
             * idabout = 1, signifie qu'on veut avoir le descriptif de
             * l'utilisateur 1.
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

    $idAdmin = $_POST['idAdmin'];
    $about = $_POST['about'];
    $idAbout = $_POST['idAbout'];
    $res = new Admin($idAdmin);

    $data = json_decode(file_get_contents("php://input"));

    if($about == "client") {

        /**L'URL est de type http....com/API/admin/1/Client/
         * Si on n'a pas le idabout, erreur
         */
        if(empty($idAbout)){
            echo "erreur";
        } else {

            $res->addClient($data);

        }

    } else if($about == "supplier") {

        if(empty($idAbout)) {
            echo "erreur";
        } else {
            $res->addSupplier($data);
        }

    } else if($about == "product") {

        if(empty($idAbout)) {
            echo "erreur";
        } else {
            $res->addProduct($data);
        }

    } else if($about == "user") {

        if(empty($idAbout)) {
            echo "erreur";
        } else {
            $res->addUser($data);
        }

    }else if($about == "order") {

        if(empty($idAbout)) {
            echo "erreur";
        } else {
            $res->addOrder($data);
        }
    }


    /**Modifier la base de données**/
    /**Fonction update de la database **/
} else  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $idAdmin = $_PUT['idAdmin'];
    $about = $_PUT['about'];
    $idAbout = $_PUT['idAbout'];
    $res = new Admin($idAdmin);

    $data = json_decode(file_get_contents("php://input"));

    if($about == "client") {

        /**L'URL est de type http....com/API/admin/1/Client/
         * Si on n'a pas le idabout, c'est un erreur car on ne veut pas
         * modifier tous les clients en même temps
         */
        if(empty($idAbout)){
            echo "erreur, impossible de modifier tous les clients en même temps";
            /**L'URL est de type http....com/API/admin/1/Client/idabout
             * Si on a le idabout, cela veut dire qu'on modifier les informations
             * d'un client
             */
        } else {
            $res->editClient($data, $idAbout);

        }

    } else if($about == "supplier") {
        /**L'URL est de type http....com/API/admin/1/supplier/
         * Si on n'a pas le idabout, cela veut dire qu'on veut modifier la liste de
         * tous les produits.
         */
        if(empty($idAbout)) {
            echo "erreur, impossible de modifier tous les fournisseurs en même temps";

            /**L'URL est de type http....com/API/admin/1/supplier/1
             * idabout = 1, signifie qu'on veut modifier le descriptif du
             * produit 1.
             */
        } else {
            $res->editSupplier($data, $idAbout);
        }

    } else if($about == "product") {
        /**L'URL est de type http....com/API/admin/1/Produit/
         * Si on n'a pas le idabout, cela veut dire qu'on veut modifier la liste de
         * tous les produits.
         */
        if(empty($idAbout)) {
            echo "erreur, impossible de modifier tous les produits en même temps";

            /**L'URL est de type http....com/API/admin/1/Produit/1
             * idabout = 1, signifie qu'on veut modifier le descriptif du
             * produit 1.
             */
        } else {
            $res->editProduct($data, $idAbout);
        }

    } else if($about == "user") {
        /**L'URL est de type http....com/API/admin/1/User/
         * Si on n'a pas le idabout, cela veut dire qu'on veut modifier la liste de
         * tous les utilisateurs du fournisseur 1.
         */
        if(empty($idAbout)) {
            echo "erreur, impossible de modifier tous les utilisateurs en même temps";

            /**L'URL est de type http....com/API/admin/1/User/1
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

    $idAdmin = $_DELETE['idAdmin'];
    $about = $_DELETE['about'];
    $idAbout = $_DELETE['idAbout'];
    $res = new Admin($idAdmin);

    if($about == "client") {


        if(!empty($idAbout)){
            $res->deleteClient($idAbout);
        }

    } else if($about == "supplier") {

        if(!empty($idAbout)) {
           $res->deleteSupplier();
        }

    } else if($about == "product") {

        if(!empty($idAbout)) {
            $res->deleteProduct();
        }

    } else if($about == "user") {

        if(!empty($idAbout)) {
           $res->deleteUser();
        }

    }else if($about == "order") {

        if(!empty($idAbout)) {
            $res->deleteOrder();
        }
    }
}

