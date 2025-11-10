<?php
session_start();

// Vérification que l'utilisateur est bien administrateur
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php'); // Redirection vers la page de connexion si l'utilisateur n'est pas admin
    exit;
}

// Configuration de la base de données
include('db.php');

// Récupérer tous les messages de la base de données
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages soumis</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1 class="mt-5">Messages soumis</h1>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo $message['id']; ?></td>
                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                        <td><?php echo htmlspecialchars($message['subject']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                        <td><?php echo $message['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <a href="logout.php" class="btn btn-danger mt-3">Déconnexion</a>
</body>
</html>
