<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["role"] = $user["role"];
            header("Location: dashboard_admin.php");
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Admin user not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - EventHub</title>
</head>
<body style="font-family:sans-serif;background:#f3f4f6;padding:50px;">
    <div style="max-width:400px;margin:auto;background:white;padding:30px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align:center;color:#1f2937;">🔐 Admin Login</h2>
        <?php if ($error): ?>
            <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" style="display:flex;flex-direction:column;gap:12px;">
            <input type="email" name="email" placeholder="Email" required style="padding:10px;border:1px solid #ccc;border-radius:6px;">
            <input type="password" name="password" placeholder="Password" required style="padding:10px;border:1px solid #ccc;border-radius:6px;">
            <button type="submit" style="padding:10px;background:#3b82f6;color:white;border:none;border-radius:6px;cursor:pointer;">Login</button>
        </form>
        <p style="text-align:center;margin-top:15px;"><a href="index.php" style="color:#3b82f6;text-decoration:none;">← Back to Home</a></p>
    </div>
</body>
</html>
