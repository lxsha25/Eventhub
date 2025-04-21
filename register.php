<?php
session_start();
include 'db_connect.php';

$registerError = "";
$registerSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = "user";

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $registerError = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if ($stmt->execute()) {
            $registerSuccess = true;
        } else {
            $registerError = "Registration failed. Please try again.";
        }
    }
}

$isLoggedIn = isset($_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - EventHub</title>
    <style>
        :root {
            --bg-dark: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            --bg-light: linear-gradient(to right, #c9d6ff, #e2e2e2);
            --text-dark: white;
            --text-light: #1f2937;
        }

        body {
            background: var(--bg-dark);
            color: var(--text-dark);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            transition: all 0.5s ease;
        }

        header {
            background: #1f2937;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            color: white;
        }

        nav {
            background: #374151;
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
        }

        .form-container {
            max-width: 400px;
            margin: 40px auto;
            background: white;
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .form-container input, .form-container button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #d1d5db;
            border-radius: 5px;
        }

        .form-container button {
            background: #10b981;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background: #059669;
        }

        .success-box {
            text-align: center;
            margin: 40px auto;
            color: white;
            animation: fadeIn 1s ease-in-out;
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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
    </style>
</head>
<body>

<?php if ($registerSuccess): ?>
    <div class="success-box">
        <h1>✅ Registration Successful!</h1>
        <p>You’ll be redirected to the login page shortly...</p>
        <div class="loader"></div>
        <a href="login.php" style="color: #10b981; font-weight: bold;">Click here if not redirected</a>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = "login.php";
        }, 3000);
    </script>
<?php else: ?>
    <!-- Header -->
    <header>
        <h1>📝 Register at <span style="color:#10b981;">EventHub</span></h1>
    </header>

    <!-- Navbar -->
    <nav>
        <a href="index.php">Home</a>
        <a href="browse_events.php">Browse Events</a>
        <?php if ($isLoggedIn): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>

    <!-- Register Form -->
    <div class="form-container">
        <h2 style="text-align:center;">Create Your Account</h2>
        <?php if ($registerError): ?>
            <p style="color:red;text-align:center;"><?php echo htmlspecialchars($registerError); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
<?php endif; ?>

<!-- Theme Toggle Button -->
<button class="theme-toggle" onclick="toggleTheme()">🌓 Toggle Theme</button>

<script>
    let isDarkMode = true;

    function toggleTheme() {
        const root = document.documentElement;
        const body = document.body;

        if (isDarkMode) {
            body.style.background = getComputedStyle(root).getPropertyValue('--bg-light');
            body.style.color = getComputedStyle(root).getPropertyValue('--text-light');
        } else {
            body.style.background = getComputedStyle(root).getPropertyValue('--bg-dark');
            body.style.color = getComputedStyle(root).getPropertyValue('--text-dark');
        }

        isDarkMode = !isDarkMode;
    }
</script>

</body>
</html>
