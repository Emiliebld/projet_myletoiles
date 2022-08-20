<?php

namespace Controllers;

class HomeController{
    
    //afficher le formauliare de connection au backoffice
    public function displayFormConnect(){
        require_once("views/headerConnectOffice.phtml");
        require_once("views/loginOffice.phtml");
    }
    
    public function displayAccueil(){
        require_once("views/headerOffice.phtml");
        require_once("views/accueilOffice.phtml");
        require_once("views/footerOffice.phtml");
    }
    
    
    //to acces backoffice, user must be admin :
    public function submitFormLogin(){
        //check form
        //check email exist in database
        //check good password
        //admin number 1

        if (isset($_POST['email'])){
            $model = new \Models\UsersModel();
            $email = htmlentities($_POST['email']);
            $result = $model -> getUserByEmail($email);
  

        if(password_verify($_POST['password'] ,$result['password']) && $result['role_id']==1){
            
            $_SESSION['admin'] = [ 
                                    'id' => $result['id'], 
                                    'userName' => $result['userName'], 
                                    'email' => $result['email']
            ];
    
            header('location: index.php?page=accueil');
            exit();
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrecte!";
        }
    }
}
}