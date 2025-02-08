<?php
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/common.php';
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/Account.php';
echo $account, $main_head;

// Fetch top 5 most ordered food items based on item quantity across all food courts with food court and stall details
$query = "
    SELECT fi.food_name, fi.image_path, fi.stall_id, fi.food_court_id, SUM(oi.quantity) AS total_quantity
    FROM order_items oi
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    JOIN orders o ON oi.order_id = o.order_id
    WHERE o.status = 'Completed'
    GROUP BY oi.food_item_id
    ORDER BY total_quantity DESC
    LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Scripts/FC1_6_JS.js"></script>
    <link rel="stylesheet" href="Scripts/FC1_6_CSS.css">
    <title>Most Ordered Foods</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .hero {
            background-color: #4CAF50;
            height: 300px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 36px;
            font-weight: bold;
        }
        .section-title {
            text-align: center;
            font-size: 28px;
            margin-top: 40px;
            color: #333;
        }
        .most-ordered {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .food-item {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 220px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .food-item img {
            width: auto;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .food-item p {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .order-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .order-button:hover {
            background-color: #45a049;
        }
                /* Adjust grid layout for different screen sizes */
        @media (max-width: 1024px) {
            .most-ordered {
                grid-template-columns: repeat(2, 1fr); /* 2 columns for medium screens */
            }
        }

        @media (max-width: 768px) {
            .most-ordered {
                grid-template-columns: 1fr; /* 1 column for small screens */
            }
        }
    </style>
</head>
<body>
    <div class="hero">
        <p>Discover the Most Popular Dishes</p>
    </div>
    <section class="most-ordered">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="food-item">
                <div class="food-item-image">
                    <img src="<?= !empty($row['image_path']) ? '/ProjectCSAD' . htmlspecialchars($row['image_path']) : '/ProjectCSAD/uploads/unknown_food.jpg' ?>" alt="<?= htmlspecialchars($row['food_name']) ?>" onerror="this.onerror=null;this.src='/ProjectCSAD/uploads/unknown_food.jpg';" style="width: auto; height: 150px; object-fit: cover; border-radius: 8px;">
                </div>
                <p><?= htmlspecialchars($row['food_name']) ?></p>
                <p>Orders: <?= $row['total_quantity'] ?></p>
                <a href="/ProjectCSAD/FoodCourts/FC.php?food_court_id=<?= htmlspecialchars($row['food_court_id']) ?>&stall_id=<?= htmlspecialchars($row['stall_id']) ?>" class="order-button">Order Now</a>
            </div>
        <?php endwhile; ?>
    </section>
    <footer>
        <p>&copy; 2025 Food Courts</p>
        <p><a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
    </footer>
</body>
</html>
