<?php
require 'auth_admin.php';
require '../includes/db.php';
include '../includes/header.php';

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<h2 class="mb-4">Manage Products</h2>
<a href="add_product.php" class="btn btn-success mb-3">Add New Product</a>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= htmlspecialchars($p['category']) ?></td>
                <td>$<?= number_format($p['price'], 2) ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>