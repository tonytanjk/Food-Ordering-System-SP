<script src="/ProjectCSAD/Scripts/FC1_6_JS.js"></script>

<?php
$account = <<<HTML
<div class="side-section">
    <!-- Balance -->
    <div class="balance">
        Account Balance: \$<span id="balance">{$accountBalance}</span>
    </div>
    <button id="toggle-btn" class="toggle-btn" onclick="toggleBalance()">Hide Balance</button>
    
    <!-- Profile Dropdown -->
    <div class="profile-dropdown">
        <button class="profile-btn">👤 Profile</button>
        <div class="dropdown-content">
            <a href="/ProjectCSAD/Client/profile.php">Main Profile</a>
            <a href="/ProjectCSAD/Payment/Topup.php">Top up</a>
            <a href="/ProjectCSAD/Client/orders.php">Orders</a>
            <a href="/ProjectCSAD/Client/logout.php">Logout</a>
        </div>
    </div>
</div>
HTML;
        
// Dynamic content for the main header
$main_head = <<<HTML
<!--//Header for Most pages-->
<header>
    <h1 style="color:white">Food Ordering System @ SP</h1>
    <nav>
        <a href="/ProjectCSAD/Home.php">Home</a>
        <a href="/ProjectCSAD/Most_Order.php">Most Ordered</a>
        <a href="/ProjectCSAD/Client/About.php">About Us</a>
        <a href="/ProjectCSAD/Client/Contact.php">Contact</a>
    </nav>
</header>
HTML;
?>
