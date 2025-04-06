<?php

use Utils\Helper;
$csrfToken = Helper::generateCsrfToken();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>

<body>
    <div class="container">
        <div class="left">
            <h2>Join Us!</h2>
            <p>Create an account to get started.</p>
        </div>
        <div class="right">
            <h2>Sign Up</h2>
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="error-messages">
                    <?php Helper::showError("general") ?>
                </div>
            <?php endif; ?>
            <form action="sign-up" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="input-group">
                    <input type="text" name="full_name" <?= Helper::oldValue("full_name", "Full name") ?> required>
                    <?php Helper::showError("full_name") ?>
                </div>
                <div class="input-group">
                    <input type="email" name="email" <?= Helper::oldValue("email", "Email") ?> required>
                    <?php Helper::showError("email") ?>

                </div>
                <div class="input-group">
                    <input type="password" name="password" <?= Helper::oldValue("password", "Password") ?> required>
                    <i class="fa fa-eye"></i>
                    <?php Helper::showError("password") ?>


                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" <?= Helper::oldValue("confirm_password", "Confirm password") ?> required>
                    <i class="fa fa-eye"></i>
                    <?php Helper::showError("confirm_password") ?>


                </div>
                <button type="submit" class="btn">Sign Up</button>
            </form>
            <div class="register">
                Already have an account? <a href="sign-in">Sign In</a>
            </div>
        </div>
    </div>
    <script src="assets/javascript/main.js"></script>
</body>

</html>

<?php
// Clear session errors after displaying
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>