<?php
    if(isset($_POST['addNewReservation'])) {
        $reservation = new Reservation();

        $reservation->request_name = trim($_POST['name']);
        $reservation->request_email = trim($_POST['email']);
        $reservation->request_tel = trim($_POST['tel']);
        $reservation->request_date = $_POST['date'];
        $reservation->request_time = $_POST['time'];
        $reservation->request_num_seats = trim($_POST['seats']);
        $reservation->request_comment = trim($_POST['comments']);
        $reservation->request_via = trim($_POST['via']);
        $reservation->request_status = trim($_POST['status']);
        $reservation->request_recieved_time = date("Y-m-d H:i:s");;

        //CHECK REQUIRED FIELDS ARE FILED
        if(!empty($request_name) && !empty($request_date) && !empty($request_time) && !empty($request_num_seats) && !empty($request_status)) {
            if(empty($request_email) && empty($request_tel) ) {
                $message = "<h2 class='alert'> Please fill all required input fields<i class='fas fa-times closeBtn'></i></h2>";
            }
        }

        if($reservation->save()) {
            $last_id = $database->connection->insert_id;
            $session->message("<h2 class='success'> 1 Reservation saved <a class='check' href='reservation.php?source=details&r_id={$last_id}'>check</a><i class='fas fa-times closeBtn'></i></h2>"); 
            redirect("reservation.php?source=add"); 
        };
    }
?>

<section class="main">
    <h1>Add Reservation</h1>

    <div class="reservationBox">
        <div class="message hide"></div>
        <?= isset($message) ? $message: null; ?>
        <form id="add" method="post">
            <div class="form-group">
                <label for="name" class="short">Name*</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email" class="short">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="tel" class="short">Phone</label>
                <input type="tel" name="tel" id="tel">
            </div>
            <div class="form-group">
                <label class="long" for="">Date & Time*</label>
                <div class="row">
                    <input class="short" type="date" name="date" id="date" required>
                    <select class="short" name="time" id="time" required>
                        <option value="" disabled selected> - Select -</option>
                        <option value="18:00">18:00</option>
                        <option value="18:30">18:30</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                        <option value="22:00">22:00</option>
                        <option value="22:30">22:30</option>
                        <option value="23:00">23:00</option>
                        <option value="23:30">23:30</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="seats" class="long">Number of Seats*</label>
                <select name="seats" id="seats"  class="short" requered>
                    <option value="" disabled selected> - Select -</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comments" class="long">Special Request</label>
                <textarea name="comments" id="comments" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group checkbox-container">
                <label for="" class="long">Reservation via</label>
                    <div class="radioBtnContainer">
                        <label for="phone" class="checkboxlabel">Phone</label>
                        <input type="radio" name="via" value="phone" checked>
                    </div>
                    <div class="radioBtnContainer">
                        <label for="facebook" class="checkboxlabel">Facebook</label>
                        <input type="radio" name="via" value="facebook">
                    </div>
                    <div class="radioBtnContainer">
                        <label for="twitter" class="checkboxlabel">Twitter</label>
                        <input type="radio" name="via" value="twitter">
                    </div>
                    <div class="radioBtnContainer">
                        <label for="others" class="checkboxlabel">Other</label>
                        <input type="radio" name="via" value="others">
                    </div>
            <div class="form-group">
                <label for="status" class="long">Reservation Status*</label>
                <select name="status" id="status"  class="short" requered>
                    <option value="" disabled selected> - Select -</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="canceled">Canceled</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div class="form-group btn-container">
                <input type="submit" name="addNewReservation" value="Add Reservation" class="btn" id="send">
            </div>
            
        </form>
    </div> <!-- end of .reservationBox -->
