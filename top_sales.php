<?php
// Include database connection and common functions
include '../scripts/common.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../UserProcess/login.php");
    exit();
}

// Get vendor_id and food_court_id from URL parameters
$vendor_id = isset($_GET['vendor_id']) ? intval($_GET['vendor_id']) : 0;
$food_court_id = isset($_GET['food_court_id']) ? intval($_GET['food_court_id']) : 0;

// Fetch top-selling items for a specific vendor and food court
function getTopSellingItems($conn, $vendor_id, $food_court_id, $limit = 10) {
    $query = "
        SELECT fi.food_name, SUM(oi.quantity) AS total_quantity, SUM(oi.price * oi.quantity) AS total_revenue
        FROM order_items oi
        JOIN food_items fi ON oi.food_id = fi.food_id
        JOIN food_stalls fs ON fi.stall_id = fs.stall_id
        WHERE fs.vendor_id = ? AND fs.food_court_id = ?
        GROUP BY oi.food_id
        ORDER BY total_quantity DESC
        LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $vendor_id, $food_court_id, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

$topSellingItems = getTopSellingItems($conn, $vendor_id, $food_court_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Sales</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        header h1 {
            margin: 0;
        }

        header nav {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        header nav a {
            color: white;
            margin-left: 15px;
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

        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .top-sales-table {
            width: 100%;
            border-collapse: collapse;
        }

        .top-sales-table th, .top-sales-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .top-sales-table th {
            background-color: #f4f4f4;
        }

        .top-sales-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #333;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Top Sales</h1>
        <nav>
            <a href="../UserProcess/logout.php">Logout</a>
            <a href="sales_metrics.php">Sales Metrics</a>
            <a href="top_sales.php">Top Sales</a>
            <a href="revenue_metrics.php">Revenue Metrics</a>
        </nav>
    </header>

    <div class="container">
        <h2>Top Selling Items</h2>
        <table class="top-sales-table">
            <thead>
                <tr>
                    <th>Food Item</th>
                    <th>Total Quantity Sold</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $topSellingItems->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['food_name']) ?></td>
                        <td><?= $item['total_quantity'] ?></td>
                        <td>$<?= number_format($item['total_revenue'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> Food Ordering System. All Rights Reserved.</p>
    </footer>
</body>
</html>