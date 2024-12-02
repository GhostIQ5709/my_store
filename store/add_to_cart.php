<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Fetch the current stock for the product
    $stmt = $pdo->prepare('SELECT product_quantity FROM products WHERE product_id = ?');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if ($product) {
        $availableStock = $product['product_quantity'];

        // Check if the requested quantity is available
        if ($quantity > $availableStock) {
            // Redirect back to the shop page with an error message
            $_SESSION['error_message'] = "Requested quantity exceeds available stock.";
            header('Location: index.php');
            exit();
        }

        // Add to cart if quantity is available
        if (isset($_SESSION['cart'][$productId])) {
            $newQuantity = $_SESSION['cart'][$productId] + $quantity;
            if ($newQuantity > $availableStock) {
                $_SESSION['error_message'] = "Cannot add more than available stock.";
                header('Location: index.php');
                exit();
            }
            $_SESSION['cart'][$productId] = $newQuantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    } else {
        $_SESSION['error_message'] = "Product not found.";
    }

    // Redirect back to the shop page
    $_SESSION['success_message'] = "Product added to cart successfully.";
    header('Location: index.php');
    exit();
}
