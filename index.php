<?php include "includes/header.php"; ?>
<?php 
    if(!$session->is_signed_in()) { redirect("login.php"); } 
    $session->finish_search();
    $session->unset_displayedMonth();
?>
<?php include "includes/navigation.php"; ?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <!-- main content -->
    <section class="main">
        <div class="todays-reservation">
            <h1>Today's Reservation</h1>
            <div class="reservationBox index-page">
            <?php
                $today = date("Y-m-d");
                $filter = new Filter();
                $filters = " Where request_date = '{$today}' ";
                $numResult = count(Reservation::searchReservation($filter, $filters));                
                $reservations = Reservation::searchReservation($filter, $filters);

                if($numResult >= 1 ) :
                ?>
                    <table>
                        <thead>
                            <tr>
                                <th><i class='far fa-flag'></i></th>
                                <th>Time</th>
                                <th>Name</th>
                                <th>Seats</th>
                                <th class='commentCell'>Special Request</th>
                                <th class='detailCell'>Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php foreach($reservations as $reservation) : ?>
                            <tr>
                                <td><i class="fa-flag <?= $reservation->isFlagged(); ?>" data="<?= $reservation->request_id; ?>"></i></td> 
                                <td class="timeCell"><?= $reservation->formatTime(); ?></td>
                                <td class="name"><?= $reservation->request_name; ?></td>
                                <td><?= $reservation->request_num_seats; ?></td>
                                <td class="commentCell"><?= $reservation->substringedComment(); ?></td>
                                <td class="detailCell"><button class="btn details"><a href="reservation.php?source=details&r_id=<?= $reservation->request_id; ?>">Details</a></button></td>
                                <td title="go to details"><a href="reservation.php?source=details&r_id=<?= $reservation->request_id; ?>" class="btn status <?= $reservation->request_status; ?>" title="<?= $reservation->request_status; ?>"><?= $reservation->request_status; ?></a></td>
                            </tr>
                    
                <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php 
                    else :
                        echo "<h1 class='no-data'>No Reservation</h1>";
                    endif;
                ?>
            </div>
        </div>
        <?php
            // CHECK UNREAD REQUEST
            $unreadFilter = " Where request_status = 'unread' ";
            $numUnread = count(Reservation::searchReservation($filter, $unreadFilter));
        ?>
        <div class="reservation">
            <div class="icon">
                <a href="reservation.php">
                    <i class="far fa-envelope"></i>
                    <h2>Reservation Request</h2>
                    <?php
                    if($numUnread > 0){
                        echo "<div class='new'>$numUnread</div>";
                    } 
                    ?>
                    
                </a>
            </div>
            <div class="icon">
                <a href="calendar.php">
                    <i class="far fa-calendar"></i>
                    <h2>Calendar</h2>
                </a>
            </div>
        </div>
        <?php include "includes/footer.php" ?>

