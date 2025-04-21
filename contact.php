<?php
// DB connection
$host = 'localhost';
$db = 'eventhub_database';
$user = 'root';
$pass = '';
$successMessage = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    if ($name && $email && $message) {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);

        // Email notification
        $to = "mohantalaxman473@gmail.com";
        $subject = "New Contact Message from EventHub";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: no-reply@eventhub.com";

        mail($to, $subject, $body, $headers);

        $successMessage = "✅ Thank you, $name! Your message has been sent.";
    } else {
        $successMessage = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - EventHub</title>
</head>
<body style="margin:0; font-family:'Segoe UI', sans-serif; background: linear-gradient(135deg, #d0f0e0, #d0f4f8); padding-top:80px;">

    <!-- Navbar -->
    <div style="position:fixed; top:0; left:0; right:0; background:#0a1f44; box-shadow:0 4px 8px rgba(0,0,0,0.4); padding:15px 30px; display:flex; justify-content:space-between; align-items:center; z-index:1000;">
        <div style="font-size:22px; font-weight:bold; color:#ffffff;">🎫 EventHub</div>
        <div>
            <a href="dashboard.php" style="margin-right:20px; text-decoration:none; color:#f0f0f0; font-weight:500;">Dashboard</a>
            <a href="contact.php" style="text-decoration:none; color:#ffffff; font-weight:500;">Contact</a>
        </div>
    </div>

    <!-- Main Container -->
    <div style="max-width:700px; margin:40px auto; background: linear-gradient(135deg, #ff6b6b, #6bff95, #6bcaff); padding:30px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
        <h2 style="color:#ffffff; margin-top:0;">📩 Contact Us</h2>

        <p style="color:#f4f4f4; font-size:16px;">
            For any queries or support, feel free to reach out to us:
        </p>
        <ul style="list-style:none; padding:0; margin-bottom:30px; color:#fff;">
            <li><strong>📞 Phone:</strong> <a href="tel:6372026603" style="color:#ffffff; text-decoration:underline;">6372026603</a></li>
            <li><strong>✉️ Email:</strong> <a href="mailto:mohantalaxman473@gmail.com" style="color:#ffffff; text-decoration:underline;">mohantalaxman473@gmail.com</a></li>
        </ul>

        <?php if ($successMessage): ?>
            <div style="background:#fff; color:#0d47a1; border-left:5px solid #0d47a1; padding:10px 15px; margin-bottom:20px; border-radius:6px;">
                <?= $successMessage ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="display:flex; flex-direction:column; gap:15px;">
            <input type="text" name="name" placeholder="Your Name" required
                style="padding:12px; border:1px solid #ccc; border-radius:8px;">
            <input type="email" name="email" placeholder="Your Email" required
                style="padding:12px; border:1px solid #ccc; border-radius:8px;">
            <textarea name="message" rows="5" placeholder="Your Message" required
                style="padding:12px; border:1px solid #ccc; border-radius:8px;"></textarea>

            <button type="submit" 
                style="padding:12px; background:#0a1f44; color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">
                Send Message
            </button>
        </form>
    </div>

</body>
</html>
