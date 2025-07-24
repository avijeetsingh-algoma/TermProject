<?php
require 'auth_admin.php';
require '../includes/db.php';
include '../includes/header.php';

// Fetch all users
$stmt = $pdo->query("SELECT id, name, email, is_admin FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<h2 class="mb-4">Manage Users</h2>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <span class="badge bg-<?= $user['is_admin'] ? 'success' : 'secondary' ?>">
                        <?= $user['is_admin'] ? 'Yes' : 'No' ?>
                    </span>
                </td>
                <td>
                    <?php if ($_SESSION['user_id'] != $user['id']): ?>
                        <form method="POST" action="toggle_admin.php" class="d-inline">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-warning">
                                <?= $user['is_admin'] ? 'Revoke Admin' : 'Make Admin' ?>
                            </button>
                        </form>
                        <form method="POST" action="delete_user.php" class="d-inline" onsubmit="return confirm('Delete this user?');">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">You</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>