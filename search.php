<?php 
    ob_start();
    include "includes/header.php";
    include "includes/navigation.php"; 
?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <section class="main">
        <h1>Search result</h1>
        <?php include "includes/searchbox.php"; ?>
       
        <div class="back">
            <?php 
            if(isset($session->current_page)) {
                echo "<a href='reservation.php?page={$session->current_page}'>";
            } else {
                echo "<a href='reservation.php'>";
            }
            ?>
                <i class="fas fa-chevron-left"></i>
                Back to All reservations
            </a>
        </div>

        <div class="reservationBox"> 

        <!-- SEARCH AND FILTERS -->
        <?php include "includes/search_filter.php"; ?>
        
        <!-- BULK OPTIONS -->
        <?php include "includes/bulkoptions.php"; ?>

        <?php
            $filter->echoFilterBtn();
            
            if($numResult === null) {
                redirect("index.php");

            } elseif($numResult === 0) {
                echo $message = "<h2 class='alert'>Found no result <i class='fas fa-times closeBtn'></i></h2>";
            } else {
                if($numResult === 1) {
                    echo $message = "<h2 class='success'>Found $numResult result <i class='fas fa-times closeBtn'></i></h2>";
                } elseif($numResult > 1) {
                    echo $message = "<h2 class='success'>Found $numResult results <i class='fas fa-times closeBtn'></i></h2>"; 
                }
        ?>
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                            <th><i class="fas fa-circle unread"></i></th>
                            <th><i class="far fa-flag"></i></th>
                            <th>Date</th>
                            <th class='timeCell'>Time</th>
                            <th>Name</th>
                            <th>Seats</th>
                            <th class='commentCell'>Special Request</th>
                            <th class='detailCell'>Details</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php
            foreach($reservations as $reservation) :
                $request_id = $reservation->request_id;
                $request_name = $reservation->request_name;
                $request_email = $reservation->request_email;
                $request_tel = $reservation->request_tel;
                $request_date = $reservation->formatDate($reservation->request_date);
                $request_time = $reservation->formatTime($reservation->request_time);
                $request_num_seats = $reservation->request_num_seats;
                $request_comment = $reservation->request_comment;
                $request_status = $reservation->request_status;
                $request_recieved_time = $reservation->request_recieved_time;
                $request_edited_time = $reservation->request_edited_time;
                $request_flag = $reservation->request_edited_time;
                $request_via = $reservation->request_edited_time;            
        ?>
                        <tr class="<?= $reservation->isPastEvent();?>">
                            <td><input class="checkbox" type="checkbox" name="checkBoxArray[]" value="<?= $reservation->request_id; ?>"></td>
                            <td><?= $reservation->showUnreadSign(); ?></td>
                            <td><i class="fa-flag <?= $reservation->isFlagged(); ?>" data="<?= $reservation->request_id; ?>"></i></td>
                            <td><?= $reservation->formatDate(); ?></td>
                            <td class="timeCell"><?= $reservation->formatTime(); ?></td>
                            <td class="name"><?= $reservation->request_name; ?></td>
                            <td><?= $reservation->request_num_seats; ?></td>
                            <td class="commentCell"><?= $reservation->substringedComment(); ?></td>
                            <td class="detailCell"><button class="btn details"><a href="reservation.php?source=details&r_id=<?= $reservation->request_id; ?>">Details</a></button></td>
                            <td title="go to details"><a href="reservation.php?source=details&r_id=<?= $reservation->request_id; ?>" class="btn status <?= $reservation->request_status; ?>" title="<?= $reservation->request_status; ?>"><?= $reservation->request_status; ?></a></td>
                        </tr>
        <?php
         endforeach;     
            }  // end if/else
        ?>
                    </tbody>
                </table>
            </form> <!-- end of bulkoptions form -->
            <!-- PAGINATION -->
            <ul class="pagination">
                    <?php 
                    // $paginate = new Paginate();
                        if($paginate->page_total() > 1) {
                            $paginate->has_previous("search.php",$session->filterParameter);
                            $paginate->show_pagination("search.php",$session->filterParameter);
                            $paginate->has_next("search.php",$session->filterParameter);
                        }
                    ?>
            </ul>
     </div> <!-- end of .reservationBox --> 
<?php include "includes/footer.php"; ?>
<?php ob_end_flush(); ?>
