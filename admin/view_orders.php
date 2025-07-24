<?php
require 'auth_admin.php';
require '../includes/db.php';
include '../includes/header.php';

// Fetch all orders with user names + item counts
$stmt = $pdo->query("
    SELECT o.id, o.user_id, u.name AS customer_name, o.total_price, o.order_date,
           COUNT(oi.id) AS item_count
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_items oi ON o.id = oi.order_id
    GROUP BY o.id
    ORDER BY o.order_date DESC
");
$orders = $stmt->fetchAll();
?>

<h2 class="mb-4">All Orders</h2>

<?php if (empty($orders)): ?>
    <div class="alert alert-info">No orders have been placed yet.</div>
<?php else: ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= $order['item_count'] ?></td>
                    <td>$<?= number_format($order['total_price'], 2) ?></td>
                    <td><?= date("F j, Y, g:i a", strtotime($order['order_date'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>