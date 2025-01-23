<?php

// Include the database connection
include '../db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the inputs
    $food_item_id = isset($_POST['food_item_id']) ? intval($_POST['food_item_id']) : null;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($food_item_id && $quantity > 0) {
        // Check if the item exists in the database
        $stmt = $conn->prepare("SELECT * FROM food_items WHERE food_item_id = ?");
        $stmt->bind_param("i", $food_item_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($food_item = $result->fetch_assoc()) {
            // Initialize the cart if it doesn't exist
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Add or update the cart item
            if (isset($_SESSION['cart'][$food_item_id])) {
                // Update the quantity
                $_SESSION['cart'][$food_item_id]['quantity'] += $quantity;
            } else {
                // Add a new item to the cart
                $_SESSION['cart'][$food_item_id] = [
                    'name' => $food_item['food_name'],
                    'price' => $food_item['price'],
                    'quantity' => $quantity,
                ];
            }

            // Redirect back to the previous page or display a success message
            header("Location: ../FoodCourts/FC1.php?stall_id=" . $food_item['stall_id']);
            exit();
        } else {
            echo "Food item not found.";
        }
    } else {
        echo "Invalid food item or quantity.";
    }
} else {
    echo "Invalid request method.";
}
?>
