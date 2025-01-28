<?php
// Include database connection and common functions
include '../scripts/common.php';

// Assume user_id is stored in session after login
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch stall_id and food_court_id for the logged-in user
$query = "SELECT stall_id, food_court_id FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stall_id = $user['stall_id'] ?? 0;
$food_court_id = $user['food_court_id'] ?? 0;

// Fetch sales metrics
$totalSales = getTotalSales($conn, $stall_id, $food_court_id);
$totalOrders = getTotalOrders($conn, $stall_id, $food_court_id);
$averageOrderValue = getAverageOrderValue($conn, $stall_id, $food_court_id);
$salesTrends = getSalesTrends(7, $conn, $stall_id, $food_court_id); // Last 7 days

// Fetch stall items
$query = "SELECT * FROM food_items WHERE stall_id = ? AND food_court_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $stall_id, $food_court_id);
$stmt->execute();
$stallItems = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Home</title>
    <script>
        function deleteItem() {
            var form = document.getElementById('itemForm');
            form.action = 'delete_item.php';
            form.submit();
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
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
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .widget {
            display: inline-block;
            width: 30%;
            padding: 20px;
            margin: 10px;
            background: #f4f4f4;
            border-radius: 8px;
            text-align: center;
            
        }

        .widget h3 {
            margin: 0 0 10px;
            color: #444;
        }

        .widget p {
            font-size: 1.2em;
            margin: 0;
        }

        .stall-items {
            margin-top: 30px;
        }

        .stall-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .stall-items th, .stall-items td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .stall-items th {
            background-color: #f4f4f4;
        }

        .stall-items tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .edit-form, .add-form {
            margin-top: 20px;
            display: none;
        }

        .edit-form input, .edit-form textarea, .add-form input, .add-form textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .edit-form button, .add-form button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-form button:hover, .add-form button:hover {
            background-color: #555;
        }
                footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        footer a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
    <script>
        function showEditForm(itemId, foodName, description, price) {
            document.getElementById('edit-form').style.display = 'block';
            document.getElementById('item_id').value = itemId;
            document.getElementById('food_name').value = foodName;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
        }

        function showAddForm() {
            document.getElementById('add-form').style.display = 'block';
        }
    </script>
</head>
<body>
    <header>
        <h1>Vendor Home</h1>
        <nav>
            <a href="manage_orders.php">Manage Orders</a>
            <a href="SalesMetrics.php">Sales Metrics</a>
            <a href="top_sales.php">Top Sales</a>
            <a href="../Client/login.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <div class="widget">
            <h3>Total Sales</h3>
            <p>$<?= number_format($totalSales, 2) ?></p>
        </div>
        <div class="widget">
            <h3>Total Orders</h3>
            <p><?= $totalOrders ?></p>
        </div>
        <div class="widget">
            <h3>Average Order Value</h3>
            <p>$<?= number_format($averageOrderValue, 2) ?></p>
        </div>

        <div class="stall-items">
            <h2>Stall Items</h2>
            <button onclick="showAddForm()">Add New Item</button>
            <table>
                <thead>
                    <tr>
                        <th>Food Item</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $stallItems->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['food_name']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <button onclick="showEditForm('<?= $item['food_item_id'] ?>', '<?= htmlspecialchars($item['food_name']) ?>', '<?= htmlspecialchars($item['description']) ?>', '<?= $item['price'] ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="edit-form" class="edit-form">
            <h2>Edit Item</h2>
            <form id="itemForm" action="update_item.php" method="post">
                <input type="hidden" id="stall_id" name="stall_id" value="<?= $stall_id ?>">
                <input type="hidden" id="item_id" name="item_id">
                <label for="food_name">Food Name:</label>
                <input type="text" id="food_name" name="food_name" required>
                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
                <button type="submit">Update Item</button>
                <button type="submit" onclick="deleteItem()">Delete item</button>
            </form>
        </div>

        <div id="add-form" class="add-form">
            <h2>Add New Item</h2>
            <form action="add_item.php" method="post">
                <input type="hidden" name="stall_id" value="<?= $stall_id ?>">
                <label for="new_food_name">Food Name:</label>
                <input type="text" id="new_food_name" name="food_name" required>
                <label for="new_description">Description:</label>
                <textarea id="new_description" name="description"></textarea>
                <label for="new_price">Price:</label>
                <input type="number" id="new_price" name="price" step="0.01" required>
                <button type="submit">Add Item</button>
            </form>
        </div>
    </div>

<footer>
    <p>&copy; 2025 I'm going nuts</p>
    <p><a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
</footer>
</body>
</html>