<?php

namespace Controllers;

class LivredorController {

    // Méthode permettant d'afficher la liste de tous les utilisateurs
    public function displayAllComments() {
        $model = new \Models\LivredorModel();
        $livredor = $model->getAllComments();

var_dump($livredor);

        require_once("views/headerOffice.phtml");
        require_once("views/livredorOffice.phtml");
        require_once("views/footerOffice.phtml");
    }

    // Méthode permettant d'afficher un utlisateur via son id ( l'id devra être passé en argument )
    public function displaylUserById($id) {
        //...
    }

    // Méthode permettant d'afficher le formulaire de connexion
    public function displayFormConnect() {
        require('config/config.php');
        $template = "connect.phtml";
        include_once 'views/layout.phtml';
    }

    // Méthode permettant de soumettre le formulaire de connexion à la vérification
    public function submitFormConnect() {
        // Vérification du remplissage du formulaire ( aucun champ vide )
        // Vérifier la correspondance avec la BDD ( email et MDP avec password_hash )

        // Si les identifiants sont bons, création du $_SESSION et header("Location: index.php"); exit();
        // Si le formulaire n'est pas bien rempli ( champ vide ) et pas les bons identifiants :
            // Affichez le ou les messages d'erreurs.
        var_dump("Vérification du formulaire à réaliser !"); die;
    }

    //...
}
