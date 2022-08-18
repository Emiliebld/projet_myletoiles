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
    
    
    //pour accéder au backoffice la personne doit etre admin :
    public function submitFormLogin(){
        //vérifier que le formulaire soit bien rempli
        //vérifier que le mail existe dans la base de données
        //vérifier que le MDP soit bon 
        //admin numéri 1

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