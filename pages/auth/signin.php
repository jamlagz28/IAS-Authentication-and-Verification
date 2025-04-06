<?php

use Utils\Helper;

$csrfToken = Helper::generateCsrfToken();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Account</title>
    <link rel="stylesheet" href="assets/css/auth_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url('https://img.freepik.com/premium-vector/padlock-with-keyhole-icon-personal-data-security-illustrates-cyber-data-information-privacy-idea-blue-color-abstract-hi-speed-internet-technology_542466-600.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .header {
            text-align: center;
            font-size: 36px;
            color: white;
            font-weight: 500;
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .right {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        .input-group input:focus {
            border-color: #007BFF;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .register {
            text-align: center;
            margin-top: 20px;
        }

        .register a {
            color: #007BFF;
            font-weight: 500;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .options label {
            font-size: 14px;
        }

        .error-messages {
            color: red;
            margin-bottom: 15px;
        }

        .fa-eye {
            position: absolute;
            right: 10px;
            top: 15px;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <div class="header">
         IAS - Authentication and Verification
    </div>

    <div class="right">
        <h2 style="text-align: center; font-size: 24px; font-weight: 500; margin-bottom: 30px;">Access Account</h2>
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error-messages">
                <?php Helper::showError("general") ?>
            </div>
        <?php endif; ?>

        <form action="sign-in" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <div class="input-group">
                <input type="text" name="email" <?= Helper::oldValue("email", "Please enter your email") ?> required>
                <?php Helper::showError("email") ?>
            </div>

            <div class="input-group">
                <input type="password" name="password" <?= Helper::oldValue('password', 'Please enter your password') ?> required>
                <?php Helper::showError("password") ?>

                <i class="fa fa-eye"></i>
            </div>

            <div class="options">
                <label>
                    <input name="remember_me" type="checkbox"> Remember my login
                </label>
                <a href="reset-password">Reset your password</a>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="register">
        Don't have an account? <a href="sign-up">Sign up</a>
        </div>
    </div>

    <script src="assets/javascript/main.js"></script>

</body>

</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
