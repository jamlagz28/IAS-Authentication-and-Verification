<?php

use Utils\Helper;

$csrfToken = Helper::generateCsrfToken();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>

<body>
    <div class="container">
        <div class="left">
            <h2>Welcome back!</h2>
            <p>You can sign in to access your existing account.</p>
        </div>
        <div class="right">
            <h2>Sign In</h2>
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="error-messages">
                    <?php Helper::showError("general") ?>
                </div>
            <?php endif; ?>

            <form action="sign-in" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="input-group">
                    <input type="text" name="email" <?= Helper::oldValue("email", "Enter your email") ?> required>
                    <?php Helper::showError("email") ?>

                </div>
                <div class="input-group">
                    <input type="password" name="password" <?= Helper::oldValue('password', 'Password') ?> required>
                    <?php Helper::showError("password") ?>

                    <i class="fa fa-eye"></i>
                </div>
                <div class="options">
                    <label>
                        <input name="remember_me" type="checkbox"> Remember me</label>
                    <a href="reset-password">Forgot password?</a>
                </div>
                <button type="submit" class="btn">Sign In</button>
            </form>
            <div class="register">
                New here? <a href="sign-up">Create an Account</a>
            </div>
        </div>
    </div>
    <script src="assets/javascript/main.js"></script>
</body>

</html>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>