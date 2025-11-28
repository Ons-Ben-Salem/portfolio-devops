<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php'); // Redirection vers la page de login si non connecté
    exit;
}

include('db.php');

$message = "";

// Handle form submission for adding, editing, or deleting content
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $type = $_POST['type'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        if ($type === 'interest') {
            // Add new interest
            $query = "INSERT INTO interests (title, description) VALUES (:title, :description)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':title' => $title, ':description' => $description]);
            $message = "Interest added successfully!";
        } elseif ($type === 'blog') {
            // Add new blog post
            $content = $_POST['content'];
            $query = "INSERT INTO blog_posts (title, content, created_at) VALUES (:title, :content, NOW())";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':title' => $title, ':content' => $content]);
            $message = "Blog post added successfully!";
        }
    } elseif ($action === 'modify') {
        $type = $_POST['type'];
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        if ($type === 'interest') {
            // Modify existing interest
            $query = "UPDATE interests SET title = :title, description = :description WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id, ':title' => $title, ':description' => $description]);
            $message = "Interest updated successfully!";
        } elseif ($type === 'blog') {
            // Modify existing blog post
            $content = $_POST['content'];
            $query = "UPDATE blog_posts SET title = :title, content = :content WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id, ':title' => $title, ':content' => $content]);
            $message = "Blog post updated successfully!";
        }
    } elseif ($action === 'delete') {
        $type = $_POST['type'];
        $id = $_POST['id'];

        if ($type === 'interest') {
            // Delete interest
            $query = "DELETE FROM interests WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            $message = "Interest deleted successfully!";
        } elseif ($type === 'blog') {
            // Delete blog post
            $query = "DELETE FROM blog_posts WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            $message = "Blog post deleted successfully!";
        }
    }
}

// Fetch all interests and blog posts
$interests = $pdo->query("SELECT * FROM interests")->fetchAll(PDO::FETCH_ASSOC);
$blog_posts = $pdo->query("SELECT * FROM blog_posts")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center my-4">Manage Blog Posts and Interests</h2>

        <?php if ($message): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Add new interest or blog post -->
        <h3>Add New Content</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="type">Select type</label>
                <select name="type" id="type" class="form-control">
                    <option value="interest">Interest</option>
                    <option value="blog">Blog Post</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group" id="content-group" style="display:none;">
                <label for="content">Content (for blog posts)</label>
                <textarea name="content" id="content" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" name="action" value="add" class="btn btn-primary mt-3">Add Content</button>
        </form>

        <!-- Modify or Delete existing content -->
        <h3 class="mt-5">Modify or Delete Content</h3>

        <h4>Interests</h4>
        <?php foreach ($interests as $interest): ?>
            <div>
                <form action="" method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $interest['id'] ?>">
                    <input type="hidden" name="type" value="interest">
                    <button type="submit" name="action" value="modify" class="btn btn-warning">Modify</button>
                    <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                </form>
                <p><strong><?= htmlspecialchars($interest['title']) ?></strong> - <?= htmlspecialchars($interest['description']) ?></p>
            </div>
        <?php endforeach; ?>

        <h4>Blog Posts</h4>
        <?php foreach ($blog_posts as $post): ?>
            <div>
                <form action="" method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                    <input type="hidden" name="type" value="blog">
                    <button type="submit" name="action" value="modify" class="btn btn-warning">Modify</button>
                    <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                </form>
                <p><strong><?= htmlspecialchars($post['title']) ?></strong> - <?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <a href="logout.php" class="btn btn-danger mt-3">Déconnexion</a>
</body>
</html>
