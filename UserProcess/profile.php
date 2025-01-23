<?php
include '../db_connection.php'; // Include the database connection file

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../UserProcess/login.php');
    exit();
}

// Retrieve user information from the database
$user_id = $_SESSION['user_id'];

// Query to fetch user details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // User details retrieved successfully
} else {
    // If no user data is found, redirect to login
    session_destroy();
    header('Location: ../UserProcess/login.php');
    exit();
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $profile_picture = $_FILES['profile_picture'];

    // Profile picture upload logic
    $profile_picture_path = $user['profile_picture']; // Default to current profile picture
    if (!empty($profile_picture['name'])) {
        $upload_dir = '../uploads/';
        $profile_picture_path = $upload_dir . basename($profile_picture['name']);
        move_uploaded_file($profile_picture['tmp_name'], $profile_picture_path);
    }

    // Update password if provided
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password = $user['password']; // Keep the existing password
    }

    // Update user details in the database
    $update_query = "UPDATE users 
                     SET username = :username, email = :email, phone = :phone, 
                         password = :password, profile_picture = :profile_picture 
                     WHERE user_id = :user_id";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([
        'username' => $username, // Correct parameter for username
        'email' => $email,
        'phone' => $phone,
        'password' => $password,
        'profile_picture' => $profile_picture_path,
        'user_id' => $user_id
    ]);

    // Refresh page to show updated details
    header('Location: profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }

        .profile-header h2 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        .profile-header .info {
            font-size: 16px;
            color: #555;
        }

        .profile-header .info p {
            margin: 5px 0;
        }

        .section-title {
            font-size: 24px;
            margin-top: 40px;
            color: #333;
        }

        .section-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .section-content p {
            font-size: 16px;
            color: #555;
        }

        .section-content .button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .section-content .button:hover {
            background-color: #45a049;
        }

        /* Form styling */
        .edit-form {
            display: none;
            flex-direction: column;
            margin-top: 20px;
        }

        .edit-form input {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-form button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #0056b3;
        }

        .cancel-button {
            background-color: #ccc;
        }

        .cancel-button:hover {
            background-color: #aaa;
        }
    </style>
    <script>
        function toggleEditForm() {
            const form = document.getElementById('edit-form');
            const viewSection = document.getElementById('view-section');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
            viewSection.style.display = (form.style.display === 'block') ? 'none' : 'block';
        }
    </script>
</head>
<body>

<header>
    <h1>Food Ordering System @ SP</h1>
    <nav>
        <a href="../Home.php">Home</a>
        <a href="../FoodCourts/FC.php">Food Courts</a>
        <a href="../Most_Order.php">Most Ordered</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <a href="../UserProcess/login.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="profile-header">
    <img src="<?= htmlspecialchars($user['profile_picture'] ?: '../assets/default_profile_pic.jpg') ?>" alt="User Profile Picture">
    <div>
        <h2><?= htmlspecialchars($user['username']) ?></h2>
        <div class="info">
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Account Balance: $<?= htmlspecialchars($user['account_balance']) ?></p>
        </div>
    </div>
</div>

<section id="view-section">
    <h2 class="section-title">Account Details</h2>
    <div class="section-content">
        <p>Name: <?= htmlspecialchars($user['username']) ?></p>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <p>Phone: <?= htmlspecialchars($user['phone']) ?></p>
        <a href="javascript:void(0);" class="button" onclick="toggleEditForm()">Edit Account Details</a>
    </div>
</section>

<section id="edit-form" class="edit-form">
    <h2 class="section-title">Edit Account Details</h2>
    <div class="section-content">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

            <label for="password">New Password</label>
            <input type="password" name="password" id="password" placeholder="Leave blank to keep current password">

            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <button type="submit">Save Changes</button>
            <button type="button" class="cancel-button" onclick="toggleEditForm()">Cancel</button>
        </form>
    </div>
</section>

    <!-- Order History Section -->
    <section>
        <h2 class="section-title">Order History</h2>
        <div class="section-content">
            <p>View your past orders and details here.</p>
            <a href="OrderHistory.php" class="button">View Orders</a>
        </div>
    </section>
</div>

</body>
</html>
