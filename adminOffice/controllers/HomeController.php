<?php

namespace Controllers;

class HomeController{
    
    //afficher le formauliare de connection au backoffice
    public function displayFormConnect(){
        require_once("views/headerOffice.phtml");
        require_once("views/loginOffice.phtml");
        require_once("views/footerOffice.phtml");
    }
    //pour accéder au backoffice la personne doit etre admin :
    public function submitFormLogin(){
        //vérifier que le formulaire soit bien rempli
        //vérifier que le mail existe dans la base de données
        //vérifier que le MDP soit bon 
        //admin numéri 1
        if (isset($_POST['email'])){
            $login = new Database();
            $email = htmlentities($_POST['email']);
            $_SESSION['email'] = $email;
            $password = htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT));
  
            $parameters = [
		            'email' => $email,
	            ];
            $query = $login->prepare ("SELECT * FROM users WHERE email = :email",$parameters,true);
  

        if(password_verify($_POST['password'] ,$query['password'])){
            $_SESSION['username'] = $query['username'];
            $_SESSION['role_id'] = $query['role_id'];
            $_SESSION['logged']=true;
            $_SESSION['id']=$query['id'];
    
            header('location: index.php?page=home');
            exit();
        } else {
            $message = "Username or Password is incorrect.";
        }
    }
}
}