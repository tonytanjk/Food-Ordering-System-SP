<?php

// Include database connection
include_once 'Scripts/common.php';
include 'Scripts/Account.php';
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
       
    
    <footer>
        <p>&copy; 2025 Food Courts</p>
        <p><a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
    </footer>

</body>
</html>
