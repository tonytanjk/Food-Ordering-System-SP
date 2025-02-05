<?php
// Include database connection file
include 'Scripts/common.php';
include 'Scripts/Account.php';
include $_SERVER['DOCUMENT_ROOT'] .  '/projectCSAD/Vendor/VendorCommon.php';

echo $account,$main_head;
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
    font-size: 36px;
    font-weight: bold;
    padding: 0 20px;
    box-sizing: border-box;
}

.section-title {
    text-align: center;
    font-size: 24px;
    margin-top: 20px;
    color: #333;
}

.card-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin: 10px;
    gap: 10px;
}

.card {
    flex: 1 1 300px;
    background-color: white;
    max-width: 300px;
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
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
}

.card h3 {
    font-size: 20px;
    color: #333;
    margin: 10px 0;
}

.card p {
    font-size: 14px;
    color: #555;
}

.card a {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 16px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

.card a:hover {
    background-color: #45a049;
}

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

.side-section:hover {
    right: 20px;
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

/* Responsive Design */
@media (max-width: 768px) {
    .hero {
        font-size: 28px;
        height: 300px;
    }

    .section-title {
        font-size: 22px;
    }

    .card {
        flex: 1 1 45%;
        max-width: 100%;
    }

    .card-container {
        gap: 15px;
        margin: 10px;
    }
}

@media (max-width: 480px) {
    .hero {
        font-size: 24px;
        height: 250px;
        padding: 0 10px;
    }

    .section-title {
        font-size: 20px;
        margin-top: 10px;
    }

    .card {
        flex: 1 1 90%;
        max-width: 100%;
        margin: 5px;
    }

    .card img {
        height: 150px;
    }

    .card h3 {
        font-size: 18px;
    }

    .card p {
        font-size: 12px;
    }

    .card a {
        font-size: 12px;
        padding: 6px 12px;
    }
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
</head>
<body>

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
            <a href="./FoodCourts/FC.php?food_court_id=1">Visit</a>
        </div>
        <div class="card">
            <img src="./assets/fc2.jpg" alt="Food Court 2">
            <h3>Food Court 2</h3>
            <p>Discover your favorite food options.</p>
            <a href="./FoodCourts/FC.php?food_court_id=2">Visit</a>
        </div>
        <div class="card">
            <img src="./assets/fc3.jpg" alt="Food Court 3">
            <h3>Food Court 3</h3>
            <p>Enjoy tasty treats and quick bites.</p>
            <a href="./FoodCourts/FC.php?food_court_id=3">Visit</a>
        </div>
            <div class="card">
            <img src="./assets/fc4.jpg" alt="Food Court 3">
            <h3>Food Court 4</h3>
            <p>Enjoy tasty treats and quick bites.</p>
            <a href="./FoodCourts/FC.php?food_court_id=4">Visit</a>
        </div>
            <div class="card">
            <img src="./assets/fc5.jpg" alt="Food Court 3">
            <h3>Food Court 5</h3>
            <p>Enjoy tasty treats and quick bites.</p>
            <a href="./FoodCourts/FC.php?food_court_id=5">Visit</a>
        </div>
            <div class="card">
            <img src="./assets/fc6.jpg" alt="Food Court 3">
            <h3>Food Court 6</h3>
            <p>Enjoy tasty treats and quick bites.</p>
            <a href="./FoodCourts/FC.php?food_court_id=6">Visit</a>
        </div>
    </div>
</section>

    <?php echo $foot; // Display the footer  ?>


</body>
</html>
