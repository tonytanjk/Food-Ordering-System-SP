<?php 
//DB Connection and Script Usage
include '../scripts/common.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Metrics</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
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

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .metric-card {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .metric-card h2 {
            font-size: 24px;
            color: #007bff;
            margin: 10px 0;
        }

        .metric-card p {
            font-size: 18px;
            color: #555;
        }

        .sales-trends {
            margin-top: 30px;
        }

        .sales-trends h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .trends-table {
            width: 100%;
            border-collapse: collapse;
        }

        .trends-table th, .trends-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .trends-table th {
            background-color: #f4f4f9;
            color: #333;
        }

        .trends-table tbody tr:nth-child(even) {
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
        <h1>Sales Metrics Dashboard</h1>
        <br
        <nav>
            <a href="stall_configure.php">Stall</a>
            <a href="top_sales.php">Top Sales</a>
            <a href="revenue_metrics.php">Revenue Metrics</a>
            <a href="../UserProcess/logout.php">Logout</a></br>
        </nav>
    </header>

    <div class="container">
        <div class="metrics-grid">
            <div class="metric-card">
                <h2>Daily Sales</h2>
                <p>$<?= number_format($totalSales, 2) ?></p>
            </div>
            <div class="metric-card">
                <h2>Daily Orders</h2>
                <p><?= $totalOrders ?></p>
            </div>
            <div class="metric-card">
                <h2>Daily Sales Growth</h2>
                <p><?= number_format($dailySalesGrowth, 2) ?>%</p>
            </div>
        </div>

        <div class="sales-trends">
            <h2>Sales Trends (Last 7 Days)</h2>
            <table class="trends-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Daily Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salesTrends as $trend): ?>
                        <tr>
                            <td><?= htmlspecialchars($trend['order_date']) ?></td>
                            <td>$<?= number_format($trend['daily_sales'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> Food Ordering System. All Rights Reserved.</p>
    </footer>
</body>
</html>