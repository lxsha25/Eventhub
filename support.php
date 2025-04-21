<!DOCTYPE html>
<html>
<head>
    <title>Support | EventHub</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, rgb(142, 68, 173), rgb(93, 64, 55)); /* Violet-Brown mix */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .support-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
            max-width: 500px;
            width: 100%;
        }
        .support-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .support-container form {
            display: flex;
            flex-direction: column;
        }
        .support-container input,
        .support-container textarea {
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }
        .support-container textarea {
            resize: vertical;
            min-height: 120px;
        }
        .support-container button {
            background-color: #00ffcc;
            color: #002244;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .support-container button:hover {
            background-color: #00e6b8;
        }
    </style>
</head>
<body>

<div class="support-container">
    <h2>🛠️ Contact EventHub Support</h2>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <input type="text" name="subject" placeholder="Subject" required />
        <textarea name="message" placeholder="Type your message..." required></textarea>
        <button type="submit">Send Message</button>
    </form>
</div>

</body>
</html>
