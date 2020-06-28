<?php
session_start();
require_once('dbConfig.php');
$page = "search";

$stat_query ="INSERT INTO statistics(stat_date,views)
VALUES (CURDATE(),1) ON DUPLICATE KEY UPDATE views = views + 1";
$stat_res = mysqli_query($connect, $stat_query);

include('CancelReservation.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home Page</title>
	<?php include('head.php'); ?>
	<link rel="stylesheet" href="style.css">
</head>
<body class="">
<?php include('nav-bar.php'); ?>

<div class="container mt-5">
<nav>
<div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="pills-book-tab" data-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="true"><h5><i class="material-icons">
airplanemode_active
</i> Book Flight</h5></a>

    <a class="nav-item nav-link" id="pills-cancel-tab" data-toggle="pill" href="#pills-cancel" role="tab" aria-controls="pills-cancel" aria-selected="false"><h5><i class="material-icons">
airplanemode_inactive
</i> Cancel Reservation</h5> </a>
</div>
</nav>
<div class="tab-content container card-bg border-0" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">

<form action="FlightSearch.php" method="POST">
<div class="row">
<div class="col-sm-6">
<div class="custom-control custom-radio mt-3">
  <input type="radio" id="oneWay" name="type" value="oneway" class="custom-control-input" onclick="javascript:showhide()" required>
  <label class="custom-control-label" for="oneWay">One-way</label>
</div>

<div class="custom-control custom-radio">
  <input type="radio" id="Return" name="type" value="Return" class="custom-control-input" onclick="showhide()" required>
  <label class="custom-control-label" for="Return">Return</label>
</div>

</div>
<div class="col-sm-3 mt-3">
<label>Class:</label>
<select name="class" class="form-control">
<option value="Economy">Economy</option>
<option value="Business">Business </option>
<option value="Firstclass">First class</option>
</select>

</div>
<div class="col-sm-3 mt-3">
<label>Number Of Passengers:</label>
<input type="number" name="num_passengers" class="form-control" min="1" max="10" value="1">
</div>
</div>
<div class="row mt-3">
<div class="col-sm-6">
<i class="material-icons">flight_takeoff</i>
<input class="form-control" type="text" id="country"  placeholder="From" name="from" required autocomplete="off">
</div>
<div class="col-sm-6">
  <i class="material-icons">flight_land</i>
     <input class="form-control" type="text" id="country" placeholder="Going To" name="to" required autocomplete="off">
</div>
</div>
 <div class="row mt-3">
        <div class="col-sm-6">
        <i class="fas fa-calendar-alt"></i>  Outbound date <input class="form-control" type="date" id="date" name="date1" required>
        </div>
        <div class="col-sm-6">
          <div id="hide">
        <i class="fas fa-calendar-alt"></i>  Return date <input class="form-control" type="date" id="dat2" name="date2">
          </div>
        </div>
    </div>
     <div class="row mt-3">
        <div class="col-sm-6">
        </div>
         <div class="col-sm-6">
         	 <button type="submit" name="search" class="btn btn-primary btn-lg w-100  mb-5"><i class="fas fa-search"></i> Search</button>
        </div>
    </div>
</form>

</div>

  <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">
    <form action="" method="POST">
  <p><i class="fas fa-check mt-3"></i> Allows canclling reservation online.<br/>
  <i class="fas fa-check"></i> Ticket Number <br/>
  <i class="fas fa-check"></i> First & Last name must exactly match the name in the ticket.</p>
<div class="row mt-3">
<div class="col-sm-6">
  <label>First name</label>
  <input type="text" name="fname" class="form-control" required>
</div>
<div class="col-sm-6">
  <label>Last name</label>
  <input type="text" name="lname" class="form-control" required>
</div>
<div class="col-sm-6">
<label>Email</label>
  <input type="email" name="email" class="form-control" required>
</div>
<div class="col-sm-6">
<label>Ticket number</label>
  <input type="text" name="ticke_number" class="form-control" required>
</div>
<div class="col-sm-6">
  <?php
if (isset($errorMsg)) {
  echo $errorMsg;
}
if (isset($confirmMsg)) {
  echo $confirmMsg;
}
   ?>
  </div>
  <div class="col-sm-6">
    <button type="submit" name="cancel" class="btn btn-danger btn-lg w-100 mt-2 mb-5">CANCEL RESERVATION</button>
  </div>
</div>
</form>


  </div>

</div>

</div>
<?php include('footer.php'); ?>
</body>
</html>
<script type="text/javascript">
function showhide() {
    if (document.getElementById('oneWay').checked) {
        document.getElementById('hide').style.display = 'none';
    }else{
document.getElementById('hide').style.display = 'block';

    }
  }
  </script>
