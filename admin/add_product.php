<!-- add_product.php -->
<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quantity'];
    $productCost = $_POST['product_cost'];
    $productPrice = $_POST['product_price'];
    $imagePath = '';

    // Handle file upload
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

    // Insert product into database
    $stmt = $pdo->prepare('INSERT INTO products (product_name, product_quantity
    , product_cost, product_price, product_picture) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$productName, $productQuantity, $productCost, $productPrice, $imagePath]);

    header('Location: index.php');
    exit;
}
