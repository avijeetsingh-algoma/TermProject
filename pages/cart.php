<?php
require '../includes/auth.php'; // Only logged-in users
require '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];

// Get all cart items for this user
$stmt = $pdo->prepare("
    SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.image_url, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll();

$total = 0;
?>

<h2 class="mb-4">Your Shopping Cart</h2>

<?php if (empty($items)): ?>
    <div class="alert alert-info">Your cart is empty.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th style="width: 150px;">Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td>
                            <img src="/assets/images/<?= htmlspecialchars($item['image_url']) ?>" width="60" class="me-2">
                            <?= htmlspecialchars($item['name']) ?>
                        </td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>
                            <form method="POST" action="/php/update_cart.php" class="d-flex">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control me-2" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                            </form>
                        </td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <form method="POST" action="/php/remove_from_cart.php">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-end">
        <h4>Total: <span class="text-primary">$<?= number_format($total, 2) ?></span></h4>
        <a href="checkout.php" class="btn btn-success mt-3">Proceed to Checkout</a>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>