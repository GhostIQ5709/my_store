<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];

    // Update order status
    $stmt = $pdo->prepare('UPDATE orders SET order_status = ? WHERE order_id = ?');
    if ($stmt->execute([$newStatus, $orderId])) {
        $_SESSION['message'] = "Order status updated successfully.";
    } else {
        $_SESSION['message'] = "Failed to update order status.";
    }
}

// Redirect back to the admin orders page
header('Location: index.php');
exit();
