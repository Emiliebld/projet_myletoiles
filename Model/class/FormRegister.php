<?php


class FormRegister extends FormToDB {
    protected function EmailIsUse():bool
    {
        if(isset($this->input['email']['value'])){
            $params = [
                'email' => $this->input['email']['value']
            ];
            $query = $this->prepare('SELECT email FROM users WHERE email = :email',$params);
            if(!empty($query)){
                $message = 'Vous avez deja un compte chez nous !';
                $this->createError('email', $message);
            }
            return !empty($query);
        }
        return true;
    }
    
    protected function getIdRole(?string $role='user'):int
    {
        $params = [
            'name' => $role
        ];
        $query = $this->prepare('SELECT id FROM role_users WHERE name = :name',$params, true);
        return $query['id'];
    }
    
    protected function addToDB()
    {
        $additionnalParams = [
            'register_date' => date('Y-m-d h-i-s'),
            'id_role' => $this->getIdRole()
        ];
        $params = $this->createParams($additionnalParams);
        $this->prepare('INSERT INTO users (pseudo, id_role, email, password, register_date) VALUES (:pseudo, :id_role, :email, :password, :register_date)',$params);
    }
    
    protected function checkIfGood():array
    {
        $result = [
            ...Parent::checkIfGood(),
            !$this->EmailIsUse()
        ];
        return $result;
    }
    
    protected function success()
    {
        $this->addToDB();
        $this->clearData();
        return "Formulaire envoyé avec succès";
        
    }
}