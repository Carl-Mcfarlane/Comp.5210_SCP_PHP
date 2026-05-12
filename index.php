<?php
// Connect to the database
require 'includes/db.php';

// Fetch all SCP records ordered by ID
$stmt = $pdo->query("SELECT * FROM scps ORDER BY id");
$scps = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SCP Foundation archive index page">
    <title>Home | SCP Foundation</title>
    <link rel="stylesheet" href="css/styles2.css">
    <style>
        /* SCP card grid layout */
        .scp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        /* Individual SCP card */
        .scp-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            text-decoration: none;
            color: var(--text-primary);
            transition: border-color 0.3s ease, transform 0.2s ease;
            display: block;
        }

        .scp-card:hover {
            border-color: var(--accent);
            transform: translateY(-3px);
        }

        .scp-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            border: none;
            padding: 0;
        }

        /* Object class colour badges */
        .scp-card .class-badge {
            display: inline-block;
            font-size: 0.8rem;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .badge-safe { background-color: #1a5c1a; color: #90ee90; }
        .badge-euclid { background-color: #5c4a1a; color: #ffd700; }
        .badge-keter { background-color: #5c1a1a; color: #ff6b6b; }
        .badge-thaumiel { background-color: #1a1a5c; color: #87ceeb; }

        /* Truncate description to 3 lines */
        .scp-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Page header with logo */
        .page-header {
            text-align: center;
            padding: 3rem 0 1rem;
        }

        .page-header img {
            width: min(70vw, 400px);
            height: auto;
            margin-bottom: 1rem;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <a class="brand" href="index.php" aria-label="SCP Foundation home">
                <img src="images/SCP_navbar_logo.png" alt="SCP Foundation Logo" width="225" height="70">
            </a>

            <!-- Hamburger toggle for mobile -->
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <label for="nav-toggle" class="nav-toggle-label" aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <nav id="primary-navigation" aria-label="Primary navigation">
                <ul>
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="admin/index.php">Admin Panel</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Page header with logo -->
        <div class="page-header">
            <img src="images/SCP_navbar_logo.png" alt="SCP Foundation Logo">
            <p>Secure. Contain. Protect.</p>
        </div>

        <!-- SCP card grid - dynamically generated from database -->
        <div class="container">
            <div class="scp-grid">
                <?php foreach ($scps as $scp): ?>
                <a href="scp.php?id=<?= $scp['id'] ?>" class="scp-card">
                    <h3><?= htmlspecialchars($scp['scp_id']) ?></h3>
                    <!-- Colour coded object class badge -->
                    <span class="class-badge badge-<?= strtolower(htmlspecialchars($scp['object_class'])) ?>">
                        <?= htmlspecialchars($scp['object_class']) ?>
                    </span>
                    <p><?= htmlspecialchars($scp['description']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 SCP Foundation | Secure. Contain. Protect.</p>
        </div>
    </footer>
</body>
</html>