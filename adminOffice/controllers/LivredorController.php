<?php

namespace Controllers;

class LivredorController {

    // Function by message list
    public function displayAllComments() {
        $model = new \Models\LivredorModel();
        $livredor = $model->getAllComments();

        require_once("views/headerOffice.phtml");
        require_once("views/livredorOffice.phtml");
        require_once("views/footerOffice.phtml");
    }
}
