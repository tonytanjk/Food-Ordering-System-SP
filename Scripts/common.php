<?php
// Include database connection
session_start();

// Database connection details
$host = 'localhost';  // Change to your database host
$dbname = 'projectcsad';  // Change to your database name
$username = 'root';  // Change to your database username
$password = '';  // Change to your database password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /ProjectCSAD/Client/login.php");
    exit();
}

// Get user ID from session
$userId = $_SESSION['user_id'];
// Fetch food court ID and food items for a specific court or stall (For FC1 - FC6)
$food_court_id = isset($_GET['food_court_id']) ? intval($_GET['food_court_id']) : 0;
$stall_id = isset($_GET['stall_id']) ? intval($_GET['stall_id']) : null;

// Fetch user account balance
function getAccountBalance($userId, $conn) {
    $query = "SELECT account_balance FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['account_balance'];
    }
    return 0.00; // Default balance if not found
}

// Fetch food stalls for a given food court
function getFoodStalls($foodCourtId, $conn) {
    $query = "SELECT * FROM food_stalls WHERE food_court_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $foodCourtId);
    $stmt->execute();
    return $stmt->get_result();
}

// Fetch food items for a given stall
function getFoodItems($stallId, $conn) {
    $query = "SELECT * FROM food_items WHERE stall_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $stallId);
    $stmt->execute();
    return $stmt->get_result();
}

// Example function to fetch total sales for a specific food court and stall
function getTotalSales($conn, $food_court_id, $stall_id) {
    $query = "SELECT SUM(o.total_amount) AS total_sales
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN food_items fi ON oi.food_item_id = fi.food_item_id
              WHERE fi.stall_id = ? AND fi.food_court_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $food_court_id, $stall_id); // Match the order of parameters
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_sales'] ?? 0; // Return total sales or 0 if no sales exist
}

// Example function to fetch total orders for a specific food court and stall
function getTotalOrders($conn, $food_court_id, $stall_id) {
    $query = "SELECT COUNT(o.order_id) AS total_orders
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN food_items fi ON oi.food_item_id = fi.food_item_id
              WHERE fi.stall_id = ? AND fi.food_court_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $food_court_id, $stall_id); // Match the order of parameters
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_orders'] ?? 0;
}

// Example function to calculate the average order value for a specific food court and stall
function getAverageOrderValue($conn, $food_court_id, $stall_id) {
    $query = "SELECT AVG(o.total_amount) AS average_order_value
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN food_items fi ON oi.food_item_id = fi.food_item_id
              WHERE fi.stall_id = ? AND fi.food_court_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $food_court_id, $stall_id); // Match the order of parameters
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['average_order_value'] ?? 0; // Return 0 if no average found
}

// Example function to fetch sales trends for the last 7 days for a specific food court and stall
function getSalesTrends($days, $conn, $food_court_id, $stall_id) {
    $query = "SELECT DATE(o.order_date) AS date, SUM(o.total_amount) AS daily_sales
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN food_items fi ON oi.food_item_id = fi.food_item_id
              WHERE fi.stall_id = ? AND fi.food_court_id = ? AND o.order_date >= CURDATE() - INTERVAL ? DAY
              GROUP BY DATE(o.order_date)
              ORDER BY DATE(o.order_date) DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $food_court_id, $stall_id, $days); // Match the order of parameters
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC); // Return the trend data
}

function getTotalRefunds($conn, $stall_id, $food_court_id) {
    $query = "
        SELECT SUM(o.total_amount) AS total_refunds
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN food_items fi ON oi.food_item_id = fi.food_item_id
        WHERE o.status = 'Cancelled'
        AND fi.stall_id = ? 
        AND fi.food_court_id = ?
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $stall_id, $food_court_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc()['total_refunds'] ?? 0.00;
}

// Fetch weekly revenue
function getWeeklyRevenue($conn) {
    $query = "
        SELECT DATE(order_date) AS order_date, SUM(total_amount) AS daily_sales 
        FROM orders 
        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(order_date) 
        ORDER BY order_date ASC";
    $result = $conn->query($query);
    $weeklyRevenue = 0.00;
    while ($row = $result->fetch_assoc()) {
        $weeklyRevenue += $row['daily_sales'];
    }
    return $weeklyRevenue;
}

function getTopSellingItems($conn, $foodCourtId, $stallId, $limit = 10) {
    $query = "
        SELECT fi.food_name, SUM(oi.quantity) AS total_quantity, SUM(oi.price * oi.quantity) AS total_revenue
        FROM order_items oi
        JOIN food_items fi ON oi.food_item_id = fi.food_item_id
        JOIN food_stalls fs ON fi.stall_id = fs.stall_id
        WHERE fs.food_court_id = ? AND fs.stall_id = ?
        GROUP BY fi.food_name
        ORDER BY total_quantity DESC
        LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $foodCourtId, $stallId, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

$stall_result = $food_court_id ? getFoodStalls($food_court_id, $conn) : null;
$food_result = $stall_id ? getFoodItems($stall_id, $conn) : null;

// Example usage for sales metrics (For Vendor)
$accountBalance = getAccountBalance($userId, $conn);
$totalSales = getTotalSales($conn,$food_court_id, $stall_id);
$totalOrders = getTotalOrders($conn,$food_court_id, $stall_id);
$averageOrderValue = getAverageOrderValue($conn,$food_court_id, $stall_id);
$getTotalRefunds = getTotalRefunds($conn,$food_court_id, $stall_id);
$salesTrends = getSalesTrends(7, $conn,$food_court_id, $stall_id); // Last 7 days
$weeklyRevenue = getWeeklyRevenue($conn,$food_court_id, $stall_id);


?>
