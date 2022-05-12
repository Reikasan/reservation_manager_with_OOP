<nav>
<?php 
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user' ) {
    echo $_SESSION['user_role'];
    $logoUrl = "index.php";
    $logoutLink = ' <li class="logoutBtn"><a href="includes/logout.php">Logout</a></li>';
} else {
    $logoUrl = "login.php";
}
?>

    <div class="logo"><a href="<?php echo $logoUrl; ?>">Reservation Manager</a></div>
    <ul class="right">
        <li><a href="contact">Contact</a></li>
    <?php
        if(isset($logoutLink)) {
            echo $logoutLink;
        }
    ?>
    
    </ul>
</nav>