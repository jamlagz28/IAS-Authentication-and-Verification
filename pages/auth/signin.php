<?php

use Utils\Helper;

$csrfToken = Helper::generateCsrfToken();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAqhQlE0g-OBH8MfQXCEHUjnjTn6e52DpySw&s') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .site-title {
            color: #fff;
            font-size: 34px;
            font-weight: 600;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            margin-bottom: 25px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.96);
            padding: 35px 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .auth-card h2 {
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .form-row {
            margin-bottom: 18px;
            position: relative;
        }

        .form-row input {
            width: 100%;
            padding: 14px;
            padding-right: 40px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .form-row input:focus {
            border-color: #3498db;
            outline: none;
        }

        .fa-eye {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-options a {
            color: #3498db;
            text-decoration: none;
        }

        .form-options a:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            background: #3498db;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-button:hover {
            background: #2980b9;
        }

        .signup-link {
            margin-top: 16px;
            text-align: center;
            font-size: 14px;
        }

        .signup-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="site-title">Secure Login Panel</div>

    <div class="auth-card">
        <h2>Sign in to your account</h2>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error-message">
                <?php Helper::showError("general") ?>
            </div>
        <?php endif; ?>

        <form id="login-form" action="sign-in" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <div class="form-row">
                <input type="text" name="email" <?= Helper::oldValue("email", "Please enter your email") ?> required>
                <?php Helper::showError("email") ?>
            </div>

            <div class="form-row">
                <input type="password" name="password" <?= Helper::oldValue("password", "Please enter your password") ?> required>
                <i class="fa fa-eye"></i>
                <?php Helper::showError("password") ?>
            </div>

            <div class="form-options">
                <label><input type="checkbox" name="remember_me"> Stay signed in</label>
                <a href="reset-password">Forgot Password?</a>
            </div>

            <div class="g-recaptcha" data-sitekey="6Ld3HCArAAAAAFy_oFIR3nhvGLOkJzwf0zcd0Vk1"></div>

            <button type="submit" class="login-button">Sign In</button>
        </form>

        <div class="signup-link">
            New user? <a href="sign-up">Create an account</a>
        </div>
    </div>

    <script src="assets/javascript/main.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>

</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
