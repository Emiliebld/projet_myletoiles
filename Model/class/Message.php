<?php


class Message extends database {
    
    protected function AllMessages()
    {
        /*DESC pour l'affichage des messages en décroissant selon la date*/
            $query = $this->prepare('SELECT * FROM livredor ORDER BY date_paint DESC 
                                    INNER JOIN user ON users.id LIMIT 15');
            return $query;
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