<?php

// Include database connection
include_once 'db_connection.php';

// Get user ID from session
$userId = $_SESSION['user_id'];
// Fetch user account balance
function getAccountBalance($userId, $conn) {
    $query = "SELECT account_balance FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['account_balance'];
    }
    return 0.00; // Default balance if not found
}

$accountBalance = getAccountBalance($userId, $conn);

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
        .food-courts, .most-ordered {
            display: flex;
            justify-content: space-around;
            margin: 20px;
            flex-wrap: wrap;
        }
        .food-court, .food-item {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            width: 250px;
            text-align: center;
        }
        .food-court button, .food-item button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .food-court button:hover, .food-item button:hover {
            background-color: #45a049;
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
</head>
<body>

    <header>
        <h1 style="color: white">Most Ordered Foods</h1>
        <nav>
        <a href="./Home.php">Home</a>
        <a href="Most_Order.php">Most Ordered</a>
        <a href="UserProcess/About.html">About Us</a>
        <a href="UserProcess/Contact.html">Contact</a>
        <a href="./UserProcess/login.php">Logout</a>
        </nav>
    </header>

    <div class="hero">
        <p>Discover the Most Popular Dishes</p>
    </div>

    <section class="most-ordered">
        <h2 class="section-title">Most Ordered Foods</h2>
        <div class="food-item">
            <button style="background-image: url('fooditem1-image.jpg');" onclick="window.location.href='#';">Food Item 1</button>
        </div>
        <div class="food-item">
            <button style="background-image: url('fooditem2-image.jpg');" onclick="window.location.href='#';">Food Item 2</button>
        </div>
        <div class="food-item">
            <button style="background-image: url('fooditem3-image.jpg');" onclick="window.location.href='#';">Food Item 3</button>
        </div>
        <div class="food-item">
            <button style="background-image: url('fooditem4-image.jpg');" onclick="window.location.href='#';">Food Item 4</button>
        </div>
        <div class="food-item">
            <button style="background-image: url('fooditem5-image.jpg');" onclick="window.location.href='#';">Food Item 5</button>
        </div>
        
    </section>
    
    
        <div class="side-section">
        <!-- Balance -->
        <div class="balance">
            Account Balance: $<span id="balance"><?php echo number_format($accountBalance, 2); ?></span>
        </div>
        <button id="toggle-btn" class="toggle-btn" onclick="toggleBalance()">Hide Balance</button>
        
        <!-- Profile Dropdown -->
        <div class="profile-dropdown">
            <button class="profile-btn">👤 Profile</button>
            <div class="dropdown-content">
                <a href="./UserProcess/profile.php">Main Profile</a>
                <a href="Top_up.php">Top up</a>
                <a href="settings.php">Settings</a>
                <a href="orders.php">Orders</a>
            </div>
        </div>
    </div>    
    
    
    
    <footer>
        <p>&copy; 2025 Food Courts</p>
        <p><a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
    </footer>

</body>
</html>
