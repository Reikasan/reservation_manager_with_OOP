<?php include "includes/header.php"; ?>

<!-- navigation -->

<?php 
    $token = new Token();
    $token->token = $_SESSION['token'];
    $token->email = $_SESSION['email'];
    $token->issue_date_time = $_SESSION['issue_date'];

    // unset($_SESSION['token']);
    // unset($_SESSION['email']);
    // unset($_SESSION['issue_date']); 
?>
<!-- Page Content -->
	<div class="container mail">
        <div class="mail-header">
            <h2>Reservation Manager</h2>	
            <h3>Reset Your Password</h3>
            <h3>To: <?= $token->email; ?></h3>
            <p><?= $token->issue_date_time; ?></p>
        </div>
        <div class="mail-contents">
            <h2 class="text-center">Reset Your Password</h2>
            <p>Hello! This email has been sent to you to reset your login password.</p>
            <p>Please click the link below to complete the password reset process. This link will expire in 24 hours.</p>
            <div class="link">
            <a href="reset_password.php?<?= $token->token; ?>">Reset Password</a>
            </div>
        </div>
        <div class="mail-footer">
            <h4>Reservation Manager</h4>
            <a href="#">https://reservation_manager.com</a><br>
            <a href="#">contact@reservation_manager.com</a>
        </div>
        
	</div> <!-- /.container -->
    <footer>
        <div class="copyright">
            <small>2021 &#64;Reika Akuzawa</small>
        </div> 
    </footer>
    <script src="js/script.js"></script>
</body>
    
</html>