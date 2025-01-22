<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Court Vendors</title>
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
            margin: 20px auto;
            padding: 10px;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        .vendor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .vendor-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .vendor-card:hover {
            transform: translateY(-5px);
        }

        .vendor-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .vendor-card .vendor-details {
            padding: 15px;
        }

        .vendor-card h2 {
            font-size: 18px;
            margin: 0 0 10px;
            color: #007bff;
        }

        .vendor-card p {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Food Court Vendors</h1>
        <div class="vendor-grid">
            <?php
            // Database connection
            $pdo = new PDO("mysql:host=localhost;dbname=food_court", 'root', '');

            // Fetch vendors for the food court FC1
            $stmt = $pdo->query("SELECT * FROM vendors WHERE food_court_id = 1");
            while ($vendor = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <a href="food_selection.php?vendor_id=<?= $vendor['id'] ?>" class="vendor-card">
                    <img src="images/placeholder.jpg" alt="<?= $vendor['name'] ?>">
                    <div class="vendor-details">
                        <h2><?= htmlspecialchars($vendor['name']) ?></h2>
                        <p>Click to view food selection.</p>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
