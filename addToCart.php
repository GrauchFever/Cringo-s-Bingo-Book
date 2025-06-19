<?php
    session_start();
    header('Content-Type: application/json');

    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
        exit;
    }

    $product_id = (int) $_POST['id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1; // Add first time
    } else {
        $_SESSION['cart'][$product_id] += 1; // Increment quantity
    }
    
    echo json_encode(['success' => true, 'cartCount' => array_sum($_SESSION['cart'])]);
?>