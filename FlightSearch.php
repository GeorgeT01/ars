<?php
session_start();
require_once('dbConfig.php'); 

$dDate = $_POST['date1'];
$rDate = $_POST['date2'];
$fromCity = $connect->escape_string($_POST['from']);
$toCity = $connect->escape_string($_POST['to']);
$class =  $_POST['class'];


$_SESSION['num_passengers'] = $_POST['num_passengers'];
$_SESSION['class'] = $_POST['class'];


$type = $_POST['type'];

$query1 = "SELECT *from flights
INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number

INNER JOIN airport ON flights.from_city = airport.city

INNER JOIN aircraft on flight_details.ac_id = aircraft.ac_id

INNER JOIN flight_price on flights.flight_number = flight_price.flight_number

INNER JOIN class on flight_price.class_id = class.class_id

where 
flights.from_city LIKE '%".$fromCity."%' and
flights.to_city LIKE '%".$toCity."%' and
flight_details.depart_date LIKE '{$dDate}%' and
class.class_name = '".$class."' ";



$query2 = "select *from flights
INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number

INNER JOIN airport ON flights.from_city = airport.city

INNER JOIN aircraft on flight_details.ac_id = aircraft.ac_id

INNER JOIN flight_price on flights.flight_number = flight_price.flight_number

INNER JOIN class on flight_price.class_id = class.class_id

where 
flights.from_city LIKE '%".$toCity."%' and
flights.to_city LIKE '%".$fromCity."%' and
flight_details.depart_date LIKE '{$rDate}%'  and
class.class_name = '".$class."' ";


//one way flights
$query = "select *from flights
INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number

INNER JOIN airport ON flights.from_city = airport.city

INNER JOIN aircraft on flight_details.ac_id = aircraft.ac_id

INNER JOIN flight_price on flights.flight_number = flight_price.flight_number

INNER JOIN class on flight_price.class_id = class.class_id

where 
flights.from_city LIKE '%".$fromCity."%' and
flights.to_city LIKE '%".$toCity."%' and
flight_details.depart_date LIKE '{$dDate}%' and
class.class_name = '".$class."' ";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select Flight</title>
  <?php include('head.php'); ?>

</head>
<body>
  <?php include('nav-bar.php'); ?>
 <div class="container mt-5">
<?php
if(isset($_POST['search']) && $type == 'Return') //RETURN FLIGHTS
{


$result1 = mysqli_query($connect, $query1);
$numRows1 =mysqli_num_rows($result1);

$result2 = mysqli_query($connect, $query2);
$numRows2 =mysqli_num_rows($result2);

if ($numRows1 > 0 && $numRows2 > 0) 
{
	?>
<form action="BookFlight.php" method="POST">
	<?php
$i = 0;
while ($row1 = mysqli_fetch_array($result1)) 
{

if ($i == 0) { ?>
<h4 class="text-primary">Outbound Flights</h4>
<?php } //if $i ?>
<h6><?php echo $row1['from_city']." - ".$row1['to_city']; ?></h6>
<strong><?php  echo date("l d M Y", strtotime($row1['depart_date'])); ?></strong>
<div class="table-responsive">
<table class="table">
<tr class="table-primary">
	<th scope="col">


	</th>
 <th scope="col">Departure</th>
 <th scope="col">Arrival</th>
 <th scope="col">Duration</th>
  <th scope="col">Class</th>
 <th scope="col">Baggage</th>
  <th scope="col">Price</th>

</tr>
<tr class="table-light">
	 <td scope="col">
	<div class="custom-control custom-radio">
  <input type="radio" id="flight1" name="flight1" value="<?php  echo $row1['flight_number']; ?>" class="custom-control-input" onclick="javascript:showhide()" required> 
  <label class="custom-control-label" for="flight1"></label>
</div>	

	  </td>
	 <td scope="col"><?php  echo date("H:i", strtotime($row1['depart_time'])); ?></td>
 <td scope="col"><?php  echo date("H:i", strtotime($row1['arrival_time'])); ?></td>
 <td scope="col">
 	<?php
$datetime1 = new DateTime($row1['arrival_time']);
$datetime2 = new DateTime($row1['depart_time']);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%h')."h ".$interval->format('%i')."min";
?>  
</td>	
<td scope="col"> <?php  echo $row1['class_name']; ?> </td>
<td scope="col"> <?php  echo $row1['baggage']; ?> Kg </td>
<td scope="col"> <strong><?php  echo $row1['price']; ?><sup>$</sup></strong></td>

</tr>
</table>
</div>
<?php
} // 1st while loop
$i = 0;
while ($row2 = mysqli_fetch_array($result2)) {
if ($i == 0) { ?>


<h4 class="text-primary mt-5">Inbound Flights</h4>
<?php } //if $i ?>
<h6><?php echo $row2['from_city']." - ".$row2['to_city']; ?></h6>
<strong><?php  echo date("l d M Y", strtotime($row2['depart_date'])); ?></strong>
<div class="table-responsive">
<table class="table">
<tr class="table-primary">
	<th scope="col">


	</th>
 <th scope="col">Departure</th>
 <th scope="col">Arrival</th>
 <th scope="col">Duration</th>
  <th scope="col">Class</th>
 <th scope="col">Baggage</th>
  <th scope="col">Price</th>

</tr>
<tr class="table-light">
	 <td scope="col">
	<div class="custom-control custom-radio">
  <input type="radio" id="flight2" name="flight2" value="<?php  echo $row2['flight_number']; ?>" class="custom-control-input" onclick="javascript:showhide()" required> 
  <label class="custom-control-label" for="flight2"></label>
</div>	

	  </td>
	 <td scope="col"><?php  echo date("H:i", strtotime($row2['depart_time'])); ?></td>
 <td scope="col"><?php  echo date("H:i", strtotime($row2['arrival_time'])); ?></td>
 <td scope="col">
 	<?php
$datetime1 = new DateTime($row2['arrival_time']);
$datetime2 = new DateTime($row2['depart_time']);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%h')."h ".$interval->format('%i')."min";
?>  
</td>	
<td scope="col"> <?php  echo $row2['class_name']; ?> </td>
<td scope="col"> <?php  echo $row2['baggage']; ?> Kg </td>
<td scope="col"> <strong><?php  echo $row2['price']; ?><sup>$</sup></strong></td>

</tr>
</table>
</div>


<?php 

}// 2nd while loop
?>
<center>
 <a href="index.php" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> BACK</a><button type="submit" name="bookFlight2" class="btn btn-primary">NEXT <i class="fa fa-angle-double-right"></i></button>
 </center>
</form>
<?php
} // if numRows1 & 2
else
{
/*
echo '<div class="text-center">
<a class="btn btn-primary text-light" href="index.php"><i class="fas fa-redo"></i> SEARCH AGAIN</a>
</div>'; */
echo '<script>swal({
  title: "No flights can be found for the route and date you have selected.",
  text: "",
  icon: "warning",
  button: "SEARCH AGRAIN",
}).then(function() {
    window.location = "index.php";
});</script>';
} // else
} // if one-way flight
if(isset($_POST['search']) && $type == 'oneway') //ONE-WAY FLIGHT
{

$result = mysqli_query($connect, $query);
$numRows =mysqli_num_rows($result);


if ($numRows > 0) 
{
	?>
<form action="BookFlight.php" method="POST">
	<?php
$i = 0;
while ($row = mysqli_fetch_array($result)) 
{

if ($i == 0) { ?>
<h4 class="text-primary">Outbound Flights</h4>
<?php } //if $i ?>
<h6><?php echo $row['from_city']." - ".$row['to_city']; ?></h6>
<strong><?php  echo date("l d M Y", strtotime($row['depart_date'])); ?></strong>
<div class="table-responsive">
<table class="table">
<tr class="table-primary">
	<th scope="col">
	</th>
 <th scope="col">Departure</th>
 <th scope="col">Arrival</th>
 <th scope="col">Duration</th>
  <th scope="col">Class</th>
 <th scope="col">Baggage</th>
  <th scope="col">Price</th>

</tr>
<tr class="table-light">
	 <td scope="col">
	<div class="custom-control custom-radio">
  <input type="radio" id="flight" name="flight" value="<?php  echo $row['flight_number']; ?>" class="custom-control-input" onclick="javascript:showhide()" required> 
  <label class="custom-control-label" for="flight"></label>
</div>	

	  </td>
	 <td scope="col"><?php  echo date("H:i", strtotime($row['depart_time'])); ?></td>
 <td scope="col"><?php  echo date("H:i", strtotime($row['arrival_time'])); ?></td>
 <td scope="col">
 	<?php
$datetime1 = new DateTime($row['arrival_time']);
$datetime2 = new DateTime($row['depart_time']);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%h')."h ".$interval->format('%i')."min";
?>  
</td>	
<td scope="col"> <?php  echo $row['class_name']; ?> </td>
<td scope="col"> <?php  echo $row['baggage']; ?> Kg </td>
<td scope="col"> <strong><?php  echo $row['price']; ?><sup>$</sup></strong></td>

</tr>
</table>
</div>
<?php
} // while loop
?>
<center>
 <a href="index.php" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> BACK</a><button type="submit" name="bookFlight1" class="btn btn-primary">NEXT <i class="fa fa-angle-double-right"></i></button>
 </center>

<?php
} // if numRows

else
{
echo '<script>swal({
  title: "No flights can be found for the route and date you have selected.",
  text: "",
  icon: "warning",
  button: "SEARCH AGRAIN",
}).then(function() {
    window.location = "index.php";
});</script>';
}// else
} // if one-way flight
?>
</div> 
  <?php include('footer.php'); ?>
</body>
</html>


