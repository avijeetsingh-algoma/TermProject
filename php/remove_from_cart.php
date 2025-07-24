<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['cart_id'])) {
    header("Location: /pages/cart.php");
    exit;
}

$cart_id = (int) $_POST['cart_id'];

$stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$stmt->execute([$cart_id, $_SESSION['user_id']]);

header("Location: /pages/cart.php");
exit;
