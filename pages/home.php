<?php 
$user = $_SESSION['user'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="navbar">
        <div class="brand">Php Project</div>
        <div class="profile" id="profileLink">
            <img src="https://picsum.photos/200/300" alt="Avatar">

            <span><?= $user['name']?></span>

            <div class="dropdown">
                <a href="profile">Profile</a>
                <a href="logout">Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>Welcome to PHP Project</h1>
        <p>Your application Homepage.</p>
    </div>
    <script src="assets/javascript/main.js"></script>
</body>

</html>