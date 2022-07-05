<?php


	// Initialiser la session
	session_start();
	// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
		exit(); 
	}
?>

		<div class="sucess">
			<h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
			<p>Ceci est votre espace admin.</p>
			<a href="index.php?page=login">Add user</a> | 
			<a href="#">Update user</a> | 
			<a href="#">Delete user</a> | 
			<a href="index.php?page=logout">Déconnexion</a>
		</ul>
		</div>
	</body>
</html>