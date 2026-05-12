<?php
// Connect to the database
require '../includes/db.php';

// Get the SCP ID from the URL parameter
$id = $_GET['id'] ?? null;

// Redirect to admin panel if no ID provided
if (!$id) {
    header("Location: index.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the existing SCP record in the database
    $stmt = $pdo->prepare("UPDATE scps SET scp_id=?, object_class=?, image=?, image_alt=?, description=?, containment=? WHERE id=?");
    $stmt->execute([
        $_POST['scp_id'],
        $_POST['object_class'],
        $_POST['image'],
        $_POST['image_alt'],
        $_POST['description'],
        $_POST['containment'],
        $id
    ]);
    // Redirect back to admin panel with success message
    header("Location: index.php?success=SCP record updated successfully!");
    exit;
}

// Fetch the existing SCP record to pre-fill the form
$stmt = $pdo->prepare("SELECT * FROM scps WHERE id = ?");
$stmt->execute([$id]);
$scp = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect if SCP not found
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
    <title>Edit <?= htmlspecialchars($scp['scp_id']) ?> | SCP Foundation</title>
    <link rel="stylesheet" href="../css/styles2.css">
    <style>
        /* Form group spacing */
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        /* Style all form inputs consistently */
        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            background-color: #111;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 0.95rem;
        }
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        /* Highlight focused inputs */
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--accent);
        }
        /* Reset button width so it doesn't stretch full width */
        button {
            width: auto;
        }
    </style>
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
                    <li><a href="index.php">Admin Panel</a></li>
                    <li><a href="create.php">Add New SCP</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <article>
            <section class="scp-header">
                <div>
                    <h2>Edit <?= htmlspecialchars($scp['scp_id']) ?></h2>
                    <p>Update this SCP database record</p>
                </div>
            </section>

            <!-- Edit form - pre-filled with existing database values -->
            <section>
                <form method="POST">
                    <div class="form-group">
                        <label for="scp_id">SCP ID</label>
                        <input type="text" id="scp_id" name="scp_id"
                               value="<?= htmlspecialchars($scp['scp_id']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="object_class">Object Class</label>
                        <!-- Selected option matches current database value -->
                        <select id="object_class" name="object_class" required>
                            <option value="">Select class...</option>
                            <option value="Safe" <?= $scp['object_class'] === 'Safe' ? 'selected' : '' ?>>Safe</option>
                            <option value="Euclid" <?= $scp['object_class'] === 'Euclid' ? 'selected' : '' ?>>Euclid</option>
                            <option value="Keter" <?= $scp['object_class'] === 'Keter' ? 'selected' : '' ?>>Keter</option>
                            <option value="Thaumiel" <?= $scp['object_class'] === 'Thaumiel' ? 'selected' : '' ?>>Thaumiel</option>
                        </select>
                    </div>

                    <!-- Image fields are optional -->
                    <div class="form-group">
                        <label for="image">Image Path (optional)</label>
                        <input type="text" id="image" name="image"
                               value="<?= htmlspecialchars($scp['image']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="image_alt">Image Alt Text (optional)</label>
                        <input type="text" id="image_alt" name="image_alt"
                               value="<?= htmlspecialchars($scp['image_alt']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required><?= htmlspecialchars($scp['description']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="containment">Containment Procedures</label>
                        <textarea id="containment" name="containment" required><?= htmlspecialchars($scp['containment']) ?></textarea>
                    </div>

                    <button type="submit" class="btn">Save Changes</button>
                    <a href="index.php" class="btn" style="margin-left: 1rem; text-decoration: none;">Cancel</a>
                </form>
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