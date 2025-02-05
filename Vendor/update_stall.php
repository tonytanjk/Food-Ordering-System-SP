<?php
include '../scripts/common.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stall_id = $_POST['stall_id'];
    $stall_name = $_POST['stall_name'];
    
    // Handle stall picture upload
    if (isset($_FILES['stall_picture']) && $_FILES['stall_picture']['error'] == 0) {
        $image_name = $_FILES['stall_picture']['name'];
        $image_tmp = $_FILES['stall_picture']['tmp_name'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            $new_image_name = uniqid('stall_') . '.' . $image_extension;
            $upload_path = '../images/' . $new_image_name;
            move_uploaded_file($image_tmp, $upload_path);
        }
    } else {
        $new_image_name = null;
    }

    // Update stall details in the database
    $query = "UPDATE food_stalls SET stall_name = ?, stall_picture = ? WHERE stall_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $stall_name, $new_image_name, $stall_id);
    $stmt->execute();

    header("Location: vendor_home.php");
    exit();
}
?>
