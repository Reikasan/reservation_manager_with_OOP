<section class="main">
    <h1>Reservation Details</h1>

    <div class="back">
    <?php 
    if(isset($_SESSION['currentPage'])) {
        $page = $_SESSION['currentPage'];
        echo "<a href='reservation.php?page={$page}'>";
    } else {
        echo "<a href='reservation.php'>";
    }
    ?>
            <i class="fas fa-chevron-left"></i>
            Back to All reservations
        </a>
    </div>
    
    <div class="reservationDetails">
        
    <?php
    $status = new Status();

    // STATUS CHANGE
    if(isset($_POST['newStatus'])){
        $selectedRequestId = escape($_POST['request_id']);
        $newStatus = escape($_POST['newStatus']);
        $status->changeStatus($newStatus, $selectedRequestId);

        redirect('reservation.php?source=details&p_id='.$selectedRequestId);
    }

    // SHOW DATA FROM REQUEST_ID
    if(isset($_GET['p_id'])){
        $requestId = $_GET['p_id'];
    ?>
        <div class="anotherReservation">
            <ul>
    <?php
        // SELECT ALL DATA FROM REQUEST_ID
        $reservations = Reservation::find_by_id("request_id", $requestId);
        foreach($reservations as $reservation) :

            $formattedRequestDate = $reservation->formatDate();
            $formattedRequestTime = $reservation->formatTime();

            // format date and time
            $formattedRequestReceivedTime = date_create($reservation->request_recieved_time);
            $formattedRequestReceivedTime = date_format($formattedRequestReceivedTime, 'D d.m.Y H:i');

            
            // change request status 'unread' to 'pending"
            $requestStatus = $reservation->request_status;

            if($requestStatus === 'unread') {
                $newStatus = "pending";
                $status->changeStatus($newStatus, $requestId);

                $requestStatus = $newStatus;
            } 

            // SELECT ALL DATA FROM SAME REQUEST_DATE
            $anotherRequests = Reservation::selectByRequestDate($reservation->request_date);
            $numAnotherReservations = count($anotherRequests);

            if($numAnotherReservations <= 1) {
                echo "<li class='date'>No other reservation on $formattedRequestDate</li>";
            } else {
                echo "<li class='date'><i class='fas fa-exclamation'></i> $numAnotherReservations Requests on $formattedRequestDate<i class='fas fa-caret-down dropdown2'></i></li>";
            
                foreach($anotherRequests as $anotherRequest):           
    ?>
                <li class="<?= checkSelected($requestId, $anotherRequest->request_id); ?>" >
                    <a href="reservation.php?source=details&p_id=<?= $anotherRequest->request_id; ?>">
                        <div class="list-container">
                            <div class="details">
                                <p class="small"><?= $anotherRequest->formatTimestamp("request_recieved_time"); ?></p>
                                <div>
                                    <p><?php echoFlag($anotherRequest->isFlagged()); ?></p>
                                    <p><?= $anotherRequest->request_time; ?></p>
                                    <p><?= $anotherRequest->request_num_seats; ?> Seats</p>
                                    <?php echoCommentSign($anotherRequest->request_comment); ?>
                                </div>
                            </div>
                            <div class="status <?= $anotherRequest->request_status; ?>">
                                <p><?= $anotherRequest->request_status; ?></p>
                            </div>
                        </div>
                    </a>
                </li>
                <?php
                endforeach;
            }
                ?>
            </ul>
        </div>
        <div class="mail">
            <div class="mail-header">
                <form action="" method="post" class="status <?= $requestStatus; ?>">
                    <select name="newStatus" class="status <?= $requestStatus; ?>" onchange="this.form.submit()">
                        <option value="unread" <?= checkSelected("unread", $requestStatus); ?>>Unread</option>
                        <option value="pending" <?= checkSelected("pending", $requestStatus); ?>>Pending</option>
                        <option value="confirmed" <?= checkSelected("confirmed", $requestStatus); ?>>Confirmed</option>
                        <option value="canceled" <?= checkSelected("canceled", $requestStatus); ?>>Canceled</option>
                    </select>
                    <input type="text" value="<?= $reservation->request_id; ?>" name="request_id" readonly class="hide">
                </form>
                <div class="row">
                    <?php echoFlag($reservation->isFlagged()); ?>
                    <table class="small">
                        <tbody>
                            <tr>
                                <td>Received </td>
                                <td>: <?php echo $reservation->formatTimestamp("request_recieved_time"); ?></td>
                            </tr>
                            <?php
                            if($reservation->request_edited_time !== null) {
                            ?>
                            <tr>
                                <td>Edited </td>
                                <td>: <?= $reservation->formatTimestamp("request_edited_time"); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>                    
                </div>
                
            </div> <!-- end of mail-header -->
            <table class="mail-contents">
                <tbody>
                    <tr>
                        <td class="label">Name :</td>
                        <td class="contents"><?= $reservation->request_name; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Email :</td>
                        <td class="contents"><?= $reservation->request_email; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Phone :</td>
                        <td class="contents"><?= $reservation->request_tel == "" ? " - " :  $reservation->request_tel; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Reservation Time :</td>
                        <td class="contents"><?= $formattedRequestTime; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Seats :</td>
                        <td class="contents"><?= $reservation->request_num_seats; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Special Request :</td>
                        <td class="contents comment"><?= $reservation->request_comment; ?></td>
                    </tr>
                </tbody>
            </table> <!-- end of mail-contents -->
            <form class="editBtnContainer" action="edit_reservation.php?r_id=<?= $reservation->request_id; ?>" method="post">
                <input type="submit" value="Edit" class="btn">
            </form>
            <div class="down hide">
                <i class="fas fa-angle-down"></i>
            </div>
<?php endforeach;

}
      ?> 
        </div> <!-- end of mail -->
    </div> <!-- end of .reservationBox -->
