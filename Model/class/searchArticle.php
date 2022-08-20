<?php
//use a Database with Construct
        const DB_DSN = 'mysql:host=db.3wa.io;port=3306;dbname=emiliebillaud_projetMyletoiles;charset=utf8'; // DSN pour PDO
        const DB_USER = 'emiliebillaud'; // User Mysql
        const DB_PASS = 'd6b5a481fcd94bf05c57bd0385fa8e5c'; // password Mysql


        // take what JS sent us
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $search = "%".$data['textToFind']."%"; //  %banane%

        $bdd = new PDO(DB_DSN, DB_USER, DB_PASS); // Ma connexion à la BDD

        $sth = $bdd->prepare('SELECT * FROM oeuvres WHERE title LIKE :find ORDER BY id DESC');
        $sth->bindValue('find', $search, PDO::PARAM_STR); // On protège car le text à recherche vient de l'utilisateur.
        $sth->execute();
        $oeuvres = $sth->fetchAll(PDO::FETCH_ASSOC);

        $numberOfArticles = count($oeuvres); // On en profite pour compter le nombre de résultats

        // Inclure le template qui va générer la partie html qui doit afficher les articles
        include '../../View/search_article.phtml';

        // Notre fichier php retourne le résultat à notre fichier js.
        // Remontez à la ligne 210 du cours. Le fichier js exploite les données et affiche notre template dans la div