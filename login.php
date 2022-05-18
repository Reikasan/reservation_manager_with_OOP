<?php include "includes/header.php"; ?>

<!-- navigation -->
<?php include "includes/navigation.php"; ?>
<?php 
if($session->is_signed_in()) {
    redirect("index.php");
}

//LOGIN FUNCTION
if(isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = User::verify_user($username, $password);

    if($user) {
        $session->login($user);
        redirect("index.php");
    } else {
        $message = "<h2 class='warning'>Your password or username is incorrect</h2>";
    }
} else {
    $username = "";
    $password = "";
    $message = "";
}
?>
	<!-- Page Content -->
	<div class="container">
		<div class="client-logo">
			<img src="img/bar-logo.jpg" alt="client-logo" title="client-logo">
		</div>	
        <div class="message-container">
            <?= isset($message) ? $message: null; ?>
        </div>
        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" value="Bar_at_Tokio"  readonly>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" value="bar1" placeholder="enter your password" requered>
                <br>
                <a class="forgot" href="forgot.php">Forget your password?</a>
            </div>
            <input class="btn" type="submit" value="Login" name="login">
        </form>
	</div> <!-- /.container -->
    <footer>
        <div class="copyright">
            <small>2021 &#64;Reika Akuzawa</small>
        </div> 
    </footer>
    <script src="js/script.js"></script>
</body>
    
</html>
