<?php

session_start();
class FormLogin extends FormToDB {
    protected array $userData = [];
    
    protected function getUserData()
    {
        if(isset($this->input['email']['value'])){
            $params = [
                'email' => $this->input['email']['value']
            ];
            $query = $this->prepare('SELECT * FROM users WHERE email = :email',$params,true);
            if(!empty($query)){
                $message = "Réessayez !";
                $this->createError('email', $message);
                $this->createError('password', $message);
            }
            $this->userData = $query;
        }
    }
    
    protected function checkPassword():bool
    {
        if(isset($this->input['password']['value'])){
            $this->getUserData();
            $passwordFromInput = $this->input['password']['value'];
            if(password_verify($passwordFromInput,$this->userData['password'])){
                return true;
            } else {
                $message = "Mot de passe incorrect !";
                $this->createError('email', $message);
                $this->createError('password', $message);
                return false;
            }
        }
        return false;
    }
    protected function getUserRoleName():string
    {
        $params = [
            'id' => $this->userData['id_role']
        ];
        $query = $this->prepare('SELECT name FROM role_users WHERE id = :id',$params, true);
        return $query['name'];
    }
    
    protected function logged()
    {
        $_SESSION['logged'] = true;
        $_SESSION['id_role'] = $this->userData['id_role'];
        $_SESSION['role'] = $this->getUserRoleName();
        $_SESSION['pseudo'] = $this->userData['pseudo'];
    }
    
    protected function checkIfGood():array
    {
        $result = [
            ...Parent::checkIfGood(),
            $this->checkPassword(),
            
        ];
        return $result;
    }
    
    protected function success()
    {
        $this->logged();
        $this->clearData();
        header('Location:index.php');
        exit();
    }
}