<?php
// clear previous search data
// unset($_SESSION['searchText']);
// unset($_SESSION['searchCategory']);
// unset($_SESSION['query']);
// unset($_SESSION['searchQuery']);
// unset($_SESSION['displayName']);
// unset($_SESSION['filters']);
// unset($_SESSION['filterValues']);
// unset($_SESSION['filterQueries']);
// unset($_SESSION['currentPage']);
// $session->unset_search_set();


?>
<section class="main">
    <h1>Reservation Request</h1>
    <?php include "includes/searchbox.php"; ?>
    <div class="reservationBox">
        <!-- BULK OPTIONS -->
        <?php include "includes/bulkoptions.php"; ?>

        <?= isset($message) ? $message : null; ?>
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                    <th><i class="fas fa-circle"></i></th>
                    <th><i class="far fa-flag"></i></th>
                    <th>Date</th>
                    <th class="timeCell">Time</th>
                    <th>Name</th>
                    <th>Seats</th>
                    <th class='commentCell'>Special Request</th>
                    <th class='detailCell'>Details</th>
                    <th>Status</th>
                </tr>
            </thead> 
            <tbody>
            <?php
                
                // Set val for pagination
                $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
                $items_per_page = 10;
                $items_total_count = Reservation::count_all();
                $paginations_per_page = 5;

                $_SESSION['currentPage']= $page;

                // Show Reservations
                $paginate = new Paginate($page, $items_per_page, $items_total_count, $paginations_per_page);
                
                $sql = "SELECT * FROM reservation_request ";
                $sql .= "ORDER BY request_recieved_time DESC ";
                $sql .= "LIMIT {$items_per_page} ";
                $sql .= "OFFSET {$paginate->offset()}";
                $reservations = Reservation::find_by_query($sql);
               
                foreach($reservations as $reservation) :
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
            
            <?php endforeach; ?>
                </tbody>
            </table>
        </form>
        <!-- PAGINATION -->
        <ul class="pagination">
        <?php 
            if($paginate->page_total() > 1) {
                $paginate->has_previous("reservation.php");
                $paginate->show_pagination("reservation.php");
                $paginate->has_next("reservation.php");
            }
        ?>
        </ul>
        
    </div>
