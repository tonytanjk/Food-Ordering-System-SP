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

// Initialize the cart total amount
$total_amount = 0;

// Calculate total price from the cart
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $food_item) {
        $total_amount += $food_item['price'] * $food_item['quantity'];
    }
} else {
    $error_message = "Your cart is empty. Please add items to your cart before proceeding with payment.";
}

// Fetch form data
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Validate user session and cart total
if ($user_id <= 0 || $total_amount <= 0) {
    die("Invalid session or empty cart. Please ensure you're logged in and your cart is not empty.");
}

// Fetch user balance
$sql = "SELECT account_balance FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$row = $result->fetch_assoc();
$current_balance = (float)$row['account_balance'];

// Check if balance is sufficient
if ($current_balance < $total_amount) {
    $error_message = "Insufficient balance.";
    $is_balance_sufficient = false;
} else {
    // Deduct amount from balance
    $new_balance = $current_balance - $total_amount;
    $sql = "UPDATE users SET account_balance = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $new_balance, $user_id);

    if ($stmt->execute()) {
        // Clear the cart after successful payment
        unset($_SESSION['cart']);
        $success_message = "Payment successful! New balance: $" . number_format($new_balance, 2);
        $is_balance_sufficient = true;
    } else {
        $error_message = "Error processing payment.";
    }
}

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
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

        .cart-items {
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-item span {
            font-size: 16px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment</h1>

        <!-- Success or Error Message Display -->
        <?php if (isset($success_message)): ?>
            <div class="message success">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="message error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Cart Display -->
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-items">
                <?php foreach ($_SESSION['cart'] as $food_item): ?>
                    <div class="cart-item">
                        <span><?php echo htmlspecialchars($food_item['name']); ?> (x<?php echo $food_item['quantity']; ?>)</span>
                        <span>$<?php echo number_format($food_item['price'] * $food_item['quantity'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="total-price">
                <strong>Total: $<?php echo number_format($total_amount, 2); ?></strong>
            </div>
            <!-- Checkout Form -->
            <?php if ($is_balance_sufficient): ?>
                <form method="POST" action="">
                    <button type="submit" name="checkout">Pay</button>
                </form>
            <?php else: ?>
                <form action="topup.php" method="get">
                    <button type="submit">Top Up</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <p>Your cart is empty. Proceed back to home page.</p>
            <form action="/projectCSAD/home.php" method="get">
                <button type="submit">Back to Home Page</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
