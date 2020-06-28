<?php
if (isset($_POST['cancel'])) {
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$ticketNumber = $_POST['ticke_number'];

$query = "SELECT *FROM reservation
INNER JOIN passenger on reservation.passenger_id = passenger.passenger_id
INNER JOIN seat_reservation on reservation.res_id = seat_reservation.res_id
WHERE reservation.res_id = '$ticketNumber' AND
passenger.fname = '$fname' AND
passenger.lname = '$lname' ";
$result= mysqli_query($connect, $query);
$reservation = $result->fetch_assoc();

if (mysqli_num_rows($result) == 0) {
$errorMsg ='<script>swal({
  title: "Sorry, Reservation not found!",
  text: "",
  icon: "warning",
  button: "Ok",
}).then(function() {
    window.location = "index.php";
});</script>';
}else
{
$cancel_query= "INSERT INTO cancellation (res_id, contact_email) VAlUES ('".$reservation['res_id']."','$email') ";
$cancel_result = mysqli_query($connect, $cancel_query);

$delete_query = "DELETE FROM seat_reservation
 WHERE res_id = '".$reservation['res_id']."' ";
$delete_result = mysqli_query($connect, $delete_query);

$update_query = "UPDATE seats SET statement = 'Available' 
WHERE seat_id = '".$reservation['seat_id']."'";
$update_result = mysqli_query($connect, $update_query);


if ($cancel_result && $delete_result && $update_result) {
$confirmMsg = '<script>swal({
  title: "Reservation has been cancelled , we will contact you for refund",
  text: "",
  icon: "success",
  button: "Ok",
}).then(function() {
    window.location = "index.php";
});</script>';
}else
{
$errorMsg ='<script>swal({
  title: "Somthing went wrong, try again later!",
  text: "",
  icon: "warning",
  button: "Ok",
}).then(function() {
    window.location = "index.php";
});</script>';

}


}


}
?>