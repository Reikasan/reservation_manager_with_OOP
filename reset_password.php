<?php include "includes/header.php"; ?>

<!-- navigation -->
<?php include "includes/navigation.php"; ?>
<?php 
$token_is_expired = false;
$password_changed = false;

$token = new Token();
$user_id = $token->find_by_token($_GET['token'])->user_id;

if($session->is_signed_in()) {
    redirect("index.php");
}

if(!isset($_GET['email']) && !isset($_GET['token'])) {
    redirect("index.php");
}

if(!$token->isEmailValid($_GET['token'], $_GET['email'])) {
    redirect("index.php");
}

if($token->isTokenExpired($_GET['token'])) {
    $token_is_expired = true;
    $message = "<h2 class='warning'>Password reset request is expired. Please send new request. <i class='fas fa-times closeBtn'></i></h2>";
}


if(isset($_POST['resetPass'])) {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if($password === "" || $confirm_password =="") {
        $message = "<h2 class='alert'>Password can not be empty.<i class='fas fa-times closeBtn'></i></h2>";
    }

    if($password === $confirm_password) {
        $user = new User();

        if($user->updatePassword($password, $user_id)) {
            $password_changed = true;
            $message = "<h2 class='success'>Password has been successfully changed. <i class='fas fa-times closeBtn'></i></h2>";
        } else {
            $message = "<h2 class='warning'>Something wrong... Please try again.<i class='fas fa-times closeBtn'></i></h2>";
        }
    } else {
        $message = "<h2 class='warning'>Password doesn't match. Please try again.<i class='fas fa-times closeBtn'></i></h2>";
    }
}

?>
<!-- Page Content -->
	<div class="container">
        <h1 class="text-center">Reset Password</h1>	
        <div class="message-container">
            <?= isset($message) ? $message: null; ?>
        </div>
        <?php if($password_changed): ?>
        <div class="link">
                <a href="login.php">Login</a>
            </div>
        <?php elseif($token_is_expired): ?>
            <div class="link">
                <a href="forgot.php">Reset Password</a>
            </div>

        <?php else: ?>
        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" placeholder="Enter new Password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">New Password</label>
                <input type="password" name="confirm_password" placeholder="Enter new Password again"required>
            </div>
            <input type="text" name="token" value="<?= $_GET['token']; ?>" hidden>
            <div class="form-group comment">
                <p>You can change Password from this page, but don't worry no effect to login function!</p>
            </div>
            <input class="btn" type="submit" value="Reset" name="resetPass">
        </form>
        <?php endif; ?> 
	</div> <!-- /.container -->
    <footer>
        <div class="copyright">
            <small>2021 &#64;Reika Akuzawa</small>
        </div> 
    </footer>
    <script src="js/script.js"></script>
</body>
    
</html>