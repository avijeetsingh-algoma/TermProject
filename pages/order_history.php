<?php
require '../includes/auth.php';
require '../includes/db.php';
include '../includes/header.php';


$user_id = $_SESSION['user_id'];

// Get orders
$stmt = $pdo->prepare("
    SELECT o.id, o.order_date, o.total_price, COUNT(oi.id) AS items
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    WHERE o.user_id = ?
    GROUP BY o.id
    ORDER BY o.order_date DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<h2 class="mb-4">Order History</h2>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Your order has been placed successfully.</div>
<?php endif; ?>

<?php if (empty($orders)): ?>
    <div class="alert alert-info">You haven't placed any orders yet.</div>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Items</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><?= date("F j, Y, g:i a", strtotime($order['order_date'])) ?></td>
                    <td><?= $order['items'] ?></td>
                    <td>$<?= number_format($order['total_price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>