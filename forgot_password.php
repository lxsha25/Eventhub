<?php
include 'db_connect.php';

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        // Simulate sending reset link (you can replace this with actual mail logic)
        $successMessage = "A password reset link has been sent to your email.";
    } else {
        $errorMessage = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password - EventHub</title>
</head>
<body style="font-family:sans-serif;background:#f3f4f6;margin:0;">

    <header style="background:#1f2937;color:white;padding:20px;text-align:center;">
        <h1 style="margin:0;font-size:28px;">🔑 Forgot Password</h1>
    </header>

    <div style="max-width:400px;margin:40px auto;background:white;padding:30px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        <h3 style="text-align:center;color:#111827;">Reset Your Password</h3>
        <p style="font-size:14px;text-align:center;color:#4b5563;">Enter your email and we’ll send you a reset link.</p>

        <?php if ($successMessage): ?>
            <p style="color:green;text-align:center;"><?php echo $successMessage; ?></p>
        <?php elseif ($errorMessage): ?>
            <p style="color:red;text-align:center;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required
                style="width:100%;padding:10px;margin:10px 0;border:1px solid #d1d5db;border-radius:5px;">
            <button type="submit" 
                style="width:100%;padding:10px;background:#3b82f6;color:white;border:none;border-radius:5px;cursor:pointer;"
                onmouseover="this.style.background='#2563eb';" onmouseout="this.style.background='#3b82f6';">
                Send Reset Link
            </button>
        </form>

        <div style="text-align:center;margin-top:15px;">
            <a href="login.php" style="color:#3b82f6;text-decoration:none;font-size:14px;">Back to Login</a>
        </div>
    </div>

    <footer style="background:#1f2937;color:white;text-align:center;padding:15px;">
        <p style="margin:0;">&copy; 2025 EventHub. All rights reserved.</p>
    </footer>

</body>
</html>
