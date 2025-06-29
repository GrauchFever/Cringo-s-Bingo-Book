<?php

    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "cringo_db";

    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Only allow access if user_id is 1 (admin)
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
        die("Access denied.");
    }
    
    // Handle user deletion (but not admin)
    if (isset($_GET['delete_user'])) {
        $delete_id = intval($_GET['delete_user']);
        if ($delete_id != 1) {
            $result = $conn->query("DELETE FROM accounts WHERE user_id = $delete_id");
            if ($result) {
                // Redirect to admin.html after deletion, same as products
                header("Location: admin.html");
                exit();
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        }
    }
    
    // Handle product deletion
    if (isset($_GET['delete_product'])) {
        $delete_id = intval($_GET['delete_product']);
        $result = $conn->query("DELETE FROM products WHERE product_id = $delete_id");
    
        if ($result) {
            header("Location: admin.html");
            exit();
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    }
    
    // Get all users
    $users = $conn->query("SELECT user_id, user_name, user_email FROM accounts");
    
    // Get all products
    $products = $conn->query("SELECT product_id, product_name, product_price FROM products");

    echo '<div class="container mt-5 bg-white p-5">';
    echo '<h1 class="mb-4">Admin Dashboard</h1>';

    echo '<h3>All Users</h3>';
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr></thead>';
    echo '<tbody>';
    while ($row = $users->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['user_id'] . '</td>';
        echo '<td>' . htmlspecialchars($row['user_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['user_email']) . '</td>';
        echo '<td>';
        if ($row['user_id'] != 1) {
            echo '<a href="admin.php?delete_user=' . $row['user_id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Delete this user?\');">Delete</a>';
        } else {
            echo 'Admin';
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    echo '<h3>All Products</h3>';
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr><th>ID</th><th>Name</th><th>Price (ZAR)</th><th>Action</th></tr></thead>';
    echo '<tbody>';
    while ($row = $products->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['product_id'] . '</td>';
        echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
        echo '<td>R' . number_format($row['product_price'], 2) . '</td>';
        echo '<td>';
        echo '<a href="admin.php?delete_product=' . $row['product_id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Delete this product?\');">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    echo '</div>'; // container

?>