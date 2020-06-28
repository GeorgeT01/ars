<?php 
session_start();
require_once('dbConfig.php');
$page = "contact";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profile</title>
	<?php include('head.php'); ?>
</head>
<body>
<?php include('nav-bar.php'); ?>

<div class="container mt-5">
	<center><h1>Contact Us</h1></center>
<div class="row mt-3">

<div class="col-sm-3"></div>	
<div class="col-sm-2">Email Address</div>	
<div class="col-sm-4"><input type="email" name="email" class="form-control" required></div>	
<div class="col-sm-3"></div>
</div>	

<div class="row mt-5">
<div class="col-sm-3"></div>	
<div class="col-sm-2">Full Name</div>	
<div class="col-sm-4"><input type="text" name="name" class="form-control" required></div>	
<div class="col-sm-3"></div>
</div>	

<div class="row mt-5">
<div class="col-sm-3"></div>	
<div class="col-sm-2">Message</div>	
<div class="col-sm-4"><textarea class="form-control" name="msg" required rows="4"></textarea></div>	
<div class="col-sm-3"></div>
</div>	
<div class="row mt-5">
<div class="col-sm-3"></div>	
<div class="col-sm-2"></div>	
<div class="col-sm-4"><button class="btn btn-primary w-100">Send</button></div>	
<div class="col-sm-3"></div>
</div>	


</div>





<?php include('footer.php'); ?>
</body>
</html>
