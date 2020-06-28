<?php
session_start();
require_once('dbConfig.php'); 
$page = "signup";
if(isset($_POST['signup'])){
$_SESSION['email'] = $_POST['email'];
$_SESSION['fname'] = $_POST['fname'];
$_SESSION['lname'] = $_POST['lname'];

$fname = $connect->escape_string($_POST['fname']);
$lname = $connect->escape_string($_POST['lname']);
$email = $connect->escape_string($_POST['email']);
$phone = $connect->escape_string($_POST['phone']);
$password = $connect->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $connect->escape_string( md5( rand(0,1000) ) );

    $d = date("Y-m-d");
    $t =  date("h:i");
      
// Check if user with that email already exists
$result = $connect->query("SELECT * FROM users WHERE user_email='$email'") or die($connect->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
$errorMsg ='<script>swal("User already exist!", "", "warning");</script>';
    
}
else { // Email doesn't already exist in a database, proceed...



    $sql = "INSERT INTO users (user_fname, user_lname, user_email, user_phone, user_password, user_hash, date_signed, time_signed) " 
            . "VALUES ('$fname','$lname', '$email','$phone', '$password', '$hash', '$d','$t')";

    // Add user to the database
    if ( $connect->query($sql) ){
$_SESSION['email'] = $email;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['user_id'] = mysqli_insert_id($connect);

$_SESSION['logged_in'] = true; 
        header("refresh:1;url=index.php");


require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = 'georgealromhen93@gmail.com';
$mail->Password = 'yazan789A';

$mail->setFrom($email, $fname);
$mail->addAddress('georgealromhen93@gmail.com');
$mail->Subject = '';

$body= "New User Signed up";

$mail->Body = $body;

$mail->send();
    }

    else {
$errorMsg ='<script>swal("Somethin went wrong, please try again later!", "", "warning");</script>';
    }


}


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign up</title>
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
	<center><h3> SIGN UP</h3></center>

	    <div class="form-group mt-2">
         <div class="input-group mb-2 mr-sm-2 mb-sm-0">
         <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
<input type="text" name="fname" class="form-control" placeholder="First Name" required autocomplete="off">
              </div>
           </div>           
	                <div class="form-group">    
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
<input type="text" name="lname" class="form-control" placeholder="Last Name" required autocomplete="off">	
	</div>
</div>
		                <div class="form-group">    
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fas fa-at"></i></div>
	<input type="email" name="email" class="form-control" placeholder="Email" required>
	</div>
</div>
			                <div class="form-group">    
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
      <div class="input-group-addon" style="width: 2.6rem"><i class="fas fa-phone"></i></div>
	<input type="number" name="phone" class="form-control" placeholder="Phone Number" required autocomplete="off">
</div>
</div>
				                <div class="form-group">    
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fas fa-lock"></i></div>
<input type="password" name="password" class="form-control" id="password" placeholder="Password" required autocomplete="off">
</div>
</div>
		 <div class="form-group">    
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fas fa-redo"></i></div>
	<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required autocomplete="off">	
</div>
</div>
<style type="text/css">
/* For Firefox */
input[type='number'] {
    -moz-appearance:textfield;
}
/* Webkit browsers Safari and Chrome */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
	 <script>
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
    confirm_password.style.border = "2px solid red";
  } else {
    confirm_password.setCustomValidity('');
    confirm_password.style.border = "";
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
     </script>
<center>
<button type="submit" name="signup" class="btn btn-primary mb-2 w-50">
<i class="fas fa-user-plus"></i> Sign up</button></center>
</div>


<div class="col-sm">
		</div>
</div> <!--card --> 
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