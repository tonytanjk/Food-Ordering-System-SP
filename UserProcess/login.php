<?php
include "../Scripts/common.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Prepare SQL query
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $inputUsername);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($inputPassword, $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Store user role in session

        // Redirect based on user role
        if ($user['role'] === 'customer') {
            header("Location: ../Home.php");
        } elseif ($user['role'] === 'vendor') {
            header("Location: ../VendorDashboard.php");
        }
        exit;
    } else {
        // Invalid credentials
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background: linear-gradient(
                rgba(0, 0, 0, 0.5),
                rgba(0, 0, 0, 0.5)
            ), 
            url('../assets/bg.jpg') no-repeat center center/cover;
            color: #fff;
        }

        h1.title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
        }

        .login-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .login-container input {
        width: calc(100% - 40px); /* Adds space from both sides */
        padding: 12px;
        margin: 0 auto 20px auto; /* Center with auto margin */
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        display: block;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .login-container .forgot-password {
            margin-top: 10px;
        }

        .login-container .forgot-password a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-container .forgot-password a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h1 class="title">Food Ordering System @ SP</h1>
    <div class="login-container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <div class="forgot-password">
                <a href="Forget.php">Forgot your password?</a>
            </div>
        </form>
    </div>
</body>
</html>
