<?php

use Utils\Helper;

$csrfToken = Helper::generateCsrfToken();


$verified = $_SESSION['email_verified'] ?? null;
$email = $_SESSION['email'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Password</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">
</head>

<body>
    <div class="container">
        <div class="left">
            <h2>Forgot Your Password?</h2>

            <p>Enter your new password</p>


        </div>
        <div class="right">
            <h2>Recover Password</h2>

            <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="error-messages">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p class="error"><?= htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
                <div class="success-messages">
                    <p class="success"><?= htmlspecialchars($_SESSION['success']); ?></p>
                </div>
            <?php endif ?>

            <?php if ($verified): ?>

                <form action="reset-password" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <input type="hidden" name="identifier" value="<?= $email ?>">
                    <div class="input-group">
                        <input type="password" name="password" <?= Helper::oldValue("password", "New password") ?> required>
                        <i class="fa fa-eye"></i>
                    </div>
                    <div class="input-group">
                        <input type="password" name="confirm_password" <?= Helper::oldValue("confirm_password", "Confirm password") ?> required>
                        <i class="fa fa-eye"></i>

                    </div>

                    <button type="submit" class="btn">Reset Password</button>

                </form>
            <?php else: ?>
                <form action="reset-password" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div class="input-group">
                        <input name="email" type="email" <?= Helper::oldValue('email', 'Enter your email') ?> required>
                    </div>
                    <button type="submit" class="btn">Reset Password</button>
                </form>
            <?php endif ?>

            <div class="register">
                Remembered your password? <a href="sign-in">Sign In</a>
            </div>
        </div>
    </div>
</body>

</html>


<?php
// Clear session errors after displaying
unset($_SESSION['errors']);
unset($_SESSION['old']);
unset($_SESSION['success']);
?>