<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get billing information
    $billingName = $_POST['billing_name'];
    $billingAddress = $_POST['billing_address'];
    $billingEmail = $_POST['billing_email'];
    $billingPhone = $_POST['billing_phone'];

    // Check if cart is not empty
    if (!empty($_SESSION['cart'])) {
        $totalPrice = 0;
        $orderItems = [];

        // Prepare SQL to insert order
        $orderStmt = $pdo->prepare('
        INSERT INTO orders (billing_name, billing_address, billing_email, billing_phone, order_total)
         VALUES (?, ?, ?, ?, ?)');

        // Calculate total price and prepare order items
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = ?');
            $stmt->execute([$productId]);
            $product = $stmt->fetch();

            if ($product) {
                $subtotal = $product['product_price'] * $quantity;
                $totalPrice += $subtotal;

                // Reduce product quantity
                $newQuantity = $product['product_quantity'] - $quantity;
                $updateStmt = $pdo->prepare('UPDATE products SET product_quantity = ? WHERE product_id = ?');
                $updateStmt->execute([$newQuantity, $productId]);

                // Store order item details
                $orderItems[] = [$productId, $quantity, $subtotal];
            }
        }

        // Insert order
        if ($orderStmt->execute([$billingName, $billingAddress, $billingEmail, $billingPhone, $totalPrice])) {
            $orderId = $pdo->lastInsertId();

            // Insert order items
            $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, subtotal)
             VALUES (?, ?, ?, ?)');
            foreach ($orderItems as $item) {
                $itemStmt->execute([$orderId, $item[0], $item[1], $item[2]]);
            }

            // Clear the cart
            unset($_SESSION['cart']);

            // Redirect to a confirmation page
            header('Location: order_confirmation.php');
            exit();
        } else {
            echo "Failed to place order. Please try again.";
        }
    }
}
