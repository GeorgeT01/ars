<?php 
session_start();
require_once('dbConfig.php');
$page = "reservation";
$id = $_SESSION['user_id'];

$query = "SELECT *FROM reservation 
INNER JOIN flights ON reservation.flight_number = flights.flight_number
INNER JOIN flight_details ON flights.flight_number = flight_details.flight_number
INNER JOIN seat_reservation ON reservation.res_id = seat_reservation.res_id
INNER JOIN seats ON seat_reservation.seat_id = seats.seat_id
INNER JOIN class ON seats.class_id = class.class_id
INNER JOIN passenger ON reservation.passenger_id = passenger.passenger_id
INNER JOIN users ON passenger.user_id = users.user_id
WHERE users.user_id = '$id'";
$result = mysqli_query($connect, $query);
$numRows = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>My Reservations</title>
	<?php include('head.php'); ?>
</head>
<body>
<?php include('nav-bar.php'); ?>
<div class="container mt-5">
	<?php
	if ($numRows > 1 ) {
$i = 0;
while ($row = mysqli_fetch_array($result)) 
{

if ($i == 0) { ?>
<?php } //if $i ?>
<h6><?php echo $row['from_city']." - ".$row['to_city']; ?></h6>
<strong><?php  echo date("l d M Y", strtotime($row['depart_date'])); ?></strong>
<div class="table-responsive">
<table class="table">
<tr class="table-primary">
	<th scope="col">
Flight Number
	</th>
 <th scope="col">Departure</th>
 <th scope="col">Arrival</th>
 <th scope="col">Duration</th>
  <th scope="col">Class</th>
 <th scope="col">Seat Number</th>

</tr>
<tr class="table-light">
	 <td scope="col">
<?php  echo $row['flight_number']; ?>

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
<td scope="col"> <?php  echo $row['seat_number']; ?></td>


</tr>
</table>
</div>
<?php
} 
}else
{
echo "You Have No Reservations!";
} ?>
</div>
<?php include('footer.php'); ?>
</body>
</html>