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
            justify-items:center; 
            justify-content: center;
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
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
}

/* Hero Section */
    .hero {
        background-color: #4CAF50;
        height: 250px;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-size: 36px;
        font-weight: bold;
        padding: 20px;
        box-sizing: border-box;
}

    .section-title {
        text-align: center;
        font-size: 28px;
        margin-top: 20px;
        color: #333;
}

/* Responsive Food Cards */
    .most-ordered {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 20px;
        justify-content: center;
}

    .food-item {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
}

    .food-item:hover {
        transform: translateY(-5px);
}

    .food-item img {
        width: 100%;
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
        display: inline-block;
        transition: background 0.3s ease-in-out;
}

    .order-button:hover {
        background-color: #45a049;
}

/* Footer */
    footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 20px;
        font-size: 14px;
}

    footer a {
        color: white;
        margin: 0 10px;
        text-decoration: none;
}

    footer a:hover {
        text-decoration: underline;
}

/* Responsive Design */
    @media (max-width: 768px) {
    .hero {
        font-size: 28px;
        height: 200px;
    }

    .section-title {
        font-size: 22px;
    }

    .food-item p {
        font-size: 16px;
    }

    .order-button {
        font-size: 14px;
        padding: 8px 16px;
    }
}

    @media (max-width: 480px) {
    .hero {
        font-size: 24px;
        height: 180px;
        padding: 15px;
    }

    .section-title {
        font-size: 20px;
        margin-top: 10px;
    }

    .food-item {
        padding: 15px;
    }

    .food-item img {
        height: 120px;
    }

    .food-item p {
        font-size: 14px;
    }

    .order-button {
        font-size: 12px;
        padding: 6px 12px;
    }
}

    </style>
</head>
<body>
    <div class="hero">
        <p>Discover the Most Popular Dishes</p>
    </div>
    <section class="most-ordered">
        <h2 class="section-title">Most Ordered Foods</h2>
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
