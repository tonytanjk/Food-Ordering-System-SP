<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/common.php';
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/Account.php';
include $_SERVER['DOCUMENT_ROOT'] .  '/projectCSAD/Vendor/VendorCommon.php';
echo $account,$main_head;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Court Vendors</title>
    <link rel="stylesheet" href="../Scripts/FC1_6_CSS.css">
    <script src="../Scripts/FC1_6_JS.js"></script>
    <style>
        .back-to-menu-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 12px 20px;
            background-color: #6c757d; /* Gray background */
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
            background-color: #5a6268; /* Darker gray when hovered */
            transform: scale(1.05); /* Slightly enlarge the button on hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .back-to-menu-btn:active {
            background-color: #4e555b; /* Darkest gray when clicked */
            transform: scale(1); /* Reset size on click */
        }

        .cart-summary:hover {
            left: 20px;
        }
    </style>
</head>
<body>
    <header>      
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-summary">
                <h2>Your Cart</h2>
                <div class="cart-items">
                    <?php foreach ($_SESSION['cart'] as $item_id => $item): ?>
                        <div class="cart-item">
                            <div class="item-details">
                                <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                                <span class="item-price">$<?= number_format($item['price'], 2) ?></span>
                            </div>
                            <div class="item-quantity">
                                <span class="quantity-label">Quantity:</span> <?= $item['quantity'] ?>
                            </div>
                            <div class="item-total">
                                <strong>Total: $<?= number_format($item['price'] * $item['quantity'], 2) ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cart-total">
                    <p><strong>Total Price:</strong> $<?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $_SESSION['cart'])), 2) ?></p>
                </div>
                <a href="../Payment/cart.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </header>
    <div class="container">
        <h1>Food Court Vendors</h1>
      <a href="javascript:history.back()" class="back-to-menu-btn">Back</a>
        <?php if (!$stall_id && $food_court_id): ?>
            <!-- Display food stalls for the selected food court -->
            <h2>Food Stalls in Food Court #<?= htmlspecialchars($food_court_id) ?></h2>
            <div class="vendor-grid">
                <?php while ($stall = $stall_result->fetch_assoc()):                 ?>
                    <a href="FC.php?vendor_id=<?= $food_court_id ?>&stall_id=<?= $stall['stall_id'] ?>" class="vendor-card">
                    <img src="<?= !empty($stall['stall_picture']) ? '/ProjectCSAD' . htmlspecialchars($stall['stall_picture']) : '/ProjectCSAD/uploads/unknown_food.jpg' ?>" alt="<?= htmlspecialchars($stall['stall_picture']) ?>" onerror="this.onerror=null;this.src='/ProjectCSAD/uploads/unknown_food.jpg';" style="width: auto; height: 150px; object-fit: cover; border-radius: 8px;">
                        <div class="vendor-details">
                            <h2><?= htmlspecialchars($stall['stall_name']) ?></h2>
                            <p>Click to view food selection.</p>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php elseif ($stall_id): ?>
            <!-- Display food items for the selected food stall -->
            <h2>Food Menu</h2>
    <div class="food-items-grid">
        <?php 
        // Loop through food items for the selected food stall
        while ($food_item = $food_result->fetch_assoc()): ?>
            <div class="food-item-card">
                <div class="food-item-image">
                <?php
                $imagePath = !empty($food_item['image_path']) ? htmlspecialchars($food_item['image_path']) : '../uploads/unknown_food.jpg';
                ?>
                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($food_item['food_name']) ?>" onerror="this.onerror=null;this.src='../uploads/unknown_food.jpg';" style="width: auto; height: 150px; object-fit: cover; border-radius: 8px;">
                </div>
                <div class="food-item-details">
                    <h2><?= htmlspecialchars($food_item['food_name']) ?></h2>
                    <p><?= htmlspecialchars($food_item['description']) ?></p>
                    <p class="price">Price: $<?= number_format($food_item['price'], 2) ?></p>                    
                    <!-- Add to Cart Form -->
                    <form action="../Payment/addcart.php" method="POST">
                        <input type="hidden" name="food_item_id" value="<?= $food_item['food_item_id'] ?>">
                        <input type="hidden" name="stall_id" value="<?= $stall_id ?>">
                        <label for="quantity-<?= $food_item['food_item_id'] ?>">Quantity:</label>
                        <input type="number" id="quantity-<?= $food_item['food_item_id'] ?>" name="quantity" value="1" min="1" max="100" required>
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
    </div>
    <?php echo $foot; // Display the footer  ?>
</body>
</html>
