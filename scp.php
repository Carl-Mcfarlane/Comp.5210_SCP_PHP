<?php
// Connect to the database
require 'includes/db.php';

// Get the SCP ID from the URL parameter
$id = $_GET['id'] ?? null;

// Redirect to home if no ID provided
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch the SCP record matching the ID
$stmt = $pdo->prepare("SELECT * FROM scps WHERE id = ?");
$stmt->execute([$id]);
$scp = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect to home if SCP not found
if (!$scp) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($scp['scp_id']) ?> containment file - SCP Foundation database">
    <title><?= htmlspecialchars($scp['scp_id']) ?> | SCP Foundation</title>
    <link rel="stylesheet" href="css/styles2.css">
</head>
<!-- always-hamburger class keeps nav collapsed on desktop due to many entries -->
<body class="always-hamburger">
    <header>
        <div class="container">
            <a class="brand" href="index.php" aria-label="SCP Foundation home">
                <img src="images/SCP_navbar_logo.png" alt="SCP Foundation Logo" width="225" height="70">
            </a>

            <!-- Hamburger toggle -->
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <label for="nav-toggle" class="nav-toggle-label" aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <nav id="primary-navigation" aria-label="Primary navigation">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php
                    // Dynamically build nav links from database
                    $navScps = $pdo->query("SELECT id, scp_id FROM scps ORDER BY id");
                    foreach ($navScps as $navScp):
                    ?>
                    <li>
                        <!-- Highlight the currently active SCP -->
                        <a href="scp.php?id=<?= $navScp['id'] ?>"
                           <?= $navScp['id'] == $id ? 'class="active" aria-current="page"' : '' ?>>
                            <?= htmlspecialchars($navScp['scp_id']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <li><a href="admin/index.php">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <article>
            <!-- SCP header with ID, class and image if available -->
            <section class="scp-header">
                <div>
                    <h2>Item #: <?= htmlspecialchars($scp['scp_id']) ?></h2>
                    <p><strong>Object Class:</strong> <?= htmlspecialchars($scp['object_class']) ?></p>
                </div>
                <?php if ($scp['image']): ?>
                <!-- Only render image if one exists in the database -->
                <img src="<?= htmlspecialchars($scp['image']) ?>"
                     alt="<?= htmlspecialchars($scp['image_alt']) ?>">
                <?php endif; ?>
            </section>

            <section>
                <h3>Special Containment Procedures</h3>
                <p><?= htmlspecialchars($scp['containment']) ?></p>
            </section>

            <section>
                <h3>Description</h3>
                <p><?= htmlspecialchars($scp['description']) ?></p>
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