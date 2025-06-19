<?php
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
        $productId = intval($_POST['product_id']);
    
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }
    
    // Redirect back to the cart page (e.g., cart.php or wherever it loads the sidebar)
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
?>