<?php
include('db.php'); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Protéger contre les injections SQL

    // Supprimer l'avis de la base de données
    $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: testimonials.php?message=success"); // Redirection après suppression
        exit;
    } else {
        header("Location: testimonials.php?message=error"); // En cas d'erreur
        exit;
    }
} else {
    header("Location: testimonials.php"); // Accès direct non autorisé
    exit;
}
