<?php
session_start();

// Count total items in the cart
$totalItems = 0;
if (isset($_SESSION['cart'])) {
    $totalItems = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Store</title>
    <link href="/my_store/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            transition: background-color 0.1s, color 0.1s;
        }

        .form-switch {
            display: inline-flex;
            align-items: center;
        }

        .form-switch input {
            display: none;
        }

        .form-switch .form-check-label {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
            background-color: #ccc;
            border-radius: 20px;
            margin-right: 10px;
            transition: 0.3s;
            cursor: pointer;
        }

        .form-switch .form-check-label::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background-color: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        .form-switch input:checked+.form-check-label {
            background-color: #4CAF50;
        }

        .form-switch input:checked+.form-check-label::before {
            transform: translateX(20px);
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            /* Set a consistent height */
            object-fit: cover;
            /* Ensures the image covers the space */
        }

        .card {
            height: 90%;
            margin-bottom: 20px;
            /* Ensures all cards are the same height */
        }
    </style>
</head>

<body class="bg-light text-dark">
    <div class="container">
        <header class="d-flex justify-content-between py-3">
            <h1>My Store</h1>
            <div>
                <label class="form-switch">
                    <input type="checkbox" id="theme-toggle">
                    <span class="form-check-label"> </span>
                </label>
                <a href="/my_store/store/cart.php" class="btn btn-outline-primary">
                    Cart <span class="badge bg-secondary">
                        <?php echo $totalItems; ?>
                    </span>
                </a>
            </div>
        </header>
