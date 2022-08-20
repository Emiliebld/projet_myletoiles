<?php


class Article extends database {
    
    protected function AllArticles()
    {
        /*DESC = display paint to date paint*/
            $query = $this->prepare('SELECT * FROM oeuvres ORDER BY date_paint DESC LIMIT 50');
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