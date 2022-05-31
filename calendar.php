<?php include "includes/header.php"; ?>
<?php 
    if(!$session->is_signed_in()) { redirect("login.php"); } 
    $session->finish_search();
?>
<?php 

$calendar = new Calendar();

?>
<?php include "includes/navigation.php"; ?>

<div class="container">
    <!-- sidebar -->
    <?php include "includes/sidebar.php"; ?>

    <!-- main content -->
    <section class="main">
        <div class="calendar">
            <h1 class="month"><a title="show last month" class="previous" href="calendar.php?month=<?php $calendar->getPreviousMonth(); ?>">&lt;</a>&nbsp;<?= $calendar->calendar_title; ?>&nbsp;<a title="show next month" class="next" href="calendar.php?month=<?php $calendar->getNextMonth(); ?>">&gt;</a></h1>
            <table id="main-calendar-frame">
                <tr id="week">
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                    <th>Sun</th>
                </tr>
                <?php
                    $calendar->showCalendar();
                ?>
            </table>

        </div>

        <?php include "includes/footer.php" ?>


