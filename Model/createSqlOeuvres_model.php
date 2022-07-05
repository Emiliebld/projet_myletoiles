<?php
//..........récupération des oeuvres........

// Je me connecte à ma base de donnée
$db = new PDO(
 'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles',
 'emiliebillaud',
 'd6b5a481fcd94bf05c57bd0385fa8e5c'
);

// Je prépare ma requête
$query = $db->prepare('SELECT * FROM oeuvres'); 

// Je l'exécute
$query->execute();

// Je récupère les données
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// .........creation oeuvres............

if(isset($_POST['oeuvres'])){
 $create_oeuvres=$db->prepare("INSERT INTO oeuvres (title) VALUES (:title)");
 $params = [
  'title' => $_POST['oeuvres']
 ];
 $create_oeuvres->execute($params);
}

//---------------------------------------
//.........liste des oeuvres..........

$db = new PDO(
 'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles',
 'emiliebillaud',
 'd6b5a481fcd94bf05c57bd0385fa8e5c'
);

$liste_oeuvres = $db->prepare('SELECT * FROM oeuvres'); 

$liste_oeuvres->execute();

$result = $liste_oeuvres->fetchAll(PDO::FETCH_ASSOC);

// .........creation liste des oeuvres............

if(isset($_POST['oeuvres'])){
 $liste_oeuvres=$db->prepare("INSERT INTO oeuvres (list) VALUES (:list)");
 $params = [
  'list' => $_POST['oeuvres']
 ];
 $liste_oeuvres->execute($params);
}

?>