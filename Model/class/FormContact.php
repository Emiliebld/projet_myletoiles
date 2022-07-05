<?php


class FormContact extends FormToDB {
    
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
        $input = $this->input;
        $additionnalParams = ['date_message' => date('Y-m-d h-i-s')];
        $params = $this->createParams($additionnalParams);
        $this->prepare('INSERT INTO contact (firstname, email, message, date_message) VALUES (:firstname, :email, :message, :date_message)',$params);
    }
    
    protected function success():string
    {
        $this->addToDB();
        $this->clearData();
        return "Message envoyé avec succès";
    }
}