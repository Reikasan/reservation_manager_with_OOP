<?php include "includes/header.php"; ?>
<?php
    if(isset($_GET['r_id'])) {
        $requestId = $_GET['r_id'];

        // SELECT ALL DATA FROM REQUEST_ID
        $reservation = Reservation::find_by_id($requestId);

        // SAVE EDITED RESERVATION DATA
        if(isset($_POST['update'])) {
            //CHECK REQUIRED FIELDS ARE FILED
            if(empty($_POST['name']) || empty($_POST['date']) || empty($_POST['time']) || empty($_POST['seats']) || empty($_POST['status'])) {
                $session->message("<h2 class='alert'>Please fill out all required input<i class='fas fa-times closeBtn'></i></h2>");
                redirect("edit_reservation.php?r_id={$requestId}");
                return false;
            }

            if(empty($_POST['email']) && empty($_POST['tel'])) {
                $session->message("<h2 class='alert'> Please fill out at least one of the contact input <i class='fas fa-times closeBtn'></i></h2>");
                redirect("edit_reservation.php?r_id={$requestId}");
                return false;
            } 

            $reservation->id = $requestId;
            $reservation->request_name = $_POST['name'];
            $reservation->request_name = $_POST['name'];
            $reservation->request_email = $_POST['email'];
            $reservation->request_tel = $_POST['tel'];
            $reservation->request_num_seats = $_POST['seats'];
            $reservation->request_comment = $_POST['comments'];
            $reservation->request_via = $_POST['via'];
            $reservation->request_status = $_POST['status'];

            $reservation->request_date = $_POST['date'];
            $reservation->request_time = $_POST['time'];

            $reservation->request_edited_time = date("Y-m-d H:i:s");
            $reservation->save();

            $session->message("<h2 class='success'> 1 Reservation Updated <a class='check' href='reservation.php?source=details&r_id={$requestId}'>check</a><i class='fas fa-times closeBtn'></i></h2>"); 
            redirect("edit_reservation.php?r_id={$requestId}"); 

        } // end of $_POST['update']
    }

?>
<?php include "includes/navigation.php"; ?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <section class="main">
        <h1>Edit Reservation</h1>

        <div class="back">
        <?php
            if(isset($_GET['search'])) {
                echo "<a href='reservation.php?source=search_details&r_id={$requestId}'>";
            } else {
                echo "<a href='reservation.php?source=details&r_id={$requestId}'>";
            }
        ?>
                <i class="fas fa-chevron-left"></i>
                Back to Details
            </a>
        </div>

        <div class="reservationBox">
            <div class="message hide"></div>
            <?= isset($message)? $message : null;?>

            <form id="add" method="post">
                <div class="form-group">
                    <label for="name" class="short">Name*</label>
                    <input type="text" name="name" id="name" value="<?= $reservation->request_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email" class="short">Email</label>
                    <input type="email" name="email" id="email" value="<?= returnValueIfItsNotNull($reservation->request_email); ?>">
                </div>
                <div class="form-group">
                    <label for="tel" class="short">Phone</label>
                    <input type="tel" name="tel" id="tel" value="<?= returnValueIfItsNotNull($reservation->request_tel); ?>">
                </div>
                <div class="form-group">
                    <label class="long" for="">Date & Time*</label>
                    <div class="row">
                        <input class="short" type="date" name="date" id="date" value="<?= returnValueIfItsNotNull($reservation->request_date); ?>" required>
                        <select class="short" name="time" id="time" required>
                            <option value="" disabled selected> - Select -</option>
                            <option value="18:00" <?= checkSelected("18:00", $reservation->formatTime()); ?>>18:00</option>
                            <option value="18:30" <?= checkSelected("18:30", $reservation->formatTime()); ?>>18:30</option>
                            <option value="19:00" <?= checkSelected("19:00", $reservation->formatTime()); ?>>19:00</option>
                            <option value="19:30" <?= checkSelected("19:30", $reservation->formatTime()); ?>>19:30</option>
                            <option value="20:00" <?= checkSelected("20:00", $reservation->formatTime()); ?>>20:00</option>
                            <option value="20:30" <?= checkSelected("20:30", $reservation->formatTime()); ?>>20:30</option>
                            <option value="21:00" <?= checkSelected("21:00", $reservation->formatTime()); ?>>21:00</option>
                            <option value="21:30" <?= checkSelected("21:30", $reservation->formatTime()); ?>>21:30</option>
                            <option value="22:00" <?= checkSelected("22:00", $reservation->formatTime()); ?>>22:00</option>
                            <option value="22:30" <?= checkSelected("22:30", $reservation->formatTime()); ?>>22:30</option>
                            <option value="23:00" <?= checkSelected("23:00", $reservation->formatTime()); ?>>23:00</option>
                            <option value="23:30" <?= checkSelected("23:30", $reservation->formatTime()); ?>>23:30</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="seats" class="long">Number of Seats*</label>
                    <select name="seats" id="seats"  class="short" requered>
                        <option value="" disabled selected> - Select -</option>
                        <option value="1" <?= checkSelected(1, $reservation->request_num_seats); ?>>1</option>
                        <option value="2" <?= checkSelected(2, $reservation->request_num_seats); ?>>2</option>
                        <option value="3" <?= checkSelected(3, $reservation->request_num_seats); ?>>3</option>
                        <option value="4" <?= checkSelected(4, $reservation->request_num_seats); ?>>4</option>
                        <option value="5" <?= checkSelected(5, $reservation->request_num_seats); ?>>5</option>
                        <option value="6" <?= checkSelected(6, $reservation->request_num_seats); ?>>6</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comments" class="long">Special Request</label>
                    <textarea name="comments" id="comments" cols="30" rows="10"><?= returnValueIfItsNotNull($reservation->request_comment); ?></textarea>
                </div>
                <div class="form-group checkbox-container">
                    <label for="" class="long">Reservation via</label>
                        <div class="radioBtnContainer">
                            <label for="website" class="checkboxlabel">Website</label>
                            <input type="radio" name="via" value="website"  <?= checkChecked("website", $reservation->request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="phone" class="checkboxlabel">Phone</label>
                            <input type="radio" name="via" value="phone"  <?= checkChecked("phone", $reservation->request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="facebook" class="checkboxlabel">Facebook</label>
                            <input type="radio" name="via" value="facebook" <?= checkChecked("facebook", $reservation->request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="twitter" class="checkboxlabel">Twitter</label>
                            <input type="radio" name="via" value="twitter" <?= checkChecked("twitter", $reservation->request_via); ?>>
                        </div>
                        <div class="radioBtnContainer">
                            <label for="others" class="checkboxlabel">Other</label>
                            <input type="radio" name="via" value="others" <?= checkChecked("other", $reservation->request_via); ?>>
                        </div>
                <div class="form-group">
                    <label for="status" class="long">Reservation Status*</label>
                    <select name="status" id="status"  class="short" requered>
                        <option value="" disabled> - Select -</option>
                        <option value="confirmed" <?= checkSelected("confirmed", $reservation->request_status); ?>>Confirmed</option>
                        <option value="canceled" <?= checkSelected("canceled", $reservation->request_status); ?>>Canceled</option>
                        <option value="pending" <?= checkSelected("pending", $reservation->request_status); ?>>Pending</option>
                    </select>
                </div>
                <div class="form-group hidden">
                    <input type="date" name="request_edited_time" value="<?php time() ?>" hidden>
                </div>
                
                <div class="form-group btn-container">
                    <a type="button" href="edit_reservation.php?r_id=<?= $requestId; ?>" class="btn">Clear</a>
                    <input type="submit" name="update" value="Update" class="btn" id="send">
                </div>
                
            </form>
        </div> <!-- end of .reservationBox -->
        <?php include "includes/footer.php"; ?>
