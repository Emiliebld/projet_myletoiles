<?php

session_start();


// Dans un premier temps, on va utiliser un AUTOLOAD.
// L'autoloader va inclure automatiquement les fichiers dès l'instant où l'on instancie un controller / model
// Par exemple, dès que vous allez écrire : $controller = new Controllers\HomeController();
// L'autoloader va alors générer la phrase suivante et l'exécuter : require_once 'controllers/HomeController.php';
spl_autoload_register(function($class) {
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';
});

// Ainsi, nous n'aurons plus à nous préocuper des fichiers à requérir, notre autoload le fait pour nous !

if(array_key_exists('page', $_GET)) :

    switch($_GET['page']) {

        // ------- AFFICHAGE DE LA PAGE D'ACCUEIL DE NOTRE SITE AVEC LE FORM ------- //
        case 'home':
            // On va instancier notre HomeController et pas conséquent, notre autoloader s'exécute.
            $controller = new Controllers\HomeController();
            // Appel de notre méthode "displayFormConnect()" pour afficher la page d'accueil avec tous les articles.
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