<?php

$db = new PDO(
 'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles;charset=utf8',
 'emiliebillaud',
 'd6b5a481fcd94bf05c57bd0385fa8e5c'
);
$liste_oeuvres = $db->prepare('SELECT * FROM oeuvres ORDER BY date_paint DESC'); 
$liste_oeuvres->execute();
$oeuvres = $liste_oeuvres->fetchAll(PDO::FETCH_ASSOC);

// view
require('./View/header.phtml');
require('./View/paint_art.phtml');
require('./View/footer.phtml');

?>