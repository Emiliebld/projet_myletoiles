<?php

namespace Models;

// model extend by Database.

class PaintModel extends Database {

    public function getAllPaint() {
        $req = "SELECT * FROM oeuvres ORDER BY id DESC";
        return $this ->findAll($req);
    }
}