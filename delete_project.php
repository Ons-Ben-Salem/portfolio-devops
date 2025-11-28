<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    $id = $_POST['id'];
    $sql = "DELETE FROM projects WHERE id = $id";
    $conn->query($sql);
    header('Location: projets.php');
}
?>
