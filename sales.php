<?php

include 'includes/session.php';

if (isset($_GET['data'])) {
    $_POST = json_decode(base64_decode($_GET['data']));
    $_POST = (array) $_POST;
}

if (isset($_POST['pay'])) {
    $date = date('Y-m-d');
    $conn = $pdo->open();
    try {
        $stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date,firstname,lastname,contact,address) VALUES (:user_id, :pay_id, :sales_date,:firstname,:lastname,:contact,:address)");
        $stmt->execute(['user_id' => $user['id'], 'pay_id' => $_POST['option'], 'sales_date' => $date, 'firstname' => $_POST['firstname'], 'lastname' => $_POST['lastname'], 'contact' => $_POST['contact'], 'address' => $_POST['address']]);
        $salesid = $conn->lastInsertId();

        try {
            $stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
            $stmt->execute(['user_id' => $user['id']]);

            foreach ($stmt as $row) {
                $stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
                $stmt->execute(['sales_id' => $salesid, 'product_id' => $row['product_id'], 'quantity' => $row['quantity']]);
            }

            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
            $stmt->execute(['user_id' => $user['id']]);

            $_SESSION['success'] = 'Transaction successful. Thank you.';
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    $pdo->close();
}

header('location: profile.php');
?>