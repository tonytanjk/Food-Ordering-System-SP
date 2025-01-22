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
            background-image: url(fc.jpeg);
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
        <h1>Food Ordering System @ SP</h1>
        <nav>
            <a href="#">Home</a>
            <a href="FC.php">Food Courts</a>
            <a href="#">Most Ordered</a>
            <a href="#">About Us</a>
            <a href="#">Contact</a>
            <a href="login.php">Logout</a>
        </nav>
    </header>

    <div class="hero">
        <p>Explore Our Food Courts</p>
    </div>

    <section class="food-courts">
        <h2 class="section-title">Food Courts</h2>
        <div class="food-court">
            <button>Foodcourt 1</button>
        </div>
        <div class="food-court">
            <button>Foodcourt 2</button>
        </div>
        <div class="food-court">
            <button>Foodcourt 3</button>
        </div>
        <div class="food-court">
            <button>Foodcourt 4</button>
        </div>
        <div class="food-court">
            <button>Bang Deli @ Foodcourt 5</button>
        </div>
        <div class="food-court">
            <button>Foodcourt 6</button>
        </div>
    </section>
    <footer>
        <p>&copy; 2025 Food Courts</p>
        <p><a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
    </footer>

</body>
</html>