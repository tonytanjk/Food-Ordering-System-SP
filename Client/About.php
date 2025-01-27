<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/common.php';
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/Account.php';
echo $account,$main_head;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>About Us</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../Scripts/FC1_6_CSS.css">
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
            
            .heading {
                width: 90%;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                text-align: center;
                margin: 20px auto;
            }

            .heading h1 {
                font-size: 50px;
                color: #000;
                margin-bottom: 25px;
                position: relative;
            }

            .heading h1::after {
                content: "";
                position: absolute;
                width: 80px;
                height: 4px;
                display: block;
                background-color: #000; /* Changed color for visibility */
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
            }

            .heading p {
                font-size: 18px;
                color: black;
                margin-bottom: 35px;
            }

            .container {
                width: 90%;
                margin: 0 auto;
                padding: 10px 20px;
            }

            .about {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
            }

            .about-image {
                flex: 1;
                margin-right: 40px;
                overflow: hidden;
            }

            .about-image img {
                max-width: 100%;
                height: auto;
                display: block;
                transition: 0.5s ease;
            }

            .about-image:hover img {
                transform: scale(1.1); /* Adjusted scale for smoother zoom effect */
            }

            .about-content {
                flex: 1;
            }

            .about-content h2 {
                font-size: 23px;
                margin-bottom: 15px;
                color: black;
            }

            .about-content p {
                font-size: 18px;
                line-height: 1.5;
                color: black;
            }

            .about-content .read_more {
                display: inline-block;
                padding: 10px 20px;
                color: white;
                background-color: #333; /* Added a background color for better visibility */
                font-size: 19px;
                text-decoration: none;
                border-radius: 25px;
                margin-top: 15px;
                transition: 0.3s ease;
            }

            .about-content .read_more:hover {
                background-color: #555; /* Darker shade for hover effect */
            }

            /* Responsive Design */
            @media screen and (max-width: 768px) {
                .heading {
                    padding: 0px 20px;
                }

                .heading h1 {
                    font-size: 36px;
                    margin-bottom: 10px;
                }

                .heading p {
                    font-size: 17px;
                    margin-bottom: 10px;
                }

                .container {
                    padding: 0px;
                }

                .about {
                    padding: 20px;
                    flex-direction: column;
                }

                .about-image {
                    margin-right: 0px;
                    margin-bottom: 20px;
                }

                .about-content p {
                    padding: 0px;
                    font-size: 16px;
                }

                .about-content .read_more {
                    font-size: 16px;
                }
            }
        </style>
    </head>
    
    <body>
       
        <div class="heading">
            <h1>About Us</h1>
            <p>This is where the description goes. Add meaningful content here.</p>
        </div>
        
        <div class="container">
            <section class="about">
                <div class="about-image"> 
                    <img src="Singapore_Polytechnic_logo.png" alt="Singapore Polytechnic Logo">
                </div>
                <div class="about-content">
                    <h2>Our Mission</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Cras convallis vehicula orci, sed ultricies ligula bibendum nec.</p>
                    <a href="LM.php" class="read_more">Read More</a>
                </div>
            </section>
        </div>
    <footer>
        <p>&copy; 2025 Food Courts</p>
        <p><a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
    </footer>
    </body>
</html>
