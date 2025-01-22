<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Courts</title>
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
            background-image: url(../assets/fc.jpeg);
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
        .food-courts {
            display: flex;
            justify-content: space-around;
            margin: 20px;
            flex-wrap: wrap;
        }
        .food-court {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            width: 250px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .food-court a {
            width: auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
        }

        .food-court a:hover {
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
        <a href="../Home.php">Home</a>
        <a href="FC.php">Food Courts</a>
        <a href="../Most_Order.php">Most Ordered</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <a href="../UserProcess/login.php">Logout</a>
        </nav>
    </header>

    <div class="hero">
        <p>Explore Our Food Courts</p>
    </div>

    <section class="food-courts">
        <h2 class="section-title">Food Courts</h2>
        <div class="food-court">
            <a href="FoodCourts/FC1.php">Foodcourt 1</a>
        </div>
        <div class="food-court">
            <a href="FoodCourts/FC2.php">Foodcourt 2</a>
        </div>
        <div class="food-court">
            <a href="FoodCourts/FC3.php">Foodcourt 3</a>
        </div>
        <div class="food-court">
            <a href="FoodCourts/FC4.php">Foodcourt 4</a>
        </div>
        <div class="food-court">
            <a href="FoodCourts/FC5.php">Bang Deli @ Foodcourt 5</a>
        </div>
        <div class="food-court">
            <a href="FoodCourts/FC6.php">Foodcourt 6</a>
        </div>
    </section>

    <!-- Side Section (Initially hidden) -->
    <div class="side-section">
        <!-- Balance -->
        <div class="balance">
            Account Balance: $<span id="balance">100.00</span>
        </div>
        <button id="toggle-btn" class="toggle-btn" onclick="toggleBalance()">Hide Balance</button>
        
        <!-- Profile Dropdown -->
        <div class="profile-dropdown">
            <button class="profile-btn">👤 Profile</button>
            <div class="dropdown-content">
                <a href="../UserProcess/profile.php">Main Profile</a>
                <a href="account.php">Account Details</a>
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
