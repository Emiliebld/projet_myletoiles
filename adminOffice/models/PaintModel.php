<?php

namespace Models;

// Notre model Users va nous permettre de stocker toutes nos méthodes permettant de réaliser des requêtes
// SQL liées aux utilisateurs
// * Rechercher tous les utilisateurs
// * Rechercher un utilisateur via son id
// * Ajouter un utilisateur
// * Modifier un utilisateur
// * Supprimer un utilisateur
//...

// Notre model extends lui aussi de la Database.

class PaintModel extends Database {

    public function getAllPaint() {
        $req = "SELECT * FROM oeuvres ORDER BY id DESC";
        return $this ->findAll($req);
    }
    
    //public function getUserByEmail($email) {
       
       // return $this ->getOneByEmail("users", $email);
    //}

    // ...
}