<?php

include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/common.php';
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/Account.php';
echo $account,$main_head;

// Fetch orders from the database for the logged-in user
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .order-header {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-header h2 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        .order {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .order .order-details {
            margin-bottom: 10px;
        }

        .order .order-details p {
            margin: 5px 0;
        }

        .order .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .order .button:hover {
            background-color: #45a049;
        }

        /* Pop-up styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .popup table {
            width: 100%;
            border-collapse: collapse;
        }

        .popup th, .popup td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .popup th {
            background-color: #f4f4f4;
        }

        .popup tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .popup .close-btn {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .popup .close-btn:hover {
            background-color: #555;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
    <script>
        function showOrderDetails(orderId) {
            console.log('Fetching details for order ID:', orderId); // Debugging line
            // Fetch order details using AJAX
            fetch(`fetch_order_details.php?order_id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Order details:', data); // Debugging line
                    const popup = document.getElementById('popup');
                    const overlay = document.getElementById('overlay');
                    const tableBody = document.getElementById('popup-table-body');

                    // Clear previous data
                    tableBody.innerHTML = '';

                    // Populate table with new data
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.food_name}</td>
                            <td>${item.quantity}</td>
                            <td>$${parseFloat(item.price).toFixed(2)}</td>
                        `;
                        tableBody.appendChild(row);
                    });

                    // Show the popup and overlay
                    popup.style.display = 'block';
                    overlay.style.display = 'block';
                })
                .catch(error => console.error('Error fetching order details:', error)); // Debugging line
        }

        function closePopup() {
            const popup = document.getElementById('popup');
            const overlay = document.getElementById('overlay');
            popup.style.display = 'none';
            overlay.style.display = 'none';
        }
    </script>
</head>
<body>

<div class="container">
    <div class="order-header">
        <h2>Your Order History</h2>
    </div>

    <?php if (count($orders) > 0): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order">
                <div class="order-details">
                    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['tracking_id']); ?></p>
                    <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                    <p><strong>Total Cost:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
                </div>

                <button class="button" onclick="showOrderDetails(<?php echo $order['order_id']; ?>)">View Order Details</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You have no past orders yet.</p>
    <?php endif; ?>
</div>

<!-- Pop-up for order details -->
<div id="popup" class="popup">
    <h3>Order Details</h3>
    <table>
        <thead>
            <tr>
                <th>Food Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody id="popup-table-body">
            <!-- Order details will be populated here -->
        </tbody>
    </table>
    <button class="close-btn" onclick="closePopup()">Close</button>
</div>

<div id="overlay" class="overlay" onclick="closePopup()"></div>

</body>
</html>