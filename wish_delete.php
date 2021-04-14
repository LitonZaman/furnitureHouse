<?php

include 'includes/session.php';

$conn = $pdo->open();
$id = $_GET['id'];

if (isset($_SESSION['user'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM wishlist WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $_SESSION['success'] = 'Product deleted from wishlist';
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

$pdo->close();
header('location: wish_view.php');
?>