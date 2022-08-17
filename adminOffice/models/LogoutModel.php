<?php


	// Initialiser la session
	session_start();
	//setcookie('pseudo','',time()-10);
	//setcookie('date','',time()-10);
	
	// Détruire la session.
	session_destroy();
	
		// Redirection vers la page de connexion
		header("Location: index.php?page=home");
	//exit();

	
?>