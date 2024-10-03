<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role =  'admin';

// Fetch users or admins for the receiver list (Admins can select users and vice versa)
$receiver_query = $is_admin ? "SELECT user_id, name FROM user WHERE role = 'user'" : "SELECT user_id, name FROM user WHERE role = 'admin'";
$receiver_result = $conn->query($receiver_query);

// Handle sending messages
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Insert the message into the database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, sender_role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $receiver_id, $message, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Failed to send the message. Please try again.');</script>";
    }
}

// Fetch all messages for the user or admin
$query = "SELECT * FROM messages WHERE sender_id = ? OR receiver_id = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #356698;
        }

        .message-form {
            margin: 20px 0;
        }

        .message-form select, .message-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .message-form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message-form button:hover {
            background-color: #218838;
        }

        .message-container {
            margin: 10px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message-header {
            font-weight: bold;
            color: #444;
        }

        .message-content {
            margin: 10px 0;
        }

        .message-timestamp {
            font-size: 0.8em;
            color: #777;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #356698;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Message System</h1>

    <!-- Message Form (for sending messages) -->
    <div class="message-form">
        <form action="" method="POST">
            <label for="receiver_id">Send to:</label>
            <select name="receiver_id" required>
                <?php while ($row = $receiver_result->fetch_assoc()) : ?>
                    <option value="<?php echo $row['user_id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="message">Message:</label>
            <textarea name="message" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <!-- View Messages -->
    <h2>Your Messages</h2>
    <?php while ($row = $result->fetch_assoc()) :
        $is_sender = $row['sender_id'] == $user_id;
        $sender = $is_sender ? "You" : ($row['sender_role'] == 'admin' ? 'Admin' : 'User');
    ?>
        <div class="message-container">
            <div class="message-header"><?php echo $sender; ?>:</div>
            <div class="message-content"><?php echo htmlspecialchars($row['message']); ?></div>
            <div class="message-timestamp"><?php echo $row['timestamp']; ?></div>
        </div>
    <?php endwhile; ?>
</div>

<footer>
    <p>&copy; 2024 TravelQuest</p>
</footer>

</body>
</html>
