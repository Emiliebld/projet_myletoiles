<?php

$users=new Database();
$result='';

if (isset($_POST['username'], $_POST['email'], $_POST['type'], $_POST['password'])){
	// take username
	$username = htmlentities($_POST['username']);
	// take email 
	$email = htmlentities($_POST['email']);
	// take password
	$password = htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT));
	// take type (user | admin)
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
	
		$result = 'Votre compte a bien été créé, vous pouvez vous connecter!';
	
		//header('Location: index.php?page=login');
		//exit();	
		
	} else {
		$message = "Votre email ou mot de passe existe déjà!";
	}
}
?>

<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>