<?php
require 'auth_admin.php';
include '../includes/header.php';
?>

<h2 class="mb-4">Admin Dashboard</h2>

<div class="row">
    <div class="col-md-4">
        <a href="manage_products.php" class="btn btn-outline-primary w-100 mb-3">Manage Products</a>
    </div>
    <div class="col-md-4">
        <a href="view_orders.php" class="btn btn-outline-primary w-100 mb-3">View Orders</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>