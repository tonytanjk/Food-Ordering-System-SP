<?php
include '../scripts/common.php'; // Database connection and common functions
include 'VendorCommon.php';

// Fetch stall_id and food_court_id for the logged-in vendor
$user_id = $_SESSION['user_id'] ?? 0; // Ensure user_id is set
$query = "SELECT stall_id, food_court_id FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stall_id = $user['stall_id'] ?? 0;
$food_court_id = $user['food_court_id'] ?? 0;

// Fetch open orders specific to the vendor
$query = "
    SELECT 
        o.order_id, 
        o.tracking_id, 
        u.username, 
        SUM(oi.price * oi.quantity) AS total_amount,  -- Calculate the total dynamically
        o.payment_method, 
        o.order_date, 
        GROUP_CONCAT(CONCAT(fi.food_name, ' x', oi.quantity, ' ($', oi.price, ')') SEPARATOR ', ') AS order_details
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    WHERE fi.stall_id = ? 
      AND fi.food_court_id = ? 
      AND o.status = 'Pending' 
    GROUP BY o.order_id, o.tracking_id, u.username, o.payment_method, o.order_date
    ORDER BY o.order_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $stall_id, $food_court_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;

// Handle order status updates
if (isset($_POST['close_order'])) {
    $order_id = $_POST['order_id'];
    $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();

    // Redirect to refresh the list of orders
    header("Location: manage_orders.php");
    exit();
}

if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];
    $reason = $_POST['reason']; // Get cancellation reason from POST data

    if (!empty($reason)) {
        // Start transaction for data integrity
        $conn->begin_transaction();

        try {
            // Fetch order details
            $stmt = $conn->prepare("SELECT user_id, total_amount FROM orders WHERE order_id = ?");
            $stmt->bind_param('i', $order_id);
            $stmt->execute();
            $order = $stmt->get_result()->fetch_assoc();
            $user_id = $order['user_id'];
            $refund_amount = $order['total_amount'];

            // Fetch the current account balance of the user
            $stmt = $conn->prepare("SELECT account_balance FROM users WHERE user_id = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $current_balance = $user['account_balance'];

            // Calculate new balance
            $new_balance = $current_balance + $refund_amount;

            // Update the user's account balance
            $stmt = $conn->prepare("UPDATE users SET account_balance = ? WHERE user_id = ?");
            $stmt->bind_param('di', $new_balance, $user_id);
            $stmt->execute();

            // Update order status to 'Cancelled' and save the reason
            $stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled', reason = ? WHERE order_id = ?");
            $stmt->bind_param('si', $reason, $order_id);
            $stmt->execute();

            // Commit the transaction
            $conn->commit();

            // Redirect to refresh the list of orders
            header("Location: manage_orders.php");
            exit();
        } catch (Exception $e) {
            // Rollback transaction if any error occurs
            $conn->rollback();
            echo "<script>alert('Error processing the refund. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please provide a reason for cancellation.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Scripts/FC1_6_CSS.css">
    <title>Vendor Orders</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 1200px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-button {
            background-color: #28a745;
            color: white;
        }

        .close-button:hover {
            background-color: #218838;
        }

        .cancel-button {
            background-color: #dc3545;
            color: white;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }

        /* Modal Styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Black background with opacity */
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Adjust as needed */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal .close-button:hover,
        .modal .close-button:focus {
            color: #000;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="color: white">Manage Orders</h1>
        <?php echo $navi; // Display the navigation bar ?>
    </header>
    <div class="container">
        <h1>Open Orders</h1>
        <?php if ($orders === null): ?>
            <p>No orders yet.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Tracking ID</th>
                        <th>Username</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['tracking_id']) ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($order['payment_method']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                            <button type="submit" name="close_order" class="action-button close-button">Close Order</button>
                            <button type="button" class="action-button cancel-button" onclick="confirmCancel(<?= htmlspecialchars($order['order_id']) ?>)">Cancel Order</button>
                        </form>
                        <button class="action-button" onclick="viewOrderDetails(<?= htmlspecialchars($order['order_id']) ?>)">View Details</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
        <?php endif; ?>
    </div>
    <!-- Modal for Order Details -->
    <div id="orderDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <h2>Order Details</h2>
            <div id="orderDetailsContent">
                <!-- Order details will be loaded dynamically here -->
            </div>
        </div>
    </div>
    <script>
        function confirmCancel(orderId) {
            const reason = prompt("Please provide a reason for canceling this order:");
            if (reason !== null && reason.trim() !== "") {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'manage_orders.php';
                
                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_id';
                orderIdInput.value = orderId;
                form.appendChild(orderIdInput);

                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'reason';
                reasonInput.value = reason;
                form.appendChild(reasonInput);

                const cancelOrderInput = document.createElement('input');
                cancelOrderInput.type = 'hidden';
                cancelOrderInput.name = 'cancel_order';
                form.appendChild(cancelOrderInput);

                document.body.appendChild(form);
                form.submit();
            } else {
                alert("Reason is required to cancel the order.");
            }
        }

        function viewOrderDetails(orderId) {
            const modal = document.getElementById("orderDetailsModal");
            const modalContent = document.getElementById("orderDetailsContent");
            modal.style.display = "block";
            modalContent.innerHTML = "<p>Loading...</p>";

            fetch(`fetch_order.php?order_id=${orderId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const totalAmount = parseFloat(data.total_amount) || 0; // Ensure it's a number
                        const formattedAmount = totalAmount.toFixed(2); // Format the amount

                        modalContent.innerHTML = `
                            <p><strong>Order ID:</strong> ${data.order_id}</p>
                            <p><strong>Tracking ID:</strong> ${data.tracking_id}</p>
                            <p><strong>Customer:</strong> ${data.username}</p>
                            <p><strong>Total Amount:</strong> $${formattedAmount}</p>
                            <p><strong>Payment Method:</strong> ${data.payment_method}</p>
                            <p><strong>Order Date:</strong> ${data.order_date}</p>
                            <p><strong>Order Items:</strong><br>${data.order_details}</p>
                        `;
                    } else {
                        modalContent.innerHTML = "<p>Failed to fetch order details.</p>";
                    }
                })
                .catch(error => {
                    console.error("Error fetching order details:", error);
                    modalContent.innerHTML = "<p>Error fetching order details. Please try again later.</p>";
                });
        }

        function closeModal() {
            const modal = document.getElementById("orderDetailsModal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById("orderDetailsModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
    <?php echo $foot; // Display the footer  ?>
</body>
</html>

