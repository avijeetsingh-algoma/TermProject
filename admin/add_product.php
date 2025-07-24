<?php
require 'auth_admin.php';
require '../includes/db.php';
include '../includes/header.php';

$name = $desc = $price = $image = $category = "";
$stock = 0;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $desc = trim($_POST["description"]);
    $price = floatval($_POST["price"]);
    $image = trim($_POST["image_url"]); // assume you input filename
    $category = trim($_POST["category"]);
    $stock = intval($_POST["stock"]);

    if (!$name || !$desc || !$price || !$image || !$category || $stock < 0) {
        $errors[] = "All fields are required and must be valid.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, category, stock) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $price, $image, $category, $stock]);
        header("Location: manage_products.php");
        exit;
    }
}
?>

<h2 class="mb-4">Add New Product</h2>

<?php if ($errors): ?>
    <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
<?php endif; ?>

<form method="POST" novalidate>
    <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" required></textarea></div>
    <div class="mb-3"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Image File Name</label><input type="text" name="image_url" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Category</label><input type="text" name="category" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Stock</label><input type="number" name="stock" class="form-control" required></div>
    <button type="submit" class="btn btn-success">Add Product</button>
</form>

<?php include '../includes/footer.php'; ?>