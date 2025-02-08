<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/common.php';
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/Account.php';
include $_SERVER['DOCUMENT_ROOT'] .  '/projectCSAD/Vendor/VendorCommon.php';

echo $account,$main_head;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <script src="https://kit.fontawesome.com/0ec8534c4b.js" crossorigin="anonymous"></script>
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

        .contact {
            position: relative;
            min-height: 100vh;
            padding: 50px 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-image: url(bg.jpeg); /* Background image */
            background-size: cover;
        }

        .contact .content {
            max-width: 800px;
            text-align: center;
        }

        .contact .content h2 {
            font-size: 36px;
            font-weight: 500;
            color: black;
        }

        .contact .content p {
            font-size: 18px;
            font-weight: 300;
            color: black;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        .container .contactInfo {
            width: 50%;
            display: flex;
            flex-direction: column;
        }

        .container .contactInfo .box {
            position: relative;
            padding: 20px 0;
            display: flex;
            align-items: center;
        }

        .container .contactInfo .box .icon {
            min-width: 60px;
            height: 60px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 22px;
            color: #333;
        }

        .container .contactInfo .box .text {
            display: flex;
            margin-left: 20px;
            flex-direction: column;
        }

        .container .contactInfo .box .text h3 {
            font-weight: 500;
            color: #333;
            font-size: 18px;
        }

        .contactForm {
            width: 40%;
            padding: 40px;
            background: #FFF;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contactForm h2 {
            font-size: 30px;
            color: #333;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .contactForm .inputBox {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .contactForm .inputBox input,
        .contactForm .inputBox textarea {
            width: 100%;
            padding: 5px 0;
            font-size: 16px;
            margin: 10px 0;
            border: none;
            border-bottom: 2px solid #333;
            outline: none;
            resize: none;
        }

        .contactForm .inputBox span {
            position: absolute;
            left: 0;
            top: 5px;
            font-size: 16px;
            color: #666;
            transition: 0.5s;
            pointer-events: none;
        }

        .contactForm .inputBox input:focus + span,
        .contactForm .inputBox input:valid + span,
        .contactForm .inputBox textarea:focus + span,
        .contactForm .inputBox textarea:valid + span {
            color: #e91263;
            font-size: 12px;
            transform: translateY(-20px);
        }

        .contactForm .inputBox input[type="submit"] {
            width: 100%;
            background: #00bcd4;
            color: #FFF;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 18px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .contactForm .inputBox input[type="submit"]:hover {
            background: #019da8;
        }

        /* Media Queries for Responsiveness */
        @media only screen and (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .container .contactInfo,
            .contactForm {
                width: 80%;
            }

            .contact .content h2 {
                font-size: 28px;
            }

            .contact .content p {
                font-size: 16px;
            }

            .contactForm h2 {
                font-size: 24px;
            }

            .contactForm .inputBox input,
            .contactForm .inputBox textarea {
                font-size: 14px;
            }

            .container .contactInfo .box {
                margin-bottom: 20px;
            }
        }

        @media only screen and (max-width: 480px) {
            .contact .content h2 {
                font-size: 24px;
            }

            .contact .content p {
                font-size: 14px;
            }

            .contactForm h2 {
                font-size: 22px;
            }

            .contactForm .inputBox input,
            .contactForm .inputBox textarea {
                font-size: 14px;
            }

            .contactForm .inputBox input[type="submit"] {
                font-size: 16px;
            }

            .container .contactInfo {
                width: 100%;
            }

            .contactForm {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <section class="contact">
        <div class="content">
            <h2>Contact Us</h2>
            <p>If you have any questions, feel free to reach out to us!</p>
        </div>
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Address</h3>
                        <p>123 Main Street,<br>City, Country</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Email</h3>
                        <p>info@example.com</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Phone</h3>
                        <p>+123 456 7890</p>
                    </div>
                </div>
            </div>

            <div class="contactForm">
                <form action="https://api.web3forms.com/submit" method="post">
                    <input type="hidden" name="access_key" value="d82c9256-27b0-4ad7-b369-1598033bf698">
                    <h2>Send Message</h2>
                    <div class="inputBox">
                        <input type="text" name="full_name" required="required">
                        <span>Full Name</span>
                    </div>

                    <div class="inputBox">
                        <input type="email" name="email" required="required">
                        <span>Email</span>
                    </div>

                    <div class="inputBox">
                        <textarea name="message" required="required"></textarea>
                        <span>Type your message...</span>
                    </div>

                    <div class="inputBox">
                        <input type="submit" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php echo $foot; // Display the footer  ?>
</body>
</html>
