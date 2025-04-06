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

    <style>
        body {
            background-image: url('https://img.freepik.com/free-vector/abstract-secure-technology-background_23-2148331624.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            display: flex;
            gap: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
        }

        .left {
            width: 45%;
        }

        .right {
            width: 55%;
        }

        h2 {
            margin-bottom: 10px;
            color: #f0f0f0;
        }

        p {
            color: #e0e0e0;
        }

        .user-email {
            font-weight: bold;
            color: #00d0ff;
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

        .btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-link {
            background: none;
            border: none;
            color: #007BFF;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            text-decoration: underline;
        }

        .error-messages .error,
        .success-messages .success {
            color: white;
            margin-bottom: 10px;
        }

        .success-messages .success {
            color: limegreen;
        }

        .register {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
       
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
