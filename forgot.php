<?php include "includes/header.php"; ?>

<!-- navigation -->
<?php include "includes/navigation.php"; ?>
<?php 
if($session->is_signed_in()) {
    redirect("index.php");
}

if(isset($_POST['resetPass'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $user = new User();
    $isEmailVerified = $user->verify_user_email($username, $email);

    if($isEmailVerified) {
        $length = 50;
        
        $token = new Token();
        $token->user_id = $user->fetch_value($username, 'user_id');
        $token->email = $email;
        $token->token = $token->create_token($length);
        $token->issue_date_time = $token->format_issue_date();
        $token->expire_date_time = $token->create_and_format_expire_date($token->create_issue_date());
        $token->save();

        $_SESSION['token'] = $token->token;
        $_SESSION['email'] = $email;
        $_SESSION['issue_date'] = $token->issue_date_time;

        $email = "";
        $message = "<h2 class='success'>Password reset request has been sent. <i class='fas fa-times closeBtn'></i></h2>";
        $dummy = "<h2 class='dummy'>Dummy Email is <a href='email.php' target='_blank'>HERE</a><i class='fas fa-times closeBtn'></i></h2>";
    } else {
        $message = "<h2 class='alert'>Email doesn't much with your Username <i class='fas fa-times closeBtn'></i></h2>";
    }   
}

?>
<!-- Page Content -->
	<div class="container">
        <h1 class="text-center">Reset Password</h1>	
        <div class="back">
            <a href='login.php'>
            <i class="fas fa-chevron-left"></i>
            Back to Login page
            </a>
        </div>
        <div class="message-container">
            <?= isset($message) ? $message: null; ?>
            <?= isset($dummy) ? $dummy: null;?>    
        </div>
        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" value="Bar_at_Tokio"  readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="" placeholder="enter your Email" requered>
            </div>
            <div class="form-group comment">
                <p>* This page is used only for demonstration purpose, mail isn't sent to entered Email Address</p>
                <p>* sample Email is "barattokio@sample.com"</p>
            </div>
            
            <input class="btn" type="submit" value="Send Request" name="resetPass">
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