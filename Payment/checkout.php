<?php
session_start();

// Checkout logic here (e.g., payment, saving order to database)
if (isset($_POST['checkout'])) {
    // Process the checkout (you can save the order to the database, etc.)
    // For now, just clear the cart after checkout
    $_SESSION['cart'] = [];
    echo "<p>Your order has been successfully placed!</p>";
    exit;
}
?>
