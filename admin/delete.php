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

// Delete the matching SCP record from the database
$stmt = $pdo->prepare("DELETE FROM scps WHERE id = ?");
$stmt->execute([$id]);

// Redirect back to admin panel with success message
header("Location: index.php?success=SCP record deleted successfully!");
exit;
?>