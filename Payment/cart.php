<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=food_court", 'root', '');

// Initialize total price
$total_price = 0;

if (isset($_SESSION['cart'])) {
    // Fetch food details for items in the cart
    $cart_items = [];
    foreach ($_SESSION['cart'] as $food_id => $cart_data) {
        $stmt = $pdo->prepare("SELECT * FROM food_items WHERE id = :food_id");
        $stmt->execute(['food_id' => $food_id]);
        $food = $stmt->fetch(PDO::FETCH_ASSOC);
        $cart_items[] = [
            'food' => $food,
            'quantity' => $cart_data['quantity'],
            'total_price' => $food['price'] * $cart_data['quantity']
        ];
        $total_price += $food['price'] * $cart_data['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-top: 20px;
        }

        .cart-items {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 8px;
        }

        .cart-item .details {
            flex: 1;
        }

        .cart-item .details h3 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }

        .cart-item .details p {
            color: #555;
        }

        .cart-item .price {
            font-size: 18px;
            color: #28a745;
            font-weight: bold;
        }

        .total-price {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .checkout-btn {
            display: block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }

        .checkout-btn:hover {
            background-color: #45a049;
        }

        .empty-cart {
            text-align: center;
            color: #888;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Shopping Cart</h1>
        
        <div class="cart-items">
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $cart_item): ?>
                    <div class="cart-item">
                        <img src="images/<?= $cart_item['food']['image_url'] ?>" alt="<?= $cart_item['food']['name'] ?>">
                        <div class="details">
                            <h3><?= htmlspecialchars($cart_item['food']['name']) ?></h3>
                            <p>Quantity: <?= $cart_item['quantity'] ?></p>
                        </div>
                        <div class="price">
                            $<?= number_format($cart_item['total_price'], 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="total-price">
                    Total Price: $<?= number_format($total_price, 2) ?>
                </div>
                <form action="checkout.php" method="POST">
                    <button type="submit" class="checkout-btn" name="checkout">Proceed to Checkout</button>
                </form>
            <?php else: ?>
                <div class="empty-cart">
                    <p>Your cart is empty.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
