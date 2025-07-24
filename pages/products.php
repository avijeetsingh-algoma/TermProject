<?php
require '../includes/db.php';
include '../includes/header.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$sql = "SELECT * FROM products WHERE 1";
$params = [];

if ($search) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$search%";
}

if ($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$sql .= " ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<h2 class="mb-4">Browse Our Products</h2>

<!-- Alerts -->
<?php if (isset($_GET['added'])): ?>
    <div class="alert alert-success">Item added to cart.</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] === 'outofstock'): ?>
    <div class="alert alert-danger">Not enough stock available.</div>
<?php endif; ?>

<!-- Search and Filter -->
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-4">
        <select name="category" class="form-select">
            <option value="">All Categories</option>
            <option value="Laptop" <?= $category == 'Laptop' ? 'selected' : '' ?>>Laptops</option>
            <option value="Desktop" <?= $category == 'Desktop' ? 'selected' : '' ?>>Desktops</option>
            <option value="Accessory" <?= $category == 'Accessory' ? 'selected' : '' ?>>Accessories</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<!-- Product Grid -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php foreach ($products as $product): ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="/assets/images/<?= htmlspecialchars($product['image_url']) ?>"
                    class="card-img-top"
                    alt="<?= htmlspecialchars($product['name']) ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                    <p class="fw-bold text-primary">$<?= number_format($product['price'], 2) ?></p>

                    <?php if ($product['stock'] > 0): ?>
                        <form method="POST" action="/php/add_to_cart.php" class="mt-auto">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="mb-2">
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>"
                                    class="form-control" style="max-width: 100px;">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning mt-auto">Out of Stock</div>
                    <?php endif; ?>

                    <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-outline-primary w-100 mt-2">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>