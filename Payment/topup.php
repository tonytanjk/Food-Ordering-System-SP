<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/common.php';

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topup_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    if ($topup_amount > 0 && !empty($payment_method)) {
        // Insert top-up record into `account_topups` table
        $stmt = $pdo->prepare("INSERT INTO account_topups (user_id, topup_amount, payment_method, status) VALUES (:user_id, :topup_amount, :payment_method, 'completed')");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':topup_amount', $topup_amount);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->execute();

        // Update user's account balance
        $stmt = $pdo->prepare("UPDATE users SET account_balance = account_balance + :topup_amount WHERE user_id = :user_id");
        $stmt->bindParam(':topup_amount', $topup_amount);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $success_message = "Your account has been topped up by \$$topup_amount using $payment_method!";
    } else {
        $error_message = "Please select a valid amount and payment method.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Account</title>
    <style>
        /* Same styles as before */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .topup-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .topup-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .amount-buttons button, .amount-buttons input[type="number"] {
            margin: 5px;
            padding: 10px 20px;
            font-size: 16px;
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .amount-buttons button {
            background-color: #007bff;
            color: white;
        }
        .amount-buttons button:hover {
            background-color: #0056b3;
        }
        .amount-buttons input[type="number"] {
            width: 100px;
            text-align: center;
        }
        .total-display {
            margin: 20px 0;
            font-size: 18px;
            color: #333;
        }
        select.payment-method {
            margin: 10px 0 20px 0;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button.topup-submit, a.back-home {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button.topup-submit {
            background-color: #28a745;
            color: white;
            border: none;
        }
        button.topup-submit:hover {
            background-color: #218838;
        }
        a.back-home {
            background-color: #6c757d;
            color: white;
            border: none;
        }
        a.back-home:hover {
            background-color: #5a6268;
        }
        .message {
            margin-top: 15px;
            font-size: 16px;
        }
        .message.success {
            color: #28a745;
        }
        .message.error {
            color: #dc3545;
        }
    </style>
    <script>
        let totalAmount = 0;

        function addAmount(amount) {
            totalAmount += amount;
            updateDisplay();
        }

        function subtractAmount(amount) {
            if (totalAmount - amount >= 0) {
                totalAmount -= amount;
            } else {
                alert("Amount cannot be less than $0!");
            }
            updateDisplay();
        }

        function addCustomAmount() {
            const customAmountInput = document.getElementById('customAmount');
            const customAmount = parseFloat(customAmountInput.value);
            if (!isNaN(customAmount) && customAmount > 0) {
                totalAmount = customAmount;
                updateDisplay();
                customAmountInput.value = '';
            } else {
                alert("Please enter a valid amount.");
            }
        }

        function updateDisplay() {
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
            document.getElementById('totalInput').value = totalAmount.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="topup-container">
        <h1>Top Up Your Account</h1>
        <div class="amount-buttons">
            <button onclick="addAmount(10)">+ $10</button>
            <button onclick="addAmount(20)">+ $20</button>
            <button onclick="addAmount(30)">+ $30</button>
            <button onclick="addAmount(40)">+ $40</button>
            <button onclick="addAmount(50)">+ $50</button>
            <button onclick="subtractAmount(10)">- $10</button>
            <button onclick="subtractAmount(20)">- $20</button>
            <button onclick="subtractAmount(30)">- $30</button>
            <button onclick="subtractAmount(40)">- $40</button>
            <button onclick="subtractAmount(50)">- $50</button>
        </div>
        <div class="amount-buttons">
            <input type="number" id="customAmount" placeholder="Custom Amount">
            <button onclick="addCustomAmount()">Add Custom</button>
        </div>
        <div class="total-display">
            Total Amount: $<span id="totalAmount">0.00</span>
        </div>
        <form action="" method="post">
            <input type="hidden" id="totalInput" name="total_amount" value="0.00">
            <select name="payment_method" class="payment-method" required>
                <option value="">Select Payment Method</option>
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
            <button type="submit" class="topup-submit">Top Up</button>
        </form>
        <a href="/ProjectCSAD/home.php" class="back-home">Back to Home</a>
        <?php if (isset($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
