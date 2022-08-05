<?php
session_start();

$errors=[];

$db = new PDO(
     'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles',
     'emiliebillaud',
     'd6b5a481fcd94bf05c57bd0385fa8e5c'
);

if(isset($_POST) && !empty($_POST)) {
    

// Vérification du bon remplissage du formulaire
    //if(empty ($_POST["firstname"])){
        //$errors[]="Veuillez remplir votre prénom";
    //}
    if(empty ($_POST["msg"])){
        $errors[]="Veuillez remplir votre message";
    }

    //filter_var permet de s'assurer que le text envoyé est au format email
    //if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        //$errors[] = 'Veuillez renseigner un email valide SVP !';
        
        //si le tableau d'erreur est vide alors on enregistre le message 
        if(count($errors)==0){
            $parameters = [
			'msg' => $_POST["msg"],
			'id' => $_SESSION['id']
			
		];
		
            $list_message = $db->prepare("INSERT INTO livredor(message, users_id)
					                       VALUES (:msg, :id)"); 
            $list_message->execute($parameters);
        }
}

$list_message = $db->prepare('SELECT livredor.message,livredor.date_message,users.id,users.username FROM livredor 
                             INNER JOIN users ON users.id=livredor.users_id ORDER BY date_message DESC LIMIT 10'); 
$list_message->execute();
$livredor = $list_message->fetchAll(PDO::FETCH_ASSOC);



// view
require('./View/header.phtml');
require('./View/gold_book.phtml');
require('./View/footer.phtml');

?>