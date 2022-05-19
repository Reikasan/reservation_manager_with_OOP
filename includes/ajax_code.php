<?php 
    require_once("../classes/init.php");

    $reservation = new Reservation();

    if(isset($_POST['flag_status'])) {
        $reservation->ajax_change_flag_status($_POST['flag_status'], $_POST['request_id']);
    }

?>