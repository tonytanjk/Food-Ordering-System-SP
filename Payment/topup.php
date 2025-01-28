<?php
session_start();

// Database connection
$host = 'localhost';
$db = 'projectcsad';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error and success messages
$error_message = '';
$success_message = '';

// Fetch form data if the user submitted the top-up request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch user ID and top-up amount
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    $top_up_amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;

    // Validate inputs
    if ($user_id <= 0 || $top_up_amount <= 0) {
        $error_message = "Invalid user or amount.";
    } else {
        // Fetch the user's current balance
        $sql = "SELECT account_balance FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $error_message = "User not found.";
            } else {
                $row = $result->fetch_assoc();
                $current_balance = (float)$row['account_balance'];

                // Add the top-up amount to the user's current balance
                $new_balance = $current_balance + $top_up_amount;

                // Update the user's balance in the database
                $sql = "UPDATE users SET account_balance = ? WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("di", $new_balance, $user_id);

                    if ($stmt->execute()) {
                        // Success message
                        $success_message = "Top-up successful! Your new balance is $" . number_format($new_balance, 2);

                        // Redirect back to the checkout page
                        header("Location: checkout.php");
                        exit(); // Ensure that the script stops execution after the redirect
                    } else {
                        $error_message = "Error processing top-up.";
                    }
                } else {
                    $error_message = "Error preparing the update query.";
                }
            }

            // Close the statement
            $stmt->close();
        } else {
            $error_message = "Error preparing the balance query.";
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #444;
        }

        .message {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        label {
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            display: block;
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Top Up Your Account</h1>

        <!-- Success or Error Message Display -->
        <?php if (!empty($success_message)): ?>
            <div class="message success">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <div class="message error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Top Up Form -->
        <form action="topup.php" method="post">
            <label for="amount">Top Up Amount ($)</label>
            <input type="number" name="amount" id="amount" step="0.01" min="1" required>
            <button type="submit">Top Up</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Food Courts</p>
    </footer>
</body>
</html>
