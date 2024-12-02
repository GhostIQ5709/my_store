<?php
include '../includes/db.php';
include '../includes/header.php';

// Fetch products in the cart
$cartItems = [];
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE product_id IN ($ids)");
    $cartItems = $stmt->fetchAll();
}
?>

<main>
    <h1>Checkout</h1>
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
                        <?php echo number_format($item['product_price'] *
                            $_SESSION['cart'][$item['product_id']], 2); ?>
                    </span>
                </li>
                <?php $totalPrice += $item['product_price'] * $_SESSION['cart'][$item['product_id']]; ?>
            <?php endforeach; ?>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total (GHS)</span>
                <strong>₵
                    <?php echo number_format($totalPrice, 2); ?>
                </strong>
            </li>
        </ul>
        <!-- Button to trigger Billing Info Modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#billingModal">Complete
            Purchase</button>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</main>

<!-- Billing Info Modal -->
<div class="modal fade" id="billingModal" tabindex="-1" aria-labelledby="billingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="billingModalLabel">Billing Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="complete_purchase.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="billing_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="billing_name" name="billing_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="billing_address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="billing_address" name="billing_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="billing_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="billing_email" name="billing_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="billing_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="billing_phone" name="billing_phone" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

