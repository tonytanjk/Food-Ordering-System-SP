<?php
// Include database connection
include '../db_connection.php';
// Get the food court ID from the URL
$food_court_id = 5; // Replace with dynamic value if needed

// Check if a specific food stall is selected
$stall_id = isset($_GET['stall_id']) ? $_GET['stall_id'] : null;

// Fetch food stalls if food court is selected
if ($food_court_id) {
    $query = "SELECT * FROM food_stalls WHERE food_court_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $food_court_id);
    $stmt->execute();
    $stall_result = $stmt->get_result();
}

// Fetch food items if a food stall is selected
if ($stall_id) {
    $query = "SELECT * FROM food_items WHERE stall_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $stall_id);
    $stmt->execute();
    $food_result = $stmt->get_result();
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Query to fetch account balance
    $query = "SELECT account_balance FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $accountBalance = $row['account_balance'];
    } else {
        $accountBalance = 0.00; // Default balance if user is not found
    }
} else {
    // Redirect to login page if not logged in
    header("Location: ./UserProcess/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Court Vendors</title>
    <link rel="stylesheet" href="../Scripts/FC1_6_CSS.css">
    <script src="../Scripts/FC1_6_JS.js"></script>
</head>
<body>
    <header>
        <h1>Food Ordering System @ SP</h1>
        <nav>
            <a href="./Home.php">Home</a>
            <a href="../FoodCourts/FC.php">Food Courts</a>
            <a href="#">Most Ordered</a>
            <a href="#">About Us</a>
            <a href="#">Contact</a>
            <a href="../UserProcess/login.php">Logout</a>
        </nav>        
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

        <?php if (!$stall_id && $food_court_id): ?>
            <!-- Display food stalls for the selected food court -->
            <h2>Food Stalls in Food Court #<?= htmlspecialchars($food_court_id) ?></h2>
            <div class="vendor-grid">
                <?php while ($stall = $stall_result->fetch_assoc()): 
                    $stall_picture = !empty($stall['stall_picture']) ? $stall['stall_picture'] : 'images/placeholder.jpg'; // Fallback to placeholder
                ?>
                    <a href="FC1.php?vendor_id=<?= $food_court_id ?>&stall_id=<?= $stall['stall_id'] ?>" class="vendor-card">
                        <img src="<?= htmlspecialchars($stall_picture) ?>" alt="<?= htmlspecialchars($stall['stall_name']) ?>">
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
        while ($food_item = $food_result->fetch_assoc()):?>
            <div class="food-item-card">
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
            <div class="side-section">
        <!-- Balance -->
        <div class="balance">
            Account Balance: $<span id="balance"><?php echo number_format($accountBalance, 2); ?></span>
        </div>
        <button id="toggle-btn" class="toggle-btn" onclick="toggleBalance()">Hide Balance</button>
        
        <!-- Profile Dropdown -->
        <div class="profile-dropdown">
            <button class="profile-btn">👤 Profile</button>
            <div class="dropdown-content">
                <a href="../UserProcess/profile.php">Main Profile</a>
                <a href="account.php">Account Details</a>
                <a href="settings.php">Settings</a>
                <a href="orders.php">Orders</a>
            </div>
        </div>
    </div>
</body>
</html>
