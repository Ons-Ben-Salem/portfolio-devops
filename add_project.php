<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// Connexion à la base de données
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $titre = mysqli_real_escape_string($conn, $_POST['titre']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $categorie = mysqli_real_escape_string($conn, $_POST['categorie']);
    $lien_image = mysqli_real_escape_string($conn, $_POST['lien_image']);

    // Insérer les données dans la base
    $sql = "INSERT INTO projets (titre, description, categorie, lien_image) 
            VALUES ('$titre', '$description', '$categorie', '$lien_image')";

    if ($conn->query($sql) === TRUE) {
        echo "Projet ajouté avec succès.";
        header("Location: admin.php"); // Redirige vers la page admin
        exit;
    } else {
        echo "Erreur : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Projet</title>
</head>
<body>
    <h2>Ajouter un Projet</h2>
    <form action="add_project.php" method="POST">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="categorie">Catégorie :</label>
        <input type="text" id="categorie" name="categorie" required><br>

        <label for="lien_image">Lien de l'image :</label>
        <input type="text" id="lien_image" name="lien_image" required><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
