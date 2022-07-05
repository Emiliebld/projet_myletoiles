<?php
//..........récupération livre d'or........


// Je me connecte à ma base de donnée
/*$db = new PDO(
 'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles',
 'emiliebillaud',
 'd6b5a481fcd94bf05c57bd0385fa8e5c'
);

// Je prépare ma requête
$query = $db->prepare('SELECT * FROM livredor'); 

// Je l'exécute
$query->execute();

// Je récupère les données
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// .........creation livre d'or............

if(isset($_POST['livredor'])){
 $create_message=$db->prepare("INSERT INTO livredor (msg) VALUES (:msg)");
 $params = [
  'msg' => $_POST['livredor']
 ];
 $create_message->execute($params);
}

//---------------------------------------
//.........liste des messages.......... ????????????????

$db = new PDO(
 'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles',
 'emiliebillaud',
 'd6b5a481fcd94bf05c57bd0385fa8e5c'
);

$list_message = $db->prepare('SELECT * FROM users_id'); 

$list_message->execute();

$result = $list_message->fetchAll(PDO::FETCH_ASSOC);

?>







