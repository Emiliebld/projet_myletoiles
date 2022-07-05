<?php

//..........récupération users........

// Je me connecte à ma base de donnée
$db = new PDO(
 'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles',
 'emiliebillaud',
 'd6b5a481fcd94bf05c57bd0385fa8e5c'
);

// Je prépare ma requête
$query = $db->prepare('SELECT * FROM users'); 

// Je l'exécute
$query->execute();

// Je récupère les données
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// .........creation users............

if(isset($_POST['users'])){
 $create_messages=$db->prepare("INSERT INTO users (username) VALUES (:username)");
 $params = [
  'username' => $_POST['users']
 ];
 $create_messages->execute($params);
}

?>

