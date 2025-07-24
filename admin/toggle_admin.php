<?php
require 'auth_admin.php';
require '../includes/db.php';

if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    header("Location: manage_users.php");
    exit;
}

$user_id = (int) $_POST['user_id'];

// Prevent self-demotion
if ($user_id === $_SESSION['user_id']) {
    header("Location: manage_users.php");
    exit;
}

$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($user) {
    $newRole = $user['is_admin'] ? 0 : 1;
    $update = $pdo->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
    $update->execute([$newRole, $user_id]);
}

header("Location: manage_users.php");
exit;
