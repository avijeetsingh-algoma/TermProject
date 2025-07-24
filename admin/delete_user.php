<?php
require 'auth_admin.php';
require '../includes/db.php';

if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    header("Location: manage_users.php");
    exit;
}

$user_id = (int) $_POST['user_id'];

// Don't let an admin delete themselves
if ($user_id === $_SESSION['user_id']) {
    header("Location: manage_users.php");
    exit;
}

// Delete user & cart (cascade manually if needed)
$pdo->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$user_id]);
$pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user_id]);

header("Location: manage_users.php");
exit;
