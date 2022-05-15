<nav>
<?php 
if($session->is_signed_in()) {
    $logoUrl = "index.php";
    $logoutLink = ' <li class="logoutBtn"><a href="logout.php">Logout</a></li>';
} else {
    $logoUrl = "login.php";
};

?>

    <div class="logo"><a href="<?= $logoUrl; ?>">Reservation Manager</a></div>
    <ul class="right">
        <li><a href="contact">Contact</a></li>
    <?= isset($logoutLink) ? $logoutLink : null ; ?>
    
    </ul>
</nav>