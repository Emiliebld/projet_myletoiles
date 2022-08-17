<?php

public function verifConnection() {
    
    $errors = [];
    
    if(array_key_exists('email',$_POST)){
        
        $user = [
            'email' =>trim($_POST['email']),
            'password' =>$_POST['password']
            ];
            
        if($user['password'] == '')
            $errors[] = "Veuillez renseigner votre mot de passe!";
            
        if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = "Veuillez renseigner un email valide!";
        
        if(count($errors) == 0){
            $model = new \Models\Results();
            $result = $model->getUserByEmail($user['email']);
            
            if($result !== false && password-verify($user['password'],$result['user_password']))
            
                if($result == false){
                    $errors[] = "Erreur d'identification!";
                }
                
                else if($result['user_valid'] == true){
                    $errors[] = "Identification réussie!"
                }
        }
    }
}
