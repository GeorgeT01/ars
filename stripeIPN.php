<?php
session_start();
require_once"config.php";
require_once('dbConfig.php'); 
error_reporting(0);

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];

if (isset($_POST['stripeToken'])){

// Charge the user's card:
$charge = \Stripe\Charge::create(array(
  "amount" =>$_SESSION['price']."00",
  "currency" => "usd",
  "description" => "Example charge",
  "source" => $token,
));

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) {
$user_id = $_SESSION['user_id'];
}
else{
 $user_id = 0;
}


$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = date("Y-m-d");
$time = date("h:i:sa");

// two flights
if ($_SESSION['twoflights'] == true) {

$passenger_query = "INSERT INTO passenger(fname, lname, email, phone, birth_date, user_id) 
VALUES ('$fname', '$lname', '$email', '$phone', '$dob', '$user_id')"; 
$passenger_res = mysqli_query($connect, $passenger_query);
$pas_id = mysqli_insert_id($connect); // last id inserted for passenger


  // insert in reservation table
$reservation_query = "insert into reservation(flight_number, passenger_id, num_passengers, res_date, res_time)
values('".$_SESSION['flight1']."','".$pas_id."','".$_SESSION['num_passengers']."','".$date."','".$time."')";
$reservation_result = mysqli_query($connect, $reservation_query);

$res_id1 = mysqli_insert_id($connect);


foreach ($_SESSION['seat1'] as $value) {
 $seat_query1 = "INSERT INTO seat_reservation(res_id, seat_id)
 VALUES ('$res_id1', '$value')";

 $seat_res = mysqli_query($connect, $seat_query1);

$change_query = "update seats set statement = 'Unavailable' where seat_id = '".$value."' ";
$change_result = mysqli_query($connect, $change_query);

}// foreach loop


$reservation_query2 = "insert into reservation(flight_number, passenger_id, num_passengers, res_date, res_time)
values('".$_SESSION['flight2']."','".$pas_id."','".$_SESSION['num_passengers']."','".$date."','".$time."')";
$reservation_result2 = mysqli_query($connect, $reservation_query2) or trigger_error(mysqli_error()." ".$reservation_query2);


$res_id2 = mysqli_insert_id($connect);

foreach ($_SESSION['seat2'] as $value2) {
 $seat_query2 = "INSERT INTO seat_reservation(res_id, seat_id)
 VALUES ('$res_id2', '$value2')";
 $seat_res2 = mysqli_query($connect, $seat_query2);
$change_query2 = "update seats set statement = 'Unavailable' where seat_id = '".$value2."' ";
$change_result2 = mysqli_query($connect, $change_query2);

}// foreach loop

$payment_query = "insert into payment(passenger_id, amount) 
values('".$pas_id."', '".$_SESSION['price']."' )";
$payment_result = mysqli_query($connect, $payment_query);

if ($payment_result && $change_result2 && $seat_res2 && $reservation_result2 && $passenger_res && $change_result && $seat_res && $reservation_result) {

$select = "SELECT *FROM reservation 

INNER JOIN passenger ON reservation.passenger_id = passenger.passenger_id 

INNER JOIN seat_reservation ON reservation.res_id = seat_reservation.res_id 

INNER JOIN flights ON reservation.flight_number = flights.flight_number

INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number 

INNER JOIN seats ON seats.seat_id = seat_reservation.seat_id 
 INNER JOIN class ON seats.class_id = class.class_id

WHERE reservation.res_id = '$res_id1'
";
$select_res = mysqli_query($connect, $select) or trigger_error(mysqli_error()." ".$select);



$select2 = "SELECT *FROM reservation 

INNER JOIN passenger ON reservation.passenger_id = passenger.passenger_id 

INNER JOIN seat_reservation ON reservation.res_id = seat_reservation.res_id 

INNER JOIN flights ON reservation.flight_number = flights.flight_number

INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number 

INNER JOIN seats ON seats.seat_id = seat_reservation.seat_id 
 
INNER JOIN class ON seats.class_id = class.class_id

WHERE reservation.res_id = '$res_id2'
";
$select_res2 = mysqli_query($connect, $select2) or trigger_error(mysqli_error()." ".$select2);
}

}// if two flights



// one way flight
if ($_SESSION['oneflight'] == true) {

$passenger_query = "INSERT INTO passenger(fname, lname, email, phone, birth_date, user_id) 
VALUES ('$fname', '$lname', '$email', '$phone', '$dob', '$user_id')"; 
$passenger_res = mysqli_query($connect, $passenger_query);
$pas_id = mysqli_insert_id($connect); // last id inserted for passenger


  // insert in reservation table
$reservation_query = "insert into reservation(flight_number, passenger_id, num_passengers, res_date, res_time)
values('".$_SESSION['flight']."','".$pas_id."','".$_SESSION['num_passengers']."','".$date."','".$time."')";
$reservation_result = mysqli_query($connect, $reservation_query);

$res_id = mysqli_insert_id($connect);


foreach ($_SESSION['seat'] as $value) {
 $seat_query = "INSERT INTO seat_reservation(res_id, seat_id)
 VALUES ('$res_id', '$value')";

 $seat_res = mysqli_query($connect, $seat_query);

$change_query = "update seats set statement = 'Unavailable' where seat_id = '".$value."' ";
$change_result = mysqli_query($connect, $change_query);

}// foreach loop



$payment_query = "insert into payment(passenger_id, amount) 
values('".$pas_id."', '".$_SESSION['price']."' )";
$payment_result = mysqli_query($connect, $payment_query);

$select = "SELECT *FROM reservation 

INNER JOIN passenger ON reservation.passenger_id = passenger.passenger_id 

INNER JOIN seat_reservation ON reservation.res_id = seat_reservation.res_id 

INNER JOIN flights ON reservation.flight_number = flights.flight_number

INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number 

INNER JOIN seats ON seats.seat_id = seat_reservation.seat_id 
 INNER JOIN class ON seats.class_id = class.class_id

WHERE reservation.res_id = '$res_id'
";
$select_res = mysqli_query($connect, $select) or trigger_error(mysqli_error()." ".$select);



}// if one flights
$to = $email;
$subject = "Flight Booked";
$txt = "Your Reservation has been confirmed";
$headers = "From: BSUIR :)";
mail($to,$subject,$txt,$headers);
session_unset();

}// if paid


?>
<!DOCTYPE html>
<html>
<head>
	<title>Reservation Confirmed</title>
	    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="bootstrap/4.dist0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/style.css">
<script defer src="fontawesome/fontawesome-all.js"></script>
<link rel="icon" href="img/icon.png"> 
</head>
<body>

<div class="container">
<div class="card">
  <?php
$i = 1;
while ($row = mysqli_fetch_array($select_res)) {
if ($i == 1) { ?>
<div class="card">
  <div class="card-header">
    Ticket No: <?php echo $row['res_id']." Flight No: ".$row['flight_number']."<br/>".
"<strong>".$row['from_city'].": ".date("d.m.Y", strtotime($row['depart_date']))." at ".date("H:i", strtotime($row['depart_time']))." TO ".$row['to_city'].": ".date("d.m.Y", strtotime($row['arrival_date']))." at ".date("H:i", strtotime($row['arrival_time']))    ."</strong>"
    ; ?>
  </div>
<div class="card-body">
  <h4>Passengers Seat</h4><?php echo $row['class_name']; ?>
<?php
$i++;
} ?>
  
    <h5 class="card-title"><?php
echo "   Seat No: ".$row['seat_number']."<br>";?></h5>


<?php
}

?>  
  </div>
</div>
<?php
$i = 1;
while ($row2 = mysqli_fetch_array($select_res2)) {
if ($i == 1) { ?>
<div class="card">
  <div class="card-header">
    Ticket No: <?php echo $row2['res_id']." Flight No: ".$row2['flight_number']."<br/>".
"<strong>".$row2['from_city'].": ".date("d.m.Y", strtotime($row2['depart_date']))." at ".date("H:i", strtotime($row2['depart_time']))." TO ".$row2['to_city'].": ".date("d.m.Y", strtotime($row2['arrival_date']))." at ".date("H:i", strtotime($row2['arrival_time']))    ."</strong>"
    ; ?>
  </div>
<div class="card-body">
  <h4>Passengers Seat</h4><?php echo $row2['class_name']; ?>
<?php
$i++;
} ?>
  
    <h5 class="card-title"><?php
echo "   Seat No: ".$row2['seat_number']."<br>";?></h5>


<?php
}

?>  
  </div>
</div>
</div>
<button type="button" onclick="myFunction()" class="btn btn-primary"><i class="fas fa-print"></i> print</button>   <a href="index.php" class="btn btn-primary">Home</a>
</div>
</body>
</html>
<script>
function myFunction() {
    window.print();
}
</script>