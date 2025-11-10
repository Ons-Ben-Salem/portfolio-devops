

<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il est admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// Connexion à la base de données
include('db.php');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Gestion de la suppression
if (isset($_GET["delete_id"])) {
    $delete_id = (int) $_GET["delete_id"];
    $sql = "DELETE FROM projets WHERE id = $delete_id";
    $conn->query($sql);
    header("Location: admin.php");
    exit;
}

// Récupérer les projets
$sql = "SELECT * FROM projets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Projets</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestion des Projets</h2>
        <a href="add_project.php" class="btn btn-success mb-3">Add project</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><img src="<?= $row['lien_image'] ?>" alt="Image" style="width: 50px; height: 50px;"></td>
                            <td><?= htmlspecialchars($row['titre']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['categorie']) ?></td>
                            <td>
                                <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">Aucun projet trouvé</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-danger mt-3">Déconnexion</a>
    </div>
</body>
</html>
