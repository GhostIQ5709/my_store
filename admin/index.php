<?php
include '../includes/db.php';
include '../includes/header.php';

// Fetch products
$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll();

// Fetch all orders
$orders_stmt = $pdo->query('SELECT * FROM orders ORDER BY order_date DESC');
$orders = $orders_stmt->fetchAll();
?>

<main>
    <section>
        <h1>Admin Panel</h1>
        <!-- Trigger Add Product Modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add Product
        </button>

        <!-- Product List Table -->
        <table class="table table-striped">
            <caption>Products</caption>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Cost</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product):
                    $stockClass = $product['product_quantity'] < 10 ?
                        'table-danger' : ($product['product_quantity'] < 50 ? 'table-warning' : '');
                    ?>
                    <tr class="<?php echo $stockClass; ?>">
                        <td>
                            <?php echo htmlspecialchars($product['product_name']); ?>
                        </td>
                        <td>
                            <?php echo $product['product_quantity']; ?>
                        </td>
                        <td>₵
                            <?php echo number_format($product['product_cost'], 2); ?>
                        </td>
                        <td>₵
                            <?php echo number_format($product['product_price'], 2); ?>
                        </td>
                        <td>
                            <!-- Trigger Edit Product Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editProductModal"
                                data-bs-product-id="<?php echo $product['product_id']; ?>"
                                data-bs-product-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                                data-bs-product-quantity="<?php echo $product['product_quantity']; ?>"
                                data-bs-product-cost="<?php echo $product['product_cost']; ?>"
                                data-bs-product-price="<?php echo $product['product_price']; ?>"
                                data-bs-product-image="<?php echo htmlspecialchars($product['product_picture']); ?>">
                                Edit
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="add_product.php" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="product_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="product_quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="product_quantity" name="product_quantity"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="product_cost" class="form-label">Cost</label>
                                <input type="text" class="form-control" id="product_cost" name="product_cost" required>
                            </div>
                            <div class="mb-3">
                                <label for="product_price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="product_price" name="product_price"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="product_picture" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="product_picture" name="product_picture"
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="edit_product.php" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" id="edit_product_id" name="product_id">
                            <div class="mb-3">
                                <label for="edit_product_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_product_name" name="product_name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_product_quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="edit_product_quantity"
                                    name="product_quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_product_cost" class="form-label">Cost</label>
                                <input type="text" class="form-control" id="edit_product_cost" name="product_cost"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_product_price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="edit_product_price" name="product_price"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_product_picture" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="edit_product_picture" name="product_picture"
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h1>Manage Orders</h1>
        <table class="table">
            <caption>Orders Table</caption>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($order['order_id']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($order['billing_name']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($order['billing_email']); ?>
                        </td>
                        <td>₵
                            <?php echo number_format($order['order_total'], 2); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($order['order_status']); ?>
                        </td>
                        <td>
                            <!-- Form to update order status -->
                            <form method="post" action="update_order_status.php" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="new_status" class="form-select" style="width: auto; display: inline-block;">
                                    <option value="Pending" <?php if ($order['order_status'] == 'Pending')
                                        echo 'selected'; ?>>Pending</option>
                                    <option value="Processing" <?php if ($order['order_status'] == 'Processing')
                                        echo 'selected'; ?>>Processing</option>
                                    <option value="Shipped" <?php if ($order['order_status'] == 'Shipped')
                                        echo 'selected'; ?>>Shipped</option>
                                    <option value="Completed" <?php if ($order['order_status'] == 'Completed')
                                        echo 'selected'; ?>>Completed</option>
                                    <option value="Cancelled" <?php if ($order['order_status'] == 'Cancelled')
                                        echo 'selected'; ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editProductModal = document.getElementById('editProductModal');
        editProductModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-bs-product-id');
            const productName = button.getAttribute('data-bs-product-name');
            const productQuantity = button.getAttribute('data-bs-product-quantity');
            const productCost = button.getAttribute('data-bs-product-cost');
            const productPrice = button.getAttribute('data-bs-product-price');
            const productImage = button.getAttribute('data-bs-product-image');

            editProductModal.querySelector('#edit_product_id').value = productId;
            editProductModal.querySelector('#edit_product_name').value = productName;
            editProductModal.querySelector('#edit_product_quantity').value = productQuantity;
            editProductModal.querySelector('#edit_product_cost').value = productCost;
            editProductModal.querySelector('#edit_product_price').value = productPrice;
            // You might want to handle the product image display differently
        });
    });
</script>

<?php include '../includes/footer.php'; ?>

