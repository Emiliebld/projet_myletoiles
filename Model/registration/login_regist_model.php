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
  
  if(password_verify($_POST['password'] ,$query['password'])){
    $_SESSION['username'] = $query['username'];
    $_SESSION['role_id'] = $query['role_id'];
    $_SESSION['logged']=true;
    $_SESSION['id']=$query['id'];
    
      header('location: index.php?page=home');
      exit();
  } else {
    $message = "Username or Password is incorrect.";
  }
}
?>

<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>