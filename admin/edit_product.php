<?php
require 'auth_admin.php';
require '../includes/db.php';
include '../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("Invalid product.");
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) die("Product not found.");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $desc = trim($_POST["description"]);
    $price = floatval($_POST["price"]);
    $image = trim($_POST["image_url"]);
    $category = trim($_POST["category"]);
    $stock = intval($_POST["stock"]);

    if (!$name || !$desc || !$price || !$image || !$category || $stock < 0) {
        $errors[] = "All fields are required and must be valid.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, image_url=?, category=?, stock=? WHERE id=?");
        $stmt->execute([$name, $desc, $price, $image, $category, $stock, $id]);
        header("Location: manage_products.php");
        exit;
    }
}
?>

<h2 class="mb-4">Edit Product</h2>

<?php if ($errors): ?>
    <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
<?php endif; ?>

<form method="POST" novalidate>
    <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']) ?></textarea></div>
    <div class="mb-3"><label class="form-label">Price</label><input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Image File Name</label><input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Category</label><input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Stock</label><input type="number" name="stock" value="<?= $product['stock'] ?>" class="form-control" required></div>
    <button type="submit" class="btn btn-primary">Update Product</button>
</form>

<?php include '../includes/footer.php'; ?>