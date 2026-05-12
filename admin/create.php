<?php
// Connect to the database
require '../includes/db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert new SCP record into database
    $stmt = $pdo->prepare("INSERT INTO scps (scp_id, object_class, image, image_alt, description, containment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['scp_id'],
        $_POST['object_class'],
        $_POST['image'],
        $_POST['image_alt'],
        $_POST['description'],
        $_POST['containment']
    ]);
    // Redirect back to admin panel with success message
    header("Location: index.php?success=SCP record created successfully!");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add SCP | SCP Foundation</title>
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
                    <li><a href="create.php" class="active">Add New SCP</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <article>
            <section class="scp-header">
                <div>
                    <h2>Add New SCP</h2>
                    <p>Create a new SCP database record</p>
                </div>
            </section>

            <!-- Create form - submits via POST -->
            <section>
                <form method="POST">
                    <div class="form-group">
                        <label for="scp_id">SCP ID</label>
                        <input type="text" id="scp_id" name="scp_id" placeholder="e.g. SCP-012" required>
                    </div>

                    <div class="form-group">
                        <label for="object_class">Object Class</label>
                        <select id="object_class" name="object_class" required>
                            <option value="">Select class...</option>
                            <option value="Safe">Safe</option>
                            <option value="Euclid">Euclid</option>
                            <option value="Keter">Keter</option>
                            <option value="Thaumiel">Thaumiel</option>
                        </select>
                    </div>

                    <!-- Image fields are optional -->
                    <div class="form-group">
                        <label for="image">Image Path (optional)</label>
                        <input type="text" id="image" name="image" placeholder="e.g. images/scp-012.jpg">
                    </div>

                    <div class="form-group">
                        <label for="image_alt">Image Alt Text (optional)</label>
                        <input type="text" id="image_alt" name="image_alt" placeholder="e.g. SCP-012 containment chamber">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="containment">Containment Procedures</label>
                        <textarea id="containment" name="containment" required></textarea>
                    </div>

                    <button type="submit" class="btn">Add SCP Record</button>
                    <a href="index.php" class="btn" style="margin-left: 1rem;">Cancel</a>
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