<?php 
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | MyApp</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        .topbar {
            background-color: #2a3f54;
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 20px;
            font-weight: 600;
        }

        .user-box {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-box img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-box span {
            font-weight: 500;
        }

        .dropdown-menu {
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 6px;
            overflow: hidden;
            display: none;
            flex-direction: column;
        }

        .dropdown-menu a {
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            transition: background 0.2s;
        }

        .dropdown-menu a:hover {
            background-color: #f0f0f0;
        }

        .main-content {
            padding: 40px 20px;
            text-align: center;
        }

        .main-content h1 {
            font-size: 32px;
            color: #2a3f54;
        }

        .main-content p {
            font-size: 16px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="topbar">
        <div class="logo">MyApp Dashboard</div>
        <div class="user-box" id="profileLink">
            <img src="https://i.pinimg.com/280x280_RS/07/ae/d2/07aed2d135b60a098fc33925015f8e8e.jpg" alt="User Avatar">
            <span><?= htmlspecialchars($user['name']) ?></span>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="profile">My Profile</a>
                <a href="logout">Sign Out</a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <h1>Welcome, <?= htmlspecialchars($user['name']) ?>!</h1>
        <p>This is your personalized dashboard. Feel free to explore the features.</p>
    </div>

    <script>
        const profileLink = document.getElementById('profileLink');
        const dropdown = document.getElementById('dropdownMenu');

        profileLink.addEventListener('click', () => {
            dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
        });

        document.addEventListener('click', (e) => {
            if (!profileLink.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>

</html>
