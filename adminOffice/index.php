<?php

session_start();


// First time we used AUTOLOAD.
// AUTOLOAD included documents when controller / model instanciation

spl_autoload_register(function($class) {
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';
});


if(array_key_exists('page', $_GET)) :

    switch($_GET['page']) {

        // ------- display formConnect ------- //
        case 'home':
            // We instantiate HomeController, and execute autoloader.
            $controller = new Controllers\HomeController();
            // Call "displayFormConnect()" methode to displaypour home page.
            $controller->displayFormConnect();
        break;

        case 'submitFormLogin':
            $controller = new Controllers\HomeController();
            $controller->submitFormLogin();
        break;
        
        
        case 'accueil':
            $controller = new Controllers\HomeController();
            $controller->displayAccueil();
        break;
        
        case 'users':
            $controller = new Controllers\UsersController();
            $controller->displayAllUsers();
        break;
        
        case 'paint':
            $controller = new Controllers\PaintController();
            $controller->displayAllPaint();
        break;
        
        case 'messages':
            $controller = new Controllers\LivredorController();
            $controller->displayAllComments();
        break;


        default:
            header('location: index.php?page=home');
            exit;
    }

// If root is not present -> redirection to home
else :
    header('Location: index.php?page=home');
    exit;

endif;