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
        header{
            text-shadow:2px 2px 5px #000;
            background-color: #333;
            color: white;
            font-size:16px;
            padding: 20px;
            text-align: center;
            transition:05s;
        }
        
        a{
            font-size:16px;
        }
        
        header nav a:hover{
            font-size:18px;
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
            background-image: url(fc1_1.jpg);
            height: 300px;
            background-size: cover;
            color: white;
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
            text-align:center;
            display: flex;
            justify-content:center;
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
        .food-court a, .food-item button {
            width: 90%;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .food-court a:hover, .food-item button:hover {
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
        
        #background-music {
            display: none;
        }
    </style>
</head>
<body>
    <audio id="background-music" autoplay loop>
        <source src="music/JazzMusic.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <header>
        <h1>Food Ordering System @ SP</h1>
        <nav>
            <a href="Homepage.php">Home</a>
            <a href="FC.php">Food Courts</a>
            <a href="Most_Order.php">Most Ordered</a>
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

    <footer>
        <p>&copy; 2025 Food Courts</p>
        <p><a target="_blank" href="https://www.starbucks.com/terms/suppliers-standard-terms-and-conditions/">Terms</a> | <a target="_blank" href="https://www.starbucks.com/terms/privacy-notice/">Privacy Policy</a> | <a href="#">Contact</a></p>
    </footer>

</body>
<script>
    let musicStarted = false;
    window.addEventListener('scroll', () => {
        if (!musicStarted) {
            document.getElementById('background-music').play();
            musicStarted = true;
        }
    });
    
    const audio = document.getElementById('background-music');
    audio.volume = 0.25; // Set volume to 50%
</script>
</html>
