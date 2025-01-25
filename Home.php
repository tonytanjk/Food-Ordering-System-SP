<?php
// Include database connection file
include 'db_connection.php'; // Make sure this file contains your database connection logic

// Fetch the user's account balance from the database
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Query to fetch account balance
    $query = "SELECT account_balance FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $accountBalance = $row['account_balance'];
    } else {
        $accountBalance = 0.00; // Default balance if user is not found
    }
} else {
    // Redirect to login page if not logged in
    header("Location: ./UserProcess/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System @ SP</title>
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
            background-image: linear-gradient(to bottom, grey, red);
            height: 400px;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            font-size: 48px;
            font-weight: bold;
        }

        .hero h1 {
            margin: 0;
        }

        .section-title {
            text-align: center;
            font-size: 28px;
            margin-top: 40px;
            color: #333;
        }

        .card-container {
            display: flex;
            justify-content: space-around;
            margin: 20px;
            flex-wrap: wrap;
        }

        .card {
            background-color: white;
            width: 280px;
            margin: 10px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .card h3 {
            font-size: 22px;
            color: #333;
            margin: 10px 0;
        }

        .card p {
            font-size: 16px;
            color: #555;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .card a:hover {
            background-color: #45a049;
        }
        /* Side Section (Initially hidden) */
        .side-section {
            position: fixed;
            top: 20px;
            right: -250px;
            width: 250px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            transition: right 0.3s ease-in-out;
        }

        /* Only slides out when hovering over the side section */
        .side-section:hover {
            right: 20px;
        }

        .balance {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        .toggle-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .toggle-btn:hover {
            background-color: #45a049;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
            margin-top: 15px;
            width: 100%;
        }
        .profile-btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 16px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }
        .profile-btn:hover {
            background-color: #0056b3;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
            width: 100%;
            border-radius: 5px;
        }
        .dropdown-content a {
            display: block;
            color: #333;
            padding: 10px 16px;
            text-decoration: none;
            border-bottom: 1px solid #ddd;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .profile-dropdown:hover .dropdown-content {
            display: block;
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
        // Toggle the balance visibility
        function toggleBalance() {
            const balance = document.getElementById("balance");
            const toggleBtn = document.getElementById("toggle-btn");
            if (balance.style.display === "none") {
                balance.style.display = "inline";
                toggleBtn.textContent = "Hide Balance";
            } else {
                balance.style.display = "none";
                toggleBtn.textContent = "Show Balance";
            }
        }
    </script>
</head>
<body>

    <header>
    <h1>Food Ordering System @ SP</h1>
    <nav>
        <a href="./Home.php">Home</a>
        <a href="./FoodCourts/FC.php">Food Courts</a>
        <a href="#">Most Ordered</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <a href="./UserProcess/login.php">Logout</a>
    </nav>
    </header>

<div class="hero">
    <h1>Welcome to Our Food Ordering System</h1>
</div>

<section>
    <h2 class="section-title">Explore Our Food Courts</h2>
    <div class="card-container">
        <div class="card">
            <img src="./assets/fc1.jpg" alt="Food Court 1">
            <h3>Food Court 1</h3>
            <p>Explore a variety of delicious meals.</p>
            <a href="./FoodCourts/FC1.php">Visit</a>
        </div>
        <div class="card">
            <img src="./assets/fc2.jpg" alt="Food Court 2">
            <h3>Food Court 2</h3>
            <p>Discover your favorite food options.</p>
            <a href="./FoodCourts/FC2.php">Visit</a>
        </div>
        <div class="card">
            <img src="./assets/fc3.jpg" alt="Food Court 3">
            <h3>Food Court 3</h3>
            <p>Enjoy tasty treats and quick bites.</p>
            <a href="./FoodCourts/FC3.php">Visit</a>
        </div>
    </div>
</section>

<section>
    <h2 class="section-title">Most Ordered</h2>
    <div class="card-container">
        <div class="card">
            <img src="./assets/most-ordered1.jpg" alt="Most Ordered 1">
            <h3>Pizza</h3>
            <p>Our top choice! Freshly made pizza just for you.</p>
            <a href="#">Order Now</a>
        </div>
        <div class="card">
            <img src="./assets/most-ordered2.jpg" alt="Most Ordered 2">
            <h3>Burgers</h3>
            <p>The best burgers in town. Juicy and satisfying.</p>
            <a href="#">Order Now</a>
        </div>
        <div class="card">
            <img src="./assets/most-ordered3.jpg" alt="Most Ordered 3">
            <h3>Sushi</h3>
            <p>Delicious sushi with fresh ingredients.</p>
            <a href="#">Order Now</a>
        </div>
    </div>
</section>

<section>
    <h2 class="section-title">Special Offers</h2>
    <div class="card-container">
        <div class="card">
            <img src="./assets/offer1.jpg" alt="Special Offer 1">
            <h3>Buy 1 Get 1 Free</h3>
            <p>Enjoy a great offer at our food court.</p>
            <a href="#">Grab the Offer</a>
        </div>
        <div class="card">
            <img src="./assets/offer2.jpg" alt="Special Offer 2">
            <h3>20% Off on Your First Order</h3>
            <p>Sign up now and enjoy the discount!</p>
            <a href="#">Claim Now</a>
        </div>
        <div class="card">
            <img src="./assets/offer3.jpg" alt="Special Offer 3">
            <h3>Free Drink with Every Meal</h3>
            <p>Get a free drink with any meal at select food courts.</p>
            <a href="#">Check It Out</a>
        </div>
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
                <a href="account.php">Account Details</a>
                <a href="settings.php">Settings</a>
                <a href="orders.php">Orders</a>
            </div>
        </div>
    </div>

<footer>
    <p>&copy; 2025 I'm going nuts</p>
    <p><a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
</footer>

</body>
</html>
