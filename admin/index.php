<?php
// Connect to the database
require '../includes/db.php';

// Fetch all SCP records from the database
$stmt = $pdo->query("SELECT * FROM scps");
$scps = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | SCP Foundation</title>
    <link rel="stylesheet" href="../css/styles2.css">
</head>
<body>
    <header>
        <div class="container">
            <a class="brand" href="../index.php" aria-label="SCP Foundation home">
                <img src="../images/SCP_navbar_logo.png" alt="SCP Foundation Logo" width="225" height="70">
            </a>
            <nav id="primary-navigation">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="index.php" class="active">Admin Panel</a></li>
                    <li><a href="create.php">Add New SCP</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <article>
            <section class="scp-header">
                <div>
                    <h2>Admin Panel</h2>
                    <p>Manage SCP Database Records</p>
                </div>
            </section>

            <!-- Success message displayed after CRUD operations -->
            <?php if (isset($_GET['success'])): ?>
                <p style="color: lightgreen; margin-bottom: 1rem;">✅ <?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif; ?>

            <!-- Table listing all SCP records with edit and delete actions -->
            <section>
                <table style="width:100%; border-collapse: collapse; color: var(--text-secondary);">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="text-align:left; padding: 0.75rem;">ID</th>
                            <th style="text-align:left; padding: 0.75rem;">Class</th>
                            <th style="text-align:left; padding: 0.75rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scps as $scp): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 0.75rem;"><?= htmlspecialchars($scp['scp_id']) ?></td>
                            <td style="padding: 0.75rem;"><?= htmlspecialchars($scp['object_class']) ?></td>
                            <td style="padding: 0.75rem;">
                                <!-- Edit link takes user to edit form -->
                                <a href="edit.php?id=<?= $scp['id'] ?>" style="color: var(--accent); margin-right: 1rem;">Edit</a>
                                <!-- Delete link with confirmation dialog -->
                                <a href="delete.php?id=<?= $scp['id'] ?>"
                                   style="color: #bf1616;"
                                   onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars($scp['scp_id']) ?>?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Add new SCP button -->
                <a href="create.php" class="btn" style="margin-bottom: 1rem; display: inline-block;">+ Add New SCP</a>
            </section>
        </article>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 SCP Foundation | Secure. Contain. Protect.</p>
        </div>
    </footer>
</body>
</html>