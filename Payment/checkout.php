<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=projectcsad", 'root', '');

// Generate a tracking ID
function generateTrackingID() {
    return strtoupper(uniqid('ORDER_'));
}

// Checkout logic
if (isset($_POST['checkout'])) {
    if (!empty($_SESSION['cart'])) {
        // Generate a unique tracking ID
        $tracking_id = generateTrackingID();

        // Save the order to the database (example schema assumed)
        foreach ($_SESSION['cart'] as $food_id => $cart_data) {
            $stmt = $pdo->prepare("INSERT INTO orders (tracking_id, food_id, quantity) VALUES (:tracking_id, :food_id, :quantity)");
            $stmt->execute([
                'tracking_id' => $tracking_id,
                'food_id' => $food_id,
                'quantity' => $cart_data['quantity']
            ]);
        }

        // Clear the cart after checkout
        $_SESSION['cart'] = [];
        $_SESSION['tracking_id'] = $tracking_id;  // Save the tracking ID in session for easy reference

        // Redirect to the order placed page
        header("Location: order_placed.php");
        exit();
    } else {
        $error_message = "Your cart is empty. Please add items before checking out.";
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
        <h1>Checkout</h1>

        <!-- Error Message Display -->
        <?php if (isset($error_message)): ?>
            <div class="message error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Cart Display -->
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-items">
                <?php foreach ($_SESSION['cart'] as $food_id => $cart_data): ?>
                    <div class="cart-item">
                        <span><?php echo $cart_data['name']; ?> (x<?php echo $cart_data['quantity']; ?>)</span>
                        <span>$<?php echo $cart_data['price'] * $cart_data['quantity']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Checkout Form -->
            <form method="POST" action="">
                <button type="submit" name="checkout">Proceed to Checkout</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty. Please add items before checking out.</p>
        <?php endif; ?>
    </div>
</body>
</html>
