<?php
// Connexion à la base de données avec PDO
include('db.php');
// Récupération des données des centres d'intérêt
$query_interests = "SELECT title, description FROM interests";
$stmt_interests = $pdo->prepare($query_interests);
$stmt_interests->execute();
$interests = $stmt_interests->fetchAll(PDO::FETCH_ASSOC);

// Récupération des articles de blog avec la colonne 'likes' incluse
$query_blog = "SELECT id, title, content, created_at, likes FROM blog_posts ORDER BY created_at DESC";
$stmt_blog = $pdo->prepare($query_blog);
$stmt_blog->execute();
$blog_posts = $stmt_blog->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<body>
<main id="main">
<li><a href="login.php">Connexion</a></li>
    <section class="container py-5">
        <h1 class="text-center mb-4">My Blog</h1>
        <p class="text-center mb-5">Discover my interests, my inspirations and my technological explorations.</p>

        <!-- Section des intérêts -->
        <div class="row mb-5">
            <h2 class="text-center mb-4">My Interest</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($interests)) {
                    foreach ($interests as $interest) {
                        echo "<tr>
                                <td>{$interest['title']}</td>
                                <td>{$interest['description']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-center'>Aucun centre d'intérêt trouvé.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Section des articles de blog -->
        <div class="row">
            <h2 class="text-center mb-4">Blog Posts</h2>
            <?php
            if (!empty($blog_posts)) {
                foreach ($blog_posts as $post) {
                    // Vérifie que toutes les clés nécessaires existent
                    if (isset($post['id'], $post['title'], $post['content'], $post['created_at'], $post['likes'])) {
                        echo "<div class='col-md-4 mb-4'>
                                <div class='card h-100'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>" . htmlspecialchars($post['title']) . "</h5>
                                        <p class='card-text'>" . htmlspecialchars(substr($post['content'], 0, 100)) . "...</p>
                                        <p class='text-muted'>Published on: " . htmlspecialchars($post['created_at']) . "</p>
                                    </div>
                                    <div class='card-footer text-center'>
                                        <form method='POST' action='like.php'>
                                            <input type='hidden' name='post_id' value='" . htmlspecialchars($post['id']) . "'>
                                            <button type='submit' class='btn btn-outline-danger btn-sm'>
                                                <i class='bi bi-heart'></i> Like 
                                                <span class='like-count'>(" . htmlspecialchars($post['likes']) . ")</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                              </div>";
                    } else {
                        echo "<p class='text-center'>Error: Incomplete blog post data.</p>";
                    }
                }
            } else {
                echo "<p class='text-center'>No blog posts available.</p>";
            }
            ?>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
