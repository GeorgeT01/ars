<?php
session_start();
 require_once('dbConfig.php');
$page = "login";
 if (isset($_POST['login'])) {
$email = $connect->escape_string($_POST['email']);
$result = $connect->query("SELECT *FROM users WHERE user_email='$email'");

if ( $result->num_rows == 0 ){ // User doesn't exist
$errorMsg ='<script>swal("User dosent exist!", "", "warning");</script>';
}
else { // User exists
$user = $result->fetch_assoc();
if (password_verify($_POST['password'], $user['user_password']) ) {

$_SESSION['email'] = $user['user_email'];
$_SESSION['fname'] = $user['user_fname'];
$_SESSION['lname'] = $user['user_lname'];
$_SESSION['user_id'] = $user['user_id'];

        $_SESSION['logged_in'] = true;
        header("refresh:0;url=index.php");
    }
    else {
$errorMsg ='<script>swal("Incorrect Password", "", "warning");</script>';
    }
}
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<?php include('head.php'); ?>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('nav-bar.php'); ?>
<form action="" method="POST">
<div class="container mt-5">
<div class="row">
			<div class="col-sm">
		</div>
		<div class="col-sm text-center card mb-5 mt-5 bg-dark text-light form-shadow">
<center><h3>LOGIN</h3></center>
<div class="form-group mt-2">
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">

                        <div class="input-group-addon" style="width: 2.6rem"><i class="fas fa-at"></i></div>

		<input type="email" name="email" required placeholder="Email" class="form-control">
	</div>

	</div>
		<div class="form-group">
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fas fa-lock"></i></div>
		<input type="password" name="password" placeholder="Password" required autocomplete="off" class="form-control">
	</div>
</div>



<center>
	<input type="checkbox" class="mb-2"> Remember me
	   <br>
	<button type="submit" name="login" class="btn btn-primary mb-2 w-50">
		<i class="fas fa-sign-in-alt"></i> Login
	</button><br/>

</center>
<div class="mt-5 mb-2">
Forgot <a href="#" class="">Password?</a>
<br>
Don’t have an account?  <a href="sign-up.php">Sign up</a>
 </div>
	</div>
	<div class="col-sm">
	</div>
</div>
</div>
</form>
<?php
if (isset($errorMsg)) {
	echo $errorMsg;
}
?>


<?php include('footer.php'); ?>
</body>
</html>
