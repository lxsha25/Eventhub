<?php
session_start();
include 'db_connect.php';

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_role"] = $user["role"];
            $loginSuccess = true;
        } else {
            $loginError = "Invalid password!";
        }
    } else {
        $loginError = "No user found with this email!";
    }
}
?>

<?php if (!empty($loginSuccess)): ?>
<!-- Success Animation + Redirect -->
<!DOCTYPE html>
<html>
<head>
    <title>Logging In - EventHub</title>
    <style>
        :root {
            --bg-dark: linear-gradient(to right, #232526, #414345);
            --bg-light: linear-gradient(to right, #f5f7fa, #c3cfe2);
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

        .login-box {
            text-align: center;
            animation: fadeOut 3s ease forwards;
        }

        .login-box h1 {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .login-box p {
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
            window.location.href = "dashboard.php";
        }, 3000);

        function toggleTheme() {
            const root = document.documentElement;
            const currentBg = document.body.style.backgroundImage;
            const darkBg = getComputedStyle(root).getPropertyValue('--bg-dark');
            const lightBg = getComputedStyle(root).getPropertyValue('--bg-light');

            if (currentBg === lightBg) {
                document.body.style.backgroundImage = darkBg;
                document.body.style.color = getComputedStyle(root).getPropertyValue('--text-dark');
            } else {
                document.body.style.backgroundImage = lightBg;
                document.body.style.color = getComputedStyle(root).getPropertyValue('--text-light');
            }
        }
    </script>
</head>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">🌓 Toggle Theme</button>

    <div class="login-box">
        <h1>🎉 Welcome back, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h1>
        <p>Login successful. Redirecting to your dashboard...</p>
        <div class="loader"></div>
        <a href="dashboard.php"><button class="button">🏠 Go to Dashboard</button></a>
    </div>
</body>
</html>

<?php else: ?>
<!-- Normal Login Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Login - EventHub</title>
</head>
<body style="font-family:sans-serif;background:#f3f4f6;margin:0;">

<header style="background:#1f2937;color:white;padding:20px;text-align:center;">
    <h1 style="margin:0;font-size:28px;">🔐 Login to <span style="color:#10b981;">EventHub</span></h1>
</header>

<nav style="background:#374151;display:flex;justify-content:center;gap:20px;padding:10px;">
    <a href="index.php" style="color:white;text-decoration:none;padding:8px 12px;">Home</a>
    <a href="browse_events.php" style="color:white;text-decoration:none;padding:8px 12px;">Browse Events</a>
    <a href="register.php" style="color:white;text-decoration:none;padding:8px 12px;">Register</a>
</nav>

<div style="max-width:400px;margin:40px auto;background:white;padding:30px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.05);">
    <h2 style="margin-top:0;text-align:center;color:#111827;">Welcome Back</h2>

    <?php if ($loginError): ?>
        <p style="color:red;text-align:center;"><?php echo htmlspecialchars($loginError); ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required 
               style="width:100%;padding:10px;margin:8px 0;border:1px solid #d1d5db;border-radius:5px;">
        <input type="password" name="password" placeholder="Password" required 
               style="width:100%;padding:10px;margin:8px 0;border:1px solid #d1d5db;border-radius:5px;">
        <button type="submit" 
                style="width:100%;padding:10px;background:#10b981;color:white;border:none;border-radius:5px;margin-top:10px;cursor:pointer;"
                onmouseover="this.style.background='#059669';" onmouseout="this.style.background='#10b981';">
            Login
        </button>
    </form>
</div>

<footer style="background:#1f2937;color:white;text-align:center;padding:15px;margin-top:40px;">
    <p id="footerText" style="margin:0;transition:color 0.3s;">&copy; 2025 EventHub. All rights reserved.</p>
</footer>

<script>
    const footer = document.getElementById("footerText");
    footer.addEventListener("mouseenter", () => footer.style.color = "#10b981");
    footer.addEventListener("mouseleave", () => footer.style.color = "white");
</script>

</body>
</html>
<?php endif; ?>
