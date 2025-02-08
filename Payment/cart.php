<?php
// Include the database connection
include '../Scripts/common.php';

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the form was submitted for adding/modifying items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for adding/updating an item
    if (isset($_POST['food_item_id'])) {
        $food_item_id = intval($_POST['food_item_id']);
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Add or modify the cart item
        if ($food_item_id && $quantity > 0) {
            // Check if the item exists in the database
            $stmt = $conn->prepare("SELECT * FROM food_items WHERE food_item_id = ?");
            $stmt->bind_param("i", $food_item_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($food_item = $result->fetch_assoc()) {
                // Add or update the cart item
                if (isset($_SESSION['cart'][$food_item_id])) {
                    // Update the quantity
                    $_SESSION['cart'][$food_item_id]['quantity'] = $quantity;
                } else {
                    // Add a new item to the cart
                    $_SESSION['cart'][$food_item_id] = [
                        'name' => $food_item['food_name'],
                        'price' => $food_item['price'],
                        'quantity' => $quantity,
                    ];
                }
            }
        }
    }

    // Handle the item deletion from the cart
    if (isset($_POST['delete_food_item_id'])) {
        $food_item_id = intval($_POST['delete_food_item_id']);
        if (isset($_SESSION['cart'][$food_item_id])) {
            unset($_SESSION['cart'][$food_item_id]); // Remove item from cart
        }
    }
}

// Calculate the total price
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
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
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .total-price {
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
        text-align: right;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #28a745;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 15px;
        cursor: pointer;
    }

    .checkout-btn:hover {
        background-color: #218838;
    }

    .empty-cart {
        text-align: center;
        margin-top: 20px;
        font-size: 18px;
    }

    .cart-item-form {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cart-item-form input[type="number"] {
        width: 60px;
        padding: 8px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .cart-item-form button[type="submit"] {
        padding: 8px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .cart-item-form button[type="submit"]:hover {
        background-color: #0056b3;
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .cart-item-form button[type="submit"]:active {
        background-color: #004085;
        transform: scale(1);
    }

    .remove-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 15px;
        cursor: pointer;
    }

    .remove-btn:hover {
        background-color: #c82333;
    }

    .back-to-menu-btn {
        display: inline-block;
        margin-bottom: 20px;
        padding: 12px 20px;
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .back-to-menu-btn:hover {
        background-color: #5a6268;
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .back-to-menu-btn:active {
        background-color: #4e555b;
        transform: scale(1);
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 768px) {
        .container {
            width: 95%;
            margin: 20px auto;
        }

        table, th, td {
            font-size: 14px;
        }

        .cart-item-form {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-item-form input[type="number"],
        .cart-item-form button[type="submit"] {
            margin-bottom: 10px;
            width: 100%;
        }

        .total-price {
            text-align: center;
        }

        .checkout-btn {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        th, td {
            font-size: 12px;
            padding: 8px;
        }

        .checkout-btn {
            padding: 10px;
            font-size: 12px;
        }

        .remove-btn, .cart-item-form button[type="submit"] {
            font-size: 12px;
            padding: 6px 10px;
        }

        .back-to-menu-btn {
            font-size: 12px;
            padding: 8px 10px;
        }
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Your Shopping Cart</h1>
        <a href="javascript:history.back()" class="back-to-menu-btn">Back to Menu</a>
        <div class="cart-items">
            <?php if (!empty($_SESSION['cart'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Food Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $food_item_id => $cart_item): ?>
                            <tr id="cart-item-<?= $food_item_id ?>">
                                <td><?= htmlspecialchars($cart_item['name']) ?></td>
                                <td>
                                <form method="POST" action="cart.php" class="cart-item-form">
                                    <input type="hidden" name="food_item_id" value="<?= $food_item_id ?>">
                                    <input type="number" name="quantity" value="<?= $cart_item['quantity'] ?>" min="1" class="cart-item-quantity">
                                    <button type="submit">Update</button>
                                </form>
                                </td>
                                <td>$<?= number_format($cart_item['price'], 2) ?></td>
                                <td>$<?= number_format($cart_item['price'] * $cart_item['quantity'], 2) ?></td>
                                <td>
                                    <form method="POST" action="cart.php">
                                        <input type="hidden" name="delete_food_item_id" value="<?= $food_item_id ?>">
                                        <button type="submit" class="remove-btn">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="total-price">
                    Total Price: $<?= number_format($total_price, 2) ?>
                </div>
                <form action="ProcessPayment.php" method="POST">
                    <button type="submit" class="checkout-btn" name="checkout">Proceed to Payment</button>
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