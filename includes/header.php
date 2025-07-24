<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Computer Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/index.php">Computer Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="/pages/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pages/register.php">Register</a></li>
                    <?php else: ?>
                        <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin Panel
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                    <li><a class="dropdown-item" href="/admin/dashboard.php">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/admin/manage_products.php">Manage Products</a></li>
                                    <li><a class="dropdown-item" href="/admin/view_orders.php">View Orders</a></li>
                                    <li><a class="dropdown-item" href="/admin/manage_users.php">Manage Users</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="/pages/products.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pages/cart.php">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pages/order_history.php">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pages/logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-4">