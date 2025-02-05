<?php
include '../Scripts/common.php';

/**
 * Function to calculate the total price of the cart
 * @return float
 */
function calculateCartTotal() {
    return array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));
}

/**
 * Function to clear the cart
 */
function clearCart() {
    unset($_SESSION['cart']);
}

/**
 * Generate a unique tracking ID
 * @return string
 */
function generateTrackingID() {
    return strtoupper(uniqid('ORDER_'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $error_message = "Your cart is empty. Please add items to your cart before proceeding.";
    } else {
        $total_price = calculateCartTotal();

        // Fetch user account balance
        $stmt = $pdo->prepare("SELECT account_balance FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['account_balance'] < $total_price) {
            $error_message = "Insufficient balance. Please top up your account.";
        } else {
            try {
                $pdo->beginTransaction();

                // Deduct the amount from the user's balance
                $new_balance = $user['account_balance'] - $total_price;
                $stmt = $pdo->prepare("UPDATE users SET account_balance = :new_balance WHERE user_id = :user_id");
                $stmt->execute(['new_balance' => $new_balance, 'user_id' => $_SESSION['user_id']]);

                // Generate tracking ID and save the order
                $tracking_id = generateTrackingID();
                $stmt = $pdo->prepare("INSERT INTO orders (tracking_id, user_id, total_amount, status, payment_method, order_date) VALUES (:tracking_id, :user_id, :total_amount, 'Pending', 'Credit Card', NOW())");
                $stmt->execute([
                    'tracking_id' => $tracking_id,
                    'user_id' => $_SESSION['user_id'],
                    'total_amount' => $total_price
                ]);
                $order_id = $pdo->lastInsertId();

                // Insert items into order_items table
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, food_item_id, quantity, price) VALUES (:order_id, :food_item_id, :quantity, :price)");
                foreach ($_SESSION['cart'] as $food_id => $cart_data) {
                    $stmt->execute([
                        'order_id' => $order_id,
                        'food_item_id' => $food_id,
                        'quantity' => $cart_data['quantity'],
                        'price' => $cart_data['price']
                    ]);
                }

                clearCart();
                $_SESSION['tracking_id'] = $tracking_id;

                $pdo->commit();
                header("Location: track_order.php");
                exit();
            } catch (Exception $e) {
                $pdo->rollBack();
                $error_message = "An error occurred during payment processing: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
        <h1>Checkout</h1>

        <?php if (isset($error_message)): ?>
            <div class="message error">
                <?php echo htmlspecialchars($error_message); ?>
                <form action="/ProjectCSAD/Payment/Topup.php" method="POST">
                    <button type="submit" class="checkout-btn" name="checkout">Top up</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['cart'])): ?>
            <form method="POST" action="">
                <button type="submit" name="checkout">Proceed to Checkout</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty. Please add items before checking out.</p>
        <?php endif; ?>
    </div>
</body>
</html>
