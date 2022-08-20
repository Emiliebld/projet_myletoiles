<?php

namespace Controllers;

class UsersController {

    // Function by methode list
    public function displayAllUsers() {
        $model = new \Models\UsersModel();
        $users = $model->getAllUsers();

        require_once("views/headerOffice.phtml");
        require_once("views/usersOffice.phtml");
        require_once("views/footerOffice.phtml");
    }
}
