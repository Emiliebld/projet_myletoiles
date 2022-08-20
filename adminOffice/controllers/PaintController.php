<?php

namespace Controllers;

class PaintController {

    // Méthod to do paint list
    public function displayAllPaint() {
        $model = new \Models\PaintModel();
        $oeuvre = $model->getAllPaint();

        require_once("views/headerOffice.phtml");
        require_once("views/PaintOffice.phtml");
        require_once("views/footerOffice.phtml");
    }
}
