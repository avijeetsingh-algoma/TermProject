<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['cart_id'], $_POST['quantity'])) {
    header("Location: /pages/cart.php");
    exit;
}

$cart_id = (int) $_POST['cart_id'];
$quantity = max(1, (int) $_POST['quantity']);

$stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
$stmt->execute([$quantity, $cart_id, $_SESSION['user_id']]);

header("Location: /pages/cart.php");
exit;
