<?php
session_start();
include 'db_connect.php';

$token = $_GET["token"] ?? "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["token"];
    $new_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token=? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $stmt = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, reset_expires=NULL WHERE reset_token=?");
        $stmt->bind_param("ss", $new_password, $token);
        $stmt->execute();
        $message = "Password has been reset successfully.";
    } else {
        $message = "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Reset Password</title></head>
<body style="font-family:sans-serif;background:#f3f4f6;padding:40px;">
    <div style="max-width:400px;margin:auto;background:white;padding:20px;border-radius:10px;">
        <h2 style="text-align:center;">🔒 Reset Password</h2>
        <?php if ($message): ?>
            <p style="color:green;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="password" placeholder="New Password" required style="width:100%;padding:10px;margin:10px 0;">
            <button type="submit" style="width:100%;padding:10px;background:#10b981;color:white;border:none;border-radius:5px;">Reset Password</button>
        </form>
    </div>
</body>
</html>