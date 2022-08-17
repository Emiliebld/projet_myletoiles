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





        // ------- AFFICHAGE DES DETAILS DE L'ARTICLE SELECTIONNE VIA SON ID ------- //
        case 'detailsOfOneArticle':
            if(array_key_exists('id', $_GET)) {
                $controller = new Controllers\ArticleController();
                $controller->displayArticleById($_GET['id']);
            } else {
                header('location: index.php');
                exit;
            }
        break;


        // ------- AFFICHAGE DU FORMULAIRE D'AJOUT D'UN ARTICLE ------- //
        case 'displayFormAddArticle':
            $controller = new Controllers\ArticleController();
            $controller->displayFormForAddArticle();
        break;


        // ------- SOUMISSION DU FORMULAIRE D'AJOUT D'UN ARTICLE ------- //
        // ------- VERIFICATION + AJOUT DANS LE BDD ou AFFICHAGE DES ERREURS ) ------- //
        case 'submitFormAddArticle':
            $controller = new Controllers\ArticleController();
            $controller->verifAddArticle();
        break;





        // ------- PAGE DES UTILISATEURS: AFFICHE TOUS LES UTILISATEURS ------- //
        case 'users':
            $controller = new Controllers\UsersController();
            $controller->displayAllUsers();
        break;


        // ------- AFFICHAGE DU FORMULAIRE DE CONNEXION ------- //
        case 'connect':
            $controller = new Controllers\UsersController();
            $controller->displayFormConnect();
        break;


        // ------- SOUMISSION DU FORMULAIRE DE CONNEXION ------- //
        case 'submitConnect':
            $controller = new Controllers\UsersController();
            $controller->submitFormConnect();
        break;


        // ------- SI LA ROUTE DANS L'URL N'EST PAS PRESENTE DANS NOTRE SWITCH, REDIRECTION VERS L'ACCUEIL ------- //
        default:
            header('location: index.php?page=home');
            exit;
    }

// ------- SI Y'A PAS DE ROUTE DANS L'URL, ON REDIRIGE VERS L'ACCUEIL DU SITE ------- //
else :
    header('Location: index.php?page=home');
    exit;

endif;