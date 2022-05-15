<?php require_once("classes/init.php"); ?>

<?php
    if(!$session->is_signed_in()) { redirect("login.php"); }  
?>

<?php

if(empty($_GET['r_id'])) {
    redirect("reservation.php");
}

$reservation = Reservation::find_by_id($_GET['r_id']);

if($reservation) {
    $reservation->id = $_GET['r_id'];
    $reservation->delete();
    $session->message("<h2 class='success'>1 Reservation has been deleted <i class='fas fa-times closeBtn'></i></h2>");
    redirect("reservation.php");
} else {
    redirect("reservation.php");
}

?>