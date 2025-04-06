<?php

use Utils\Helper;
$csrfToken = Helper::generateCsrfToken();


$email = $_SESSION['verification_email'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">

</head>

<body>


    <div class="container">
        <div class="left">
            <h2>Email Verification</h2>
            <p>Enter the verification code sent to your email</p>
            <p class="user-email"><?= $email ?></p>
        </div>
        <div class="right">
            <h2>Verify Your Email</h2>
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
            <form action="verify-email" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="input-group">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                    <input type="text" name="code" <?= Helper::oldValue("code", "Enter verification code") ?> required>
                </div>
                <button type="submit" class="btn">Verify</button>
            </form>
            <div class="register">
                Didn't receive the code?
                <form action="verify-email" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                    <button type="submit" class="btn-link">Request a new one</button>
                </form>
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