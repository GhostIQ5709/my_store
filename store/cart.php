<?php // Ensure session is started
include '../includes/db.php';
include '../includes/header.php';

// Fetch products in the cart
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE product_id IN ($ids)");
    $cartItems = $stmt->fetchAll();
}
?>

<main>
    <h1>Shopping Cart</h1>
    <?php if (!empty($cartItems)): ?>
        <ul class="list-group mb-3">
            <?php foreach ($cartItems as $item): ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">
                            <?php echo htmlspecialchars($item['product_name']); ?>
                        </h6>
                        <small class="text-muted">Price per unit: ₵
                            <?php echo number_format($item['product_price'], 2); ?>
                        </small>
                    </div>
                    <span class="text-muted">Quantity:
                        <?php echo $_SESSION['cart'][$item['product_id']]; ?>
                    </span>
                    <span class="text-success">Subtotal: ₵
                        <?php echo number_format($item['product_price'] * $_SESSION['cart'][$item['product_id']], 2); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        <!-- Clear Cart Button -->
        <form method="post" action="clear_cart.php" style="display: inline;">
            <button type="submit" class="btn btn-danger">Clear Cart</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>

