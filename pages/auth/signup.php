<?php

use Utils\Helper;
$csrfToken = Helper::generateCsrfToken();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('https://images.unsplash.com/photo-1586281380349-632531db7edb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-wrapper {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px 25px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .auth-wrapper h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-control {
            margin-bottom: 15px;
            position: relative;
        }

        .form-control input {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-control i {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #2980b9;
        }

        .switch-page {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
        }

        .switch-page a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }

        .switch-page a:hover {
            text-decoration: underline;
        }

        .error-messages {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>

    <div class="auth-wrapper">
        <h2>Register New Account</h2>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error-messages">
                <?php Helper::showError("general") ?>
            </div>
        <?php endif; ?>

        <form action="sign-up" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <div class="form-control">
                <input type="text" name="full_name" <?= Helper::oldValue("full_name", "Enter your full name") ?> required>
                <?php Helper::showError("full_name") ?>
            </div>

            <div class="form-control">
                <input type="email" name="email" <?= Helper::oldValue("email", "Your email address") ?> required>
                <?php Helper::showError("email") ?>
            </div>

            <div class="form-control">
                <input type="password" name="password" <?= Helper::oldValue("password", "Choose a password") ?> required>
                <i class="fa fa-eye"></i>
                <?php Helper::showError("password") ?>
            </div>

            <div class="form-control">
                <input type="password" name="confirm_password" <?= Helper::oldValue("confirm_password", "Confirm your password") ?> required>
                <i class="fa fa-eye"></i>
                <?php Helper::showError("confirm_password") ?>
            </div>

            <button type="submit" class="btn-submit">Sign Up</button>
        </form>

        <div class="switch-page">
            Already have an account? <a href="sign-in">Log in</a>
        </div>
    </div>

    <script src="assets/javascript/main.js"></script>
</body>

</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
