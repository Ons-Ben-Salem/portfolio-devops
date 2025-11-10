<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php'); // Redirection vers la page de login si non connecté
    exit;
}

// Si l'utilisateur choisit une page, redirigez-le
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $choix = $_POST['choix'];
    if ($choix === 'message') {
        header('Location: admin.php');
    } elseif ($choix === 'admin') {
        header('Location: message.php');
    } elseif ($choix === 'manage') {
        header('Location: manage_blog.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix - Portfolio</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            font-size: 16px;
            padding: 12px;
            border-radius: 5px;
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-info {
            background-color: #17a2b8;
        }
        .btn-warning {
            background-color:rgb(255, 160, 7);
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center">Choisissez votre destination</h2>
            <form action="" method="POST" class="mt-4">
                <button type="submit" name="choix" value="message" class="btn btn-success w-100 mb-3 btn-custom">Projets page</button>
                <button type="submit" name="choix" value="admin" class="btn btn-info w-100 mb-3 btn-custom">Messages page</button>
                <button type="submit" name="choix" value="manage" class="btn btn-warning w-100 mb-3 btn-custom">Manage Blog</button> 
            </form>
        </div>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
