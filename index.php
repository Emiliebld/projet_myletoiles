<!--index.php est le seul et unique point d'entrée de notre site web-->

<?php
//session_start();

spl_autoload_register(function($class) {
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';
});

if(isset($_GET['page'])){
    if($_GET['page'] === 'home'){
        require('Controller/home_controller.php');
    } 
    
    else if($_GET['page'] === 'presentation'){
        require('Controller/presentation_controller.php');
    } 
    
    else if($_GET['page'] === 'paint_art'){
        require('Controller/paintArt_controller.php');
    } 
    
    else if($_GET['page'] === 'gold_book'){
        require('Controller/goldBook_controller.php');
    }
    
    else if($_GET['page'] === 'admin'){
        require('Controller/admin_controller.php');
    }
    
    else if($_GET['page'] === 'register'){
        require('Controller/register_regist_controller.php');
    }
    
    else if($_GET['page'] === 'login'){
        require('Controller/login_regist_controller.php');
    }
    
    else if($_GET['page'] === 'logout'){
        require('Controller/logout_regist_controller.php');
    }
    
    else if($_GET['page'] === 'submitForm'){
        require('Controller/goldBook_controller.php');
    }
    else if($_GET['page'] === 'submitFormLogin'){
        require('Controller/login_regist_controller.php');
    }
    else {
        
    } 
    
    
    
} else {
    require('Controller/home_controller.php');
}

?>