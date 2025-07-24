<?php
require '../includes/auth.php';
require '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $pdo->prepare("
    SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.stock, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll();

if (empty($items)) {
    echo "<div class='alert alert-info'>Your cart is empty.</div>";
    include '../includes/footer.php';
    exit;
}

// Calculate total
$total = 0;
foreach ($items as $item) {
    if ($item['quantity'] > $item['stock']) {
        echo "<div class='alert alert-danger'>Not enough stock for {$item['name']}.</div>";
        include '../includes/footer.php';
        exit;
    }
    $total += $item['price'] * $item['quantity'];
}

// Process order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Create order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    $order_id = $pdo->lastInsertId();

    // 2. Insert order items & update stock
    $insertItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $updateStock = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $deleteCart = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");

    foreach ($items as $item) {
        $insertItem->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
        $updateStock->execute([$item['quantity'], $item['product_id']]);
    }

    // 3. Clear cart
    $deleteCart->execute([$user_id]);

    // 4. Redirect
    header("Location: order_history.php?success=1");
    exit;
}
?>

<h2 class="mb-4">Checkout</h2>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Order Summary</h4>
        <ul class="list-group list-group-flush mb-3">
            <?php foreach ($items as $item): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <div><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></div>
                    <div>$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="d-flex justify-content-between">
            <strong>Total:</strong>
            <strong class="text-primary">$<?= number_format($total, 2) ?></strong>
        </div>

        <form method="POST" class="mt-4">
            <button type="submit" class="btn btn-success w-100">Place Order</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>