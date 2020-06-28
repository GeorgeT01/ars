<?php 
session_start();
require_once('dbConfig.php');
$page = "profile";
$id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profile</title>
	<?php include('head.php'); ?>
</head>
<body>
<?php include('nav-bar.php'); ?>


<?php include('footer.php'); ?>
</body>
</html>