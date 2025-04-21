<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logging Out - EventHub</title>
    <style>
        :root {
            --bg-dark: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            --bg-light: linear-gradient(to right, #c9d6ff, #e2e2e2);
            --text-dark: white;
            --text-light: #222;
        }

        body {
            background: var(--bg-dark);
            color: var(--text-dark);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            transition: all 0.5s ease;
        }

        .logout-box {
            text-align: center;
            animation: fadeOut 3s ease forwards;
        }

        .logout-box h1 {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .logout-box p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #00c6ff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        .button {
            margin-top: 20px;
            background-color: #00c6ff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .button:hover {
            background-color: #008acb;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #fff;
            color: #333;
            padding: 8px 12px;
            border-radius: 20px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0.3; }
        }
    </style>

    <script>
        setTimeout(() => {
            window.location.href = "login.php"; // Redirect after 3 seconds
        }, 3000);

        function toggleTheme() {
            const root = document.documentElement;
            const isDark = root.style.getPropertyValue('--bg-dark') === getComputedStyle(document.body).backgroundImage;

            if (document.body.style.backgroundImage === getComputedStyle(document.documentElement).getPropertyValue('--bg-dark')) {
                // Switch to light
                document.body.style.backgroundImage = getComputedStyle(document.documentElement).getPropertyValue('--bg-light');
                document.body.style.color = getComputedStyle(document.documentElement).getPropertyValue('--text-light');
            } else {
                // Switch to dark
                document.body.style.backgroundImage = getComputedStyle(document.documentElement).getPropertyValue('--bg-dark');
                document.body.style.color = getComputedStyle(document.documentElement).getPropertyValue('--text-dark');
            }
        }
    </script>
</head>
<body>

    <button class="theme-toggle" onclick="toggleTheme()">🌓 Toggle Theme</button>

    <div class="logout-box">
        <h1>👋 Goodbye!</h1>
        <p>You have been successfully logged out.</p>
        <div class="loader"></div>
        <p>Redirecting to login page...</p>

        <a href="login.php"><button class="button">🔐 Log In Again</button></a>
    </div>

</body>
</html>
