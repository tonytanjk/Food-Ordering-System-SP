<?php
// Assuming you have a database connection file 'db_connection.php'
// include('db_connection.php'); // Uncomment once DB is available

// Query to get vendors for Food Court 2 (change accordingly for FC3 to FC6)
$query = "SELECT * FROM vendors WHERE food_court_id = 5";  // FC2
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Court 2 Vendors</title>
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
        <h1>Food Court 2 Vendors</h1>
        <div class="vendor-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($vendor = mysqli_fetch_assoc($result)) {
                    // Display vendor card dynamically
                    echo '<a href="food_selection.php?vendor_id=' . $vendor['id'] . '&food_court_id=5" class="vendor-card">';
                    echo '<img src="' . $vendor['image_url'] . '" alt="' . $vendor['name'] . '">';
                    echo '<div class="vendor-details">';
                    echo '<h2>' . $vendor['name'] . '</h2>';
                    echo '<p>' . $vendor['description'] . '</p>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo '<p>No vendors available at this moment.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
// mysqli_close($conn);
?>
