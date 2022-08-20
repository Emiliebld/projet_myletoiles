<?php


	// Initial session
	session_start();
	// Verify if user is connected, elseif redirection connect page
	if(!isset($_SESSION["users"])){
		header("Location: login.php");
		exit(); 
	}
?>

		<div class="success">
			<ul>
				<h1>Bienvenue <?php echo $_SESSION['users']; ?>!</h1>
				<p>Ceci est votre espace admin.</p>
				<a href="index.php?page=login">Add user</a> | 
				<a href="#">Update user</a> | 
				<a href="#">Delete user</a> | 
				<a href="index.php?page=logout">Déconnexion</a>
			</ul>
		</div>
	</body>
</html>