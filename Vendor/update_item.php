<?php
include '../scripts/common.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $food_name = $_POST['food_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stall_id = $_POST['stall_id'];

    // Check if an image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/"; // Folder where images will be stored
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

     /*   // Allow only certain file formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }*/

        // Move the uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Update database with new image
            $query = "UPDATE food_items SET food_name=?, description=?, price=?, image_path=? WHERE food_item_id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssdsi", $food_name, $description, $price, $target_file, $item_id);
        } else {
            die("Error uploading file.");
        }
    } else {
        // If no new image is uploaded, update other fields without changing the image
        $query = "UPDATE food_items SET food_name=?, description=?, price=? WHERE food_item_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdi", $food_name, $description, $price, $item_id);
    }

    if ($stmt->execute()) {
        header("Location: vendor_home.php?success=Item updated!");
        exit();
    } else {
        die("Database error: " . $stmt->error);
    }
}