<?php


	// Initial  session
	session_start();
	//setcookie('pseudo','',time()-10);
	//setcookie('date','',time()-10);
	
	// Destroy la session.
	session_destroy();
	
		// Redirection to the home page
		header("Location: index.php?page=home");
	//exit();

	
?>