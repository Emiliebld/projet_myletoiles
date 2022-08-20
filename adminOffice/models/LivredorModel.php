<?php

namespace Models;

// modelLivredor stock méthodes to realise requêtes
// SQL messages
// * Rechercher tous les utilisateurs
// * search messages
// * Add messages
// * Modif messages
// * Sup messages
//...

// model extends by Database.

class LivredorModel extends Database {

    public function getAllComments() {
        $req = "SELECT * FROM livredor ORDER BY id DESC";
        return $this ->findAll($req);
    }
}