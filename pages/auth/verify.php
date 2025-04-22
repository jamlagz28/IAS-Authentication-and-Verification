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
    <title>Confirm Email</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">

    <style>
        body {
            background-image: url('https://t4.ftcdn.net/jpg/01/89/03/15/360_F_189031578_Vbt5GyJy47xjEEgLXxcq3HyoLyDf6BNS.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-wrapper {
            display: flex;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 100%;
            gap: 40px;
        }

        .info-section, .form-section {
            width: 50%;
        }

        .info-section h2 {
            color: #ffffff;
            margin-bottom: 12px;
        }

        .info-section p {
            color: #e2e2e2;
        }

        .user-highlight {
            color: #00f0ff;
            font-weight: bold;
        }

        .form-section h2 {
            margin-bottom: 10px;
            color: #ffffff;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #004a99;
        }

        .link-btn {
            background: transparent;
            border: none;
            color: #00aaff;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            margin-top: 10px;
        }

        .feedback {
            margin-bottom: 10px;
        }

        .feedback .error {
            color: #ff4d4d;
        }

        .feedback .success {
            color: #33cc33;
        }

        .resend-section {
            color: #fff;
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="card-wrapper">
        <div class="info-section">
            <h2>Check Your Inbox</h2>
            <p>We've sent a code to the email address:</p>
            <p class="user-highlight"><?= htmlspecialchars($email) ?></p>
        </div>

        <div class="form-section">
            <h2>Enter Your Code</h2>

            <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="feedback">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p class="error"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
                <div class="feedback">
                    <p class="success"><?= htmlspecialchars($_SESSION['success']) ?></p>
                </div>
            <?php endif ?>

            <form action="verify-email" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

                <div class="input-group">
                    <input type="text" name="code" <?= Helper::oldValue("code", "Enter your code") ?> required>
                </div>

                <button type="submit" class="btn-submit">Submit Code</button>
            </form>

            <div class="resend-section">
                Didn't get the code?
                <form action="verify-email" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                    <button type="submit" class="link-btn">Send a new one</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Cleanup session after rendering
unset($_SESSION['errors']);
unset($_SESSION['old']);
unset($_SESSION['success']);
?>
