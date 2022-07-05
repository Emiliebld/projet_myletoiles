<!--requete de la table USERS-->

<?php

$users=new Database();


if (isset($_POST['username'], $_POST['email'], $_POST['type'], $_POST['password'])){
	// récupérer le nom d'utilisateur 
	$username = htmlentities($_POST['username']);
	// récupérer l'email 
	$email = htmlentities($_POST['email']);
	// récupérer le mot de passe 
	$password = htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT));
	// récupérer le type (user | admin)
	$type = htmlentities($_POST['type']);
	
	$paramsVerifEmail = [
		'email' => $_POST['email']
	];
	$checkEmail = $users->prepare('SELECT * FROM users WHERE email = :email',$paramsVerifEmail,true);
	
	if($checkEmail === false){
		$parameters = [
			':username' => $username,
			':email' => $email,
			':type' => $type,
			':password' => $password,
			':date' => date('Y-m-d')
		];
			
	    $query = $users->prepare("INSERT INTO users (username, email, role_id, password, register_date)
					  VALUES (:username, :email, :type, :password, :date)", $parameters);
	
		$result = true;
	
		header('Location: index.php?page=login');
		exit();	
	} else {
		$message = "Mail or password already exist.";
	}
}
?>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>