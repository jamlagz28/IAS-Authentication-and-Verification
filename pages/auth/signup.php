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

    <style>
        body {
            background-image: url('https://t4.ftcdn.net/jpg/04/60/71/01/360_F_460710131_YkD6NsivdyYsHupNvO3Y8MPEwxTAhORh.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .left {
            width: 40%;
            padding: 20px;
            color: white;
        }

        .right {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        }

        .error-messages {
            color: red;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>
   
        <div class="right">
            <center><h2>Create an Account</h2> </center>
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="error-messages">
                    <?php Helper::showError("general") ?>
                </div>
            <?php endif; ?>
            <form action="sign-up" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="input-group">
                    <input type="text" name="full_name" <?= Helper::oldValue("full_name", "Your Name") ?> required>
                    <?php Helper::showError("full_name") ?>
                </div>
                <div class="input-group">
                    <input type="email" name="email" <?= Helper::oldValue("email", "Enter Your Email") ?> required>
                    <?php Helper::showError("email") ?>
                </div>
                <div class="input-group">
                    <input type="password" name="password" <?= Helper::oldValue("password", "Set a Password") ?> required>
                    <i class="fa fa-eye"></i>
                    <?php Helper::showError("password") ?>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" <?= Helper::oldValue("confirm_password", "Re-enter Password") ?> required>
                    <i class="fa fa-eye"></i>
                    <?php Helper::showError("confirm_password") ?>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
            <div class="register">
            Have an account already? <a href="sign-in">Login</a>
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
