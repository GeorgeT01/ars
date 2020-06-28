<?php
session_start();
#error_reporting(0);
require_once('dbConfig.php'); 
require_once"config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Book flight</title>
    <link rel="stylesheet" href="style.css">
   <?php include('head.php'); ?>
   <style type="text/css">
     input[type='number'] {
    -moz-appearance:textfield;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
   </style>
</head>
<body>
<?php include('nav-bar.php'); ?>




<?php
// if tow flights
if (isset($_POST['bookFlight2'])) {
$_SESSION['twoflights'] = true;
$_SESSION['flight1'] = $_POST['flight1'];
$_SESSION['flight2'] = $_POST['flight2'];
$_SESSION['num_passengers'];
$_SESSION['class'];

$query1 = "select *from flights
INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number
INNER JOIN airport ON flights.from_city = airport.city
INNER JOIN aircraft on flight_details.ac_id = aircraft.ac_id
INNER JOIN flight_price on flights.flight_number = flight_price.flight_number
INNER JOIN class on flight_price.class_id = class.class_id
where 
flights.flight_number = '".$_SESSION['flight1']."' and
class.class_name = '".$_SESSION['class']."' ";

$res1 = mysqli_query($connect, $query1) or trigger_error(mysqli_error()." ".$query1);?>
<div class="container mt-5">
<h5>Your flight information:</h5>
<form action="stripeIPN.php" method="POST"> 
<?php
while ($row1 = mysqli_fetch_array($res1)) {
?>
 <div class="card">
   <h5 class="card-header bg-dark" style="background-color: black;color: white;">Flight No: <?php  echo $row1['flight_number']; 
     $limit =  $_SESSION['num_passengers'];
$seat_query = "SELECT *FROM seats
INNER JOIN aircraft ON seats.ac_id = aircraft.ac_id
INNER JOIN flight_details on aircraft.ac_id = flight_details.ac_id
INNER JOIN flights on flight_details.flight_number = flights.flight_number
INNER JOIN class on seats.class_id = class.class_id
WHERE class.class_name = '".$_SESSION['class']."'
AND flights.flight_number = '".$_SESSION['flight1']."'
AND seats.statement = 'Available' ORDER BY RAND() LIMIT ".$_SESSION['num_passengers'];


$seat_res = mysqli_query($connect, $seat_query);
$_SESSION['seat1'] = array();
$i = 1;
while ($seat = mysqli_fetch_array($seat_res)) {
  echo "<br/>  Passenger ".$i." Seat No: ".$seat['seat_number'];
  $i++;

  $_SESSION['seat1'][] = $seat['seat_id'];

}
if (mysqli_num_rows($seat_res) < $_SESSION['num_passengers']) {
echo "Not enough seats on the plane!";
}
?><p style="float: right;"> Outbound Flight</p></h5>
<div class="row">
<div class="col-2">



</div>  
<div class="col-3">
 <strong> Depart</strong> <br/> 
<i class="fas fa-calendar-alt"></i> <?php  echo date("d M Y", strtotime($row1['depart_date'])); ?>  <br/>
<i class="far fa-clock"></i> <?php  echo date("H:i", strtotime($row1['depart_time'])); ?> <br/>
<i class="fas fa-map-marker-alt"></i> <?php  echo $row1['from_city'].", ".$row1['country'].", <br/> ".$row1['airport_name']; ?>
</div> 
<div class="col-2">
 <i class="fa fa-hourglass-half"></i> <strong>Duration</strong><br/>
<?php
$datetime1 = new DateTime($row1['arrival_time']);
$datetime2 = new DateTime($row1['depart_time']);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%h')."h ".$interval->format('%i')."min";
?>  


</div> 
<div class="col-3">
 <strong> Arrival</strong> <br/> 
<i class="fas fa-calendar-alt"></i> <?php  echo date("d M Y", strtotime($row1['arrival_date'])); ?>  <br/>
<i class="far fa-clock"></i> <?php  echo date("H:i", strtotime($row1['arrival_time'])); ?> <br/>
<i class="fas fa-map-marker-alt"></i> <?php
$airport = " SELECT *FROM airport WHERE city = '".$row1['to_city']."' ";
$res = mysqli_query($connect, $airport);
$rowAirpoet = $res->fetch_assoc();
  echo $row1['to_city'].", ".$rowAirpoet['country'].", <br/> ".$rowAirpoet['airport_name']; ?>    
</div> 
<div class="col-2">
 <strong> Baggage </strong>  <br/>
  <?php  echo $row1['baggage']; ?> Kg <br/>
  <strong> Class </strong>  <br/>
  <?php  echo $row1['class_name']; ?><br/>
  <strong> Price </strong> <br/>
<?php  echo $row1['price']; 
$_SESSION['price1'] = $row1['price']; 
?> $<br/>
</div> 

</div>    



  </div>
<?php
}
$query2 = "select *from flights
INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number
INNER JOIN airport ON flights.from_city = airport.city
INNER JOIN aircraft on flight_details.ac_id = aircraft.ac_id
INNER JOIN flight_price on flights.flight_number = flight_price.flight_number
INNER JOIN class on flight_price.class_id = class.class_id
where 
flights.flight_number = '".$_SESSION['flight2']."' and
class.class_name = '".$_SESSION['class']."' ";

$res2 = mysqli_query($connect, $query2) or trigger_error(mysqli_error()." ".$query2);
while ($row2 = mysqli_fetch_array($res2)) {
?>
 <div class="card">
   <h5 class="card-header bg-dark" style="background-color: black;color: white;">Flight No: <?php  echo $row2['flight_number']; 
  $limit =  $_SESSION['num_passengers'];
$seat_query = "SELECT *FROM seats
INNER JOIN aircraft ON seats.ac_id = aircraft.ac_id
INNER JOIN flight_details on aircraft.ac_id = flight_details.ac_id
INNER JOIN flights on flight_details.flight_number = flights.flight_number
INNER JOIN class on seats.class_id = class.class_id
WHERE class.class_name = '".$_SESSION['class']."'
AND flights.flight_number = '".$_SESSION['flight2']."'
AND seats.statement = 'Available' ORDER BY RAND() LIMIT ".$_SESSION['num_passengers'];


$seat_res = mysqli_query($connect, $seat_query);
$_SESSION['seat2'] = array();
$i = 1;
while ($seat = mysqli_fetch_array($seat_res)) {
  echo "<br/>  Passenger ".$i." Seat No: ".$seat['seat_number'];
  $i++;

  $_SESSION['seat2'][] = $seat['seat_id'];

}
foreach ($_SESSION['seat2'] as $value) {
 echo $value;
}

if (mysqli_num_rows($seat_res) < $_SESSION['num_passengers']) {
echo "Not enough seats on the plane!";
}


   ?><p style="float: right;">Return Flight</p></h5>
<div class="row">
<div class="col-2">



</div>  
<div class="col-3">
 <strong> Depart</strong> <br/> 
<i class="fas fa-calendar-alt"></i> <?php  echo date("d M Y", strtotime($row2['depart_date'])); ?>  <br/>
<i class="far fa-clock"></i> <?php  echo date("H:i", strtotime($row2['depart_time'])); ?> <br/>
<i class="fas fa-map-marker-alt"></i> <?php  echo $row2['from_city'].", ".$row2['country'].", <br/> ".$row2['airport_name']; ?>
</div> 
<div class="col-2">
 <i class="fa fa-hourglass-half"></i> <strong>Duration</strong><br/>
<?php
$datetime12 = new DateTime($row2['arrival_time']);
$datetime22 = new DateTime($row2['depart_time']);
$interval2 = $datetime12->diff($datetime22);
echo $interval2->format('%h')."h ".$interval->format('%i')."min";
?>  


</div> 
<div class="col-3">
 <strong> Arrival</strong> <br/> 
<i class="fas fa-calendar-alt"></i> <?php  echo date("d M Y", strtotime($row2['arrival_date'])); ?>  <br/>
<i class="far fa-clock"></i> <?php  echo date("H:i", strtotime($row1['arrival_time'])); ?> <br/>
<i class="fas fa-map-marker-alt"></i> <?php
$airport2 = " SELECT *FROM airport WHERE city = '".$row2['to_city']."' ";
$resu2 = mysqli_query($connect, $airport2);
$rowAirpoet2 = $resu2->fetch_assoc();
  echo $row2['to_city'].", ".$rowAirpoet2['country'].", <br/> ".$rowAirpoet2['airport_name']; ?>    
</div> 
<div class="col-2">
 <strong> Baggage </strong>  <br/>
  <?php  echo $row2['baggage']; ?> Kg <br/>
  <strong> Class </strong>  <br/>
  <?php  echo $row2['class_name']; ?><br/>
  <strong> Price </strong> <br/>
<?php  echo $row2['price']; 
$_SESSION['price2'] = $row2['price']; 
?> $<br/>

</div> 

</div>    



  </div>
<?php
} // while loop
$_SESSION['price'] = ($_SESSION['price1'] + $_SESSION['price2']) *  $_SESSION['num_passengers']; 
$_SESSION['price']; ?>


<div class="card container mt-5" style="background-color: #ECF0F1;">
  <h3 class="">Passenger Details & Payment</h3>
<div class="row mt-3">
<div class="col">
First Name<small class="font-weight-bold" style="color: red;">* (as shown in your ID)</small>
<input type="text" name="fname" class="form-control" required autocomplete="off" placeholder="First Name">
</div>  
<div class="col">
Last Name<small class="font-weight-bold" style="color: red;">* (as shown in your ID)</small>
<input type="text" name="lname" class="form-control" required autocomplete="off" placeholder="Last Name">
</div>      
</div>  

<div class="row">
<div class="col">
Data of Birth<larg  class="font-weight-bold" style="color: red;">*</larg>
<input type="date" name="dob" class="form-control" required autocomplete="off" placeholder="Email Address">
</div>  
<div class="col">
Email<larg  class="font-weight-bold" style="color: red;">*</larg>
<input type="text" name="email" class="form-control" required autocomplete="off" placeholder="Email Address">
</div>      
</div>
<div class="row mb-5">
<div class="col">
Phone Number<larg  class="font-weight-bold" style="color: red;">*</larg>
 <div class="row">

<div class="col-4">

<select class="form-control">
<option value="bel">+375 Belarus</option>  
<option value="ru">+7 Russia</option>  
<option value="uk">+380 Ukraine</option>  
<option value="ch">+86 China</option>  
<option value="usa">+1 USA</option>  
<option value="gr">+49 Germany</option>  
</select>
</div>
<div class="col-8">
<input type="number" name="phone" class="form-control" required autocomplete="off" >
</div>
</div> 
</div>  
<div class="col mt-4">
<script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key= <?php echo $stripDetails['publishableKey']; ?>
    data-amount=<?php echo $_SESSION['price']."00"; ?>
    data-name="Diploma Project"
    data-description="Widget"
    data-locale="auto">
  </script>
  <a href="index.php" class="btn btn-danger btn-sm w-25">Cancel</a>
</div>      
</div>
</div>


</form>

</div>

<?php
}// if two flights
?>



<?php
// if one flight
if (isset($_POST['bookFlight1'])) {
$_SESSION['oneflight'] = true;
$_SESSION['flight'] = $_POST['flight'];
$_SESSION['num_passengers'];
$_SESSION['class'];

$query = "select *from flights
INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number
INNER JOIN airport ON flights.from_city = airport.city
INNER JOIN aircraft on flight_details.ac_id = aircraft.ac_id
INNER JOIN flight_price on flights.flight_number = flight_price.flight_number
INNER JOIN class on flight_price.class_id = class.class_id
where 
flights.flight_number = '".$_SESSION['flight']."' and
class.class_name = '".$_SESSION['class']."' ";

$res = mysqli_query($connect, $query) or trigger_error(mysqli_error()." ".$query);?>
<div class="container mt-5">
<h5>Your flight information:</h5>
<form action="stripeIPN.php" method="POST"> 
<?php
while ($row = mysqli_fetch_array($res)) {
?>
 <div class="card">
   <h5 class="card-header bg-dark" style="background-color: black;color: white;">Flight No: <?php  echo $row['flight_number']; 
$limit =  $_SESSION['num_passengers'];
$seat_query = "SELECT *FROM seats
INNER JOIN aircraft ON seats.ac_id = aircraft.ac_id
INNER JOIN flight_details on aircraft.ac_id = flight_details.ac_id
INNER JOIN flights on flight_details.flight_number = flights.flight_number
INNER JOIN class on seats.class_id = class.class_id
WHERE class.class_name = '".$_SESSION['class']."'
AND flights.flight_number = '".$_SESSION['flight']."'
AND seats.statement = 'Available' ORDER BY RAND() LIMIT ".$_SESSION['num_passengers'];


$seat_res = mysqli_query($connect, $seat_query);
$_SESSION['seat'] = array();
$i = 1;
while ($seat = mysqli_fetch_array($seat_res)) {
  echo "<br/>  Passenger ".$i." Seat No: ".$seat['seat_number'];
  $i++;

  $_SESSION['seat'][] = $seat['seat_id'];

}
foreach ($_SESSION['seat'] as $value) {
 echo $value;
}
if (mysqli_num_rows($seat_res) < $_SESSION['num_passengers']) {
echo "Not enough seats on the plane!";
}
?>
<p style="float: right;"> One Way Flight</p></h5>
<div class="row">
<div class="col-2">



</div>  
<div class="col-3">
 <strong> Depart</strong> <br/> 
<i class="fas fa-calendar-alt"></i> <?php  echo date("d M Y", strtotime($row['depart_date'])); ?>  <br/>
<i class="far fa-clock"></i> <?php  echo date("H:i", strtotime($row['depart_time'])); ?> <br/>
<i class="fas fa-map-marker-alt"></i> <?php  echo $row['from_city'].", ".$row['country'].", <br/> ".$row['airport_name']; ?>
</div> 
<div class="col-2">
 <i class="fa fa-hourglass-half"></i> <strong>Duration</strong><br/>
<?php
$datetime1 = new DateTime($row['arrival_time']);
$datetime2 = new DateTime($row['depart_time']);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%h')."h ".$interval->format('%i')."min";
?>  


</div> 
<div class="col-3">
 <strong> Arrival</strong> <br/> 
<i class="fas fa-calendar-alt"></i> <?php  echo date("d M Y", strtotime($row['arrival_date'])); ?>  <br/>
<i class="far fa-clock"></i> <?php  echo date("H:i", strtotime($row['arrival_time'])); ?> <br/>
<i class="fas fa-map-marker-alt"></i> <?php
$airport = " SELECT *FROM airport WHERE city = '".$row['to_city']."' ";
$res = mysqli_query($connect, $airport);
$rowAirpoet = $res->fetch_assoc();
  echo $row['to_city'].", ".$rowAirpoet['country'].", <br/> ".$rowAirpoet['airport_name']; ?>    
</div> 
<div class="col-2">
 <strong> Baggage </strong>  <br/>
  <?php  echo $row['baggage']; ?> Kg <br/>
  <strong> Class </strong>  <br/>
  <?php  echo $row['class_name']; ?><br/>
  <strong> Price </strong> <br/>
<?php  echo $row['price']; 
$_SESSION['price'] = $row['price']; 
?> $<br/>
</div> 

</div>    



  </div>
<?php
}
?>


<div class="card container mt-5" style="background-color: #ECF0F1;">
  <h3>Passenger Details</h3>
<div class="row">
<div class="col">
First Name<small class="font-weight-bold" style="color: red;">* (as shown in your ID)</small>
<input type="text" name="fname" class="form-control" required autocomplete="off" placeholder="First Name">
</div>  
<div class="col">
Last Name<small class="font-weight-bold" style="color: red;">* (as shown in your ID)</small>
<input type="text" name="lname" class="form-control" required autocomplete="off" placeholder="Last Name">
</div>      
</div>  

<div class="row">
<div class="col">
Data of Birth<larg  class="font-weight-bold" style="color: red;">*</larg>
<input type="date" name="dob" class="form-control" required autocomplete="off" placeholder="Email Address">
</div>  
<div class="col">
Email<larg  class="font-weight-bold" style="color: red;">*</larg>
<input type="text" name="email" class="form-control" required autocomplete="off" placeholder="Email Address">
</div>      
</div>
<div class="row">
<div class="col">
    Phone Number<larg  class="font-weight-bold" style="color: red;">*</larg>
 <div class="row mb-5">

<div class="col-4">

<select class="form-control">
<option value="bel">+375 Belarus</option>  
<option value="ru">+7 Russia</option>  
<option value="uk">+380 Ukraine</option>  
<option value="ch">+86 China</option>  
<option value="usa">+1 USA</option>  
<option value="gr">+49 Germany</option>  
</select>
</div>
<div class="col-8">
<input type="number" name="phone" class="form-control" required autocomplete="off" >
</div>
</div> 
</div> 

<div class="col mt-4">
<script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key= <?php echo $stripDetails['publishableKey']; ?>
    data-amount=<?php echo $_SESSION['price'] * $_SESSION['num_passengers']."00"; ?>
    data-name=""
    data-description="Widget"
    data-locale="auto">
  </script>
  <a href="index.php" class="btn btn-danger btn-sm w-25">Cancel</a>
</div>      
</div>
</div>


</form>

</div>

<?php
}// if one flight
?>
<?php include('footer.php'); ?>
</body>
</html>