<?php
session_start();

if (!isset($_SESSION['tracking_id'])) {
    // Redirect to checkout if no tracking ID is found
    header("Location: checkout.php");
    exit();
}

$tracking_id = $_SESSION['tracking_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 600px;
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

        .message {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .tracking {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }

        .tracking a {
            color: #007bff;
            text-decoration: none;
        }

        .tracking a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Placed Successfully</h1>
        <div class="message success">
            Your order has been successfully placed! Your tracking ID is <strong><?php echo $tracking_id; ?></strong>. Please save this ID to track your order.
        </div>

        <div class="tracking">
            <p>Track your order: <a href="track_order.php?tracking_id=<?php echo $tracking_id; ?>">Click here</a></p>
        </div>
    </div>
</body>
</html>
