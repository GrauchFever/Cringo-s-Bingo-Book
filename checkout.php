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

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
        exit;
    }

    $ids = implode(",", array_map('intval', array_keys($_SESSION['cart'])));
    $sql = "SELECT * FROM products WHERE product_id IN ($ids)";
    $result = mysqli_query($conn, $sql);

    echo "<div class='container mt-4'>";
    echo "<h4>Checkout Summary</h4>";
    echo "<table class='table'>";
    echo "<thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>";

    $total = 0;
    while ($row = mysqli_fetch_assoc($result)) 
    {
        $id = $row['product_id'];
        $quantity = $_SESSION['cart'][$id];
        $price = $row['product_price'];
        $subtotal = $price * $quantity;
        $total += $subtotal;

        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>$quantity</td>";
        echo "<td>R" . number_format($price, 2) . "</td>";
        echo "<td>R" . number_format($subtotal, 2) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "<h5>Total: R" . number_format($total, 2) . "</h5>";

    echo "<button class='btn btn-success mt-3' onclick='confirmOrder()'>Confirm Order</button>";
    echo "</div>";

    mysqli_close($conn);
?>