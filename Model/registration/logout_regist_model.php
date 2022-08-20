<?php


	// Initialiser la session
	session_start();
	setcookie('pseudo','',time()-10);
	setcookie('date','',time()-10);
	
	// Destroy session.
	session_destroy();
	
		// Redirection connection page
		header("Location: index.php?page=login");
	//exit();

	
?>