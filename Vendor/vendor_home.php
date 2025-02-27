<?php
// Include database connection and common functions
include '../scripts/common.php';
include 'VendorCommon.php';
// Assume user_id is stored in session after login
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch stall_id and food_court_id for the logged-in user
$query = "SELECT stall_id, food_court_id FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stall_id = $user['stall_id'] ?? 0;
$food_court_id = $user['food_court_id'] ?? 0;
$stall_picture = $result->fetch_assoc()['stall_picture'] ?? ''; // Default to an empty string if not set
echo "Stall ID: " . $stall_id;
echo "Food Court ID: " . $food_court_id;
// Fetch sales metrics
$totalSales = getTotalSales($conn, $stall_id, $food_court_id);
$totalOrders = getTotalOrders($conn, $stall_id, $food_court_id);
$averageOrderValue = getAverageOrderValue($conn, $stall_id, $food_court_id);
$salesTrends = getSalesTrends(7, $conn, $stall_id, $food_court_id); // Last 7 days
$getTotalRefunds = getTotalRefunds($conn, $stall_id, $food_court_id);

// Fetch stall items
$query = "SELECT * FROM food_items WHERE stall_id = ? AND food_court_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $stall_id, $food_court_id);
$stmt->execute();
$stallItems = $stmt->get_result();

// Fetch stall information (name and image)
$query = "SELECT stall_name, stall_picture FROM food_stalls WHERE stall_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $stall_id);
$stmt->execute();
$stall_info = $stmt->get_result()->fetch_assoc();

$stall_name = $stall_info['stall_name'] ?? '';
$stall_image = $stall_info['stall_picture'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Home</title>
    <script>
        function deleteItem() {
            var form = document.getElementById('itemForm');
            form.action = 'delete_item.php';
            form.submit();
        }
    </script>
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
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .widget {
        display: inline-block;
        width: 30%;
        padding: 20px;
        margin: 10px;
        background: #f4f4f4;
        border-radius: 8px;
        text-align: center;
        margin-left: 100px
    }

    .widget h3 {
        margin: 0 0 10px;
        color: #444;
    }

    .widget p {
        font-size: 1.2em;
        margin: 0;
    }

    .stall-items {
        margin-top: 30px;
    }

    .stall-items table {
        width: 100%;
        border-collapse: collapse;
    }

    .stall-items th, .stall-items td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .stall-items th {
        background-color: #f4f4f4;
    }

    .stall-items tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Updated CSS for smooth transition of add-form and edit-form */
    .edit-form, .add-form {
        margin-top: 20px;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        padding: 0;
        transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out, padding 0.3s ease-in-out;
    }

    .edit-form.show, .add-form.show {
        max-height: 500px; /* Adjust as needed */
        opacity: 1;
        padding: 10px; /* Restores padding */
    }

    .edit-form input, .edit-form textarea, .add-form input, .add-form textarea {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .edit-form button, .add-form button {
        padding: 10px 20px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .edit-form button:hover, .add-form button:hover {
        background-color: #555;
    }

    footer {
        background-color: #333;
        color: white;
        padding: 20px;
        text-align: center;
    }

    .stall-config h2 {
        margin-bottom: 20px;
    }

    .stall-config input[type="text"],
    .stall-config textarea {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .stall-config input[type="file"] {
        margin: 5px 0;
    }

    .stall-config img {
        max-width: 200px;
        display: block;
        margin-top: 10px;
    }

    .stall-config button {
        padding: 10px 20px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .stall-config button:hover {
        background-color: #555;
    }

    #stallConfig {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out, padding 0.3s ease-in-out;
    }

    #stallConfig.show {
        max-height: 500px; /* Adjust as needed */
    }

    footer a {
        color: white;
        margin: 0 10px;
        text-decoration: none;
    }

    </style>
    <script>
    function toggleSection(sectionId) {
        let sections = ['edit-form', 'add-form', 'stallConfig'];

        sections.forEach(id => {
            let section = document.getElementById(id);

            if (id === sectionId) {
                // Toggle the selected section
                if (sectionId === 'stallConfig') {
                    section.classList.toggle("show");
                } else {
                    section.classList.toggle("show");
                }
            } else {
                    section.classList.remove("show");
            }
        });
    }

    function showEditForm(itemId, foodName, description, price, imageUrl) {
        toggleSection('edit-form');

        document.getElementById('item_id').value = itemId;
        document.getElementById('food_name').value = foodName;
        document.getElementById('description').value = description;
        document.getElementById('price').value = price;

        if (imageUrl) {
            document.getElementById('imagePreview').src = imageUrl;
            document.getElementById('imagePreview').style.display = 'block';
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
    }

    function showAddForm() {
        toggleSection('add-form');
    }

    function toggleConfig() {
        toggleSection('stallConfig');
    }

    function previewImage(event, formType) {
        const reader = new FileReader();
        reader.onload = function() {
            let preview;

            // Depending on the form type, select the corresponding image preview element
            if (formType === 'edit') {
                preview = document.getElementById('editItemImagePreview');
            } else if (formType === 'add') {
                preview = document.getElementById('addItemImagePreview');
            } else if (formType === 'stall') {
                preview = document.getElementById('stallImagePreview');
            }

            // Set the preview image
            preview.src = reader.result;
            preview.style.display = 'block'; // Display the image once selected
        };

        reader.readAsDataURL(event.target.files[0]);
    }

    // Close all forms when clicking outside (but not on a button)
    document.addEventListener("click", function(event) {
        let sections = ['edit-form', 'add-form', 'stallConfig'];
        let clickedInsideForm = sections.some(id => document.getElementById(id)?.contains(event.target));
        let clickedButton = event.target.matches("button");

        if (!clickedInsideForm && !clickedButton) {
            sections.forEach(id => {
                let section = document.getElementById(id);
                if (section) {
                    if (id === 'stallConfig') {
                        section.classList.remove("show");
                    } else {
                        section.classList.remove("show");
                    }
                }
            });
        }
    });
</script>
</head>
<body>
    <header>
        <h1>Vendor Home</h1>
        <?php echo $navi; // Display the navigation bar ?>
    </header>

    <div class="container">
        <div class="widget">
            <h3>Total Sales</h3>
            <p>$<?= number_format($totalSales, 2) ?></p>
        </div>
        <div class="widget">
            <h3>Total Orders</h3>
            <p><?= $totalOrders ?></p>
        </div>
        <div class="widget">
            <h3>Average Order Value</h3>
            <p>$<?= number_format($averageOrderValue, 2) ?></p>
        </div>
        <div class="widget">
            <h3>Total Refunds</h3>
            <p style="color: red">$<?= number_format($getTotalRefunds, 2) ?></p>
        </div>
        
        <h2>Configure Stall</h2>
        <button onclick="toggleSection('stallConfig')">Configure</button>
        <div id="stallConfig" class="stall-config">
            <form action="update_stall.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="stall_id" value="<?= $stall_id ?>">

                <label for="stall_name">Stall Name:</label>
                <input type="text" id="stall_name" name="stall_name" value="<?= htmlspecialchars($stall_name) ?>" required>

                <label for="stall_picture">Stall Picture:</label>
                <input type="file" id="stall_picture" name="stall_picture" accept="image/*" onchange="previewImage(event, 'stall')">

                <!-- Image Preview -->
                <img id="imagePreview" src="<?= $stall_picture ? '../images/' . $stall_picture : '' ?>" 
                     style="max-width: 200px; max-height: 100px; display: <?= $stall_picture ? 'block' : 'none' ?>; margin-top: 10px;">
                <button type="submit">Update Stall</button>
            </form>
        </div>
        <div class="stall-items">
            <h2>Stall Items</h2>
            <button onclick="toggleSection('add-form')">Add New Item</button>
        <div id="add-form" class="add-form">
            <h2>Add New Item</h2>
            <form action="add_item.php" method="post">
                <input type="hidden" name="stall_id" value="<?= $stall_id ?>">
                <label for="new_food_name">Food Name:</label>
                <input type="text" id="new_food_name" name="food_name" required>
                <label for="new_description">Description:</label>
                <textarea id="new_description" name="description"></textarea>
                <label for="new_price">Price:</label>
                <input type="number" id="new_price" name="price" step="0.01" required>
                <label for="image">Upload New Image:</label>
                <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event, 'add')">
                <!-- Image Preview for Add Item -->
                <img id="addItemImagePreview" src="" alt="Food Image Preview" style="max-width: 200px; max-height: 100px;display: none; margin-top: 10px;">
                <button type="submit">Add Item</button>
            </form>
            <br>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Food Item</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $stallItems->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['food_name']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <button onclick="showEditForm('<?= $item['food_item_id'] ?>', '<?= htmlspecialchars($item['food_name']) ?>', '<?= htmlspecialchars($item['description']) ?>', '<?= $item['price'] ?>', '<?= $item['image_path'] ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="edit-form" class="edit-form">
        <h2>Edit Item</h2>
        <form id="itemForm" action="update_item.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="stall_id" name="stall_id" value="<?= $stall_id ?>">
            <input type="hidden" id="item_id" name="item_id">

            <label for="food_name">Food Name:</label>
            <input type="text" id="food_name" name="food_name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <!-- Image Upload -->
            <label for="image">Upload New Image:</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event, 'edit')">


            <!-- Image Preview for Edit Item -->
            <img id="editItemImagePreview" src="" alt="Food Image Preview" style="max-width: 200px;  max-height: 100px; display: none; margin-top: 10px;">


            <button type="submit">Update Item</button>
            <button type="submit" onclick="deleteItem()">Delete item</button>
        </form>
    </div>
    </div>

<?php echo $foot; // Display the footer  ?>
</body>
</html>