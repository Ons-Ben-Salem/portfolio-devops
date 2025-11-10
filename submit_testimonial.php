<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $title = $conn->real_escape_string($_POST['title']);
    $message = $conn->real_escape_string($_POST['message']);
    $rating = intval($_POST['rating']);

    $sql = "INSERT INTO testimonials (name, title, message, rating) VALUES ('$name', '$title', '$message', $rating)";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: testimonials.php?success=1");
        exit;
    } else {
        echo "Erreur : " . $conn->error;
    }
}
?>
