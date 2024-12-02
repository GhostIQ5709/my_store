<?php
include '../includes/db.php';
include '../includes/header.php';

// Fetch products
$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?php
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?php
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
    </div>
<?php endif;
?>



<main>
    <h1>Shop</h1>
    <div class="row">
        <?php foreach ($products as $product):
            $stockClass = $product['product_quantity'] < 10 ? 'border-danger text-danger' : ($product['product_quantity'] < 50 ? 'border-warning text-warning' : '');
            $stockMessage = $product['product_quantity'] < 10 ? 'Almost out of stock!' : '';
            ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm <?php echo $stockClass; ?>">
                    <img src="<?php echo htmlspecialchars("/my_store/" . $product['product_picture']); ?>"
                        class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($product['product_name']); ?>
                        </h5>
                        <p class="card-text">Price: ₵
                            <?php echo number_format(htmlspecialchars($product['product_price']), 2); ?>
                        </p>
                        <p class="card-text <?php echo $stockClass; ?>">
                            <?php echo $stockMessage; ?>
                        </p>

                        <!-- Quantity Selector -->
                        <form method="post" action="/my_store/store/add_to_cart.php">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="quantity" min="1"
                                    max="<?php echo $product['product_quantity']; ?>" value="1">
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <button class="btn btn-primary" type="submit" <?php echo $product['product_quantity'] <= 0 ? 'disabled' : ''; ?>>Add to Cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

