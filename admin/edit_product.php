<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quantity'];
    $productCost = $_POST['product_cost'];
    $productPrice = $_POST['product_price'];
    $imagePath = null;

    // Handle file upload if a new file is provided
    if (isset($_FILES['product_picture']) && $_FILES['product_picture']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['product_picture']['name']);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['product_picture']['tmp_name'], $uploadFile)) {
            $imagePath = '/uploads/' . basename($_FILES['product_picture']['name']);
        } else {
            echo "Failed to upload image.";
        }
    }

    // Update product in database
    if ($imagePath) {
        // Update with a new image
        $stmt = $pdo->prepare('UPDATE products SET product_name = ?, product_quantity = ?, product_cost = ?, product_price = ?, product_picture = ? WHERE product_id = ?');
        $stmt->execute([$productName, $productQuantity, $productCost, $productPrice, $imagePath, $productId]);
    } else {
        // Update without changing the image
        $stmt = $pdo->prepare('UPDATE products SET product_name = ?, product_quantity = ?, product_cost = ?, product_price = ? WHERE product_id = ?');
        $stmt->execute([$productName, $productQuantity, $productCost, $productPrice, $productId]);
    }

    // Redirect back to admin page
    header('Location: index.php');
    exit();
}
