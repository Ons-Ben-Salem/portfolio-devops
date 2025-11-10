<?php
// Connexion à la base de données avec PDO
include('db.php');

// Vérifier si l'ID du post est passé via le formulaire
if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
    // Récupérer l'ID du post
    $post_id = $_POST['post_id'];

    // Mettre à jour le nombre de likes
    try {
        // Récupérer le nombre actuel de likes
        $query = "SELECT likes FROM blog_posts WHERE id = :post_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();

        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            // Incrémenter le nombre de likes
            $new_likes = $post['likes'] + 1;

            // Mettre à jour la base de données avec le nouveau nombre de likes
            $update_query = "UPDATE blog_posts SET likes = :new_likes WHERE id = :post_id";
            $update_stmt = $pdo->prepare($update_query);
            $update_stmt->bindParam(':new_likes', $new_likes, PDO::PARAM_INT);
            $update_stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $update_stmt->execute();
        }

        // Rediriger l'utilisateur vers la page des articles de blog après avoir ajouté le like
        header('Location: blog.php'); 
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour des likes : " . $e->getMessage());
    }
} else {
    echo "Erreur : L'ID du post est manquant.";
}
?>
