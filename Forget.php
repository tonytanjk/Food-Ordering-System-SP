<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('bg.jpg') no-repeat center center/cover;
            color: #fff;
        }

        .container {
            display: flex;
            width: 800px;
            height: 400px;
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative; /* Allows positioning of foreground images */
        }

        .image-section {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f9f9f9;
        }

        .image-section img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .form-section {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-section label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            text-align: center;
        }

        .form-section input {
            width: 80%;
            padding: 10px;
            margin: 0 auto 15px auto;
            display: block;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-section button {
            width: 80%;
            padding: 10px;
            margin: 0 auto;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            display: block;
        }

        .form-section button:hover {
            background-color: #0056b3;
        }

        .form-section .back-to-login {
            text-align: center;
            margin-top: 10px;
        }

        .form-section .back-to-login a {
            color: #007bff;
            text-decoration: none;
        }

        .form-section .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Foreground image section -->
        <div class="image-section">
            <img src="forget_bg.png" alt="Forgot Password Image">
        </div>
        <!-- Form section -->
        <div class="form-section">
            <h1>Forgot Password</h1>
            <form action="#" method="post">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>

                <button type="submit">Send Reset Link</button>

                <div class="back-to-login">
                    <a href="login.php">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
