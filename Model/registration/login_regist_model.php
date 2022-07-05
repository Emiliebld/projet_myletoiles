<?php
session_start();

if (isset($_POST['email'])){
  $login = new Database();
  $email = htmlentities($_POST['email']);
  $_SESSION['email'] = $email;
  // $password = htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT));
  
  $parameters = [
		'email' => $email,
	];
  $query = $login->prepare ("SELECT * FROM users WHERE email = :email",$parameters,true);
  var_dump($query);
  if(password_verify($_POST['password'] ,$query['password'])){
    $_SESSION['username'] = $email;
    $_SESSION['role_id'] = $query['role_id'];
    if($query['role_id'] === 1){
      header('location: index.php?page=admin');
    } else {
      header('location: index.php');
    }
  } else {
    $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
  }
}
?>

<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>