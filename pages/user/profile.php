<?php

use Utils\Helper;

$user = $_SESSION['user'];

$csrfToken = Helper::generateCsrfToken();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/css/profile.css">
</head>

<body>
    <div class="navbar">
        <a href="home">
            <div class="brand">Home</div>
        </a>
    </div>
    <div class="container">
        <h1>Profile Settings</h1>

        <?php if (isset($_SESSION['success']['update-profile'])): ?>

            <div class="success-messages">
                <p class="success"><?= $_SESSION['success']['update-profile'] ?></p>
            </div>

        <?php elseif (isset($_SESSION['error']['update-profile'])): ?>

            <div class="error-messages">
                <p class="error"><?= $_SESSION['error']['update-profile'] ?></p>
            </div>

        <?php endif ?>
        <form method="POST" action="update-profile">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" <?= Helper::oldValue('name', "$user[name]"); ?>>
                <?= Helper::showError('name') ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" value="<?= $user['email']; ?>" disabled>
            </div>
            <button name="update-profile" type="submit" class="btn">Update Profile</button>
        </form>
    </div>
    <div class="container">
        <h2>Change Password</h2>
        <?php if (isset($_SESSION['success']['update-password'])): ?>
            <div class="success-messages">
                <p class="success"><?= $_SESSION['success']['update-password'] ?></p>
            </div>
        <?php elseif (isset($_SESSION['errors']['update-password'])) : ?>
            <div class="error-messages">
                <p class="error"><?= $_SESSION['errors']['update-password'] ?></p>
            </div>
        <?php endif ?>
        <form action="update-profile" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" name="current-password" id="current-password" required>
                <?= Helper::showError('current-password') ?>
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" name="password" id="new-password" required>
                <?= Helper::showError('password') ?>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" name="confirm-password" id="confirm-password" required>
                <?= Helper::showError('confirm-password') ?>

            </div>
            <button name="update-password" type="submit" class="btn">Update Password</button>
        </form>

    </div>

    <div class="container">

        <h2>Delete Account</h2>
        <form action="update-profile" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <button name="delete" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
    <script src="assets/javascript/main.js"></script>
</body>

</html>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
unset($_SESSION['success']);

?>